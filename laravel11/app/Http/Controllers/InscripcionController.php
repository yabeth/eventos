<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\evento;
use App\Models\persona;
use App\Models\escuela;
use App\Models\genero;
use App\Models\subevent;
use App\Models\inscripcion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
class InscripcionController extends Controller
{
    public function inscripcion()
    { 
     $eventos = Evento::select('idevento', 'eventnom', 'fecini', 'fechculm', 'idestadoeve')
                 ->where('fechculm', '>=', now()->toDateString())
                 ->where('idestadoeve', 2)
                 ->get();

        $personas = persona::all(); 
        $personas = persona::with('genero')->get();
        $escuelas = escuela::all();
        $generos = Genero::all();
        $subevents = subevent::all();
        $inscripciones = inscripcion::with(['subevento', 'escuela', 'persona.genero','persona'])->get();
        return view('Vistas.inscripcion', compact('eventos', 'personas','escuelas', 'inscripciones','generos','subevents'));
    }
    public function create()
    {
        //
    }
/*public function store(Request $request) {
    try {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Usuario no autenticado'], 401);
        }

        $usuario_logueado = Auth::user()->nomusu;
        DB::statement("SET @usuario_logueado := ?", [$usuario_logueado]);

        $dni = $request->input('dni');
        $idescuela = $request->input('idescuela');
        
        // Verificar si la persona existe y su escuela actual
        $persona = DB::table('personas')
            ->leftJoin('inscripcion', 'personas.idpersona', '=', 'inscripcion.idpersona')
            ->where('personas.dni', $dni)
            ->select('personas.*', 'inscripcion.idescuela')
            ->first();

        // Si la persona no existe o no tiene inscripción previa
        if (!$persona || $persona->idescuela === null) {
            DB::statement('CALL CRinscrip(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->input('apell'),
                $request->input('direc'),
                $request->input('dni'),
                $request->input('email'),
                $request->input('idgenero'),
                $request->input('nombre'),
                $request->input('tele'),
                $idescuela,
                $request->input('idevento'),
                'N'
            ]);
            return response()->json(['success' => true, 'message' => 'Se agregó exitosamente!']);
        }

        // Si la persona existe y está en la misma escuela
        if ($persona->idescuela == $idescuela) {
            DB::statement('CALL CRinscrip(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->input('apell'),
                $request->input('direc'),
                $request->input('dni'),
                $request->input('email'),
                $request->input('idgenero'),
                $request->input('nombre'),
                $request->input('tele'),
                $idescuela,
                $request->input('idevento'),
                'N'
            ]);
            return response()->json(['success' => true, 'message' => 'Se agregó exitosamente!']);
        }

        // Si la persona existe pero está en una escuela diferente
        if ($request->has('decision')) {
            DB::statement('CALL CRinscrip(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->input('apell'),
                $request->input('direc'),
                $request->input('dni'),
                $request->input('email'),
                $request->input('idgenero'),
                $request->input('nombre'),
                $request->input('tele'),
                $idescuela,
                $request->input('idevento'),
                $request->input('decision')
            ]);
            return response()->json(['success' => true, 'message' => 'Se actualizó exitosamente!']);
        }

        return response()->json(['showAlert' => true]);

    } catch (\Illuminate\Database\QueryException $e) {
        return response()->json(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()], 500);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error inesperado: ' . $e->getMessage()], 500);
    }
}*/
    

public function store(Request $request) {
    try {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Usuario no autenticado'], 401);
        }

        $usuario_logueado = Auth::user()->nomusu;
        DB::statement("SET @usuario_logueado := ?", [$usuario_logueado]);

        $dni = $request->input('dni');
        $idescuela = $request->input('idescuela');
        
        // Verificar si la persona existe y su escuela actual
        $persona = DB::table('personas')
            ->leftJoin('inscripcion', 'personas.idpersona', '=', 'inscripcion.idpersona')
            ->where('personas.dni', $dni)
            ->select('personas.*', 'inscripcion.idescuela')
            ->first();

        // Determinar la decisión
        $decision = 'N'; // Por defecto
        
        // Solo si la persona existe, tiene escuela y es diferente a la actual
        if ($persona && $persona->idescuela !== null && $persona->idescuela != $idescuela) {
            // Si no viene la decisión en el request, mostrar alerta
            if (!$request->has('decision')) {
                return response()->json([
                    'showAlert' => true,
                    'message' => 'La persona ya está registrada en otra escuela. ¿Desea cambiarla?'
                ]);
            }
            // Si viene la decisión, usarla
            $decision = $request->input('decision');
        }

        // Ejecutar el procedimiento almacenado
        DB::statement('CALL CRinscrip(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->input('apell'),
            $request->input('direc'),
            $dni,
            $request->input('email'),
            $request->input('idgenero'),
            $request->input('nombre'),
            $request->input('tele'),
            $idescuela,
            $request->input('idevento'),
            $decision
        ]);

