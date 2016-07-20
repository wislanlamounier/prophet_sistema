<div class="col-md-12">
    <div class="ibox float-e-margins">
        <div class="ibox-header">
            <a class="pull-right" href="<?php echo BASE_URL; ?>/sms/baixarHistorico">
                <button class="btn btn-success">
                    Baixar histórico
                </button>
            </a>
        </div>
        <div class="ibox-content p-md">
            <?php include_once('visualizador/sms/filtro.inc.php'); ?>
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-striped table-bordered table-hover datatable" >
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Dentista</th>
                                <th>Data</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $dtoSms = new DTOSms();
                                foreach($arrSms as $sms){
                                    if(isset($sms['nomSobrenome']))
                                        $sms['nomPaciente'] .= ' '.$sms['nomSobrenome'];
                            ?>
                            <tr>
                                <td>
                                    <?php echo $sms['nomPaciente']; ?>
                                </td>
                                <td>
                                    <?php echo $sms['nomUsuario']; ?>
                                </td>
                                <td>
                                    <?php echo $dtoSms->transformacaoDatetime($sms['datEnvio']); ?>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/sms/consultarFim/<?php echo $sms['cdnSms']; ?>">
                                        <button class="btn btn-primary">Visualizar</button>
                                    </a>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Paciente</th>
                                <th>Dentista</th>
                                <th>Data</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
