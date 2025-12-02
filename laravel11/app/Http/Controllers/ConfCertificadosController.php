<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\certificado;
use App\Models\inscripcion;
use App\Models\persona;
use App\Models\evento;
use App\Models\certificacion;
use App\Models\asistencia;
use App\Models\certiasiste;
use App\Models\certinormal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class ConfCertificadosController extends Controller
{
    public function index() {}

    public function ConCertificado()
    {
        $eventos = Evento::select('evento.idevento', 'evento.eventnom', 'evento.fecini')
            ->where('evento.idestadoeve', 2) // Estado finalizado
            ->whereRaw('DATE_ADD(DATE_ADD(evento.fecini, INTERVAL TIME(evento.fechculm) HOUR_SECOND), INTERVAL 10 MINUTE) <= NOW()')
            ->where('evento.fecini', '<=', now()->toDateString())
            ->orderBy('evento.fecini', 'desc')
            ->get();
        $inscripciones = Inscripcion::with(['persona', 'escuela', 'subevento.evento'])->get();
        $personas = Persona::all();
        $certificados = Certificado::with(['evento', 'estadoCertificado', 'cargo', 'cargo.tipoCertificado'])->get();
        return view('Vistas.ConCertificado', compact('eventos', 'inscripciones', 'personas', 'certificados'));
    }

    public function filterByEventos(Request $request)
    {
        $eventId = $request->input('event_id');
        $searchTerm = trim($request->input('searchTerm'));

        $certificados = Certificado::with([
            'evento',
            'estadoCertificado',
            'cargo.tipoCertificado',
            'certiasiste.asistencia.inscripcion.persona',
            'certiasiste.asistencia.inscripcion.escuela',
            'certinormal.persona'
        ])
            ->where('idevento', $eventId)
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereHas('certiasiste.asistencia.inscripcion.persona', function ($subQ) use ($searchTerm) {
                        $subQ->where('dni', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('nombre', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('apell', 'LIKE', "%{$searchTerm}%");
                    })
                        ->orWhereHas('certinormal.persona', function ($subQ) use ($searchTerm) {
                            $subQ->where('dni', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('nombre', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('apell', 'LIKE', "%{$searchTerm}%");
                        });
                });
            })
            ->orderBy('idCertif', 'asc')
            ->get();

        $certificados->transform(function ($cert) {
            try {
                $cert->porcentaje_calculado = 0;
                if (
                    isset($cert->certiasiste) &&
                    isset($cert->certiasiste->asistencia) &&
                    isset($cert->certiasiste->asistencia->inscripcion)
                ) {

                    $idpersona = $cert->certiasiste->asistencia->inscripcion->idpersona;
                    $idevento = $cert->idevento;

                    $inscripciones = DB::table('inscripcion as i')
                        ->join('subevent as s', 'i.idsubevent', '=', 's.idsubevent')
                        ->where('i.idpersona', $idpersona)
                        ->where('s.idevento', $idevento)
                        ->pluck('i.idincrip');

                    if ($inscripciones->count() > 0) {
                        $asistencias = DB::table('asistencia')
                            ->whereIn('idincrip', $inscripciones)
                            ->get();

                        $totalSubeventos = $asistencias->count();

                        $asistenciasPresentes = $asistencias->where('porceasis', '>', 0)->count();

                        if ($totalSubeventos > 0) {
                            $cert->porcentaje_calculado = round(($asistenciasPresentes / $totalSubeventos) * 100, 2);
                        }
                    }
                } else if (isset($cert->certinormal)) {
                    $cert->porcentaje_calculado = 100;
                }
            } catch (\Exception $e) {
                Log::error('Error calculando porcentaje para certificado ' . $cert->idCertif . ': ' . $e->getMessage());
                $cert->porcentaje_calculado = 0;
            }

            try {
                if ($cert->pdff) {
                    if (str_contains($cert->pdff, 'http://') || str_contains($cert->pdff, 'https://')) {
                        $cert->pdf_url = $cert->pdff;
                    } else {
                        $cert->pdf_url = asset($cert->pdff);
                    }
                } else {
                    $cert->pdf_url = null;
                }
            } catch (\Exception $e) {
                Log::error('Error procesando PDF: ' . $e->getMessage());
                $cert->pdf_url = null;
            }

            return $cert;
        });

        return response()->json($certificados);
    }


    public function buscarPorDni(Request $request)
    {
        $request->validate([
            'dniParticipante' => 'required|string|max:8|min:1'
        ]);
        $dni = $request->dniParticipante;
        try {
            $certificados = DB::select("
                SELECT DISTINCT
                    c.idCertif,
                    COALESCE(e.eventnom, 'Sin evento asignado') as evento,
                    c.nro as numero_certificado,
                    p.dni,
                    CONCAT(p.nombre, ' ', p.apell) as nombres_completos,
                    p.tele as telefono,
                    p.email,
                    ec.nomestadc as estado,
                    c.pdff as pdf,
                    c.fecentrega as fecha_entrega,
                    tc.cargo as tipo_certificado
                FROM personas p
                -- CERTIFICADOS NORMALES
                LEFT JOIN certinormal cn ON cn.idpersona = p.idpersona
                LEFT JOIN certificado c1 ON c1.idCertif = cn.idCertif
                -- CERTIFICADOS POR ASISTENCIA
                LEFT JOIN inscripcion i ON i.idpersona = p.idpersona
                LEFT JOIN asistencia a ON a.idincrip = i.idincrip
                LEFT JOIN certiasiste ca ON ca.idasistnc = a.idasistnc
                LEFT JOIN certificado c2 ON c2.idCertif = ca.idCertif
                -- Resultado final
                LEFT JOIN certificado c ON c.idCertif IN (c1.idCertif, c2.idCertif)
                LEFT JOIN estadocerti ec ON c.idestcer = ec.idestcer
                LEFT JOIN cargo tc ON c.idcargo = tc.idcargo
                LEFT JOIN evento e ON c.idevento = e.idevento
                WHERE p.dni LIKE ?
                  AND c.idCertif IS NOT NULL
                ORDER BY c.fecentrega DESC
            ", [$dni . '%']);

            return response()->json([
                'success' => true,
                'data' => $certificados,
                'total' => count($certificados)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar certificados: ' . $e->getMessage()
            ], 500);
        }
    }


    public function actualizarNumeroCertificado(Request $request)
    {
        try {
            $validated = $request->validate([
                'idCertif' => 'required|integer',
                'nro' => 'required|string|max:100'
            ]);

            $certificado = Certificado::find($request->idCertif);

            if (!$certificado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certificado no encontrado'
                ], 404);
            }

            $existe = Certificado::where('nro', $request->nro)
                ->where('idCertif', '!=', $request->idCertif)
                ->exists();

            if ($existe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este número de certificado ya está en uso'
                ], 400);
            }

            $certificado->nro = $request->nro;
            $certificado->save();

            return response()->json([
                'success' => true,
                'message' => 'Número de certificado actualizado correctamente',
                'data' => $certificado
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function numcerocerti(Request $request)
    {
        try {
            $request->validate([
                'idevento' => 'required|integer|exists:evento,idevento',
                'prefijo'  => 'required|string|max:10'
            ], [
                'idevento.required' => 'Debe seleccionar un evento.',
                'idevento.exists'   => 'El evento seleccionado no existe.',
                'prefijo.required'  => 'Debe ingresar un prefijo.',
                'prefijo.max'       => 'El prefijo no puede tener más de 10 caracteres.'
            ]);

            $idEvento = $request->input('idevento');
            $prefijo  = strtoupper(trim($request->input('prefijo')));

            $certificadosSinNumero = DB::table('certificado')
                ->where('idevento', $idEvento)
                ->where(function ($q) {
                    $q->whereNull('nro')
                        ->orWhere('nro', '')
                        ->orWhere('nro', '0');
                })->count();

            if ($certificadosSinNumero === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay certificados sin número para este evento.'
                ]);
            }

            if (Auth::check()) {
                DB::statement("SET @usuario_app = ?", [Auth::user()->nomusu]);
            }

            $result = DB::select('CALL GenerarNumeroCertificado(?, ?)', [$idEvento, $prefijo]);
            $message = $result[0]->Resultado ?? 'Certificados generados correctamente.';

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            Log::error('Error en SP: ' . $ex->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error en la base de datos: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $e) {
            Log::error('Error general: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    /** Generar tokens únicos para certificados */
    public function generarTokens(Request $request)
    {
        $request->validate([
            'idevento' => 'required|exists:evento,idevento'
        ]);
        try {
            DB::beginTransaction();

            $idevento = $request->idevento;
            $certificadosSinToken = DB::table('certificado')
                ->where('idevento', $idevento)
                ->where(function ($q) {
                    $q->whereNull('tokenn')
                        ->orWhere('tokenn', '')
                        ->orWhere('tokenn', 'like', 'cert_%')
                        ->orWhere('tokenn', 'like', 'temp_%');
                })
                ->count();

            if ($certificadosSinToken === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay certificados sin token para este evento.'
                ]);
            }

            $result = DB::select('CALL GenerarTokensCertificados(?)', [$idevento]);

            $message = $result[0]->Resultado ?? 'Tokens generados correctamente.';

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message,
                'total' => $certificadosSinToken
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al generar tokens: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al generar tokens: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generarTokenIndividual($idCertif)
    {
        $maxIntentos = 10;
        $intentos = 0;

        do {
            $token = sprintf(
                '%s-%s-%s-%s-%s',
                bin2hex(random_bytes(4)),
                bin2hex(random_bytes(2)),
                bin2hex(random_bytes(2)),
                bin2hex(random_bytes(2)),
                bin2hex(random_bytes(6))
            );

            $existe = Certificado::where('tokenn', $token)->exists();
            $intentos++;
        } while ($existe && $intentos < $maxIntentos);

        if (!$existe) {
            Certificado::where('idCertif', $idCertif)->update(['tokenn' => $token]);
            return $token;
        }

        throw new \Exception('No se pudo generar un token único después de ' . $maxIntentos . ' intentos.');
    }


    public function generarTokenAjax(Request $request, $idCertif)
    {
        try {
            $token = $request->input('tokenn');

            if ($token) {
                if (Certificado::where('tokenn', $token)->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'El token ya existe. Por favor, ingrese uno diferente.'
                    ]);
                }
                Certificado::where('idCertif', $idCertif)->update(['tokenn' => $token]);
            } else {
                $token = $this->generarTokenIndividual($idCertif);
            }

            return response()->json([
                'success' => true,
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    // Generar DESCRIPCION automatica

    public function obtenerDatosEvento(Request $request)
    {
        try {
            $idevento = $request->input('idevento');

            if (!$idevento || $idevento <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de evento inválido'
                ], 400);
            }

            $evento = DB::table('evento as e')
                ->join('tema as t', 'e.idtema', '=', 't.idtema')
                ->join('tipoevento as tp', 'e.idTipoeven', '=', 'tp.idTipoeven')

                ->leftJoin('certificado as c', 'c.idevento', '=', 'e.idevento')

                ->where('e.idevento', $idevento)
                ->select(
                    't.tema',
                    'tp.nomeven as nombre_evento',
                    'e.fecini',
                    DB::raw('DAY(e.fecini) as dia'),
                    DB::raw('MONTH(e.fecini) as mes'),
                    DB::raw('YEAR(e.fecini) as anio')
                )
                ->first();

            if (!$evento) {
                return response()->json([
                    'success' => false,
                    'message' => 'Evento no encontrado'
                ], 404);
            }

            $meses = [
                1 => 'enero',
                2 => 'febrero',
                3 => 'marzo',
                4 => 'abril',
                5 => 'mayo',
                6 => 'junio',
                7 => 'julio',
                8 => 'agosto',
                9 => 'septiembre',
                10 => 'octubre',
                11 => 'noviembre',
                12 => 'diciembre'
            ];

            $fechaFormateada = "{$evento->dia} de {$meses[$evento->mes]} del {$evento->anio}";

            return response()->json([
                'success' => true,
                'evento' => [
                    'tema' => $evento->tema,
                    'nombre_evento' => $evento->nombre_evento,
                    'fecha_formateada' => $fechaFormateada
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener datos: ' . $e->getMessage()
            ], 500);
        }
    }


    /* Guardar folio, registro, cuaderno, tiempo y DESCRIPCIÓN */
    public function guardarFolio(Request $request)
    {
        $request->validate([
            'cuaderno' => 'required|string|max:45',
            'tiempoCapacitacion' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'modo' => 'required|in:auto,manual',
            'idevento' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            $cuaderno = trim($request->input('cuaderno'));
            $tiempoCapacitacion = $request->input('tiempoCapacitacion');
            $descripcion = $request->input('descripcion');
            $modo = $request->input('modo');
            $idevento = $request->input('idevento');

            if ($modo === 'auto') {

                $LIMITE = 32;

                $certificadosSinAsignar = DB::table('certificado')
                    ->select('idCertif')
                    ->where('idevento', $idevento)
                    ->where(function ($query) {
                        $query->where('foli', '=', 0)
                            ->orWhereNull('foli')
                            ->orWhere('numregis', '=', 0)
                            ->orWhereNull('numregis');
                    })
                    ->orderBy('idCertif', 'asc')
                    ->get();

                if ($certificadosSinAsignar->isEmpty()) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'No hay certificados pendientes de asignar para este evento'
                    ], 400);
                }
                $ultimoDelCuaderno = DB::table('certificado')
                    ->where('cuader', $cuaderno)
                    ->whereNotNull('foli')
                    ->where('foli', '>', 0)
                    ->whereNotNull('numregis')
                    ->where('numregis', '>', 0)
                    ->orderBy('foli', 'desc')
                    ->orderBy('numregis', 'desc')
                    ->first();

                if ($ultimoDelCuaderno) {
                    $folioActual = intval($ultimoDelCuaderno->foli);
                    $registroActual = intval($ultimoDelCuaderno->numregis);
                } else {
                    $folioActual = 1;
                    $registroActual = 0;
                }

                $actualizados = 0;

                foreach ($certificadosSinAsignar as $certificado) {
                    if ($registroActual >= $LIMITE) {
                        $folioActual++;
                        $registroActual = 0;
                    }

                    $registroActual++;

                    DB::table('certificado')
                        ->where('idCertif', $certificado->idCertif)
                        ->update([
                            'cuader' => $cuaderno,
                            'foli' => $folioActual,
                            'numregis' => $registroActual,
                            'tiempocapa' => $tiempoCapacitacion,
                            'descr' => $descripcion
                        ]);

                    $actualizados++;
                }

                $mensaje = "Se asignaron automáticamente {$actualizados} certificados. Cuaderno: {$cuaderno}, Folio: {$folioActual}, Último registro: {$registroActual}";
            } else {
                $request->validate([
                    'folio' => 'required|integer|min:1',
                    'registroDesde' => 'required|integer|min:1',
                    'registroHasta' => 'required|integer|min:1'
                ]);

                $folio = $request->input('folio');
                $registroDesde = $request->input('registroDesde');
                $registroHasta = $request->input('registroHasta');

                if ($registroDesde > $registroHasta) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'El rango de registros es inválido'
                    ], 400);
                }

                $cantidad = $registroHasta - $registroDesde + 1;

                $certificados = DB::table('certificado')
                    ->select('idCertif')
                    ->where('idevento', $idevento)
                    ->where(function ($query) {
                        $query->where('foli', '=', 0)
                            ->orWhereNull('foli')
                            ->orWhere('numregis', '=', 0)
                            ->orWhereNull('numregis');
                    })
                    ->orderBy('idCertif', 'asc')
                    ->limit($cantidad)
                    ->get();

                if ($certificados->isEmpty()) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'No hay certificados disponibles para asignar'
                    ], 400);
                }

                $registroActual = $registroDesde;
                $actualizados = 0;

                foreach ($certificados as $certificado) {
                    DB::table('certificado')
                        ->where('idCertif', $certificado->idCertif)
                        ->update([
                            'cuader' => $cuaderno,
                            'foli' => $folio,
                            'numregis' => $registroActual,
                            'tiempocapa' => $tiempoCapacitacion,
                            'descr' => $descripcion
                        ]);

                    $registroActual++;
                    $actualizados++;
                }

                $mensaje = "{$actualizados} certificados actualizados en Cuaderno {$cuaderno}, Folio {$folio}";
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $mensaje
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }


    /*  Generar certificados normales con asignación automática de folio Y cuaderno
     */
    public function generarCertificadosNormales(Request $request)
    {
        $request->validate([
            'idevento' => 'required|integer|min:1',
            'idtipcerti' => 'required|integer|min:1',
            'tiempocapa' => 'required|string|max:100',
            'descr' => 'required|string',
            'personas' => 'required|array|min:1',
            'personas.*' => 'integer|exists:personas,idpersona'
        ]);

        DB::beginTransaction();

        try {
            $idevento = $request->input('idevento');
            $idcargo = $request->input('idtipcerti');
            $tiempocapa = $request->input('tiempocapa');
            $descripcion = $request->input('descr');
            $personas = $request->input('personas');

            $LIMITE_POR_FOLIO = 32;

            $ultimo = DB::table('certificado')
                ->whereNotNull('cuader')
                ->where('cuader', '!=', '')
                ->orderByRaw('CAST(cuader AS CHAR) DESC')
                ->orderByRaw('CAST(foli AS UNSIGNED) DESC')
                ->orderByRaw('CAST(numregis AS UNSIGNED) DESC')
                ->select('cuader', 'foli', 'numregis')
                ->first();

            if ($ultimo) {
                $cuadernoActual = $ultimo->cuader;
                $folioActual = (int)$ultimo->foli;
                $registroActual = (int)$ultimo->numregis;

                if ($registroActual >= $LIMITE_POR_FOLIO) {
                    $folioActual++;
                    $registroActual = 0;
                }
            } else {
                $cuadernoActual = "I";
                $folioActual = 1;
                $registroActual = 0;
            }

            $folioInicial = $folioActual;
            $registroInicial = $registroActual + 1;
            $totalCert = 0;

            foreach ($personas as $idpersona) {

                $registroActual++;

                if ($registroActual > $LIMITE_POR_FOLIO) {
                    $folioActual++;
                    $registroActual = 1;
                }

                $idCertif = DB::table('certificado')->insertGetId([
                    'nro' => '',
                    'idestcer' => 1,
                    'fecentrega' => null,
                    'cuader' => $cuadernoActual,
                    'foli' => $folioActual,
                    'numregis' => $registroActual,
                    'tokenn' => '',
                    'descr' => $descripcion,
                    'pdff' => '',
                    'tiempocapa' => $tiempocapa,
                    'idevento' => $idevento,
                    'idcargo' => $idcargo
                ]);

                DB::table('certinormal')->insert([
                    'idCertif' => $idCertif,
                    'idpersona' => $idpersona
                ]);

                $totalCert++;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Se generaron {$totalCert} certificado(s) correctamente.",
                'detalle' => [
                    'cuaderno' => $cuadernoActual,
                    'folio_inicial' => $folioInicial,
                    'folio_final' => $folioActual,
                    'registro_inicial' => $registroInicial,
                    'registro_final' => $registroActual
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al generar certificados: ' . $e->getMessage()
            ], 500);
        }
    }


    // CAMBIAR ESTADO POR EVENTO

    public function cambiarEstadoPorEvento(Request $request)
    {
        $request->validate([
            'idevento' => 'required|integer|min:1'
        ]);

        try {

            $idevento = $request->idevento;

            $certificados = DB::table('certificado')
                ->where('idevento', $idevento)
                ->where('idestcer', '<', 4)
                ->get();

            if ($certificados->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => "No hay certificados disponibles para cambiar de estado."
                ]);
            }

            foreach ($certificados as $cert) {
                $estadoActual = (int)$cert->idestcer;

                $nuevoEstado = $estadoActual < 3 ? $estadoActual + 1 : 3;

                DB::table('certificado')
                    ->where('idCertif', $cert->idCertif)
                    ->update(['idestcer' => $nuevoEstado]);
            }

            return response()->json([
                'success' => true,
                'message' => "Los estados se actualizaron correctamente."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Error: " . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Cambiar estado del certificado a "Entregado" y registrar fecha
     */
    public function cambiarEstado(Request $request)
    {
        $request->validate([
            'idCertif' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            $idCertif = $request->input('idCertif');

            $certificado = DB::table('certificado')
                ->where('idCertif', $idCertif)
                ->first();

            if (!$certificado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certificado no encontrado'
                ], 404);
            }

            if ($certificado->idestcer == 4) {
                return response()->json([
                    'success' => false,
                    'message' => 'El certificado ya fue entregado'
                ], 400);
            }

            DB::table('certificado')
                ->where('idCertif', $idCertif)
                ->update([
                    'idestcer' => 4,
                    'fecentrega' => now()
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Certificado marcado como entregado exitosamente',
                'fecha' => now()->format('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar estado: ' . $e->getMessage()
            ], 500);
        }
    }

    // Cambiar estado de evento a finalizado
    public function eventoFinalizado(Request $request)
    {
        try {
            $eventId = $request->input('event_id');
            $evento = Evento::find($eventId);

            if (!$evento) {
                return response()->json([
                    'success' => false,
                    'message' => 'Evento no encontrado'
                ], 404);
            }
            if ($evento->idestadoeve == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'El evento ya ha sido culminado anteriormente'
                ], 400);
            }

            $evento->idestadoeve = 1;
            $evento->save();

            return response()->json([
                'success' => true,
                'message' => 'Evento culminado exitosamente',
                'evento' => $evento->eventnom
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al culminar el evento'
            ], 500);
        }
    }


    // COMBO TIPOS DE CERTIFICADOS

    public function getTipos()
    {
        try {
            $tipos = DB::table('cargo as tc')
                ->join('tipocertificado as c', 'tc.idtipcert', '=', 'c.idtipcert')
                ->select('tc.idcargo', 'tc.cargo', 'c.tipocertifi')
                ->orderBy('tc.cargo')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $tipos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar tipos de certificado'
            ], 500);
        }
    }

    public function Mostrargenero()
    {
        try {
            $generos = DB::table('generos')
                ->select('idgenero', 'nomgen')
                ->orderBy('nomgen')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $generos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar géneros: ' . $e->getMessage()
            ], 500);
        }
    }

    public function GuardarPersona(Request $request)
    {
        try {

            $request->validate([
                'dni' => 'required|digits:8|unique:personas,dni',
                'nombre' => 'required|max:45',
                'apell' => 'required|max:45',
                'tele' => 'required|max:11',
                'email' => 'required|email|max:45|unique:personas,email',
                'direc' => 'required|max:45',
                'idgenero' => 'required|integer'
            ]);

            $id = DB::table('personas')->insertGetId([
                'dni' => $request->dni,
                'nombre' => $request->nombre,
                'apell' => $request->apell,
                'tele' => $request->tele,
                'email' => $request->email,
                'direc' => $request->direc,
                'idgenero' => $request->idgenero
            ]);

            return response()->json([
                'success' => true,
                'idpersona' => $id
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    // En tu controlador de Certificados
    public function subirDocumento(Request $request)
    {
        try {
            $certId = $request->certificado_id;
            $tipoSubida = $request->tipo_subida;
            $pdffValue = '';

            if ($tipoSubida === 'archivo') {
                $request->validate([
                    'pdf_file' => 'required|file|mimes:pdf|max:10240'
                ]);

                $file = $request->file('pdf_file');
                $year = date('Y');
                $month = date('m');

                $directory = "uploads/certificados/{$year}/{$month}";

                if (!file_exists(public_path($directory))) {
                    mkdir(public_path($directory), 0755, true);
                }

                $filename = "cert_{$certId}_" . time() . '.pdf';
                $file->move(public_path($directory), $filename);

                $pdffValue = "{$directory}/{$filename}";
            } else {
                $request->validate([
                    'gdrive_url' => 'required|url'
                ]);

                $pdffValue = $request->gdrive_url;
            }

            DB::table('certificado')
                ->where('idCertif', $certId)
                ->update(['pdff' => $pdffValue]);

            return response()->json([
                'success' => true,
                'message' => 'Documento guardado correctamente',
                'pdff' => $pdffValue
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