        // Mensaje según el caso
        $mensaje = ($persona && $persona->idescuela !== null && $persona->idescuela != $idescuela && $decision == 'S') 
            ? 'Se actualizó exitosamente!' 
            : 'Se agregó exitosamente!';

        return response()->json(['success' => true, 'message' => $mensaje]);

    } catch (\Illuminate\Database\QueryException $e) {
        // Capturar el error del SIGNAL del procedimiento almacenado
        if (strpos($e->getMessage(), 'No se puede registrar en una escuela diferente') !== false) {
            return response()->json([
                'success' => false, 
                'message' => 'No se puede registrar en una escuela diferente sin autorización'
            ], 400);
        }
        return response()->json(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()], 500);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error inesperado: ' . $e->getMessage()], 500);
    }
}
    public function show(inscripcion $inscripcion)
    {
    }
    public function edit($idincrip)
    {
        $inscripciones = inscripcion::findOrFail($idincrip); // Encuentra el evento por ID
        $eventos = evento::all();
        $personas = Persona::with('genero')->get();
        $escuelas = escuela::all();
        $generos = Genero::all();
        return view('Vistas.inscripcion', compact('eventos', 'personas', 'escuelas', 'inscripciones','generos'));
    }

    public function update(Request $request, $idincrip) {   
        try { 
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Usuario no autenticado'], 401);
            }
            $usuario_logueado = Auth::user()->nomusu;
            DB::statement("SET @usuario_logueado := ?", [$usuario_logueado]);
            $result = DB::select('call MDincripcion(?,?, ?, ?, ?, ?, ?, ?,?,?)', [
                $idincrip,
                $request->input('dni'),
                $request->input('apell'),
                $request->input('direc'),
                $request->input('email'),
                $request->input('idgenero'),
                $request->input('nombre'),
                $request->input('tele'),
                $request->input('idescuela'),
                $request->input('idevento')
            ]);
            return response()->json(['success' => true, 'message' => '¡Se modificó exitosamente!']);  
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1451) {
                return response()->json(['success' => false, 'message' => 'No se puede modificar'], 400);
            } elseif ($errorCode == 1644) {
                $errorMessage = $e->errorInfo[2];
                return response()->json(['success' => false, 'message' => $errorMessage], 400);
            } else {
                return response()->json(['success' => false, 'message' => 'Ocurrió un error al intentar modificar'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ocurrió un error inesperado al intentar modificar'], 500);
        }
    }

    public function destroy($idincrip) {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }
            
            $usuario_logueado = Auth::user()->nomusu;
            DB::statement("SET @usuario_logueado := ?", [$usuario_logueado]);
            
            $result = DB::select('CALL ELIinscrip(?)', [$idincrip]);
            
            return response()->json([
                'success' => true,
                'message' => 'Registro eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar inscripción: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el registro'
            ], 500);
        }
    }
    public function getParticipant($dni)
{
    $persona = Persona::where('dni', $dni)->first();
    
    if ($persona) {
        // Agregar logs para depuración
        \Log::info('Persona encontrada con ID: ' . $persona->idpersona);
        
        // Obtener la inscripción más reciente de esta persona
        $inscripcion = DB::table('inscripcion')
            ->where('idpersona', $persona->idpersona)
            ->orderBy('idincrip', 'desc')
            ->first();
        
        // Verificar si se encontró una inscripción
        if ($inscripcion) {
            \Log::info('Inscripción encontrada con idescuela: ' . $inscripcion->idescuela);
            $persona->idescuela = $inscripcion->idescuela;
        } else {
            \Log::info('No se encontraron inscripciones para esta persona');
        }
        
        return response()->json([
            'success' => true,
            'data' => $persona
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'No se encontró el participante.'
        ]);
    }
}
    public function filterByEvent(Request $request)
    {

        $eventId = $request->input('event_id');
        
        $inscripciones = Inscripcion::with(['evento', 'escuela', 'persona.genero', 'persona'])
            ->where('idevento', $eventId)
            ->get();
        return response()->json($inscripciones);
    }
   /* public function filterByEventt(Request $request) {
        $eventId = $request->input('event_id');
        $searchTerm = $request->input('searchTerm');

        $query = Inscripcion::with(['evento', 'escuela', 'persona.genero', 'persona'])
            ->where('idevento', $eventId);

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('persona', function ($q) use ($searchTerm) {
                    $q->where('dni', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('nombre', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('apell', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('tele', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('direc', 'LIKE', "%{$searchTerm}%");
                })->orWhereHas('escuela', function ($q) use ($searchTerm) {
                    $q->where('nomescu', 'LIKE', "%{$searchTerm}%");
                })->orWhereHas('persona.genero', function ($q) use ($searchTerm) {
                    $q->where('nomgen', 'LIKE', "%{$searchTerm}%");
                });
            });
        }

        $inscripciones = $query->get();

        return response()->json($inscripciones);
    }*/


