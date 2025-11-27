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
        
    }


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
        
        \Log::info('UPDATE INICIADO', [
            'idincrip' => $idincrip,
            'dni' => $request->input('dni'),
            'idescuela' => $request->input('idescuela')
        ]);
        
        $usuario_logueado = Auth::user()->nomusu;
        DB::statement("SET @usuario_logueado := ?", [$usuario_logueado]);
        
        //  SOLO 9 PARÁMETROS - Ya no enviamos idevento ni idsubevent
        $result = DB::select('call MDincripcion(?,?,?,?,?,?,?,?,?)', [
            $idincrip,
            $request->input('dni'),
            $request->input('apell'),
            $request->input('direc'),
            $request->input('email'),
            $request->input('idgenero'),
            $request->input('nombre'),
            $request->input('tele'),
            $request->input('idescuela')
        ]);
        
        \Log::info('UPDATE EXITOSO', ['result' => $result]);
        
        return response()->json([
            'success' => true, 
            'message' => '¡Se modificó exitosamente! La escuela se actualizó en todas las inscripciones de esta persona.'
        ]);  
        
    } catch (\Illuminate\Database\QueryException $e) {
        \Log::error('ERROR DB EN UPDATE', [
            'error' => $e->getMessage(),
            'code' => $e->errorInfo[1] ?? null
        ]);
        
        $errorMessage = $e->errorInfo[2] ?? $e->getMessage();
        
        if (strpos($errorMessage, 'DNI ya está registrado') !== false) {
            return response()->json(['success' => false, 'message' => 'El DNI ya está registrado para otra persona'], 400);
        }
        
        return response()->json(['success' => false, 'message' => $errorMessage], 500);
        
    } catch (\Exception $e) {
        \Log::error('ERROR INESPERADO EN UPDATE', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['success' => false, 'message' => 'Error inesperado: ' . $e->getMessage()], 500);
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
        
        \Log::info('Eliminando persona de todos los subeventos', ['idincrip' => $idincrip]);
        
        $result = DB::select('CALL ELIinscrip(?)', [$idincrip]);
        
        \Log::info('Eliminación exitosa', ['result' => $result]);
        
        return response()->json([
            'success' => true,
            'message' => $result[0]->mensaje ?? 'La persona fue eliminada de todos los subeventos del evento'
        ]);
        
    } catch (\Exception $e) {
        \Log::error(' Error al eliminar:', [
            'error' => $e->getMessage(),
            'idincrip' => $idincrip
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error al eliminar: ' . $e->getMessage()
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
    
    $inscripciones = Inscripcion::with(['escuela', 'persona.genero', 'persona', 'subevento'])
        ->whereHas('subevento', function ($q) use ($eventId) {
            $q->where('idevento', $eventId);
        })
        ->get();
        
    return response()->json($inscripciones);
}
  

public function filterByEventt(Request $request)  {
    try {
<<<<<<< HEAD
        Log::info('🔍 filterByEventt llamado', $request->all());
=======
        \Log::info('filterByEventt llamado', $request->all());
>>>>>>> eb0f3b63b213a1da8799f8cebfba113449cb8a96
        
        $eventId = $request->input('event_id'); 
        $searchTerm = $request->input('searchTerm');
        
        if (!$eventId) {
<<<<<<< HEAD
            Log::warning('⚠️ No se proporcionó event_id');
=======
            \Log::warning('No se proporcionó event_id');
>>>>>>> eb0f3b63b213a1da8799f8cebfba113449cb8a96
            return response()->json([
                'success' => false,
                'message' => 'No se proporcionó el ID del evento'
            ], 400);
        }

<<<<<<< HEAD
        Log::info('📊 Buscando inscripciones para evento:', ['event_id' => $eventId]);
=======
        \Log::info('Buscando inscripciones para evento:', ['event_id' => $eventId]);
>>>>>>> eb0f3b63b213a1da8799f8cebfba113449cb8a96

        // CAMBIAR subevent por subevento
        $query = Inscripcion::with([
            'escuela',
            'persona',
            'persona.genero',
            'subevento',
            'subevento.evento'
        ])
        ->whereHas('subevento', function ($q) use ($eventId) {
            $q->where('idevento', $eventId);
        });

        // Aplicar búsqueda si existe
        if ($searchTerm && trim($searchTerm) !== '') {
            $searchTerm = trim($searchTerm);
<<<<<<< HEAD
            Log::info('🔍 Aplicando búsqueda:', ['term' => $searchTerm]);
=======
            \Log::info('Aplicando búsqueda:', ['term' => $searchTerm]);
>>>>>>> eb0f3b63b213a1da8799f8cebfba113449cb8a96

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
                })
                ->orWhereHas('persona.genero', function ($q) use ($searchTerm) {
                    $q->where('nomgen', 'LIKE', "%{$searchTerm}%");
                });
            });
        }

        // Ejecutar consulta
        $inscripciones = $query->get();

