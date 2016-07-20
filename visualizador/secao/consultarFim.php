                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/secao/cadastrar/<?php echo $dtoSecao->getCdnProcedimento(); ?>">
                                    <button class="btn btn-success">
                                        Cadastrar nova seção
                                    </button>
                                </a>
                            </div>
                            <div class="ibox-content text-center p-md">
                                <div class="col-md-12 text-justify">
                                    <?php
                                        echo $this->link('procedimento', 'consultarFim', 'Voltar para procedimento', array($dtoSecao->getCdnProcedimento()));
                                    ?>
                                </div>
                                <div class="col-md-3 col-lg-3 form-group">
                                    <label class="control-label" for="nomSecao">Nome</label>
                                    <input disabled class="form-control" name="nomSecao" type="text" placeholder="Nome da seção" value="<?php echo $dtoSecao->getNomSecao(); ?>">
                                </div>
                                <div class="col-md-3 col-lg-3 form-group text-center">
                                    <label class="control-label" for="indAviso">Avisar na marcação?</label><br>
                                    <input disabled name="indAviso" type="checkbox">
                                </div>
                                <div class="col-md-6 col-lg-6 form-group">
                                    <label class="control-label" for="desSecao">Descrição</label>
                                    <input disabled class="form-control" name="desSecao" type="text" placeholder="Descrição da seção" value="<?php echo $dtoSecao->getDesSecao(); ?>">
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <a href="<?php echo BASE_URL; ?>/secao/atualizar/<?php echo $dtoSecao->getCdnSecao(); ?>">
                                        <button type="button" class="btn btn-block btn-lg btn-success">
                                            Editar
                                        </button>
                                    </a>
                                </div>
                                <div class="row text-justify">

                                    <div class="col-md-12">
                                        <span class="text-muted">
                                            <?php echo $this->link('secao', 'deletar', 'Deletar seção', array($dtoSecao->getCdnSecao())); ?>
                                        </span>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
