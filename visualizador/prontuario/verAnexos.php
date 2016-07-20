                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content p-md">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/prontuario/anexo/<?php echo $cdnPaciente; ?>">
                                    <button class="btn btn-success">
                                        Cadastrar
                                    </button>
                                </a>
                            </div>
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover datatable" >
                                            <thead>
                                                <tr>
                                                    <th>Descrição</th>
                                                    <th>Tamanho</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($arrAnexos as $arrAnexo){
                                                        $dtoAnexo = $modProntuario->getProntuarioAnexo($arrAnexo['cdnProntuarioAnexo']);
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $this->link('prontuario', 'abrirAnexo', $arrAnexo['desProntuarioAnexo'], array($arrAnexo['cdnProntuarioAnexo']), '_blank');?>
                                                        </td>
                                                        <td>
                                                            <?php echo $this->link('prontuario', 'abrirAnexo', $dtoAnexo->getValTamanho('auto'), array($arrAnexo['cdnProntuarioAnexo']), '_blank');?>
                                                        </td>
                                                        <td>
                                                            <a target="_blank" href="<?php echo BASE_URL; ?>/prontuario/abrirAnexo/<?php echo $arrAnexo['cdnProntuarioAnexo']; ?>">
                                                                <button type="button" class="btn btn-success">
                                                                    <i class="fa fa-hand-o-right"></i>
                                                                </button>
                                                            </a>
                                                            <a href="<?php echo BASE_URL; ?>/prontuario/deletarAnexo/<?php echo $arrAnexo['cdnProntuarioAnexo']; ?>">
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
                                                    <th>Descrição</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
