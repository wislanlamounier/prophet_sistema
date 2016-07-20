                    <div class="col-md-12">
                        <div class="row">
                            <form action="<?php echo BASE_URL; ?>/colaborador/cadastrarFim" method="post">
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="nomUsuario">Nome</label>
                                    <input class="form-control" name="nomUsuario" type="text" required>
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strEmail">E-mail</label>
                                    <input class="form-control" name="strEmail" type="email" required>
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strSenha">Senha</label>
                                    <input class="form-control" name="strSenha" type="password" required>
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="confSenha">Confirmação de senha</label>
                                    <input class="form-control" name="confSenha" type="password" required>
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="codCpf">CPF</label>
                                    <input class="form-control mask-cpf" name="codCpf" type="text">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strEndereco">Endereço</label>
                                    <input class="form-control" name="strEndereco" type="text">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="nomCidade">Cidade</label>
                                    <input class="form-control" name="nomCidade" type="text">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                	<label class="control-label" for="codUf">Estado</label>
    	                            <select class="form-control" name="codUf">
    									<option value="ac">Acre</option>
    									<option value="al">Alagoas</option>
    									<option value="ap">Amapá</option>
    									<option value="am">Amazonas</option>
    									<option value="ba">Bahia</option>
    									<option value="ce">Ceará</option>
    									<option value="df">Distrito Federal</option>
    									<option value="es">Espirito Santo</option>
    									<option value="go">Goiás</option>
    									<option value="ma">Maranhão</option>
    									<option value="ms">Mato Grosso do Sul</option>
    									<option value="mt">Mato Grosso</option>
    									<option value="mg">Minas Gerais</option>
    									<option value="pa">Pará</option>
    									<option value="pb">Paraíba</option>
    									<option value="pr">Paraná</option>
    									<option value="pe">Pernambuco</option>
    									<option value="pi">Piauí</option>
    									<option value="rj">Rio de Janeiro</option>
    									<option value="rn">Rio Grande do Norte</option>
    									<option value="rs">Rio Grande do Sul</option>
    									<option value="ro">Rondônia</option>
    									<option value="rr">Roraima</option>
    									<option value="sc">Santa Catarina</option>
    									<option value="sp">São Paulo</option>
    									<option value="se">Sergipe</option>
    									<option value="to">Tocantins</option>
    								</select>
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="codCep">CEP</label>
                                    <input class="form-control mask-cep" name="codCep" type="text">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="numTelefone1">Telefone 1</label>
                                    <input class="form-control" name="numTelefone1" type="text">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="numTelefone2">Telefone 2</label>
                                    <input class="form-control" name="numTelefone2" type="text">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="datNascimento">Data de nascimento</label>
                                    <input class="form-control mask-date" name="datNascimento" type="date">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="datAdmissao">Data de admissão</label>
                                    <input class="form-control mask-date" name="datAdmissao" type="date">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="valRemuneracao">Remuneração</label>
                                    <input class="form-control mask-money" name="valRemuneracao" type="text">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="indPorcentagem">Tem porcentagem sobre as vendas feitas?</label>
                                    <br>
                                    <input name="indPorcentagem" type="checkbox">
                                </div>
                                <div class="col-md-12 col-lg-12 form-group">
                                    <label class="control-label" for="desColaborador">Observações</label>
                                    <textarea class="form-control" name="desColaborador"></textarea>
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
