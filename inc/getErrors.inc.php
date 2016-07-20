<?php
	$flash = $this->getFlash();
	if(is_array($flash)){
		if(count($flash) > 0){
			if(isset($flash['erro'])){
				
			}
			foreach($flash as $tipo=>$mensagem){
				if(trim($mensagem) != ''){
					$texto = '';
					$tipo = $tipo == 'erro' ? 'danger' : $tipo;
					$tipo = $tipo == 'aviso' ? 'warning' : $tipo;
					$tipo = $tipo == 'sucesso' ? 'success' : $tipo;
					$tipo = $tipo == 'mensagem' ? 'info' : $tipo;
					$texto .= $mensagem.'<br>';
					echo '  <div class="row">
								<div class="col-md-12 alert alert-'.$tipo.' text-center">
									<span><b>'.$texto.'</b></span>
								</div>
							</div>';
				}
			}
		}
	}
	$this->setFlash(null);
	if(isset($_SESSION['erroPHP'])){
		if($_SESSION['erroPHP'] != ''){
			echo '
					<div class="row">
						<div class="col-md-12 alert alert-danger text-center">
							<span>'.$_SESSION['erroPHP'].'</span>
						</div>
					</div>';
			$_SESSION['erroPHP'] = '';
		}
	}
