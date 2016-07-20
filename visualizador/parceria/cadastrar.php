                    <div class="col-md-12">
                        <form action="<?php echo BASE_URL; ?>/parceria/cadastrarFim" method="post">
                            <div class="row">
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="nomParceria">Nome</label>
                                    <input required class="form-control" name="nomParceria" type="text" >
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="indPaciente">Indicação de paciente?</label>
                                    <Br>
                                    <input required name="indPaciente" value="1" type="radio" checked> Sim
                                    <input required name="indPaciente" value="0" type="radio" > Não
                                    <br>
                                    <br>
                                </div>
                                <div class="col-md-6 col-lg-3" id="paciente">
                                    <?php echo $selectPaciente; ?>
                                </div>
                                <div class="col-md-6 col-lg-3" id="funcionario" style="display: none;">
                                    <?php echo $selectUsuario; ?>
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strEndereco">Endereço</label>
                                    <input class="form-control" name="strEndereco" type="text" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="nomCidade">Cidade</label>
                                    <input class="form-control" name="nomCidade" type="text">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="codCep">CEP</label>
                                    <input class="form-control mask-cep" name="codCep" type="text">
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
                                    <label class="control-label" for="indFisica">Pessoa física?</label>
                                    <br>
                                    <input name="indFisica" type="checkbox">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="codCpfCnpj">CPF/CNPJ</label>
                                    <input class="form-control mask-cpfcnpj" name="codCpfCnpj" type="text" >
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="codIe">Inscrição Estadual</label>
                                    <input class="form-control" name="codIe" type="text">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="numTelefone1">Número telefone 1</label>
                                    <input class="form-control" name="numTelefone1" type="text">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="numTelefone2">Número telefone 2</label>
                                    <input class="form-control" name="numTelefone2" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strEmail">E-mail</label>
                                    <input class="form-control" name="strEmail" type="email">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="nomRepresentante">Nome representante</label>
                                    <input class="form-control" name="nomRepresentante" type="text">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="numRepresentanteTelefone">Telefone representante</label>
                                    <input class="form-control" name="numRepresentanteTelefone" type="text">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strRepresentanteEmail">E-mail representante</label>
                                    <input class="form-control" name="strRepresentanteEmail" type="email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="datContrato">Data do contrato</label>
                                    <input class="form-control mask-date" name="datContrato" type="date">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="numContrato">Número do contrato</label>
                                    <input class="form-control" name="numContrato" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 form-group">
                                    <label class="control-label" for="desParceria">Observações</label>
                                    <textarea class="form-control" name="desParceria"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