<<<<<<< HEAD
        Log::info('📈 Total inscripciones encontradas:', ['count' => $inscripciones->count()]);
=======
        \Log::info('Total inscripciones encontradas:', ['count' => $inscripciones->count()]);
>>>>>>> eb0f3b63b213a1da8799f8cebfba113449cb8a96

        // Eliminar duplicados por persona (mantener la inscripción más reciente)
        $inscripcionesUnicas = $inscripciones->groupBy('idpersona')
            ->map(function ($group) {
                return $group->sortByDesc('idincrip')->first();
            })
            ->values();

<<<<<<< HEAD
        Log::info('✅ Inscripciones únicas:', ['count' => $inscripcionesUnicas->count()]);
=======
        \Log::info('Inscripciones únicas:', ['count' => $inscripcionesUnicas->count()]);
>>>>>>> eb0f3b63b213a1da8799f8cebfba113449cb8a96

        return response()->json([
            'success' => true,
            'data' => $inscripcionesUnicas,
            'count' => $inscripcionesUnicas->count()
        ]);

    } catch (\Exception $e) {
<<<<<<< HEAD
        Log::error('❌ Error en filterByEventt:', [
=======
        \Log::error('Error en filterByEventt:', [
>>>>>>> eb0f3b63b213a1da8799f8cebfba113449cb8a96
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error del servidor: ' . $e->getMessage()
        ], 500);
    }
}


// Método para eliminar TODAS las inscripciones de un evento
public function destroyAllByEvent(Request $request) {
    try {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado'
            ], 401);
        }
        
        $idevento = $request->input('idevento');
        
        if (!$idevento) {
            return response()->json([
                'success' => false,
                'message' => 'Debe seleccionar un evento'
            ], 400);
        }
        
        $usuario_logueado = Auth::user()->nomusu;
        DB::statement("SET @usuario_logueado := ?", [$usuario_logueado]);
        
        \Log::info('Eliminando todas las inscripciones del evento', [
            'idevento' => $idevento,
            'usuario' => $usuario_logueado
        ]);
        
        $result = DB::select('CALL ELIinscrip_evento(?)', [$idevento]);
        
        \Log::info('Inscripciones eliminadas exitosamente', ['result' => $result]);
        
        return response()->json([
            'success' => true,
            'message' => $result[0]->mensaje ?? 'Todas las inscripciones fueron eliminadas correctamente'
        ]);
        
    } catch (\Illuminate\Database\QueryException $e) {
        \Log::error('Error DB al eliminar inscripciones del evento:', [
            'error' => $e->getMessage(),
            'code' => $e->errorInfo[1] ?? null
        ]);
        
        $errorMessage = $e->errorInfo[2] ?? $e->getMessage();
        
        return response()->json([
            'success' => false,
            'message' => $errorMessage
        ], 500);
        
    } catch (\Exception $e) {
        \Log::error('Error inesperado al eliminar inscripciones:', [
            'error' => $e->getMessage()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error inesperado: ' . $e->getMessage()
        ], 500);
    }
}

    }