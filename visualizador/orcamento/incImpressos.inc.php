<?php
    if(isset($dtoOrcamentoFormaPagamento)){ // escolheu a forma
?>
        <div class="col-sm-6 form-group">
            <label class="control-label" for="formaPagamento">Forma</label>
            <input type="text" name="formaPagamento" class="form-control" disabled value="<?php echo $dtoOrcamentoFormaPagamento->getIndVia(true); ?>">
        </div>
        <div class="col-sm-6 form-group">
            <label class="control-label" for="taxa">Taxa</label>
            <input type="text" name="taxa" class="form-control" disabled value="<?php echo $dtoOrcamentoFormaPagamento->getNumPorcentagem(); ?>%">
        </div>
        <?php if($dtoOrcamento->getValEntrada()){ ?>
            <div class="col-sm-6 form-group">
                <label class="control-label" for="entrada">Entrada</label>
                <input type="text" name="entrada" class="form-control" disabled value="R$<?php echo $dtoOrcamento->getValEntrada(true); ?>">
            </div>
        <?php } ?>
        <?php if($dtoOrcamento->getValDesconto()){ ?>
            <div class="col-sm-6 form-group">
                <label class="control-label" for="desconto">Desconto - <?php echo $dtoOrcamento->getIndTipoDesconto(true); ?></label>
                <input type="text" name="desconto" class="form-control" disabled value="<?php echo $dtoOrcamento->getValDesconto(); ?>">
            </div>
        <?php } ?>
<?php
        $numVezesEscolhido = $dtoOrcamentoFormaPagamento->getNumVezes();
        if($numVezesEscolhido > 1){ // escolheu parcelado
            include_once('incParcelas.php');
            if($dtoOrcamentoFormaPagamento->getIndVia() == 'carne' and
                $dtoOrcamento->getIndAprovado() and !$dtoOrcamento->getIndFinalizado()){
                ?>
                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <a target="blank" href="<?php echo BASE_URL; ?>/orcamento/carne/<?php echo $dtoOrcamento->getCdnOrcamento(); ?>">
                        <button type="button" class="btn btn-block btn-lg btn-success">
                            Gerar carnê
                        </button>
                    </a>
                </div>
                <?php
            }
        }else{ // escolheu a vista
            if($dtoOrcamentoFormaPagamento->getIndVia() == 'boleto' and // escolheu boleto
                $dtoOrcamento->getIndAprovado() and !$dtoOrcamento->getIndFinalizado()){
                ?>
                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <a href="<?php echo BASE_URL; ?>/boleto/gerar/<?php echo $dtoOrcamento->getValFinal(); ?>">
                        <button type="button" class="btn btn-block btn-lg btn-success">
                            Gerar boleto bancário
                        </button>
                    </a>
                </div>
                <?php
            }
            if($dtoOrcamentoFormaPagamento->getIndVia() == 'nota' and // escolheu mota
                $dtoOrcamento->getIndAprovado() and !$dtoOrcamento->getIndFinalizado()){
                ?>
                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <a target="blank" href="<?php echo BASE_URL; ?>/orcamento/notaPromissoria/<?php echo $dtoOrcamento->getCdnOrcamento(); ?>">
                        <button type="button" class="btn btn-block btn-lg btn-success">
                            Gerar nota promissória
                        </button>
                    </a>
                </div>
                <?php
            }
            if($dtoOrcamentoFormaPagamento->getIndVia() == 'autorizacaoDesc' and $dtoOrcamento->getIndAprovado() and !$dtoOrcamento->getIndFinalizado()){
                ?>
                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <a target="blank" href="<?php echo BASE_URL; ?>/orcamento/autorizacaoDesconto/<?php echo $dtoOrcamento->getCdnOrcamento(); ?>">
                        <button type="button" class="btn btn-block btn-lg btn-success">
                            Gerar autorização de desconto
                        </button>
                    </a>
                </div>
                <?php
            }
        }
    }else{ // ainda não escolheu a forma
        include_once('incFormas.php');
    }
?>