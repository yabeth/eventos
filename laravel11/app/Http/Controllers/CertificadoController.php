<?php

namespace App\Http\Controllers;
use App\Models\asistencia;
use App\Models\inscripcion;
use App\Models\persona;
use App\Models\evento;
use App\Models\informe;
use App\Models\certificado;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 use App\Models\certificacion;
use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Support\Facades\Auth;

class CertificadoController extends Controller
{
    public function certificado()
    {
        $inscripciones= inscripcion::all();
        $inscripciones= inscripcion::with('evento')->get();
        $personas= persona::all();
        
        $eventos = Evento::distinct()  
        ->select('eve.*')  
        ->from('evento AS eve')  
        ->join('certificacion AS cert', 'cert.idevento', '=', 'eve.idevento')  
        ->where('eve.idestadoeve', 2)  
        ->whereRaw('DATE_ADD(DATE_ADD(eve.fecini, INTERVAL TIME(eve.horcul) HOUR_SECOND), INTERVAL 10 MINUTE) <= NOW()')  
        ->where('eve.fecini', '<=', now()->toDateString())  
        ->get(); 
        $certificaciones = certificacion::all();
        $asistencias = asistencia::with(['inscripcion.evento','inscripcion','inscripcion.persona'])->get();
        //  $certificados = certificado::with(['informe.certificacion', 'asistencia.inscripcion.persona'])->get();
    //  $certificados=certificado::with(['informe','asistencia'])->get();
    $certificados = Certificado::with(['certificacion', 'asistencia.inscripcion.persona'])
    ->get();

        return view('Vistas.certificado',compact('certificados','inscripciones','personas','eventos','asistencias','certificaciones'));


    }
    public function create()
    {   
    }
    public function store(Request $request)
    { 
    }
    public function show(certificado $certificado)
    {
    }
    public function edit( $idCertif)
    {
        $inscripciones= inscripcion::all();
        $inscripciones= inscripcion::with('evento')->get();
        $personas= persona::all();
        $eventos = evento::where('idestadoeve', 2)->get();
        $certificaciones = certificacion::all();
        $asistencias = asistencia::with(['inscripcion.evento','inscripcion','inscripcion.persona'])->get();
        $certificados=certificado::findOrFail($idCertif);
        return view('Vistas.certificado',compact('certificados','inscripciones','personas','eventos','asistencias'));

    }
    public function update(Request $request, $idCertif)
    {
        try {

            DB::statement("SET @usuario_app = ?", [Auth::user()->nomusu]);
            
        $result = DB::select('CALL MDcertinum(?, ?)', [
            $idCertif,
            $request->input('nro')
        ]);
      
        $message = $result[0]->{'Los datos pueden generar duplicidadSe modifico correctamente'} ?? 'Se modifico correctamente';

        session()->flash('success', 'El certificado se actualizó correctamente.');
        return response()->json(['message' => 'El certificado se actualizó correctamente.']);
} catch (\Illuminate\Database\QueryException $ex) {
    $errorMsg = $ex->getMessage();

    if (strpos($errorMsg, 'El certificado ya está entregado') !== false) {
        return response()->json(['message' => 'El certificado ya está entregado.'], 400);
    } elseif (strpos($errorMsg, 'Ya existe el número de certificado') !== false) {
        return response()->json(['message' => 'Ya existe el número de certificado.'], 400);
    }

    return response()->json(['message' => 'Hubo un problema al actualizar el certificado.'], 500);
}
   
    }
    

public function updat(Request $request, $idCertif)
{
    try {
        Log::info("Inicio de la función 'updat' con idCertif: $idCertif");

        DB::statement("SET @usuario_app = ?", [Auth::user()->nomusu]);

        $result = DB::select('CALL MDcertestado(?, ?)', [
            $idCertif,
            $request->input('idestcer')
        ]);
      

        $message = $result[0]->{'Cambio de estado incorrecto'} ?? 'Se modificó correctamente el estado';
        Log::info("Mensaje generado", ['message' => $message]);

        return response()->json(['message' => $message]);

    } catch (\Exception $e) {
        Log::error("Error en la función 'updat'", ['exception' => $e->getMessage()]);
        return response()->json(['message' => 'Ocurrió un error al modificar el estado'], 500);
    }
}


public function numcer(Request $request)
{

    try {

        DB::statement("SET @usuario_app = ?", [Auth::user()->nomusu]);

        $result = DB::select('CALL GenerarNumero(?, ?, ?, ?)', [
            $request->input('idevento'),
            $request->input('carac'),
            $request->input('desde'),
            $request->input('hasta')
        ]);

        // Asumimos que el procedimiento almacenado devuelve un resultado exitoso en caso de éxito
        $message = $result[0]->{'Resultado'} ?? 'Se generaron los números correctamente.';
        return redirect()->back()->with('success', $message);
    } catch (\Illuminate\Database\QueryException $ex) {
        // Capturar errores de SQL, incluyendo SIGNAL SQLSTATE
        $errorMsg = $ex->getMessage();

        if (strpos($errorMsg, 'No hay suficientes registros en el rango especificado.') !== false) {
            $errorMsg = 'No hay suficientes registros en el rango especificado.';
        } else {
            $errorMsg = 'Ocurrió un error al generar los números.';
        }

        return redirect()->back()->with('error', $errorMsg);
    } catch (\Exception $e) {
        // Capturar cualquier otro error
        return redirect()->back()->with('error', 'Ocurrió un error inesperado.');
    }
}

