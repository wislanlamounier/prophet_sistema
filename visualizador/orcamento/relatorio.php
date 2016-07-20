<div class="col-md-12">
    <div class="ibox float-e-margins">
        <div class="ibox-content p-md">
            <!-- Relatórios de aprovados !-->
            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#rel1" class="faq-question">Relatório de orçamentos aprovados</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="rel1" class="panel-collapse collapse ">
                            <div class="faq-answer">
                                <form action="<?php echo BASE_URL; ?>/orcamento/relatorio/aprovados" method="post" target="_blank">
                                    <div class="row">
                                        <div class="col-sm-5 form-group">
                                            <label for="forma" class="control-label">Forma de pagamento</label>
                                            <select name="forma" class="form-control">
                                                <option value="todas">Todas</option>
                                                <option value="boleto">Boleto bancário</option>
                                                <option value="cartao">Cartão de crédito</option>
                                                <option value="carne">Carnê</option>
                                                <option value="nota">Nota promissória</option>
                                                <option value="dinheiro">Dinheiro</option>
                                                <option value="autorizacaoDesc">Autorização de desconto</option>
                                                <option value="mensalidade">Mensalidade</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-5 form-group">
                                            <label for="datas" class="control-label">Período</label>
                                            <?php
                                                $value = date('01/m/Y').' - '.date('t/m/Y');
                                            ?>
                                            <input type="text" class="mask-dateinterval form-control" name="datas" value="<?php echo $value; ?>">
                                        </div>
                                        <div class="col-sm-2">
                                            <br>
                                            <input type="submit" class="btn btn-primary" value="Gerar relatório">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Relatórios de não aprovados !-->
            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#rel2" class="faq-question">Relatório de orçamentos não aprovados</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="rel2" class="panel-collapse collapse ">
                            <div class="faq-answer">
                                <form action="<?php echo BASE_URL; ?>/orcamento/relatorio/reprovados" method="post" target="_blank">
                                    <div class="row">
                                        <div class="col-sm-5 form-group">
                                            <label for="forma" class="control-label">Forma de pagamento</label>
                                            <select name="forma" class="form-control">
                                                <option value="todas">Todas</option>
                                                <option value="boleto">Boleto bancário</option>
                                                <option value="cartao">Cartão de crédito</option>
                                                <option value="carne">Carnê</option>
                                                <option value="nota">Nota promissória</option>
                                                <option value="dinheiro">Dinheiro</option>
                                                <option value="autorizacaoDesc">Autorização de desconto</option>
                                                <option value="mensalidade">Mensalidade</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-5 form-group">
                                            <label for="datas" class="control-label">Período</label>
                                            <?php
                                                $value = date('01/m/Y').' - '.date('t/m/Y');
                                            ?>
                                            <input type="text" class="mask-dateinterval form-control" name="datas" value="<?php echo $value; ?>">
                                        </div>
                                        <div class="col-sm-2">
                                            <br>
                                            <input type="submit" class="btn btn-primary" value="Gerar relatório">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Por paciente !-->
            <!--
            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#rel3" class="faq-question">Relatório de orçamentos por paciente</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="rel3" class="panel-collapse collapse ">
                            <div class="faq-answer">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Por dentista
            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#rel4" class="faq-question">Relatório de orçamentos por dentista</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="rel4" class="panel-collapse collapse ">
                            <div class="faq-answer">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagos
            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#rel5" class="faq-question">Relatório de orçamentos/parcelas pagos/pagas</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="rel5" class="panel-collapse collapse ">
                            <div class="faq-answer">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Devendo !--
            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#rel6" class="faq-question">Relatório de orçamentos devedores</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="rel6" class="panel-collapse collapse ">
                            <div class="faq-answer">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            !-->
        </div>
    </div>
