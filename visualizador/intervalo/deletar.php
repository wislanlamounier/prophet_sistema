                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content text-center p-md">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>
                                            <span class="text-navy">Tem certeza que deseja deletar o intervalo deste dentista?</span>
                                        </h2>
                                        <h3>
                                            <?php echo $arrUsuario['nomUsuario']; ?> - 
                                            <?php echo $dtoIntervalo->getHoraInicio().'~'.$dtoIntervalo->getHoraFinal(); ?>
                                        </h3>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-sm-5 col-sm-offset-1 col-md-4 col-md-offset-2 text-center">
                                        <a href="<?php echo BASE_URL; ?>/intervalo/consultar/<?php echo $dtoIntervalo->getCdnDentista(); ?>">
                                            <button class="btn btn-lg btn-block btn-default">
                                                Não! Cancele!
                                            </button>
                                        </a>
                                    </div>
                                    <div class="visible-xs">
                                        <br><br>
                                    </div>
                                    <div class="col-sm-5 col-md-4 text-center">
                                        <a href="<?php echo BASE_URL; ?>/intervalo/deletarFim/<?php echo $dtoIntervalo->getCdnIntervalo(); ?>">
                                            <button class="btn btn-lg btn-block btn-warning">
                                                Sim, deletar.
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
