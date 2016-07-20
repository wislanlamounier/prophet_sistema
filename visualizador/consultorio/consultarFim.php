                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <div class="col-md-12">
                                    <a class="pull-right" href="<?php echo BASE_URL; ?>/consultorio/cadastrar">
                                        <button class="btn btn-success">
                                            Cadastrar novo consultório
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content text-center p-md">
                                <div class="col-md-12 col-lg-12 form-group">
                                    <label class="control-label" for="numConsultorio">Número</label>
                                    <input disabled class="form-control" name="numConsultorio" type="text" placeholder="Número do consultório" value="<?php echo $dtoConsultorio->getNumConsultorio(); ?>">
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <a href="<?php echo BASE_URL; ?>/consultorio/atualizar/<?php echo $dtoConsultorio->getCdnConsultorio(); ?>">
                                        <button type="button" class="btn btn-block btn-lg btn-success">
                                            Editar
                                        </button>
                                    </a>
                                </div>
                                <div class="row text-justify">

                                    <div class="col-md-12">
                                        <span class="text-muted">
                                            <?php echo $this->link('consultorio', 'deletar', 'Deletar consultório', array($dtoConsultorio->getCdnConsultorio())); ?>
                                        </span>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
