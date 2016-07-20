                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <a href="<?php echo BASE_URL; ?>/cronometro/salaEspera">
                                        <button type="button" class="btn btn-block btn-outline btn-primary">
                                            Ver sala de espera
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content p-md">

                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover datatable" >
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Hora de chegada</th>
                                                    <th>Hora de entrada</th>
                                                    <th>Tempo esperando</th>
                                                    <th>Tempo de atendimento</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $modPaciente = new ModeloPaciente();
                                                    foreach($arrCronometros as $arrCronometro){
                                                        $dtoCronometro = $modCronometro->getCronometro($arrCronometro['cdnCronometro']);
                                                        $arrPaciente = $modPaciente->getPaciente($dtoCronometro->getCdnPaciente(), true);
                                                        $horaChegada = strtotime($dtoCronometro->getHoraChegada());
                                                        $horaEntrada = strtotime($dtoCronometro->getHoraEntrada());

                                                        $horaEsperando = $horaEntrada - $horaChegada;
                                                        $horaEsperando = ceil($horaEsperando / 60);

                                                        $horaAgora = time();
                                                        $horaAtendimento = $horaAgora - $horaEntrada;
                                                        $horaAtendimento = ceil($horaAtendimento / 60);
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $this->link('paciente', 'consultarFim', $arrPaciente['nomPaciente'], array($dtoCronometro->getCdnPaciente()));?>
                                                        </td>
                                                        <td>
                                                            <?php echo date('H:i:s', strtotime($dtoCronometro->getHoraChegada())); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo date('H:i:s', strtotime($dtoCronometro->getHoraEntrada())); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $horaEsperando.' minutos' ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $horaAtendimento.' minutos' ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo BASE_URL; ?>/cronometro/saida/<?php echo $dtoCronometro->getCdnCronometro(); ?>">
                                                                <button type="button" class="btn btn-success">
                                                                    Saiu de atendimento
                                                                </button>
                                                            </a>
                                                            <a href="<?php echo BASE_URL; ?>/cronometro/voltar/<?php echo $dtoCronometro->getCdnCronometro(); ?>">
                                                                <button type="button" class="btn btn-success">
                                                                    Voltar para sala
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Hora de chegada</th>
                                                    <th>Hora de entrada</th>
                                                    <th>Tempo esperando</th>
                                                    <th>Tempo de atendimento</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
