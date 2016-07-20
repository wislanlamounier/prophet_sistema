                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/orcamento/cadastrar">
                                    <button class="btn btn-success">
                                        Cadastrar
                                    </button>
                                </a>
                            </div>
                            <div class="ibox-content p-md">

                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover datatable" >
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Paciente</th>
                                                    <th>Valor</th>
                                                    <th>Vencimento</th>
                                                    <th>Aprovado</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($arrOrcamentos as $arrOrcamento){
                                                        $dtoOrcamento = $modOrcamento->getOrcamento($arrOrcamento['cdnOrcamento']);
                                                        $arrPaciente = $modPaciente->getPaciente($dtoOrcamento->getCdnPaciente(), true);
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $this->link('orcamento', 'consultarFim', $dtoOrcamento->getCdnOrcamento(), array($dtoOrcamento->getCdnOrcamento()));?>
                                                        </td>
                                                        <td>
                                                            <?php echo $this->link('paciente', 'consultarFim', $arrPaciente['nomPaciente'], array($arrPaciente['cdnPaciente'])); ?></td>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                $valOrcamento = $dtoOrcamento->getValOrcamento(true);
                                                                if(!is_null($dtoOrcamento->getValFinal()))
                                                                    $valOrcamento = $dtoOrcamento->getValFinal(true);

                                                                echo $this->link('orcamento', 'consultarFim', 'R$'.$valOrcamento, array($dtoOrcamento->getCdnOrcamento()));
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $this->link('orcamento', 'consultarFim', $dtoOrcamento->getDatValidade(true), array($dtoOrcamento->getCdnOrcamento())); ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                if($dtoOrcamento->getIndAprovado()){
                                                                    $aprovado = 'Sim';
                                                                }else{
                                                                    if(is_null($dtoOrcamento->getIndAprovado()))
                                                                        $aprovado = 'Sem resposta';
                                                                    else
                                                                        $aprovado = 'Não';
                                                                }
                                                                echo $this->link('orcamento', 'consultarFim', $aprovado, array($dtoOrcamento->getCdnOrcamento()));
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo BASE_URL; ?>/orcamento/consultarFim/<?php echo $dtoOrcamento->getCdnOrcamento(); ?>">
                                                                <button type="button" class="btn btn-success">
                                                                    Visualizar
                                                                </button>
                                                            </a>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Paciente</th>
                                                    <th>Valor</th>
                                                    <th>Aprovado</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
