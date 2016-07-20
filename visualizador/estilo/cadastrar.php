                    <div class="col-md-12">
                        <div class="row">
                            <form action="<?php echo BASE_URL; ?>/estilo/cadastrarFim/<?php echo $cdnUsuario; ?>" method="post">
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="nomSkin">Geral</label>
                                    <select class="form-control" name="nomSkin">
                                        <option value="">Padrão</option>
                                        <option value="skin-1">Azul</option>
                                        <option value="skin-3">Roxo c/ Amarelo</option>
                                    </select>
                                </div>

                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="nomFundoConteudo">Fundo da página</label>
                                    <select class="form-control" name="nomFundoConteudo">
                                        <option class="yellow-bg" value="yellow-bg">Amarelo</option>
                                        <option class="blue-bg" value="blue-bg">Azul</option>
                                        <option class="lazur-bg" value="lazur-bg">Azul claro</option>
                                        <option class="white-bg" value="white-bg">Branco</option>
                                        <option selected class="gray-bg" value="gray-bg">Cinza</option>
                                        <option class="black-bg" value="black-bg">Preto</option>
                                        <option class="ping-bg" value="pink-bg">Rosa</option>
                                        <option class="navy-bg" value="navy-bg">Verde claro</option>
                                        <option class="red-bg" value="red-bg">Vermelho</option>
                                    </select>
                                </div>

                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="nomFundoHeader">Fundo do cabeçalho (título)</label>
                                    <select class="form-control" name="nomFundoHeader">
                                        <option class="yellow-bg" value="yellow-bg">Amarelo</option>
                                        <option class="blue-bg" value="blue-bg">Azul</option>
                                        <option class="lazur-bg" value="lazur-bg">Azul claro</option>
                                        <option class="white-bg" value="white-bg">Branco</option>
                                        <option class="gray-bg" value="gray-bg">Cinza</option>
                                        <option class="black-bg" value="black-bg">Preto</option>
                                        <option class="ping-bg" value="pink-bg">Rosa</option>
                                        <option selected class="navy-bg" value="navy-bg">Verde claro</option>
                                        <option class="red-bg" value="red-bg">Vermelho</option>
                                    </select>
                                </div>


                                <div class="col-md-8 form-group">
                                    <label class="control-label" for="nomBotaoPrimario">Botão geral</label>
                                    <select class="form-control" name="nomBotaoPrimario">
                                        <option value="">Padrão</option>
                                        <option class="yellow-bg" value="yellow-bg">Amarelo</option>
                                        <option class="blue-bg" value="blue-bg">Azul</option>
                                        <option class="lazur-bg" value="lazur-bg">Azul claro</option>
                                        <option class="white-bg" value="white-bg">Branco</option>
                                        <option class="gray-bg" value="gray-bg">Cinza</option>
                                        <option class="black-bg" value="black-bg">Preto</option>
                                        <option class="pink-bg" value="pink-bg">Rosa</option>
                                        <option class="navy-bg" value="navy-bg">Verde claro</option>
                                        <option class="red-bg" value="red-bg">Vermelho</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <b>Botão geral atual:</b><br>
                                    <button type="button" class="btn btn-lg btn-success">
                                        Exemplo
                                    </button>
                                </div>

                                <div class="col-md-8 form-group">
                                    <label class="control-label" for="nomBotaoSucesso">Botão de cadastro</label>
                                    <select class="form-control" name="nomBotaoSucesso">
                                        <option value="">Padrão</option>
                                        <option class="yellow-bg" value="yellow-bg">Amarelo</option>
                                        <option class="blue-bg" value="blue-bg">Azul</option>
                                        <option class="lazur-bg" value="lazur-bg">Azul claro</option>
                                        <option class="white-bg" value="white-bg">Branco</option>
                                        <option class="gray-bg" value="gray-bg">Cinza</option>
                                        <option class="black-bg" value="black-bg">Preto</option>
                                        <option class="pink-bg" value="pink-bg">Rosa</option>
                                        <option class="navy-bg" value="navy-bg">Verde claro</option>
                                        <option class="red-bg" value="red-bg">Vermelho</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <b>Botão de cadastro atual:</b><br>
                                    <button type="button" class="btn btn-lg btn-primary">
                                        Exemplo
                                    </button>
                                </div>


                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
