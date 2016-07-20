                    <div class="col-md-12">
                        <div class="row">
                            <form action="<?php echo BASE_URL; ?>/fornecedor/cadastrarFim" method="post">
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="nomFornecedor">Nome</label>
                                    <input required class="form-control" name="nomFornecedor" type="text" >
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="numTelefone1">Número telefone 1</label>
                                    <input class="form-control" name="numTelefone1" type="text" >
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="numTelefone2">Número telefone 2</label>
                                    <input class="form-control" name="numTelefone2" type="text" >
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="numWhatsapp">Número Whatsapp</label>
                                    <input class="form-control" name="numWhatsapp" type="text" >
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="nomFacebook">Nome Facebook</label>
                                    <input class="form-control" name="nomFacebook" type="text" >
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="strEndereco">Endereço</label>
                                    <input class="form-control" name="strEndereco" type="text" >
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="nomRepresentante">Nome representante</label>
                                    <input class="form-control" name="nomRepresentante" type="text" >
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="numRepresentanteTelefone">Telefone representante</label>
                                    <input class="form-control" name="numRepresentanteTelefone" type="text" >
                                </div>
                                <div class="col-md-6 col-lg-4 form-group">
                                    <label class="control-label" for="strRepresentanteEmail">E-mail representante</label>
                                    <input class="form-control" name="strRepresentanteEmail" type="email" >
                                </div>
                                <div class="col-md-12 col-lg-12 form-group">
                                    <label class="control-label" for="desFornecedor">Observações</label>
                                    <textarea class="form-control" name="desFornecedor"></textarea>
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
