                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/questionario/cadastrarPergunta">
                                    <button class="btn btn-success">
                                        Cadastrar
                                    </button>
                                </a>
                            </div>
                            <div class="ibox-content p-md">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <a href="<?php echo BASE_URL; ?>/questionario/imprimir">
                                            <button class="btn btn-lg btn-primary">
                                                Imprimir/visualizar questionario
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover datatable" >
                                            <thead>
                                                <tr>
                                                    <th>Pergunta</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($arrPerguntas as $arrPergunta){
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $this->link('questionario', 'consultarPergunta', $arrPergunta['strPergunta'], array($arrPergunta['cdnPergunta']));?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo BASE_URL; ?>/questionario/consultarPergunta/<?php echo $arrPergunta['cdnPergunta']; ?>">
                                                                <button type="button" class="btn btn-success">
                                                                    <i class="fa fa-hand-o-right"></i>
                                                                </button>
                                                            </a>
                                                            <a href="<?php echo BASE_URL; ?>/questionario/deletarPergunta/<?php echo $arrPergunta['cdnPergunta']; ?>">
                                                                <button type="button" class="btn btn-warning">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Pergunta</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
