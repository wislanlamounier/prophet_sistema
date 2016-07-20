                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 form-group">
                                <h3>
                                    <i class="fa fa-arrow-left"></i>
                                    <?php echo $this->link('questionario', 'cadastrarPergunta', 'Cadastrar nova pergunta'); ?>
                                </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-12 form-group">
                                <label class="control-label" for="strPergunta">Pergunta</label>
                                <input disabled class="form-control" name="strPergunta" type="text" value="<?php echo $dtoPergunta->getStrPergunta(); ?>">
                            </div>
                            <a href="<?php echo BASE_URL; ?>/questionario/atualizarPergunta/<?php echo $dtoPergunta->getCdnPergunta(); ?>">
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="button" class="btn btn-block btn-lg btn-success">
                                        Editar
                                    </button>
                                </div>
                            </a>
                            <?php
                                if(isset($arrOpcoes)){
                            ?>
                            <div class="col-md-12 table-responsive">
                                <table class="table table-striped table-bordered table-hover datatable" >
                                    <thead>
                                        <tr>
                                            <th>Opção</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($arrOpcoes as $arrOpcao){
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php echo $arrOpcao['strOpcao']; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo BASE_URL; ?>/questionario/atualizarOpcao/<?php echo $arrOpcao['cdnOpcao']; ?>">
                                                        <button type="button" class="btn btn-success">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>/questionario/deletarOpcao/<?php echo $arrOpcao['cdnOpcao']; ?>">
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
                                            <th>Pergunta</th>
                                            <th>Ações</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <?php
                                }
                            ?>
                            <a href="<?php echo BASE_URL; ?>/questionario/cadastrarOpcao/<?php echo $dtoPergunta->getCdnPergunta(); ?>">
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="button" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar opção de resposta
                                    </button>
                                </div>
                            </a>
                        </div>
                    </div>
