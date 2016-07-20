
<div class="row">
    <div class="col-md-12">
        <h3>Carregar consulta via orçamento</h3>
    </div>
    <div class="col-sm-4 form-group">
        <label for="cdnOrcamento" class="control-label">Orçamento</label> <br />
        <strong  style="cursor: pointer;">
            <?php
            $iniText = 'Selecionar orçamento...';
            if (isset($cdnOrcamento))
                $iniText = 'Orçamento número ' . $cdnOrcamento;
            ?>
            <i id="cdnOrcamento" ><?php echo $iniText; ?></i>
        </strong>
        <?php
        $value = '';
        if (isset($cdnOrcamento))
            $value = 'value="' . $cdnOrcamento . '"';
        ?>
        <input type="hidden" name="cdnOrcamento" <?php echo $value; ?>>
    </div>
    <div class="col-sm-4 form-group">
        <label for="cdnOrcamentoProcedimento" class="control-label">Procedimento</label> <br />
        <strong  style="cursor: pointer;">
            <?php
            $iniText = 'Selecionar procedimento...';
            if (isset($nomProcedimentoOrcamento))
                $iniText = $nomProcedimentoOrcamento;
            ?>
            <i id="cdnOrcamentoProcedimento" ><?php echo $iniText; ?></i>
        </strong>
        <?php
        $value = '';
        if (isset($cdnOrcamentoProcedimento))
            $value = 'value="' . $cdnOrcamentoProcedimento . '"';
        ?>
        <input type="hidden" name="cdnOrcamentoProcedimento" <?php echo $value; ?>>
    </div>
    <div class="col-sm-4">
        <button id="resetarOrcamento" type="button" class="btn btn-lg btn-default">
            Cancelar escolha de orçamento
        </button>
    </div>
    <?php
    include_once('visualizador/orcamento/modalSelectOrcamento.php');
    include_once('visualizador/orcamento/modalSelectProcedimento.php');
    ?>
</div>
<hr />