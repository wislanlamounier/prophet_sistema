                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content text-center p-md">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>
                                        <?php
                                            if($indProntuario){
                                        ?>
                                            <span class="text-navy">Tem certeza que deseja fechar o acesso aos prontuários?</span>
                                        <?php
                                            }else{
                                        ?>
                                            <span class="text-navy">Tem certeza que deseja liberar o acesso aos prontuários?</span>
                                        <?php
                                            }

                                            if($indProntuario)
                                                $indProntuario = 0;
                                            else
                                                $indProntuario = 1;
                                        ?>
                                        </h2>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-sm-5 col-sm-offset-1 col-md-4 col-md-offset-2 text-center">
                                        <a href="<?php echo BASE_URL; ?>/">
                                            <button class="btn btn-lg btn-block btn-default">
                                                Não! Cancele!
                                            </button>
                                        </a>
                                    </div>
                                    <div class="visible-xs">
                                        <br><br>
                                    </div>
                                    <div class="col-sm-5 col-md-4 text-center">
                                        <a href="<?php echo BASE_URL; ?>/clinica/disponivelFim/<?php echo $indProntuario; ?>">
                                            <button class="btn btn-lg btn-block btn-warning">
                                                Sim, desejo.
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
