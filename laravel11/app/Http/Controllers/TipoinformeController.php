<?php
namespace App\Http\Controllers;
use App\Models\tipoinforme;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class TipoinformeController extends Controller
{
    public function tipoinforme()
    {
        $tipoinformes = tipoinforme::all();
        return view('Vistas.tipoinforme',compact('tipoinformes'));
    }
    public function create()
    {
        
    }
    public function store(Request $request) {  
        try {  
            DB::statement('call CRTipoinforme(?)', [  
                $request->input('nomtinform')  
            ]);  
    
            
            return back()->with('swal_success', 'El tipo de infome se agregó exitosamente!');
        }catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->back()->with('swal_error', 'No se puede ingresar el tipo de informe ');
            } elseif ($errorCode == 1644) {
                $errorMessage = $e->errorInfo[2];
                return redirect()->back()->with('swal_error', $errorMessage);
            } else {
                return redirect()->back()->with('swal_error', 'Ocurrió un error al intentar insertar ?');
            }
        } 
        catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado al intentar insertar');
        }
    
    }
    public function show(tipoinforme $tipoinforme)
    {
        
    }
    public function edit( $idTipinfor)
    {
        
        $tipoinforme= tipoinforme::findOrFail($idTipinfor); 
        return view('Vistas.tipoinforme', compact('tipoinforme'));
    }
    public function update(Request $request, $idTipinfor)
    {
        try {  
        $result = DB::select('CALL MDTipoinforme(?, ?)', [
            $idTipinfor,
            $request->input('nomtinform')
        ]);
        return redirect()->back()->with('swal_success', 'El tipo de informe se modificó exitosamente!');
     } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->back()->with('swal_error', 'No se puede modificar el tipo de informe ');
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
    public function destroy($idTipinfor)
    {
        try {
        $result = DB::select('CALL ELITipoinforme(?)', [
            $idTipinfor
        ]);
        return redirect()->back()->with('success', '¡El tipo de informe se elimino correctamente');
    } catch (\Illuminate\Database\QueryException $e) {
        $errorCode = $e->errorInfo[1];
        if ($errorCode == 1451) {
            return redirect()->back()->with('swal_error', 'No se puede eliminar el tipo de informe');
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
    
        $tipoinformes = tipoinforme::where('nomtinform', 'LIKE', '%' . $query . '%')->get();
    
        $output = '';
        foreach ($tipoinformes as $index =>$tipoinforme) {
            $output .= '<tr>
                            <td>' . ($index + 1) . '</td>
                            <td>' . $tipoinforme->nomtinform . '</td>
                            <td>
                                <div class="btn-group action-buttons">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit' . $tipoinforme->idTipinfor. '"><i class="bi bi-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete' . $tipoinforme->idTipinfor. '"><i class="bi bi-trash"></i></button>
                                </div>
                            </td>
                        </tr>';
        }
        return response($output); 
    }
    


    
}
