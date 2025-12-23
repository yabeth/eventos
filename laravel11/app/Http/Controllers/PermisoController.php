<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\permiso;
use App\Models\tipousuario;
use App\Models\datosperusu;
use App\Models\genero;
use App\Models\persona;
use Illuminate\Http\Request;
use App\Models\usuario;


class PermisoController extends Controller
{
    public function index()
{
    $tipousuarios = tipousuario::all();
    $usuarios = Usuario::with('permisos')->get();
    $permisos = permiso::all();
    $datosperusus = datosperusu::with('usuario')->get(); 
    $personas = persona::with('genero')->get();
    $generos = genero::all();

    return view('Vistas/usuario', compact( 'permisos','usuarios','tipousuarios','datosperusus', 'personas', 'generos'));
}
    public function abrir()
    {
        return view('Vistas/sinpermiso');
    }

public function storeee(Request $request, $idusuario)
{
    $usuario = Usuario::findOrFail($idusuario);
    $permisosSeleccionados = $request->input('permisos', []);
    $usuario->permisos()->sync($permisosSeleccionados);
     return back()->with('success', 'Permisos actualizados correctamente.');
    return view('Vistas.usuario', compact('usuario', ));

}

public function store(Request $request, $idusuario)
{
    $usuario = Usuario::findOrFail($idusuario);

    // Recibe los permisos seleccionados
    $permisosSeleccionados = $request->input('permisos', []);

    // Actualiza la tabla pivote
    $usuario->permisos()->sync($permisosSeleccionados);

    return back()->with('success', 'Permisos actualizados correctamente.');
}



    public function storeanterior(Request $request, usuario $idusuario)
    {
        $request->validate([
            'nombre_ruta' => 'required',
            'idusuario' => 'required|exists:usuarios,id'
        ]);

        $permiso = Permiso::create(['nombre_ruta' => $request->nombre_ruta]);

        $usuario = Usuario::find($request->idusuario);
        $usuario->permisos()->attach($permiso->id);

        return redirect()->route('Vistas/usuario')->with('success', 'Permiso asignado exitosamente');
    }

    
    public function show(string $id)
    {}

    public function edit(string $id)
    {}

    public function update(Request $request, string $id)
    {}

    public function destroy(string $id)
    {}
}
