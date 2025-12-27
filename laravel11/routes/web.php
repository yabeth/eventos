<?php
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\ModalevenController;   
use App\Http\Controllers\PersonaController; 
use App\Http\Controllers\TipoorgController;  
use App\Http\Controllers\OrganizadorController;  
use App\Http\Controllers\GeneroController; 
use App\Http\Controllers\EstadoEventoController;  
use App\Http\Controllers\TipoeventoController;  
use App\Http\Controllers\InformeController;  
use App\Http\Controllers\AsistenciaController;  
use App\Http\Controllers\FacultadController; 
use App\Http\Controllers\EventoController; 
use App\Http\Controllers\EventoorganizadorController; 
use App\Http\Controllers\AsignarponentController; 
use App\Http\Controllers\EscuelaController;
use App\Http\Controllers\UsuarioController;  
use App\Http\Controllers\CertificadoController; 
use App\Http\Controllers\InscripcionController;  
use App\Http\Controllers\ParticipanteController;
use App\Http\Controllers\DatosperusuController; 
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\ReportesController; 
use App\Http\Controllers\ResoluciaprobController;
use App\Http\Controllers\EstadisticaController;
use App\Http\Controllers\TiporesolucionController;
use App\Http\Controllers\TipousuarioController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\SubeventController;
use App\Http\Controllers\CanalController; 
use App\Http\Controllers\ModalidadController; 
use App\Http\Controllers\AuditoriaController;
use App\Http\Middleware\CheckPermiso;
use App\Http\Controllers\SubirimagenController;

use App\Http\Controllers\TipresolucionAgradController;
use App\Http\Controllers\TemaController;

use App\Http\Controllers\ConfCertificadosController;


use App\Http\Controllers\InasistenciaController;
use App\Http\Controllers\eventowebController;


Route::get('/eventoweb', [eventowebController::class, 'indexweb'])->name('vista.eventoweb');
Route::get('/eventos/{id}', [eventowebController::class, 'showeventodetalle'])->name('eventos.detalle');
Route::get('/api/participante/{dni}', [eventowebController::class, 'getParticipant'])->name('api.participante.buscar');
Route::post('/inscripcion/stores', [eventowebController::class, 'stores'])->name('Rut.inscrip.stores');


// rutas de asistencia
Route::middleware(['auth'])->group(function () {
    Route::get('/asistencia', [InasistenciaController::class, 'index'])->name('vista.ConAsistencia');
    Route::post('/asistencia/subevento-activo', [InasistenciaController::class, 'obtenerSubeventoActivo'])->name('asistencia.subeventoActivo');
    Route::post('/asistencia/participantes', [InasistenciaController::class, 'obtenerParticipantes'])->name('asistencia.participantes');
    Route::post('/asistencia/guardar', [InasistenciaController::class, 'guardarAsistencias'])->name('asistencia.guardar');
    Route::post('/asistencia/culminar', [InasistenciaController::class, 'culminarAsistencia'])->name('asistencia.culminar');

    Route::post('/asistencia/generarCertificados', [InasistenciaController::class, 'generarCertificados'])->name('asistencia.generarCertificados');
    Route::post('/asistencia/verificarEvento', [InasistenciaController::class, 'verificarEventoCompleto'])->name('asistencia.verificarEvento');
});


// Rutas del Con Certificado controller
Route::get('/Rut-certiss', [ConfCertificadosController::class, 'ConCertificado'])->name('Rut-certiss');
Route::post('/filter-by-eventos', [ConfCertificadosController::class, 'filterByEventos']); // Filtrar certificados por evento
Route::get('/Rut-certi', [ConfCertificadosController::class, 'ConCertificado'])->name('Rut-certi');
Route::post('/certificadonumero', [ConfCertificadosController::class, 'numcerocerti'])
    ->name('certificadonumero.numcerocerti');
Route::post('/certificados/generar-tokens', [ConfCertificadosController::class, 'generarTokens'])->name('certificados.generarTokens');
Route::post('/certificados/generar-token/{idCertif}', [ConfCertificadosController::class, 'generarTokenAjax'])->name('certificados.generarTokenAjax');

