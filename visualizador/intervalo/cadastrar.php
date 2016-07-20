                    <div class="col-md-12">
                        <div class="row">
                            <form action="<?php echo BASE_URL; ?>/intervalo/cadastrarFim/<?php echo $cdnDentista; ?>" method="post">
                                <div class="col-sm-6 form-group">
                                    <label class="control-label" for="horaInicio">Horário de início</label>
                                    <input type="text" class="form-control mask-time" name="horaInicio">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label class="control-label" for="horaFinal">Horário de final</label>
                                    <input type="text" class="form-control mask-time" name="horaFinal">
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label class="control-label" for="indPermanente">
                                        Intervalo será permanente? (ocorre todos os dias)
                                    </label>
                                    <input type="checkbox" name="indPermanente" id="indPermanente">
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label class="control-label">
                                        Ocorre nos seguintes dias da semana
                                    </label>
                                    <br>
                                    <input type="checkbox" name="indDomingo" class="diasSemana"> Domingo &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="indSegunda" class="diasSemana"> Segunda &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="indTerca" class="diasSemana"> Terça &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="indQuarta" class="diasSemana"> Quarta &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="indQuinta" class="diasSemana"> Quinta &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="indSexta" class="diasSemana"> Sexta &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="indSabado" class="diasSemana"> Sábado &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-sm-12 form-group" id="data">
                                    <label class="control-label" for="datIntervalo">Ocorre em um dia específico, apenas</label>
                                    <input type="text" class="form-control mask-date" name="datIntervalo" id="datIntervalo">
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
