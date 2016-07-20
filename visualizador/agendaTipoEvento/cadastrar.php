                    <div class="col-md-12">
                        <form action="<?php echo BASE_URL; ?>/agendaTipoEvento/cadastrarFim" method="post">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="control-label" for="nomTipoEvento">Nome</label>
                                    <input required class="form-control" name="nomTipoEvento" type="text">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label" for="codCor">Cor</label>
                                    <select required class="form-control" name="codCor">
                                        <option value="yellow" style="background-color: #f39c12;">Amarelo</option>
                                        <option value="blue" style="background-color: #0073b7;">Azul</option>
                                        <option value="purple" style="background-color: #605ca8;">Roxo</option>
                                        <option value="green" style="background-color: #00a65a;">Verde</option>
                                        <option value="red" style="background-color: #dd4b39;">Vermelho</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
