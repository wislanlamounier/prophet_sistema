<div class="col-md-12">
    <div class="ibox float-e-margins">
        <div class="ibox-content p-md">

            <form action="<?php echo BASE_URL; ?>/main/logs/" method="post">
                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 form-group">
                        <label for="tipo" class="control-label">Datas:</label> <br>
                        <input value="<?php echo $datas; ?>" type="text" class="form-control mask-dateinterval" name="datas" />
                    </div>
                    <div class="col-sm-5 col-md-6 col-lg-3 form-group">
                        <label for="usuario" class="control-label">Usuário:</label>
                        <select name="usuario" class="form-control">
                            <option value="" <?php echo is_null($usuario) ? 'selected' : ''; ?>>Não filtrar</option>
                            <?php
                                foreach($arrUsuarios as $arrUsuario){
                                    $selected = $arrUsuario['cdnUsuario'] == $usuario ? 'selected' : '';
                                    echo '<option value="'.$arrUsuario['cdnUsuario'].'" '.$selected.' >'.$arrUsuario['nomUsuario'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <br />
                        <button class="btn btn-success" type="submit">Modificar</button>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-striped table-bordered table-hover datatable" >
                        <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Data</th>
                            <th>Tipo</th>
                            <th>Local</th>
                            <th>Operação</th>
                            <th>Informação</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $dtoUsuario = new DTOUsuario();
                            foreach($arrLogs as $log){
                                $datLog = $dtoUsuario->transformacaoDatetime($log['datLog']);
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $log['nomUsuario']; ?>
                                    </td>
                                    <td>
                                        <?php echo $datLog; ?>
                                    </td>
                                    <td>
                                        <?php echo $log['strTipo']; ?>
                                    </td>
                                    <td>
                                        <?php echo $log['nomModulo']; ?>
                                    </td>
                                    <td>
                                        <?php echo $log['strOperacao']; ?>
                                    </td>
                                    <td>
                                        <?php echo $log['strInformacao']; ?>
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
                            <th>Tipo</th>
                            <th>Local</th>
                            <th>Operação</th>
                            <th>Informação</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>


        </div>
    </div>
</div>