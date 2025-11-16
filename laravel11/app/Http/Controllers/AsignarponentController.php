<?php

namespace App\Http\Controllers;
use App\Models\subevent;
use App\Models\persona;
use App\Models\canal;
use App\Models\modalidad;
use App\Models\evento;
use App\Models\genero;
use App\Models\asignarponent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsignarponentController extends Controller
{
    
    public function asignarponent()
    {
        $eventos = evento::all();
        $subevents = subevent::with(['evento'])->get();
        $generos = genero::all();
        $personas = persona::with(['genero'])->get();
        $modalidades = modalidad::all();
        $canales = canal::with(['modalidad'])->get();
        $asignarponents = asignarponent::with(['subevent','persona.genero','subevent.canal','subevent.canal.modalidad','subevent.evento'])->get();
        return view('Vistas.asignarponent', compact('subevents', 'generos', 'personas', 'asignarponents','canales','modalidades', 'eventos')); 
    }

    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        
    }

    
    public function show(asignarponent $asignarponent)
    {
        
    }

    public function edit(asignarponent $asignarponent)
    {
        
    }

   
    public function update(Request $request, asignarponent $asignarponent)
    {
        
    }

   
    public function destroy(asignarponent $asignarponent)
    {
        
    }
    
    public function cargarPonentes(Request $request)
    {
    try {
        $idsubevent = $request->idsubevent;
        
        // Obtener todos los ponentes de ese subevento
        $ponentes = DB::select("
            SELECT a.idasig, p.idpersona, p.dni, p.nombre, p.apell, p.tele, p.email, p.direc, p.idgenero
            FROM personas p
            INNER JOIN asignarponent a ON p.idpersona = a.idpersona
            WHERE a.idsubevent = ?
            ORDER BY p.apell, p.nombre
        ", [$idsubevent]);
        
        return response()->json([
            'success' => true,
            'ponentes' => $ponentes
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al cargar ponentes: ' . $e->getMessage()
        ], 500);
    }
    }

    public function filtrarPorEvento(Request $request)
    {
    try {
        $idevento = $request->idevento;

        // Obtener TODOS los subeventos del evento seleccionado
        $subeventos = subevent::with([
            'canal.modalidad',
            'evento',
            'asignarponentes.persona'
        ])
        ->where('idevento', $idevento)
        ->orderBy('fechsubeve')
        ->orderBy('horini')
        ->get();

        return response()->json([
            'success' => true,
            'subeventos' => $subeventos
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al filtrar: ' . $e->getMessage()
        ], 500);
    }
    }


    public function buscarPorDni(Request $request)
    {
        try {
            $dni = $request->dni;
            
            $persona = persona::where('dni', $dni)->first();
            
            if ($persona) {
                return response()->json([
                    'encontrado' => true,
                    'idpersona' => $persona->idpersona,
                    'nombre' => $persona->nombre,
                    'apell' => $persona->apell,
                    'tele' => $persona->tele,
                    'email' => $persona->email,
                    'idgenero' => $persona->idgenero,
                    'direc' => $persona->direc
                ]);
            }
            
            return response()->json(['encontrado' => false]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda: ' . $e->getMessage()
            ], 500);
        }
    }

    public function agregarPonente(Request $request)
    {
       
        
        try {
            // Llamar al procedimiento almacenado CRasignarponent
            DB::statement('CALL CRasignarponent(?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->dni,
                $request->nombre,
                $request->apell,
                $request->tele ?? '',
                $request->email,
                $request->direc ?? '',
                $request->genero,
                $request->idsubevent
            ]);
            
            // Obtener los datos de la persona creada/actualizada
            $persona = persona::where('dni', $request->dni)->first();
            
            return response()->json([
                'success' => true,
                'message' => 'Ponente agregado correctamente',
                'persona' => $persona
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar ponente: ' . $e->getMessage()
            ], 500);
        }
    }

    public function actualizarPonente(Request $request)
   {
    $request->validate([
        'idasig' => 'required',
        'dni' => 'required|string|max:9',
        'nombre' => 'required|string|max:100',  
        'apell' => 'required|string|max:100',   
        'email' => 'required|email|max:100',
        'genero' => 'required|integer'
    ]);
    
    try {
        $asignacionActual = asignarponent::find($request->idasig);
        
        if (!$asignacionActual) {
            return response()->json([
                'success' => false,
                'message' => 'Asignación no encontrada'
            ], 404);
        }
        
        // Verificar que la persona existe
        $persona = persona::where('dni', $request->dni)->first();
        
        if (!$persona) {
            return response()->json([
                'success' => false,
                'message' => 'Persona no encontrada con ese DNI'
            ], 404);
        }
        
        // Llamar al procedimiento almacenado MDasignarponent
        DB::statement('CALL MDasignarponent(?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->dni,
            $request->nombre,      
            $request->apell,       
            $request->tele ?? '',  
            $request->email,
            $request->direc ?? '', 
            $request->genero,
            $asignacionActual->idsubevent
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Ponente actualizado correctamente'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar ponente: ' . $e->getMessage()
        ], 500);
    }
}

    public function eliminarPonente(Request $request)
    {
        $request->validate([
            'idasig' => 'required|integer'
        ]);
        
        try {
            // Verificar que la asignación existe
            $asignacion = asignarponent::find($request->idasig);
            
            if (!$asignacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Asignación no encontrada'
                ], 404);
            }
            
            DB::statement('CALL EliAsignarPonente(?)', [$request->idasig]);
            
            return response()->json([
                'success' => true,
                'message' => 'Ponente eliminado correctamente del evento'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar ponente: ' . $e->getMessage()
            ], 500);
        }
    }
}