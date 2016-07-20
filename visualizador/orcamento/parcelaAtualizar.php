                    <div class="col-md-12">
                            <form action="<?php echo BASE_URL; ?>/orcamento/parcelaAtualizarFim/<?php echo $dtoParcela->getCdnOrcamento().'/'.$dtoParcela->getNumParcela(); ?>" method="post">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="datVencimento" class="control-label">Vencimento</label>
                                        <input required type="date" value="<?php echo $dtoParcela->getDatVencimento(); ?>" class="form-control mask-date" name="datVencimento">
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </form>
                    </div>
