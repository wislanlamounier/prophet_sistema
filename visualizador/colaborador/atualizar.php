<div class="col-md-12">
    <div class="row">
        <form action="<?php echo BASE_URL; ?>/colaborador/atualizarFim/<?php echo $dtoColaborador->getCdnUsuario(); ?>" method="post">
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="nomUsuario">Nome</label>
                <input class="form-control" name="nomUsuario" type="text" value="<?php echo $arrUsuario['nomUsuario']; ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="strEmail">E-mail</label>
                <input class="form-control" name="strEmail" type="email" value="<?php echo $arrUsuario['strEmail']; ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="strSenha">Senha</label>
                <input class="form-control" name="strSenha" type="password" >
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="confSenha">Confirmação de senha</label>
                <input class="form-control" name="confSenha" type="password" >
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="codCpf">CPF</label>
                <input class="form-control mask-cpf" name="codCpf" type="text"  value="<?php echo $dtoColaborador->getCodCpf(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="strEndereco">Endereço</label>
                <input class="form-control" name="strEndereco" type="text" value="<?php echo $dtoColaborador->getStrEndereco(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="nomCidade">Cidade</label>
                <input class="form-control" name="nomCidade" type="text" value="<?php echo $dtoColaborador->getNomCidade(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="codUf">Estado</label>
                <select class="form-control" name="codUf">
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'ac') ? 'selected' : ''; ?> value="ac">Acre</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'al') ? 'selected' : ''; ?> value="al">Alagoas</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'ap') ? 'selected' : ''; ?> value="ap">Amapá</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'am') ? 'selected' : ''; ?> value="am">Amazonas</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'ba') ? 'selected' : ''; ?> value="ba">Bahia</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'ce') ? 'selected' : ''; ?> value="ce">Ceará</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'df') ? 'selected' : ''; ?> value="df">Distrito Federal</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'es') ? 'selected' : ''; ?> value="es">Espirito Santo</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'go') ? 'selected' : ''; ?> value="go">Goiás</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'ma') ? 'selected' : ''; ?> value="ma">Maranhão</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'ms') ? 'selected' : ''; ?> value="ms">Mato Grosso do Sul</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'mt') ? 'selected' : ''; ?> value="mt">Mato Grosso</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'mg') ? 'selected' : ''; ?> value="mg">Minas Gerais</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'pa') ? 'selected' : ''; ?> value="pa">Pará</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'pb') ? 'selected' : ''; ?> value="pb">Paraíba</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'pr') ? 'selected' : ''; ?> value="pr">Paraná</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'pe') ? 'selected' : ''; ?> value="pe">Pernambuco</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'pi') ? 'selected' : ''; ?> value="pi">Piauí</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'rj') ? 'selected' : ''; ?> value="rj">Rio de Janeiro</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'rn') ? 'selected' : ''; ?> value="rn">Rio Grande do Norte</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'rs') ? 'selected' : ''; ?> value="rs">Rio Grande do Sul</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'ro') ? 'selected' : ''; ?> value="ro">Rondônia</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'rr') ? 'selected' : ''; ?> value="rr">Roraima</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'sc') ? 'selected' : ''; ?> value="sc">Santa Catarina</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'sp') ? 'selected' : ''; ?> value="sp">São Paulo</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'se') ? 'selected' : ''; ?> value="se">Sergipe</option>
                    <option <?php echo strtolower($dtoColaborador->getCodUf() == 'to') ? 'selected' : ''; ?> value="to">Tocantins</option>
                </select>
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="codCep">CEP</label>
                <input class="form-control mask-cep" name="codCep" type="text" value="<?php echo $dtoColaborador->getCodCep(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="numTelefone1">Telefone 1</label>
                <input class="form-control" name="numTelefone1" type="text" value="<?php echo $dtoColaborador->getNumTelefone1(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="numTelefone2">Telefone 2</label>
                <input class="form-control" name="numTelefone2" type="text" value="<?php echo $dtoColaborador->getNumTelefone2(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="datNascimento">Data de nascimento</label>
                <input class="form-control mask-date" name="datNascimento" type="date" value="<?php echo $dtoColaborador->getDatNascimento(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="datAdmissao">Data de admissão</label>
                <input class="form-control mask-date" name="datAdmissao" type="date" value="<?php echo $dtoColaborador->getDatAdmissao(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="valRemuneracao">Remuneração</label>
                <input class="form-control mask-money" name="valRemuneracao" type="text" value="R$<?php echo $dtoColaborador->getValRemuneracao(true); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="indPorcentagem">Tem porcentagem sobre as vendas feitas?</label>
                <br>
                <input <?php echo $dtoColaborador->getIndPorcentagem() ? 'checked' : ''; ?> name="indPorcentagem" value="true" type="checkbox">
            </div>
            <div class="col-md-12 col-lg-12 form-group">
                <label class="control-label" for="desColaborador">Observações</label>
                <textarea class="form-control" name="desColaborador"><?php echo $dtoColaborador->getDescolaborador(); ?></textarea>
            </div>
            <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <button type="submit" class="btn btn-block btn-lg btn-primary">
                    Editar
                </button>
            </div>
        </form>
    </div>

</div>
