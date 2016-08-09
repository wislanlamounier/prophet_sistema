<div class="col-md-12">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <label>Data das Consultas</label>
            <input type="text" id="filtroData" class="form-control mask-date" value="<?php echo date('d/m/Y'); ?>" />
        </div>
    </div>
    <div class="row" id="divMapa">
        <?php foreach($arrConsultorios as $consutorio){ ?>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <fieldset>
                    <legend>Consultório <?php echo($consutorio["numConsultorio"]); ?></legend>
                    <?php if(isset($consutorio["consultas"])) { ?>
                        <table class="table table-striped table-bordered table-hover">
                            <tr>
                                <th>Dentista</th>
                                <th>Horário</th>
                            </tr>
                            <?php foreach($consutorio["consultas"] as $consulta) { ?>
                                <tr>
                                    <td><?php echo($consulta["nomDentista"]); ?></td>
                                    <td><?php echo($consulta["horaConsulta"]); ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    <?php } else { ?>
                        <div class="well well-sm" style="text-align: center;">
                            Sem consultas marcadas
                        </div>
                    <?php } ?>
                </fieldset>
            </div>
        <?php } ?>
    </div>
</div>
