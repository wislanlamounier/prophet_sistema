                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/consultorio/cadastrar">
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
                                                    <th>Número</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($arrConsultorios as $arrConsultorio){
                                                        $dtoConsultorio = $modConsultorio->getConsultorio($arrConsultorio['cdnConsultorio']);
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $this->link('consultorio', 'consultarFim', $dtoConsultorio->getCdnConsultorio(), array($dtoConsultorio->getCdnConsultorio()));?>
                                                        </td>
                                                        <td>
                                                            <?php echo $this->link('consultorio', 'consultarFim', $dtoConsultorio->getNumConsultorio(), array($dtoConsultorio->getCdnConsultorio()));?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo BASE_URL; ?>/consultorio/consultarFim/<?php echo $dtoConsultorio->getCdnConsultorio(); ?>">
                                                                <button type="button" class="btn btn-success">
                                                                    <i class="fa fa-hand-o-right"></i>
                                                                </button>
                                                            </a>
                                                            <a href="<?php echo BASE_URL; ?>/consultorio/atualizar/<?php echo $dtoConsultorio->getCdnConsultorio(); ?>">
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
                                                    <th>Código</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
