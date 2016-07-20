                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content p-md">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <h2>
                                            <span class="text-navy">
                                                Tem certeza que deseja aprovar o orçamento no valor de R$<?php echo $dtoOrcamentoFormaPagamento->getValFinalTaxas(true); ?>
                                                com finalidade de consulta para o paciente <?php echo $arrPaciente['nomPaciente']; ?>? <br>
                                                <b>Vencimento para aprovação:</b> <?php echo $dtoOrcamento->getDatValidade(true); ?> <br>
                                                <b>Valor original: </b> R$<?php echo $dtoOrcamento->getValOrcamento(true); ?> <br>
                                                <b>Número de parcelas: </b> <?php echo $dtoOrcamentoFormaPagamento->getNumVezesEscolhido(); ?> <br>
                                                <?php
                                                    if($dtoOrcamento->getValDesconto()){
                                                ?>
                                                <b>Desconto: </b> <?php echo $dtoOrcamento->getIndTipoDesconto(true).' - '.$dtoOrcamento->getValDesconto(); ?> <br>
                                                <?php
                                                    }
                                                    if($dtoOrcamento->getValEntrada()){
                                                ?>
                                                <b>Entrada: </b> R$<?php echo $dtoOrcamento->getValEntrada(true); ?>
                                                <?php
                                                    }
                                                ?>
                                            </span>
                                        </h2>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="page-header text-center">Procedimentos que serão realizados</h3>
                                    </div>
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Dentista</th>
                                                    <th>Área de atuação</th>
                                                    <th>Procedimento</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($arrProcedimentos as $arrProcedimento){
                                                        $arrUsuario = $modMain->getUsuario($arrProcedimento['cdnDentista']);
                                                        $dtoAreaAtuacao = $modAreaAtuacao->getAreaAtuacao($arrProcedimento['cdnAreaAtuacao']);
                                                        $dtoProcedimento = $modProcedimento->getProcedimento($arrProcedimento['cdnProcedimento']);
                                                ?>
                                                <tr>
                                                    <td><?php echo $arrUsuario['nomUsuario']; ?></td>
                                                    <td><?php echo $dtoAreaAtuacao->getNomAreaAtuacao(); ?></td>
                                                    <td><?php echo $dtoProcedimento->getNomProcedimento(); ?></td>
                                                </tr>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <div class="col-sm-5 col-sm-offset-1 col-md-4 col-md-offset-2 text-center">
                                        <a href="<?php echo BASE_URL; ?>/orcamento/consultarFim/<?php echo $dtoOrcamento->getCdnOrcamento(); ?>">
                                            <button class="btn btn-lg btn-block btn-default">
                                                Não! Cancele!
                                            </button>
                                        </a>
                                    </div>
                                    <div class="visible-xs">
                                        <br><br>
                                    </div>
                                    <div class="col-sm-5 col-md-4 text-center">
                                        <a href="<?php echo BASE_URL; ?>/orcamento/aprovarFim/<?php echo $dtoOrcamento->getCdnOrcamento(); ?>">
                                            <button class="btn btn-lg btn-block btn-warning">
                                                Sim, aprovar.
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
