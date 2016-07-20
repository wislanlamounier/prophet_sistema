<div class="col-md-12">
    <div class="row">
        <form action="<?php echo BASE_URL; ?>/estilo/atualizarFim/<?php echo $dtoEstilo->getCdnUsuario(); ?>" method="post">
            <div class="col-md-6 col-lg-4 form-group">
                <label class="control-label" for="nomSkin">Geral</label>
                <select class="form-control" name="nomSkin">
                    <option <?php echo is_null($dtoEstilo->getNomSkin()) || $dtoEstilo->getNomSkin() == '' ? 'selected' : ''; ?> value="">Padrão</option>
                    <option <?php echo $dtoEstilo->getNomSkin() == 'skin-1' ? 'selected' : ''; ?> value="skin-1">Azul</option>
                    <option <?php echo $dtoEstilo->getNomSkin() == 'skin-3' ? 'selected' : ''; ?> value="skin-3">Roxo c/ Amarelo</option>
                </select>
            </div>

            <div class="col-md-6 col-lg-4 form-group">
                <label class="control-label" for="nomFundoConteudo">Fundo da página</label>
                <select class="form-control" name="nomFundoConteudo">
                    <option class="yellow-bg" <?php echo $dtoEstilo->getNomFundoConteudo() == 'yellow-bg' ? 'selected' : ''; ?> value="yellow-bg">Amarelo</option>
                    <option class="blue-bg" <?php echo $dtoEstilo->getNomFundoConteudo() == 'blue-bg' ? 'selected' : ''; ?> value="blue-bg">Azul</option>
                    <option class="lazur-bg" <?php echo $dtoEstilo->getNomFundoConteudo() == 'lazur-bg' ? 'selected' : ''; ?> value="lazur-bg">Azul claro</option>
                    <option class="white-bg" <?php echo $dtoEstilo->getNomFundoConteudo() == 'white-bg' ? 'selected' : ''; ?> value="white-bg">Branco</option>
                    <option class="gray-bg" <?php echo $dtoEstilo->getNomFundoConteudo() == 'gray-bg' ? 'selected' : ''; ?> value="gray-bg">Cinza</option>
                    <option class="black-bg" <?php echo $dtoEstilo->getNomFundoConteudo() == 'black-bg' ? 'selected' : ''; ?> value="black-bg">Preto</option>
                    <option class="pink-bg" <?php echo $dtoEstilo->getNomFundoConteudo() == 'pink-bg' ? 'selected' : ''; ?> value="pink-bg">Rosa</option>
                    <option class="navy-bg" <?php echo $dtoEstilo->getNomFundoConteudo() == 'navy-bg' ? 'selected' : ''; ?> value="navy-bg">Verde claro</option>
                    <option class="red-bg" <?php echo $dtoEstilo->getNomFundoConteudo() == 'red-bg' ? 'selected' : ''; ?> value="red-bg">Vermelho</option>
                </select>
            </div>

            <div class="col-md-6 col-lg-4 form-group">
                <label class="control-label" for="nomFundoHeader">Fundo do cabeçalho (título)</label>
                <select class="form-control" name="nomFundoHeader">
                    <option class="yellow-bg" <?php echo $dtoEstilo->getNomFundoHeader() == 'yellow-bg' ? 'selected' : ''; ?> value="yellow-bg">Amarelo</option>
                    <option class="blue-bg" <?php echo $dtoEstilo->getNomFundoHeader() == 'blue-bg' ? 'selected' : ''; ?> value="blue-bg">Azul</option>
                    <option class="lazur-bg" <?php echo $dtoEstilo->getNomFundoHeader() == 'lazur-bg' ? 'selected' : ''; ?> value="lazur-bg">Azul claro</option>
                    <option class="white-bg" <?php echo $dtoEstilo->getNomFundoHeader() == 'white-bg' ? 'selected' : ''; ?> value="white-bg">Branco</option>
                    <option class="gray-bg" <?php echo $dtoEstilo->getNomFundoHeader() == 'gray-bg' ? 'selected' : ''; ?> value="gray-bg">Cinza</option>
                    <option class="black-bg" <?php echo $dtoEstilo->getNomFundoHeader() == 'black-bg' ? 'selected' : ''; ?> value="black-bg">Preto</option>
                    <option class="pink-bg" <?php echo $dtoEstilo->getNomFundoHeader() == 'pink-bg' ? 'selected' : ''; ?> value="pink-bg">Rosa</option>
                    <option class="navy-bg" <?php echo $dtoEstilo->getNomFundoHeader() == 'navy-bg' ? 'selected' : ''; ?> value="navy-bg">Verde claro</option>
                    <option class="red-bg" <?php echo $dtoEstilo->getNomFundoHeader() == 'red-bg' ? 'selected' : ''; ?> value="red-bg">Vermelho</option>
                </select>
            </div>

            <div class="col-md-8 form-group">
                <label class="control-label" for="nomBotaoPrimario">Botão geral</label>
                <select class="form-control" name="nomBotaoPrimario">
                    <option <?php echo $dtoEstilo->getNomBotaoPrimario() == '' ? 'selected' : ''; ?> value="">Padrão</option>
                    <option class="yellow-bg" <?php echo $dtoEstilo->getNomBotaoPrimario() == 'yellow-bg' ? 'selected' : ''; ?> value="yellow-bg">Amarelo</option>
                    <option class="blue-bg" <?php echo $dtoEstilo->getNomBotaoPrimario() == 'blue-bg' ? 'selected' : ''; ?> value="blue-bg">Azul</option>
                    <option class="lazur-bg" <?php echo $dtoEstilo->getNomBotaoPrimario() == 'lazur-bg' ? 'selected' : ''; ?> value="lazur-bg">Azul claro</option>
                    <option class="white-bg" <?php echo $dtoEstilo->getNomBotaoPrimario() == 'white-bg' ? 'selected' : ''; ?> value="white-bg">Branco</option>
                    <option class="gray-bg" <?php echo $dtoEstilo->getNomBotaoPrimario() == 'gray-bg' ? 'selected' : ''; ?> value="gray-bg">Cinza</option>
                    <option class="black-bg" <?php echo $dtoEstilo->getNomBotaoPrimario() == 'black-bg' ? 'selected' : ''; ?> value="black-bg">Preto</option>
                    <option class="pink-bg" <?php echo $dtoEstilo->getNomBotaoPrimario() == 'pink-bg' ? 'selected' : ''; ?> value="pink-bg">Rosa</option>
                    <option class="navy-bg" <?php echo $dtoEstilo->getNomBotaoPrimario() == 'navy-bg' ? 'selected' : ''; ?> value="navy-bg">Verde claro</option>
                    <option class="red-bg" <?php echo $dtoEstilo->getNomBotaoPrimario() == 'red-bg' ? 'selected' : ''; ?> value="red-bg">Vermelho</option>
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
                    <option <?php echo $dtoEstilo->getNomBotaoSucesso() == '' ? 'selected' : ''; ?> value="">Padrão</option>
                    <option class="yellow-bg" <?php echo $dtoEstilo->getNomBotaoSucesso() == 'yellow-bg' ? 'selected' : ''; ?> value="yellow-bg">Amarelo</option>
                    <option class="blue-bg" <?php echo $dtoEstilo->getNomBotaoSucesso() == 'blue-bg' ? 'selected' : ''; ?> value="blue-bg">Azul</option>
                    <option class="lazur-bg" <?php echo $dtoEstilo->getNomBotaoSucesso() == 'lazur-bg' ? 'selected' : ''; ?> value="lazur-bg">Azul claro</option>
                    <option class="white-bg" <?php echo $dtoEstilo->getNomBotaoSucesso() == 'white-bg' ? 'selected' : ''; ?> value="white-bg">Branco</option>
                    <option class="gray-bg" <?php echo $dtoEstilo->getNomBotaoSucesso() == 'gray-bg' ? 'selected' : ''; ?> value="gray-bg">Cinza</option>
                    <option class="black-bg" <?php echo $dtoEstilo->getNomBotaoSucesso() == 'black-bg' ? 'selected' : ''; ?> value="black-bg">Preto</option>
                    <option class="pink-bg" <?php echo $dtoEstilo->getNomBotaoSucesso() == 'pink-bg' ? 'selected' : ''; ?> value="pink-bg">Rosa</option>
                    <option class="navy-bg" <?php echo $dtoEstilo->getNomBotaoSucesso() == 'navy-bg' ? 'selected' : ''; ?> value="navy-bg">Verde claro</option>
                    <option class="red-bg" <?php echo $dtoEstilo->getNomBotaoSucesso() == 'red-bg' ? 'selected' : ''; ?> value="red-bg">Vermelho</option>
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
                    Editar
                </button>
            </div>
        </form>
    </div>

</div>
