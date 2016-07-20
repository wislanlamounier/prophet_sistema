                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/consulta/cadastrar">
                                    <button class="btn btn-success">
                                        Marcar
                                    </button>
                                </a>
                            </div>
                            <div class="ibox-content p-md">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="tipo" class="control-label">Mostrar:</label> <br>
                                        <input checked type="radio" name="tipo" class="tipo" value="ativas"> Próximas
                                        &nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="tipo" class="tipo" value="ativas_passadas"> Próximas e realizadas
                                        &nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="tipo" class="tipo" value="desmarcadas"> Desmarcadas
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover datatable" >
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Prontuário</th>
                                                    <th>Data</th>
                                                    <th>Horário</th>
                                                    <th>Visualizar/Remarcar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Prontuário</th>
                                                    <th>Data</th>
                                                    <th>Horário</th>
                                                    <th>Visualizar/Remarcar</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
