

    <div class="col-md-12">
        <div class="row">
            <?php $dtoSms = new DTOSms(); ?>
            <div class="col-md-4 form-group">
                <label for="destinatario" class="control-label">Destinatario</label>
                <input type="text" disabled class="form-control" name="destinatario" value="<?php echo $arrSms['nomPaciente']; ?>">
            </div>
            <div class="col-md-4 form-group">
                <label for="data" class="control-label">Data de envio</label>
                <input type="text" disabled class="form-control" name="data" value="<?php echo $dtoSms->transformacaoDatetime($arrSms['datEnvio']); ?>">
            </div>
            <div class="col-md-4 form-group">
                <label for="telefone" class="control-label">Telefone</label>
                <input type="text" disabled class="form-control" name="telefone" value="<?php echo $arrSms['numTelefone']; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="texto" class="control-label">Texto</label>
                <textarea disabled class="form-control" name="texto"><?php echo $arrSms['strTexto']; ?></textarea>
            </div>
        </div>

    </div>
