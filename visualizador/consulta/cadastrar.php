                    <div class="col-md-12">
                        <form action="<?php echo BASE_URL; ?>/consulta/cadastrarFim/<?php echo $cdnConsulta; ?>" method="post">
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?php require('visualizador/paciente/modalSelect.php'); ?>
                                    </div>
                                    <div style="display: none;" id="divCadastro" class="alert alert-warning">

                                    </div>

                                    <div style="display: none;" id="divTelefoneErr" class="alert alert-danger">
                                        
                                    </div>
                                    
                                    <div style="display: none;" id="divProcedimento" class="alert alert-warning">

                                    </div>

                                    <div style="display: none;" id="divSecao" class="alert alert-warning">

                                    </div>

                                    <div style="display: none;" id="divProntuario" class="alert alert-warning">

                                    </div>

                                    <div style="display: none;" id="divDesmarque" class="alert alert-warning">

                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="cdnDentista" class="control-label">Dentista</label>
                                    <select required name="cdnDentista" class="form-control select2" id="iptCdnDentista">
                                        <option selected value=""></option>
                                        <?php
                                            foreach($arrDentistas as $arrDentista){
                                        ?>
                                        <option value="<?php echo $arrDentista['cdnUsuario']; ?>"><?php echo $arrDentista['nomUsuario']; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="cdnConsultorio" class="control-label">Consultório</label>
                                    <select required name="cdnConsultorio" class="form-control select2" id="iptCdnConsultorio">
                                        <?php
                                            foreach($arrConsultorios as $arrConsultorio){
                                                echo '<option value="'.$arrConsultorio['cdnConsultorio'].'">'.$arrConsultorio['numConsultorio'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="divAgenda" style="display: none;">
                                <div class="col-md-12" id="calendario" style=" max-height: 600px;">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group" id="divAreaAtuacao">
                                    <label for="cdnAreaAtuacao" class="control-label">Área de Atuação</label>
                                    <select required name="cdnAreaAtuacao" class="form-control select2" id="cdnAreaAtuacao">
                                    </select>
                                </div><!--
                                <div class="col-md-4 classCdnProcedimento" id="divCdnProcedimento">
                                    <div class="form-group">
                                        <label class="control-label">Procedimento</label>
                                        <select class="form-control select2">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="divCdnSecao">
                                    <div class="form-group">
                                        <label class="control-label">Seção de procedimento</label>
                                        <select class="form-control select2">
                                        </select>
                                    </div>
                                </div> -->
                            </div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="datConsulta" class="control-label">Data</label>
                                    <input required type="text" id="datConsulta" name="datConsulta" class="form-control mask-date">
                                    <div style="display: none;" id="divFechado" class="alert alert-warning">

                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="horaConsulta" class="control-label">Horário</label>
                                    <div id="horario">
                                        <input required type="text" id="horaConsulta" name="horaConsulta" class="form-control mask-time">
                                    </div>
                                    <div id="divHorarios" style="display: none;" class="alert alert-warning">

                                    </div>
                                </div>
                                <div class="col-xs-10 col-md-4 form-group">
                                    <label for="numHorarios" class="control-label">Quantidade de horários ocupados</label>
                                    <input required type="number" id="numHorarios" name="numHorarios" class="form-control">
                                    <div id="divEsperado" style="display: none;" class="alert alert-warning">

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 form-group">
                                    <label for="indEncaixe" class="control-label">Esta consulta é um encaixe?</label>
                                    <br>
                                    <input type="checkbox" id="indEncaixe" name="indEncaixe">
                                </div>
                                <div class="col-xs-6 form-group">
                                    <label for="indBloquear" class="control-label">
                                        Não permitir que encaixes sejam marcados neste horário.
                                    </label>
                                    <br>
                                    <input type="checkbox" id="indBloquear" name="indBloquear">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="indEnviarSms" class="control-label">Enviar SMS de aviso</label>
                                    <br />
                                    <input type="checkbox" id="indEnviarSms" name="indEnviarSms" />
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="numSegAntecedencia" class="control-label">Antecedência</label>
                                    <select disabled name="numSegAntecedencia" class="form-control" id="numSegAntecedencia">
                                        <option value="1hora">1 hora</option>
                                        <option value="2horas">2 horas</option>
                                        <option value="3horas">3 horas</option>
                                        <option value="1dia">1 dia</option>
                                        <option value="2dias">2 dias</option>
                                        <option value="1semana">1 semana</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="display: none" id="divTelefone">
                                <div class="col-sm-12 form-group">
                                    <label for="numTelefone" class="control-label">Telefone para enviar SMS</label>
                                    <small class="text-muted">Formato: (xx) xxxx-xxxxx</small>
                                    <input type="text" name="numTelefone" class="form-control mask-phone" id="numTelefone"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="desConsulta" class="control-label">Observações</label>
                                    <textarea name="desConsulta" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                <button type="submit" class="btn btn-block btn-lg btn-primary">
                                    Cadastrar
                                </button>
                            </div>
                        </form>
                    </div>
