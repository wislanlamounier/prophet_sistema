                    <div class="col-md-12">
                        <div class="row">
                            <form action="<?php echo BASE_URL; ?>/dentista/abrirAgendaFim/<?php echo $cdnDentista; ?>" method="post">
                                <div class="col-sm-6 form-group">
                                    <label class="control-label" for="horaManha">Horário manhã</label>
                                    <input type="text" class="form-control mask-timeInterval" name="horaManha">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label class="control-label" for="horaTarde">Horário tarde</label>
                                    <input type="text" class="form-control mask-timeInterval" name="horaTarde">
                                </div>
                                <div class="col-sm-12 form-group" id="data">
                                    <label class="control-label" for="datAberto">Data</label>
                                    <input required type="text" class="form-control mask-date" name="datAberto" id="datAberto">
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12 page-header">
                            <h2>Dias abertos</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-striped datatable">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Horário manhã</th>
                                            <th>Horário tarde</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($arrAbertos as $arrAberto){
                                                $dtoAberto = $modDentista->getDentistaAberto($arrAberto['cdnAberto']);
                                        ?>
                                        <tr>
                                            <td><?php echo $dtoAberto->getDatAberto(true); ?></td>
                                            <td><?php echo $dtoAberto->getHoraManha(); ?></td>
                                            <td><?php echo $dtoAberto->getHoraTarde(); ?></td>
                                            <td><?php echo $this->link('dentista', 'deletarAberto', 'Excluir', array($dtoAberto->getCdnAberto())); ?></td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
