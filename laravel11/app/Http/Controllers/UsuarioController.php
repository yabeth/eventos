<?php

namespace App\Http\Controllers;

use App\Models\tipousuario;
use App\Models\usuario;
use App\Models\genero;
use App\Models\permiso;
use App\Models\persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UsuarioController extends Controller
{
    public function usuario()
    {
        $tipousuarios = tipousuario::all();
        $personas = persona::with('genero')->get();
        $generos = genero::all();
        $usuarios = usuario::with(['tipousuario', 'persona.genero'])->get();
        $permisos = permiso::all();

        return view('Vistas.usuario', compact('usuarios', 'tipousuarios', 'personas', 'generos', 'permisos'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nomusu' => 'required|string|max:45',
        'pasword' => 'required|string|max:45',
        'idTipUsua' => 'required|integer',
        'fecemi' => 'required|date',
        'ubigeo' => 'required|string|max:6',
        'dni' => 'required|string|max:8',
        'apell' => 'required|string|max:45',
        'nombre' => 'required|string|max:45',
        'direc' => 'required|string|max:45',
        'email' => 'required|email|max:45',
        'tele' => 'required|string|max:11',
        'idgenero' => 'required|integer'
    ]);

    try {
        DB::statement('CALL CRusuario(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->nomusu,
            $request->pasword,
            $request->idTipUsua,
            $request->fecemi,
            $request->ubigeo,
            $request->dni,
            $request->apell,
            $request->nombre,
            $request->direc,
            $request->email,
            $request->tele,
            $request->idgenero
        ]);

        return redirect()->route('Rutususario')
            ->with('success', 'Usuario agregado correctamente');

    } catch (\Illuminate\Database\QueryException $e) {

        if (($e->errorInfo[1] ?? null) == 1644) {
            return redirect()->back()
                ->withInput()
                ->with('swal_error', $e->errorInfo[2]);
        }

        return redirect()->back()
            ->withInput()
            ->with('swal_error', 'Error al crear el usuario');
    }
}


    public function update(Request $request, $idusuario)
    {
        $request->validate([
            'nomusu' => 'required|string|max:45',
            'idTipUsua' => 'required|integer',
            'ubigeo' => 'nullable|string|max:6',
            'fecemi' => 'nullable|date',
            'dni' => 'required|string|max:8',
            'nombre' => 'required|string|max:45',
            'apell' => 'required|string|max:45',
            'tele' => 'required|string|max:11',
            'email' => 'required|email|max:45',
            'direc' => 'required|string|max:45',
            'idgenero' => 'required|integer'
        ]);

        try {
            $password = $request->filled('pasword') && $request->pasword !== ''
                ? $request->pasword
                : null;

            $ubigeo = $request->filled('ubigeo') && $request->ubigeo !== ''
                ? $request->ubigeo
                : null;

            $fecha = $request->filled('fecemi') && $request->fecemi !== ''
                ? $request->fecemi
                : null;

            DB::statement('CALL CRrecucontra(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $idusuario,
                $ubigeo,
                $fecha,
                $request->nomusu,
                $password,
                $request->idTipUsua,
                $request->dni,
                $request->nombre,
                $request->apell,
                $request->tele,
                $request->email,
                $request->direc,
                $request->idgenero
            ]);

            return redirect()->route('Rutususario')->with('success', 'Usuario actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('swal_error', 'Error al actualizar: Datos duplicados o invalidos');
        }
    }

    public function destroy($idusuario)
    {
        try {
            $result = DB::select('CALL EliminarUsuario(?)', [$idusuario]);

            return redirect()->route('Rutususario')->with('success', 'Usuario eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'No se pudo eliminar el usuario');
        }
    }

    public function buscar(Request $request)
    {
        $query = $request->input('search');

        $usuarios = usuario::where('nomusu', 'LIKE', '%' . $query . '%')
            ->orWhereHas('tipousuario', function ($q) use ($query) {
                $q->where('tipousu', 'LIKE', '%' . $query . '%');
            })
            ->with(['tipousuario', 'persona.genero'])
            ->get();

        $output = '';
        foreach ($usuarios as $index => $usu) {
            $output .= '<tr>
                <td>' . ($index + 1) . '</td>
                <td>' . e($usu->nomusu) . '</td>
                <td>' . e($usu->tipousuario->tipousu ?? '') . '</td>
                <td>' . e($usu->fechaemision ?? '') . '</td>
                <td>' . e($usu->persona->dni ?? '') . '</td>
                <td>' . e($usu->persona->apell ?? '') . ' ' . e($usu->persona->nombre ?? '') . '</td>
                <td>' . e($usu->persona->tele ?? '') . '</td>
                <td>' . e($usu->persona->genero->nomgen ?? '') . '</td>
                <td>
                    <div class="btn-group action-buttons">
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit' . $usu->idusuario . '">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete' . $usu->idusuario . '">
                            <i class="bi bi-trash"></i>
                        </button>
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" onclick="cargarPermisos(' . $usu->idusuario . ')" data-target="#permiso' . $usu->idusuario . '">
                            <i class="bi bi-shield-check"></i>
                        </button>
                    </div>
                </td>
            </tr>';
        }

        return response($output);
    }

    public function validateUser(Request $request)
    {
        $request->validate([
            'dni' => 'required|string',
            'ubigeo' => 'required|string',
            'fecemi' => 'required|date'
        ]);

        $user = Usuario::whereHas('persona', function ($query) use ($request) {
            $query->where('dni', $request->dni);
        })
            ->where('ubigeo', hash('sha256', $request->ubigeo))
            ->where('fechaemision', $request->fecemi)
            ->first();

        return response()->json(['valid' => $user !== null]);
    }

    public function updateUser(Request $request)
    {
        $request->validate([
            'dni' => 'required|string',
            'newUsername' => 'required|string|max:255',
            'newPassword' => 'required|string',
        ]);

        $usuario = usuario::whereHas('persona', function ($query) use ($request) {
            $query->where('dni', $request->dni);
        })->first();

        if ($usuario) {
            try {
                $result = DB::select('CALL actualizarusu(?, ?, ?)', [
                    $usuario->idusuario,
                    $request->input('newUsername'),
                    $request->input('newPassword')
                ]);

                $message = $result[0]->message ?? 'Usuario actualizado correctamente';

                return response()->json(['success' => true, 'message' => $message]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el usuario'
                ]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Usuario no encontrado']);
    }


    public function buscarPersonaPorDni($dni)
{
    // Validar que sea exactamente 8 dígitos numéricos
    if (!preg_match('/^\d{8}$/', $dni)) {
        return response()->json(null, 400);
    }

    $persona = DB::table('personas')
        ->where('dni', $dni)
        ->select(
            'idpersona',
            'nombre',
            'apell',
            'tele',
            'email',
            'direc',
            'idgenero'
        )
        ->first();

    if (!$persona) {
        return response()->json(null); // No encontrada → limpia campos
    }

    return response()->json([
        'idpersona' => $persona->idpersona,
        'nombre'    => $persona->nombre ?? '',
        'apell'     => $persona->apell ?? '',
        'tele'      => $persona->tele ?? '',
        'email'     => $persona->email ?? '',
        'direc'     => $persona->direc ?? '',
        'idgenero'  => $persona->idgenero ?? ''
    ]);
}


}
