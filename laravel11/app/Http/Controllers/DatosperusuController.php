<?php

namespace App\Http\Controllers;
use App\Models\usuario;
use App\Models\datosperusu;
use App\Models\persona;
use App\Models\genero;
use App\Models\tipousuario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use DB;

class DatosperusuController extends Controller
{
    
    public function datosperusu()
    {
        $usuarios = usuario::all();
        $personas = persona::all();
        $personas= persona::with('genero')->get();
        $generos = genero::all();
        $usuarios= usuario::with('tipousuario')->get();
        $tipousuarios= tipousuario::all();
        $datosperusus = datosperusu::with(['usuario','usuario.tipousuario','persona','persona.genero'])->paginate(4);
        return view('Vistas.datosperusu', compact('usuarios', 'datosperusus','personas','tipousuarios','personas','generos'));
    }
    public function create()
    {
       
    }

    public function store(Request $request)
    {
          DB::statement('CALL CRusuperso(?,?,?,?,?,?,?,?,?,?)', [
            $request->input('dni'),
            $request->input('apell'),
            $request->input('direc'),
            $request->input('email'),
            $request->input('idgenero'),
            $request->input('nombre'),
            $request->input('tele'),
            $request->input('nomusu'),
            $request->input('pasword'),
            $request->input('idTipUsua')
        ]);
        return redirect()->back()->with('success','Se Registro correctamente');
    }
    public function show(datosperusu $datosperusu)
    {    
    }
    public function edit($idatosPer)
    {
        $usuarios = usuario::all();
        $personas = persona::all();
        $personas= persona::with('genero')->get();
        $generos = genero::all();
        $usuarios= usuario::with('tipousuario')->get();
        $tipousuarios= tipousuario::all();
        $datosperusus = datosperusu::findOrFail($idatosPer);
        return view('Vistas.datosperusu', compact('usuarios', 'datosperusus','personas','tipousuarios','personas','generos'));
    }
    public function update(Request $request, $idatosPer)
    {
        $result = DB::select('CALL MDusuperso(?,?,?,?,?,?,?,?,?,?,?)', [
            $idatosPer,
            $request->input('dni'),
            $request->input('apell'),
            $request->input('direc'),
            $request->input('email'),
            $request->input('idgenero'),
            $request->input('nombre'),
            $request->input('tele'),
            $request->input('nomusu'),
            $request->input('pasword'),
            $request->input('idTipUsua')
        ]);
        $message = $result[0]->{'Se modifico correctamente'} ?? 'Los datos pueden generar duplicidad';
        return redirect()->back()->with('success', $message);
        

    }
    public function destroy($idatosPer)
    {
        $result = DB::select('CALL EliminarUsudata(?)', [
            $idatosPer
        ]);
        $message = $result[0]->{'El usuario se eliminó correctamente'} ?? 'El usuario no se puede eliminar';
        return redirect()->back()->with('success', $message);
    }

    public function buscar(Request $request)
    {
        $query = $request->input('search'); 
    
        $datosperusus = datosperusu::whereHas('persona', function($q) use ($query) {
            $q->where(function($subQuery) use ($query) {
                $subQuery->where('dni', 'LIKE', "%{$query}%")
                    ->orWhere('nombre', 'LIKE', "%{$query}%")
                    ->orWhere('apell', 'LIKE', "%{$query}%")
                    ->orWhere('tele', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%");
            });
        })->orWhereHas('usuario', function($q) use ($query) {
            $q->where('nomusu', 'LIKE', "%{$query}%");
        })->get();
        
    
        $output = '';
        foreach ($datosperusus as $dat) {
            $output .= '<tr>
            <td>' . $dat->persona->dni . '</td>
            <td>' . $dat->persona->apell . ' ' . $dat->persona->nombre . '</td>
            <td>' . $dat->persona->direc . '</td>
            <td>' . $dat->persona->email . '</td>
            <td>' . $dat->persona->tele . '</td>
            <td>' . $dat->persona->genero->nomgen . '</td>
            <td>' . $dat->usuario->tipousuario->tipousu . '</td>
            <td>' . $dat->usuario->nomusu . '</td>
            <td>
                <div class="btn-group action-buttons">
                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit' . $dat->idatosPer . '"><i class="bi bi-pencil"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete' . $dat->idatosPer . '"><i class="bi bi-trash"></i></button>
                </div>
            </td>
        </tr>';
        
        }
    
        return response($output); 
    }
}
