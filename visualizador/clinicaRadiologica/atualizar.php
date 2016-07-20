<div class="col-md-12">
    <div class="row">
        <form action="<?php echo BASE_URL; ?>/clinicaRadiologica/atualizarFim/<?php echo $dtoClinicaRadiologica->getCdnClinicaRadiologica(); ?>" method="post">
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="nomClinicaRadiologica">Nome</label>
                <input required class="form-control" name="nomClinicaRadiologica" type="text" value="<?php echo $dtoClinicaRadiologica->getNomClinicaRadiologica(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="numWhatsapp">Número Whatsapp</label>
                <input class="form-control" name="numWhatsapp" type="text" value="<?php echo $dtoClinicaRadiologica->getNumWhatsapp(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="numTelefone1">Número telefone 1</label>
                <input class="form-control" name="numTelefone1" type="text" value="<?php echo $dtoClinicaRadiologica->getNumTelefone1(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="numTelefone2">Número telefone 2</label>
                <input class="form-control" name="numTelefone2" type="text" value="<?php echo $dtoClinicaRadiologica->getNumTelefone2(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="strEndereco">Endereço</label>
                <input class="form-control" name="strEndereco" type="text" value="<?php echo $dtoClinicaRadiologica->getStrEndereco(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="nomCidade">Cidade</label>
                <input class="form-control" name="nomCidade" type="text" value="<?php echo $dtoClinicaRadiologica->getNomCidade(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="strEmail">E-mail</label>
                <input class="form-control" name="strEmail" type="email" value="<?php echo $dtoClinicaRadiologica->getStrEmail(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="strSite">Site</label>
                <input class="form-control" name="strSite" type="text" value="<?php echo $dtoClinicaRadiologica->getStrSite(); ?>">
            </div>
            <div class="col-md-12 col-lg-12 form-group">
                <label class="control-label" for="desClinicaRadiologica">Observações</label>
                <textarea class="form-control" name="desClinicaRadiologica"><?php echo $dtoClinicaRadiologica->getDesClinicaRadiologica(); ?></textarea>
            </div>
            <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <button type="submit" class="btn btn-block btn-lg btn-primary">
                    Editar
                </button>
            </div>
        </form>
    </div>

</div>
