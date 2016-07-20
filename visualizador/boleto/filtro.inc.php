<?php if($tipoFiltro == 'historico') { ?>
<form action="<?php echo BASE_URL; ?>/boleto/historico/" method="post">
<?php } ?>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3 form-group">
            <label for="tipo" class="control-label">Mostrar:</label> <br>
            <input checked type="radio" name="origem" class="tipo" value="todos"> Todos
            &nbsp;&nbsp;&nbsp;
            <input type="radio" name="origem" class="tipo" value="orcamento"> Orçamentos
            &nbsp;&nbsp;&nbsp;
            <input type="radio" name="origem" class="tipo" value="orcamento_parcela"> Parcelas de orçamentos
        </div>
        <div class="col-sm-6 col-md-8 col-lg-9 form-group">
            <?php include_once('visualizador/paciente/modalSelect.php'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3 form-group">
            <label for="tipo" class="control-label">Datas:</label> <br>
            <input type="text" class="form-control mask-dateinterval" name="datas" />
        </div>
        <div class="col-sm-2">
            <br />
            <?php if($tipoFiltro == 'historico') { ?>
            <button class="btn btn-success" type="submit">Modificar</button>
            <?php }else{ ?>
            <button class="btn btn-success" type="submit">Baixar</button>
            <?php } ?>
        </div>
    </div>
</form>
