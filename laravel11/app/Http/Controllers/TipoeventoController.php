<?php

namespace App\Http\Controllers;
use App\Models\tipoevento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class TipoeventoController extends Controller
{
    public function vistipeven()
    {
        $tipoeventos = tipoevento::all();
        return view('Vistas.vistipeven',compact('tipoeventos'));
    }
    public function create()
    {
        
    }
    public function store(Request $request) {  
        try {  
            // Llamada a la stored procedure  
            DB::statement('call CRtipeven(?)', [  
                $request->input('nomeven')  
            ]);  
    
            
            return redirect()->back()->with('swal_success', 'El tipo de evento se agregó exitosamente!');
        }catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->back()->with('swal_error', 'No se puede ingresar el tipo de evento ');
            } elseif ($errorCode == 1644) {
                $errorMessage = $e->errorInfo[2];
                return redirect()->back()->with('swal_error', $errorMessage);
            } else {
                return redirect()->back()->with('swal_error', 'Ocurrió un error al intentar insertar ?');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado al intentar insertar');
        }
    
    }
    public function show(tipoevento $tipoevento)
    {
        
    }
    public function edit( $idTipoeven)
    {
        
        $tipoevento = tipoevento::findOrFail($idTipoeven); 
        return view('Vistas.vistipeven', compact('tipoevento'));
    }
    public function update(Request $request, $idTipoeven)
    {
        try {  
        $result = DB::select('CALL MODtipeven(?, ?)', [
            $idTipoeven,
            $request->input('nomeven')
        ]);
        return redirect()->back()->with('swal_success', 'El tipo de evento se modificó exitosamente!');
     } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->back()->with('swal_error', 'No se puede modificar el tipo de evento ');
            } elseif ($errorCode == 1644) {
                $errorMessage = $e->errorInfo[2];
                return redirect()->back()->with('swal_error', $errorMessage);
            } else {
                return redirect()->back()->with('swal_error', 'Ocurrió un error');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado');
        }
    }
    public function destroy($idTipoeven)
    {
        try {
        $result = DB::select('CALL ELItipeven(?)', [
            $idTipoeven
        ]);
        return redirect()->back()->with('success', '¡El tipo de evento se elimino correctamente');
    } catch (\Illuminate\Database\QueryException $e) {
        $errorCode = $e->errorInfo[1];
        if ($errorCode == 1451) {
            return redirect()->back()->with('swal_error', 'No se puede eliminar el tipo de evento ');
        } elseif ($errorCode == 1644) {
            $errorMessage = $e->errorInfo[2];
            return redirect()->back()->with('swal_error', $errorMessage);
        } else {
            return redirect()->back()->with('swal_error', 'Ocurrió un error al intentar eliminar ?');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado al intentar eliminar');
    }

    }
    public function buscar(Request $request)
    {
        $query = $request->input('search'); 
    
        $tipoeventos = tipoevento::where('nomeven', 'LIKE', '%' . $query . '%')->get();
    
        $output = '';
        foreach ($tipoeventos as  $index =>$tipoevento) {
            $output .= '<tr>
                            <td>' . ($index + 1) . '</td>
                            <td>' . $tipoevento->nomeven . '</td>
                            <td>
                                <div class="btn-group action-buttons">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit' . $tipoevento->idTipoeven . '"><i class="bi bi-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete' . $tipoevento->idTipoeven . '"><i class="bi bi-trash"></i></button>
                                </div>
                            </td>
                        </tr>';
        }
        
    
        return response($output); 
    }
    


    
}
