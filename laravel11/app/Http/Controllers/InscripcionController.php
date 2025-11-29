<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\{evento, persona, escuela, genero, subevent, inscripcion};

class InscripcionController extends Controller
{
    
    public function inscripcion()
    { 
        $eventos = Evento::select('idevento', 'eventnom', 'fecini', 'fechculm', 'idestadoeve')
            ->where('fechculm', '>=', now()->toDateString())
            ->where('idestadoeve', 2)
            ->get();

        return view('Vistas.inscripcion', [
            'eventos' => $eventos,
            'personas' => persona::with('genero')->get(),
            'escuelas' => escuela::all(),
            'inscripciones' => inscripcion::with(['subevento', 'escuela', 'persona.genero', 'persona'])->get(),
            'generos' => Genero::all(),
            'subevents' => subevent::all()
        ]);
    }

    /** Registrar nueva inscripción */
    public function store(Request $request) 
    {
        try {
            $this->checkAuthentication();
            $this->setUserContext();

            $dni = $request->input('dni');
            $idescuela = $request->input('idescuela');
            
            $persona = $this->getPersonaWithSchool($dni);
            $decision = $this->determineDecision($persona, $idescuela, $request);

            if ($decision === 'alert') {
                return response()->json([
                    'showAlert' => true,
                    'message' => 'La persona ya está registrada en otra escuela. ¿Desea cambiarla?'
                ]);
            }

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

            $mensaje = ($decision == 'S') ? 'Se actualizó exitosamente!' : 'Se agregó exitosamente!';

            return response()->json(['success' => true, 'message' => $mensaje]);

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->handleDatabaseError($e);
        } catch (\Exception $e) {
            return $this->handleGeneralError($e);
        }
    }

