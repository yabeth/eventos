<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\permiso;
use App\Models\tipousuario;
use App\Models\datosperusu;
use App\Models\certificado;
use App\Models\evento;
use App\Models\persona;
use App\Models\evento_auditoria;
use App\Models\informe_auditoria;
use App\Models\certificado_auditoria;
use App\Models\informe;
use App\Models\inscripcion;
use App\Models\asistencia;
use App\Models\Asistencia_audit;
use App\Models\escuela;
use App\Models\Inscripcion_audit;
use Illuminate\Http\Request;
use App\Models\usuario;

class AuditoriaController extends Controller

{
    public function index()
    {
        $tipousuarios = tipousuario::all();
        $usuarios = Usuario::with('permisos')->get();
        $permisos = permiso::all();
        $datosperusus = datosperusu::with('usuario')->get(); // Revisa si necesitas esta consulta
        $personas = persona::with('genero')->get();
        $generos = genero::all();
    
        return view('Vistas/usuario', compact( 'permisos','usuarios','tipousuarios','datosperusus', 'personas', 'generos'));
    }
    public function auditoriaevento()
    {
        $evento_auditoria = evento_auditoria::all();
        $evento = evento::where('idevento','ideventooriginal')->get();
    
        return view('Vistas/auditoriaevento', compact( 'evento_auditoria','evento'));
    }
    public function auditoriacertificado()
    {
        $certificado_auditoria= certificado_auditoria::all();
        $certificado = certificado::where('idCertif','idoriginal')->get();
    
        return view('Vistas/auditoriacertificado', compact( 'certificado_auditoria','certificado'));
    }
    public function auditoriainforme()
    {
        $informe_auditoria= informe_auditoria::all();
        $informe = informe::where('idinforme','idoriginal')->get();
    
        return view('Vistas/auditoriainforme', compact( 'informe_auditoria','informe'));
    }

    public function auditoriaAsistencia() {
        $asistencia = Asistencia_Audit::select(
                'asistencia_audit.audit_id as id_auditoria',
                'asistencia_audit.operation as operacion',
                'tipoasiste.nomasis as tipo_asistencia',
                'estadoevento.nomestado as estado',
                'asistencia_audit.modified_at as fecha_modificacion',
                'asistencia_audit.nomusu'
            )
            ->join('tipoasiste', 'asistencia_audit.idtipasis', '=', 'tipoasiste.idtipasis')
            ->join('estadoevento', 'asistencia_audit.idestado', '=', 'estadoevento.idestadoeve')
            ->orderBy('asistencia_audit.modified_at', 'desc')
            ->get();

        return view('Vistas/auditoriaAsistencia', compact('asistencia'));
    }
    
    public function auditoriaInscripcion() {
        $inscripcion = Inscripcion_audit::select(
                'inscripcion_audit.audit_id as id_auditoria',
                'inscripcion_audit.operation as operacion',
                'escuela.nomescu as escuela',
                DB::raw('CONCAT(personas.nombre, " ", personas.apell) as personas'),
                'evento.eventnom as evento',
                'inscripcion_audit.modified_at as fecha_modificacion',
                'inscripcion_audit.nomusu'
            )
            ->join('escuela', 'inscripcion_audit.idescuela', '=', 'escuela.idescuela')
            ->join('personas', 'inscripcion_audit.idpersona', '=', 'personas.idpersona')
            ->join('evento', 'inscripcion_audit.idevento', '=', 'evento.idevento')
            ->orderBy('inscripcion_audit.modified_at', 'desc')
            ->get();
    
        return view('Vistas/auditoriaInscripcion', compact('inscripcion'));
    }
    
}
