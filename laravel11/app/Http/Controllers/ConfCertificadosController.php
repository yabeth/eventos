<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\certificado;
use App\Models\inscripcion;
use App\Models\persona;
use App\Models\evento;
use App\Models\certificacion;
use App\Models\asistencia;
use Illuminate\Support\Facades\DB;

class ConfCertificadosController extends Controller {
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function ConCertificado() {
        $eventos = Evento::select('idevento', 'eventnom')
            ->orderBy('fecini', 'desc')
            ->get();
        
        $inscripciones = inscripcion::with(['persona', 'escuela', 'subevento.evento'])->get();
        
        $personas = persona::all();
        
        return view('Vistas.ConCertificado', compact('eventos', 'inscripciones', 'personas'));
    }

    public function filterByEventos(Request $request) {
        $eventId = request()->input('event_id');
        $searchTerm = request()->input('searchTerm');

        $certificados = Certificado::with([
            'certificacion.evento',
            'estadoCertificado',
            'tipoCertificado.cargo',
            'certiasiste.asistencia.inscripcion.persona',
            'certiasiste.asistencia.inscripcion.escuela'
        ])
            ->whereHas('certificacion.evento', function ($query) use ($eventId) {
                $query->where('idevento', $eventId);
            })
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->whereHas('certiasiste.asistencia.inscripcion.persona', function ($q) use ($searchTerm) {
                    $q->where('dni', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('nombre', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('apell', 'LIKE', "%{$searchTerm}%");
                });
            })
            ->get();

        return response()->json($certificados);
    }    
}
