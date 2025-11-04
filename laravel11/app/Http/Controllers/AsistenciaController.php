<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\evento;
use App\Models\asistencia;
use App\Models\inscripcion;
use App\Models\persona;
use App\Models\tipoasiste;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

class AsistenciaController extends Controller
{
    public function asistencia()
    {
        $inscripciones= inscripcion::all();
        $inscripciones= inscripcion::with('evento')->get();
        $tipoasistes= tipoasiste::all();
        $personas= persona::all();
        
        $eventos = DB::table('evento as eve')
        ->distinct()
        ->join('inscripcion as ins', 'ins.idevento', '=', 'eve.idevento')
        ->join('asistencia as asi', 'asi.idincrip', '=', 'ins.idincrip')
        ->join('tipoasistencia as tip', 'tip.idestado', '=', 'asi.idestado')
        ->where('tip.idestado', 1)
        ->where('eve.idestadoeve', 2)
        ->whereDate('eve.fecini', '=', DB::raw('CURDATE()')) // Cambiar la condición de fecha
        ->whereRaw('(TIME(NOW()) BETWEEN TIME(eve.horain) AND ADDTIME(TIME(eve.horcul), "00:10:00"))') // Añadiendo la condición de tiempo
        ->select('eve.*')
        ->get();

        $asistencias = asistencia::with(['inscripcion.evento','inscripcion','inscripcion.persona','tipoasiste'])->get();
        return view('Vistas.asistencia',compact('asistencias','inscripciones','eventos','personas','tipoasistes'));
    }
    public function create()
    {
    }
    public function store(Request $request)
    {}
    public function show(asistencia $asistencia)
    {}
    public function edit($idasistnc)
    {
        $asistencias = asistencia::findOrFail($iidasistnc); 

        return view('Vistas.asistencia',compact('asistencias'));
    }

    public function update(Request $request, $idasistnc)
    {
        try {
            if (!Auth::check()) {
                return redirect()->back()->with('swal_error', 'Usuario no autenticado');
            }
            $usuario_logueado = Auth::user()->nomusu;
            DB::statement("SET @usuario_logueado := ?", [$usuario_logueado]);
            DB::statement('CALL MDasisten(?, ?)', [
                $idasistnc,
                $request->input('idtipasis')
            ]);

            return redirect()->back()->with('success', '¡Asistencia actualizada correctamente!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('swal_error', 'Ocurrió un error al intentar actualizar.');
        } catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado.');
        }
    }

    public function updateMultiple(Request $request) {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Usuario no autenticado'], 403);
            }
            $usuario_logueado = Auth::user()->nomusu;
            DB::statement("SET @usuario_logueado := ?", [$usuario_logueado]);
            $attendances = $request->input('attendances');

            foreach ($attendances as $idasistnc => $idtipasis) {
                DB::statement('CALL MDasisten(?, ?)', [
                    $idasistnc,
                    $idtipasis
                ]);
            }

            return response()->json(['message' => '¡Asistencias actualizadas correctamente!']);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'Ocurrió un error al intentar actualizar.'], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error inesperado.'], 500);
        }
    }


    public function destroy(asistencia $asistencia)
    {}
    public function filterByEven(Request $request)
    {
    $eventId = $request->input('event_id');
    
    try {
        $asistencias = asistencia::with(['inscripcion.evento', 'inscripcion', 'inscripcion.persona','tipoasiste'])
            ->whereHas('inscripcion', function ($query) use ($eventId) {
                $query->where('idevento', $eventId);
            })
            ->get();
    } catch (\Exception $e) {
        \Log::error('Error fetching asistencias: ' . $e->getMessage());
        return response()->json(['error' => 'Something went wrong'], 500);
    }
    
    return response()->json($asistencias);
    }

    public function buscar(Request $request)
    {
        $query = $request->input('search'); 
    
        $asistencias = asistencia::whereHas('inscripcion.persona', function($q) use ($query) {
            $q->where(function($subQuery) use ($query) {
                $subQuery->where('nombre', 'LIKE', "%{$query}%")
                    ->orWhere('apell', 'LIKE', "%{$query}%");
            });
        })->get();
        
    
        $output = '';
        foreach ($asistencias as $asistencia) {
            $output .= '<tr data-id="'.$asistencia->idasistnc.'">
                <td>'.$asistencia->inscripcion->persona->apell.' '.$asistencia->inscripcion->persona->nombre.'</td>
                <td>
                    <button class="btn btn-toggle" data-idasistnc="'.$asistencia->idasistnc.'" type="button">
                        <span class="attendance-icon"></span>
                    </button>
                </td>
            </tr>';
        }
    
        return response($output); 
    }

    
    public function cambioestad(Request $request, $idevento) {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Usuario no autenticado'], 403);
            }
            $usuario_logueado = Auth::user()->nomusu;
            DB::statement("SET @usuario_logueado := ?", [$usuario_logueado]);
            DB::statement('CALL MDestadasiten(?)', [$idevento]);
            return response()->json(['message' => 'Estado cambiado exitosamente.']);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'Ocurrió un error al cambiar el estado.', 'error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error inesperado.', 'error' => $e->getMessage()], 500);
        }
    }
}



