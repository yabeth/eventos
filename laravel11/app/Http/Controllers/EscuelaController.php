<?php

namespace App\Http\Controllers;

use App\Models\facultad;
use App\Models\escuela;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class EscuelaController extends Controller
{
    
    public function escuela() {
        $facultads = facultad::all();
        $escuelas = escuela::with('facultad')->get(); // Sin paginación
        return view('Vistas.escuela', compact('facultads', 'escuelas'));
    }

    public function create()
    {
        
    }

    public function store(Request $request) {
        try {
        DB::statement('CALL CRescuela(?, ?)', [
            $request->input('nomescu'),
            $request->input('idfacultad')
        ]);
        return redirect()->back()->with('success', 'La escuela se agrego exitosamente!');
    
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


    public function show(escuela $escuela)
    {
        
    }
    public function edit($idescuela){
        $escuela = Evento::findOrFail($idescuela); // Encuentra el evento por ID
        $facultads = tipoevento::all();
        return view('Vistas.escuela', compact('facultads', 'escuela'));
    }
    
    public function update(Request $request,$idescuela) {
      
        try {
        $result = DB::select('CALL MODescuel(?, ?, ?)', [
            $idescuela,
            $request->input('nomescu'),
            $request->input('idfacultad')
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

    public function buscar(Request $request) {
        $query = $request->input('search'); 
        $escuelas = escuela::where('nomescu', 'LIKE', '%' . $query . '%')
                            ->orWhereHas('facultad', function($q) use ($query) {
                                $q->where('nomfac', 'LIKE', '%' . $query . '%');
                            })
                            ->get();

        $output = '';
        foreach ($escuelas as $escu) {
            $output .= '<tr>
                            <td>' . $escu->facultad->nomfac . '</td>
                            <td>' . $escu->nomescu . '</td>
                            <td>
                                <div class="action-buttons">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit' . $escu->idescuela . '"><i class="bi bi-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete' . $escu->idescuela . '"><i class="bi bi-trash"></i></button>
                                </div>
                            </td>
                        </tr>';
        }
        return response($output); 
    }


    public function destroy($idescuela) {
        try {
        $result = DB::select('CALL ELIescue(?)', [
            $idescuela
        ]);
        $message = $result[0]->{'La escuela se eliminó correctamente'} ?? 'La escuela no se puede eliminar';
        return redirect()->back()->with('success', $message);
    } catch (\Illuminate\Database\QueryException $e) {
        $errorCode = $e->errorInfo[1];
        if ($errorCode == 1451) {
            return redirect()->back()->with('swal_error', 'No se puede eliminar  existen tablas relacionadas');
        } elseif ($errorCode == 1644) {
            $errorMessage = $e->errorInfo[2];
            return redirect()->back()->with('swal_error', $errorMessage);
        } else {
            return redirect()->back()->with('swal_error', 'Ocurrió un error al intentar eliminar la escuela');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado al intentar eliminar la escuela');
    }
    }
}
