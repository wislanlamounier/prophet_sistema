                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <div class="row">
                                    <a class="pull-right" href="<?php echo BASE_URL; ?>/consulta/cadastrar">
                                        <button class="btn btn-success">
                                            Marcar nova consulta
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div clas="ibox-content">
                                <?php
                                    if(isset($falta)){
                                ?>
                                <div class="col-md-12 alert alert-warning text-center">
                                    <b>ATENÇÃO:</b> O paciente faltou à esta consulta. <br>
                                    <?php echo $this->link('falta', 'desmarcar', 'Desmarcar falta', array($dtoConsulta->getCdnConsulta())); ?>
                                </div>
                                <?php
                                    }

                                    if(isset($desmarque)){
                                ?>
                                <div class="col-md-12 alert alert-warning text-center">
                                    <b>ATENÇÃO:</b> Esta consulta foi desmarcada. <br>
                                    <?php echo $this->link('desmarque', 'cancelar', 'Cancelar desmarque', array($dtoConsulta->getCdnConsulta())); ?>
                                </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if(isset($arrRetorno)){
                                ?>
                                <div class="col-md-12 alert alert-info text-center">
                                    <b>Esta consulta é um retorno:</b> <br>
                                    <?php echo $this->link('consulta', 'consultarFim',
                                                           'Visitar consulta original', array($arrRetorno['cdnConsultaOriginal'])); ?>
                                </div>
                                <?php
                                    }
                                    if(isset($arrRetornos)){
                                ?>
                                <div class="col-md-12 alert alert-info text-center">
                                    <b>Esta consulta possui retorno marcado:</b>
                                    <ul style="list-style-type: none;">
                                        <?php
                                            foreach($arrRetornos as $arrRetorno){
                                                $dtoRetorno = $modConsulta->getConsulta($arrRetorno['cdnConsultaRetorno']);
                                        ?>
                                        <li><?php echo $this->link('consulta', 'consultarFim', $dtoRetorno->getDatConsulta(true), array($dtoRetorno->getCdnConsulta())); ?></li>
                                        <?php
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                                    }
                                ?>
                                <form action="<?php echo BASE_URL; ?>/consulta/cadastrarFim" method="post">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="nomPaciente" class="control-label">Paciente</label>
                                            <input disabled type="text" name="nomPaciente" class="form-control" value="<?php echo $nomPaciente; ?>">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="cdnDentista" class="control-label">Dentista</label>
                                            <input disabled type="text" name="cdnDentista" class="form-control" value="<?php echo $nomDentista; ?>">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="cdnConsultorio" class="control-label">Consultório</label>
                                            <input disabled type="text" name="cdnConsultorio" class="form-control" value="<?php echo $numConsultorio; ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="cdnAreaAtuacao" class="control-label">Área de Atuação</label>
                                            <input disabled type="text" name="cdnAreaAtuacao" class="form-control" value="<?php echo $nomAreaAtuacao; ?>">
                                        </div>
                                       <!--  <div class="col-md-4 form-group">
                                            <label for="cdnProcedimento" class="control-label">Procedimento</label>
                                            <input disabled type="text" name="cdnProcedimento" class="form-control" value="<?php //echo $nomProcedimento; ?>">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="cdnSecao" class="control-label">Seção</label>
                                            <input disabled type="text" name="cdnSecao" class="form-control" value="<?php //echo $nomSecao; ?>">
                                        </div> -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="datConsulta" class="control-label">Data</label>
                                            <input disabled type="date" name="datConsulta" class="form-control mask-date" value="<?php echo $dtoConsulta->getDatConsulta(); ?>">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="horaConsulta" class="control-label">Horário</label>
                                            <?php
                                                $horaConsulta = $dtoConsulta->getHoraConsulta();
                                                if($dtoConsulta->getHoraFinalizada() != '')
                                                    $horaConsulta .= ' - '.$dtoConsulta->getHoraFinalizada();
                                            ?>
                                            <input disabled type="text" name="horaConsulta" class="form-control" value="<?php echo $horaConsulta; ?>">
                                        </div>
                                        <div class="col-xs-10 col-md-4 form-group">
                                            <label for="numHorarios" class="control-label">Quantidade de horários ocupados</label>
                                            <input disabled type="number" name="numHorarios" class="form-control" value="<?php echo $dtoConsulta->getNumHorarios(); ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6 form-group">
                                            <label for="indEncaixe" class="control-label">Esta consulta é um encaixe?</label>
                                            <br>
                                            <input disabled type="checkbox" id="indEncaixe" name="indEncaixe" <?php echo $dtoConsulta->getIndEncaixe() ? 'checked' : ''; ?>>
                                        </div>
                                        <div class="col-xs-6 form-group">
                                            <label for="indBloquear" class="control-label">
                                                Não permitir que encaixes sejam marcados neste horário.
                                            </label>
                                            <br>
                                            <input disabled type="checkbox" id="indBloquear" name="indBloquear" <?php echo $dtoConsulta->getIndBloquear() ? 'checked' : ''; ?>>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php
                                            if(isset($dtoAviso)){
                                        ?>
                                                <div class="col-sm-6 form-group">
                                                    <label for="indEnviarSms" class="control-label">Enviar SMS de aviso</label>
                                                    <br />
                                                    <input type="checkbox" checked disabled id="indEnviarSms" name="indEnviarSms" />
                                                </div>
                                                <div class="col-sm-4 form-group">
                                                    <label for="numSegAntecedencia" class="control-label">Horário de envio</label>
                                                    <input class="form-control" disabled type="text" name="numSegAntecedencia" value="<?php echo $dtoAviso->getDatAviso(true); ?>">
                                                </div>
                                                <div class="col-sm-2">
                                                    <br>
                                                    <a href="<?php echo BASE_URL; ?>/consulta/mudarAviso/<?php echo $dtoConsulta->getCdnConsulta(); ?>">
                                                        <button class="btn btn-block btn-success">
                                                            Mudar
                                                        </button>
                                                    </a>
                                                </div>
                                        <?php
                                            }else {
                                        ?>
                                                <div class="col-sm-12">
                                                    <label class="control-label">O paciente não será avisado por SMS.</label>
                                                    <a href="<?php echo BASE_URL; ?>/consulta/cadastrarAviso/<?php echo $dtoConsulta->getCdnConsulta(); ?>">
                                                        <button class="btn btn-block btn-lg btn-success">
                                                            Cadastrar aviso por SMS
                                                        </button>
                                                    </a>
                                                </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="desConsulta" class="control-label">Observações</label>
                                            <textarea disabled name="desConsulta" class="form-control"><?php echo $dtoConsulta->getDesConsulta(); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-lg-offset-2 col-md-offset-2 col-lg-4">
                                        <?php
                                            if(!isset($falta)){
                                        ?>
                                            <a href="<?php echo BASE_URL; ?>/falta/cadastrar/<?php echo $dtoConsulta->getCdnPaciente().'/'.$dtoConsulta->getCdnConsulta(); ?>">
                                                <button type="button" class="btn btn-block btn-lg btn-primary">
                                                    Marcar falta
                                                </button>
                                            </a>
                                        <?php
                                            }
                                        ?>
                                        </div>
                                        <?php
                                            if(!isset($desmarque)){
                                        ?>
                                        <div class="col-md-4 col-lg-4">
                                            <a href="<?php echo BASE_URL; ?>/desmarque/cadastrar/<?php echo $dtoConsulta->getCdnPaciente().'/'.$dtoConsulta->getCdnConsulta(); ?>">
                                                <button type="button" class="btn btn-block btn-lg btn-success">
                                                    Desmarcar consulta
                                                </button>
                                            </a>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4 col-lg-offset-2 col-md-offset-2 col-lg-4">
                                            <a href="<?php echo BASE_URL; ?>/consulta/atestado/<?php echo $dtoConsulta->getCdnConsulta(); ?>">
                                                <button type="button" class="btn btn-outline btn-block btn-lg btn-info">
                                                    Atestado/comunicação
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-lg-4">
                                            <a href="<?php echo BASE_URL; ?>/consulta/remarcar/<?php echo $dtoConsulta->getCdnConsulta(); ?>">
                                                <button type="button" class="btn btn-outline btn-block btn-lg btn-info">
                                                    Remarcar
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-8 col-lg-offset-2 col-md-offset-2 col-lg-8">
                                            <a href="<?php echo BASE_URL; ?>/consulta/cadastrar/<?php echo $dtoConsulta->getCdnConsulta(); ?>">
                                                <button type="button" class="btn btn-outline btn-block btn-lg btn-warning">
                                                    Marcar retorno
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
