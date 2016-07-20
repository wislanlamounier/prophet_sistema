                    <div class="col-md-12">
                        <div class="row">
                            <form action="<?php echo BASE_URL; ?>/intervalo/atualizarFim/<?php echo $dtoIntervalo->getCdnIntervalo(); ?>" method="post">
                                <div class="col-sm-6 form-group">
                                    <label class="control-label" for="horaInicio">Horário de início</label>
                                    <input type="text" class="form-control mask-time" name="horaInicio" value="<?php echo $dtoIntervalo->getHoraInicio(); ?>">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label class="control-label" for="horaFinal">Horário de final</label>
                                    <input type="text" class="form-control mask-time" name="horaFinal" value="<?php echo $dtoIntervalo->getHoraFinal(); ?>">
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label class="control-label" for="indPermanente">
                                        Intervalo será permanente? (ocorre todos os dias)
                                    </label>
                                    <input type="checkbox" name="indPermanente" id="indPermanente" <?php echo $dtoIntervalo->getIndPermanente() ? 'checked' : ''; ?>>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label class="control-label">
                                        Ocorre nos seguintes dias da semana
                                    </label>
                                    <br>
                                    <input type="checkbox" name="indDomingo" class="diasSemana" <?php echo $dtoIntervalo->getIndDomingo() ? 'checked' : ''; ?>> Domingo &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="indSegunda" class="diasSemana" <?php echo $dtoIntervalo->getIndSegunda() ? 'checked' : ''; ?>> Segunda &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="indTerca" class="diasSemana" <?php echo $dtoIntervalo->getIndTerca() ? 'checked' : ''; ?>> Terça &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="indQuarta" class="diasSemana" <?php echo $dtoIntervalo->getIndQuarta() ? 'checked' : ''; ?>> Quarta &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="indQuinta" class="diasSemana" <?php echo $dtoIntervalo->getIndQuinta() ? 'checked' : ''; ?>> Quinta &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="indSexta" class="diasSemana" <?php echo $dtoIntervalo->getIndSexta() ? 'checked' : ''; ?>> Sexta &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="indSabado" class="diasSemana" <?php echo $dtoIntervalo->getIndSabado() ? 'checked' : ''; ?>> Sábado &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-sm-12 form-group" id="data">
                                    <label class="control-label" for="datIntervalo">Ocorre em um dia específico, apenas</label>
                                    <input type="date" class="form-control mask-date" name="datIntervalo" id="datIntervalo" value="<?php echo $dtoIntervalo->getDatIntervalo(); ?>">
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