    public function destroy(certificado $certificado)
    {  
        
    }
    public function filterByEve(Request $request) {
        $eventId = $request->input('event_id');
        $searchTerm = $request->input('searchTerm'); 
    
        $certificados = certificado::with(['certificacion', 'asistencia.inscripcion.persona'])
            ->whereHas('asistencia.inscripcion.evento', function ($query) use ($eventId) {
                $query->where('idevento', $eventId);
            })
            ->whereHas('asistencia.inscripcion.persona', function ($query) use ($searchTerm) {
              
                $query->where('dni', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('nombre', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('apell', 'LIKE', "%{$searchTerm}%");
            })
            ->get();
    
        return response()->json($certificados);
    }

    public function getDescription($idevento)  
    {  
        $certificacion = Certificacion::where('idevento', $idevento)->first();
        
        if (!$certificacion) {  
            return response()->json(['error' => 'Certificación no encontrada'], 404);  
        }  
        
        return response()->json(['obser' => $certificacion->obser ?? '']);  
    }

public function updateCertificacion(Request $request, $idevento)
{
    try {
        DB::select('CALL MDcertificacion(?, ?)', [
            $idevento,
            $request->input('obser'),
        ]);

        return redirect()->back()->with('success', 'Se actualizó correctamente');
    } catch (\Exception $e) {
        \Log::error("Error al actualizar la certificación: " . $e->getMessage());
        return redirect()->back()->with('error', 'Error al actualizar la certificación: ' . $e->getMessage());
    }
}




public function buscar(Request $request) {
    $search = $request->input('search');
    $eventId = $request->input('event_id');
    $query = Certificado::query();

    if (!empty($eventId)) {
        $query->whereHas('asistencia.inscripcion', function ($q) use ($eventId) {
            $q->where('idevento', $eventId);
        });
    }
    if (!empty($search)) {
        $query->whereHas('asistencia.inscripcion.persona', function ($q) use ($search) {
            $q->where('dni', 'LIKE', '%' . $search . '%')
            ->orWhere('apell', 'LIKE', '%' . $search . '%')
            ->orWhere('nombre', 'LIKE', '%' . $search . '%');
        });
    }

    $certificados = $query->with([
        'asistencia.inscripcion.persona',
        'asistencia.inscripcion.evento'  // Añadir esta relación
    ])->get();

    $output = '';
    $counter = 1;

    foreach ($certificados as $certi) {
        $persona = $certi->asistencia->inscripcion->persona;
        $evento = $certi->asistencia->inscripcion->evento;  // Obtener el evento
        $eventnom = $evento ? htmlspecialchars($evento->eventnom) : 'Sin evento';  // Verificar que exista
        
        
        
        $estadoClass = $certi->idestcer == 2 ? 'btn-success' : 'btn-warning';
        $estadoText = $certi->idestcer == 2 ? 'Entregado' : 'Pendiente';

        $output .= '<tr>
            <td>' . $counter++ . '</td>
            <td>' . htmlspecialchars($persona->dni) . '</td>
            <td>' . (!empty($certi->nro) ? htmlspecialchars($certi->nro) : 'No asignado') . '</td>
            <td>' . htmlspecialchars($persona->apell . ' ' . $persona->nombre) . '</td>
            <td>' . htmlspecialchars($persona->tele) . '</td>
            <td>' . htmlspecialchars($persona->email) . '</td>
            <td>
                <button class="btn btn-xs ' . $estadoClass . ' cambiar-estado" data-id="' . $certi->idCertif . '" data-estado="' . $certi->idestcer . '">
                    ' . $estadoText . '
                </button>
            </td>
            <td>
                <button class="btn btn-xs btn-primary ingresar-numero" data-id="' . $certi->idCertif . '">
                    Ingresar N° de certificado
                </button>
            </td>
            <td>' . $eventnom . '</td>
        </tr>';
    }

    return response($output);
}




public function culeven(Request $request, $idevento)
{
    Log::info("Iniciando culminación de evento. ID del evento: " . $idevento);

    try {
        DB::beginTransaction();

        $affected = DB::update('UPDATE evento SET idestadoeve = 1 WHERE idevento = ?', [$idevento]);
        
        if ($affected === 0) {
            DB::rollBack();
            Log::warning("No se actualizó ningún registro. ID del evento: " . $idevento);
            return response()->json(['error' => 'No se encontró el evento o ya está culminado'], 404);
        }

        DB::commit();
        Log::info("Evento culminado exitosamente. ID del evento: " . $idevento);
        return response()->json(['message' => 'El evento ha sido culminado exitosamente'], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("Error al culminar el evento: " . $e->getMessage() . ". ID del evento: " . $idevento);
        return response()->json(['error' => 'Error al culminar el evento: ' . $e->getMessage()], 500);
    }
}

}
