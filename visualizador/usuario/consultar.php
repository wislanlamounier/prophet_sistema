                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/usuario/cadastrar">
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
                                                    <th>E-mail</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($arrUsuarios as $arrUsuario){
                                                        $arrUsuario = $modMain->consultar('usuario', '*', array('cdnUsuario' => $arrUsuario['cdnUsuario']))[0];
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $this->link('usuario', 'consultarFim', $arrUsuario['cdnUsuario'], array($arrUsuario['cdnUsuario']));?>
                                                        </td>
                                                        <td>
                                                            <?php echo $this->link('usuario', 'consultarFim', $arrUsuario['nomUsuario'], array($arrUsuario['cdnUsuario']));?>
                                                        </td>
                                                        <td>
                                                            <?php echo $this->link('usuario', 'consultarFim', $arrUsuario['strEmail'], array($arrUsuario['cdnUsuario']));?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo BASE_URL; ?>/usuario/consultarFim/<?php echo $arrUsuario['cdnUsuario']; ?>">
                                                                <button type="button" class="btn btn-success">
                                                                    <i class="fa fa-hand-o-right"></i>
                                                                </button>
                                                            </a>
                                                            <a href="<?php echo BASE_URL; ?>/usuario/atualizar/<?php echo $arrUsuario['cdnUsuario']; ?>">
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
                                                    <th>E-mail</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
