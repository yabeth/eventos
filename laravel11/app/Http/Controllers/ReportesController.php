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
    // Obtener todas las escuelas
    $escuelas = escuela::all();

    // Obtener la fecha y hora actual en la zona horaria correcta
    $currentDateTime = Carbon::now(config('app.timezone'))->format('d-m-Y / H:i:s');

    // Pasar los datos a la vista, incluyendo la fecha y hora
    $pdf = \PDF::loadView('Vistas/pdfescu', compact('escuelas', 'currentDateTime'));

    // Configurar el PDF
    $this->configurarPDF($pdf);

    // Generar y retornar el PDF
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
    //$canvas->page_text(270, 800,"Página (PAGE_NUM) de (PAGE_COUNT)", null, 5);
    //$canvas->page_text(450, 800,"Fechaa: ".\Carbon\Carbon::now()->format('d/m/y')." - ".\Carbon\Carbon);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'),null,12);
    $currentDateTime = Carbon::now(config('app.timezone'))->format('d-m-Y / H:i:s');
    return $pdf->stream();

}

public function pdfinscritosfechaeven(Request $request)
{
    //$datos= request
    $fecinicio = $request->input(key:'fecinic');
    $fecfin = $request->input(key:'fecfin');
    $idevento = $request->input(key:'ideven');
    //$evento = evento::where('idevento',);
    $nome = evento::where('idevento', $idevento)->pluck('eventnom')->first();

    //$inscritos= inscripcion::whereBetween('fecinscripcion',[$fecinicio, $fecfin])->get();
    $inscritos = inscripcion::join('personas', 'inscripcion.idpersona', '=', 'personas.idpersona')
    ->orderBy('personas.apell', 'asc')
    ->where('idevento', $idevento)
    ->whereBetween('fecinscripcion',[$fecinicio, $fecfin])
    ->get(['inscripcion.*', 'personas.apell', 'personas.nombre']);
    // Si no hay eventos, redirigir de vuelta con un error
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



public function pdfinscritosfecha(Request $request)
{
    //$datos= request
    $fecinicio = $request->input(key:'fecinic');
    $fecfin = $request->input(key:'fecfin');
    //$eventos= evento::all();

    //$inscritos= inscripcion::whereBetween('fecinscripcion',[$fecinicio, $fecfin])->get();
    $inscritos = inscripcion::join('personas', 'inscripcion.idpersona', '=', 'personas.idpersona')
    ->orderBy('personas.apell', 'asc')
    ->whereBetween('fecinscripcion',[$fecinicio, $fecfin])
    ->get(['inscripcion.*', 'personas.apell', 'personas.nombre']);
    // Si no hay eventos, redirigir de vuelta con un error
    if ($inscritos->isEmpty()) {
        return redirect()->back()->with('error', 'No hay datos disponibles para las fechas seleccionadas.');
    }
    else{
    $pdf = \PDF::loadView('Vistas/pdfinscritosfecha',compact('inscritos','fecinicio','fecfin'));
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
    //$datos= request
    $fecinicio = $request->input(key:'fecinic');
    $fecfin = $request->input(key:'fecfin');
    //$eventos= evento::all();

    $eventos= evento::whereBetween('fecini',[$fecinicio, $fecfin])->get();
    $audit= evento_auditoria::whereBetween('fecha_operacion',[$fecinicio, $fecfin])->get();

    // Si no hay eventos, redirigir de vuelta con un error
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
    //$datos= request
    $fecinicio = $request->input(key:'fecinic');
    $fecfin = $request->input(key:'fecfin');
    //$eventos= evento::all();

    $eventos= evento::whereBetween('fecini',[$fecinicio, $fecfin])->get();

    // Si no hay eventos, redirigir de vuelta con un error
    if ($eventos->isEmpty()) {
        return redirect()->back()->with('error', 'No hay datos disponibles para las fechas seleccionadas.');
    }
    else{
    $pdf = \PDF::loadView('Vistas/pdfeventofecha',compact('eventos','fecinicio','fecfin'))
    ->setPaper('a4', 'landscape')  
    ->setOption('margin-top', 20)   // Ajusta según sea necesario  
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
    ->setOption('margin-top', 20)   // Ajusta según sea necesario  
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



public function pdfcertificado()
{
    $certificado= certificado::all();
    $pdf = \PDF::loadView('Vistas/pdfcertificado',compact('certificado'));
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(75, 800, "Reporte de Certificados", null,10);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'),null,10);
    $currentDateTime = Carbon::now(config('app.timezone'))->format('d-m-Y / H:i:s');
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
  //  $inscritos = inscripcion::where('idevento', $idevent)->get();  

    $inscritos = inscripcion::join('personas', 'inscripcion.idpersona', '=', 'personas.idpersona')
    ->where('idevento', $idevent)
    ->orderBy('personas.apell', 'asc') 
    ->get(['inscripcion.*', 'personas.apell', 'personas.nombre']);
    //$nome = evento::where('idevento',$idevent)->get('eventnom');
    // Si no hay eventos, redirigir de vuelta con un error
    if ($inscritos->isEmpty()) {
        return redirect()->back()->with('error', 'No hay datos disponibles para el evento seleccionado.');
    }
    $nome = evento::where('idevento', $idevent)->pluck('eventnom')->first();
    $pdf = \PDF::loadView('Vistas/pdfinscritosxevento',compact('idevent','inscritos','nome'));
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de inscritos", null,12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'),null,12);
    $currentDateTime = Carbon::now(config('app.timezone'))->format('d-m-Y / H:i:s');
    return $pdf->stream();

}


public function rcerti(Request $request)
{
    $ideven = $request->input('ideven');
    $action = $request->input('action');

    $nome = evento::where('idevento', $ideven)->pluck('eventnom')->first();
    $inscritos = inscripcion::where('idevento', $ideven)->get();
    $inscripcionIds = $inscritos->pluck('idincrip')->toArray();
    $idasistentes = asistencia::whereIn('idincrip', $inscripcionIds)
        ->where('idtipasis', 1)->pluck('idasistnc')->toArray();

    // Si no hay asistentes, mostramos un mensaje de error
    if (empty($idasistentes)) {
        return redirect()->back()->with('error', 'No se encontraron asistentes.');
    }

    // Reporte de certificados entregados o pendientes
    $entregado = certificado::whereIn('idasistnc', $idasistentes)->where('idestcer', 2)->get();
    $pendiente = certificado::whereIn('idasistnc', $idasistentes)->where('idestcer', 3)->get();

    // Validar si hay datos en el reporte
    if ($action == 'entregado' && $entregado->isEmpty()) {
        return redirect()->back()->with('error', 'No hay certificados entregados.');
    } elseif ($action == 'pendiente' && $pendiente->isEmpty()) {
        return redirect()->back()->with('error', 'No hay certificados pendientes por entregar.');
    }

    // Generar el PDF solo si hay datos
    if ($action == 'entregado') {
        $pdf = \PDF::loadView('Vistas/pdfentregado', compact('ideven', 'inscritos', 'entregado', 'nome'));
    } elseif ($action == 'pendiente') {
        $pdf = \PDF::loadView('Vistas/pdfpendiente', compact('ideven', 'inscritos', 'pendiente', 'nome'));
    }

    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Asistencia a un evento", null, 12);
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
    
    // Obtener inscritos y asistentes/ausentes
    $inscritos = inscripcion::where('idevento', $ideven)->get();
    $inscripcionIds = $inscritos->pluck('idincrip')->toArray();
    $asistentes = asistencia::whereIn('idincrip', $inscripcionIds)->where('idtipasis', 1)->get();
    $ausentes = asistencia::whereIn('idincrip', $inscripcionIds)->where('idtipasis', 2)->get();

    // Verificar si no hay asistentes o ausentes
    if ($action == 'presentes' && $asistentes->isEmpty()) {
        return redirect()->back()->with('error', 'No hay datos de personas presentes.');
    } elseif ($action == 'ausentes' && $ausentes->isEmpty()) {
        return redirect()->back()->with('error', 'No hay datos de personas ausentes.');
    }

    // Generar PDF solo si hay datos
    if ($action == 'presentes') {
        $pdf = \PDF::loadView('Vistas/pdfpresentes', compact('ideven', 'inscritos', 'asistentes', 'ausentes', 'nome'));
    } elseif ($action == 'ausentes') {
        $pdf = \PDF::loadView('Vistas/pdfausentes', compact('ideven', 'inscritos', 'asistentes', 'ausentes', 'nome'));
    }

    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Asistencia a un evento", null, 12);
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


public function pdfevenxescuxfacu(Request $request)
{
    $ideven = $request->input('ideven');
    $action = $request->input('action');
    $nome = evento::where('idevento', $ideven)->pluck('eventnom')->first();

    // Obtener inscritos
    $inscritos = inscripcion::where('idevento', $ideven)->get();
    $inscripcionIds = $inscritos->pluck('idincrip')->toArray();

    // Obtener asistencia
    $asistencia = asistencia::whereIn('idincrip', $inscripcionIds)->get();

    // Relacionar con las escuelas
    $escuelas = escuela::whereIn('idescuela', $inscritos->pluck('idescuela'))->get();
    $facultad = facultad::whereIn('idfacultad', $escuelas->pluck('idfacultad'))->get();
    
    // Inicializar variables
    $asistentesPorEscuela = [];
    $asistentesPorFacultad = [];

    // Acción por escuela
    if ($action == 'escuela') {
        foreach ($escuelas as $escuela) {
            $asistentes = $asistencia->filter(function ($asistente) use ($escuela) {
                return $asistente->inscripcion->idescuela == $escuela->idescuela;
            });
            if ($asistentes->isNotEmpty()) {
                $asistentesPorEscuela[$escuela->nomescu] = $asistentes;
            }
        }

        if (empty($asistentesPorEscuela)) {
            return redirect()->back()->with('mensaje', 'No hay datos de asistentes por escuela en el evento.');
        }
        
        $pdf = \PDF::loadView('Vistas/pdfevxescuela', compact('nome', 'asistentesPorEscuela'));

    // Acción por facultad
    } elseif ($action == 'facultad') {
        foreach ($facultad as $facu) {
            $asistentes = $asistencia->filter(function ($asistente) use ($facu) {
                return $asistente->inscripcion->escuela->idfacultad == $facu->idfacultad;
            });
            if ($asistentes->isNotEmpty()) {
                $asistentesPorFacultad[$facu->nomfac] = $asistentes;
            }
        }

        if (empty($asistentesPorFacultad)) {
            return redirect()->back()->with('mensaje', 'No hay datos de asistentes por facultad en el evento.');
        }

        $pdf = \PDF::loadView('Vistas/pdfevxfacultad', compact('nome', 'asistentesPorFacultad'));
    }

    // Personalizar el PDF
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Participantes", null, 12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'), null, 12);

    return $pdf->stream();
}




public function pdfpresentesxescuxfac(Request $request) 
{
    $ideven = $request->input('ideven');
    $action = $request->input('action');
    $nome = evento::where('idevento', $ideven)->pluck('eventnom')->first();

    // Obtener inscritos
    $inscritos = inscripcion::where('idevento', $ideven)->get();
    $inscripcionIds = $inscritos->pluck('idincrip')->toArray();

    // Obtener asistencia
    $asistencia = asistencia::whereIn('idincrip', $inscripcionIds)->where('idtipasis', 1)->get();

    // Relacionar con las escuelas
    $escuelas = escuela::whereIn('idescuela', $inscritos->pluck('idescuela'))->get();
    $facultad = facultad::whereIn('idfacultad', $escuelas->pluck('idfacultad'))->get();

    // Variables para almacenar los asistentes por escuela o facultad
    $asistentesPorEscuela = [];
    $asistentesPorFacultad = [];

    // Acción por escuela
    if ($action == 'escuela') {
        foreach ($escuelas as $escuela) {
            $asistentes = $asistencia->filter(function ($asistente) use ($escuela) {
                return $asistente->inscripcion->idescuela == $escuela->idescuela;
            });
            if ($asistentes->isNotEmpty()) {
                $asistentesPorEscuela[$escuela->nomescu] = $asistentes;
            }
        }

        // Verificar si hay asistentes
        if (empty($asistentesPorEscuela)) {
            return redirect()->back()->with('error', 'No hay presentes en el evento.');
        } else {
            $pdf = \PDF::loadView('Vistas/pdfpresentesxescu', compact('nome', 'asistentesPorEscuela'));
        }

    // Acción por facultad
    } elseif ($action == 'facultad') {
        foreach ($facultad as $facu) {
            $asistentes = $asistencia->filter(function ($asistente) use ($facu) {
                return $asistente->inscripcion->escuela->idfacultad == $facu->idfacultad;
            });
            if ($asistentes->isNotEmpty()) {
                $asistentesPorFacultad[$facu->nomfac] = $asistentes;
            }
        }

        // Verificar si hay asistentes
        if (empty($asistentesPorFacultad)) {
            return redirect()->back()->with('error', 'No hay presentes en el evento.');
        } else {
            $pdf = \PDF::loadView('Vistas/pdfpresentesxfac', compact('nome', 'asistentesPorFacultad'));
        }
    }

    // Personalizar el PDF
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Participantes", null, 12);
    $canvas->page_text(270, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
    $canvas->page_text(450, 800, "Fecha: " . \Carbon\Carbon::now()->format('d/m/y'), null, 12);

    return $pdf->stream();
}



public function pdfausentesxescuxfac(Request $request) 
{
    $ideven = $request->input('ideven');
    $action = $request->input('action');
    $nome = evento::where('idevento', $ideven)->pluck('eventnom')->first();

    // Obtener inscritos
    $inscritos = inscripcion::where('idevento', $ideven)->get();
    $inscripcionIds = $inscritos->pluck('idincrip')->toArray();

    // Obtener asistencia
    $asistencia = asistencia::whereIn('idincrip', $inscripcionIds)->where('idtipasis', 2)->get();

    // Relacionar con las escuelas
    $escuelas = escuela::whereIn('idescuela', $inscritos->pluck('idescuela'))->get();
    $facultad = facultad::whereIn('idfacultad', $escuelas->pluck('idfacultad'))->get();

    // Variables para almacenar los asistentes por escuela o facultad
    $asistentesPorEscuela = [];
    $asistentesPorFacultad = [];

    // Acción por escuela
    if ($action == 'escuela') {
        foreach ($escuelas as $escuela) {
            $asistentes = $asistencia->filter(function ($asistente) use ($escuela) {
                return $asistente->inscripcion->idescuela == $escuela->idescuela;
            });
            if ($asistentes->isNotEmpty()) {
                $asistentesPorEscuela[$escuela->nomescu] = $asistentes;
            }
        }

        // Verificar si hay asistentes
        if (empty($asistentesPorEscuela)) {
            return redirect()->back()->with('error', 'No hay ausentes en el evento.');
        } else {
            $pdf = \PDF::loadView('Vistas/pdfausentesxescu', compact('nome', 'asistentesPorEscuela'));
        }

    // Acción por facultad
    } elseif ($action == 'facultad') {
        foreach ($facultad as $facu) {
            $asistentes = $asistencia->filter(function ($asistente) use ($facu) {
                return $asistente->inscripcion->escuela->idfacultad == $facu->idfacultad;
            });
            if ($asistentes->isNotEmpty()) {
                $asistentesPorFacultad[$facu->nomfac] = $asistentes;
            }
        }

        // Verificar si hay asistentes
        if (empty($asistentesPorFacultad)) {
            return redirect()->back()->with('error', 'No hay ausentes en el evento.');
        } else {
            $pdf = \PDF::loadView('Vistas/pdfausentesxfac', compact('nome', 'asistentesPorFacultad'));
        }
    }

    // Personalizar el PDF
    $pdf->output();
    $dompdf = $pdf->getDomPDF();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(55, 800, "Reporte de Participantes", null, 12);
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

}