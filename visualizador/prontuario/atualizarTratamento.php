                    <div class="col-md-12">
                        <div class="row">
                            <form action="<?php echo BASE_URL; ?>/prontuario/atualizarTratamentoFim/<?php echo $cdnProntuarioTratamento; ?>" method="post">
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="datProntuarioTratamento">Data</label>
                                    <input required class="form-control mask-date" name="datProntuarioTratamento" type="date" value="<?php echo $dtoProntuarioTratamento->getDatProntuarioTratamento(); ?>">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="numDente">Dente</label>
                                    <input class="form-control" name="numDente" type="text" value="<?php echo $dtoProntuarioTratamento->getNumDente(); ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <?php echo $selectDentista; ?>
                                </div>
                                <div class="col-md-12 col-lg-12 form-group">
                                    <label class="control-label" for="desProntuarioTratamento">Tratamento realizado</label>
                                    <textarea class="form-control" name="desProntuarioTratamento"><?php echo $dtoProntuarioTratamento->getDesProntuarioTratamento(); ?></textarea>
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-success">
                                        Editar
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
