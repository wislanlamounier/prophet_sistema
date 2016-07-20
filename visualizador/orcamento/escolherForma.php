<div class="col-md-12">
    <div class="ibox float-e-margins">
        <div class="ibox-content p-md">
            <div class="row text-center">
                <div class="col-md-12">
                    <h3>
                        <b>Parcelas: </b> <?php echo $numVezes; ?> <br>
                        <b>Valor: </b> <span id="valor">R$<?php echo $valFinal; ?></span>
                    </h3>
                    <?php
                        if ($numVezes == 'A VISTA')
                            $numVezes = 1;
                    ?>
                </div>
            </div>

            <form action="<?php echo BASE_URL; ?>/orcamento/aprovarFim/<?php echo $cdnOrcamento; ?>"
                  method="post">
                <input type="hidden" name="numVezes" value="<?php echo $numVezes; ?>">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="control-label" for="tipo">Pagamento via</label>
                        <select required class="form-control select2" name="tipo" id="tipo">
                            <option id="boleto" value="boleto">Boleto bancário</option>
                            <option value="cartao">Cartão de crédito</option>
                            <option value="carne">Carnê</option>
                            <option value="nota">Nota promissória</option>
                            <option value="dinheiro">Dinheiro</option>
                            <option value="autorizacaoDesc">Autorização de desconto</option>
                            <option value="mensalidade">Mensalidade</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="control-label" for="datInicioPagamento">
                            Iniciar pagamento em
                        </label>
                        <input required type="date" id="datInicioPagamento" name="datInicioPagamento"
                               class="form-control mask-date"
                               value="<?php echo date('Y-m', strtotime('+1 month')); ?>-10">
                    </div>
                </div>

                <?php
                    if($numVezes > 1) {
                ?>
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <label for="diaVencimento" class="control-label">Dia de vencimento mensal</label>
                        <input type="number" id="diaVencimento" class="form-control" required name="numDiaVencimento"
                               value="10">
                    </div>
                </div>
                <?php
                    }
                ?>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="valEntrada" class="control-label">Entrada</label>
                        <input type="text" id="entrada" name="valEntrada" class="form-control mask-money">
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2 form-group">
                        <label for="valDesconto" class="control-label">Tipo desconto</label> <br>
                        <input type="radio" name="indTipoDesconto" class="tipo" value="qtd" checked> Dinheiro &nbsp;&nbsp;
                        <br>
                        <input type="radio" name="indTipoDesconto" class="tipo" value="prc"> Porcentagem &nbsp;&nbsp;
                    </div>
                    <div class="col-sm-8 col-md-3 col-lg-4 form-group" id="divDesconto">
                        <label for="valDesconto" class="control-label">Valor desconto</label>
                        <input id="desconto" name="valDesconto" class="form-control mask-money">
                    </div>
                </div>
                <h3 class="text-center">Valor restante para pagamento: <span id="restante">R$<?php echo $valFinal; ?></span></h3>
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">
                            Aprovar orçamento
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
