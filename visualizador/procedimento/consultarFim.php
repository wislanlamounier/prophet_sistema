                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <?php
                                    echo $this->link('areaAtuacao', 'consultarFim', 'Voltar para área de atuação', array($dtoProcedimento->getCdnAreaAtuacao()), '_self', 'pull-left');
                                ?>
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/procedimento/cadastrar/<?php echo $dtoProcedimento->getCdnAreaAtuacao(); ?>">
                                    <button class="btn btn-success">
                                        Cadastrar novo procedimento
                                    </button>
                                </a>
                            </div>
                            <div class="ibox-content text-center p-md">

                                <div class="col-sm-3 form-group">
                                    <label class="control-label" for="nomProcedimento">Nome</label>
                                    <input disabled class="form-control" name="nomProcedimento" type="text" placeholder="Nome do procedimento" value="<?php echo $dtoProcedimento->getNomProcedimento(); ?>">
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label class="control-label" for="indAviso">Avisar na marcação?</label><br>
                                    <input disabled name="indAviso" type="checkbox" <?php echo $dtoProcedimento->getIndAviso() ? 'checked' : ''; ?>>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label" for="desProcedimento">Observações</label>
                                    <input disabled class="form-control" name="desProcedimento" type="text" placeholder="Observações" value="<?php echo $dtoProcedimento->getDesProcedimento(); ?>">
                                </div>
                                <?php
                                    if(count($arrSecoes) > 0){
                                ?>
                                <div class="col-md-12 table-responsive text-justify">
                                    <h4 class="text-center">Seções</h4>
                                    <table class="table table-striped table-bordered table-hover datatable" >
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Descrição</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach($arrSecoes as $arrSecao){
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $this->link('secao', 'consultarFim', $arrSecao['nomSecao'], array($arrSecao['cdnSecao']));?>
                                                    </td>
                                                    <td>
                                                        <?php echo $this->link('secao', 'consultarFim', $arrSecao['desSecao'], array($arrSecao['cdnSecao']));?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo BASE_URL; ?>/secao/consultarFim/<?php echo $arrSecao['cdnSecao']; ?>">
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

                                <?php
                                    if(count($arrTabelas) > 0 or count($arrParcerias) > 0){
                                ?>
                                <div class="col-md-12 table-responsive text-justify">
                                    <h4 class="text-center">Tabelas de preço</h4>
                                    <table class="table table-striped table-bordered table-hover datatable" >
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
                                                        R$<?php echo $dtoTabelaPreco->transformacaoMonetario($arrTabela['valPreco']); ?>
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
                                                        R$<?php echo $dtoParceria->transformacaoMonetario($arrParceria['valPreco']); ?>
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
                                    <a href="<?php echo BASE_URL; ?>/secao/cadastrar/<?php echo $dtoProcedimento->getCdnProcedimento(); ?>">
                                        <button type="button" class="btn btn-block btn-lg btn-primary">
                                            Cadastrar seção
                                        </button>
                                    </a>
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <a href="<?php echo BASE_URL; ?>/procedimento/atualizar/<?php echo $dtoProcedimento->getCdnProcedimento(); ?>">
                                        <button type="button" class="btn btn-block btn-lg btn-success">
                                            Editar
                                        </button>
                                    </a>
                                </div>
                                <div class="row text-justify">

                                    <div class="col-md-12">
                                        <span class="text-muted">
                                            <?php echo $this->link('procedimento', 'deletar', 'Deletar procedimento', array($dtoProcedimento->getCdnProcedimento())); ?>
                                        </span>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
