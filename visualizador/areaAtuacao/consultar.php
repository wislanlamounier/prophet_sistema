                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/areaAtuacao/cadastrar">
                                    <button class="btn btn-success">
                                        Cadastrar
                                    </button>
                                </a>
                            </div>
                            <div class="ibox-content p-md">

                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover datatable" >
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nome</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($arrAreaAtuacoes as $arrAreaAtuacao){
                                                        $dtoAreaAtuacao = $modAreaAtuacao->getAreaAtuacao($arrAreaAtuacao['cdnAreaAtuacao']);
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $this->link('areaAtuacao', 'consultarFim', $dtoAreaAtuacao->getCdnAreaAtuacao(), array($dtoAreaAtuacao->getCdnAreaAtuacao()));?>
                                                        </td>
                                                        <td>
                                                            <?php echo $this->link('areaAtuacao', 'consultarFim', $dtoAreaAtuacao->getNomAreaAtuacao(), array($dtoAreaAtuacao->getCdnAreaAtuacao()));?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo BASE_URL; ?>/areaAtuacao/consultarFim/<?php echo $dtoAreaAtuacao->getCdnAreaAtuacao(); ?>">
                                                                <button type="button" class="btn btn-success">
                                                                    <i class="fa fa-hand-o-right"></i>
                                                                </button>
                                                            </a>
                                                            <a href="<?php echo BASE_URL; ?>/areaAtuacao/atualizar/<?php echo $dtoAreaAtuacao->getCdnAreaAtuacao(); ?>">
                                                                <button type="button" class="btn btn-success">
                                                                    <i class="fa fa-edit"></i>
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
                                                    <th>#</th>
                                                    <th>Nome</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
