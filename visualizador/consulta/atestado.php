                    <div class="col-md-12">
                            <form target="_blank" action="<?php echo BASE_URL; ?>/consulta/atestadoFim" method="post">
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label for="fins" class="control-label">Atesto para fins de</label>
                                        <input type="text" class="form-control" name="fins">
                                    </div>
                                    <div class="col-md-3">
                                        <?php echo $selectPaciente; ?>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="rg" class="control-label">RG</label>
                                        <input id="iptRg" type="text" class="form-control" name="rg" value="<?php echo $rg; ?>">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="endereco" class="control-label">Endereço</label>
                                        <input id="iptEndereco" type="text" class="form-control" name="endereco" value="<?php echo $endereco; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label for="horario" class="control-label">Horário</label>
                                        <input type="text" class="form-control mask-timeInterval" name="horario" value="<?php echo $horario; ?>">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="data" class="control-label">Data</label>
                                        <input type="date" class="form-control mask-date" name="data" value="<?php echo $data; ?>">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="repouso" class="control-label">Dias de repouso</label>
                                        <input type="number" class="form-control" name="repouso">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="observacoes" class="control-label">Observações</label>
                                        <textarea class="form-control" name="observacoes"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label for="local" class="control-label">Local</label>
                                        <input type="text" class="form-control" name="local" value="<?php echo $local; ?>">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="hoje" class="control-label">Data de hoje</label>
                                        <input type="date" class="form-control" name="hoje" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <?php echo $selectDentista; ?>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="cid" class="control-label">CID</label>
                                        <input type="text" class="form-control" name="cid">
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 form-group text-center">
                                    <label for="tipo" class="control-label">Tipo</label>
                                    <br>
                                    <input type="radio" name="tipo" value="atestado" checked> Atestado
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="tipo" value="comunicacao"> Comunicação
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button target="_blank" type="submit" class="btn btn-block btn-lg btn-primary">
                                        Imprimir/visualizar
                                    </button>
                                </div>
                            </form>
                    </div>