public function filterByEventt(Request $request)  
{
    try {
        \Log::info('🔍 filterByEventt llamado', $request->all());
        
        $eventId = $request->input('event_id'); // <-- CORREGIDO
        $searchTerm = $request->input('searchTerm');
        
        if (!$eventId) {
            \Log::warning('⚠️ No se proporcionó event_id');
            return response()->json([
                'success' => false,
                'message' => 'No se proporcionó el ID del evento'
            ], 400);
        }

        \Log::info('📊 Buscando inscripciones para evento:', ['event_id' => $eventId]);

        // Construir la consulta
        $query = Inscripcion::with([
            'escuela',
            'persona',
            'persona.genero',
            'subevent'
        ])
        ->whereHas('subevent', function ($q) use ($eventId) {
            $q->where('idevento', $eventId);
        });

        // Aplicar búsqueda
        if ($searchTerm && trim($searchTerm) !== '') {
            $searchTerm = trim($searchTerm);
            \Log::info('🔍 Aplicando búsqueda:', ['term' => $searchTerm]);

            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('persona', function ($q) use ($searchTerm) {
                    $q->where('dni', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('nombre', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('apell', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('tele', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('email', 'LIKE', "%{$searchTerm}%");
                })
                ->orWhereHas('escuela', function ($q) use ($searchTerm) {
                    $q->where('nomescu', 'LIKE', "%{$searchTerm}%");
                });
            });
        }

        // Ejecutar consulta
        $inscripciones = $query->get();

        \Log::info('📈 Total inscripciones encontradas:', ['count' => $inscripciones->count()]);

        // Quitar duplicados por persona
        $inscripcionesUnicas = $inscripciones->unique('idpersona')->values();

        return response()->json([
            'success' => true,
            'data' => $inscripcionesUnicas,
            'count' => $inscripcionesUnicas->count()
        ]);

    } catch (\Exception $e) {
        \Log::error('❌ Error en filterByEventt:', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error del servidor: ' . $e->getMessage(),
            'error_details' => $e->getMessage()
        ], 500);
    }
}


    }