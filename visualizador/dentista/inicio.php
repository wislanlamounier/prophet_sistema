                    <?php include_once('visualizador/_inc/master.inc.php'); ?>

                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content p-md">
                                <div class="col-md-12 text-center">
                                    <a id="geral">
                                        <b>Ver gráfico geral</b>
                                    </a>
                                </div>
                                <div class="col-md-12">
                                    <h3 class="page-header">
                                        Seu gráfico
                                    </h3>
                                    <b style="color: rgba(26,179,148,1)!important">Consultas</b>
                                    -
                                    <b style="color: rgba(220,220,220,1)!important">Desmarques</b>
                                    -
                                    <b style="color: rgba(122, 147, 255, 1)!important">Faltas</b>
                                    -
                                    <b style="color: rgba(255, 168, 211, 1)!important">Remarques</b>
                                </div>
                                <div>
                                    <canvas id="lineChart" height="140"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal inmodal" id="modalGeral" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content animated fadeIn">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Fechar</span>
                                    </button>
                                    <i class="fa fa-area-chart modal-icon"></i>
                                    <h4 class="modal-title">Gráfico da clínica</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-12">
                                        <h3 class="page-header">
                                            Legenda
                                        </h3>
                                        <b style="color: rgba(26,179,148,1)!important">Consultas</b>
                                        -
                                        <b style="color: rgba(220,220,220,1)!important">Desmarques</b>
                                        -
                                        <b style="color: rgba(122, 147, 255, 1)!important">Faltas</b>
                                        -
                                        <b style="color: rgba(255, 168, 211, 1)!important">Remarques</b>
                                    </div>
                                    <div class="col-md-12">
                                        <canvas id="graficoGeral"></canvas>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>