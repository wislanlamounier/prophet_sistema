                        <div class="col-md-12 form-group">
                            <label class="control-label" for="diaVencimento">Dia de vencimento mensal</label>
                            <input type="number" name="diaVencimento" class="form-control" disabled value="<?php echo $dtoOrcamentoFormaPagamento->getNumDiaVencimento(); ?>">
                        </div>
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-striped table-bordered table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>Parcela</th>
                                            <th>Valor</th>
                                            <?php
                                                if($dtoOrcamento->getIndAprovado()){
                                            ?>
                                            <th>Vencimento</th>
                                            <?php
                                                }
                                            ?>
                                            <th>Paga</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($arrParcelas as $dtoOrcamentoParcela){
                                                $dtoOrcamentoParcela = unserialize($dtoOrcamentoParcela);
                                        ?>
                                        <tr>
                                            <td><?php echo $dtoOrcamentoParcela->getNumParcela(); ?></td>
                                            <td>R$<?php echo $dtoOrcamentoParcela->getValParcela(true); ?></td>
                                            <?php
                                                if($dtoOrcamento->getIndAprovado()){
                                            ?>
                                            <td><?php echo $dtoOrcamentoParcela->getDatVencimento(true); ?></td>
                                            <?php
                                                }
                                            ?>
                                            <td><?php echo $dtoOrcamentoParcela->getIndPaga(true); ?></td>
                                            <td>
                                                <?php
                                                    if(!$dtoOrcamentoParcela->getIndPaga()){
                                                        if($dtoOrcamento->getIndAprovado()){
                                                ?>
                                                <a href="<?php echo BASE_URL; ?>/orcamento/registrarPagamento/<?php echo $dtoOrcamento->getCdnOrcamento().'/'.$dtoOrcamentoParcela->getNumParcela(); ?>">
                                                    <button type="button" class="btn btn-success">
                                                        Registrar pagamento
                                                    </button>
                                                </a>
                                                <a href="<?php echo BASE_URL; ?>/orcamento/parcelaAtualizar/<?php echo $dtoOrcamento->getCdnOrcamento().'/'.$dtoOrcamentoParcela->getNumParcela(); ?>">
                                                    <button type="button" class="btn btn-success btn-outline">
                                                        Alterar vencimento
                                                    </button>
                                                </a>
                                                <?php
                                                            if($dtoOrcamentoFormaPagamento->getIndVia() == 'boleto'){
                                                ?>
                                                <a target="_blank" href="<?php echo BASE_URL; ?>/boleto/gerar/<?php echo $dtoOrcamentoParcela->getValParcela().'/'.'orcamento_parcela/'.$dtoOrcamento->getCdnPaciente().'/'.$dtoOrcamento->getCdnOrcamento().'/'.$dtoOrcamentoParcela->getNumParcela(); ?>">
                                                    <button type="button" class="btn btn-primary">
                                                        Gerar boleto
                                                    </button>
                                                </a>
                                                <?php
                                                            }else{

                                                                if($dtoOrcamentoFormaPagamento->getIndVia() == 'nota'){
                                                ?>
                                                <a target="_blank" href="<?php echo BASE_URL; ?>/orcamento/notaPromissoria/<?php echo $dtoOrcamento->getCdnOrcamento().'/'.$dtoOrcamentoParcela->getNumParcela(); ?>">
                                                    <button type="button" class="btn btn-primary">
                                                        Gerar nota promissória
                                                    </button>
                                                </a>
                                                <?php
                                                                }
                                                            }
                                                        }else{
                                                ?>
                                                <b>Orçamento não aprovado.</b>
                                                <?php
                                                        }
                                                    }else{
                                                ?>
                                                <b>Parcela paga.</b>
                                                <?php
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
