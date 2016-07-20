<div class="col-md-12 col-xs-12">
    <div class="ibox float-e-margins">
        <div class="ibox-header">
            <span class="pull-left">
                <b>
                    Média das notas de satisfação: 
                    <?php echo $dtoDentista->getNumNotaSatisfacao(); ?>
                </b>
            </span>
            <a class="pull-right" href="<?php echo BASE_URL; ?>/dentista/cadastrar">
                <button class="btn btn-success">
                    Cadastrar novo dentista
                </button>
            </a>
        </div>
        <div class="ibox-content text-center p-md">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="control-label" for="nomUsuario">Nome</label>
                    <input disabled class="form-control" name="nomUsuario" type="text" value="<?php echo $arrUsuario['nomUsuario']; ?>">
                </div>
                <div class="col-md-6 form-group">
                    <label class="control-label" for="strEmail">E-mail</label>
                    <input disabled class="form-control" name="strEmail" type="email" value="<?php echo $arrUsuario['strEmail']; ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="codCpf">CPF</label>
                    <input disabled class="form-control mask-cpf" name="codCpf" type="text" value="<?php echo $dtoDentista->getCodCpf(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="codCro">CRO</label>
                    <input disabled class="form-control" name="codCro" type="text" value="<?php echo $dtoDentista->getCodCro(); ?>">
                </div>
                <div class="col-md-6 col-lg-6 form-group">
                    <label class="control-label" for="strEndereco">Endereço</label>
                    <input disabled class="form-control" name="strEndereco" type="text" value="<?php echo $dtoDentista->getStrEndereco(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="nomCidade">Cidade</label>
                    <input disabled class="form-control" name="nomCidade" type="text"  value="<?php echo $dtoDentista->getNomCidade(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="codUf">Estado</label>
                    <select disabled class="form-control" name="codUf">
                        <option value="">Selecione o Estado</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'ac') ? 'selected' : ''; ?> value="ac">Acre</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'al') ? 'selected' : ''; ?> value="al">Alagoas</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'ap') ? 'selected' : ''; ?> value="ap">Amapá</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'am') ? 'selected' : ''; ?> value="am">Amazonas</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'ba') ? 'selected' : ''; ?> value="ba">Bahia</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'ce') ? 'selected' : ''; ?> value="ce">Ceará</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'df') ? 'selected' : ''; ?> value="df">Distrito Federal</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'es') ? 'selected' : ''; ?> value="es">Espirito Santo</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'go') ? 'selected' : ''; ?> value="go">Goiás</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'ma') ? 'selected' : ''; ?> value="ma">Maranhão</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'ms') ? 'selected' : ''; ?> value="ms">Mato Grosso do Sul</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'mt') ? 'selected' : ''; ?> value="mt">Mato Grosso</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'mg') ? 'selected' : ''; ?> value="mg">Minas Gerais</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'pa') ? 'selected' : ''; ?> value="pa">Pará</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'pb') ? 'selected' : ''; ?> value="pb">Paraíba</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'pr') ? 'selected' : ''; ?> value="pr">Paraná</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'pe') ? 'selected' : ''; ?> value="pe">Pernambuco</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'pi') ? 'selected' : ''; ?> value="pi">Piauí</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'rj') ? 'selected' : ''; ?> value="rj">Rio de Janeiro</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'rn') ? 'selected' : ''; ?> value="rn">Rio Grande do Norte</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'rs') ? 'selected' : ''; ?> value="rs">Rio Grande do Sul</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'ro') ? 'selected' : ''; ?> value="ro">Rondônia</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'rr') ? 'selected' : ''; ?> value="rr">Roraima</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'sc') ? 'selected' : ''; ?> value="sc">Santa Catarina</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'sp') ? 'selected' : ''; ?> value="sp">São Paulo</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'se') ? 'selected' : ''; ?> value="se">Sergipe</option>
                        <option <?php echo strtolower($dtoDentista->getCodUf() == 'to') ? 'selected' : ''; ?> value="to">Tocantins</option>
                    </select>
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="codCep">CEP</label>
                    <input disabled class="form-control mask-cep" name="codCep" type="text" value="<?php echo $dtoDentista->getCodCep(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="numTempoConsulta">Tempo de consulta (hora:minuto)</label>
                    <input disabled class="form-control mask-time" name="numTempoConsulta" type="text" value="<?php echo $dtoDentista->getNumTempoConsulta(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="numTelefone1">Telefone 1</label>
                    <input disabled class="form-control" name="numTelefone1" type="text" value="<?php echo $dtoDentista->getNumTelefone1(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="numTelefone2">Telefone 2</label>
                    <input disabled class="form-control" name="numTelefone2" type="text" value="<?php echo $dtoDentista->getNumTelefone2(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="datNascimento">Data de nascimento</label>
                    <input disabled class="form-control mask-date" name="datNascimento" type="date" value="<?php echo $dtoDentista->getDatNascimento(); ?>">
                </div>
                <div class="col-md-6 col-lg-3 form-group">
                    <label class="control-label" for="datAdmissao">Data de admissão</label>
                    <input disabled class="form-control mask-date" name="datAdmissao" type="date" value="<?php echo $dtoDentista->getDatAdmissao(); ?>">
                </div>
                <div class="col-md-6 form-group">
                    <label class="control-label" for="strOutrosTrabalhos">Outros trabalhos</label>
                    <textarea disabled class="form-control" name="strOutrosTrabalhos"><?php echo $dtoDentista->getStrOutrosTrabalhos(); ?></textarea>
                </div>
                <div class="col-md-6 form-group">
                    <label class="control-label" for="strContaBancaria">Conta bancária</label>
                    <textarea disabled class="form-control" name="strContaBancaria"><?php echo $dtoDentista->getStrContaBancaria(); ?></textarea>
                </div>
                <div class="col-md-12 form-group">
                    <label class="control-label" for="desDentista">Observações</label>
                    <textarea disabled class="form-control" name="desDentista"><?php echo $dtoDentista->getDesDentista(); ?></textarea>
                </div>
            </div>
            <div class="col-md-12 table-responsive text-justify">
                <table class="table table-hover table-striped">
                    <tr>
                        <th>Dia</th>
                        <th>Trabalha?</th>
                        <th>Horários (manhã)</th>
                        <th>Horários (tarde)</th>
                    </tr>
                    <tr>
                        <td>Domingo</td>
                        <td><input disabled type="checkbox" name="indDomingo" <?php echo $dtoDias->getIndDomingo() ? 'checked' : ''; ?>></td>
                        <td><input disabled value="<?php echo $dtoDias->getHoraDomingoManha(); ?>" type="text" class="form-control mask-timeInterval" name="horaDomingoManha"></td>
                        <td><input disabled value="<?php echo $dtoDias->getHoraDomingoTarde(); ?>" type="text" class="form-control mask-timeInterval" name="horaDomingoTarde"></td>
                    </tr>
                    <tr>
                        <td>Segunda<span class="hidden-xs">-feira</span></td>
                        <td><input disabled type="checkbox" name="indSegunda" <?php echo $dtoDias->getIndSegunda() ? 'checked' : ''; ?>></td>
                        <td><input disabled value="<?php echo $dtoDias->getHoraSegundaManha(); ?>" type="text" class="form-control mask-timeInterval" name="horaSegundaManha"></td>
                        <td><input disabled value="<?php echo $dtoDias->getHoraSegundaTarde(); ?>" type="text" class="form-control mask-timeInterval" name="horaSegundaTarde"></td>
                    </tr>
                    <tr>
                        <td>Terça<span class="hidden-xs">-feira</span></td>
                        <td><input disabled type="checkbox" name="indTerca" <?php echo $dtoDias->getIndTerca() ? 'checked' : ''; ?>></td>
                        <td><input disabled value="<?php echo $dtoDias->getHoraTercaManha(); ?>" type="text" class="form-control mask-timeInterval" name="horaTercaManha"></td>
                        <td><input disabled value="<?php echo $dtoDias->getHoraTercaTarde(); ?>" type="text" class="form-control mask-timeInterval" name="horaTercaTarde"></td>
                    </tr>
                    <tr>
                        <td>Quarta<span class="hidden-xs">-feira</span></td>
                        <td><input disabled type="checkbox" name="indQuarta" <?php echo $dtoDias->getIndQuarta() ? 'checked' : ''; ?>></td>
                        <td><input disabled value="<?php echo $dtoDias->getHoraQuartaManha(); ?>" type="text" class="form-control mask-timeInterval" name="horaQuartaManha"></td>
                        <td><input disabled value="<?php echo $dtoDias->getHoraQuartaTarde(); ?>" type="text" class="form-control mask-timeInterval" name="horaQuartaTarde"></td>
                    </tr>
                    <tr>
                        <td>Quinta<span class="hidden-xs">-feira</span></td>
                        <td><input disabled type="checkbox" name="indQuinta" <?php echo $dtoDias->getIndQuinta() ? 'checked' : ''; ?>></td>
                        <td><input disabled value="<?php echo $dtoDias->getHoraQuintaManha(); ?>" type="text" class="form-control mask-timeInterval" name="horaQuintaManha"></td>
                        <td><input disabled value="<?php echo $dtoDias->getHoraQuintaTarde(); ?>" type="text" class="form-control mask-timeInterval" name="horaQuintaTarde"></td>
                    </tr>
                    <tr>
                        <td>Sexta<span class="hidden-xs">-feira</span></td>
                        <td><input disabled type="checkbox" name="indSexta" <?php echo $dtoDias->getIndSexta() ? 'checked' : ''; ?>></td>
                        <td><input disabled value="<?php echo $dtoDias->getHoraSextaManha(); ?>" type="text" class="form-control mask-timeInterval" name="horaSextaManha"></td>
                        <td><input disabled value="<?php echo $dtoDias->getHoraSextaTarde(); ?>" type="text" class="form-control mask-timeInterval" name="horaSextaTarde"></td>
                    </tr>
                    <tr>
                        <td>Sábado</td>
                        <td><input disabled type="checkbox" name="indSabado" <?php echo $dtoDias->getIndSabado() ? 'checked' : ''; ?>></td>
                        <td><input disabled value="<?php echo $dtoDias->getHoraSabadoManha(); ?>" type="text" class="form-control mask-timeInterval" name="horaSabadoManha"></td>
                        <td><input disabled value="<?php echo $dtoDias->getHoraSabadoTarde(); ?>" type="text" class="form-control mask-timeInterval" name="horaSabadoTarde"></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12 form-group text-justify">
                <label for="cdnConsultorio" class="control-label">Consultório</label>
                <select disabled class="select2 form-control" name="cdnConsultorio">
                    <option>Nenhum</option>
                    <?php
                    foreach ($arrConsultorios as $arrConsultorio) {
                        $selected = $arrConsultorio['cdnConsultorio'] == $dtoDentista->getCdnConsultorio() ? 'selected' : '';
                        echo '<option ' . $selected . ' value="' . $arrConsultorio['cdnConsultorio'] . '">' . $arrConsultorio['numConsultorio'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-12 form-group">
                <?php
                $areas = '';
                foreach ($arrRelacoes as $arrRelacao) {
                    $modAreaAtuacao = new ModeloAreaAtuacao();
                    $dtoAreaAtuacao = $modAreaAtuacao->getAreaAtuacao($arrRelacao['cdnAreaAtuacao']);
                    $areas .= $dtoAreaAtuacao->getNomAreaAtuacao() . ', ';
                }
                $areas = trim($areas, ', ');
                ?>
                <label class="control-label" for="areasAtuacao">Áreas de atuação</label>
                <input type="text" disabled class="form-control" name="areasAtuacao" placeholder="Nenhuma" value="<?php echo $areas . '.'; ?>">
            </div>

            <div class="row">
                <div class="col-md-4 col-lg-offset-2 col-md-offset-2 col-lg-4">
                    <a href="<?php echo BASE_URL; ?>/dentista/atualizar/<?php echo $arrUsuario['cdnUsuario']; ?>">
                        <button type="button" class="btn btn-block btn-lg btn-success">
                            Editar
                        </button>
                    </a>
                </div>
                <div class="col-md-4 col-lg-4">
                    <a href="<?php echo BASE_URL; ?>/intervalo/consultar/<?php echo $arrUsuario['cdnUsuario']; ?>">
                        <button type="button" class="btn btn-block btn-lg btn-warning">
                            Intervalos
                        </button>
                    </a>
                </div>
            </div>
            <br>
            <?php
            if (Modelo::masterStatic($_SESSION['cdnUsuario']) || $_SESSION['cdnUsuario'] == $arrUsuario['cdnUsuario']) {
                ?>
                <div class="row">
                    <div class="col-md-4 col-lg-offset-2 col-md-offset-2 col-lg-4">
                        <a href="<?php echo BASE_URL; ?>/dentista/fecharAgenda/<?php echo $arrUsuario['cdnUsuario']; ?>">
                            <button type="button" class="btn btn-block btn-lg btn-success btn-outline">
                                Fechar agenda
                            </button>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <a href="<?php echo BASE_URL; ?>/dentista/abrirAgenda/<?php echo $arrUsuario['cdnUsuario']; ?>">
                            <button type="button" class="btn btn-block btn-lg btn-warning btn-outline">
                                Abrir agenda
                            </button>
                        </a>
                    </div>
                </div>

                <?php
            }
            ?>
            <br>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <a href="<?php echo BASE_URL; ?>/permissao/atualizar/<?php echo $arrUsuario['cdnUsuario']; ?>">
                        <button type="button" class="btn btn-primary btn-lg btn-block">
                            Permissões
                        </button>
                    </a>
                </div>
            </div>
            <?php
            $modMain = new ModeloMain(true);
            if ($_SESSION['cdnUsuario'] == $arrUsuario['cdnUsuario'] or
                    $modMain->dono() or $modDentista->master()) {
                ?>
                <div class="row text-justify">

                    <div class="col-md-12 col-xs-12">
                        <span class="text-muted">
                            <?php echo $this->link('dentista', 'deletar', 'Deletar conta', array($arrUsuario['cdnUsuario'])); ?>
                        </span>
                    </div>

                </div>
                <?php
            }
            ?>

        </div>
    </div>
</div>
