<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\evento;
use App\Models\persona;
use App\Models\escuela;
use App\Models\genero;
use App\Models\subevent;
use App\Models\inscripcion;
use Carbon\Carbon;

class eventowebController extends Controller {

    public function indexweb() {
        $ahora = Carbon::now();
        $fecha_ocultamiento = $ahora->copy()->addDays(2)->toDateString(); 

        $eventosVisibles = DB::table('evento')
            ->select(
                'evento.*',
                DB::raw('MIN(subevent.fechsubeve) as fechsubeve_min'),
                DB::raw('MIN(subevent.horini) as horini_min')
            )
            ->join('subevent', 'evento.idevento', '=', 'subevent.idevento')
            ->whereDate('subevent.fechsubeve', '>', $fecha_ocultamiento)
            ->groupBy(
                'evento.idevento', 
                'evento.eventnom', 
                'evento.idTipoeven', 
                'evento.idestadoeve', 
                'evento.descripción', 
                'evento.fecini', 
                'evento.fechculm', 
                'evento.idtema'
            )
            ->orderBy('fechsubeve_min', 'asc')
            ->orderBy('horini_min', 'asc')
            ->get();

        return view('Vistas.eventoweb', ['eventosProximos' => $eventosVisibles]);
    }

    public function showeventodetalle($id) {
        $escuelas = escuela::all();
        $generos = Genero::all();
        $eventoDetalle = DB::table('evento')
            ->where('idevento', $id)
            ->first();
            
        if (!$eventoDetalle) {
            abort(404);
        }
        $subEventos = DB::table('subevent')
            ->where('idevento', $id)
            ->orderBy('fechsubeve', 'asc')
            ->get();
            
        return view('Vistas.eventowebdetalle', compact('eventoDetalle', 'subEventos', 'escuelas', 'generos'));
    }

    // ============================================
    // CREAR INSCRIPCIÓN
    // ============================================

    public function getParticipant($dni) {
        $persona = Persona::where('dni', $dni)->first();
        
        if ($persona) {
            Log::info('Persona encontrada con ID: ' . $persona->idpersona);
            
            // Obtener la inscripción más reciente
            $inscripcion = DB::table('inscripcion')
                ->where('idpersona', $persona->idpersona)
                ->orderBy('idincrip', 'desc')
                ->first();
            
            if ($inscripcion) {
                Log::info('Inscripción encontrada con idescuela: ' . $inscripcion->idescuela);
                $persona->idescuela = $inscripcion->idescuela;
            } else {
                Log::info('No se encontraron inscripciones para esta persona');
            }
            
            return response()->json([
                'success' => true,
                'data' => $persona
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'No se encontró el participante.'
        ]);
    }

    // ============================================
    // CREAR INSCRIPCIÓN
    // ============================================
    public function store(Request $request) {
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Usuario no autenticado'], 401);
            }

            $usuario_logueado = Auth::user()->nomusu;
            DB::statement("SET @usuario_logueado := ?", [$usuario_logueado]);

            $dni = $request->input('dni');
            $idescuela = $request->input('idescuela');
            
            $persona = DB::table('personas')
                ->leftJoin('inscripcion', 'personas.idpersona', '=', 'inscripcion.idpersona')
                ->where('personas.dni', $dni)
                ->select('personas.*', 'inscripcion.idescuela')
                ->first();

            $decision = 'N';
            if ($persona && $persona->idescuela !== null && $persona->idescuela != $idescuela) {
                if (!$request->has('decision')) {
                    return response()->json([
                        'showAlert' => true,
                        'message' => 'La persona ya está registrada en otra escuela. ¿Desea cambiarla?'
                    ]);
                }
                $decision = $request->input('decision');
            }

            DB::statement('CALL CRinscrip(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->input('apell'),
                $request->input('direc'),
                $dni,
                $request->input('email'),
                $request->input('idgenero'),
                $request->input('nombre'),
                $request->input('tele'),
                $idescuela,
                $request->input('idevento'),
                $decision
            ]);

            $mensaje = ($persona && $persona->idescuela !== null && $persona->idescuela != $idescuela && $decision == 'S') 
                ? 'Se actualizó exitosamente!' 
                : 'Se agregó exitosamente!';

            return response()->json(['success' => true, 'message' => $mensaje]);

        } catch (\Illuminate\Database\QueryException $e) {
            if (strpos($e->getMessage(), 'No se puede registrar en una escuela diferente') !== false) {
                return response()->json([
                    'success' => false, 
                    'message' => 'No se puede registrar en una escuela diferente sin autorización'
                ], 400);
            }
            return response()->json(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error inesperado: ' . $e->getMessage()], 500);
        }
    }
}