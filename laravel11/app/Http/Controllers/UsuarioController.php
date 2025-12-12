<?php

namespace App\Http\Controllers;
use App\Models\tipousuario;
use App\Models\usuario;
use App\Models\datosperusu;
use App\Models\genero;
use App\Models\permiso;
use Illuminate\Support\Facades\Auth;
use App\Models\persona;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use DB;

class UsuarioController extends Controller
{
    // UsuarioController.php
public function usuario()
{
    $tipousuarios = tipousuario::all();
    $personas = persona::with('genero')->get();
    $generos = genero::all();
    $usuarios = usuario::with(['tipousuario', 'persona'])->get();
    $permisos = permiso::all();
    return view('Vistas.usuario', compact('usuarios', 'tipousuarios', 'personas', 'generos','permisos'));
}

    public function showForm()
{
    $user = auth()->user(); 

    $userData = $user->datosPersonales ?? null;

    return view('Vistas.usuario', compact('userData'));
}
    public function create()
    {
    }
    public function store(Request $request)
    { 
        try {
                DB::statement('CALL CRusuario(?, ?, ?, ?, ?, ?,?,?,?,?,?,?)', [
                $request->input('nomusu'),
                $request->input('pasword'),
                $request->input('idTipUsua'),
                $request->input('fecemi'),
                $request->input('ubigeo'),
                $request->input('dni'),
                $request->input('apell'),
                $request->input('nombre'),
                $request->input('direc'),
                $request->input('email'),
                $request->input('tele'),
                $request->input('idgenero')
            ]);
        
            return redirect()->back()->with('success', 'Se ingresó correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1644) {
                return redirect()->back()->with('swal_error', 'El DNI '.$request->input('dniu').' ya esta en uso con otro Usuario');
            }
    
            throw $e;
        }
    }
    public function show(usuario $usuario)
    {  
    }
    public function edit($idusuario)
    {
        $usuarios = usuario::findOrFail($idusuario); 
        $tipousuarios = tipousuario::all();
        return view('Vistas.usuario', compact('usuarios', 'tipousuarios'));
    }
    public function update(Request $request,$idusuario)
    {
      
            $result = DB::select('CALL CRrecucontra(?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?)', [
                $idusuario,
                $request->input('ubigeo'),
                $request->input('fecemi'),
                $request->input('nomusu'),
                $request->input('pasword'),
                $request->input('idTipUsua'),
                $request->input('dni'),
                $request->input('nombre'),
                $request->input('apell'),
                $request->input('tele'),
                $request->input('email'),
                $request->input('direc'),
                $request->input('idgenero')

            ]);
    
            $message = $result[0]->{'Mensaje para el mismo usuario'} ?? 'El usuario actualizó su propio perfil correctamente';
    
         
        return redirect()->back()->with('success', $message);
    }
    public function destroy($idusuario)
    {
        $result = DB::select('CALL EliminarUsuario(?)', [
            $idusuario
        ]);
        $message = $result[0]->{'El usuario se eliminó correctamente'} ?? 'El usuario no se puede eliminar';
        return redirect()->back()->with('success', $message);
    }

    public function buscar(Request $request)
    {
        $query = $request->input('search'); 
    
        $usuarios = usuario::where('nomusu', 'LIKE', '%' . $query . '%')
                            ->orWhereHas('tipousuario', function($q) use ($query) {
                                $q->where('tipousu', 'LIKE', '%' . $query . '%');
                            })
                            ->get();
    
        $output = '';
        foreach ($usuarios as $usu) {
            $output .= '<tr>
            <td>
                <div class="btn-group action-buttons">
                    <button 
                        class="btn btn-success btn-sm"  
                        data-bs-toggle="modal" 
                        data-bs-target="#datosEmployeeModl"
                        data-dni="' . ($usu->datosperusu->persona->dni ?? '') . '" 
                        data-nombre="' . ($usu->datosperusu->persona->nombre ?? '') . '" 
                        data-apellido="' . ($usu->datosperusu->persona->apell ?? '') . '" 
                        data-direc="' . ($usu->datosperusu->persona->direc ?? '') . '" 
                        data-email="' . ($usu->datosperusu->persona->email ?? '') . '"
                        data-tele="' . ($usu->datosperusu->persona->tele ?? '') . '" 
                        data-idgenero="' . ($usu->datosperusu->persona->genero->nomgen ?? '') . '" 
                        data-nomusu="' . $usu->nomusu . '"
                        data-pasword="' . $usu->pasword . '"
                        data-idTipUsua="' . ($usu->tipousuario->tipousu ?? '') . '" 
                    >
                        Datos
                    </button>
                </div>
            </td>
            <td>' . $usu->nomusu . '</td>
            <td>' . ($usu->tipousuario->tipousu ?? '') . '</td>
            <td>
                <div class="btn-group action-buttons">
                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit' . $usu->idusuario . '"><i class="bi bi-pencil"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete' . $usu->idusuario . '"><i class="bi bi-trash"></i></button>
                </div>
            </td>
        </tr>';
    
        }
    
        return response($output); 
    }



    public function updateUser(Request $request)
{
    $request->validate([
        'dni' => 'required|string',
        'newUsername' => 'required|string|max:255',
        'newPassword' => 'required|string',
    ]);

    $usuario = usuario::whereHas('persona', function($query) use ($request) {
        $query->where('dni', $request->dni);
    })->first();

    if ($usuario) {
        try {
            $result = DB::select('CALL actualizarusu(?, ?, ?)', [
                $usuario->idusuario,
                $request->input('newUsername'),
                $request->input('newPassword')
            ]);

            if (!empty($result) && isset($result[0]->message)) {
                $message = $result[0]->message;
            } else {
                $message = 'No se recibió respuesta del procedimiento almacenado.';
            }

            return response()->json(['success' => true, 'message' => $message]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar el usuario: ' . $e->getMessage()]);
        }

    } else {
        return response()->json(['success' => false, 'message' => 'Usuario no encontrado.']);
    }
}

public function validateUser(Request $request)
{
    // Validar entrada
    $request->validate([
        'dni' => 'required|string',
        'ubigeo' => 'required|string',
        'fecemi' => 'required|date'
    ]);

    $user = Usuario::whereHas('persona', function($query) use ($request) {
        $query->where('dni', $request->dni);
    })
    ->where('ubigeo', hash('sha256', $request->ubigeo))  // SHA-256
    ->where('fechaemision', $request->fecemi)
    ->first();

    return response()->json(['valid' => $user !== null]);
}




}
