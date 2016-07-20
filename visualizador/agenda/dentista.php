
	<div class="col-md-12 text-center">
		<a href="<?php echo BASE_URL; ?>/agenda/dentistaImprimir">
			<button class="btn btn-lg btn-default">
				Imprimir/visualizar
			</button>
		</a>
	</div>

	<div class="col-md-12 form-group">
		<label for="cdnDentista" class="control-label">Dentista</label>
		<select class="form-control select2" id="iptCdnDentista" name="cdnDentista">
			<?php
				foreach($arrDentistas as $arrDentista){
					echo '<option value="'.$arrDentista['cdnUsuario'].'">'.$arrDentista['nomUsuario'].'</option>';
				}
			?>
		</select>
	</div>

    <div class="col-md-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <!-- THE CALENDAR -->
                <div id="calendario"></div>
            </div><!-- /.box-body -->
        </div><!-- /. box -->
    </div><!-- /.col -->