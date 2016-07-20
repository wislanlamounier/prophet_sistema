<div class="col-md-12">
    <div class="ibox float-e-margins">
        <div class="ibox-header">
            <a class="pull-right" href="<?php echo BASE_URL; ?>/retorno/imprimir">
                <button class="btn btn-success">
                    Imprimir
                </button>
            </a>
        </div>
        <div class="ibox-content p-md">
            <?php include_once('visualizador/retorno/filtro.inc.php'); ?>
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-striped table-bordered table-hover datatable" >
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Telefone</th>
                                <th>Prontuário (novo-antigo)</th>
                                <th>Dentista</th>
                                <th>Data</th>
                                <th>Açoes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $dtoConsulta = new DTOConsulta();
                                foreach($arrConsultas as $arrConsulta){
                                    if(isset($arrConsulta['nomSobrenome']))
                                        $arrConsulta['nomPaciente'] .= ' '.$arrConsulta['nomSobrenome'];
                                    if(isset($arrConsulta['numTelefone2']))
                                        $arrConsulta['numTelefone1'] .= ' '.$arrConsulta['numTelefone2'];
                                    if(isset($arrConsulta['numProntuarioAntigo']))
                                        $arrConsulta['cdnPaciente'] .= ' - '.$arrConsulta['numProntuarioAntigo'];
                            ?>
                            <tr>
                                <td><?php echo $arrConsulta['nomPaciente']; ?></td>
                                <td><?php echo $arrConsulta['numTelefone1']; ?></td>
                                <td><?php echo $arrConsulta['cdnPaciente']; ?></td>
                                <td><?php echo $arrConsulta['nomUsuario']; ?></td>
                                <td>
                                    <?php echo $dtoConsulta->transformacaoData($arrConsulta['datConsulta']); ?> 
                                    <?php echo $arrConsulta['horaConsulta']; ?>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/consulta/remarcar/<?php echo $arrConsulta['cdnConsulta']; ?>">
                                        <button class="btn btn-primary">
                                            Remarcar
                                        </button>
                                    </a>
                                </td>
                            <?php
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Paciente</th>
                                <th>Telefone</th>
                                <th>Prontuário (novo-antigo)</th>
                                <th>Dentista</th>
                                <th>Data</th>
                                <th>Açoes</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
