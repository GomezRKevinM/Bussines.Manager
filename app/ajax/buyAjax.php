<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\buyController;

	if(isset($_POST['modulo_compra'])){

		$insCompra = new buyController();

		/*--------- Buscar producto por codigo ---------*/
		if($_POST['modulo_compra']=="buscar_codigo"){
			echo $insCompra->buscarCodigoCompraControlador();
		}

		/*--------- Agregar producto a carrito ---------*/
		if($_POST['modulo_compra']=="agregar_producto"){
			echo $insCompra->agregarProductoCarritoControlador();
        }

        /*--------- Remover producto de carrito ---------*/
		if($_POST['modulo_compra']=="remover_producto"){
			echo $insCompra->removerProductoCarritoControlador();
		}

		/*--------- Actualizar producto de carrito ---------*/
		if($_POST['modulo_compra']=="actualizar_producto"){
			echo $insCompra->actualizarProductoCarritoControlador();
		}

		/*--------- Buscar cliente ---------*/
		if($_POST['modulo_compra']=="buscar_supplier"){
			echo $insCompra->buscarSupplierCompraControlador();
		}

		/*--------- Agregar cliente a carrito ---------*/
		if($_POST['modulo_compra']=="agregar_supplier"){
			echo $insCompra->agregarSupplierCompraControlador();
		}

		/*--------- Remover cliente de carrito ---------*/
		if($_POST['modulo_compra']=="remover_supplier"){
			echo $insCompra->removerSupplierCompraControlador();
		}

		/*--------- Registrar Compra ---------*/
		if($_POST['modulo_compra']=="registrar_compra"){
			echo $insCompra->registrarCompraControlador();
		}

		/*--------- Eliminar Compra ---------*/
		if($_POST['modulo_compra']=="eliminar_compra"){
			echo $insCompra->eliminarCompraControlador();
		}
		
	}else{
		session_destroy();
		header("Location: ".APP_URL."login/");
	}