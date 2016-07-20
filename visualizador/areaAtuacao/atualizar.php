<div class="col-md-12">
    <div class="row">
        <form action="<?php echo BASE_URL; ?>/areaAtuacao/atualizarFim/<?php echo $dtoAreaAtuacao->getCdnAreaAtuacao(); ?>" method="post">
            <div class="col-md-12 form-group">
                <label class="control-label" for="nomAreaAtuacao">Nome</label>
                <input class="form-control" name="nomAreaAtuacao" type="text" value="<?php echo $dtoAreaAtuacao->getNomAreaAtuacao(); ?>" required>
            </div>
            <div class="col-md-12 col-lg-12 form-group">
                <label class="control-label" for="desAreaAtuacao">Observações</label>
                <textarea class="form-control" name="desAreaAtuacao"><?php echo $dtoAreaAtuacao->getDesAreaAtuacao(); ?></textarea>
            </div>
            <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <button type="submit" class="btn btn-block btn-lg btn-primary">
                    Editar
                </button>
            </div>
        </form>
    </div>

</div>
