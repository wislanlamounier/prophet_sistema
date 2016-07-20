                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-striped table-bordered table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>Parcelas</th>
                                            <th>Valores das parcelas</th>
                                            <th>Valor final</th>
                                            <th>Taxas</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($arrParcelas as $arrParcela){
                                        ?>
                                        <tr>
                                            <td><?php echo $arrParcela['numVezes']; ?></td>
                                            <td><?php echo $arrParcela['valores']; ?></td>
                                            <td>R$<?php echo $arrParcela['valOrcamento']; ?></td>
                                            <td>R$<?php echo $arrParcela['valTaxas'] ?></td>
                                            <td>
                                                <?php
                                                    $vezes = $arrParcela['numVezes'];
                                                    if($vezes == 'A VISTA')
                                                        $vezes = 1;
                                                ?>
                                                <a href="<?php echo BASE_URL; ?>/orcamento/escolherForma/<?php echo $cdnOrcamento.'/'.$vezes; ?>">
                                                    <button type="button" class="btn btn-primary">
                                                        Aprovar orçamento
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
                        </div>
