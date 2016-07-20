                    <div class="col-md-12">
                        <div class="row">
                            <form action="<?php echo BASE_URL; ?>/anamnese/responderFim/<?php echo $cdnPaciente; ?>" method="post">
                                <?php
                                    $arrComOpcoes = array();
                                    foreach($arrPerguntas as $arrPergunta){
                                        if($modPergunta->checaExiste('pergunta_opcao', 'cdnPergunta', $arrPergunta['cdnPergunta'])){
                                            $arrComOpcoes[] = $arrPergunta;
                                            continue;
                                        }
                                        $arrCond = array('cdnPaciente' => $cdnPaciente,
                                                         'conscond1'   => 'AND',
                                                         'cdnPergunta' => $arrPergunta['cdnPergunta']);
                                        $arrResposta = $modPergunta->consultar('resposta', '*', $arrCond);
                                        if(count($arrResposta) > 0)
                                            $value = $arrResposta[0]['strResposta'];
                                        else
                                            $value = '';
                                ?>
                                <div class="col-md-4 form-group">
                                    <label class="control-label" for="<?php echo $arrPergunta['cdnPergunta']; ?>">
                                        <?php echo $arrPergunta['strPergunta']; ?>
                                    </label>
                                    <input value="<?php echo $value; ?>" type="text" name="<?php echo $arrPergunta['cdnPergunta']; ?>" class="form-control">
                                </div>
                                <?php
                                    }

                                    foreach($arrComOpcoes as $arrPergunta){
                                        $arrCond = array('cdnPergunta' => $arrPergunta['cdnPergunta']);
                                        $arrOpcoes = $modPergunta->consultar('pergunta_opcao', '*', $arrCond);
                                ?>
                                <div class="col-md-4 form-group">
                                    <label class="control-label" for="<?php echo $arrPergunta['cdnPergunta']; ?>">
                                        <?php echo $arrPergunta['strPergunta']; ?>
                                    </label>
                                <?php
                                        foreach($arrOpcoes as $arrOpcao){
                                            $arrCond = array('cdnPaciente' => $cdnPaciente,
                                                             'conscond1'   => 'AND',
                                                             'cdnPergunta' => $arrOpcao['cdnPergunta'],
                                                             'conscond2'   => 'AND',
                                                             'cdnOpcao'    => $arrOpcao['cdnOpcao']);
                                            $arrResposta = $modPergunta->consultar('resposta', '*', $arrCond);
                                            if(count($arrResposta) > 0)
                                                $checked = 'checked';
                                            else
                                                $checked = '';
                                ?>
                                    <input <?php echo $checked; ?> name="op<?php echo $arrOpcao['cdnOpcao']; ?>" type="checkbox" value="<?php echo $arrOpcao['cdnOpcao']; ?>">
                                    <?php echo $arrOpcao['strOpcao']; ?>
                                <?php
                                        }
                                ?>
                                </div>
                                <?php
                                    }
                                ?>
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                        <button type="submit" class="btn btn-block btn-lg btn-primary">
                                            Responder
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