Route::post('/certificado/obtener-datos-evento', [ConfCertificadosController::class, 'obtenerDatosEvento'])->name('certificado.obtenerDatosEvento');
Route::post('/certificado/obtener-ultimo-folio', [ConfCertificadosController::class, 'obtenerUltimoFolio'])->name('certificado.obtenerUltimoFolio');
Route::post('/certificado/guardar-folio', [ConfCertificadosController::class, 'guardarFolio']) ->name('certificado.guardarFolio');
Route::post('/certificados/generar-tokens', [ConfCertificadosController::class, 'generarTokens'])->name('certificados.generarTokens');
Route::post('/certificado/cambiar-estado', [ConfCertificadosController::class, 'cambiarEstado'])->name('certificado.cambiarEstado');
Route::post('/certificados/buscar-por-dni', [ConfCertificadosController::class, 'buscarPorDni'])->name('certificados.buscarPorDni');
Route::get('/certificados/tipos', [ConfCertificadosController::class, 'getTipos'])->name('certificados.getTipos');
Route::get('/certificados/personas-por-tipo', [ConfCertificadosController::class, 'getPersonasPorTipo'])->name('certificados.getPersonasPorTipo');
Route::post('/certificados/generar-normales', [ConfCertificadosController::class, 'generarCertificadosNormales'])->name('certificados.generarNormales');
Route::post('/certificados/cambiar-estado', [ConfCertificadosController::class, 'cambiarEstadoPorEvento'])->name('certificados.cambiarEstado');
Route::post('/certificados/actualizar-numero', [ConfCertificadosController::class, 'actualizarNumeroCertificado'])->name('certificados.actualizarNumero');
Route::get('/generos/listar', [ConfCertificadosController::class, 'Mostrargenero'])->name('generos.listar');
Route::post('/personas/guardar', [ConfCertificadosController::class, 'GuardarPersona'])->name('personas.guardar');
Route::post('/certificados/subir-documento', [ConfCertificadosController::class, 'subirDocumento']);

Route::post('/evento-finalizado', [ConfCertificadosController::class, 'eventoFinalizado'])->name('evento.finalizado');
Route::post('/certificados-normal/eliminar/{id}', [ConfCertificadosController::class, 'destroyNormal']);


use App\Http\Controllers\TipoinformeController;
Route::post('/Rut-tipinfo', [TipoinformeController::class, 'store'])->name('Rut.tipinfo.store');
Route::put('/Rut-tipinfo/{idTipinfor}', [TipoinformeController::class, 'update'])->name('Rut.tipinfo.update');
Route::delete('/Rut-tipinfo/{idTipinfor}', [TipoinformeController::class, 'destroy'])->name('Rut.tipinfo.destroy');
Route::get('/buscar/tipinforme', [TipoinformeController::class, 'buscar'])->name('buscar.tipinforme');

// Route::post('/validateUser', [UsuarioController::class, 'validateUser'])->name('validateUser');
// Route::post('/updateUser', [UsuarioController::class, 'updateUser'])->name('updateUser');
// Route::get('/Rusuario',[UsuarioController::class, 'usuario'])->name('Rutususario'); 
// Route::post('/Rusuario', [UsuarioController::class, 'store'])->name('Rutususario.store');
// Route::delete('/Rusuario/{idusuario}', [UsuarioController::class, 'destroy'])->name('Rutususario.destroy');
// Route::get('/buscar/usuario', [UsuarioController::class, 'buscar'])->name('buscar.usuario');

// Rutas de Usuario
Route::get('/Rusuario', [UsuarioController::class, 'usuario'])->name('Rutususario');
Route::post('/Rusuario', [UsuarioController::class, 'store'])->name('Rutususario.store');
Route::post('/Rusuario/update/{idusuario}', [UsuarioController::class, 'update'])->name('Rutususario.update');
Route::post('/Rusuario/delete/{idusuario}', [UsuarioController::class, 'destroy'])->name('Rutususario.destroy');
Route::get('/buscar/usuario', [UsuarioController::class, 'buscar'])->name('buscar.usuario');
Route::post('/validateUser', [UsuarioController::class, 'validateUser'])->name('validateUser');
Route::post('/updateUser', [UsuarioController::class, 'updateUser'])->name('updateUser');
Route::get('/personas/buscar/{dni}', [UsuarioController::class, 'buscarPersonaPorDni'])
     ->name('personas.buscar');


