<?php

namespace App\Http\Controllers;
use App\Models\tipoorg;
use App\Models\organizador;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class OrganizadorController extends Controller
{
   
    public function organizador()
    {
        $tipoorgs = tipoorg::all();
        $organizadors = organizador::with('tipoorg')->get(); 
        return view('Vistas.organizador', compact('tipoorgs', 'organizadors'));
    }

    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        try {
            DB::statement('CALL CRorgn(?, ?)', [
                $request->input('nombreor'),
                $request->input('idtipo')
            ]);
            return redirect()->back()->with('success', 'El organizador se agrego exitosamente!');
        
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->back()->with('swal_error', 'No se puede ingresar ');
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

    
    public function show(organizador $organizador)
    {
        
    }

    
    public function edit(organizador $organizador)
    {
        
    }

    public function update(Request $request, $idorg)
    {
        try {
            $result = DB::select('CALL MDorgn(?, ?, ?)', [
                $idorg,
                $request->input('nombreor'),
                $request->input('idtipo')
            ]);
            return redirect()->back()->with('success', '¡Se modifico exitosamente!');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->back()->with('swal_error', 'No se puede modificar');
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

    public function destroy($idorg)
    {
        try {
            $result = DB::select('CALL ELIorg(?)', [
                $idorg
            ]);
            $message = $result[0]->{'El organizador se eliminó correctamente'} ?? 'El organizador no se puede eliminar';
            return redirect()->back()->with('success', $message);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->back()->with('swal_error', 'No se puede eliminar  existen tablas relacionadas');
            } elseif ($errorCode == 1644) {
                $errorMessage = $e->errorInfo[2];
                return redirect()->back()->with('swal_error', $errorMessage);
            } else {
                return redirect()->back()->with('swal_error', 'Ocurrió un error al intentar eliminar al organizador');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado al intentar eliminar al organizador');
        }  
    }
}
