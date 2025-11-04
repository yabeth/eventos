<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);


use App\Models\facultad;
use App\Models\escuela;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class FacultadController extends Controller
{
    public function facultad()
    {
        $facultads=facultad::all();
        return view('Vistas.facultad',compact('facultads'));
    }
    public function create()
    {
        
    }
    public function store(Request $request) {
        try {
        
        DB::statement('CALL CRfacultad(?)', [
            $request->input('nomfac')
        ]); 
        return redirect()->back()->with('success', '¡Facultad agregada exitosamente!');
     
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

    public function show(facultad $facultad)
    {
        
    }
    public function edit($idfacultad)
    {
        $facultad = facultad::findOrFail($idfacultad); 
        return view('Vistas.facultad', compact('facultad'));
        
    }
    public function update(Request $request, $idfacultad)
    {
        try {
        $result = DB::select('CALL MODfacultad(?, ?)', [
            $idfacultad,
            $request->input('nomfac')
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
            return redirect()->back()->with('swal_error', 'Ocurrió un error al intentar insertar ?');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado al intentar insertar');
    }
    }
    public function destroy($idfacultad) {
        try {
        $result = DB::select('call ELIfacu(?)', [$idfacultad]);
        return redirect()->back()->with('success', '¡Se elimino correctamente');
         } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->back()->with('swal_error', 'No se puede eliminar la facultad porque existen escuelas relacionadas');
            } elseif ($errorCode == 1644) {
                $errorMessage = $e->errorInfo[2];
                return redirect()->back()->with('swal_error', $errorMessage);
            } else {
                return redirect()->back()->with('swal_error', 'Ocurrió un error al intentar eliminar la facultad');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado al intentar eliminar la facultad');
        }
    
    }
    

    public function buscar(Request $request) {
        $query = $request->input('search'); 

        $facultads = facultad::where('nomfac', 'LIKE', '%' . $query . '%') ->get();

        $output = '';
        foreach ($facultads as $facultad) {
            $output .= '<tr>
                        <td>' . $facultad->nomfac . '</td>
                        <td>
                            <div class="btn-group action-buttons">
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit' . $facultad->idfacultad . '"><i class="bi bi-pencil"></i></button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete' . $facultad->idfacultad . '"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>';
        }
        return response($output); 
    }


}
