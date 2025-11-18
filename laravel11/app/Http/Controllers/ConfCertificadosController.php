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
        $inscripciones = Inscripcion::with(['persona', 'escuela', 'evento'])->get();
        $personas = Persona::all();
        $certificados = Certificado::with(['evento', 'estadoCertificado', 'tipoCertificado.cargo'])->get();

        return view('Vistas.ConCertificado', compact('eventos', 'inscripciones', 'personas', 'certificados'));
    }

    public function filterByEventos(Request $request)
    {
        $eventId = $request->input('event_id');
        $searchTerm = $request->input('searchTerm');

        $certificados = Certificado::with([
            'evento',                   
            'estadoCertificado',
            'tipoCertificado.cargo',
            'certiasiste.asistencia.inscripcion.persona',
            'certiasiste.asistencia.inscripcion.escuela'
        ])
            ->where('idevento', $eventId)
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->whereHas('certiasiste.asistencia.inscripcion.persona', function ($q) use ($searchTerm) {
                    $q->where('dni', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('nombre', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('apell', 'LIKE', "%{$searchTerm}%");
                });
            })
            ->get();

        return response()->json($certificados);
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
                'prefijo' => 'required|string|max:10'
            ], [
                'idevento.required' => 'Debe seleccionar un evento.',
                'idevento.exists' => 'El evento seleccionado no existe.',
                'prefijo.required' => 'Debe ingresar un prefijo para generar los certificados.',
                'prefijo.max' => 'El prefijo no puede tener más de 10 caracteres.'
            ]);

            $idEvento = $request->input('idevento');
            $prefijo = strtoupper(trim($request->input('prefijo')));

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
            $message = $result[0]->Resultado ?? 'Números de certificado generados correctamente.';
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . implode(', ', $e->errors())
            ], 422);
        } catch (\Illuminate\Database\QueryException $ex) {
            Log::error('Error en GenerarNumeroCertificado: ' . $ex->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error en la base de datos: ' . $ex->getMessage()
            ], 500);
        } catch (\Exception $e) {
            Log::error('Error general en numcerocerti: ' . $e->getMessage());
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

    // Obtener el último folio asignado para un evento
    public function obtenerUltimoFolio(Request $request)
    {
        try {
            $idevento = $request->input('idevento');
            
            if (!$idevento || $idevento <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de evento inválido'
                ], 400);
            }
            $total = DB::table('certificado')
                ->where('idevento', $idevento)
                ->whereNotNull('foli')
                ->whereNotNull('numregis')
                ->count();

            return response()->json([
                'success' => true,
                'total' => $total
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener folios: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Guardar folio, registro, cuaderno y tiempo de capacitación
     */
    public function guardarFolio(Request $request)
    {
        $request->validate([
            'cuaderno' => 'required|string|max:45',
            'tiempoCapacitacion' => 'required|string|max:100',
            'modo' => 'required|in:auto,manual',
            'idevento' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            $cuaderno = $request->input('cuaderno');
            $tiempoCapacitacion = $request->input('tiempoCapacitacion');
            $modo = $request->input('modo');
            $idevento = $request->input('idevento');

            if ($modo === 'auto') {
                $LIMITE = 32;
                $certificadosSinAsignar = DB::table('certificado')
                    ->select('idCertif')
                    ->where('idevento', $idevento)
                    ->where(function($query) {
                        $query->whereNull('foli')
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
                $totalAsignados = DB::table('certificado')
                    ->where('idevento', $idevento)
                    ->whereNotNull('foli')
                    ->whereNotNull('numregis')
                    ->count();

                $actualizados = 0;
                $contadorGlobal = $totalAsignados;
                foreach ($certificadosSinAsignar as $certificado) {
                    $contadorGlobal++;
                    
                    $folio = ceil($contadorGlobal / $LIMITE);
                    $registro = $contadorGlobal % $LIMITE;
                    
                    if ($registro === 0) {
                        $registro = $LIMITE;
                    }

                    DB::table('certificado')
                        ->where('idCertif', $certificado->idCertif)
                        ->update([
                            'cuader' => $cuaderno,
                            'foli' => $folio,
                            'numregis' => $registro,
                            'tiempocapa' => $tiempoCapacitacion
                        ]);

                    $actualizados++;
                }

                $mensaje = "Se asignaron automáticamente $actualizados certificado(s) con sus respectivos folios y registros";

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
                    return response()->json([
                        'success' => false,
                        'message' => 'El rango de registros es inválido'
                    ], 400);
                }

                $cantidadNecesaria = $registroHasta - $registroDesde + 1;
                
                $certificados = DB::table('certificado')
                    ->select('idCertif')
                    ->where('idevento', $idevento)
                    ->where(function($query) {
                        $query->whereNull('foli')
                              ->orWhereNull('numregis');
                    })
                    ->limit($cantidadNecesaria)
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
                    if ($registroActual > $registroHasta) {
                        break;
                    }

                    DB::table('certificado')
                        ->where('idCertif', $certificado->idCertif)
                        ->update([
                            'cuader' => $cuaderno,
                            'foli' => $folio,
                            'numregis' => $registroActual,
                            'tiempocapa' => $tiempoCapacitacion
                        ]);

                    $actualizados++;
                    $registroActual++;
                }

                $mensaje = "$actualizados certificado(s) actualizados con Folio $folio y Registros $registroDesde-$registroHasta";
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
            if ($certificado->idestcer == 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'El certificado ya fue entregado'
                ], 400);
            }
            DB::table('certificado')
                ->where('idCertif', $idCertif)
                ->update([
                    'idestcer' => 2,
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
}
