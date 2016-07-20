                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/fornecedor/cadastrar">
                                    <button class="btn btn-success">
                                        Cadastrar novo fornecedor
                                    </button>
                                </a>
                            </div>
                            <div class="ibox-content text-center p-md">

                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="nomFornecedor">Nome</label>
                                    <input disabled class="form-control" name="nomFornecedor" type="text" placeholder="Nome do fornecedor" value="<?php echo $dtoFornecedor->getNomFornecedor(); ?>">
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="numTelefone1">Número telefone 1</label>
                                    <input disabled class="form-control" name="numTelefone1" type="text" placeholder="Número telefone 1" value="<?php echo $dtoFornecedor->getNumTelefone1(); ?>">
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="numTelefone2">Número telefone 2</label>
                                    <input disabled class="form-control" name="numTelefone2" type="text" placeholder="Número telefone 2" value="<?php echo $dtoFornecedor->getNumTelefone2(); ?>">
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="numWhatsapp">Número Whatsapp</label>
                                    <input disabled class="form-control" name="numWhatsapp" type="text" placeholder="Número whatsapp" value="<?php echo $dtoFornecedor->getNumWhatsapp(); ?>">
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="nomFacebook">Nome Facebook</label>
                                    <input disabled class="form-control" name="nomFacebook" type="text" placeholder="Nome do Facebook" value="<?php echo $dtoFornecedor->getNomFacebook(); ?>">
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="strEndereco">Endereço</label>
                                    <input disabled class="form-control" name="strEndereco" type="text" value="<?php echo $dtoFornecedor->getStrEndereco(); ?>">
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="nomRepresentante">Nome representante</label>
                                    <input disabled class="form-control" name="nomRepresentante" type="text" placeholder="Nome do Representante" value="<?php echo $dtoFornecedor->getNomRepresentante(); ?>">
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="numRepresentanteTelefone">Telefone representante</label>
                                    <input disabled class="form-control" name="numRepresentanteTelefone" type="text" placeholder="Telefone do representante" value="<?php echo $dtoFornecedor->getNumRepresentanteTelefone(); ?>">
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="strRepresentanteEmail">E-mail representante</label>
                                    <input disabled class="form-control" name="strRepresentanteEmail" type="email" placeholder="E-mail do representante" value="<?php echo $dtoFornecedor->getStrRepresentanteEmail(); ?>">
                                </div>
                                <div class="col-md-12 col-lg-12 form-group">
                                    <label class="control-label" for="desFornecedor">Observações</label>
                                    <textarea disabled class="form-control" name="desFornecedor"><?php echo $dtoFornecedor->getDesFornecedor(); ?></textarea>
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <a href="<?php echo BASE_URL; ?>/fornecedor/atualizar/<?php echo $dtoFornecedor->getCdnFornecedor(); ?>">
                                        <button type="button" class="btn btn-block btn-lg btn-success">
                                            Editar
                                        </button>
                                    </a>
                                </div>
                                <div class="row text-justify">

                                    <div class="col-md-12">
                                        <span class="text-muted">
                                            <?php echo $this->link('fornecedor', 'deletar', 'Deletar fornecedor', array($dtoFornecedor->getCdnFornecedor())); ?>
                                        </span>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
