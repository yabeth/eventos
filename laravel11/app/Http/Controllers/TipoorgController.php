<?php

namespace App\Http\Controllers;

use App\Models\tipoorg;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class TipoorgController extends Controller
{
   
    public function tipoorg()
    {
        $tipoorgs = tipoorg::all();
        return view('Vistas.tipoorg',compact('tipoorgs'));
    }
    public function create()
    {  
    }

    public function store(Request $request)
    {
        try {  
            // Llamada a la stored procedure  
            DB::statement('call CRtiporg(?)', [  
                $request->input('nombre')  
            ]);  
    
            
            return redirect()->back()->with('swal_success', 'El tipo de organizador se agregó exitosamente!');
        }catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->back()->with('swal_error', 'No se puede ingresar el tipo de organizador ');
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

    public function show(tipoorg $tipoorg)
    {
        
    }

    public function edit($idtipo)
    {
        $tipoorgs = tipoorg::findOrFail($idtipo); 
        return view('Vistas.tipoorg',compact('tipoorgs'));
    }

    public function update(Request $request,$idtipo)
    {
        try {  
            $result = DB::select('CALL MDtiporg(?, ?)', [
                $idtipo,
                $request->input('nombre')
            ]);
            return redirect()->back()->with('swal_success', 'El tipo de organizador se modificó exitosamente!');
         } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                if ($errorCode == 1451) {
                    return redirect()->back()->with('swal_error', 'No se puede modificar el tipo de organizador');
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
    public function destroy($idtipo)
    {
        try {
            $result = DB::select('CALL ELItiporg(?)', [
                $idtipo
            ]);
            return redirect()->back()->with('success', '¡El tipo de organizador se elimino correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->back()->with('swal_error', 'No se puede eliminar el tipo de organizador ');
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
    
        $tipoorgs = tipoorg::where('nombre', 'LIKE', '%' . $query . '%')->get();
    
        $output = '';
        foreach ($tipoorgs as  $index =>$tipoorg) {
            $output .= '<tr>
                            <td>' . ($index + 1) . '</td>
                            <td>' . $tipoorg->nombre . '</td>
                            <td>
                                <div class="btn-group action-buttons">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit' . $tipoorg->idtipo . '"><i class="bi bi-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete' . $tipoorgs->idtipo . '"><i class="bi bi-trash"></i></button>
                                </div>
                            </td>
                        </tr>';
        }
        
    
        return response($output); 
    }
}
