                    <div class="col-md-12">
                        <div class="row">
                            <form action="<?php echo BASE_URL; ?>/prontuario/cadastrarTratamentoFim/<?php echo $cdnPaciente; ?>" method="post">
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="datProntuarioTratamento">Data</label>
                                    <input required class="form-control mask-date" name="datProntuarioTratamento" type="date">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="numDente">Dente</label>
                                    <input class="form-control" name="numDente" type="text">
                                </div>
                                <div class="col-md-6">
                                    <?php echo $selectDentista; ?>
                                </div>
                                <div class="col-md-12 col-lg-12 form-group">
                                    <label class="control-label" for="desProntuarioTratamento">Tratamento realizado</label>
                                    <textarea class="form-control" name="desProntuarioTratamento"></textarea>
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
