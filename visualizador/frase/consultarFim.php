                    <div class="col-md-12">
                        <div class="col-md-12">
                            <a class="pull-right" href="<?php echo BASE_URL; ?>/fornecedor/cadastrar">
                                <button class="btn btn-success">
                                    Cadastrar nova frase
                                </button>
                            </a>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-12 form-group">
                                <label class="control-label" for="strFrase">Frase</label>
                                <textarea disabled class="form-control" name="strFrase"><?php echo $dtoFrase->getStrFrase(); ?></textarea>
                            </div>
                            <a href="<?php echo BASE_URL; ?>/frase/atualizar/<?php echo $dtoFrase->getCdnFrase(); ?>">
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-success">
                                        Editar
                                    </button>
                                </div>
                            </a>
                        </div>
                        <div class="row">
                            <br>
                            <a href="<?php echo BASE_URL; ?>/frase/ativar/<?php echo $dtoFrase->getCdnFrase(); ?>">
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Tornar principal
                                    </button>
                                </div>
                            </a>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $this->link('frase', 'deletar', 'Deletar frase', array('cdnFrase' => $dtoFrase->getCdnFrase())); ?>
                            </div>
                        </div>
                    </div>
