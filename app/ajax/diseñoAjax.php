<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\diseñoController;

	if(isset($_POST['modulo_diseño'])){

		$insDiseño = new diseñoController;

		if($_POST['modulo_diseño']=="actualizar"){
			echo $insDiseño->actualizarStyleControlador();
		}else{
			echo "no ha reconocido el for";		}
	}