                    <div class="col-md-12">
                        <div class="row">
                            <form action="<?php echo BASE_URL; ?>/usuario/atualizarFim/<?php echo $arrUsuario['cdnUsuario']; ?>" method="post">
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="nomUsuario">Nome</label>
                                    <input class="form-control" name="nomUsuario" type="text" required value="<?php echo $arrUsuario['nomUsuario']; ?>">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strEmail">E-mail</label>
                                    <input class="form-control" name="strEmail" type="email"  value="<?php echo $arrUsuario['strEmail']; ?>">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strSenha">Senha</label>
                                    <input class="form-control" name="strSenha" type="password" >
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="confSenha">Confirmação de senha</label>
                                    <input class="form-control" name="confSenha" type="password" >
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Editar
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
