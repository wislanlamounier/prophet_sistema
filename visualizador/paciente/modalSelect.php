<label for="cdnPaciente" class="control-label">
    Paciente
    <span id="novoPaciente" style="cursor: pointer;" class="text-muted">(Não possui cadastro?)</span>
</label>
<br>
<strong  style="cursor: pointer;">
    <?php
        $iniText = 'Selecionar paciente...';
        if(isset($nomPaciente))
            $iniText = $nomPaciente;
        if(isset($arrPaciente)){
            $iniText = $arrPaciente['nomPaciente'];
        }
    ?>
    <i id="nomPaciente" ><?php echo $iniText; ?></i>
</strong>
<?php
    $value = '';
    if(isset($cdnPaciente))
        $value = 'value="'.$cdnPaciente.'"';
    if(isset($arrPaciente))
        $value = 'value="'.$arrPaciente['cdnPaciente'].'"';
?>  
<input type="hidden" name="cdnPaciente" <?php echo $value; ?>>
<div class="modal inmodal" id="modalPaciente" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Fechar</span>
                </button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Selecionar paciente</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="selectpaciente">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="fechaModalPaciente">Selecionar</button>
            </div>
        </div>
    </div>
</div>