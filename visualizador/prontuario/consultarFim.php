                    <div class="col-md-12">
                        <div class="ibox float-e-margins">

                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/prontuario/cadastrarTratamento/<?php echo $cdnPaciente; ?>">
                                    <button class="btn btn-success">
                                        Cadastrar
                                    </button>
                                </a>
                            </div>
                            <div class="ibox-content p-md">
                                <div class="row">
                                    <div class="col-md-4 col-lg-4 text-center">
                                        <a href="<?php echo BASE_URL; ?>/prontuario/imprimir/<?php echo $cdnPaciente; ?>">
                                            <button class="btn btn-lg btn-primary btn-block">
                                                Imprimir/visualizar
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-lg-4 text-center">
                                        <a href="<?php echo BASE_URL; ?>/prontuario/verAnexos/<?php echo $cdnPaciente; ?>">
                                            <button class="btn btn-lg btn-primary btn-block">
                                                Anexos
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-lg-4 text-center">
                                        <a target="_blank" href="<?php echo BASE_URL; ?>/anamnese/consultarFim/<?php echo $cdnPaciente; ?>">
                                            <button class="btn btn-lg btn-primary btn-block">
                                                Anamnese
                                            </button>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover datatable" >
                                            <thead>
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Dente</th>
                                                    <th>Tratamento</th>
                                                    <th>Dentista</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    echo $this->link('paciente', 'consultarFim', '<- Voltar para paciente', array($cdnPaciente));
                                                    $modMain = new  ModeloMain(true);
                                                    foreach($arrTratamentos as $arrTratamento){
                                                        $dtoProntuarioTratamento = $modProntuario->getProntuarioTratamento($arrTratamento['cdnProntuarioTratamento']);
                                                        $arrUsuario = $modMain->getUsuario($dtoProntuarioTratamento->getCdnDentista());
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $dtoProntuarioTratamento->getDatProntuarioTratamento(true); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $dtoProntuarioTratamento->getNumDente(); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo nl2br($dtoProntuarioTratamento->getDesProntuarioTratamento()); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $arrUsuario['nomUsuario']; ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo BASE_URL; ?>/prontuario/deletarTratamento/<?php echo $dtoProntuarioTratamento->getCdnProntuarioTratamento(); ?>">
                                                                <button type="button" class="btn btn-warning">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </a>
                                                            <a href="<?php echo BASE_URL; ?>/prontuario/atualizarTratamento/<?php echo $dtoProntuarioTratamento->getCdnProntuarioTratamento(); ?>">
                                                                <button type="button" class="btn btn-success">
                                                                    <i class="fa fa-edit"></i>
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
                                                    <th>Data</th>
                                                    <th>Dente</th>
                                                    <th>Tratamento</th>
                                                    <th>Dentista</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
