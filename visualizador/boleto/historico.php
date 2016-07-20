<div class="col-md-12">
    <div class="ibox float-e-margins">
        <div class="ibox-header">
        </div>
        <div class="ibox-content p-md">
            <?php include_once('visualizador/boleto/filtro.inc.php'); ?>
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-striped table-bordered table-hover datatable" >
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Usuário</th>
                                <th>Data</th>
                                <th>Origem</th>
                                <th>Valor</th>
                                <th>Nosso número</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $dtoBoleto = new DTOBoleto();
                                foreach($arrBoletos as $arrBoleto){
                                    if(isset($arrBoleto['nomSobrenome']))
                                        $arrBoleto['nomPaciente'] .= ' '.$arrBoleto['nomSobrenome'];
                            ?>
                            <tr>
                                <td>
                                    <?php echo $arrBoleto['nomPaciente']; ?>
                                </td>
                                <td>
                                    <?php echo $arrBoleto['nomUsuario']; ?>
                                </td>
                                <td>
                                    <?php echo $dtoBoleto->transformacaoDatetime($arrBoleto['datGerado']); ?>
                                </td>
                                <td>
                                    <?php echo $arrBoleto['desOrigem']; ?>
                                </td>
                                <td>
                                    <?php echo $dtoBoleto->transformacaoMonetario($arrBoleto['valBoleto']); ?>
                                </td>
                                <td>
                                    <?php echo $arrBoleto['numNossoNumero']; ?>
                                </td>
                                <td>
                                    <?php

                                        $origem = $arrBoleto['desOrigem'];
                                        if(substr($origem, 0, 9) == 'ORCAMENTO'){
                                            if(strpos($origem, 'PARCELA') > 0){
                                                $origem = str_replace('ORCAMENTO NÚMERO: ', '', $origem);
                                                $origem = str_replace(' PARCELA NÚMERO: ', '', $origem);
                                                $origem = explode('-', $origem);
                                                $cdnOrcamento = trim($origem[0]);
                                                $numParcela = trim($origem[1]);
                                                $urlFim = 'orcamento/registrarPagamento/'.$cdnOrcamento.'/'.$numParcela;
                                            }else{
                                                $origem = str_replace('ORCAMENTO NÚMERO: ', '', $origem);
                                                $cdnOrcamento = trim($origem);
                                                $urlFim = 'orcamento/registrarPagamento/'.$cdnOrcamento;
                                            }
                                        }

                                    ?>
                                    <a href="<?php echo BASE_URL.'/'.$urlFim ?>" target="_blank">
                                        <button class="btn btn-primary">
                                            Registrar pagamento
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
                                <th>Paciente</th>
                                <th>Usuário</th>
                                <th>Data</th>
                                <th>Origem</th>
                                <th>Valor</th>
                                <th>Nosso número</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
