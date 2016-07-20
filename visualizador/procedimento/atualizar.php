                    <div class="col-md-12">
                        <div class="row">
                            <form action="<?php echo BASE_URL; ?>/procedimento/atualizarFim/<?php echo $dtoProcedimento->getCdnProcedimento(); ?>" method="post">
                                <div class="col-sm-3 form-group">
                                    <label class="control-label" for="nomProcedimento">Nome</label>
                                    <input required class="form-control" name="nomProcedimento" type="text" value="<?php echo $dtoProcedimento->getNomProcedimento(); ?>">
                                </div>
                                <div class="col-sm-3 form-group text-center">
                                    <label class="control-label" for="indAviso">Avisar na marcação?</label><br>
                                    <input name="indAviso" type="checkbox" <?php echo $dtoProcedimento->getIndAviso() ? 'checked' : ''; ?>>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label class="control-label" for="desProcedimento">Observações</label>
                                    <input class="form-control" name="desProcedimento" type="text" value="<?php echo $dtoProcedimento->getDesProcedimento(); ?>">
                                </div>

                                <?php
                                    if(count($arrTabelas) > 0 or count($arrParcerias) > 0){
                                ?>
                                <div class="col-md-12 table-responsive text-justify">
                                    <h4 class="text-center">Tabelas de preço</h4>
                                    <table class="table table-striped table-bordered table-hover" >
                                        <thead>
                                            <tr>
                                                <th>Tabela</th>
                                                <th>Preço</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach($arrTabelas as $arrTabela){
                                                    $dtoTabelaPreco = $modTabelaPreco->getTabelaPreco($arrTabela['cdnTabelaPreco']);
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $dtoTabelaPreco->getNomTabelaPreco(); ?>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="tab<?php echo $dtoTabelaPreco->getCdnTabelaPreco();?>"
                                                               class="mask-money form-control no-margin" value="R$<?php echo $dtoTabelaPreco->transformacaoMonetario($arrTabela['valPreco']); ?>">
                                                    </td>
                                                </tr>
                                            <?php
                                                }
                                            ?>
                                            <?php
                                                foreach($arrParcerias as $arrParceria){
                                                    $dtoParceria = $modParceria->getParceria($arrParceria['cdnParceria']);
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $dtoParceria->getNomParceria(); ?>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="par<?php echo $dtoParceria->getCdnParceria();?>"
                                                               class="mask-money form-control no-margin" value="R$<?php echo $dtoParceria->transformacaoMonetario($arrParceria['valPreco']); ?>">
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
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Editar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
