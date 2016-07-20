                    <div class="col-md-12">
                        <div class="row">
                            <form id="<?php echo $cdnPaciente; ?>" target="_blank" action="<?php echo BASE_URL; ?>/prontuario/imprimirFim/<?php echo $cdnPaciente; ?>" method="post">
                                <div class="col-md-12 form-group">
                                    <label class="control-label" for="datIntervalo">A partir - até</label>
                                    <input required class="form-control" id="datIntervalo" name="datIntervalo" type="text">
                                    <div style="display: none; " id="repeticao" class="alert alert-warning">

                                    </div>
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Imprimir/visualizar
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="page-header">
                                    Histórico de impressões
                                </h3>
                            </div>
                            <div class="col-md-12 table-responsive">
                                <table class="table table-striped table-bordered table-hover datatable" >
                                    <thead>
                                        <tr>
                                            <th>De</th>
                                            <th>Até</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($arrHistoricos as $arrHistorico){
                                                $dtoHistorico = $modProntuario->getProntuarioHistorico($arrHistorico['cdnProntuarioHistorico']);
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php echo $dtoHistorico->getDatInicio(true); ?>
                                                </td>
                                                <td>
                                                    <?php echo $dtoHistorico->getDatFim(true); ?>
                                                </td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>De</th>
                                            <th>Até</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
