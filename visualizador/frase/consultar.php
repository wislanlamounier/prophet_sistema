                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/frase/cadastrar">
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
                                                    <th>Frase</th>
                                                    <th>Autor</th>
                                                    <th>Principal</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $modMain = new ModeloMain(true);
                                                    foreach($arrFrases as $arrFrase){
                                                        $dtoFrase = $modFrase->getFrase($arrFrase['cdnFrase']);
                                                        $arrUsuario = $modMain->getUsuario($dtoFrase->getCdnUsuario());
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $this->link('frase', 'consultarFim', $dtoFrase->getCdnFrase(), array($dtoFrase->getCdnFrase()));?>
                                                        </td>
                                                        <td>
                                                            <?php echo $this->link('frase', 'consultarFim', $dtoFrase->getStrFrase(), array($dtoFrase->getCdnFrase()));?>
                                                        </td>
                                                        <td>
                                                            <?php echo $this->link('frase', 'consultarFim', $arrUsuario['nomUsuario'], array($dtoFrase->getCdnFrase()));?>
                                                        </td>
                                                        <td>
                                                            <?php echo $this->link('frase', 'consultarFim', $dtoFrase->getIndAtiva(true), array($dtoFrase->getCdnFrase()));?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo BASE_URL; ?>/frase/ativar/<?php echo $dtoFrase->getCdnFrase(); ?>">
                                                                <button type="button" class="btn btn-success">
                                                                    <i class="fa fa-check"></i>
                                                                </button>
                                                            </a>
                                                            <a href="<?php echo BASE_URL; ?>/frase/atualizar/<?php echo $dtoFrase->getCdnFrase(); ?>">
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
                                                    <th>Telefones</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
