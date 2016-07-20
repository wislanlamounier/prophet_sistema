                    <div class="col-md-12">
                        <div class="row">
                            <form action="<?php echo BASE_URL; ?>/dentista/cadastrarFim" method="post">
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="nomUsuario">Nome</label>
                                    <input class="form-control" name="nomUsuario" type="text"  required>
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strEmail">E-mail</label>
                                    <input class="form-control" name="strEmail" type="email"  required>
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strSenha">Senha</label>
                                    <input class="form-control" name="strSenha" type="password"  required>
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="confSenha">Confirmação de senha</label>
                                    <input class="form-control" name="confSenha" type="password"  required>
                                </div>
                                <div class="col-md-3 col-lg-3 form-group">
                                    <label class="control-label" for="codCpf">CPF</label>
                                    <input class="form-control mask-cpf" name="codCpf" type="text" >
                                </div>
                                <div class="col-md-3 col-lg-3 form-group">
                                    <label class="control-label" for="codCro">CRO</label>
                                    <input class="form-control" name="codCro" type="text">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strEndereco">Endereço</label>
                                    <input class="form-control" name="strEndereco" type="text" >
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
                                    <label class="control-label" for="numTempoConsulta">Tempo de consulta (hora:minuto)</label>
                                    <input class="form-control mask-time" name="numTempoConsulta" type="text">
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
                                    <input  class="form-control mask-date" name="datNascimento" type="date">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="datAdmissao">Data de admissão</label>
                                    <input class="form-control mask-date" name="datAdmissao" type="date">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label" for="strOutrosTrabalhos">Outros trabalhos</label>
                                    <textarea class="form-control" name="strOutrosTrabalhos"></textarea>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label" for="strContaBancaria">Conta bancária</label>
                                    <textarea class="form-control" name="strContaBancaria"></textarea>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label class="control-label" for="desDentista">Observações</label>
                                    <textarea class="form-control" name="desDentista"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <h4>Dias de trabalho</h4>
                                    <p>Dias nos quais este dentista trabalha</p>
                                </div>
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-hover table-striped">
                                        <tr>
                                            <th>Dia</th>
                                            <th>Trabalha?</th>
                                            <th>Horário (manhã)</th>
                                            <th>Horário (tarde)</th>
                                        </tr>
                                        <tr>
                                            <td>Domingo</td>
                                            <td><input type="checkbox" name="indDomingo"></td>
                                            <td><input type="text" class="form-control mask-timeInterval" name="horaDomingoManha"></td>
                                            <td><input type="text" class="form-control mask-timeInterval" name="horaDomingoManha"></td>
                                        </tr>
                                        <tr>
                                            <td>Segunda<span class="hidden-xs">-feira</span></td>
                                            <td><input type="checkbox" name="indSegunda"></td>
                                            <td><input type="text" class="form-control mask-timeInterval" name="horaSegundaManha"></td>
                                            <td><input type="text" class="form-control mask-timeInterval" name="horaSegundaTarde"></td>
                                        </tr>
                                        <tr>
                                            <td>Terça<span class="hidden-xs">-feira</span></td>
                                            <td><input type="checkbox" name="indTerca"></td>
                                            <td><input type="text" class="form-control mask-timeInterval" name="horaTercaManha"></td>
                                            <td><input type="text" class="form-control mask-timeInterval" name="horaTercaTarde"></td>
                                        </tr>
                                        <tr>
                                            <td>Quarta<span class="hidden-xs">-feira</span></td>
                                            <td><input type="checkbox" name="indQuarta"></td>
                                            <td><input type="text" class="form-control mask-timeInterval" name="horaQuartaManha"></td>
                                            <td><input type="text" class="form-control mask-timeInterval" name="horaQuartaTarde"></td>
                                        </tr>
                                        <tr>
                                            <td>Quinta<span class="hidden-xs">-feira</span></td>
                                            <td><input type="checkbox" name="indQuinta"></td>
                                            <td><input type="text" class="form-control mask-timeInterval" name="horaQuintaManha"></td>
                                            <td><input type="text" class="form-control mask-timeInterval" name="horaQuintaTarde"></td>
                                        </tr>
                                        <tr>
                                            <td>Sexta<span class="hidden-xs">-feira</span></td>
                                            <td><input type="checkbox" name="indSexta"></td>
                                            <td><input type="text" class="form-control mask-timeInterval" name="horaSextaManha"></td>
                                            <td><input type="text" class="form-control mask-timeInterval" name="horaSextaTarde"></td>
                                        </tr>
                                        <tr>
                                            <td>Sábado</td>
                                            <td><input type="checkbox" name="indSabado"></td>
                                            <td><input type="text" class="form-control mask-timeInterval" name="horaSabadoManha"></td>
                                            <td><input type="text" class="form-control mask-timeInterval" name="horaSabadoTarde"></td>
                                        </tr>
                                    </table>
                                </div>
                                    
                                <div class="col-md-12">
                                    <h4>Consultório dentista</h4>
                                    <p>Consultório que é mais utilizado por este dentista.</p>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="cdnConsultorio" class="control-label">Consultório</label>
                                    <select class="select2 form-control" name="cdnConsultorio">
                                        <option value="">Nenhum</option>
                                        <?php
                                            foreach($arrConsultorios as $arrConsultorio){
                                                echo '<option value="'.$arrConsultorio['cdnConsultorio'].'">'.$arrConsultorio['numConsultorio'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div id="rowAreas">
                                    <div class="col-md-12">
                                        <h4>Áreas de atuação</h4>
                                        <p>Áreas de atuação deste dentista.</p>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-default" type="button" id="addArea">
                                            <span class="fa fa-plus"></span>
                                        </button>
                                        <button class="btn btn-default" type="button" id="removerArea">
                                            <span class="fa fa-minus"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
