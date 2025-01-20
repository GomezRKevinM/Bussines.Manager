<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\SupplierController;

	if(isset($_POST['modulo_supplier'])){

		$insSupplier = new SupplierController();

		if($_POST['modulo_supplier']=="registrar"){
			echo $insSupplier->registrarSupplierControlador();
		}

		if($_POST['modulo_supplier']=="eliminar"){
			echo $insSupplier->eliminarSupplierControlador();
		}

		if($_POST['modulo_supplier']=="actualizar"){
			echo $insSupplier->actualizarSupplierControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}