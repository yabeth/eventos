<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class EstadisticaController extends Controller {
    public function eventosproximos() {
        $eventosPendientes = DB::table('evento')
            ->join('estadoevento', 'evento.idestadoeve', '=', 'estadoevento.idestadoeve')
            ->select('evento.idevento', 'evento.eventnom', 'evento.descripción', 'evento.fecini')
            ->where('estadoevento.nomestado', 'Pendiente')
            ->where('evento.fecini', '>=', Carbon::now())
            ->orderBy('evento.fecini', 'asc')
            ->get();

        return view('Vistas.principal', compact('eventosPendientes'));
    }

    public function estadisticasEventos(Request $request) {
        $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'required|integer|min:2020|max:' . date('Y'),
        ]);

        $mes = $request->input('mes');
        $anio = $request->input('anio');

        $eventos = DB::table('evento as e')
            ->leftJoin('inscripcion as i', 'e.idevento', '=', 'i.idevento')
            ->leftJoin('asistencia as a', function ($join) use ($mes, $anio) {
                $join->on('i.idincrip', '=', 'a.idincrip')
                    ->whereMonth('a.fech', $mes)
                    ->whereYear('a.fech', $anio);
            })
            
            ->whereMonth('e.fecini', $mes)
            ->whereYear('e.fecini', $anio)
            ->select(
                'e.idevento',
                'e.eventnom',
                DB::raw('COUNT(DISTINCT i.idincrip) as total_participantes'),
                DB::raw('COUNT(DISTINCT CASE WHEN a.idtipasis = 1 THEN a.idincrip END) as asistentes'),
                DB::raw('COUNT(DISTINCT CASE WHEN a.idtipasis = 2 THEN i.idincrip END) as ausentes')
            )
            ->groupBy('e.idevento', 'e.eventnom')
            ->orderBy('e.eventnom')
            ->get();

        if ($request->ajax()) {
            return response()->json($eventos);
        }

        return view('Vistas.principal', compact('eventos', 'mes', 'anio'));
    }

    public function eventosPorMes($year) {
        $eventos = DB::table('evento')
            ->select(DB::raw('MONTH(fecini) as mes, COUNT(*) as cantidad'))
            ->where('idestadoeve', 1) 
            ->whereYear('fecini', $year)
            ->groupBy(DB::raw('MONTH(fecini)'))
            ->get();
    
        return response()->json($eventos);
    }

    public function eventosPorMesanio($year) {
        $eventos = DB::table('evento')
            ->select(DB::raw('MONTH(fecini) as mes, COUNT(*) as cantidad'))
            ->where('idestadoeve', 2)
            ->whereYear('fecini', $year)
            ->groupBy(DB::raw('MONTH(fecini)'))
            ->get();
    
        return response()->json($eventos);
    }

    public function eventosConResolucion() {
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


    public function eventosPorMesAno() {
        $eventosPorMesAno = DB::table('evento')
            ->selectRaw('YEAR(fecini) as anio, MONTH(fecini) as mes, COUNT(*) as cantidad')
            ->groupBy('anio', 'mes')
            ->orderBy('anio', 'asc')
            ->orderBy('mes', 'asc')
            ->get();

        return response()->json($eventosPorMesAno);
    }

    public function eventosConInforme() {
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

    public function getParticipantesPorEscuela(Request $request) {
        $eventoId = $request->input('evento');
        $facultadId = $request->input('facultad');
        
        if (!$eventoId || !$facultadId) {
            return response()->json(['error' => 'Faltan parámetros'], 400);
        }
    
        $participantesPorEscuela = DB::table('inscripcion')
            ->join('escuela', 'inscripcion.idescuela', '=', 'escuela.idescuela')
            ->join('facultad', 'escuela.idfacultad', '=', 'facultad.idfacultad')
            ->select('escuela.nomescu', DB::raw('COUNT(inscripcion.idpersona) as total'))
            ->where('inscripcion.idevento', $eventoId)
            ->where('escuela.idfacultad', $facultadId)
            ->groupBy('escuela.nomescu')
            ->get();
        
        return response()->json($participantesPorEscuela);
    }
    
    public function getCertificadosEventos(Request $request) {
        $request->validate([
            'meses' => 'required|integer|min:1|max:12',
            'anios' => 'required|integer|min:2020|max:' . date('Y'),
        ]);
    
        $meses = $request->input('meses');
        $anios = $request->input('anios');
    
        $certificados = DB::table('evento as e')
            ->join('inscripcion as i', 'e.idevento', '=', 'i.idevento')
            ->join('asistencia as a', 'i.idincrip', '=', 'a.idincrip')
            ->leftJoin('certificado as c', 'a.idasistnc', '=', 'c.idasistnc')
            ->leftJoin('estadocerti as ec', 'c.idestcer', '=', 'ec.idestcer')
            ->where('a.idtipasis', '=', 1)
            ->whereMonth('e.fecini', $meses)
            ->whereYear('e.fecini', $anios)
            ->select(
                'e.eventnom as evento',
                DB::raw('SUM(CASE WHEN c.idCertif IS NOT NULL AND ec.nomestadc = "Entregado" THEN 1 ELSE 0 END) as certificados_entregados'),
                DB::raw('SUM(CASE WHEN c.idCertif IS NOT NULL AND ec.nomestadc = "Pendiente" THEN 1 ELSE 0 END) as certificados_no_entregados')
            )
            ->groupBy('e.eventnom')
            ->get();
    
        if ($request->ajax()) {
            return response()->json($certificados);
        }
    
        return view('Vistas.principal', compact('certificados', 'meses', 'anios'));
    }
    
    public function getParticipantesPorFacultad(Request $request) {
        $request->validate([
            'anioss' => 'required|integer|min:2020|max:' . date('Y')
        ]);
    
        $anioss = $request->input('anioss');
        $participantes = DB::table('inscripcion as i')
            ->join('evento as e', 'i.idevento', '=', 'e.idevento')
            ->join('escuela as esc', 'i.idescuela', '=', 'esc.idescuela')
            ->join('facultad as f', 'esc.idfacultad', '=', 'f.idfacultad')
            ->whereYear('e.fecini', $anioss)
            ->select('f.nomfac as facultad', DB::raw('COUNT(i.idincrip) as cantidad_participantes'))
            ->groupBy('f.nomfac')
            ->get();
    
        if ($request->ajax()) {
            return response()->json($participantes);
        }
        return view('Vistas.principal', compact('participantes', 'anioss'));
    }
    
}
