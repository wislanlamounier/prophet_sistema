    <div class="ibox-header p-md">
        <div class="col-md-12">
            <h3 class="pull-left">Alterar aviso de SMS para <?php echo $nomPaciente; ?></h3>
            <a href="<?php echo BASE_URL; ?>/consulta/consultarFim/<?php echo $cdnConsulta; ?>">
                <button class="btn btn-success pull-right">
                    Voltar
                </button>
            </a>
        </div>
        <br>
    </div>
    <div class="ibox-content p-md">
        <form action="<?php echo BASE_URL; ?>/consulta/mudarAvisoFim/<?php echo $cdnConsulta; ?>" method="post">
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="numSegAntecedencia" class="control-label">Antecedência</label>
                    <select name="numSegAntecedencia" class="form-control" id="numSegAntecedencia">
                        <?php echo $options; ?>
                    </select>
                </div>
                <div class="col-sm-6 form-group">
                    <label for="numTelefone" class="control-label">Telefone para enviar SMS</label>
                    <small class="text-muted">Formato: (xx) xxxx-xxxxx</small>
                    <input <?php echo isset($numTelefone1) ? 'value="'.$numTelefone1.'"' : ''; ?> type="text" name="numTelefone" class="form-control mask-phone" id="numTelefone"/>
                </div>
                <input type="hidden" name="indEnviarSms" value="1">
            </div>
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Cadastrar
                    </button>
                </div>
            </div>
        </form>
    </div>