Route::middleware(['auth',CheckPermiso::class])->group(function () {
 Route::get('/Rut-evento', [EventoController::class, 'evento'])->name('Rut.evento');
 Route::get('/Rut-asistenc',[AsistenciaController::class, 'asistencia'])->name('Rut.asistenc');  
 
 Route::get('/Rut-certi', [CertificadoController::class, 'certificado'])->name('Rut-certi'); 
 Route::get('/Rut-infor',[InformeController::class, 'informe'])->name('Rut.infor'); 
 Route::get('/Rut-escu', [EscuelaController::class, 'escuela'])->name('Rut.escu');
 Route::get('/Rut-facu', [FacultadController::class, 'facultad'])->name('Rut.facu');

 Route::get('/Rut-inscri', [InscripcionController::class, 'inscripcion'])->name('Rut.inscri');
 Route::get('/Rut-resoluci', [ResoluciaprobController::class, 'resolucion'])->name('Rut.reso');
 Route::get('/Rut-tipreso', [TiporesolucionController::class, 'tiporesolucion'])->name('Rut.tipreso');
 Route::get('/Rut-tipusu', [TipousuarioController::class, 'tipousuario'])->name('Rut.tipusu');
 Route::get('/reportes/reportes', [ReportesController::class, 'Vtareport'])->name('Vtareport');
 Route::get('/Rut-tipinfo', [TipoinformeController::class, 'tipoinforme'])->name('Rut.tipinfo');
 
 Route::get('/tipo-evento', [TipoeventoController::class, 'vistipeven'])->name('tipo.evento');
 Route::get('/auditorias', function () {return view('Vistas.auditoria');})->name('auditorias');
 Route::post('/inscripcion/store', [InscripcionController::class, 'store']);
 Route::get('/auditoria-inscripcion', [AuditoriaController::class, 'auditoriaInscripcion'])->name('auditoriaInscripcion');
 Route::post('/asistencia/store', [AsistenciaController::class, 'store']);
 Route::get('/auditoria-asistencia', [AuditoriaController::class, 'auditoriaAsistencia'])->name('auditoriaAsistencia');
 Route::get('/tema', [TemaController::class, 'index'])->name('tema.index');
  Route::get('/Rut-subevent', [SubeventController::class, 'subevent'])->name('Rut.subevent');
    Route::get('/tipresolucionagrad', [TipresolucionAgradController::class, 'index'])->name('tipresolucionagrad.index');
    Route::get('/Rut-ponent', [AsignarponentController::class, 'asignarponent'])->name('Rut.ponent');

});


Route::middleware(['auth'])->group(function () {

Route::post('/Rut-evento', [EventoController::class, 'store'])->name('Rut.evento.store');
   
  });


Route::post('/Rut-resoluci', [ResoluciaprobController::class, 'store'])->name('Rut.reso.store');
Route::put('/Rut-resoluci/{idreslaprb}', [ResoluciaprobController::class, 'update'])->name('Rut.reso.update');
Route::delete('/Rut-resoluci/{idreslaprb}', [ResoluciaprobController::class, 'destroy'])->name('Rut.reso.destroy');
Route::get('/buscar/resolucion', [ResoluciaprobController::class, 'buscar'])->name('buscar.resolucion');
Route::put('Rut-certi/{idevento}', [CertificadoController::class, 'culeven'])->name('Rut.reso.culeven');


Route::get('/auditorias/evento',[AuditoriaController::class, 'auditoriaevento'])->name('auditoriaevento');
Route::get('/auditorias/certificado',[AuditoriaController::class, 'auditoriacertificado'])->name('auditoriacertificado');
Route::get('/auditorias/informe',[AuditoriaController::class, 'auditoriainforme'])->name('auditoriainforme');

Route::get('/auditoria-asistencia', [AuditoriaController::class, 'auditoriaAsistencia'])->name('auditoriaAsistencia');
Route::get('/auditoria-inscripcion', [AuditoriaController::class, 'auditoriaInscripcion'])->name('auditoriaInscripcion');