    /** Actualizar inscripción existente  */
    public function update(Request $request, $idincrip) 
    {   
        try { 
            $this->checkAuthentication();
            $this->setUserContext();
            
            Log::info('UPDATE INICIADO', [
                'idincrip' => $idincrip,
                'dni' => $request->input('dni'),
                'idescuela' => $request->input('idescuela')
            ]);
            
            $result = DB::select('CALL MDincripcion(?,?,?,?,?,?,?,?,?)', [
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
            
            Log::info('UPDATE EXITOSO', ['result' => $result]);
            
            return response()->json([
                'success' => true, 
                'message' => '¡Se modificó exitosamente! La escuela se actualizó en todas las inscripciones de esta persona.'
            ]);  
            
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->handleDatabaseError($e, 'UPDATE');
        } catch (\Exception $e) {
            return $this->handleGeneralError($e, 'UPDATE');
        }
    }

    /** Eliminar inscripción */
    public function destroy($idincrip) 
    {
        try {
            $this->checkAuthentication();
            $this->setUserContext();
            
            Log::info('Eliminando persona de todos los subeventos', ['idincrip' => $idincrip]);
            
            $result = DB::select('CALL ELIinscrip(?)', [$idincrip]);
            
            Log::info('Eliminación exitosa', ['result' => $result]);
            
            return response()->json([
                'success' => true,
                'message' => $result[0]->mensaje ?? 'La persona fue eliminada de todos los subeventos del evento'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar:', [
                'error' => $e->getMessage(),
                'idincrip' => $idincrip
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }

    /** Obtener datos de participante por DNI */
    public function getParticipant($dni)
    {
        $persona = Persona::where('dni', $dni)->first();
        
        if (!$persona) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró el participante.'
            ]);
        }

        Log::info('Persona encontrada con ID: ' . $persona->idpersona);
        
        $inscripcion = DB::table('inscripcion')
            ->where('idpersona', $persona->idpersona)
            ->orderBy('idincrip', 'desc')
            ->first();
        
        if ($inscripcion) {
            Log::info('Inscripción encontrada con idescuela: ' . $inscripcion->idescuela);
            $persona->idescuela = $inscripcion->idescuela;
        }
        
        return response()->json([
            'success' => true,
            'data' => $persona
        ]);
    }

    /** Filtrar inscripciones por evento */
    public function filterByEventt(Request $request)  
    {
        try {
            Log::info('filterByEventt llamado', $request->all());
            
            $eventId = $request->input('event_id'); 
            $searchTerm = $request->input('searchTerm');
            
            if (!$eventId) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se proporcionó el ID del evento'
                ], 400);
            }

            Log::info('Buscando inscripciones para evento:', ['event_id' => $eventId]);

            $query = $this->buildFilterQuery($eventId, $searchTerm);
            $inscripciones = $query->get();

            Log::info('Total inscripciones encontradas:', ['count' => $inscripciones->count()]);

            $inscripcionesUnicas = $inscripciones->groupBy('idpersona')
                ->map(function($group) {
                    return $group->sortByDesc('idincrip')->first();
                })
                ->values();

            Log::info('Inscripciones únicas:', ['count' => $inscripcionesUnicas->count()]);

            return response()->json([
                'success' => true,
                'data' => $inscripcionesUnicas,
                'count' => $inscripcionesUnicas->count()
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error en filterByEventt:', [
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

    // ==================== MÉTODOS PRIVADOS ====================

    private function checkAuthentication()
    {
        if (!Auth::check()) {
            throw new \Exception('Usuario no autenticado');
        }
    }

    /** Establecer contexto de usuario */
    private function setUserContext()
    {
        $usuario_logueado = Auth::user()->nomusu;
        DB::statement("SET @usuario_logueado := ?", [$usuario_logueado]);
    }

    /**  Obtener persona con información de escuela */
    private function getPersonaWithSchool($dni)
    {
        return DB::table('personas')
            ->leftJoin('inscripcion', 'personas.idpersona', '=', 'inscripcion.idpersona')
            ->where('personas.dni', $dni)
            ->select('personas.*', 'inscripcion.idescuela')
            ->first();
    }

    /** Determinar decisión para inscripción */
    private function determineDecision($persona, $idescuela, $request)
    {
        if (!$persona || $persona->idescuela === null || $persona->idescuela == $idescuela) {
            return 'N';
        }

        if (!$request->has('decision')) {
            return 'alert';
        }

        return $request->input('decision');
    }

    /** Construir query de filtrado  */
    private function buildFilterQuery($eventId, $searchTerm)
    {
        $query = Inscripcion::with([
            'escuela',
            'persona',
            'persona.genero',
            'subevento',
            'subevento.evento'
        ])
        ->whereHas('subevento', fn($q) => $q->where('idevento', $eventId));

        if ($searchTerm && trim($searchTerm) !== '') {
            $searchTerm = trim($searchTerm);
            Log::info('🔍 Aplicando búsqueda:', ['term' => $searchTerm]);

            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('persona', function ($q) use ($searchTerm) {
                    $q->where('dni', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('nombre', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('apell', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('tele', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('email', 'LIKE', "%{$searchTerm}%");
                })
                ->orWhereHas('escuela', fn($q) => $q->where('nomescu', 'LIKE', "%{$searchTerm}%"))
                ->orWhereHas('persona.genero', fn($q) => $q->where('nomgen', 'LIKE', "%{$searchTerm}%"));
            });
        }

        return $query;
    }

    /**
     * Manejar errores de base de datos
     */
    private function handleDatabaseError($e, $context = '')
    {
        Log::error("ERROR DB {$context}", [
            'error' => $e->getMessage(),
            'code' => $e->errorInfo[1] ?? null
        ]);
        
        $errorMessage = $e->errorInfo[2] ?? $e->getMessage();
        
        if (strpos($errorMessage, 'No se puede registrar en una escuela diferente') !== false) {
            return response()->json([
                'success' => false, 
                'message' => 'No se puede registrar en una escuela diferente sin autorización'
            ], 400);
        }

        if (strpos($errorMessage, 'DNI ya está registrado') !== false) {
            return response()->json([
                'success' => false, 
                'message' => 'El DNI ya está registrado para otra persona'
            ], 400);
        }
        
        return response()->json([
            'success' => false, 
            'message' => $errorMessage
        ], 500);
    }

    /**
     * Manejar errores generales
     */
    private function handleGeneralError($e, $context = '')
    {
        Log::error("ERROR INESPERADO {$context}", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false, 
            'message' => 'Error inesperado: ' . $e->getMessage()
        ], 500);
    }
}