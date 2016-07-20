<?php

	/**
	 * Arquivo responsável pela verificação de login
	 *
	**/
	$logado = false;
	$controle = new Controlador();
	if(isset($_SESSION['cdnUsuario']))
		$logado = !is_null($_SESSION['cdnUsuario']);
	if(!$logado){
		$this->setFlash(LOGIN);
		$controle->inicio();
		die;
	}
