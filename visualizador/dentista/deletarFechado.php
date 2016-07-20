                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content text-center p-md">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>
                                            <span class="text-navy">Tem certeza que deseja desfazer o fechamento de agenda?</span>
                                        </h2>
                                        <h3>
                                            O dia <?php echo $dtoFechado->getDatFechado(true); ?> voltará às configurações padrões para o dentista <?php echo $arrUsuario['nomUsuario']; ?>.
                                        </h3>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-sm-5 col-sm-offset-1 col-md-4 col-md-offset-2 text-center">
                                        <a href="<?php echo BASE_URL; ?>/dentista/fecharAgenda/<?php echo $arrUsuario['cdnUsuario']; ?>">
                                            <button class="btn btn-lg btn-block btn-default">
                                                Não! Cancele!
                                            </button>
                                        </a>
                                    </div>
                                    <div class="visible-xs">
                                        <br><br>
                                    </div>
                                    <div class="col-sm-5 col-md-4 text-center">
                                        <a href="<?php echo BASE_URL; ?>/dentista/deletarFechadoFim/<?php echo $dtoFechado->getCdnFechado(); ?>">
                                            <button class="btn btn-lg btn-block btn-warning">
                                                Sim, desfazer.
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