Route::post('/tipo-evento', [TipoeventoController::class, 'store'])->name('tipo.evento.store');


Route::get('/sinpermiso', [PermisoController::class, 'abrir'])->name('sinpermiso');

Route::post('/Rusuario/permiso/{idusuario}', [PermisoController::class, 'store'])->name('PermisoUsuario');

Route::post('/usuarios/permisos/{idusuario}', [PermisoController::class, 'index'])->name('permisos.index');

Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');

// Rutas de estadisticas
Route::get('/api/eventos/tipo', [EstadisticaController::class, 'eventosPorTipo'])
    ->name('api.eventos.tipo');
Route::get('/api/distribucion-eventos', [EstadisticaController::class, 'distribucionTipoEvento'])->name('api.eventos.distribucion');
Route::get('/eventos-con-informe', [EstadisticaController::class, 'eventosConInforme'])->name('eventos.informe');
Route::get('/eventos-con-resolucion', [EstadisticaController::class, 'eventosConResolucion']);
Route::get('/certificados-evento', [EstadisticaController::class, 'certificadosPorEvento']);
Route::get('/get-participantes-por-escuela', [EstadisticaController::class, 'getParticipantesPorEscuela']);
Route::get('/estadisticas-eventos', [EstadisticaController::class, 'estadisticasEventos'])->name('estadisticas.eventos');
Route::get('/participantes-por-facultad', [EstadisticaController::class, 'getParticipantesPorFacultad'])->name('participante.facultad');
Route::get('/estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas.index');
Route::get('/eventos-proximos', [EstadisticaController::class, 'eventosproximos'])->name('api.eventos.proximos');
Route::get('/eventos-por-ano', [EstadisticaController::class, 'eventosPorMesAno'])->name('eventos.mes.ano');


Route::get('/', [LoginController::class, 'login'])->name('login');
Route::get('/principal', function () {return view('Vistas.principal');})->name('principal');

Route::get('/reportes/pdffac', [ReportesController::class, 'pdfFacultades'])->name('Vistas.pdffac');
Route::get('/reportes/pdfescu', [ReportesController::class, 'pdfEscuelas'])->name('Vistas.pdfescu');

Route::get('/export-certificados-excel', [ReportesController::class, 'exportCertificadosExcel'])
    ->name('export.certificados.excel');

//Route::get('/Rut-infor',[InformeController::class, 'informe'])->name('Rut.infor'); 
Route::post('/Rut-infor', [InformeController::class, 'store'])->name('Rut.infor.store');
Route::put('/Rut-infor/{idinforme}', [InformeController::class, 'update'])->name('Rut.infor.update');
Route::delete('/Rut-infor/{idinforme}', [InformeController::class, 'destroy'])->name('Rut.infor.destroy');
Route::get('/buscar/informe', [InformeController::class, 'buscar'])->name('buscar.informe');

Route::get('/incripcion/incrifec', [ReportesController::class, 'pdfinscritosfecha'])->name('incritosfecha');
Route::get('/reportes/incrifecxeve', [ReportesController::class, 'pdfinscritosfechaeven'])->name('incritosfechaxevento');

Route::get('/usuario/rusuario', [ReportesController::class, 'pdfusuario'])->name('reportusuario');
Route::get('/auditoria/rauditeven', [ReportesController::class, 'pdfauditeventofecha'])->name('auditevenfecha');



Route::post('/filter-by-eve', [CertificadoController::class, 'filterByEve']);
Route::post('/Rut-certi/update/{idCertif}', [CertificadoController::class, 'update'])->name('Rut.certi.update');
Route::post('/Rut-certi/updat/{idCertif}', [CertificadoController::class, 'updat'])->name('Rut.certi.updat');
Route::post('/certificado/updateCertificacion/{selectedEventId}', [CertificadoController::class, 'updateCertificacion']);
Route::post('/certificadonum', [CertificadoController::class, 'numcer'])->name('certificadonum.numcer');
Route::get('/buscar/certi', [CertificadoController::class, 'buscar'])->name('buscar.certi');
Route::get('/event/{idevento}', [CertificadoController::class, 'getDescription']);


