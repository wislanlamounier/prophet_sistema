                    <div class="col-md-12">
                        <div class="row">
                            <form action="<?php echo BASE_URL; ?>/questionario/atualizarPerguntaFim/<?php echo $dtoPergunta->getCdnPergunta(); ?>" method="post">
                                <div class="col-md-12 col-lg-12 form-group">
                                    <label class="control-label" for="strPergunta">Pergunta</label>
                                    <input required class="form-control" name="strPergunta" type="text" value="<?php echo $dtoPergunta->getStrPergunta(); ?>">
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-success">
                                        Editar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
