<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\evento;
use App\Models\persona;
use App\Models\escuela;
use App\Models\genero;
use App\Models\subevent;
use App\Models\inscripcion;
use App\Models\Imagen;
use Carbon\Carbon;

class eventowebController extends Controller
{

    public function indexweb()
    {
        $imagenes = Imagen::all();
        $ahora = Carbon::now('America/Lima');
        $totalInscripciones = DB::table('inscripcion')->distinct()->count('idpersona');
        $totalEventos = DB::table('evento')->count();
        $totalCertificados = DB::table('certificado')->count();
        $totalAsistencias = DB::table('escuela')->count();

        $subeventoMinimos = DB::table('subevent')
            ->select(
                'idevento',
                DB::raw('MIN(fechsubeve) as fechsubeve_min'),
                DB::raw('MIN(horini) as horini_min')
            )->groupBy('idevento');

        $subEventos = DB::table('subevent as s')
            ->select('s.idevento',  's.fechsubeve as fechsubeve_min', 's.horini as horini_min', 'm.modalidad')
            ->joinSub($subeventoMinimos, 'min_sub', function ($join) {
                $join->on('s.idevento', '=', 'min_sub.idevento')
                    ->on('s.fechsubeve', '=', 'min_sub.fechsubeve_min')
                    ->on('s.horini', '=', 'min_sub.horini_min');
            })
            ->leftJoin('canal as c', 's.idcanal', '=', 'c.idcanal')
            ->leftJoin('modalidad as m', 'c.idmodal', '=', 'm.idmodal')
            ->groupBy('s.idevento', 's.fechsubeve', 's.horini', 'm.modalidad');

        $eventos = DB::table('evento as e')
            ->select(
                'e.idevento',
                'e.eventnom',
                'e.idTipoeven',
                'te.nomeven as tipo_evento',
                'min_sub.fechsubeve_min',
                'min_sub.horini_min',
                'min_sub.modalidad'
            )
            ->joinSub($subEventos, 'min_sub', function ($join) {
                $join->on('e.idevento', '=', 'min_sub.idevento');
            })
            ->leftJoin('tipoevento as te', 'e.idTipoeven', '=', 'te.idTipoeven')
            ->where('e.idestadoeve', 2)
            ->orderBy('min_sub.fechsubeve_min')
            ->orderBy('min_sub.horini_min')
            ->get()

            ->map(function ($evento) use ($ahora) {
                $fechaSubevento = Carbon::parse($evento->fechsubeve_min, 'America/Lima');
                $fechaOcultar = $fechaSubevento->copy()->subDays(1)->startOfDay(); // FECHA LÍMITE PARA MOSTRAR EVENTO
                $fechaCierre = $fechaSubevento->copy()->subDays(2)->endOfDay(); // FECHA DE CIERRE DE INSCRIPCIONES (visual)
                $evento->fecha_cierre = $fechaCierre->format('Y-m-d H:i:s');
                $evento->mostrar_evento = $ahora->lt($fechaOcultar);
                $evento->inscripcion_cerrada = $ahora->gte($fechaCierre);

                if ($evento->inscripcion_cerrada) {
                    $evento->dias_restantes = -1;
                    $evento->horas_restantes = 0;
                } else {
                    // $evento->dias_restantes = $ahora->diffInDays($fechaCierre, false);
                    // $evento->horas_restantes = $ahora->diffInHours($fechaCierre, false);
                    $evento->dias_restantes = max(0, $ahora->copy()->startOfDay()->diffInDays($fechaCierre->copy()->startOfDay(), false));
                    // $evento->horas_restantes = max( 0, $ahora->diffInHours($fechaCierre, false));
                    $evento->horas_restantes = max(0, $ahora->diffInRealHours($fechaCierre, false));
                }

                return $evento;
            })

            ->filter(fn($evento) => $evento->mostrar_evento)
            ->values();

        return view('Vistas.eventoweb', [
            'eventosProximos' => $eventos,
            'imagenes' => $imagenes,
            'totalInscripciones' => $totalInscripciones,
            'totalEventos' => $totalEventos,
            'totalCertificados' => $totalCertificados,
            'totalAsistencias' => $totalAsistencias
        ]);
    }



    public function showeventodetalle($id)
    {

        $escuelas = escuela::all();
        $generos = Genero::all();
        $eventoDetalle = DB::table('evento')
            ->where('idevento', $id)
            ->first();

        if (!$eventoDetalle) {
            abort(404);
        }
        $subEventos = DB::table('subevent')
            ->where('idevento', $id)
            ->orderBy('fechsubeve', 'asc')
            ->get();

        return view('Vistas.eventowebdetalle', compact('eventoDetalle', 'subEventos', 'escuelas', 'generos'));
    }

    // ============================================
    // CREAR INSCRIPCIÓN
    // ============================================

    public function getParticipant($dni)
    {
        $persona = Persona::where('dni', $dni)->first();

        if ($persona) {
            Log::info('Persona encontrada con ID: ' . $persona->idpersona);
            $inscripcion = DB::table('inscripcion')
                ->where('idpersona', $persona->idpersona)
                ->orderBy('idincrip', 'desc')
                ->first();

            if ($inscripcion) {
                Log::info('Inscripción encontrada con idescuela: ' . $inscripcion->idescuela);
                $persona->idescuela = $inscripcion->idescuela;
            } else {
                Log::info('No se encontraron inscripciones para esta persona');
            }

            return response()->json([
                'success' => true,
                'data' => $persona
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se encontró el participante.'
        ]);
    }

    // ============================================
    // CREAR INSCRIPCIÓN
    // ============================================
    public function stores(Request $request) {
        $dni = $request->input('dni');
        $idescuela = $request->input('idescuela');
        $persona = DB::table('personas')
            ->leftJoin('inscripcion', 'personas.idpersona', '=', 'inscripcion.idpersona')
            ->where('personas.dni', $dni)
            ->select('personas.*', 'inscripcion.idescuela')
            ->first();

        $decision = 'N';

        if ($persona && $persona->idescuela !== null && $persona->idescuela != $idescuela) {
            if (!$request->has('decision')) {
                return response()->json([
                    'showAlert' => true,
                    'message' => 'La persona ya está registrada en otra escuela. ¿Desea cambiarla?'
                ]);
            }
            $decision = $request->input('decision');
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

        $mensaje = ($persona && $persona->idescuela !== null && $persona->idescuela != $idescuela && $decision == 'S')
            ? 'Se actualizó exitosamente!'
            : 'Se agregó exitosamente!';

        return response()->json(['success' => true, 'message' => $mensaje]);
    }
}
