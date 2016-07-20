                    <div class="col-md-12">
                            <span class="hidden id" id="<?php echo $dtoConsulta->getCdnConsulta(); ?>"></span>
                            <form action="<?php echo BASE_URL; ?>/consulta/remarcarFim/<?php echo $dtoConsulta->getCdnConsulta(); ?>" method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php require('visualizador/paciente/modalSelect.php'); ?>
                                        </div>
                                        <div style="display: none;" id="divCadastro" class="alert alert-warning">

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
                                        <select name="cdnDentista" class="form-control select2" id="iptCdnDentista">
                                           <?php
                                                foreach($arrDentistas as $arrDentista){
                                                    if($arrDentista['cdnUsuario'] == $dtoConsulta->getCdnDentista())
                                                        $selected = 'selected';
                                                    else
                                                        $selected = '';
                                            ?>
                                            <option <?php echo $selected; ?> value="<?php echo $arrDentista['cdnUsuario']; ?>"><?php echo $arrDentista['nomUsuario']; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="cdnConsultorio" class="control-label">Consultório</label>
                                        <select name="cdnConsultorio" class="form-control select2" id="iptCdnConsultorio">
                                            <?php
                                                foreach($arrConsultorios as $arrConsultorio){
                                                    if($arrConsultorio['cdnConsultorio'] == $dtoConsulta->getCdnConsultorio())
                                                        $selected = 'selected';
                                                    else
                                                        $selected = '';
                                                    echo '<option '.$selected.' value="'.$arrConsultorio['cdnConsultorio'].'">'.$arrConsultorio['numConsultorio'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="divAgenda">
                                    <div class="col-md-12" id="calendario" style=" max-height: 600px;">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" id="divAreaAtuacao">
                                        <?php echo $selectAreaAtuacao; ?>
                                    </div>
                                    <!-- <div class="col-md-4 classCdnProcedimento" id="divCdnProcedimento">
                                        <?php // echo $selectProcedimento; ?>
                                    </div>
                                    <div class="col-md-4" id="divCdnSecao">
                                        <?php
                                            //if(isset($selectSecao))
                                                //echo $selectSecao;
                                        ?>
                                    </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="datConsulta" class="control-label">Data</label>
                                        <input required type="text" id="datConsulta" name="datConsulta" class="form-control mask-date" value="<?php echo $dtoConsulta->getDatConsulta(true); ?>">
                                        <div style="display: none;" id="divFechado" class="alert alert-warning">

                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="horaConsulta" class="control-label">Horário</label>
                                        <div id="horario">
                                            <input required type="text" id="horaConsulta" name="horaConsulta" class="form-control mask-time" value="<?php echo $dtoConsulta->getHoraConsulta(); ?>">
                                        </div>
                                        <div id="divHorarios" style="display: none;" class="alert alert-warning">

                                        </div>
                                    </div>
                                    <div class="col-xs-10 col-md-4 form-group">
                                        <label for="numHorarios" class="control-label">Quantidade de horários ocupados</label>
                                        <input type="number" id="numHorarios" name="numHorarios" class="form-control" value="<?php echo $dtoConsulta->getNumHorarios(); ?>">
                                        <div id="divEsperado" style="display: none;" class="alert alert-warning">

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 form-group">
                                        <label for="indEncaixe" class="control-label">Esta consulta é um encaixe?</label>
                                        <br>
                                        <input type="checkbox" id="indEncaixe" name="indEncaixe" <?php echo $dtoConsulta->getIndEncaixe() ? 'checked' : ''; ?>>
                                    </div>
                                    <div class="col-xs-6 form-group">
                                        <label for="indBloquear" class="control-label">
                                            Não permitir que encaixes sejam marcados neste horário.
                                        </label>
                                        <br>
                                        <input type="checkbox" id="indBloquear" name="indBloquear" <?php echo $dtoConsulta->getIndBloquear() ? 'checked' : ''; ?>>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-12 form-group">
                                        <label for="desConsulta" class="control-label">Observações</label>
                                        <textarea name="desConsulta" class="form-control"><?php echo $dtoConsulta->getDesConsulta(); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-success">
                                        Remarcar
                                    </button>
                                </div>
                            </form>
                    </div>
