                    <div class="col-md-12">
                        <div class="row">
                            <form action="<?php echo BASE_URL; ?>/secao/cadastrarFim/<?php echo $cdnProcedimento; ?>" method="post">
                                <div class="col-md-3 col-lg-3 form-group">
                                    <label class="control-label" for="nomSecao">Nome</label>
                                    <input required class="form-control" name="nomSecao" type="text" >
                                </div>
                                <div class="col-md-3 col-lg-3 form-group text-center">
                                    <label class="control-label" for="indAviso">Avisar na marcação?</label><br>
                                    <input name="indAviso" type="checkbox">
                                </div>
                                <div class="col-md-6 col-lg-6 form-group">
                                    <label class="control-label" for="desSecao">Descrição</label>
                                    <input class="form-control" name="desSecao" type="text" >
                                </div>
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
