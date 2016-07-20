<div class="row">
                            <div class="col-md-12">
                                <h3 class="page-header text-center">Procedimentos</h3>
                            </div>
                            <div class="col-md-12 table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Dentista</th>
                                            <th>Área de atuação</th>
                                            <th>Procedimento</th>
                                            <th>Quantidade</th>
                                            <th>Valor unitário</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($arrProcedimentos as $arrProcedimento){
                                                $arrUsuario = $modMain->getUsuario($arrProcedimento['cdnDentista']);
                                                $dtoAreaAtuacao = $modAreaAtuacao->getAreaAtuacao($arrProcedimento['cdnAreaAtuacao']);
                                                $dtoProcedimento = $modProcedimento->getProcedimento($arrProcedimento['cdnProcedimento']);
                                        ?>
                                        <tr>
                                            <td><?php echo $arrUsuario['nomUsuario']; ?></td>
                                            <td><?php echo $dtoAreaAtuacao->getNomAreaAtuacao(); ?></td>
                                            <td><?php echo $dtoProcedimento->getNomProcedimento(); ?></td>
                                            <td><?php echo $arrProcedimento['numQuantidade']; ?></td>
                                            <td>R$<?php echo $dtoProcedimento->transformacaoMonetario($arrProcedimento['valUnitario']); ?></td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
