<?php

namespace App\Http\Controllers;
use App\Models\evento;
use App\Models\tipoevento;
use App\Models\EstadoEvento;
use App\Models\Resoluciaprob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use DB;
class EventoController extends Controller
{
    public function evento()
    {
    $tipoeventos = tipoevento::all();
    $EstadoEventos = EstadoEvento::all();
    $eventos = Evento::with(['estadoEvento', 'tipoEvento'])->get();
    $resoluciaprobs = resoluciaprob::with(['evento'])->get();
    return view('Vistas.evento', compact('tipoeventos', 'eventos','EstadoEventos','resoluciaprobs'));
    }
    public function create()
    {
        
    }
    public function store(Request $request) {
        try {
            DB::statement('CALL CRevento(?, ?, ?, ?, ?, ?,?,?)', [
                $request->input('eventnom'),
                $request->input('fecini'),
                $request->input('descripción'),
                $request->input('horain'),
                $request->input('horcul'),
                $request->input('idTipoeven'),
                $request->input('lugar'),
                $request->input('ponente')
            ]);
         
        $eventoRecienCreado = DB::table('evento')
        ->where('eventnom', $request->input('eventnom'))
        ->where('fecini', $request->input('fecini'))
        ->orderBy('idevento', 'desc')
        ->first();
    if ($eventoRecienCreado && Auth::check()) {
        $idEventoNuevo = $eventoRecienCreado->idevento;
        $nombreUsuario = Auth::user()->nomusu;
        DB::table('evento_auditoria')
            ->where('ideventooriginal', $idEventoNuevo)
            ->orderBy('fecha_operacion', 'desc') 
            ->limit(1) 
            ->update(['nombreusuario' => $nombreUsuario]);

    }
            return back()->with('swal_success', 'El evento se agregó exitosamente!');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1644){
                $errorMessage = $e->errorInfo[2];
                return redirect()->back()->with('swal_error', $errorMessage);
            }
       
            throw $e;
        }
    }
    public function show(evento $evento)
    {
    }
    public function edit($idevento) {
        $evento = Evento::findOrFail($idevento); // Encuentra el evento por ID
        $tipoeventos = tipoevento::all();
        $EstadoEventos = EstadoEvento::all();
        return view('Vistas.evento', compact('evento', 'tipoeventos', 'EstadoEventos'));
    }
    public function update(Request $request, $idevento) {
        try {
            $result = DB::select('CALL MDevento(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $idevento,
                $request->input('eventnom'),
                $request->input('fecini'),
                $request->input('descripción'),
                $request->input('horain'),
                $request->input('horcul'),
                $request->input('idTipoeven'),
                $request->input('lugar'),
                $request->input('ponente')
                
            ]);
            if ($idevento && Auth::check()) {
                $nombreUsuario = Auth::user()->nomusu;
                $updated = DB::table('evento_auditoria')
                    ->where('ideventooriginal', $idevento)
                    ->orderBy('fecha_operacion', 'desc') 
                    ->limit(1) 
                    ->update(['nombreusuario' => $nombreUsuario]);
            
                if (!$updated) {
                    Log::warning("No se encontró registro para actualizar en evento_auditoria para ideventooriginal {$idevento}");
                }
            }
            
            $message = $result[0]->{'El evento se modifico correctamente'} ?? 'El evento se modificó correctamente';
            return redirect()->back()->with('swal_success', $message);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1644) {
                $errorMessage = $e->errorInfo[2];
                return redirect()->back()->with('swal_error', $errorMessage);
            } elseif ($errorCode == 1062) {
                return redirect()->back()->with('swal_error', 'El evento puede generar duplicidad');
            } else {
                return redirect()->back()->with('swal_error', 'Ocurrió un error al modificar el evento');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado');
        }
    }
    public function destroy($idevento) {
        try {
            $result = DB::select('CALL ELIvento(?)', [$idevento]);
    
            if ($idevento && Auth::check()) {
                $nombreUsuario = Auth::user()->nomusu;
                DB::table('evento_auditoria')
                    ->where('ideventooriginal', $idevento)
                    ->orderBy('fecha_operacion', 'desc') 
                    ->limit(1) 
                    ->update(['nombreusuario' => $nombreUsuario]);
        
            }

            $message = $result[0]->{'El evento se eliminó correctamente'} ?? 'El evento se eliminó correctamente';
            return redirect()->back()->with('swal_success', $message);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->back()->with('swal_error', 'No se puede eliminar el evento porque está siendo utilizado en otras partes del sistema');
            } elseif ($errorCode == 1644) {
                $errorMessage = $e->errorInfo[2];
                return redirect()->back()->with('swal_error', $errorMessage);
            } else {
                return redirect()->back()->with('swal_error', 'Ocurrió un error al intentar eliminar el evento');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado al intentar eliminar el evento');
        }
    }


    public function buscar(Request $request)
    {
        $query = $request->input('search'); 
    
        $eventos = Evento::where('eventnom', 'LIKE', '%' . $query . '%')
                            ->orWhereHas('tipoevento', function($q) use ($query) {
                                $q->where('nomeven', 'LIKE', '%' . $query . '%');
                            })->orWhereHas('EstadoEvento', function($q) use ($query) {
                                $q->where('nomestado', 'LIKE', '%' . $query . '%');
                            })
                            ->get();
    
        $output = '';
        foreach ($eventos as $event) {
            $output .= '<tr>
                            <td>' . $event->eventnom . '</td>
                            <td>' . $event->descripción . '</td>
                            <td>' . $event->tipoEvento->nomeven . '</td>
                            <td>' . $event->fecini . '</td>
                            <td>' . $event->horain . '</td>
                            <td>' . $event->horcul . '</td>
                            <td>' . $event->lugar . '</td>
                            <td>' . $event->ponente . '</td>
                            <td>' . $event->EstadoEvento->nomestado . '</td>
                            <td>
                                <div class="mb-3">
                                    <input class="form-control form-control-sm" id="formFileSm" type="file">
                                </div>        
                            </td>
                            <td>
                                <div class="btn-group action-buttons">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit' . $event->idevento . '"><i class="bi bi-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete' . $event->idevento . '"><i class="bi bi-trash"></i></button>
                                </div>
                            </td>
                        </tr>';
        }
        
        return response($output); 
    }
    


}
