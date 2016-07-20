                    <div class="col-md-12">                            
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/clinicaRadiologica/cadastrar">
                                    <button class="btn btn-success">
                                        Cadastrar nova clínica
                                    </button>
                                </a>
                            </div>
                            <div class="ibox-content text-center p-md">
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="nomClinicaRadiologica">Nome</label>
                                    <input disabled class="form-control" name="nomClinicaRadiologica" type="text" placeholder="Nome da clínica" value="<?php echo $dtoClinicaRadiologica->getNomClinicaRadiologica(); ?>">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="numWhatsapp">Número Whatsapp</label>
                                    <input disabled class="form-control" name="numWhatsapp" type="text" placeholder="Número whatsapp" value="<?php echo $dtoClinicaRadiologica->getNumWhatsapp(); ?>">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="numTelefone1">Número telefone 1</label>
                                    <input disabled class="form-control" name="numTelefone1" type="text" placeholder="Número telefone 1" value="<?php echo $dtoClinicaRadiologica->getNumTelefone1(); ?>">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="numTelefone2">Número telefone 2</label>
                                    <input disabled class="form-control" name="numTelefone2" type="text" placeholder="Número telefone 2" value="<?php echo $dtoClinicaRadiologica->getNumTelefone2(); ?>">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strEndereco">Endereço</label>
                                    <input disabled class="form-control" name="strEndereco" type="text" placeholder="Endereço da clínica" value="<?php echo $dtoClinicaRadiologica->getStrEndereco(); ?>">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="nomCidade">Cidade</label>
                                    <input disabled class="form-control" name="nomCidade" type="text" placeholder="Cidade da clínica" value="<?php echo $dtoClinicaRadiologica->getNomCidade(); ?>">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strEmail">E-mail</label>
                                    <input class="form-control" name="strEmail" type="email" placeholder="E-mail da clínica" value="<?php echo $dtoClinicaRadiologica->getStrEmail(); ?>">
                                </div>
                                <div class="col-md-6 col-lg-3 form-group">
                                    <label class="control-label" for="strSite">Site</label>
                                    <input disabled class="form-control" name="strSite" type="text" placeholder="Site da clínica" value="<?php echo $dtoClinicaRadiologica->getStrSite(); ?>">
                                </div>
                                <div class="col-md-12 col-lg-12 form-group">
                                    <label class="control-label" for="desClinicaRadiologica">Observações</label>
                                    <textarea disabled class="form-control" name="desClinicaRadiologica"><?php echo $dtoClinicaRadiologica->getDesClinicaRadiologica(); ?></textarea>
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <a href="<?php echo BASE_URL; ?>/clinicaRadiologica/atualizar/<?php echo $dtoClinicaRadiologica->getCdnClinicaRadiologica(); ?>">
                                        <button type="button" class="btn btn-block btn-lg btn-success">
                                            Editar
                                        </button>
                                    </a>
                                </div>
                                <div class="row text-justify">

                                    <div class="col-md-12">
                                        <span class="text-muted">
                                            <?php echo $this->link('clinicaRadiologica', 'deletar', 'Deletar clínica', array($dtoClinicaRadiologica->getCdnClinicaRadiologica())); ?>
                                        </span>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
