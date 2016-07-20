                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="nomPaciente" class="control-label">Nome</label>
                                <input disabled name="nomPaciente" value="<?php echo $arrPaciente['nomPaciente']; ?>" type="text" class="form-control">
                            </div>
                            <?php
                                if(isset($arrPaciente['codCpf'])){
                                    $value = $arrPaciente['codCpf'];
                                    $label = 'CPF';
                                }
                                if(isset($arrPaciente['codCnpj'])){
                                    $value = $arrPaciente['codCnpj'];
                                    $label = 'CNPJ';
                                }
                                if(isset($arrPaciente['codCpfCnpj'])){
                                    $value = $arrPaciente['codCpfCnpj'];
                                    $label = 'CPF/CNPJ';
                                }

                                if(isset($value)){
                            ?>
                            <div class="col-md-4 form-group">
                                <label for="<?php echo $label; ?>" class="control-label"><?php echo $label; ?></label>
                                <input disabled value="<?php $value; ?>" type="text" class="form-control" name="<?php echo $label; ?>">
                            </div>
                            <?php
                                }


                                if(isset($arrPaciente['datNascimento'])){
                            ?>
                            <div class="col-md-4 form-group">
                                <label for="datNascimento" class="control-label">Data de nascimento</label>
                                <input disabled name="datNascimento" value="<?php echo $arrPaciente['datNascimento']; ?>" type="date" class="form-control mask-date">
                            </div>
                            <?php
                                }

                                $modCampo = new ModeloCampo();
                                $sql = 'SELECT * FROM schema_campo WHERE nomCampo LIKE "%numTelefone%"';
                                $arrCampoTel = $modCampo->query($sql);
                                $strTelefone = '';
                                foreach($arrCampoTel as $arrCampo){
                                    $strTelefone .= $arrPaciente[$arrCampo['nomCampo']].' ';
                                }
                            ?>
                            <div class="col-md-4 form-group">
                                <label for="numTelefones" class="control-label">Telefone(s)</label>
                                <input disabled name="numTelefones" value="<?php echo $strTelefone; ?>" type="text" class="form-control mask-date">
                            </div>
                            <?php

                                foreach($arrCampos as $arrCampo){
                                    $cdnCampo = $arrCampo['cdnCampo'];
                                    $arrCampo = $modCampo->getCampo($cdnCampo);
                                    $classes = $modCampo->getClasses($arrCampo['indTipo']);

                                    if($arrCampo['nomCampo'] == 'codUf'){
                                        $arrPaciente['codUf'] = $this->transformacaoUf($arrPaciente['codUf']);
                                    }
                            ?>
                            <div class="col-md-4 form-group">
                                <label for="<?php echo $arrCampo['nomCampo']; ?>" class="control-label">
                                    <?php echo $arrCampo['desLabel']; ?>
                                </label>
                                <input disabled value="<?php echo $arrPaciente[$arrCampo['nomCampo']]; ?>" class="form-control <?php echo $classes; ?>" type="<?php echo $arrCampo['indTipo']; ?>">
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 form-group">
                                <label for="strTipo" class="control-label">Tipo do titular</label>
                                <input disabled type="text" class="form-control" value="<?php echo $strTipo; ?>" name="strTipo">
                            </div>
                            <div class="col-xs-6 form-group">
                                <label for="strParceria" class="control-label">Parceria do titular</label>
                                <input disabled type="text" class="form-control" value="<?php echo $strParceria; ?>" name="strParceria">
                            </div>
                        </div>
                        <?php
                            if(isset($responsavel)){
                                $ctrlPaciente = new ControlePaciente();
                                $ctrlPaciente->pacienteFormularioRespLegal($cdnPaciente, true);
                            }
                        ?>
                        <?php
                            if(isset($arrRespostas)){
                        ?>
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-striped table-bordered table-hover datatable" >
                                    <thead>
                                        <tr>
                                            <th>Pergunta</th>
                                            <th>Resposta</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $arrComOpcoes = array();
                                            foreach($arrRespostas as $arrResposta){
                                                $dtoPergunta = $modPergunta->getPergunta($arrResposta['cdnPergunta']);
                                                if($modPergunta->checaExiste('pergunta_opcao', 'cdnPergunta', $arrResposta['cdnPergunta'])){
                                                    if(!isset($arrComOpcoes[$arrResposta['cdnPergunta']]))
                                                        $arrComOpcoes[$arrResposta['cdnPergunta']] = array();
                                                    array_push($arrComOpcoes[$arrResposta['cdnPergunta']], $arrResposta['cdnOpcao']);
                                                }
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php echo $dtoPergunta->getStrPergunta(); ?>
                                                </td>
                                                <td>
                                                    <?php echo $arrResposta['strResposta']; ?>
                                                </td>
                                            </tr>
                                        <?php
                                            }


                                            foreach($arrComOpcoes as $cdnPergunta=>$arrOpcoes){
                                                $dtoPergunta = $modPergunta->getPergunta($cdnPergunta);
                                                $strResposta = '';
                                                foreach($arrOpcoes as $cdnOpcao){
                                                    $dtoOpcao = $modPergunta->getOpcao($cdnOpcao);
                                                    $strResposta .= $dtoOpcao->getStrOpcao().', ';
                                                }
                                                $strResposta = trim($strResposta, ', ');
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php echo $dtoPergunta->getStrPergunta(); ?>
                                                </td>
                                                <td>
                                                    <?php echo $strResposta; ?>
                                                </td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Pergunta</th>
                                            <th>Resposta</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                        <div class="row">
                            <div class="col-md-4 col-lg-offset-2 col-md-offset-2 col-lg-4">
                                <a href="<?php echo BASE_URL; ?>/anamnese/responder/<?php echo $cdnPaciente; ?>">
                                    <button type="button" class="btn btn-block btn-lg btn-success">
                                        Responder questionário
                                    </button>
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <a target="_blank" href="<?php echo BASE_URL; ?>/anamnese/imprimir/<?php echo $cdnPaciente ?>">
                                    <button type="button" class="btn btn-block btn-lg btn-primary">
                                        Imprimir/visualizar anamnese
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
