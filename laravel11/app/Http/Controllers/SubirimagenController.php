<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;

class SubirimagenController extends Controller
{
    public function index()
    {
        $imagenes = Imagen::all();
        return view('Vistas.subirimagen', compact('imagenes'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre_imagen' => 'required|string|max:255',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
        
        $nombreUsuario = $request->input('nombre_imagen');
        $imagenArchivo = $request->file('imagen');
        
        list($ancho, $alto) = getimagesize($imagenArchivo);
        if ($ancho == 1200 && $alto == 455) { 
            $extension = $imagenArchivo->getClientOriginalExtension();
            $nombreArchivoUnico = time() . '_' . uniqid() . '.' . $extension;
            $imagenArchivo->move(public_path('uploads'), $nombreArchivoUnico);
            $imagen = new Imagen();
            $imagen->nombre_imagen = $nombreUsuario;
            $imagen->ruta_imagen = 'uploads/' . $nombreArchivoUnico;
            $imagen->save();
            return response()->json([
                'success' => true, 
                'message' => 'La imagen **' . $nombreUsuario . '** ha sido registrada correctamente.'
            ]);
            
        } else {
            return response()->json([
                'success' => false, 
                'message' => "La imagen debe tener un tamaño exacto de 1200px de ancho y 455px de alto. (Dimensiones subidas: {$ancho}x{$alto})"
            ]);
        }
    }

    public function destroy($id)
    {
        $imagen = Imagen::findOrFail($id);
        
        $rutaImagen = public_path($imagen->ruta_imagen);
        if (file_exists($rutaImagen)) {
            if (unlink($rutaImagen)) {
                $imagen->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Imagen eliminada exitosamente.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el archivo de la carpeta. Verifique permisos.'
                ]);
            }
        } else {
            $imagen->delete();
            return response()->json([
                'success' => true,
                'message' => 'Registro de BD eliminado. Archivo no encontrado en la carpeta.'
            ]);
        }
    }
}