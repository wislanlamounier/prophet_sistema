                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content text-center p-md">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>
                                            <span class="text-navy">
                                                Tem certeza que deseja marcar
                                                <?php 
                                                    if(isset($dtoParcela)){
                                                        echo ' esta parcela como paga ';
                                                    }else{
                                                        echo ' este orçamento como pago' ;
                                                    }
                                                ?>
                                                para o paciente <?php echo $arrPaciente['nomPaciente']; ?>, no valor de
                                                <?php
                                                    if(isset($dtoParcela)){
                                                        echo ' R$'.$dtoParcela->getValParcela(true).' ';
                                                    }else{
                                                        echo ' R$'.$dtoOrcamento->getValOrcamento(true).' ';
                                                    }
                                                ?>
                                                com vencimento marcado para 
                                                <?php
                                                    if(isset($dtoParcela)){
                                                        echo $dtoParcela->getDatVencimento(true);
                                                    }else{
                                                        echo $dtoOrcamentoFormaPagamento->getDatVencimento(true);
                                                    }
                                                ?>
                                                ?
                                            </span>
                                        </h2>
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
                                        <a href="<?php echo BASE_URL; ?>/pagamento/cadastrarFim/<?php echo $dtoOrcamento->getCdnOrcamento(); ?>/<?php if(isset($dtoParcela)) echo $dtoParcela->getNumParcela(); ?>">
                                            <button class="btn btn-lg btn-block btn-warning">
                                                Sim, marcar.
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
