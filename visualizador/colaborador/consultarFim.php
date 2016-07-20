                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/colaborador/cadastrar">
                                    <button class="btn btn-success">
                                        Cadastrar novo colaborador
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
                                    <div class="col-md-6 col-lg-3 form-group">
                                        <label class="control-label" for="codCpf">CPF</label>
                                        <input disabled class="form-control mask-cpf" name="codCpf" type="text" placeholder="Código CPF" value="<?php echo $dtoColaborador->getCodCpf(); ?>">
                                    </div>
                                    <div class="col-md-6 col-lg-3 form-group">
                                        <label class="control-label" for="strEndereco">Endereço</label>
                                        <input disabled class="form-control" name="strEndereco" type="text" placeholder="Endereço do colaborador" value="<?php echo $dtoColaborador->getStrEndereco(); ?>">
                                    </div>
                                    <div class="col-md-6 col-lg-3 form-group">
                                        <label class="control-label" for="nomCidade">Cidade</label>
                                        <input disabled class="form-control" name="nomCidade" type="text" placeholder="Cidade do colaborador" value="<?php echo $dtoColaborador->getNomCidade(); ?>">
                                    </div>
                                    <div class="col-md-6 col-lg-3 form-group">
                                        <label class="control-label" for="codUf">Estado</label>
                                        <select disabled class="form-control" name="codUf">
                                            <option value="">Selecione o Estado</option>
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
                                        <input disabled class="form-control mask-cep" name="codCep" type="text" placeholder="Código do CEP" value="<?php echo $dtoColaborador->getCodCep(); ?>">
                                    </div>
                                    <div class="col-md-6 col-lg-3 form-group">
                                        <label class="control-label" for="numTelefone1">Telefone 1</label>
                                        <input disabled class="form-control" name="numTelefone1" type="text" placeholder="Telefone do colaborador" value="<?php echo $dtoColaborador->getNumTelefone1(); ?>">
                                    </div>
                                    <div class="col-md-6 col-lg-3 form-group">
                                        <label class="control-label" for="numTelefone2">Telefone 2</label>
                                        <input disabled class="form-control" name="numTelefone2" type="text" placeholder="Telefone do colaborador" value="<?php echo $dtoColaborador->getNumTelefone2(); ?>">
                                    </div>
                                    <div class="col-md-6 col-lg-3 form-group">
                                        <label class="control-label" for="datNascimento">Data de nascimento</label>
                                        <input disabled class="form-control mask-date" name="datNascimento" type="date" placeholder="Data de nascimento" value="<?php echo $dtoColaborador->getDatNascimento(); ?>">
                                    </div>
                                    <div class="col-md-6 col-lg-3 form-group">
                                        <label class="control-label" for="datAdmissao">Data de admissão</label>
                                        <input disabled class="form-control mask-date" name="datAdmissao" type="date" placeholder="Data de admissão" value="<?php echo $dtoColaborador->getDatAdmissao(); ?>">
                                    </div>
                                    <div class="col-md-6 col-lg-3 form-group">
                                        <label class="control-label" for="valRemuneracao">Remuneração</label>
                                        <input disabled class="form-control mask-money" name="valRemuneracao" type="text" placeholder="Valor de remuneração" value="R$<?php echo $dtoColaborador->getValRemuneracao(true); ?>">
                                    </div>
                                    <div class="col-md-6 col-lg-3 form-group">
                                        <label class="control-label" for="indPorcentagem">Tem porcentagem sobre as vendas feitas?</label>
                                        <br>
                                        <input <?php echo $dtoColaborador->getIndPorcentagem() ? 'checked' : ''; ?> disabled name="indPorcentagem" type="checkbox">
                                    </div>
                                    <div class="col-md-12 col-lg-12 form-group">
                                        <label class="control-label" for="desColaborador">Observações</label>
                                        <textarea disabled class="form-control" name="desColaborador" placeholder="Observações"><?php echo $dtoColaborador->getDescolaborador(); ?></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-lg-offset-2 col-md-offset-2 col-lg-4">
                                        <a href="<?php echo BASE_URL; ?>/colaborador/atualizar/<?php echo $arrUsuario['cdnUsuario']; ?>">
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

                                <?php
                                    $modMain = new ModeloMain(true);
                                    if($_SESSION['cdnUsuario'] == $arrUsuario['cdnUsuario'] or
                                       $modMain->dono() or $modColaborador->master()){
                                ?>
                                <div class="row text-justify">

                                    <div class="col-md-12">
                                        <span class="text-muted">
                                            <?php echo $this->link('colaborador', 'deletar', 'Deletar conta', array($arrUsuario['cdnUsuario'])); ?>
                                        </span>
                                    </div>

                                </div>
                                <?php
                                    }
                                ?>

                            </div>
                        </div>
                    </div>