//Route::get('/tipo-evento', [TipoeventoController::class, 'vistipeven'])->name('tipo.evento');
Route::put('/tipo-evento/{idTipoeven}', [TipoeventoController::class, 'update'])->name('tipo.evento.update');
Route::delete('/tipo-evento/{idTipoeven}', [TipoeventoController::class, 'destroy'])->name('tipo.evento.destroy');
Route::get('/buscar/tipeven', [TipoeventoController::class, 'buscar'])->name('buscar.tipeven');


// Route::get('/Rut-facu', [FacultadController::class, 'facultad'])->name('Rut.facu');
Route::post('/Rut-facu', [FacultadController::class, 'store'])->name('Rut.facu.store');
Route::put('/Rut-facu/{idfacultad}', [FacultadController::class, 'update'])->name('Rut.facu.update');
Route::delete('/Rut-facu/{idfacultad}', [FacultadController::class, 'destroy'])->name('Rut.facu.destroy');
Route::get('/buscar/facultad', [FacultadController::class, 'buscar'])->name('buscar.facultad');

//Route::get('/Rut-evento', [EventoController::class, 'evento'])->name('Rut.evento');
Route::put('/Rut-evento/{idevento}', [EventoController::class, 'update'])->name('Rut.evento.update');
Route::delete('/Rut-evento/{idevento}', [EventoController::class, 'destroy'])->name('Rut.evento.destroy');
Route::get('/buscar/evento', [EventoController::class, 'buscar'])->name('buscar.evento');

//Route::get('/Rut-escu', [EscuelaController::class, 'escuela'])->name('Rut.escu');
Route::post('/Rut-escu', [EscuelaController::class, 'store'])->name('Rut.escu.store');
Route::put('/Rut-escu/{idescuela}', [EscuelaController::class, 'update'])->name('Rut.escu.update');
Route::delete('/Rut-escu/{idescuela}', [EscuelaController::class, 'destroy'])->name('Rut.escu.destroy');
Route::get('/buscar/escuela', [EscuelaController::class, 'buscar'])->name('buscar.escuela');

Route::get('/Rut-tipoorg', [TipoorgController::class, 'tipoorg'])->name('Rut.tipoorg');
Route::post('/Rut-tipoorg', [TipoorgController::class, 'store'])->name('Rut.tipoorg.store');
Route::put('/Rut-tipoorg/{idtipo}', [TipoorgController::class, 'update'])->name('Rut.tipoorg.update');
Route::delete('/Rut-tipoorg/{idtipo}', [TipoorgController::class, 'destroy'])->name('Rut.tipoorg.destroy');
Route::get('/buscar/tipoorg', [TipoorgController::class, 'buscar'])->name('buscar.tipoorg');



Route::get('/Rut-evenorg', [EventoorganizadorController::class, 'evenorg'])->name('Rut.evenorg');
Route::post('/Rut-evenorg', [EventoorganizadorController::class, 'store'])->name('Rut.evenorg.store');
Route::put('/Rut-evenorg/{idevento}/{idorg}', [EventoorganizadorController::class, 'update'])->name('Rut.evenorg.update');
Route::delete('/Rut-evenorg/{idevento}/{idorg}', [EventoorganizadorController::class, 'destroy'])->name('Rut.evenorg.destroy');


Route::get('/Rut-orga', [OrganizadorController::class, 'organizador'])->name('Rut.orga');
Route::post('/Rut-orga', [OrganizadorController::class, 'store'])->name('Rut.orga.store');
Route::put('/Rut-orga/{idorg}', [OrganizadorController::class, 'update'])->name('Rut.orga.update');
Route::delete('/Rut-orga/{idorg}', [OrganizadorController::class, 'destroy'])->name('Rut.orga.destroy');


