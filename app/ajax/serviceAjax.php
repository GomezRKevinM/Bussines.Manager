<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";

use app\controllers\serviceController;

	if(isset($_POST['modulo_venta'])){

		$insVenta = new serviceController();

		/*--------- Buscar servicio por codigo ---------*/
		if($_POST['modulo_venta']=="buscar_codigo"){
			echo $insVenta->buscarCodigoVentaControlador();
		}

		/*--------- Agregar servicio a carrito ---------*/
		if($_POST['modulo_venta']=="agregar_producto"){
			echo $insVenta->agregarProductoCarritoControlador();
        }

        /*--------- Remover servicio de carrito ---------*/
		if($_POST['modulo_venta']=="remover_producto"){
			echo $insVenta->removerProductoCarritoControlador();
		}

		/*--------- Actualizar servicio de carrito ---------*/
		if($_POST['modulo_venta']=="actualizar_producto"){
			echo $insVenta->actualizarProductoCarritoControlador();
		}

		/*--------- Buscar cliente ---------*/
		if($_POST['modulo_venta']=="buscar_cliente"){
			echo $insVenta->buscarClienteVentaControlador();
		}

		/*--------- Agregar cliente a carrito ---------*/
		if($_POST['modulo_venta']=="agregar_cliente"){
			echo $insVenta->agregarClienteVentaControlador();
		}

		/*--------- Remover cliente de carrito ---------*/
		if($_POST['modulo_venta']=="remover_cliente"){
			echo $insVenta->removerClienteVentaControlador();
		}

		/*--------- Registrar Servicio ---------*/
		if($_POST['modulo_venta']=="registrar_venta"){
			echo $insVenta->registrarVentaControlador();
		}

		/*--------- Eliminar Servicio ---------*/
		if($_POST['modulo_venta']=="eliminar_venta"){
			echo $insVenta->eliminarVentaControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}