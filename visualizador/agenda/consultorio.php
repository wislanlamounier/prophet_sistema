
	<div class="col-md-12 text-center">
		<a href="<?php echo BASE_URL; ?>/agenda/consultorioImprimir">
			<button class="btn btn-lg btn-default">
				Imprimir/visualizar
			</button>
		</a>
	</div>

	<div class="col-md-12 form-group">
		<label for="cdnConsultorio" class="control-label">Consultório</label>
		<select class="form-control select2" id="iptCdnConsultorio" name="cdnConsultorio">
			<?php
				foreach($arrConsultorios as $arrConsultorio){
					echo '<option value="'.$arrConsultorio['cdnConsultorio'].'">'.$arrConsultorio['numConsultorio'].'</option>';
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