<?php if($tipoFiltro == 'tela') { ?>
<form action="<?php echo BASE_URL; ?>/retorno/consultar/" method="post">
<?php }else{ ?>
<form action="<?php echo BASE_URL; ?>/retorno/imprimirFim/" method="post" target="_blank">
<?php } ?>
    <div class="row">
        <div class="col-sm-12 form-group">
            <?php include_once('visualizador/paciente/modalSelect.php'); ?>
        </div>
    </div>
    <div class="row">
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
        <div class="col-sm-2 col-md-2 col-lg-3 form-group">
            <label for="mes" class="control-label">Mes:</label>
            <select name="mes" class="form-control">
                <option value="todos" <?php echo $mes == 'todos' ? 'selected' : ''; ?>>Todos</option>
                <option value="1" <?php echo $mes == 1 ? 'selected' : ''; ?>>1</option>
                <option value="2" <?php echo $mes == 2 ? 'selected' : ''; ?>>2</option>
                <option value="3" <?php echo $mes == 3 ? 'selected' : ''; ?>>3</option>
                <option value="4" <?php echo $mes == 4 ? 'selected' : ''; ?>>4</option>
                <option value="5" <?php echo $mes == 5 ? 'selected' : ''; ?>>5</option>
                <option value="6" <?php echo $mes == 6 ? 'selected' : ''; ?>>6</option>
                <option value="7" <?php echo $mes == 7 ? 'selected' : ''; ?>>7</option>
                <option value="8" <?php echo $mes == 8 ? 'selected' : ''; ?>>8</option>
                <option value="9" <?php echo $mes == 9 ? 'selected' : ''; ?>>9</option>
                <option value="10" <?php echo $mes == 10 ? 'selected' : ''; ?>>10</option>
                <option value="11" <?php echo $mes == 11 ? 'selected' : ''; ?>>11</option>
                <option value="12" <?php echo $mes == 12 ? 'selected' : ''; ?>>12</option>
            </select>
        </div>
        <div class="col-sm-2 col-md-2 col-lg-3 form-group">
            <label for="ano" class="control-label">Ano:</label>
            <input type="number" name="ano" class="form-control" value="<?php echo $ano; ?>">
        </div>
        <div class="col-sm-2">
            <br />
            <?php if($tipoFiltro == 'tela') { ?>
            <button class="btn btn-success" type="submit">Modificar</button>
            <?php }else{ ?>
            <button class="btn btn-success" type="submit">Imprimir</button>
            <?php } ?>
        </div>
    </div>
</form>