// Route::get('/Rut-inscri', [InscripcionController::class, 'inscripcion'])->name('Rut.inscri');
Route::post('/Rut-inscri', [InscripcionController::class, 'store'])->name('Rut.inscri.store');
Route::put('/Rut-inscri/{idincrip}', [InscripcionController::class, 'update'])->name('Rut.inscri.update');
Route::delete('/Rut-inscri/{idincrip}', [InscripcionController::class, 'destroy'])->name('Rut.inscri.destroy');
Route::get('/participant/{dni}', [InscripcionController::class, 'getParticipant']);
// Route::post('/filter-by-event', [InscripcionController::class, 'filterByEvent']);
// Route::post('/filter-by-eventt', [InscripcionController::class, 'filterByEventt'])->name('filter.by.event');
// En tu archivo de rutas (web.php)
Route::post('/filter-by-event', [InscripcionController::class, 'filterByEvent'])->name('filter.by.event');
// En tu archivo routes/web.php
Route::post('eliminar-inscripciones-evento', [InscripcionController::class, 'destroyAllByEvent'])
    ->name('Rut.inscri.destroyAllByEvent');



//Route::get('/Rut-asistenc',[AsistenciaController::class, 'asistencia'])->name('Rut.asistenc');  
Route::put('/Rut-asistenc/{idasistnc}', [AsistenciaController::class, 'update'])->name('Rut.asistenc.update');
Route::delete('/Rut-asistenc/{idasistnc}', [AsistenciaController::class, 'destroy'])->name('Rut.asistenc.destroy');
Route::post('/filter-by-even', [AsistenciaController::class, 'filterByEven']);
Route::post('/Rut-asistenc-update-multiple', [AsistenciaController::class, 'updateMultiple'])->name('Rut.asistenc.updateMultiple');
Route::get('/buscar/asistencia', [AsistenciaController::class, 'buscar'])->name('buscar.asistencia');
Route::put('Rut-asist/{idevento}', [AsistenciaController::class, 'cambioestad'])->name('Rut.asist.cambioestad');

Route::get('/asisten/rasistencia', [ReportesController::class, 'pdfasistencia'])->name('reportasistencia');
Route::get('/evento/evenfec', [ReportesController::class, 'pdfeventofecha'])->name('eventofecha');
Route::get('/evento/evento', [ReportesController::class, 'pdfevento'])->name('reportevento');
Route::get('/certificado/certificado', [ReportesController::class, 'pdfcertificado'])->name('reportcertificado');

Route::get('/certificado/certificados', [ReportesController::class, 'pdfcertificadoexter'])->name('reportcertificadoexter');
Route::get('/certificado/certificadoxevento', [ReportesController::class, 'pdfcertificadogeneral'])->name('reportcertificadoxevento');

Route::get('/inscripcion/rinscripcion', [ReportesController::class, 'pdfinscripcion'])->name('reportinscripcion');
Route::get('/inscripcion/rinscripcionpe', [ReportesController::class, 'pdfinscritosxevento'])->name('reportinscripcionporevento');

// Route::get('/Rut-resoluci', [ResoluciaprobController::class, 'resolucion'])->name('Rut.reso');



//Route::get('/reportes/reportes', [ReportesController::class, 'Vtareport'])->name('Vtareport');
Route::get('/reportes/rcerti', [ReportesController::class, 'rcerti'])->name('reportcerti');
Route::get('/reportes/reventop', [ReportesController::class, 'reventop'])->name('reportevenp');
Route::get('/reportes/reventof', [ReportesController::class, 'reventof'])->name('reportevenf');
Route::post('/reportes/revenxfacuxescu', [ReportesController::class, 'pdfevenxescuxfacu'])->name('reportxesxfaxev');
Route::post('/asisten/rpresentes', [ReportesController::class, 'rpresentes'])->name('reportasis');
Route::get('/asisten/rgeneral', [ReportesController::class, 'rasistenciageneral'])->name('asistenciageneral');
Route::get('/asisten/rasistencia', [ReportesController::class, 'pdfasistencia'])->name('reportasistencia');



// Route::get('/Rut-tipreso', [TiporesolucionController::class, 'tiporesolucion'])->name('Rut.tipreso');
Route::post('/Rut-tipreso', [TiporesolucionController::class, 'store'])->name('Rut.tipreso.store');
Route::put('/Rut-tipreso/{idTipresol}', [TiporesolucionController::class, 'update'])->name('Rut.tipreso.update');
Route::delete('/Rut-tipreso/{idTipresol}', [TiporesolucionController::class, 'destroy'])->name('Rut.tipreso.destroy');


