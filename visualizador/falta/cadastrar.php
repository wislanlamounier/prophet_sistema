                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content text-center p-md">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>
                                            <span class="text-navy">Tem certeza que deseja marcar falta para a consulta prevista para às
                                            <?php echo $dtoConsulta->getHoraConsulta(); ?> do dia <?php echo $dtoConsulta->getDatConsulta(true); ?>
                                            para o paciente <?php echo $this->link('paciente', 'consultarFim', $arrPaciente['nomPaciente'], array($cdnPaciente), '_blank'); ?>?</span>
                                        </h2>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-sm-5 col-sm-offset-1 col-md-4 col-md-offset-2 text-center">
                                        <a href="<?php echo BASE_URL; ?>/consulta/consultarFim/<?php echo $cdnConsulta; ?>">
                                            <button class="btn btn-lg btn-block btn-default">
                                                Não! Cancele!
                                            </button>
                                        </a>
                                    </div>
                                    <div class="visible-xs">
                                        <br><br>
                                    </div>
                                    <div class="col-sm-5 col-md-4 text-center">
                                        <a href="<?php echo BASE_URL; ?>/falta/cadastrarFim/<?php echo $cdnPaciente.'/'.$cdnConsulta; ?>">
                                            <button class="btn btn-lg btn-block btn-warning">
                                                Sim, marcar.
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
