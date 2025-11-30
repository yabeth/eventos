<?php

namespace App\Http\Controllers;
use App\Models\resoluciaprob;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\evento;
use App\Models\tiporesolucion;
use App\Models\TipresolucionAgrad;
use Illuminate\Validation\ValidationException;  
use DB;

class ResoluciaprobController extends Controller
{
    public function resolucion()
    {

        $tiporesoluciones = tiporesolucion::all();
        $eventos = evento::all();
        $TipresolucionAgrads = TipresolucionAgrad::all();
        $eventoss = evento::leftJoin('resoluciaprob as r', 'evento.idevento', '=', 'r.idevento')
        ->whereNull('r.idevento')
        ->select('evento.eventnom', 'evento.idevento')
        ->get();
        $resoluciaprobs = resoluciaprob::with(['tiporesolucion','evento','TipresolucionAgrad'])->get();
        return view('Vistas.resoluciaprob', compact('tiporesoluciones', 'eventos','resoluciaprobs','eventoss','TipresolucionAgrads'));
    }

    public function create()
    {}
    public function store(Request $request)
    {
        try {
            $request->validate([  
                'ruta' => 'required|file|mimes:pdf,docx',   
            ]);  
        $file = $request->file('ruta');
        $filename = $file->getClientOriginalName();
        $file->storeAs('public/resoluciaprob', $filename);
        $ruta = 'resoluciaprob/' . $filename;


        DB::statement('CALL CRresol(?,?,?,?,?,?,?)', [
            $request->input('nrores'),
            $request->input('fechapro'),
            $request->input('idTipresol'),
            $request->input('idevento'),
            $ruta, 
            $request->input('numresolagradcmt'),
            $request->input('idtipagr')
        ]);
        return redirect()->back()->with('success','Se registro correctamente');
    } catch (ValidationException $e) {  
        return redirect()->back()->with('swal_error', 'Solo se permiten archivos PDF y DOCX.');  
    } catch (\Illuminate\Database\QueryException $e) {
        $errorCode = $e->errorInfo[1];
        if($errorCode == 1644){
            $errorMessage = $e->errorInfo[2];
            return redirect()->back()->with('swal_error', $errorMessage);
        }
        throw $e;
    }
    }
    public function show(resoluciaprob $resoluciaprob)
    {}
    public function edit($idreslaprb)
    { 
        $resoluciaprobs = resoluciaprob::findOrFail($idreslaprb); 
        return view('Vistas.resoluciaprob', compact('resoluciaprobs'));
    }
    public function update(Request $request, $idreslaprb)  
    {  
        try {  
            // Validación de la entrada  
            $request->validate([  
                'fechapro' => 'required|date', // Asegúrate de validar otros campos según tus necesidades  
                'idevento' => 'required|integer',  
                'idTipresol' => 'required|integer',  
                'nrores' => 'required|string',  
                'ruta' => 'nullable|file|mimes:pdf,docx' // Validación para el archivo  
            ]);  
            
            // Inicializa la variable de ruta  
            $ruta = null;   
    
            if ($request->hasFile('ruta')) {  
                $file = $request->file('ruta');  
                $filename = $file->getClientOriginalName();  
                $file->storeAs('public/resoluciaprob', $filename);  
                $ruta = 'resoluciaprob/' . $filename;  
            }  
    
            // Llama al procedimiento almacenado  
            $result = DB::select('CALL MDresolapro(?, ?, ?, ?, ?, ?,?,?)', [  
                $idreslaprb,  
                $request->input('fechapro'),  
                $request->input('idevento'),  
                $request->input('idTipresol'),  
                $request->input('nrores'),  
                $ruta, 
                $request->input('numresolagradcmt'),  
                $request->input('idtipagr')  
            ]);  
    
            return redirect()->back()->with('success', '¡Se modifico exitosamente!');  
    
        } catch (\Illuminate\Validation\ValidationException $e) {  
            // Captura de la excepción de validación  
            return redirect()->back()->with('swal_error', 'Solo se permite subir archivos PDF y DOCX.');  
        } catch (\Illuminate\Database\QueryException $e) {  
            $errorCode = $e->errorInfo[1];  
            if ($errorCode == 1451) {  
                return redirect()->back()->with('swal_error', 'No se puede modificar el tipo de evento.');  
            } elseif ($errorCode == 1644) {  
                $errorMessage = $e->errorInfo[2];  
                return redirect()->back()->with('swal_error', $errorMessage);  
            } else {  
                return redirect()->back()->with('swal_error', 'Ocurrió un error al intentar insertar.');  
            }  
        } catch (\Exception $e) {  
            return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado al intentar insertar.');  
        }  

} 
    public function destroy($idreslaprb)
    { 
        $result = DB::select('call Eliresolucion(?)', [$idreslaprb]);
        return redirect()->back()->with('success', '¡Se elimino correctamente');
    }

    public function buscar(Request $request) {
        $query = $request->input('search'); 

        $resoluciaprobs = resoluciaprob::where('nrores', 'LIKE', '%' . $query . '%')
        ->orWhereHas('tiporesolucion', function($q) use ($query) {
            $q->where('nomtiprs', 'LIKE', '%' . $query . '%');
        })
        ->orWhereHas('evento', function($q) use ($query) {
            $q->where('eventnom', 'LIKE', '%' . $query . '%');
        })
        ->with('evento') // Esto asegura que la relación 'evento' se cargue también
        ->get();
    

        $output = '';

        foreach ($resoluciaprobs as $index =>$reso) {
            $output .= '<tr>
                  <td>' . ($index + 1) . '</td>
                <td>' . $reso->evento->eventnom . '</td>
                <td>' . $reso->tiporesolucion->nomtiprs . '</td>
                <td>' . $reso->fechapro . '</td>
                <td>' . $reso->nrores . '</td>
                <td>' . $reso->ruta . '</td>
                <td>
                    <div class="btn-group action-buttons">
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit' . $reso->idreslaprb . '">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete' . $reso->idreslaprb . '">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>';
        }
        return response($output); 
    }


}
