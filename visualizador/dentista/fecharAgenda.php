<div class="col-md-12">
    <div class="row">
        <form action="<?php echo BASE_URL; ?>/dentista/fecharAgendaFim/<?php echo $cdnDentista; ?>" method="post">
            <div class="col-md-12">
                <label for="datDias" class="control-label">Dias</label>
                <input type="text" name="datDias" class="form-control" id="datDias">
            </div>
            <div class="col-md-12 text-center">
                <label for="indGeral" class="control-label">Observação geral para todas</label> <br>
                <input type="checkbox" name="indGeral" id="indGeral">
            </div>
            <div id="divObs">

            </div>
            <div id="obsGeral"  style="display: none;">
                <div class="col-sm-6 form-group">
                    <label for="obsGeral" class="control-label">Observação</label>
                    <textarea name="obsGeral" class="form-control"></textarea>
                </div>
                <div class="col-sm-1 form-group">
                    <label for="diaGeral" class="control-label">Fechar o dia todo</label><br>
                    <input type="checkbox" checked name="diaGeral">
                </div>
                <div class="col-sm-5 form-group">
                    <label for="horaGeral" class="control-label">Horário (ignorar se for dia inteiro)</label>
                    <input type="text" class="form-control mask-timeInterval" name="horaGeral">
                </div>
            </div>
            <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <button type="submit" class="btn btn-block btn-lg btn-primary">
                    Fechar agenda
                </button>
            </div>
        </form>
        <div class="col-md-12 page-header">
            <h2>Dias abertos</h2>
        </div>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped datatable">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($arrFechados as $arrFechado){
                                $dtoFechado = $modDentista->getDentistaFechado($arrFechado['cdnFechado']);
                        ?>
                        <tr>
                            <td><?php echo $dtoFechado->getDatFechado(true); ?></td>
                            <td><?php echo $dtoFechado->getHoraInicio().' - '.$dtoFechado->getHoraFinal(); ?></td>
                            <td><?php echo $this->link('dentista', 'deletarFechado', 'Excluir', array($dtoFechado->getCdnFechado())); ?></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
