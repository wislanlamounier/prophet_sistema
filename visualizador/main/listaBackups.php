
<div class="row">
    <div class="col-md-12 table-responsive">
        <table class="table table-striped table-bordered table-hover datatable" >
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $modMain = new ModeloMain(true);
                    foreach($arrBackups as $arrBackup){
                        $dtoBackup = $modMain->getBackup($arrBackup['cdnBackup']);
                        if(is_null($dtoBackup->getCdnUsuario())){
                            $usuario = 'BACKUP AUTOMÁTICO';
                        }else{
                            $arrUsuario = $modMain->getUsuario($dtoBackup->getCdnUsuario());
                            $usuario = 'Manual - '.$arrUsuario['nomUsuario'];
                        }
                ?>
                    <tr>
                        <td>
                            <?= $usuario; ?>
                        </td>
                        <td>
                            <?= $dtoBackup->getDatBackup(true); ?>
                        </td>
                        <td>
                            <?php
                                if(!is_null($dtoBackup->getCdnUsuario())){
                                    echo $this->link('main', 'downloadBackup', 'Baixar', array($dtoBackup->getCdnBackup()), '_blank');
                                }
                            ?>
                        </td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Usuário</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>