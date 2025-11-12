<?php

namespace App\Http\Controllers;

use App\Models\subevent;
use App\Models\evento;
use App\Models\persona;
use App\Models\genero;
use App\Models\canal;
use App\Models\modalidad;
use App\Models\asignarponent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Ensure Log is imported
class SubeventController extends Controller
{

   public function subevent()
    {
    $eventos = evento::all();
    $personas = persona::all();
    $generos = genero::all();
    $modalidades = modalidad::all();
    $canales = canal::with(['modalidad'])->get();
    $subevents = subevent::with(['evento', 'canal', 'asignarponentes.persona'])->get();
    return view('Vistas.subevent', compact('eventos', 'canales', 'subevents', 'modalidades', 'personas','generos'));
    }
    public function create()
    {
        
    }

  public function store(Request $request)
{
    try {
        // Verificar si hay múltiples subeventos
        $subeventos = $request->input('subeventos');
        
        if ($subeventos && is_array($subeventos)) {
            $contador = 0;
            
            // Procesar múltiples subeventos
            foreach ($subeventos as $subevento) {
                // Obtener nombre de modalidad según ID
                $modalidad = modalidad::find($subevento['modalidad']);
                $modalidadNombre = $modalidad ? $modalidad->modalidad : null;
                
                if (!$modalidadNombre) {
                    throw new \Exception('Modalidad no encontrada');
                }
                
                // Obtener nombre del canal según ID
                $canal = canal::find($subevento['canal_id']);
                $canalNombre = $canal ? $canal->canal : null;
                
                if (!$canalNombre) {
                    throw new \Exception('Canal no encontrado');
                }
                
                // Llamar al procedimiento almacenado
                DB::statement('CALL CRsubevento(?,?,?,?,?,?,?,?)', [  
                    $subevento['fecha'],  
                    $subevento['hora_inicio'],
                    $subevento['hora_fin'],
                    $subevento['descripcion'],
                    $request->input('idTipoeven'),
                    $subevento['url'] ?? null,
                    $modalidadNombre,
                    $canalNombre
                ]);
                
                $contador++;
            }
            
            return redirect()->back()->with('swal_success', "Se agregaron $contador sub-evento(s) exitosamente!");
            
        } else {
            return redirect()->back()->with('swal_error', 'No se recibieron datos de subeventos');
        }
        
    } catch (\Illuminate\Database\QueryException $e) {
        $errorCode = $e->errorInfo[1] ?? null;
        
        if ($errorCode == 1451) {
            return redirect()->back()->with('swal_error', 'No se puede registrar debido a restricciones de clave foránea');
        } elseif ($errorCode == 1644) {
            $errorMessage = $e->errorInfo[2];
            return redirect()->back()->with('swal_error', $errorMessage);
        } else {
            return redirect()->back()->with('swal_error', 'Error en base de datos: ' . $e->getMessage());
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('swal_error', 'Error: ' . $e->getMessage());
    }
}

    public function show(subevent $subevent)
    {
        
    }

    public function edit(subevent $subevent)
    {
        
    }


    public function update(Request $request, $idsubevent) {
        try {
            $result = DB::select('CALL MDsubevento(?, ?, ?, ?, ?, ?, ?, ?)', [
                $idsubevent,
                $request->input('fechsubeve'),
                $request->input('horini'),
                $request->input('horfin'),
                $request->input('Descripcion'),
                $request->input('url'),
                $request->input('idmodal'),
                $request->input('idcanal')
                
            ]);

            $message = $result[0]->{'Se modifico correctamente'} ?? 'El evento se modificó correctamente';
            return redirect()->back()->with('swal_success', $message);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1644) {
                $errorMessage = $e->errorInfo[2];
                return redirect()->back()->with('swal_error', $errorMessage);
            } elseif ($errorCode == 1062) {
                return redirect()->back()->with('swal_error', 'El evento puede generar duplicidad');
            } else {
                return redirect()->back()->with('swal_error', 'Ocurrió un error al modificar el evento');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado');
        }
    }
  

public function updateponent(Request $request, $idasig) {
    try {
        // Validar datos
        $request->validate([
            'dni' => 'required|max:15',
            'nombre' => 'required|max:100',
            'apell' => 'required|max:100',
            'tele' => 'required|max:20',
            'email' => 'required|email|max:100',
            'direc' => 'required|max:150',
            'idgenero' => 'required|integer'
        ]);

        // Obtener el DNI actual del ponente (para que el procedimiento lo encuentre)
        $ponente = DB::selectOne('
            SELECT p.dni, ap.idsubevent
            FROM asignarponent ap
            INNER JOIN persona p ON ap.idpersona = p.idpersona
            WHERE ap.idasig = ?
        ', [$idasig]);
        
        if (!$ponente) {
            return redirect()->back()->with('swal_error', 'No se encontró el ponente');
        }

        // Llamar al procedimiento con el DNI actual (para que lo encuentre por WHERE dni = dnis)
        DB::statement('CALL MDasignarponent(?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->input('dni'),         // dnis - DNI para buscar Y actualizar
            $request->input('nombre'),      // nombres
            $request->input('apell'),       // apells
            $request->input('tele'),        // teles
            $request->input('email'),       // emails
            $request->input('direc'),       // direcs
            $request->input('idgenero'),    // idgeneros
            $ponente->idsubevent            // idsubevents
        ]);

        return redirect()->back()->with('swal_success', 'El ponente se modificó correctamente');
        
    } catch (\Illuminate\Database\QueryException $e) {
        $errorCode = $e->errorInfo[1] ?? null;
        
        if ($errorCode == 1644) {
            $errorMessage = $e->errorInfo[2];
            return redirect()->back()->with('swal_error', $errorMessage);
        } elseif ($errorCode == 1062) {
            return redirect()->back()->with('swal_error', 'El DNI ya está registrado');
        } else {
            \Log::error('Error al modificar ponente:', [
                'error' => $e->getMessage(),
                'idasig' => $idasig
            ]);
            return redirect()->back()->with('swal_error', 'Ocurrió un error al modificar el ponente');
        }
        
    } catch (\Exception $e) {
        \Log::error('Error inesperado:', ['error' => $e->getMessage()]);
        return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado: ' . $e->getMessage());
    }
}


   public function destroy($idsubevent) {


        try {
            $result = DB::select('CALL EliSubevento(?)', [$idsubevent]);

            $message = $result[0]->{'Se eliminó correctamente'} ?? 'Se eliminó correctamente';
            return redirect()->back()->with('swal_success', $message);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return redirect()->back()->with('swal_error', 'No se puede eliminar el evento porque está siendo utilizado en otras partes del sistema');
            } elseif ($errorCode == 1644) {
                $errorMessage = $e->errorInfo[2];
                return redirect()->back()->with('swal_error', $errorMessage);
            } else {
                return redirect()->back()->with('swal_error', 'Ocurrió un error al intentar eliminar');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'Ocurrió un error inesperado al intentar eliminar');
        }
 }

public function obtenerPonentesPorSubevento($idsubevent) 
    {
        try {
            $ponentes = DB::select('
                SELECT 
                    ap.idasig,
                    p.dni,
                    p.nombre,
                    p.apell,
                    p.tele,
                    p.email,
                    p.direc,
                    p.idgenero,
                    g.nomgen as genero
                FROM asignarponent ap
                INNER JOIN persona p ON ap.idpersona = p.idpersona
                INNER JOIN genero g ON p.idgenero = g.idgenero
                WHERE ap.idsubevent = ?
            ', [$idsubevent]);
            
            return response()->json([
                'success' => true,
                'ponentes' => $ponentes
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }}

  
}
