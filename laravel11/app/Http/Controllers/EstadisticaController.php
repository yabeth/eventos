<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EstadisticaController extends Controller {

    public function index() {
        $eventoscer = DB::table('evento')
            ->select('idevento', 'eventnom')
            ->orderBy('idevento', 'desc')
            ->get();

        $facultadess = DB::table('facultad')
            ->select('idfacultad', 'nomfac')
            ->orderBy('nomfac', 'asc')
            ->get();

        return view('Vistas.principal', compact('eventoscer', 'facultadess'));
    }


    public function eventosproximos() {
        $hoy = Carbon::today('America/Lima');

        $eventos = DB::table('evento as e')
            ->join('subevent as s', 'e.idevento', '=', 's.idevento')
            ->whereDate('s.fechsubeve', '>=', $hoy)
            ->select(
                'e.idevento',
                'e.eventnom',
                'e.fecini',
                DB::raw('MIN(s.fechsubeve) as proxima_fecha'),
                DB::raw('MIN(s.horini) as proxima_hora')
            )
            ->groupBy('e.idevento', 'e.eventnom', 'e.fecini')
            ->orderBy('proxima_fecha', 'asc')
            ->orderBy('proxima_hora', 'asc')
            ->get();

        return response()->json($eventos);
    }



    // CERTIFICADOS ENTREGADOS POR EVENTO
    public function certificadosPorEvento(Request $request)
    {
        $evento = $request->evento;

        if (!$evento) {
            return response()->json(['error' => 'Falta evento'], 400);
        }

        $data = DB::table('certificado')
            ->where('idevento', $evento)
            ->selectRaw("
            SUM(CASE WHEN idestcer = 4 THEN 1 ELSE 0 END) AS entregados,
            SUM(CASE WHEN idestcer <> 4 THEN 1 ELSE 0 END) AS no_entregados
        ")
            ->first();

        return response()->json($data);
    }


    /**
     * Obtener eventos pendientes y culminados por tipo
     */
    public function eventosPorTipo()
    {
        $eventos = DB::table('evento')
            ->join('tipoevento', 'evento.idTipoeven', '=', 'tipoevento.idTipoeven')
            ->join('estadoevento', 'evento.idestadoeve', '=', 'estadoevento.idestadoeve')
            ->select(
                'tipoevento.nomeven as tipo_evento',
                'estadoevento.nomestado as estado_evento',
                DB::raw('COUNT(evento.idevento) as cantidad')
            )
            ->whereIn('estadoevento.nomestado', ['pendiente', 'culminado'])
            ->groupBy('tipoevento.nomeven', 'estadoevento.nomestado')
            ->orderBy('tipoevento.nomeven')
            ->get();

        $labels = $eventos->pluck('tipo_evento')->unique()->values();
        $estados = $eventos->pluck('estado_evento')->unique()->values();

        $data = [];

        foreach ($estados as $estado) {
            $data[$estado] = [];
            foreach ($labels as $tipoEvento) {
                $evento = $eventos->where('estado_evento', $estado)
                    ->where('tipo_evento', $tipoEvento)
                    ->first();
                $data[$estado][$tipoEvento] = $evento ? $evento->cantidad : 0;
            }
        }

        $datasets = [];
        foreach ($estados as $estado) {
            $datasets[] = [
                'label' => $estado,
                'data' => array_values($data[$estado]),
                'backgroundColor' => $estado === 'culminado' ? 'rgba(0, 255, 0, 0.5)' : 'rgba(255, 99, 132, 1)',
                'borderColor' => $estado === 'culminado' ? 'rgba(0, 255, 0, 0.5)' : 'rgba(255, 99, 132, 1)',
                'borderWidth' => 1,
            ];
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => $datasets
        ]);
    }

    /**
     * Obtener distribución por tipo de evento (para gráfico dona)
     */
    public function distribucionTipoEvento()
    {
        $eventos = DB::table('evento')
            ->join('tipoevento', 'evento.idTipoeven', '=', 'tipoevento.idTipoeven')
            ->join('estadoevento', 'evento.idestadoeve', '=', 'estadoevento.idestadoeve')
            ->select(
                'tipoevento.nomeven as tipo_evento',
                'estadoevento.nomestado as estado_evento',
                DB::raw('COUNT(evento.idevento) as cantidad')
            )
            ->groupBy('tipoevento.nomeven', 'estadoevento.nomestado')
            ->get();

        $dataDona = [];
        $totalEventos = 0;

        foreach ($eventos as $evento) {
            if (!isset($dataDona[$evento->tipo_evento])) {
                $dataDona[$evento->tipo_evento] = 0;
            }
            $dataDona[$evento->tipo_evento] += $evento->cantidad;
            $totalEventos += $evento->cantidad;
        }

        return response()->json([
            'data' => array_values($dataDona),
            'labels' => array_keys($dataDona),
            'total' => $totalEventos
        ]);
    }



    /**
     * Estadísticas de asistencia por evento
     */
    public function estadisticasEventos(Request $request)
    {
        $request->validate([
            'event' => 'required|integer'
        ]);

        $eventoId = $request->event;

        $eventos = DB::table('evento as e')
            ->leftJoin('subevent as se', 'e.idevento', '=', 'se.idevento')
            ->leftJoin('inscripcion as i', 'se.idsubevent', '=', 'i.idsubevent')
            ->leftJoin('asistencia as a', 'i.idincrip', '=', 'a.idincrip')
            ->where('e.idevento', $eventoId)
            ->select(
                'e.idevento',
                'e.eventnom',

                DB::raw('COUNT(DISTINCT i.idpersona) as total_participantes'),

                DB::raw('COUNT(DISTINCT CASE WHEN a.idtipasis = 1 THEN i.idpersona END) as asistentes'),

                DB::raw('COUNT(DISTINCT i.idpersona) 
                     - COUNT(DISTINCT CASE WHEN a.idtipasis = 1 THEN i.idpersona END) 
                     as ausentes')
            )
            ->groupBy('e.idevento', 'e.eventnom')
            ->first();

        return response()->json($eventos);
    }


    /**
     * Eventos culminados por mes en un año específico
     */

    public function eventosPorMes($year)
    {
        $eventos = DB::table('evento')
            ->select(DB::raw('MONTH(fecini) as mes, COUNT(*) as cantidad'))
            ->where('idestadoeve', 2)
            ->whereYear('fecini', $year)
            ->groupBy(DB::raw('MONTH(fecini)'))
            ->get();

        return response()->json($eventos);
    }


    /**
     * Estadísticas de eventos con/sin resolución
     */
    public function eventosConResolucion()
    {
        $eventosConResolucion = DB::table('evento')
            ->join('resoluciaprob', 'evento.idevento', '=', 'resoluciaprob.idevento')
            ->count();

        $eventosSinResolucion = DB::table('evento')
            ->leftJoin('resoluciaprob', 'evento.idevento', '=', 'resoluciaprob.idevento')
            ->whereNull('resoluciaprob.idevento')
            ->count();

        return response()->json([
            'conResolucion' => $eventosConResolucion,
            'sinResolucion' => $eventosSinResolucion,
        ]);
    }

    /**
     * Eventos por mes y año (para gráfico de curva)
     */
    public function eventosPorMesAno()
    {
        $eventosPorMesAno = DB::table('evento')
            ->selectRaw('YEAR(fecini) as anio, MONTH(fecini) as mes, COUNT(*) as cantidad')
            ->groupBy('anio', 'mes')
            ->orderBy('anio', 'asc')
            ->orderBy('mes', 'asc')
            ->get();

        return response()->json($eventosPorMesAno);
    }


    /**
     * Estadísticas de eventos con/sin informe
     */
    public function eventosConInforme()
    {
        $eventosConInforme = DB::table('evento')
            ->join('informe', 'evento.idevento', '=', 'informe.idevento')
            ->count();

        $eventosSinInforme = DB::table('evento')
            ->leftJoin('informe', 'evento.idevento', '=', 'informe.idevento')
            ->whereNull('informe.idevento')
            ->count();

        return response()->json([
            'conResolucion' => $eventosConInforme,
            'sinResolucion' => $eventosSinInforme,
        ]);
    }


    public function getParticipantesPorEscuela(Request $request)
    {
        $evento = $request->evento;
        $facultad = $request->facultad;

        $data = DB::table('inscripcion as i')
            ->join('escuela as e', 'e.idescuela', '=', 'i.idescuela')
            ->join('facultad as f', 'f.idfacultad', '=', 'e.idfacultad')
            ->join('subevent as s', 's.idsubevent', '=', 'i.idsubevent')
            ->where('s.idevento', $evento)
            ->where('f.idfacultad', $facultad)
            ->select(
                'e.nomescu',
                DB::raw('COUNT(DISTINCT i.idpersona) as total')
            )
            ->groupBy('e.idescuela', 'e.nomescu')
            ->get();

        return response()->json($data);
    }


    /**
     * Participantes por facultad en un año determinado
     */
    public function getParticipantesPorFacultad(Request $request)
    {
        $request->validate([
            'anioss' => 'required|integer|min:2020|max:' . date('Y')
        ]);

        $anioss = $request->input('anioss');

        $participantes = DB::table('inscripcion as i')
            ->join('subevent as se', 'i.idsubevent', '=', 'se.idsubevent')
            ->join('evento as e', 'se.idevento', '=', 'e.idevento')
            ->join('escuela as esc', 'i.idescuela', '=', 'esc.idescuela')
            ->join('facultad as f', 'esc.idfacultad', '=', 'f.idfacultad')
            ->whereYear('e.fecini', $anioss)
            ->select(
                'f.nomfac as facultad',
                DB::raw('COUNT(DISTINCT i.idpersona) as cantidad_participantes')
            )
            ->groupBy('f.idfacultad', 'f.nomfac')
            ->get();

        return response()->json($participantes);
    }
}
