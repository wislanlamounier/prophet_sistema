                    <div class="col-md-12">
                            <form action="<?php echo BASE_URL; ?>/orcamento/cadastrarFim/" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <?php require('visualizador/paciente/modalSelect.php'); ?>
                                        </div>
                                        <div style="display: none;" id="divCadastro" class="alert alert-warning">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="datOrcamento" class="control-label">Data</label>
                                        <input type="text" id="datOrcamento" value="<?php echo date('d/m/Y'); ?>" name="datOrcamento" class="form-control mask-date">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="datValidade" class="control-label">Validade</label>
                                        <input type="text" id="datValidade" name="datValidade" value="<?php echo date('d/m/Y', strtotime('+1 month')); ?>" class="form-control mask-date">
                                    </div>
                                </div>


                                <hr>

                                <!-- Procedimentos !-->
                                <div id="rowProcedimentos">
                                    <div class="col-md-12">
                                        <h4>Procedimentos</h4>
                                        <p>Procedimentos deste orçamento.</p>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-default" type="button" id="addProcedimento">
                                            <span class="fa fa-plus"></span>
                                        </button>
                                        <button class="btn btn-default" type="button" id="removerProcedimento">
                                            <span class="fa fa-minus"></span>
                                        </button>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                </div>

                                <!-- Preço !-->
                                <div class="row">
                                    <div id="tabelapreco" class="col-md-12 form-group">
                                        <label for="cdnTabelaPreco" class="control-label">Tabela de preço</label>
                                        <select class="form-control" id="selectTabelaPreco" name="cdnTabelaPreco">
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <h2>
                                            <label for="valOrcamento" class="control-label">Valor final do orçamento</label>
                                        </h2>
                                        <input type="text" id="valor" name="valOrcamento" class="form-control mask-money">
                                    </div>
                                </div>


                                <!-- Pagamento !-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="page-header text-center">Quantidade de parcelas</h3>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <label for="numVezesOferecidas" class="control-label">Número de parcelas a serem oferecidas</label>
                                        <input type="number" value="6" class="form-control" id="numVezesOferecidas" name="numVezesOferecidas">
                                    </div>
                                </div>

                                <div id="pgtoParcelado">
                                    <div class="row" >
                                        <div class="col-sm-2 form-group">
                                            <label for="quantidade" class="control-label">Cobrar juros</label><br>
                                            <input type="radio" name="indCobrarJuros" id="indCobrarJuros" value="1" checked> Sim &nbsp;&nbsp;
                                            <input type="radio" name="indCobrarJuros" value="0"> Não &nbsp;&nbsp;
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="hidden-xs hidden-sm">
                                                <label for="calcular" class="control-label">&nbsp;</label><br>
                                            </div>
                                            <button type="button" id="calcular" class="btn btn-default btn-block">
                                                Calcular
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" id="tabelaCalculo">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="desOrcamento" class="control-label">Observações</label>
                                        <textarea name="desOrcamento" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        &nbsp;
                                        <br>
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </form>
                    </div>
