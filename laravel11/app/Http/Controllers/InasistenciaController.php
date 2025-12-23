<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class InasistenciaController extends Controller
{
    public function index()
    {
        $eventos = DB::table('evento')
            ->where('idestadoeve', 2)
            ->where('fechculm', '>=', DB::raw('CURRENT_DATE'))
            ->orderBy('fecini', 'DESC')
            ->get();
        
        return view('Vistas.ConAsistencia', compact('eventos'));
    }

    
    public function obtenerSubeventoActivo(Request $request) {
        try {
            $idevento = $request->idevento;
            $ahora = Carbon::now('America/Lima');
            $fechaActual = $ahora->format('Y-m-d');
            $horaActual = $ahora->format('H:i:s');

            // Log::info("=== Buscando subevento activo ===");
            Log::info("Evento ID: $idevento");
            Log::info("Fecha actual: $fechaActual");
            Log::info("Hora actual: $horaActual");

            $subevento = DB::table('subevent')
                ->select('idsubevent', 'Descripcion', 'fechsubeve', 'horini', 'horfin', 'idevento')
                ->where('idevento', $idevento)
                ->where('fechsubeve', $fechaActual)
                ->where('horini', '<=', $horaActual)
                ->where('horfin', '>=', $horaActual)
                ->orderBy('horini', 'ASC')
                ->first();

            if ($subevento) {
                Log::info("Encontrado subevento EN CURSO: " . json_encode($subevento));
            }

            if (!$subevento) {
                $horaLimite = Carbon::parse($horaActual)->addMinutes(30)->format('H:i:s');
                
                Log::info("Buscando subeventos próximos (hasta $horaLimite)");
                
                $subevento = DB::table('subevent')
                    ->select('idsubevent', 'Descripcion', 'fechsubeve', 'horini', 'horfin', 'idevento')
                    ->where('idevento', $idevento)
                    ->where('fechsubeve', $fechaActual)
                    ->where('horini', '>', $horaActual)
                    ->where('horini', '<=', $horaLimite)
                    ->orderBy('horini', 'ASC')
                    ->first();

                if ($subevento) {
                    Log::info("Encontrado subevento PRÓXIMO (30 min): " . json_encode($subevento));
                }
            }

            if (!$subevento) {
                Log::info("Buscando cualquier subevento posterior de hoy");
                
                $subevento = DB::table('subevent')
                    ->select('idsubevent', 'Descripcion', 'fechsubeve', 'horini', 'horfin', 'idevento')
                    ->where('idevento', $idevento)
                    ->where('fechsubeve', $fechaActual)
                    ->where('horini', '>', $horaActual)
                    ->orderBy('horini', 'ASC')
                    ->first();

                if ($subevento) {
                    Log::info("Encontrado subevento POSTERIOR: " . json_encode($subevento));
                }
            }

            if (!$subevento) {
                // Log::warning("No hay subeventos programados para hoy ($fechaActual)");
                
                return response()->json([
                    'success' => false,
                    'message' => "No hay subeventos programados para hoy ($fechaActual). Verifique que existan subeventos para la fecha actual."
                ]);
            }

            Log::info("Subevento seleccionado: ID={$subevento->idsubevent}, Desc={$subevento->Descripcion}");

            return response()->json([
                'success' => true,
                'subevento' => $subevento
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener subevento activo: ' . $e->getMessage());
            Log::error('Stack: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener subevento: ' . $e->getMessage()
            ], 500);
        }
    }

    public function obtenerParticipantes(Request $request)
    {
        try {
            $idsubevent = $request->idsubevent;

            Log::info("=== Obteniendo participantes ===");
            Log::info("Subevento ID: $idsubevent");

            $participantes = DB::table('inscripcion as i')
                ->join('personas as p', 'i.idpersona', '=', 'p.idpersona')
                ->leftJoin('asistencia as a', 'i.idincrip', '=', 'a.idincrip')
                ->leftJoin('tipoasiste as ta', 'a.idtipasis', '=', 'ta.idtipasis')
                ->select(
                    'i.idincrip',
                    'i.idsubevent',
                    'p.idpersona',
                    'p.dni',
                    'p.nombre',
                    'p.apell',
                    'p.email',
                    DB::raw("COALESCE(a.idasistnc, 0) as idasistnc"),
                    DB::raw("COALESCE(a.idtipasis, 1) as idtipasis"),
                    DB::raw("COALESCE(ta.nomasis, 'Presente') as nomasis"),
                    DB::raw("COALESCE(a.idestado, 1) as idestado"),
                    DB::raw("COALESCE(a.porceasis, 0) as porceasis")
                )
                ->where('i.idsubevent', $idsubevent)
                ->orderBy('p.apell', 'ASC')
                ->orderBy('p.nombre', 'ASC')
                ->get();

            Log::info("Participantes encontrados: " . $participantes->count());

            if ($participantes->count() > 0) {
                Log::info("Primeros 3 participantes: " . json_encode($participantes->take(3)));
            }

            $totalInscritos = $participantes->count();
            $totalPresentes = $participantes->where('idtipasis', 1)->count();
            $totalAusentes = $participantes->where('idtipasis', 2)->count();
            
            $porcentajePresentes = $totalInscritos > 0 ? round(($totalPresentes / $totalInscritos) * 100, 1) : 0;
            $porcentajeAusentes = $totalInscritos > 0 ? round(($totalAusentes / $totalInscritos) * 100, 1) : 0;

            return response()->json([
                'success' => true,
                'participantes' => $participantes,
                'estadisticas' => [
                    'totalInscritos' => $totalInscritos,
                    'totalPresentes' => $totalPresentes,
                    'totalAusentes' => $totalAusentes,
                    'porcentajePresentes' => $porcentajePresentes,
                    'porcentajeAusentes' => $porcentajeAusentes
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al obtener participantes: ' . $e->getMessage());
            Log::error('SQL Query Error: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener participantes: ' . $e->getMessage()
            ], 500);
        }
    }

    public function guardarAsistencias(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'idsubevent' => 'required|integer',
                'asistencias' => 'required|array',
                'asistencias.*.idincrip' => 'required|integer',
                'asistencias.*.idtipasis' => 'required|integer|in:1,2'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $idsubevent = $request->idsubevent;
            $asistencias = $request->asistencias;
            $fechaActual = Carbon::now('America/Lima');

            Log::info("=== Guardando asistencias ===");
            Log::info("Subevento ID: $idsubevent");
            Log::info("Total asistencias a guardar: " . count($asistencias));

            $insertados = 0;
            $actualizados = 0;

            foreach ($asistencias as $asistencia) {
                $idincrip = $asistencia['idincrip'];
                $idtipasis = $asistencia['idtipasis'];
                
                $porceasis = ($idtipasis == 1) ? 100 : 0;

                $existente = DB::table('asistencia')
                    ->where('idincrip', $idincrip)
                    ->first();

                if ($existente) {
                    DB::table('asistencia')
                        ->where('idasistnc', $existente->idasistnc)
                        ->update([
                            'fech' => $fechaActual,
                            'idtipasis' => $idtipasis,
                            'porceasis' => $porceasis,
                            'idestado' => 1
                        ]);
                    $actualizados++;
                    Log::info("✓ Actualizado: idincrip=$idincrip, tipo=$idtipasis");
                } else {
                    DB::table('asistencia')->insert([
                        'fech' => $fechaActual,
                        'idtipasis' => $idtipasis,
                        'idincrip' => $idincrip,
                        'idestado' => 1,
                        'porceasis' => $porceasis
                    ]);
                    $insertados++;
                    Log::info("✓ Insertado: idincrip=$idincrip, tipo=$idtipasis");
                }
            }

            DB::commit();

            Log::info("Asistencias guardadas: $insertados insertados, $actualizados actualizados");

            return response()->json([
                'success' => true,
                'message' => "Asistencias guardadas: $insertados nuevas, $actualizados actualizadas"
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al guardar asistencias: ' . $e->getMessage());
            Log::error('Stack: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar asistencias: ' . $e->getMessage()
            ], 500);
        }
    }

    
    public function culminarAsistencia(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'idsubevent' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos'
                ], 422);
            }

            DB::beginTransaction();

            $idsubevent = $request->idsubevent;

            Log::info("=== Culminando asistencia ===");
            Log::info("Subevento ID: $idsubevent");

            $affected = DB::table('asistencia as a')
                ->join('inscripcion as i', 'a.idincrip', '=', 'i.idincrip')
                ->where('i.idsubevent', $idsubevent)
                ->update(['a.idestado' => 2]);

            DB::commit();

            Log::info("✓ Registros culminados: $affected");

            return response()->json([
                'success' => true,
                'message' => 'Asistencia culminada correctamente',
                'registros_actualizados' => $affected
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al culminar asistencia: ' . $e->getMessage());
            Log::error('Stack: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al culminar asistencia: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verificarEventoCompleto(Request $request)
    {
        try {
            $idevento = $request->idevento;

            Log::info("=== Verificando si evento está completo ===");
            Log::info("Evento ID: $idevento");

            $totalSubeventos = DB::table('subevent')
                ->where('idevento', $idevento)
                ->count();

            $subeventosCulminados = DB::table('subevent as s')
                ->join('inscripcion as i', 's.idsubevent', '=', 'i.idsubevent')
                ->join('asistencia as a', 'i.idincrip', '=', 'a.idincrip')
                ->where('s.idevento', $idevento)
                ->where('a.idestado', 2) // Solo culminados
                ->distinct()
                ->count('s.idsubevent');

            $eventoCompleto = ($totalSubeventos > 0 && $totalSubeventos === $subeventosCulminados);

            Log::info("Total subeventos: $totalSubeventos");
            Log::info("Subeventos culminados: $subeventosCulminados");
            Log::info("Evento completo: " . ($eventoCompleto ? 'SÍ' : 'NO'));

            return response()->json([
                'success' => true,
                'eventoCompleto' => $eventoCompleto,
                'totalSubeventos' => $totalSubeventos,
                'subeventosCulminados' => $subeventosCulminados,
                'subeventosPendientes' => $totalSubeventos - $subeventosCulminados
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR al verificar evento completo: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar evento: ' . $e->getMessage()
            ], 500);
        }
    }

   
    public function generarCertificados(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'idevento' => 'required|integer',
                'porcentaje_minimo' => 'required|numeric|min:0|max:100'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            $idevento = $request->idevento;
            $porcentajeMinimo = $request->porcentaje_minimo ?? 40;

            Log::info("=== Generando certificados ===");
            Log::info("Evento ID: $idevento");
            Log::info("Porcentaje mínimo: $porcentajeMinimo%");

            $verificacion = $this->verificarEventoCompleto($request);
            $datosVerificacion = json_decode($verificacion->getContent());

            if (!$datosVerificacion->eventoCompleto) {
                return response()->json([
                    'success' => false,
                    'message' => "No se pueden generar certificados. Aún hay {$datosVerificacion->subeventosPendientes} subevento(s) pendiente(s) de culminar."
                ], 422);
            }

            DB::beginTransaction();

            $participantes = DB::table('inscripcion as i')
                ->join('personas as p', 'i.idpersona', '=', 'p.idpersona')
                ->join('subevent as s', 'i.idsubevent', '=', 's.idsubevent')
                ->join('asistencia as a', 'i.idincrip', '=', 'a.idincrip')
                ->select(
                    'p.idpersona',
                    'p.dni',
                    'p.nombre',
                    'p.apell',
                    DB::raw('AVG(a.porceasis) as porcentaje_total'),
                    DB::raw('COUNT(DISTINCT i.idsubevent) as subeventos_asistidos')
                )
                ->where('s.idevento', $idevento)
                ->where('a.idestado', 2) // Solo culminados
                ->groupBy('p.idpersona', 'p.dni', 'p.nombre', 'p.apell')
                ->having('porcentaje_total', '>=', $porcentajeMinimo)
                ->get();

            Log::info("Participantes aptos para certificado: " . $participantes->count());

            $certificadosGenerados = 0;
            $certificadosExistentes = 0;
            $errores = [];

            foreach ($participantes as $participante) {
                try {
                    $certificadoExistente = DB::table('certificado as c')
                        ->join('certiasiste as ca', 'c.idCertif', '=', 'ca.idCertif')
                        ->join('asistencia as a', 'ca.idasistnc', '=', 'a.idasistnc')
                        ->join('inscripcion as i', 'a.idincrip', '=', 'i.idincrip')
                        ->join('subevent as s', 'i.idsubevent', '=', 's.idsubevent')
                        ->where('s.idevento', $idevento)
                        ->where('i.idpersona', $participante->idpersona)
                        ->exists();

                    if ($certificadoExistente) {
                        $certificadosExistentes++;
                        Log::info("Ya existe certificado para: {$participante->nombre} {$participante->apell}");
                        continue;
                    }

                    $anio = date('Y');
                    $ultimoNumero = DB::table('certificado')
                        ->where('nro', 'LIKE', "CERT-$anio-%")
                        ->count();
                    $numeroConsecutivo = str_pad($ultimoNumero + 1, 6, '0', STR_PAD_LEFT);
                    $numeroCertificado = "CERT-$anio-$numeroConsecutivo";

                    $token = hash('sha256', $numeroCertificado . $participante->dni . time());

                    $evento = DB::table('evento')->where('idevento', $idevento)->first();

                    $idCertificado = DB::table('certificado')->insertGetId([
                        'nro' => "",
                        'idestcer' => 1,
                        'fecentrega' => null,
                        'cuader' => '',
                        'foli' => 0,
                        'numregis' => 0,
                        'tokenn' => "",
                        'descr' => "",
                        'pdff' => '',
                        'tiempocapa' => '',
                        'idevento' => $idevento,
                        'idcargo' => 1 
                    ]);

                    $asistencias = DB::table('asistencia as a')
                        ->join('inscripcion as i', 'a.idincrip', '=', 'i.idincrip')
                        ->join('subevent as s', 'i.idsubevent', '=', 's.idsubevent')
                        ->where('s.idevento', $idevento)
                        ->where('i.idpersona', $participante->idpersona)
                        ->select('a.idasistnc')
                        ->get();

                    foreach ($asistencias as $asistencia) {
                        DB::table('certiasiste')->insert([
                            'idasistnc' => $asistencia->idasistnc,
                            'idCertif' => $idCertificado
                        ]);
                    }

                    $certificadosGenerados++;
                    Log::info("Certificado generado para: {$participante->nombre} {$participante->apell} - {$numeroCertificado}");

                } catch (\Exception $e) {
                    $errores[] = "Error al generar certificado para {$participante->nombre} {$participante->apell}: " . $e->getMessage();
                    Log::error("Error generando certificado: " . $e->getMessage());
                }
            }

            DB::commit();

            $mensaje = "Certificados generados exitosamente: $certificadosGenerados nuevos";
            if ($certificadosExistentes > 0) {
                $mensaje .= ", $certificadosExistentes ya existían";
            }

            Log::info("Proceso de certificados completado");

            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'certificadosGenerados' => $certificadosGenerados,
                'certificadosExistentes' => $certificadosExistentes,
                'totalParticipantes' => $participantes->count(),
                'errores' => $errores
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR al generar certificados: ' . $e->getMessage());
            Log::error('Stack: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al generar certificados: ' . $e->getMessage()
            ], 500);
        }
    }
}