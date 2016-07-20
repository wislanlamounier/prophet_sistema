                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/clinicaRadiologica/cadastrar">
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
                                                    foreach($arrClinicasRadiologicas as $arrClinicaRadiologica){
                                                        $dtoClinicaRadiologica = $modClinicaRadiologica->getClinicaRadiologica($arrClinicaRadiologica['cdnClinicaRadiologica']);
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $this->link('clinicaRadiologica', 'consultarFim', $dtoClinicaRadiologica->getCdnClinicaRadiologica(), array($dtoClinicaRadiologica->getCdnClinicaRadiologica()));?>
                                                        </td>
                                                        <td>
                                                            <?php echo $this->link('clinicaRadiologica', 'consultarFim', $dtoClinicaRadiologica->getNomClinicaRadiologica(), array($dtoClinicaRadiologica->getCdnClinicaRadiologica()));?>
                                                        </td>
                                                        <td>
                                                            <?php echo $this->link('clinicaRadiologica', 'consultarFim', $dtoClinicaRadiologica->getNumTelefone1().' / '.$dtoClinicaRadiologica->getNumTelefone2(), array($dtoClinicaRadiologica->getCdnClinicaRadiologica()));?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo BASE_URL; ?>/clinicaRadiologica/consultarFim/<?php echo $dtoClinicaRadiologica->getCdnClinicaRadiologica(); ?>">
                                                                <button type="button" class="btn btn-success">
                                                                    <i class="fa fa-hand-o-right"></i>
                                                                </button>
                                                            </a>
                                                            <a href="<?php echo BASE_URL; ?>/clinicaRadiologica/atualizar/<?php echo $dtoClinicaRadiologica->getCdnClinicaRadiologica(); ?>">
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