//Route::get('/Rut-tipusu', [TipousuarioController::class, 'tipousuario'])->name('Rut.tipusu');
Route::post('/Rut-tipusu', [TipousuarioController::class, 'store'])->name('Rut.tipusu.store');
Route::put('/Rut-tipusu/{idTipUsua}', [TipousuarioController::class, 'update'])->name('Rut.tipusu.update');
Route::delete('/Rut-tipusu/{idTipUsua}', [TipousuarioController::class, 'destroy'])->name('Rut.tipusu.destroy');

// Ruta para mostrar el formulario de subir imágenes
Route::get('/subirimagen', [SubirimagenController::class, 'index'])->name('subirimagen.index');
// Ruta para subir una imagen
Route::post('/subirimagen', [SubirimagenController::class, 'store'])->name('subirimagen.store');
// Ruta para eliminar una imagen
// Route::delete('/subirimagen/{id}', [SubirimagenController::class, 'destroy'])->name('subirimagen.destroy');
Route::delete('/subirimagen/{id}', [SubirimagenController::class, 'destroy'])->name('subirimagen.destroy');



// Rutas para el controlador TipresolucionAgradController
Route::post('/tipresolucionagrad', [TipresolucionAgradController::class, 'store'])->name('tipresolucionagrad.store');
Route::put('/tipresolucionagrad/{id}', [TipresolucionAgradController::class, 'update'])->name('tipresolucionagrad.update');
Route::delete('/tipresolucionagrad/{id}', [TipresolucionAgradController::class, 'destroy'])->name('tipresolucionagrad.destroy');

// Rutas para el controlador TemaController

Route::post('/tema', [TemaController::class, 'store'])->name('tema.store');
Route::put('/tema/{id}', [TemaController::class, 'update'])->name('tema.update');
Route::delete('/tema/{id}', [TemaController::class, 'destroy'])->name('tema.destroy');

// Rutas para el controlador subeventosController
Route::post('/Rut-subevent', [SubeventController::class, 'store'])->name('Rut.subevent.store');
Route::put('/Rut-subevent/{idsubevent}', [SubeventController::class, 'update'])->name('Rut.subevent.update');
Route::delete('/subevent/{idsubevent}', [SubeventController::class, 'destroy'])->name('subevent.destroy');

Route::get('/cargar-ponentes', [AsignarponentController::class, 'cargarPonentes'])->name('ponentes.cargar');
// Rutas para el controlador ponentesController
Route::get('/ponentes/filtrar', [AsignarponentController::class, 'filtrarPorEvento'])->name('ponentes.filtrar');
Route::get('/ponentes/cargar', [AsignarponentController::class, 'cargarPonentes'])->name('ponentes.cargar');
Route::get('/persona/buscar-dni', [AsignarponentController::class, 'buscarPorDni'])->name('persona.buscar.dni');
Route::post('/ponentes/agregar', [AsignarponentController::class, 'agregarPonente'])->name('ponentes.agregar');
Route::post('/ponentes/actualizar', [AsignarponentController::class, 'actualizarPonente'])->name('ponentes.actualizar');
Route::delete('/ponentes/eliminar', [AsignarponentController::class, 'eliminarPonente'])->name('ponentes.eliminar');


// Rutas para gestión de canales
Route::get('/canales', [CanalController::class, 'index'])->name('canales.index');
Route::get('/canales/por-modalidad/{idmodal}', [CanalController::class, 'getPorModalidad'])->name('canales.porModalidad');
Route::post('/canales', [CanalController::class, 'store'])->name('canales.store');
Route::put('/canales/{idcanal}', [CanalController::class, 'update'])->name('canales.update');
Route::delete('/canales/{idcanal}', [CanalController::class, 'destroy'])->name('canales.destroy');
Route::get('/subeventos/rsubevent', [ReportesController::class, 'pdfSubeventosPorEvento'])->name('reporSubeventosPorEvento');
Route::get('/subeventos/rsubeventt', [ReportesController::class, 'pdfTodosLosSubeventos'])->name('reprTodosLosSubeventos');



use Illuminate\Support\Facades\Artisan;

Route::get('/crear-link-storage', function () {
    try {Artisan::call('storage:link');
        return "¡Enlace storage creado correctamente! Ya puedes ver los archivos subidos.";
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
});