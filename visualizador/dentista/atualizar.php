<div class="col-md-12">
    <div class="row">
        <form action="<?php echo BASE_URL; ?>/dentista/atualizarFim/<?php echo $dtoDentista->getCdnUsuario(); ?>" method="post">
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
                <input  class="form-control mask-cpf" name="codCpf" type="text" value="<?php echo $dtoDentista->getCodCpf(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="codCro">CRO</label>
                <input class="form-control" name="codCro" type="text" value="<?php echo $dtoDentista->getCodCro(); ?>">
            </div>
            <div class="col-md-6 col-lg-6 form-group">
                <label class="control-label" for="strEndereco">Endereço</label>
                <input  class="form-control" name="strEndereco" type="text"  value="<?php echo $dtoDentista->getStrEndereco(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="nomCidade">Cidade</label>
                <input  class="form-control" name="nomCidade" type="text"  value="<?php echo $dtoDentista->getNomCidade(); ?>">
            </div>
            <div class="col-md-3 col-lg-3 form-group">
                <label class="control-label" for="codUf">Estado</label>
                <select  class="form-control" name="codUf">
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
                <input  class="form-control mask-cep" name="codCep" type="text" value="<?php echo $dtoDentista->getCodCep(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="numTempoConsulta">Tempo de consulta (hora:minuto)</label>
                <input  class="form-control mask-time" name="numTempoConsulta" type="text"  value="<?php echo $dtoDentista->getNumTempoConsulta(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="numTelefone1">Telefone 1</label>
                <input  class="form-control" name="numTelefone1" type="text"  value="<?php echo $dtoDentista->getNumTelefone1(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="numTelefone2">Telefone 2</label>
                <input  class="form-control" name="numTelefone2" type="text"  value="<?php echo $dtoDentista->getNumTelefone2(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="datNascimento">Data de nascimento</label>
                <input  class="form-control mask-date" name="datNascimento" type="date"  value="<?php echo $dtoDentista->getDatNascimento(); ?>">
            </div>
            <div class="col-md-6 col-lg-3 form-group">
                <label class="control-label" for="datAdmissao">Data de admissão</label>
                <input  class="form-control mask-date" name="datAdmissao" type="date"  value="<?php echo $dtoDentista->getDatAdmissao(); ?>">
            </div>
            <div class="col-md-6 form-group">
                <label class="control-label" for="strOutrosTrabalhos">Outros trabalhos</label>
                <textarea  class="form-control" name="strOutrosTrabalhos" ><?php echo $dtoDentista->getStrOutrosTrabalhos(); ?></textarea>
            </div>
            <div class="col-md-6 form-group">
                <label class="control-label" for="strContaBancaria">Conta bancária</label>
                <textarea class="form-control" name="strContaBancaria"><?php echo $dtoDentista->getStrContaBancaria(); ?></textarea>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label" for="desDentista">Observações</label>
                <textarea  class="form-control" name="desDentista" ><?php echo $dtoDentista->getDesDentista(); ?></textarea>
            </div>
            <div class="col-md-12">
                <h4>Dias de trabalho</h4>
                <p>Dias nos quais este dentista trabalha.</p>
            </div>
            <div class="col-md-12 table-responsive">
                <table class="table table-hover table-striped">
                    <tr>
                        <th>Dia</th>
                        <th>Trabalha?</th>
                        <th>Horários (manhã)</th>
                        <th>Horários (tarde)</th>
                    </tr>
                    <tr>
                        <td>Domingo</td>
                        <td><input type="checkbox" name="indDomingo" <?php echo $dtoDias->getIndDomingo() ? 'checked' : ''; ?>></td>
                        <td><input value="<?php echo $dtoDias->getHoraDomingoManha(); ?>" type="text" class="form-control mask-timeInterval" name="horaDomingoManha"></td>
                        <td><input value="<?php echo $dtoDias->getHoraDomingoTarde(); ?>" type="text" class="form-control mask-timeInterval" name="horaDomingoTarde"></td>
                    </tr>
                    <tr>
                        <td>Segunda<span class="hidden-xs">-feira</span></td>
                        <td><input type="checkbox" name="indSegunda" <?php echo $dtoDias->getIndSegunda() ? 'checked' : ''; ?>></td>
                        <td><input value="<?php echo $dtoDias->getHoraSegundaManha(); ?>" type="text" class="form-control mask-timeInterval" name="horaSegundaManha"></td>
                        <td><input value="<?php echo $dtoDias->getHoraSegundaTarde(); ?>" type="text" class="form-control mask-timeInterval" name="horaSegundaTarde"></td>
                    </tr>
                    <tr>
                        <td>Terça<span class="hidden-xs">-feira</span></td>
                        <td><input type="checkbox" name="indTerca" <?php echo $dtoDias->getIndTerca() ? 'checked' : ''; ?>></td>
                        <td><input value="<?php echo $dtoDias->getHoraTercaManha(); ?>" type="text" class="form-control mask-timeInterval" name="horaTercaManha"></td>
                        <td><input value="<?php echo $dtoDias->getHoraTercaTarde(); ?>" type="text" class="form-control mask-timeInterval" name="horaTercaTarde"></td>
                    </tr>
                    <tr>
                        <td>Quarta<span class="hidden-xs">-feira</span></td>
                        <td><input type="checkbox" name="indQuarta" <?php echo $dtoDias->getIndQuarta() ? 'checked' : ''; ?>></td>
                        <td><input value="<?php echo $dtoDias->getHoraQuartaManha(); ?>" type="text" class="form-control mask-timeInterval" name="horaQuartaManha"></td>
                        <td><input value="<?php echo $dtoDias->getHoraQuartaTarde(); ?>" type="text" class="form-control mask-timeInterval" name="horaQuartaTarde"></td>
                    </tr>
                    <tr>
                        <td>Quinta<span class="hidden-xs">-feira</span></td>
                        <td><input type="checkbox" name="indQuinta" <?php echo $dtoDias->getIndQuinta() ? 'checked' : ''; ?>></td>
                        <td><input value="<?php echo $dtoDias->getHoraQuintaManha(); ?>" type="text" class="form-control mask-timeInterval" name="horaQuintaManha"></td>
                        <td><input value="<?php echo $dtoDias->getHoraQuintaTarde(); ?>" type="text" class="form-control mask-timeInterval" name="horaQuintaTarde"></td>
                    </tr>
                    <tr>
                        <td>Sexta<span class="hidden-xs">-feira</span></td>
                        <td><input type="checkbox" name="indSexta" <?php echo $dtoDias->getIndSexta() ? 'checked' : ''; ?>></td>
                        <td><input value="<?php echo $dtoDias->getHoraSextaManha(); ?>" type="text" class="form-control mask-timeInterval" name="horaSextaManha"></td>
                        <td><input value="<?php echo $dtoDias->getHoraSextaTarde(); ?>" type="text" class="form-control mask-timeInterval" name="horaSextaTarde"></td>
                    </tr>
                    <tr>
                        <td>Sábado</td>
                        <td><input type="checkbox" name="indSabado" <?php echo $dtoDias->getIndSabado() ? 'checked' : ''; ?>></td>
                        <td><input value="<?php echo $dtoDias->getHoraSabadoManha(); ?>" type="text" class="form-control mask-timeInterval" name="horaSabadoManha"></td>
                        <td><input value="<?php echo $dtoDias->getHoraSabadoTarde(); ?>" type="text" class="form-control mask-timeInterval" name="horaSabadoTarde"></td>
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
                            $selected = $arrConsultorio['cdnConsultorio'] == $dtoDentista->getCdnConsultorio() ? 'selected' : '';
                            echo '<option '.$selected.' value="'.$arrConsultorio['cdnConsultorio'].'">'.$arrConsultorio['numConsultorio'].'</option>';
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
                <?php
                    $arrCond = array('cdnDentista' => $dtoDentista->getCdnUsuario());
                    $modAreaAtuacao = new ModeloAreaAtuacao();
                    $arrConsulta = $modAreaAtuacao->consultar('dentista_areaatuacao', '*', $arrCond);
                    foreach($arrConsulta as $arrDentistaAtuacao){
                        $quantidade = isset($quantidade) ? $quantidade + 1 : 1;
                        $dtoAreaAtuacao = $modAreaAtuacao->getAreaAtuacao($arrDentistaAtuacao['cdnAreaAtuacao']);
                        $arrAreaAtuacoes = $modAreaAtuacao->consultar('areaatuacao', '*', array('indDesvinculada' => 0), 'nomAreaAtuacao');
                ?>
                <div class="area" id="area<?php echo $quantidade; ?>">

                    <div class="col-md-11 form-group">
                        <label id="lblCdnAreaAtuacao<?php echo $quantidade; ?>" for="cdnAreaAtuacao<?php echo $quantidade; ?>" class="control-label">Área de atuação <?php echo $quantidade; ?></label>
                        <select id="iptCdnAreaAtuacao<?php echo $quantidade; ?>" name="cdnAreaAtuacao<?php echo $quantidade; ?>" class="form-control">
                            <?php
                                foreach($arrAreaAtuacoes as $arrAreaAtuacao){
                                    if($dtoAreaAtuacao->getCdnAreaAtuacao() == $arrAreaAtuacao['cdnAreaAtuacao'])
                                        $selected = 'selected';
                                    else
                                        $selected = '';
                                    echo '<option '.$selected.' value="'.$arrAreaAtuacao['cdnAreaAtuacao'].'">'.$arrAreaAtuacao['nomAreaAtuacao'].'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-1 form-group"><br>
                        <button type="button" class="btn btn-default btn-lg btnRemover" id="<?php echo $quantidade; ?>">
                            <span class="fa fa-remove"></span>
                        </button>
                    </div>

                </div>
                <?php
                    }
                ?>
            </div>
            <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <button type="submit" class="btn btn-block btn-lg btn-primary">
                    Editar
                </button>
            </div>
        </form>
    </div>

</div>
