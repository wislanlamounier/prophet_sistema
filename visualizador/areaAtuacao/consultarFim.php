                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/areaAtuacao/cadastrar">
                                    <button class="btn btn-success">
                                        Cadastrar nova área de atuação
                                    </button>
                                </a>
                            </div>
                            <div class="ibox-content text-center p-md">
                                <div class="col-md-12 col-lg-12 form-group">
                                    <label class="control-label" for="nomAreaAtuacao">Nome</label>
                                    <input disabled class="form-control" name="nomAreaAtuacao" type="text" value="<?php echo $dtoAreaAtuacao->getNomAreaAtuacao(); ?>">
                                </div>
                                <div class="col-md-12 col-lg-12 form-group">
                                    <label class="control-label" for="desAreaAtuacao">Observações</label>
                                    <textarea disabled class="form-control" name="desAreaAtuacao"><?php echo $dtoAreaAtuacao->getDesAreaAtuacao(); ?></textarea>
                                </div>
                                <?php
                                    if(count($arrProcedimentos) > 0){
                                ?>
                                <div class="col-md-12 table-responsive text-justify">
                                    <h4 class="text-center">Procedimentos</h4>
                                    <table class="table table-striped table-bordered table-hover datatable" >
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach($arrProcedimentos as $arrProcedimento){
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $this->link('procedimento', 'consultarFim', $arrProcedimento['nomProcedimento'], array($arrProcedimento['cdnProcedimento']));?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo BASE_URL; ?>/procedimento/consultarFim/<?php echo $arrProcedimento['cdnProcedimento']; ?>">
                                                            <button class="btn btn-success">
                                                                <span class="fa fa-hand-o-right"></span>
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                                    }
                                ?>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <a href="<?php echo BASE_URL; ?>/procedimento/cadastrar/<?php echo $dtoAreaAtuacao->getCdnAreaAtuacao(); ?>">
                                        <button type="button" class="btn btn-block btn-lg btn-primary">
                                            Cadastrar procedimento
                                        </button>
                                    </a>
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <a href="<?php echo BASE_URL; ?>/areaAtuacao/atualizar/<?php echo $dtoAreaAtuacao->getCdnAreaAtuacao(); ?>">
                                        <button type="button" class="btn btn-block btn-lg btn-success">
                                            Editar
                                        </button>
                                    </a>
                                </div>
                                <div class="row text-justify">

                                    <div class="col-md-12">
                                        <span class="text-muted">
                                            <?php echo $this->link('areaAtuacao', 'deletar', 'Deletar área de atuação', array($dtoAreaAtuacao->getCdnAreaAtuacao())); ?>
                                        </span>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
