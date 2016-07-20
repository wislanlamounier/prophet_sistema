
			<div class="row m-t-sm">
	            <div class="col-lg-12">
		            <div class="panel blank-panel">
			            <div class="panel-heading">
			                <div class="panel-options">
			                </div>
			            </div>

			            <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-4">
                                    <a href="<?php echo BASE_URL; ?>/main/backupFim/">
                                        <button class="btn btn-primary btn-lg btn-block">
                                            Realizar backup manual
                                        </button>
                                    </a>
                                </div>
                                <div class="col-sm-4 col-sm-offset-4 text-center">
                                    <?php
                                        if(isset($dtoUltimo)){
                                            echo 'Último backup realizado em: '.$dtoUltimo->getDatBackup(true);
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php include_once('listaBackups.php'); ?>
			            </div>
			        </div>
	            </div>

            </div>
