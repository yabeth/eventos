<?php

namespace App\Http\Controllers;
use App\Models\evento;
use App\Models\organizador;
use App\Models\tipoorg;
use App\Models\eventoorganizador;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class EventoorganizadorController extends Controller
{
    
    public function evenorg()
    {
      /*  $eventoss = evento::leftJoin('eventoorganizador as eo', 'evento.idevento', '=', 'eo.idevento')
            ->whereNull('eo.idevento')
            ->select('evento.*')
            ->get();*/

        $eventoss = evento::where('fechculm', '>=', now()->toDateString())->get();
        $eventos = evento::all();
        $tipoorgs = tipoorg::all();
        $organizadors = organizador::with(['tipoorg'])->get();
        
        // Obtenemos todos los eventos con organizadores
        $eventoorganizadors = eventoorganizador::with(['evento', 'organizador'])->get();
        
        // Agrupamos los eventos por idevento
        $eventosAgrupados = [];
        foreach ($eventoorganizadors as $evenorg) {
            $idevento = $evenorg->idevento;
            if (!isset($eventosAgrupados[$idevento])) {
                $eventosAgrupados[$idevento] = [
                    'evento' => $evenorg->evento,
                    'organizadores' => []
                ];
            }
            $eventosAgrupados[$idevento]['organizadores'][] = [
                'organizador' => $evenorg->organizador,
                'idorg' => $evenorg->idorg
            ];
        }
        
        return view('Vistas.eventoorganizador', compact('eventos', 'organizadors', 'eventoorganizadors', 'tipoorgs', 'eventoss', 'eventosAgrupados'));
    }
   
    public function create()
    {
        
    }

   
    public function store(Request $request)
    {
        try {
            DB::statement('CALL CRevenorg(?, ?)', [
                $request->input('idevento'),
                $request->input('idorg')
            ]);
         
            return response()->json([
                'message' => 'Se agregó exitosamente!'
            ], 200);

        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1644){
                $errorMessage = $e->errorInfo[2];
                return response()->json([
                    'message' => $errorMessage
                ], 400);
            }
       
            return response()->json([
                'message' => 'Hubo un error inesperado.'
            ], 500);
        }
    }

    public function show(eventoorganizador $eventoorganizador)
    {
        
    }

   
    public function edit(eventoorganizador $eventoorganizador)
    {
        
    }

    public function update(Request $request, $idevento, $idorg)
    {
        try {
            $result = DB::select('CALL MDevenorg(?, ?, ?, ?)', [
                $idevento,      
                $idorg,        
                $request->input('ideventon'), 
                $request->input('idorgn')     
            ]);
    
            $message = $result[0]->mensaje ?? 'Se modificó correctamente';
    
            return redirect()->back()->with('swal_success', $message);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1644) {
                $errorMessage = $e->errorInfo[2];
                return redirect()->back()->with('swal_error', $errorMessage);
            } elseif ($errorCode == 1062) {
                return redirect()->back()->with('swal_error', 'Puede generar duplicidad');
            } else {
                return redirect()->back()->with('swal_error', 'Ocurrió un error al modificar');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado');
        }
    }

   
    public function destroy(Request $request, $idevento, $idorg)
    {
        try {
            $result = DB::select('CALL Elievenorg(?, ?)', [
                $idevento,
                $idorg
            ]);

            $message = $result[0]->{'Se eliminó correctamente'} ?? 'Se eliminó correctamente';
            return redirect()->back()->with('swal_success', $message);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->back()->with('swal_error', 'No se puede eliminar porque está siendo utilizado en otras partes del sistema');
            } elseif ($errorCode == 1644) {
                $errorMessage = $e->errorInfo[2];
                return redirect()->back()->with('swal_error', $errorMessage);
            } else {
                return redirect()->back()->with('swal_error', 'Ocurrió un error al intentar eliminar ');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado al intentar');
        } 





    }
}
