<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;

class SubirimagenController extends Controller
{
    public function index()
    {
        // Obtener todas las imágenes
        $imagenes = Imagen::all();
        return view('Vistas.subirimagen', compact('imagenes'));
    }

    
    // Función para almacenar una nueva imagen
    public function store(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
    
        $imagenArchivo = $request->file('imagen');
        $nombreImagen = time() . '_' . $imagenArchivo->getClientOriginalName();
    
        // Validar las dimensiones de la imagen
        list($ancho, $alto) = getimagesize($imagenArchivo);
        if ($ancho == 1184 && $alto == 447) {
            // Guardar la imagen en la carpeta 'uploads' en public
            $imagenArchivo->move(public_path('uploads'), $nombreImagen);
    
            $imagen = new Imagen();
            $imagen->nombre_imagen = $nombreImagen;
            $imagen->ruta_imagen = 'uploads/' . $nombreImagen;
            $imagen->save();
    
            // Retornar respuesta JSON para AJAX con SweetAlert
            return response()->json(['success' => true, 'message' => 'La imagen ha sido registrada correctamente.']);
        } else {
            return response()->json(['success' => false, 'message' => 'La imagen debe tener un tamaño de 1200px de ancho y 455px de alto.']);
        }
    }


    // Función para eliminar una imagen
    public function destroy($id)
    {
        $imagen = Imagen::findOrFail($id);
    
        // Ruta completa del archivo en 'uploads' dentro de 'public'
        $rutaImagen = public_path('uploads/' . $imagen->nombre_imagen);
        
        // Verificar si el archivo existe y eliminarlo
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
                    'message' => 'Error al eliminar el archivo de la carpeta.'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Archivo no encontrado en la carpeta.'
            ]);
        }
    }
} 
