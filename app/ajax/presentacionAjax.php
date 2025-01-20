<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\presentacionController;

	if(isset($_POST['modulo_presentacion'])){

		$insPresentacion = new presentacionController();

		if($_POST['modulo_presentacion']=="registrar"){
			echo $insPresentacion->registrarPresentacionControlador();
		}

		if($_POST['modulo_presentacion']=="eliminar"){
			echo $insPresentacion->eliminarPresentacionControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}