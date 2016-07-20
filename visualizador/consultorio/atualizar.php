<div class="col-md-12">
    <div class="row">
        <form action="<?php echo BASE_URL; ?>/consultorio/atualizarFim/<?php echo $dtoConsultorio->getCdnConsultorio(); ?>" method="post">
            <div class="col-md-12 form-group">
                <label class="control-label" for="numConsultorio">Número</label>
                <input class="form-control" name="numConsultorio" type="text" maxlength="30" value="<?php echo $dtoConsultorio->getNumConsultorio(); ?>" required>
            </div>
            <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <button type="submit" class="btn btn-block btn-lg btn-primary">
                    Editar
                </button>
            </div>
        </form>
    </div>

</div>
