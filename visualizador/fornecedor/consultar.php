                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/fornecedor/cadastrar">
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
                                                    <th>Telefones</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($arrFornecedores as $arrFornecedor){
                                                        $dtoFornecedor = $modFornecedor->getFornecedor($arrFornecedor['cdnFornecedor']);
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $this->link('fornecedor', 'consultarFim', $dtoFornecedor->getCdnFornecedor(), array($dtoFornecedor->getCdnFornecedor()));?>
                                                        </td>
                                                        <td>
                                                            <?php echo $this->link('fornecedor', 'consultarFim', $dtoFornecedor->getNomFornecedor(), array($dtoFornecedor->getCdnFornecedor()));?>
                                                        </td>
                                                        <td>
                                                            <?php echo $this->link('fornecedor', 'consultarFim', $dtoFornecedor->getNumTelefone1().' / '.$dtoFornecedor->getNumTelefone2(), array($dtoFornecedor->getCdnFornecedor()));?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo BASE_URL; ?>/fornecedor/consultarFim/<?php echo $dtoFornecedor->getCdnFornecedor(); ?>">
                                                                <button type="button" class="btn btn-success">
                                                                    <i class="fa fa-hand-o-right"></i>
                                                                </button>
                                                            </a>
                                                            <a href="<?php echo BASE_URL; ?>/fornecedor/atualizar/<?php echo $dtoFornecedor->getCdnFornecedor(); ?>">
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
