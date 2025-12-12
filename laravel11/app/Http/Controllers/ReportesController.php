<?php

namespace App\Http\Controllers;
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use Carbon\Carbon;
use App\Models\facultad;
use App\Models\escuela;
//use App\Models\Evento;
use App\Models\evento;
use App\Models\usuario;
use App\Models\certificacion;

use App\Models\asistencia;
use App\Models\certificado;
use App\Models\usuario_permisos;
use App\Models\evento_auditoria;

use App\Models\TipoEvento;
use App\Models\EstadoEvento;
use App\Models\EventosPendientes;
use App\Models\Inscripcion;
use App\Models\Tipotema;
use App\Models\canal;
use App\Models\modalidad;
use App\Models\asignarponent;
use App\Models\subevent;
// use PDF;

use Barryvdh\DomPDF\Facade\Pdf;


class ReportesController extends Controller
{
 
    public function Vtareport(){
        $eventos = Evento::all();
        return view('Vistas/reportes', compact('eventos'));
    }
    

public function pdfFacultades()

{
    $facultades = facultad::all();

    $currentDateTime = Carbon::now(config('app.timezone'))->format('d-m -Y / H:i:s');

    $pdf = \PDF::loadView('Vistas/pdffac', compact('facultades', 'currentDateTime'));
    
    $this->configurarPDF($pdf);

    return $pdf->stream('facultades.pdf');
}

public function pdfEscuelas()
{
    $escuelas = escuela::all();
    $currentDateTime = Carbon::now(config('app.timezone'))->format('d-m-Y / H:i:s');
    $pdf = \PDF::loadView('Vistas/pdfescu', compact('escuelas', 'currentDateTime'));
    $this->configurarPDF($pdf);
    return $pdf->stream('escuelas.pdf');
}

public function pdfusuario()
{
$usuarios = Usuario::with('permisos')->get();

    $pdf = \PDF::loadView('Vistas/pdfusuario',compact('usuarios'));
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Usuarios", null,12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'),null,12);
    $currentDateTime = Carbon::now(config('app.timezone'))->format('d-m-Y / H:i:s');
    return $pdf->stream();

}

public function pdfinscritosfechaeven(Request $request)
{
 
    $fecinicio = $request->input(key:'fecinic');
    $fecfin = $request->input(key:'fecfin');
    $idevento = $request->input(key:'ideven');
    $nome = evento::where('idevento', $idevento)->pluck('eventnom')->first();

    $inscritos = inscripcion::join('personas', 'inscripcion.idpersona', '=', 'personas.idpersona')
    ->orderBy('personas.apell', 'asc')
    ->where('idevento', $idevento)
    ->whereBetween('fecinscripcion',[$fecinicio, $fecfin])
    ->get(['inscripcion.*', 'personas.apell', 'personas.nombre']);
    if ($inscritos->isEmpty()) {
        return redirect()->back()->with('error', 'No hay datos disponibles para las fechas seleccionadas.');
    }
    else{
    $pdf = \PDF::loadView('Vistas/pdfinscritosfechaeven',compact('inscritos','fecinicio','fecfin','nome'));
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();

    $canvas->page_text(55, 800, "Reporte de eventos por fecha", null,12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'),null,12);
    $currentDateTime = Carbon::now(config('app.timezone'))->format('d-m-Y / H:i:s');
    
    return $pdf->stream();}
}

public function pdfauditeventofecha(Request $request)
{
   
    $fecinicio = $request->input(key:'fecinic');
    $fecfin = $request->input(key:'fecfin');
 

    $eventos= evento::whereBetween('fecini',[$fecinicio, $fecfin])->get();
    $audit= evento_auditoria::whereBetween('fecha_operacion',[$fecinicio, $fecfin])->get();

  
    if ($eventos->isEmpty()) {
        return redirect()->back()->with('error', 'No hay datos disponibles para las fechas seleccionadas.');
    }
    else{
    $pdf = \PDF::loadView('Vistas/pdfauditeven',compact('audit','fecinicio','fecfin'));
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();

    $canvas->page_text(55, 800, "Reporte de eventos por fecha", null,12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'),null,12);
    $currentDateTime = Carbon::now(config('app.timezone'))->format('d-m-Y / H:i:s');
    
    return $pdf->stream();}
}
public function pdfeventofecha(Request $request)
{
    $fecinicio = $request->input(key:'fecinic');
    $fecfin = $request->input(key:'fecfin');
   
    $eventos= evento::whereBetween('fecini',[$fecinicio, $fecfin])->get();

    if ($eventos->isEmpty()) {
        return redirect()->back()->with('error', 'No hay datos disponibles para las fechas seleccionadas.');
    }
    else{
    $pdf = \PDF::loadView('Vistas/pdfeventofecha',compact('eventos','fecinicio','fecfin'))
    ->setPaper('a4', 'landscape')  
    ->setOption('margin-top', 20)   
    ->setOption('margin-right', 20)  
    ->setOption('margin-bottom', 20)  
    ->setOption('margin-left', 20);
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();

    $canvas->page_text(55, 550, "Reporte de eventos por fecha", null,12);
    $canvas->page_text(270, 550, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 12);
    $canvas->page_text(450, 550, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'),null,12);
    $currentDateTime = Carbon::now(config('app.timezone'))->format('d-m-Y / H:i:s');
    
    return $pdf->stream();}
}


public function pdfevento()
{
    $eventos = evento::all();
    $pdf = \PDF::loadView('Vistas/pdfeventos', compact('eventos'))  
    ->setPaper('a4', 'landscape')  
    ->setOption('margin-top', 20)   
    ->setOption('margin-right', 20)  
    ->setOption('margin-bottom', 20)  
    ->setOption('margin-left', 20);

    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();

    $canvas->page_text(55, 550, "Reporte de Eventos", null, 12);   
    $canvas->page_text(270, 550, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 12);   
    $canvas->page_text(450, 550, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'), null, 12);

    $currentDateTime = Carbon::now(config('app.timezone'))->format('d-m-Y / H:i:s');
    
    return $pdf->stream();
}


public function pdfcertificado(Request $request)
{
    $idevento = $request->input('idevento');

    if (!$idevento) {
       return redirect()->back()->with('error', 'ERROR');
    }

    $subeventos = \DB::table('subevent')
        ->where('idevento', $idevento)
        ->pluck('idsubevent');

    if ($subeventos->isEmpty()) {
        return redirect()->back()->with('error', 'ERROR');
    }

    $evento = DB::table('evento')
        ->where('idevento', $idevento)
        ->pluck('eventnom')
        ->first();

    $certificados = DB::table('certificado')
        ->join('certiasiste', 'certiasiste.idCertif', '=', 'certificado.idCertif')
        ->join('asistencia', 'asistencia.idasistnc', '=', 'certiasiste.idasistnc')
        ->join('inscripcion', 'inscripcion.idincrip', '=', 'asistencia.idincrip')
        ->join('personas', 'personas.idpersona', '=', 'inscripcion.idpersona')
        ->join('estadocerti', 'estadocerti.idestcer', '=', 'certificado.idestcer')
        ->join('subevent', 'subevent.idsubevent', '=', 'inscripcion.idsubevent')
        ->where('subevent.idevento', $idevento)
        ->select(
            'certificado.nro',
            'certificado.fecentrega',
            'personas.dni',
            'personas.nombre',
            'personas.apell',
            'estadocerti.nomestadc AS estado'
        )
        ->distinct()
        ->get();

    $pdf = \PDF::loadView('Vistas.pdfcertificado', compact('certificados', 'evento'));
    $pdf->output();
    $dompdf = $pdf->getDomPDF();

    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Inscritos", null, 12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'), null, 12);
    $currentDateTime = Carbon::now(config('app.timezone'))->format('d-m-Y / H:i:s');
    
    return $pdf->stream();
}

public function pdfcertificadoexter(Request $request)
{
    $idevento = $request->input('idevento');

    if (!$idevento) {
        return redirect()->back()->with('error', 'ERROR: No está llegando el ID del evento.');
    }

    $evento = DB::table('evento')
        ->where('idevento', $idevento)
        ->pluck('eventnom')
        ->first();


        if (!$evento) {
        return redirect()->back()->with('error', 'ERROR: No se encontró el evento con el ID proporcionado.');
    }

    $certificados = DB::table('certinormal')
        ->join('certificado', 'certificado.idCertif', '=', 'certinormal.idCertif')
        ->join('personas', 'personas.idpersona', '=', 'certinormal.idpersona')
        ->join('estadocerti', 'estadocerti.idestcer', '=', 'certificado.idestcer')
        ->where('certificado.idevento', $idevento)
        ->select(
            'certificado.nro',
            'certificado.fecentrega',
            'personas.dni',
            'personas.nombre',
            'personas.apell',
            'estadocerti.nomestadc AS estado'
        )
        ->distinct()
        ->orderBy('personas.apell')
        ->get();

   
        if ($certificados->isEmpty()) {
        return redirect()->back()->with('info', 'No se encontraron certificados externos (modalidad normal) para el evento seleccionado.');
    }

    $pdf = \PDF::loadView('Vistas.pdfcertificado', compact('certificados', 'evento'));

    $pdf->output();
    $dompdf = $pdf->getDomPDF();

    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Certificados Externos", null, 12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'), null, 12);

    return $pdf->stream();
}

public function pdfinscripcion()
{
    // Obtener los inscritos ordenados alfabéticamente por el nombre (reemplaza 'nombre_columna' por el nombre real de la columna)
   // $inscritos = inscripcion::orderBy('personas.apell', 'asc')->get();
    $inscritos = inscripcion::join('personas', 'inscripcion.idpersona', '=', 'personas.idpersona')
    ->orderBy('personas.apell', 'asc')
    ->get(['inscripcion.*', 'personas.apell', 'personas.nombre']);
    // Si no hay inscritos, redirigir de vuelta con un error
    if ($inscritos->isEmpty()) {
        return redirect()->back()->with('error', 'No hay datos disponibles para las fechas seleccionadas.');
    }

    $pdf = \PDF::loadView('Vistas/pdfinscripcion', compact('inscritos'));
    $pdf->output();
    $dompdf = $pdf->getDomPDF();

    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Inscritos", null, 12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'), null, 12);
    $currentDateTime = Carbon::now(config('app.timezone'))->format('d-m-Y / H:i:s');
    
    return $pdf->stream();
}


public function pdfinscritosxevento(Request $request)
{
    $idevent = $request->input(key:'ideven');
    
    $inscritos = inscripcion::join('personas', 'inscripcion.idpersona', '=', 'personas.idpersona')
        ->join('escuela', 'inscripcion.idescuela', '=', 'escuela.idescuela')
        ->join('subevent', 'inscripcion.idsubevent', '=', 'subevent.idsubevent')
        ->where('subevent.idevento', $idevent)
        ->select(
            'personas.idpersona', 
            'personas.apell', 
            'personas.nombre',
            'personas.dni',
            'escuela.nomescu'
        )
        ->groupBy(
            'personas.idpersona', 
            'personas.apell', 
            'personas.nombre',
            'personas.dni',
            'escuela.nomescu'
        )
        ->orderBy('personas.apell', 'asc')
        ->get();
    
    if ($inscritos->isEmpty()) {
        return redirect()->back()->with('error', 'No hay datos disponibles para el evento seleccionado.');
    }
    
    $nome = evento::where('idevento', $idevent)->pluck('eventnom')->first();
    $pdf = \PDF::loadView('Vistas/pdfinscritosxevento', compact('idevent','inscritos','nome'));
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de inscritos", null, 12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'), null, 12);
    return $pdf->stream();
}

public function pdfSubeventosPorEvento(Request $request)
{
    $idevent = $request->input('ideven');
    $evento = Evento::where('idevento', $idevent)->first();
    if (!$evento) {
        return redirect()->back()->with('error', 'El evento seleccionado no existe.');
    }
    $subeventos = Subevent::where('idevento', $idevent)
        ->orderBy('fechsubeve', 'asc')
        ->orderBy('horini', 'asc')
        ->get();

    if ($subeventos->isEmpty()) {
        return redirect()->back()->with('error', 'Este evento no tiene subeventos registrados.');
    }
    $pdf = \PDF::loadView('Vistas/pdfSubeventosPorEvento', compact('evento', 'subeventos'))->setPaper('a4', 'landscape');;

     $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();

    $canvas->page_text(55, 560, "Reporte de Subeventos", null, 12);
    $canvas->page_text(350, 560, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(650, 560, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'), null, 12);

    return $pdf->stream();
}
public function pdfTodosLosSubeventos()
{
    // Obtener solo eventos que tienen subeventos
    $eventos = Evento::whereHas('subeventos')
        ->with(['subeventos' => function($q) {
            $q->orderBy('fechsubeve', 'asc')
              ->orderBy('horini', 'asc');
        }])
        ->orderBy('fecini', 'asc')
        ->get();

    // Si ningún evento tiene subeventos
    if ($eventos->isEmpty()) {
        return redirect()->back()
            ->with('error', 'No existen eventos con subeventos registrados.');
    }

    // Generar PDF
    $pdf = \PDF::loadView('Vistas/pdfTodosLosSubeventos', compact('eventos'))
        ->setPaper('a4', 'landscape');

    // Pie de página
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();

    $canvas->page_text(55, 560, "Reporte General de Subeventos", null, 12);
    $canvas->page_text(350, 560, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(650, 560, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'), null, 12);

    return $pdf->stream();
}


public function rcerti(Request $request)
{
    $ideven = $request->input('ideven');
    $action = $request->input('action');

    if (!$ideven) {
        return redirect()->back()->with('error', 'No está llegando el ID del evento.');
    }

    // Nombre del evento
    $nome = evento::where('idevento', $ideven)->pluck('eventnom')->first();

    // Obtener subeventos del evento
    $subeventos = DB::table('subevent')
        ->where('idevento', $ideven)
        ->pluck('idsubevent');

    if ($subeventos->isEmpty()) {
        return redirect()->back()->with('error', 'Este evento no tiene subeventos.');
    }

    // Inscritos
    $inscritos = inscripcion::whereIn('idsubevent', $subeventos)->get();
    $inscripcionIds = $inscritos->pluck('idincrip');

    if ($inscripcionIds->isEmpty()) {
        return redirect()->back()->with('error', 'No hay inscritos en este evento.');
    }

    $idasistentes = asistencia::whereIn('idincrip', $inscripcionIds)
        ->where('idtipasis', 1)
        ->groupBy('idincrip')
        ->pluck(DB::raw('MIN(idasistnc)'))  
        ->toArray();

    if (empty($idasistentes)) {
        return redirect()->back()->with('error', 'No se encontraron asistentes.');
    }


   $entregado = DB::table('certificado')
    ->join('certiasiste', 'certiasiste.idCertif', '=', 'certificado.idCertif')
    ->join('asistencia', 'asistencia.idasistnc', '=', 'certiasiste.idasistnc')
    ->join('inscripcion', 'inscripcion.idincrip', '=', 'asistencia.idincrip')
    ->join('personas', 'personas.idpersona', '=', 'inscripcion.idpersona')

    ->whereIn('asistencia.idincrip', $inscripcionIds) 
    ->where('certificado.idestcer', 4)
    ->select(
 
        DB::raw('MIN(certificado.nro) as nro'),
        DB::raw('MIN(certificado.fecentrega) as fecentrega'),
        'personas.idpersona',
        'personas.dni',
        'personas.apell',
        'personas.nombre'
    )
    ->groupBy('personas.idpersona', 'personas.dni', 'personas.apell', 'personas.nombre')
    ->orderBy('personas.apell')
    ->get();

    $pendiente = DB::table('certificado')
        ->join('certiasiste', 'certiasiste.idCertif', '=', 'certificado.idCertif')
        ->join('asistencia', 'asistencia.idasistnc', '=', 'certiasiste.idasistnc')
        ->join('inscripcion', 'inscripcion.idincrip', '=', 'asistencia.idincrip')
        ->join('personas', 'personas.idpersona', '=', 'inscripcion.idpersona')
        ->whereIn('certiasiste.idasistnc', $idasistentes)
        ->whereIn('certificado.idestcer', [1, 2, 3])
        ->select(
            DB::raw('MIN(certificado.nro) as nro'),
            DB::raw('MIN(certificado.fecentrega) as fecentrega'),
            'personas.idpersona',
            'personas.dni',
            'personas.apell',
            'personas.nombre'
        )
        ->groupBy('personas.idpersona', 'personas.dni', 'personas.apell', 'personas.nombre')
        ->orderBy('personas.apell')
        ->get();

    // Validaciones
    if ($action == 'entregado' && $entregado->isEmpty()) {
        return redirect()->back()->with('error', 'No hay certificados entregados.');
    }
    if ($action == 'pendiente' && $pendiente->isEmpty()) {
        return redirect()->back()->with('error', 'No hay certificados pendientes.');
    }

    // Generar PDF
    if ($action == 'entregado') {
        $pdf = \PDF::loadView('Vistas.pdfentregado', compact('ideven', 'inscritos', 'entregado', 'nome'));
    } else {
        $pdf = \PDF::loadView('Vistas.pdfpendiente', compact('ideven', 'inscritos', 'pendiente', 'nome'));
    }

    // Footer
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de certificados", null, 12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'), null, 12);

    return $pdf->stream();
}

public function pdfasistencia(Request $request)
{
    $idevent = $request->input('ideven');
    $nome = evento::where('idevento', $idevent)->pluck('eventnom')->first();
    
    $inscritos = inscripcion::where('idevento', $idevent)->get();
    $inscripcionIds = $inscritos->pluck('idincrip')->toArray();
    $asistentesgeneral = asistencia::whereIn('idincrip', $inscripcionIds)->get();
    
    $asistentes = asistencia::whereIn('idincrip', $inscripcionIds)->where('idtipasis', 2)->get();
    
    // Obtener los ausentes (donde idtipasis no es 2)
    $ausentes = asistencia::whereIn('idincrip', $inscripcionIds)->where('idtipasis', '!=', 2)->get();

    $pdf = \PDF::loadView('Vistas/pdfasistencia',compact('idevent','inscritos','asistentes','ausentes','nome','asistentesgeneral'));
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Asistencia a un evento", null,12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'),null,12);
    $currentDateTime = Carbon::now(config('app.timezone'))->format('d-m-Y / H:i:s');
    return $pdf->stream();

}
public function pdfcertificadogeneral(Request $request)
{
    $idevent = $request->input('ideven');
    $nome = evento::where('idevento', $idevent)->pluck('eventnom')->first();
    
    $inscritos = inscripcion::where('idevento', $idevent)->get();
    $inscripcionIds = $inscritos->pluck('idincrip')->toArray();
    $asistencia = asistencia::whereIn('idincrip', $inscripcionIds)->get();
    $idasistencia = $asistencia->pluck('idasistnc')->toArray();
    $certi = certificado::whereIn('idasistnc', $idasistencia)->get();
    $descrip = certificacion::where('idevento',$idevent)->pluck('obser')->first();

    $pdf = \PDF::loadView('Vistas/pdfcertificadoxevento',compact('nome','certi','descrip'));
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Asistencia a un evento", null,12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'),null,12);
    $currentDateTime = Carbon::now(config('app.timezone'))->format('d-m-Y / H:i:s');
    return $pdf->stream();

}

public function rpresentes(Request $request)
{
    $ideven = $request->input('ideven');
    $action = $request->input('action');
    
    // Obtener nombre del evento
    $nome = evento::where('idevento', $ideven)->pluck('eventnom')->first();
    
    // Obtener todos los subeventos del evento
    $subeventos = subevent::where('idevento', $ideven)
        ->orderBy('fechsubeve', 'asc')
        ->get();
    
    if ($subeventos->isEmpty()) {
        return redirect()->back()->with('error', 'No hay subeventos para este evento.');
    }
    
    // Inicializar arrays para agrupar por subevento
    $datosPorSubevento = [];
    
    foreach ($subeventos as $subevento) {
        // Obtener inscritos del subevento
        $inscritos = inscripcion::with(['persona', 'escuela'])
            ->where('idsubevent', $subevento->idsubevent)
            ->get();
        
        if ($inscritos->isEmpty()) {
            continue; // Saltar si no hay inscritos
        }
        
        $inscripcionIds = $inscritos->pluck('idincrip')->toArray();
        
        // Obtener asistentes y ausentes del subevento
        $asistentes = asistencia::with(['inscripcion.persona', 'inscripcion.escuela'])
            ->whereIn('idincrip', $inscripcionIds)
            ->where('idtipasis', 1)
            ->get();
        
        $ausentes = asistencia::with(['inscripcion.persona', 'inscripcion.escuela'])
            ->whereIn('idincrip', $inscripcionIds)
            ->where('idtipasis', 2)
            ->get();
        
        // Solo agregar si hay datos según la acción
        if ($action == 'presentes' && $asistentes->isNotEmpty()) {
            $nombreSubevento = $subevento->Descripcion . ' - ' . \Carbon\Carbon::parse($subevento->fechsubeve)->format('d/m/Y');
            $datosPorSubevento[$nombreSubevento] = [
                'subevento' => $subevento,
                'inscritos' => $inscritos,
                'asistentes' => $asistentes,
                'ausentes' => $ausentes
            ];
        } elseif ($action == 'ausentes' && $ausentes->isNotEmpty()) {
            $nombreSubevento = $subevento->Descripcion . ' - ' . \Carbon\Carbon::parse($subevento->fechsubeve)->format('d/m/Y');
            $datosPorSubevento[$nombreSubevento] = [
                'subevento' => $subevento,
                'inscritos' => $inscritos,
                'asistentes' => $asistentes,
                'ausentes' => $ausentes
            ];
        }
    }
    
    // Verificar si hay datos
    if (empty($datosPorSubevento)) {
        $mensaje = $action == 'presentes' ? 'No hay personas presentes en ningún subevento.' : 'No hay personas ausentes en ningún subevento.';
        return redirect()->back()->with('error', $mensaje);
    }

    // Generar PDF según la acción
    if ($action == 'presentes') {
        $pdf = \PDF::loadView('Vistas/pdfpresentes', compact('nome', 'datosPorSubevento'));
    } elseif ($action == 'ausentes') {
        $pdf = \PDF::loadView('Vistas/pdfausentes', compact('nome', 'datosPorSubevento'));
    }

    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Asistencia", null, 12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'), null, 12);
    
    return $pdf->stream();
}


public function reventop()
{
    // Recuperar los eventos con estado específico
    $eventos = evento::where('idestadoeve', 2)->get();

    // Generar el PDF con la vista y especificar orientación horizontal (landscape)
    $pdf = PDF::loadView('Vistas/pdfeventospendiente', compact('eventos'))
              ->setPaper('a4', 'landscape'); // 'a4' es el tamaño, 'landscape' para horizontal

    // Renderizar el PDF para personalizar el canvas
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();

    // Agregar texto al pie de página
    $canvas->page_text(30, 550, "Reporte de Eventos", null, 12);
    $canvas->page_text(270, 550, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 12);
    $canvas->page_text(450, 550, "Fecha: " . Carbon::now()->format('d/m/y'), null, 12);

    // Devolver el PDF en el navegador
    return $pdf->stream();
}


public function reventof()
{
    // Recuperar los eventos con estado específico
    $eventos = evento::where('idestadoeve', 1)->get();

    // Generar el PDF con la vista y especificar orientación horizontal
    $pdf = PDF::loadView('Vistas/pdfeventosfinalizados', compact('eventos'))
              ->setPaper('a4', 'landscape'); // 'a4' es el tamaño, 'landscape' para horizontal

    // Renderizar el PDF para personalizar el canvas
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();

    // Agregar texto al pie de página
    $canvas->page_text(55, 550, "Reporte de Eventos", null, 12); // Ajustar posición si es necesario
    $canvas->page_text(270, 550, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 550, "Fecha: " . Carbon::now()->format('d/m/y'), null, 12);

    // Devolver el PDF en el navegador
    return $pdf->stream();
}


public function pdfcertificadoxevento(Request $request)
{
    $idevent = $request->input('ideven');
    $inscritos = inscripcion::where('idevento', $idevent)->get();
    $nome = evento::where('idevento', $idevent)->pluck('eventnom')->first();
    
   
    $inscripcionIds = $inscritos->pluck('idincrip')->toArray();
    $asistencia = asistencia::whereIn('idincrip', $inscripcionIds)->get();
    $idasistencia = $asistencia->pluck('idasistnc')->toArray();
    $certificado = certificado::whereIn('idasistnc', $idasistencia)->get();

    if ($inscritos->isEmpty()) {
        return redirect()->back()->with('error', 'No hay datos para el evento seleccionado.');
    }

    $pdf = \PDF::loadView('Vistas/pdfcertificadoxevento', compact('certificado', 'nome'));
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Certificados", null, 12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'), null, 12);

    return $pdf->stream();
}

public function pdfevenxescuxfacuu(Request $request)
{
    $ideven = $request->input('ideven');
    $action = $request->input('action');
    $nome = evento::where('idevento', $ideven)->pluck('eventnom')->first();

    // Obtener inscritos únicos a través de los subeventos del evento
    $inscritosIds = \DB::table('inscripcion')
        ->join('subevent', 'inscripcion.idsubevent', '=', 'subevent.idsubevent')
        ->where('subevent.idevento', $ideven)
        ->distinct()
        ->pluck('inscripcion.idpersona');

    // Obtener las inscripciones completas con relaciones
    $inscritos = inscripcion::with(['persona', 'escuela', 'escuela.facultad'])
        ->join('subevent', 'inscripcion.idsubevent', '=', 'subevent.idsubevent')
        ->where('subevent.idevento', $ideven)
        ->whereIn('inscripcion.idpersona', $inscritosIds)
        ->select('inscripcion.*')
        ->get()
        ->unique('idpersona');

    if ($inscritos->isEmpty()) {
        return redirect()->back()->with('mensaje', 'No hay inscritos en el evento.');
    }

    // Inicializar variables
    $inscritosPorEscuela = [];
    $inscritosPorFacultad = [];

    // Acción por escuela
    if ($action == 'escuela') {
        foreach ($inscritos as $inscrito) {
            if ($inscrito->escuela) {
                $nombreEscuela = $inscrito->escuela->nomescu;
                if (!isset($inscritosPorEscuela[$nombreEscuela])) {
                    $inscritosPorEscuela[$nombreEscuela] = collect();
                }
                $inscritosPorEscuela[$nombreEscuela]->push($inscrito);
            }
        }

        if (empty($inscritosPorEscuela)) {
            return redirect()->back()->with('mensaje', 'No hay datos de inscritos por escuela en el evento.');
        }

        // Ordenar por nombre de escuela
        ksort($inscritosPorEscuela);
        
        $pdf = \PDF::loadView('Vistas/pdfevxescuela', compact('nome', 'inscritosPorEscuela'));

    // Acción por facultad
    } elseif ($action == 'facultad') {
        foreach ($inscritos as $inscrito) {
            if ($inscrito->escuela && $inscrito->escuela->facultad) {
                $nombreFacultad = $inscrito->escuela->facultad->nomfac;
                if (!isset($inscritosPorFacultad[$nombreFacultad])) {
                    $inscritosPorFacultad[$nombreFacultad] = collect();
                }
                $inscritosPorFacultad[$nombreFacultad]->push($inscrito);
            }
        }

        if (empty($inscritosPorFacultad)) {
            return redirect()->back()->with('mensaje', 'No hay datos de inscritos por facultad en el evento.');
        }

        // Ordenar por nombre de facultad
        ksort($inscritosPorFacultad);

        $pdf = \PDF::loadView('Vistas/pdfevxfacultad', compact('nome', 'inscritosPorFacultad'));
    }

    // Personalizar el PDF
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Inscritos", null, 12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'), null, 12);

    return $pdf->stream();
}
public function pdfevenxescuxfacu(Request $request)
{
    $ideven = $request->input('ideven');
    $action = $request->input('action');
    $nome = evento::where('idevento', $ideven)->pluck('eventnom')->first();

    // Obtener inscritos únicos a través de los subeventos del evento
    $inscritosIds = \DB::table('inscripcion')
        ->join('subevent', 'inscripcion.idsubevent', '=', 'subevent.idsubevent')
        ->where('subevent.idevento', $ideven)
        ->distinct()
        ->pluck('inscripcion.idpersona');

    // Obtener las inscripciones completas con relaciones
    $inscritos = inscripcion::with(['persona', 'escuela', 'escuela.facultad'])
        ->join('subevent', 'inscripcion.idsubevent', '=', 'subevent.idsubevent')
        ->where('subevent.idevento', $ideven)
        ->whereIn('inscripcion.idpersona', $inscritosIds)
        ->select('inscripcion.*')
        ->get()
        ->unique('idpersona');

    if ($inscritos->isEmpty()) {
        return redirect()->back()->with('mensaje', 'No hay inscritos en el evento.');
    }

    // CAMBIADO EL ORDEN: Primero facultad, luego escuela
    if ($action == 'facultad') {
        $inscritosPorFacultad = [];
        
        foreach ($inscritos as $inscrito) {
            if ($inscrito->escuela && $inscrito->escuela->facultad) {
                $nombreFacultad = $inscrito->escuela->facultad->nomfac;
                if (!isset($inscritosPorFacultad[$nombreFacultad])) {
                    $inscritosPorFacultad[$nombreFacultad] = collect();
                }
                $inscritosPorFacultad[$nombreFacultad]->push($inscrito);
            }
        }

        if (empty($inscritosPorFacultad)) {
            return redirect()->back()->with('mensaje', 'No hay datos de inscritos por facultad en el evento.');
        }

        // Ordenar por nombre de facultad
        ksort($inscritosPorFacultad);

        $pdf = \PDF::loadView('Vistas/pdfevxfacultad', compact('nome', 'inscritosPorFacultad'));

    // Acción por escuela
    } elseif ($action == 'escuela') {
        $inscritosPorEscuela = [];
        
        foreach ($inscritos as $inscrito) {
            if ($inscrito->escuela) {
                $nombreEscuela = $inscrito->escuela->nomescu;
                if (!isset($inscritosPorEscuela[$nombreEscuela])) {
                    $inscritosPorEscuela[$nombreEscuela] = collect();
                }
                $inscritosPorEscuela[$nombreEscuela]->push($inscrito);
            }
        }

        if (empty($inscritosPorEscuela)) {
            return redirect()->back()->with('mensaje', 'No hay datos de inscritos por escuela en el evento.');
        }

        // Ordenar por nombre de escuela
        ksort($inscritosPorEscuela);
        
        $pdf = \PDF::loadView('Vistas/pdfevxescuela', compact('nome', 'inscritosPorEscuela'));
        
    } else {
        return redirect()->back()->with('mensaje', 'Acción no válida.');
    }

    // Personalizar el PDF
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Inscritos", null, 12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'), null, 12);

    return $pdf->stream();
}

private function configurarPDF($pdf)
{
    
    $pdf->setPaper('A4', 'portrait');
    $pdf->output();
    $canvas = $pdf->getDomPDF()->getCanvas();
    $height = $canvas->get_height();
    $width = $canvas->get_width();
    
    $font = $pdf->getDomPDF()->getFontMetrics()->getFont("helvetica");
    $size = 8;
    $pageText = "Página {PAGE_NUM} de {PAGE_COUNT}";
    $textWidth = $pdf->getDomPDF()->getFontMetrics()->getTextWidth($pageText, $font, $size);
    $x = ($width - $textWidth) / 2;
    
    $canvas->page_text($x, $height - 40, $pageText, $font, $size, array(0, 0, 0));
}

public function rasistenciageneral(Request $request)
{
    $ideven = $request->input('ideven');
    $nome = evento::where('idevento', $ideven)->pluck('eventnom')->first();
    $subeventos = subevent::where('idevento', $ideven)
        ->orderBy('fechsubeve', 'asc')
        ->get();
    
    if ($subeventos->isEmpty()) {
        return redirect()->back()->with('error', 'No hay subeventos para este evento.');
    }
    
    $asistenciaPorSubevento = [];
    
    foreach ($subeventos as $subevento) {
        $nombreSubevento = $subevento->Descripcion . ' - ' . \Carbon\Carbon::parse($subevento->fechsubeve)->format('d/m/Y');
        
        $asistencias = asistencia::with(['inscripcion.persona', 'tipoasiste'])
            ->whereHas('inscripcion', function($query) use ($subevento) {
                $query->where('idsubevent', $subevento->idsubevent);
            })
            ->get();
        
        if ($asistencias->isNotEmpty()) {
            $asistenciaPorSubevento[$nombreSubevento] = [
                'subevento' => $subevento,
                'asistencias' => $asistencias
            ];
        }
    }
    
    if (empty($asistenciaPorSubevento)) {
        return redirect()->back()->with('error', 'No hay asistencias registradas para este evento.');
    }
    
    $pdf = \PDF::loadView('Vistas/pdfasistenciageneral', compact('nome', 'asistenciaPorSubevento'));
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Asistencia", null, 12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'), null, 12);
    
    return $pdf->stream();
}

}