	
<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <a id="ajuda"><b>Ajuda com as tags?</b></a>
            <hr>
        </div>
    </div>
    <form action="<?php echo BASE_URL; ?>/sms/configuracoesFim" method="post">
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="strAvisoConsulta" class="control-label">Mensagem de aviso de consulta</label>
                <textarea class="form-control" name="strAvisoConsulta"><?php echo $dtoConfiguracoes->getStrAvisoConsulta(); ?></textarea>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="indPesquisa" class="control-label">Ativar pesquisa de satisfação?</label> <br>
                <input type="checkbox" name="indPesquisa" <?php echo $dtoConfiguracoes->getIndPesquisa() ? 'checked' : ''; ?>>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="strPesquisa" class="control-label">Mensagem de pesquisa de satisfação</label>
                <textarea class="form-control" name="strPesquisa"><?php echo $dtoConfiguracoes->getStrPesquisa(); ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="indTipoPesquisa" class="control-label">Frequência da pesquisa</label> <br>
                <input <?php echo $dtoConfiguracoes->getIndTipoPesquisa() == 'primeira' ? 'checked' : ''; ?> type="radio" name="indTipoPesquisa" value="primeira"> Primeira consulta &nbsp;&nbsp;&nbsp;
                <input <?php echo $dtoConfiguracoes->getIndTipoPesquisa() == 'todas' ? 'checked' : ''; ?> type="radio" name="indTipoPesquisa" value="todas"> Todas consultas &nbsp;&nbsp;&nbsp;
                <input <?php echo $dtoConfiguracoes->getIndTipoPesquisa() == 'tres' ? 'checked' : ''; ?> type="radio" name="indTipoPesquisa" value="tres"> A cada três consultas do paciente
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="indDatasFestivas" class="control-label">Ativar SMS automáticos em datas festivas? *</label> <br>
                <input type="checkbox" name="indDatasFestivas" <?php echo $dtoConfiguracoes->getIndDatasFestivas() ? 'checked' : ''; ?>> <br>
                <small> * - natal, páscoa e ano novo. SMS enviados apenas para clientes ativos nos últimos 3 meses. </small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="strDatasFestivas" class="control-label">Mensagem de datas festivas</label>
                <textarea class="form-control" name="strDatasFestivas"><?php echo $dtoConfiguracoes->getStrDatasFestivas(); ?></textarea>
            </div>
            <div class="col-md-12 form-group">
                <label class="control-label">Exemplo de utilização</label>
                <span>O texto "Olá, %paciente%! Nós da %clinica% lhe desejamos %dataFestiva%!" irá enviar uma mensagem:</span> <br>
                <span>Olá, João! Nós da <?php echo $_SESSION['nomClinica']; ?> lhe desejamos um Feliz Natal!</span>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="indAniversario" class="control-label">Ativar SMS automáticos nos aniversários de pacientes? *</label> <br>
                <input type="checkbox" name="indAniversario" <?php echo $dtoConfiguracoes->getIndAniversario() ? 'checked' : ''; ?>> <br>
                <small> * - SMS enviados apenas para clientes ativos nos últimos 3 meses. </small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="strAniversario" class="control-label">Mensagem de aniversário</label>
                <textarea class="form-control" name="strAniversario"><?php echo $dtoConfiguracoes->getStrAniversario(); ?></textarea>
            </div>
        </div>
        <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
            <button type="submit" class="btn btn-block btn-lg btn-primary">
                Editar
            </button>
        </div>
    </form>
</div>


<div class="modal inmodal" id="modalTags" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Fechar</span>
                </button>
                <i class="fa fa-code modal-icon"></i>
                <h4 class="modal-title">Tags disponíveis</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Tag</th>
                                    <th>Função</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>%paciente%</td>
                                    <td>Primeiro nome do paciente</td>
                                </tr>
                                <tr>
                                    <td>%pacienteCompleto%</td>
                                    <td>Nome completo do paciente</td>
                                </tr>
                                <tr>
                                    <td>%horario%</td>
                                    <td>Horário da consulta</td>
                                </tr>
                                <tr>
                                    <td>%dataConsulta</td>
                                    <td>Data da consulta</td>
                                </tr>
                                <tr>
                                    <td>%clinica%</td>
                                    <td>Nome da clínica</td>
                                </tr>
                                <tr>
                                    <td>%profissional%</td>
                                    <td>Nome do dentista</td>
                                </tr>
                                <tr>
                                    <td>%dataFestiva%</td>
                                    <td>
                                        Nome da data festiva, junto com seu prefixo.
                                        Ex: "um Feliz Natal!", "uma Feliz Páscoa!"
                                    </td>
                                </tr>
                                <tr>
                                    <td>%data%</td>
                                    <td>Data do envio do SMS</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>