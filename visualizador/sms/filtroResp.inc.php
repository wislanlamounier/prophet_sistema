<?php if($tipoFiltro == 'respostas') { ?>
<form action="<?php echo BASE_URL; ?>/sms/respostas/" method="post">
<?php }else{ ?>
<form action="<?php echo BASE_URL; ?>/sms/baixarRespostasFim/" method="post" target="_blank">
<?php } ?>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3 form-group">
            <label for="tipo" class="control-label">Mostrar:</label> <br>
            <input <?php echo $tipo2 == 'aviso_consulta' || is_null($tipo2) ? 'checked' : ''; ?> type="radio" name="tipo" class="tipo" value="aviso_consulta"> Aviso de consulta
            <br>
            <input <?php echo $tipo2 == 'satisfacao' ? 'checked' : ''; ?> type="radio" name="tipo" class="tipo" value="satisfacao"> Pesquisa de satisfação
        </div>
        <div class="col-sm-6 col-md-8 col-lg-9 form-group">
            <?php include_once('visualizador/paciente/modalSelect.php'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3 form-group">
            <label for="tipo" class="control-label">Datas:</label> <br>
            <input value="<?php echo $datas; ?>" type="text" class="form-control mask-dateinterval" name="datas" />
        </div>
        <div class="col-sm-4 col-md-4 col-lg-3 form-group">
            <label for="dentista" class="control-label">Dentista:</label>
            <select name="dentista" class="form-control">
                <option value="" <?php echo is_null($dentista) ? 'selected' : ''; ?>>Não filtrar</option>
                <?php
                    foreach($arrDentistas as $arrDentista){
                        $selected = $arrDentista['cdnUsuario'] == $dentista ? 'selected' : '';
                        echo '<option value="'.$arrDentista['cdnUsuario'].'" '.$selected.' >'.$arrDentista['nomUsuario'].'</option>';
                    }
                ?>
            </select>
        </div>
        <div class="col-sm-2">
            <br />
            <?php if($tipoFiltro == 'respostas') { ?>
            <button class="btn btn-success" type="submit">Modificar</button>
            <?php }else{ ?>
            <button class="btn btn-success" type="submit">Baixar</button>
            <?php } ?>
        </div>
    </div>
</form>
