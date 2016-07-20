<div class="col-md-12">
    <div class="ibox float-e-margins">
        <div class="ibox-content p-md">
            <div class="row text-center">
                <div class="col-md-12">
                    <h2>
                        <span class="text-navy">
                            Tem certeza que deseja registrar o pagamento
                            <?php
                                if(isset($dtoParcela)) {
                                    echo ' da seguinte parcela para este orçamento?';
                                    $valor = $dtoParcela->getValParcela();
                                }else {
                                    echo ' do seguinte orçamento?';
                                    $valor = $dtoOrcamento->getValFinal();
                                }
                            ?>
                        </span>
                    </h2>
                    <h3>
                    <?php
                        if(isset($dtoParcela)){
                            $numParcela = $dtoParcela->getNumParcela();
                    ?>
                        <b>Parcela: </b> <?php echo $dtoParcela->getNumParcela(); ?> <br>
                        <b>Valor: </b> <?php echo $dtoParcela->getValParcela(true); ?>
                    <?php
                        }else{
                            $numParcela = '';
                    ?>
                        <b>Valor: </b> R$<?php echo $dtoOrcamento->getValFinal(true); ?>
                    <?php
                        }
                    ?>
                    </h3>
                </div>
            </div>

            <form action="<?php echo BASE_URL; ?>/orcamento/registrarPagamentoFim/<?php echo $dtoOrcamento->getCdnOrcamento().'/'.$numParcela; ?>" method="post">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 form-group">
                        <label for="numNotaFiscal" class="control-label">Número da nota fiscal (opcional)</label>
                        <input type="text" name="numNotaFiscal" class="form-control">
                        <input type="hidden" name="valPagamento" value="<?php echo $valor; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5 col-sm-offset-1 col-md-4 col-md-offset-2 text-center">
                        <a href="<?php echo BASE_URL; ?>/orcamento/consultarFim/<?php echo $dtoOrcamento->getCdnOrcamento(); ?>">
                            <button type="button" class="btn btn-lg btn-block btn-default">
                                Não! Cancele!
                            </button>
                        </a>
                    </div>
                    <div class="visible-xs">
                        <br><br>
                    </div>
                    <div class="col-sm-5 col-md-4 text-center">
                        <button type="submit" class="btn btn-lg btn-block btn-warning">
                            Sim, registrar.
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
