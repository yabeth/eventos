@include('Vistas.Header')
            <div class="page-content fade-in-up">
                <div class="row">                    
                <div class="col-lg-3 col-md-6">  
                 <a href="{{ route('auditoriaevento') }}">  
                   <div class="ibox bg-info color-white widget-stat">  
                    <div class="ibox-body">  
                      <h3 class="m-b-5 font-strong">Auditoria de eventos</h3>  
                      <div class="m-b-5">S</div>  
                    <i class="fa fa-calendar evento-icon widget-stat-icon"></i>  
                 <div><i class="fa fa-level-up m-r-5"></i><small>.....</small></div>  
                </div>  
               </div>  
              </a>  
             </div>

                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('auditoriaInscripcion') }}">
                            <div class="ibox bg-danger color-white widget-stat">
                                <div class="ibox-body">
                                    <h3 class="m-b-5 font-strong">Auditoria de Inscripciones</h3>
                                    <div class="m-b-5">N</div><i class="fa fa-pencil widget-stat-icon"></i>
                                    <div><i class="fa fa-level-down m-r-5"></i><small>....</small></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('auditoriacertificado') }}">
                            <div class="ibox bg-pink color-white widget-stat">
                                <div class="ibox-body">
                                    <h3 class="m-b-5 font-strong">Auditoria de Certificados</h3>
                                    <div class="m-b-5">R</div><i class="fa fa-certificate widget-stat-icon"></i>
                                    <div><i class="fa fa-level-up m-r-5"></i><small>....</small></div>
                                </div>
                            </div>
                        </a>
                    </div>


                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('auditoriaAsistencia') }}">
                            <div class="ibox bg-silver-300 color-white widget-stat">
                                <div class="ibox-body">
                                    <h3 class="m-b-5 font-strong">Auditoria de Asistencias</h3>
                                    <div class="m-b-5">N</div>
                                    <i class="fa fa-check-circle widget-stat-icon"></i>
                                    <div><i class="fa fa-level-down m-r-5"></i><small>-12% Lower</small></div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('auditoriainforme') }}">
                            <div class="ibox bg-ebony color-white widget-stat">
                                <div class="ibox-body">
                                    <h3 class="m-b-5 font-strong">Auditoria de Informes</h3>
                                    <div class="m-b-5">R</div><i class="fa fa-file-text widget-stat-icon"></i>
                                    <div><i class="fa fa-level-up m-r-5"></i><small>.....</small></div>
                                </div>
                            </div>
                        </a>
                    </div>

                  


                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                
                
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@include('Vistas.Footer')