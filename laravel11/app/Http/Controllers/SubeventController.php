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
use DB;
class SubeventController extends Controller
{

   public function subevent()
    {
    $eventos = evento::all();
    $personas = persona::all();
    $modalidades = modalidad::all();
    $canales = canal::with(['modalidad'])->get();
    $subevents = subevent::with(['evento', 'canal', 'asignarponentes.persona'])->get();
    return view('Vistas.subevent', compact('eventos', 'canales', 'subevents', 'modalidades', 'personas'));
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

    public function update(Request $request, subevent $subevent)
    {
        
    }

    public function destroy(subevent $subevent)
    {
    
    }
}
