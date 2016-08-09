                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php require('visualizador/orcamento/modalJustificativa.php'); ?>
                                </div>
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/orcamento/cadastrar">
                                    <button class="btn btn-success">
                                        Cadastrar novo orçamento
                                    </button>
                                </a>
                            </div>
                        </div>
                        <?php
                            if($dtoOrcamento->getIndAprovado()){
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <small>
                                    Aprovado por <?php echo $arrUsuarioAprovou['nomUsuario']; ?>
                                    em <?php echo $dtoOrcamento->getDatAprovacao(true); ?>.
                                </small>
                            </div>
                        </div>
                        <?php
                            }
                            if(is_null($dtoOrcamento->getIndAprovado()) and strtotime($dtoOrcamento->getDatValidade()) > strtotime(date('Y-m-d'))){
                        ?>
                            <div class="col-md-12 alert alert-warning text-center">
                                <b>ATENÇÃO:</b> este orçamento está com a aprovação pendente.
                            </div>
                        <?php
                            }
                            if(is_null($dtoOrcamento->getIndAprovado()) and strtotime($dtoOrcamento->getDatValidade()) < strtotime(date('Y-m-d'))){
                        ?>
                            <div class="col-md-12 alert alert-warning text-center">
                                <b>ATENÇÃO:</b> este orçamento ultrapassou a data de valiade e não foi aprovado.
                            </div>
                        <?php
                            }
                            if(!$dtoOrcamento->getIndAprovado() and !is_null($dtoOrcamento->getIndAprovado())){
                        ?>
                                <div class="col-md-12 alert alert-danger text-center">
                                    <b>ATENÇÃO:</b> este orçamento foi reprovado
                                </div>
                        <?php
                            }
                            if($dtoOrcamento->getIndFinalizado()){
                        ?>
                            <div class="col-md-12 alert alert-success text-center">
                                <b>ATENÇÃO:</b> este orçamento foi completamente pago.
                            </div>
                        <?php
                            }
                        ?>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="cdnOrcamento" class="control-label">Número do orçamento</label>
                                <input disabled class="form-control" type="text" name="cdnOrcamento" id="cdnOrcamento" value="<?php echo $dtoOrcamento->getCdnOrcamento(); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cdnPaciente" class="control-label">Paciente</label>
                                    <input disabled class="form-control" type="text" name="cdnPaciente" value="<?php echo $arrPaciente['nomPaciente']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="datOrcamento" class="control-label">Data</label>
                                <input disabled type="date" name="datOrcamento" class="form-control mask-date" value="<?php echo $dtoOrcamento->getDatOrcamento(); ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="datValidade" class="control-label">Validade</label>
                                <input disabled type="date" name="datValidade" class="form-control mask-date" value="<?php echo $dtoOrcamento->getDatValidade(); ?>">
                            </div>
                        </div>


                        <?php
                            include_once('incProcedimentos.php');
                        ?>


                        <!-- Preço !-->
                        <div class="row">
                            <div id="tabelapreco" class="col-md-12 form-group">
                                <label for="cdnTabelaPreco" class="control-label">Tabela de preço</label>
                                <input disabled name="cdnTabelaPreco" value="<?php echo $nomTabelaPreco; ?>" class="form-control" id="selectTabelaPreco" name="cdnTabelaPreco">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <h2>
                                    <label for="valOrcamento" class="control-label">Valor</label>
                                </h2>
                                <input disabled type="text" id="valor" name="valOrcamento" class="form-control mask-money" value="R$<?php echo $dtoOrcamento->getValOrcamento(true); ?>">
                            </div>
                        </div>

                        <!-- Pagamento !-->
                        
                        <?php
                            if(!$dtoOrcamento->getIndDesativado()){
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="page-header text-center">Forma de pagamento</h3>
                            </div>
                        </div>

                        <!-- Geração de impressos e escolha de pagamento !-->
                        <?php
                            include('incImpressos.inc.php');
                        ?>
                        <?php
                            } else {
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="page-header text-center">Orçamento Desativado</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="datOrcamento" class="control-label">Data</label>
                                <input disabled type="date" name="datDesativado" class="form-control" value="<?php echo $dtoOrcamento->getDatDesativado(); ?>">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="datValidade" class="control-label">Justificativa</label>
                                <textarea disabled name="strJustificativa" class="form-control"><?php echo $dtoOrcamento->getStrJustificativa(); ?></textarea>
                            </div>
                        </div>
                        <?php
                            } 
                        ?>


                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="desOrcamento" class="control-label">Observações</label>
                                <textarea disabled name="desOrcamento" class="form-control"><?php echo $dtoOrcamento->getDesOrcamento(); ?></textarea>
                            </div>
                        </div>

                        
                    </div>

                    <?php
                        if($dtoOrcamento->getIndAprovado() and $dtoOrcamentoFormaPagamento->getNumVezes() == 1){
                    ?>
                        <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                            <a target="blank" href="<?php echo BASE_URL; ?>/orcamento/registrarPagamento/<?php echo $dtoOrcamento->getCdnOrcamento(); ?>">
                                <button type="button" class="btn btn-block btn-lg btn-success">
                                    Registrar pagamento
                                </button>
                            </a>
                        </div>
                    <?php
                        }
                    ?>

                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-2">
                            <hr />
                            <a target="blank" href="<?php echo BASE_URL; ?>/orcamento/imprimir/<?php echo $dtoOrcamento->getCdnOrcamento(); ?>">
                                <button type="button" class="btn btn-block btn-lg btn-success">
                                    Imprimir orçamento
                                </button>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <hr />
                            <a>
                                <button disabled type="button" class="btn btn-block btn-lg btn-success">
                                    Editar orçamento
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-2">
                            <hr />
                            <a>
                                <button type="button" class="btn btn-block btn-lg btn-warning" onclick="openModalJustificativa();">
                                    Desativar Orçamento
                                </button>
                            </a>
                        </div>
                    <?php if(is_null($dtoOrcamento->getIndAprovado())){ ?>
                        <div class="col-sm-4">
                            <hr>
                            <a href="<?php echo BASE_URL; ?>/orcamento/reprovar/<?php echo $dtoOrcamento->getCdnOrcamento(); ?>">
                                <button type="button" class="btn btn-block btn-lg btn-danger">
                                    Reprovar orçamento
                                </button>
                            </a>
                        </div>
                    <?php } ?>
                    </div>