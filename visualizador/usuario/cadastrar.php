                    <div class="col-md-12">
                        <div class="row">
                            <form action="<?php echo BASE_URL; ?>/usuario/cadastrarFim" method="post">
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="nomUsuario">Nome</label>
                                    <input class="form-control" name="nomUsuario" type="text"  required>
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strEmail">E-mail</label>
                                    <input class="form-control" name="strEmail" type="email" required>
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strSenha">Senha</label>
                                    <input class="form-control" name="strSenha" type="password"  required>
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="confSenha">Confirmação de senha</label>
                                    <input class="form-control" name="confSenha" type="password" required>
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
