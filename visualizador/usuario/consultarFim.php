                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/usuario/cadastrar">
                                    <button class="btn btn-success">
                                        Cadastrar novo usuário
                                    </button>
                                </a>
                            </div>
                            <div class="ibox-content text-center p-md">

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="control-label" for="nomUsuario">Nome</label>
                                        <input disabled class="form-control" name="nomUsuario" type="text" placeholder="Nome do usuário" value="<?php echo $arrUsuario['nomUsuario']; ?>">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="control-label" for="strEmail">E-mail</label>
                                        <input disabled class="form-control" name="strEmail" type="email" placeholder="E-mail do usuário" value="<?php echo $arrUsuario['strEmail']; ?>">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-lg-offset-2 col-md-offset-2 col-lg-4">
                                            <a href="<?php echo BASE_URL; ?>/usuario/atualizar/<?php echo $arrUsuario['cdnUsuario']; ?>">
                                                <button type="button" class="btn btn-block btn-lg btn-success">
                                                    Editar
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-lg-4">
                                            <a href="<?php echo BASE_URL; ?>/permissao/atualizar/<?php echo $arrUsuario['cdnUsuario']; ?>">
                                                <button type="button" class="btn btn-block btn-lg btn-primary">
                                                    Permissões
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                    $modMain = new ModeloMain(true);
                                    if($_SESSION['cdnUsuario'] == $arrUsuario['cdnUsuario'] or
                                       $modMain->dono()){
                                ?>
                                <div class="row text-justify">

                                    <div class="col-md-12">
                                        <span class="text-muted">
                                            <?php echo $this->link('usuario', 'deletar', 'Deletar conta', array($arrUsuario['cdnUsuario'])); ?>
                                        </span>
                                    </div>

                                </div>
                                <?php
                                    }
                                ?>

                            </div>
                        </div>
                    </div>
