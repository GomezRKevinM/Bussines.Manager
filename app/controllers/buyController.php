<?php

	namespace app\controllers;
	use app\models\mainModel;

	class buyController extends mainModel{

		/*---------- Controlador buscar codigo de producto ----------*/
        public function buscarCodigoCompraControlador(){

            /*== Recuperando codigo de busqueda ==*/
			$producto=$this->limpiarCadena($_POST['buscar_codigo']);

			/*== Comprobando que no este vacio el campo ==*/
			if($producto==""){
				return '
				<article class="message is-warning mt-4 mb-4">
					 <div class="message-header">
					    <p>¡Ocurrio un error inesperado!</p>
					 </div>
				    <div class="message-body has-text-centered">
				    	<i class="fas fa-exclamation-triangle fa-2x"></i><br>
						Debes de introducir el Nombre, Marca o Modelo del producto
				    </div>
				</article>';
				exit();
            }

            /*== Seleccionando productos en la DB ==*/
            $datos_productos=$this->ejecutarConsulta("SELECT * FROM producto WHERE (producto_nombre LIKE '%$producto%' OR producto_marca LIKE '%$producto%' OR producto_modelo LIKE '%$producto%') ORDER BY producto_nombre ASC");

            if($datos_productos->rowCount()>=1){

				$datos_productos=$datos_productos->fetchAll();

				$tabla='<div class="table-container mb-6"><table class="table is-striped is-narrow is-hoverable is-fullwidth"><tbody>';

				foreach($datos_productos as $rows){
					$tabla.='
					<tr class="has-text-left" >
                        <td><i class="fas fa-box fa-fw"></i> &nbsp; '.$rows['producto_nombre'].'</td>
                        <td class="has-text-centered">
                            <button type="button" class="button is-link is-rounded is-small" onclick="agregar_codigo(\''.$rows['producto_codigo'].'\')"><i class="fas fa-plus-circle"></i></button>
                        </td>
                    </tr>
                    ';
				}

				$tabla.='</tbody></table></div>';
				return $tabla;
			}else{
				return '<article class="message is-warning mt-4 mb-4">
					 <div class="message-header">
					    <p>¡Ocurrio un error inesperado!</p>
					 </div>
				    <div class="message-body has-text-centered">
				    	<i class="fas fa-exclamation-triangle fa-2x"></i><br>
						No hemos encontrado ningún producto en el sistema que coincida con <strong>“'.$producto.'”
				    </div>
				</article>';

				exit();
			}
        }

        /*---------- Controlador agregar producto a la compra ----------*/
        public function agregarProductoCarritoControlador(){

            /*== Recuperando codigo del producto ==*/
            $codigo=$this->limpiarCadena($_POST['producto_codigo']);

            if($codigo==""){
                $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Debes de introducir el código de barras del producto",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            /*== Verificando integridad de los datos ==*/
            if($this->verificarDatos("[a-zA-Z0-9- ]{1,70}",$codigo)){
                $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El código de barras no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            /*== Comprobando producto en la DB ==*/
            $check_producto=$this->ejecutarConsulta("SELECT * FROM producto WHERE producto_codigo='$codigo'");
            if($check_producto->rowCount()<=0){
                $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el producto con código de barras : '$codigo'",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }else{
                $campos=$check_producto->fetch();
            }

            /*== Codigo de producto ==*/
            $codigo=$campos['producto_codigo'];

            if(empty($_SESSION['datos_producto_compra'][$codigo])){

                $detalle_cantidad=1;

                $stock_total=$campos['producto_stock_total']+$detalle_cantidad;

                $detalle_total=$detalle_cantidad*$campos['producto_precio_compra'];
                $detalle_total=number_format($detalle_total,MONEDA_DECIMALES,'.','');

                $_SESSION['datos_producto_compra'][$codigo]=[
                    "producto_id"=>$campos['producto_id'],
					"producto_codigo"=>$campos['producto_codigo'],
					"producto_stock_total"=>$stock_total,
					"producto_stock_total_old"=>$campos['producto_stock_total'],
                    "compra_detalle_precio_compra"=>$campos['producto_precio_compra'],
                    "compra_detalle_precio_venta"=>$campos['producto_precio_venta'],
                    "compra_detalle_cantidad"=>1,
                    "compra_detalle_total"=>$detalle_total,
                    "compra_detalle_descripcion"=>$campos['producto_nombre']
                ];

                $_SESSION['alerta_producto_agregado']="Se agrego <strong>".$campos['producto_nombre']."</strong> a la Compra!";
            }else{
                $detalle_cantidad=($_SESSION['datos_producto_compra'][$codigo]['compra_detalle_cantidad'])+1;

                $stock_total=$campos['producto_stock_total']+$detalle_cantidad;

                if($stock_total<0){
                    $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Lo sentimos, no hay existencias disponibles del producto seleccionado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
                }

                $detalle_total=$detalle_cantidad*$campos['producto_precio_compra'];
                $detalle_total=number_format($detalle_total,MONEDA_DECIMALES,'.','');

                $_SESSION['datos_producto_compra'][$codigo]=[
                    "producto_id"=>$campos['producto_id'],
					"producto_codigo"=>$campos['producto_codigo'],
					"producto_stock_total"=>$stock_total,
					"producto_stock_total_old"=>$campos['producto_stock_total'],
                    "compra_detalle_precio_compra"=>$campos['producto_precio_compra'],
                    "compra_detalle_precio_venta"=>$campos['producto_precio_venta'],
                    "compra_detalle_cantidad"=>$detalle_cantidad,
                    "compra_detalle_total"=>$detalle_total,
                    "compra_detalle_descripcion"=>$campos['producto_nombre']
                ];

                $_SESSION['alerta_producto_agregado']="Se agrego +1 <strong>".$campos['producto_nombre']."</strong> a la compra. Total: <strong>$detalle_cantidad</strong>";
            }

            $alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL."buyNew/"
			];

			return json_encode($alerta);
        }

        /*---------- Controlador remover producto de compra ----------*/
        public function removerProductoCarritoControlador(){

            /*== Recuperando codigo del producto ==*/
            $codigo=$this->limpiarCadena($_POST['producto_codigo']);

            unset($_SESSION['datos_producto_compra'][$codigo]);

            if(empty($_SESSION['datos_producto_compra'][$codigo])){
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"¡Producto removido!",
					"texto"=>"El producto se ha removido de la compra",
					"icono"=>"success"
				];
				
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido remover el producto, por favor intente nuevamente",
					"icono"=>"error"
				];
            }
            return json_encode($alerta);
        }

        /*---------- Controlador actualizar producto de compra ----------*/
        public function actualizarProductoCarritoControlador(){

            /*== Recuperando codigo & cantidad del producto ==*/
            $codigo=$this->limpiarCadena($_POST['producto_codigo']);
            $cantidad=$this->limpiarCadena($_POST['producto_cantidad']);

            /*== comprobando campos vacios ==*/
            if($codigo=="" || $cantidad==""){
            	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos actualizar la cantidad de productos debido a que faltan algunos parámetros de configuración",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            /*== comprobando cantidad de productos ==*/
            if($cantidad<=0){
                $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Debes de introducir una cantidad mayor a 0",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            /*== Comprobando producto en la DB ==*/
            $check_producto=$this->ejecutarConsulta("SELECT * FROM producto WHERE producto_codigo='$codigo'");
            if($check_producto->rowCount()<=0){
                $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el producto con código de barras : '$codigo'",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }else{
                $campos=$check_producto->fetch();
            }

            /*== comprobando producto en carrito ==*/
            if(!empty($_SESSION['datos_producto_compra'][$codigo])){

                if($_SESSION['datos_producto_compra'][$codigo]["compra_detalle_cantidad"]==$cantidad){
                    $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"No has modificado la cantidad de productos",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
                }

                if($cantidad>$_SESSION['datos_producto_compra'][$codigo]["compra_detalle_cantidad"]){
                    $diferencia_productos="agrego +".($cantidad-$_SESSION['datos_producto_compra'][$codigo]["compra_detalle_cantidad"]);
                }else{
                    $diferencia_productos="quito -".($_SESSION['datos_producto_compra'][$codigo]["compra_detalle_cantidad"]-$cantidad);
                }


                $detalle_cantidad=$cantidad;

                $stock_total=$campos['producto_stock_total']+$detalle_cantidad;

                $detalle_total=$detalle_cantidad*$campos['producto_precio_compra'];
                $detalle_total=number_format($detalle_total,MONEDA_DECIMALES,'.','');

                $_SESSION['datos_producto_compra'][$codigo]=[
                    "producto_id"=>$campos['producto_id'],
					"producto_codigo"=>$campos['producto_codigo'],
					"producto_stock_total"=>$stock_total,
					"producto_stock_total_old"=>$campos['producto_stock_total'],
                    "compra_detalle_precio_compra"=>$campos['producto_precio_compra'],
                    "compra_detalle_precio_venta"=>$campos['producto_precio_venta'],
                    "compra_detalle_cantidad"=>$detalle_cantidad,
                    "compra_detalle_total"=>$detalle_total,
                    "compra_detalle_descripcion"=>$campos['producto_nombre']
                ];

                $_SESSION['alerta_producto_agregado']="Se $diferencia_productos <strong>".$campos['producto_nombre']."</strong> a la compra. Total:<strong>$detalle_cantidad</strong>";

                $alerta=[
					"tipo"=>"redireccionar",
					"url"=>APP_URL."buyNew/"
				];

				return json_encode($alerta);
            }else{
                $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el producto que desea actualizar en el carrito",
					"icono"=>"error"
				];
				return json_encode($alerta);
            }
        }

        /*---------- Controlador buscar proveedor ----------*/
        public function buscarSupplierCompraControlador(){

            /*== Recuperando termino de busqueda ==*/
			$proveedor=$this->limpiarCadena($_POST['buscar_supplier']);

			/*== Comprobando que no este vacio el campo ==*/
			if($proveedor==""){
				return '
				<article class="message is-warning mt-4 mb-4">
					 <div class="message-header">
					    <p>¡Ocurrio un error inesperado!</p>
					 </div>
				    <div class="message-body has-text-centered">
				    	<i class="fas fa-exclamation-triangle fa-2x"></i><br>
						Debes de introducir el Nombre, Representante o Teléfono del proveedor
				    </div>
				</article>';
				exit();
            }

            /*== Seleccionando clientes en la DB ==*/
            $datos_proveedor=$this->ejecutarConsulta("SELECT * FROM provedor WHERE (supplier_id!='1') AND (supplier_nombre LIKE '%$proveedor%' OR supplier_representante LIKE '%$proveedor%' OR supplier_telefono LIKE '%$proveedor%') ORDER BY supplier_nombre ASC");

            if($datos_proveedor->rowCount()>=1){

				$datos_proveedor=$datos_proveedor->fetchAll();

				$tabla='<div class="table-container mb-6"><table class="table is-striped is-narrow is-hoverable is-fullwidth"><tbody>';

				foreach($datos_proveedor as $rows){
					$tabla.='
					<tr>
                        <td class="has-text-left" ><i class="fas fa-male fa-fw"></i> &nbsp; '.$rows['supplier_nombre'].' representante: '.$rows['supplier_representante'].' (Telefono: '.$rows['supplier_telefono'].')</td>
                        <td class="has-text-centered" >
                            <button type="button" class="button is-link is-rounded is-small" onclick="agregar_supplier('.$rows['supplier_id'].')"><i class="fas fa-user-plus"></i></button>
                        </td>
                    </tr>
                    ';
				}

				$tabla.='</tbody></table></div>';
				return $tabla;
			}else{
				return '
				<article class="message is-warning mt-4 mb-4">
					 <div class="message-header">
					    <p>¡Ocurrio un error inesperado!</p>
					 </div>
				    <div class="message-body has-text-centered">
				    	<i class="fas fa-exclamation-triangle fa-2x"></i><br>
						No hemos encontrado ningún proveedor en el sistema que coincida con <strong>“'.$proveedor.'”</strong>
				    </div>
				</article>';
				exit();
			}
        }

        /*---------- Controlador agregar proveedor ----------*/
        public function agregarSupplierCompraControlador(){

            /*== Recuperando id del cliente ==*/
			$id=$this->limpiarCadena($_POST['supplier_id']);

			/*== Comprobando cliente en la DB ==*/
			$check_supplier=$this->ejecutarConsulta("SELECT * FROM provedor WHERE supplier_id='$id'");
			if($check_supplier->rowCount()<=0){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido agregar el proveedor debido a un error, por favor intente nuevamente",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}else{
				$campos=$check_supplier->fetch();
            }

			if($_SESSION['datos_supplier_compra']['supplier_id']==1){
                $_SESSION['datos_supplier_compra']=[
                    "supplier_id"=>$campos['supplier_id'],
                    "supplier_nombre"=>$campos['supplier_nombre'],
                ];

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"¡Proveedor agregado!",
					"texto"=>"El proveedor se agregó para realizar una compra",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido agregar el proveedor debido a un error, por favor intente nuevamente",
					"icono"=>"error"
				];
            }
            return json_encode($alerta);
        }

        /*---------- Controlador remover proveedor ----------*/
        public function removerSupplierCompraControlador(){

			unset($_SESSION['datos_supplier_compra']);

			if(empty($_SESSION['datos_supplier_compra'])){
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"¡Proveedor removido!",
					"texto"=>"Los datos del proveedor se han quitado de la compra",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido remover el proveedor, por favor intente nuevamente",
					"icono"=>"error"
				];	
			}
			return json_encode($alerta);
        }

        /*---------- Controlador registrar compra ----------*/
        public function registrarCompraControlador(){

            $caja=$this->limpiarCadena($_POST['compra_caja']);
            $compra_pagado=$this->limpiarCadena($_POST['compra_abono']);

            /*== Comprobando integridad de los datos ==*/
            if($this->verificarDatos("[0-9.]{1,25}",$compra_pagado)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El total pagado para el proveedor no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            if($_SESSION['compra_total']<=0 || (!isset($_SESSION['datos_producto_compra']) && count($_SESSION['datos_producto_compra'])<=0)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No ha agregado productos a esta compra",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            if(!isset($_SESSION['datos_supplier_compra'])){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No ha seleccionado ningún proveedor para realizar esta compra",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }


            /*== Comprobando proveedor en la DB ==*/
			$check_proveedor=$this->ejecutarConsulta("SELECT supplier_id FROM provedor WHERE supplier_id='".$_SESSION['datos_supplier_compra']['supplier_id']."'");
			if($check_proveedor->rowCount()<=0){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el proveedor registrado en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }


            /*== Comprobando caja en la DB ==*/
            $check_caja=$this->ejecutarConsulta("SELECT * FROM caja WHERE caja_id='$caja'");
			if($check_caja->rowCount()<=0){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La caja no está registrada en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }else{
                $datos_caja=$check_caja->fetch();
            }


            /*== Formateando variables ==*/
            $compra_pagado=number_format($compra_pagado,MONEDA_DECIMALES,'.','');
            $compra_total=number_format($_SESSION['compra_total'],MONEDA_DECIMALES,'.','');

            $compra_fecha=date("Y-m-d");
            $compra_hora=date("h:i a");

            $compra_total_final=$compra_total;
            $compra_total_final=number_format($compra_total_final,MONEDA_DECIMALES,'.','');


            /*== Calculando el cambio ==*/
            if($compra_pagado<$compra_total_final){
                $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Esta es una compra al contado, el total a pagar no puede ser menor al total",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            $compra_cambio=$compra_pagado-$compra_total_final;
            $compra_cambio=number_format($compra_cambio,MONEDA_DECIMALES,'.','');


            /*== Calculando total en caja ==*/
            $movimiento_cantidad=$compra_pagado-$compra_cambio;
            $movimiento_cantidad=number_format($movimiento_cantidad,MONEDA_DECIMALES,'.','');

            $total_caja=$datos_caja['caja_efectivo']-$movimiento_cantidad;
            $total_caja=number_format($total_caja,MONEDA_DECIMALES,'.','');

			if($total_caja<0){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ups fondos insuficientes",
					"texto"=>"la caja no posee el dinero suficiente para pagar esta compra",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

            /*== Actualizando productos ==*/
            $errores_productos=0;
			foreach($_SESSION['datos_producto_compra'] as $productos){

                /*== Obteniendo datos del producto ==*/
                $check_producto=$this->ejecutarConsulta("SELECT * FROM producto WHERE producto_id='".$productos['producto_id']."' AND producto_codigo='".$productos['producto_codigo']."'");
                if($check_producto->rowCount()<1){
                    $errores_productos=1;
                    break;
                }else{
                    $datos_producto=$check_producto->fetch();
                }

                /*== Respaldando datos de BD para poder restaurar en caso de errores ==*/
                $_SESSION['datos_producto_compra'][$productos['producto_codigo']]['producto_stock_total']=$datos_producto['producto_stock_total']+$_SESSION['datos_producto_compra'][$productos['producto_codigo']]['compra_detalle_cantidad'];

                $_SESSION['datos_producto_compra'][$productos['producto_codigo']]['producto_stock_total_old']=$datos_producto['producto_stock_total'];

                /*== Preparando datos para enviarlos al modelo ==*/
                $datos_producto_up=[
                    [
						"campo_nombre"=>"producto_stock_total",
						"campo_marcador"=>":Stock",
						"campo_valor"=>$_SESSION['datos_producto_compra'][$productos['producto_codigo']]['producto_stock_total']
					]
                ];

                $condicion=[
                    "condicion_campo"=>"producto_id",
                    "condicion_marcador"=>":ID",
                    "condicion_valor"=>$productos['producto_id']
                ];

                /*== Actualizando producto ==*/
                if(!$this->actualizarDatos("producto",$datos_producto_up,$condicion)){
                    $errores_productos=1;
                    break;
                }
            }

            /*== Reestableciendo DB debido a errores ==*/
            if($errores_productos==1){

                foreach($_SESSION['datos_producto_compra'] as $producto){

                    $datos_producto_rs=[
                        [
							"campo_nombre"=>"producto_stock_total",
							"campo_marcador"=>":Stock",
							"campo_valor"=>$producto['producto_stock_total_old']
						]
                    ];

                    $condicion=[
                        "condicion_campo"=>"producto_id",
                        "condicion_marcador"=>":ID",
                        "condicion_valor"=>$producto['producto_id']
                    ];

                    $this->actualizarDatos("producto",$datos_producto_rs,$condicion);
                }

                $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido actualizar los productos en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            /*== generando codigo de compra ==*/
            $correlativo=$this->ejecutarConsulta("SELECT compra_id FROM compra");
			$correlativo=($correlativo->rowCount())+1;
            $codigo_compra=$this->generarCodigoAleatorio(10,$correlativo);

            /*== Preparando datos para enviarlos al modelo ==*/
			$datos_compra_reg=[
				[
					"campo_nombre"=>"compra_codigo",
					"campo_marcador"=>":Codigo",
					"campo_valor"=>$codigo_compra
				],
				[
					"campo_nombre"=>"compra_fecha",
					"campo_marcador"=>":Fecha",
					"campo_valor"=>$compra_fecha
				],
				[
					"campo_nombre"=>"compra_hora",
					"campo_marcador"=>":Hora",
					"campo_valor"=>$compra_hora
				],
				[
					"campo_nombre"=>"compra_total",
					"campo_marcador"=>":Total",
					"campo_valor"=>$compra_total_final
				],
				[
					"campo_nombre"=>"compra_pagado",
					"campo_marcador"=>":Pagado",
					"campo_valor"=>$compra_pagado
				],
				[
					"campo_nombre"=>"compra_cambio",
					"campo_marcador"=>":Cambio",
					"campo_valor"=>$compra_cambio
				],
				[
					"campo_nombre"=>"usuario_id",
					"campo_marcador"=>":Usuario",
					"campo_valor"=>$_SESSION['id']
				],
				[
					"campo_nombre"=>"supplier_id",
					"campo_marcador"=>":Proveedor",
					"campo_valor"=>$_SESSION['datos_supplier_compra']['supplier_id']
				],
				[
					"campo_nombre"=>"caja_id",
					"campo_marcador"=>":Caja",
					"campo_valor"=>$caja
				]
            ];

            /*== Agregando compra ==*/
            $agregar_compra=$this->guardarDatos("compra",$datos_compra_reg);

            if($agregar_compra->rowCount()!=1){
                foreach($_SESSION['datos_producto_compra'] as $producto){

                    $datos_producto_rs=[
                        [
							"campo_nombre"=>"producto_stock_total",
							"campo_marcador"=>":Stock",
							"campo_valor"=>$producto['producto_stock_total_old']
						]
                    ];

                    $condicion=[
                        "condicion_campo"=>"producto_id",
                        "condicion_marcador"=>":ID",
                        "condicion_valor"=>$producto['producto_id']
                    ];

                    $this->actualizarDatos("producto",$datos_producto_rs,$condicion);
                }

                $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido registrar la compra, por favor intente nuevamente. Código de error: 001",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            /*== Agregando detalles de la compra ==*/
            $errores_compra_detalle=0;
            foreach($_SESSION['datos_producto_compra'] as $compra_detalle){

                /*== Preparando datos para enviarlos al modelo ==*/
                $datos_compra_detalle_reg=[
                	[
						"campo_nombre"=>"compra_detalle_cantidad",
						"campo_marcador"=>":Cantidad",
						"campo_valor"=>$compra_detalle['compra_detalle_cantidad']
					],
					[
						"campo_nombre"=>"compra_detalle_precio_compra",
						"campo_marcador"=>":PrecioCompra",
						"campo_valor"=>$compra_detalle['compra_detalle_precio_compra']
					],
					[
						"campo_nombre"=>"compra_detalle_precio",
						"campo_marcador"=>":PrecioVenta",
						"campo_valor"=>$compra_detalle['compra_detalle_precio_venta']
					],
					[
						"campo_nombre"=>"compra_detalle_total",
						"campo_marcador"=>":Total",
						"campo_valor"=>$compra_detalle['compra_detalle_total']
					],
					[
						"campo_nombre"=>"compra_detalle_descripcion",
						"campo_marcador"=>":Descripcion",
						"campo_valor"=>$compra_detalle['compra_detalle_descripcion']
					],
					[
						"campo_nombre"=>"compra_coment",
						"campo_marcador"=>":Comentario",
						"campo_valor"=>"Compra de productos"
					],
					[
						"campo_nombre"=>"compra_codigo",
						"campo_marcador"=>":CompraCodigo",
						"campo_valor"=>$codigo_compra
					],
					[
						"campo_nombre"=>"producto_id",
						"campo_marcador"=>":Producto",
						"campo_valor"=>$compra_detalle['producto_id']
					]
                ];

                $agregar_detalle_compra=$this->guardarDatos("compra_detalle",$datos_compra_detalle_reg);

                if($agregar_detalle_compra->rowCount()!=1){
                    $errores_compra_detalle=1;
                    break;
                }
            }

            /*== Reestableciendo DB debido a errores ==*/
            if($errores_compra_detalle==1){

                $this->eliminarRegistro("compra_detalle","compra_codigo",$codigo_compra);
                $this->eliminarRegistro("compra","compra_codigo",$codigo_compra);

                foreach($_SESSION['datos_producto_compra'] as $producto){

                    $datos_producto_rs=[
                        [
							"campo_nombre"=>"producto_stock_total",
							"campo_marcador"=>":Stock",
							"campo_valor"=>$producto['producto_stock_total_old']
						]
                    ];

                    $condicion=[
                        "condicion_campo"=>"producto_id",
                        "condicion_marcador"=>":ID",
                        "condicion_valor"=>$producto['producto_id']
                    ];

                    $this->actualizarDatos("producto",$datos_producto_rs,$condicion);
                }

                $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido registrar la compra, por favor intente nuevamente. Código de error: 002",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            /*== Actualizando efectivo en caja ==*/
            $datos_caja_up=[
                [
					"campo_nombre"=>"caja_efectivo",
					"campo_marcador"=>":Efectivo",
					"campo_valor"=>$total_caja
				]
            ];

            $condicion_caja=[
                "condicion_campo"=>"caja_id",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$caja
            ];

            if(!$this->actualizarDatos("caja",$datos_caja_up,$condicion_caja)){

                $this->eliminarRegistro("compra_detalle","compra_codigo",$codigo_compra);
                $this->eliminarRegistro("compra","compra_codigo",$codigo_compra);

                foreach($_SESSION['datos_producto_compra'] as $producto){

                    $datos_producto_rs=[
                        [
							"campo_nombre"=>"producto_stock_total",
							"campo_marcador"=>":Stock",
							"campo_valor"=>$producto['producto_stock_total_old']
						]
                    ];

                    $condicion=[
                        "condicion_campo"=>"producto_id",
                        "condicion_marcador"=>":ID",
                        "condicion_valor"=>$producto['producto_id']
                    ];

                    $this->actualizarDatos("producto",$datos_producto_rs,$condicion);
                }

                $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido registrar la compra, por favor intente nuevamente. Código de error: 003",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();

            }

            /*== Vaciando variables de sesion ==*/
            unset($_SESSION['compra_total']);
            unset($_SESSION['datos_supplier_compra']);
            unset($_SESSION['datos_producto_compra']);

            $_SESSION['compra_codigo_factura']=$codigo_compra;

            $alerta=[
				"tipo"=>"recargar",
				"titulo"=>"¡Compra registrada!",
				"texto"=>"La compra se registró con éxito en el sistema",
				"icono"=>"success"
			];
			return json_encode($alerta);
	        exit();
        }

		/*----------  Controlador listar compra  ----------*/
		public function listarCompraDateControlador($pagina,$registros,$url,$busqueda,$fechaF){

			$pagina=$this->limpiarCadena($pagina);
			$registros=$this->limpiarCadena($registros);
			$date= date("y-m-d");
			$fechaF=$_SESSION['fechaF'];
			$url=$this->limpiarCadena($url);
			$url=APP_URL.$url."/";

			$busqueda=$this->limpiarCadena($busqueda);

			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			$campos_tablas="compra.compra_id,compra.compra_codigo,compra.compra_fecha,compra.compra_hora,compra.compra_total,compra.usuario_id,compra.supplier_id,compra.caja_id,usuario.usuario_id,usuario.usuario_nombre,usuario.usuario_apellido,provedor.supplier_id,provedor.supplier_nombre,provedor.supplier_representante";

			if(isset($busqueda) && $busqueda!=""){

				$consulta_datos="SELECT $campos_tablas FROM compra INNER JOIN provedor ON compra.supplier_id=provedor.supplier_id INNER JOIN usuario ON compra.usuario_id=usuario.usuario_id WHERE compra_fecha BETWEEN '$busqueda' AND '$fechaF' ORDER BY compra.compra_id DESC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(compra_id) FROM compra WHERE compra_fecha";

			}else{

				$consulta_datos="SELECT $campos_tablas FROM compra INNER JOIN provedor ON compra.supplier_id=provedor.supplier_id INNER JOIN usuario ON compra.usuario_id=usuario.usuario_id ORDER BY compra.compra_id DESC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(compra_id) FROM compra";

			}

			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();

			$total = $this->ejecutarConsulta($consulta_total);
			$total = (int) $total->fetchColumn();

			$numeroPaginas =ceil($total/$registros);

			$tabla.='
				<div><i class="bi bi-bag-check-fill"></i> &nbsp;Compras Realizadas en este periodo: <strong>'.$total.'</strong><div>
				<div class="table-container">
				<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
					<thead>
						<tr>
							<th class="has-text-centered">NRO.</th>
							<th class="has-text-centered">Codigo</th>
							<th class="has-text-centered">Fecha</th>
							<th class="has-text-centered">Provedor</th>
							<th class="has-text-centered">Vendedor</th>
							<th class="has-text-centered">Total</th>
							<th class="has-text-centered">Opciones</th>
						</tr>
					</thead>
					<tbody>
			';

			if($total>=1 && $pagina<=$numeroPaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){
					$tabla.='
						<tr class="has-text-centered" >
							<td>'.$rows['compra_id'].'</td>
							<td>'.$rows['compra_codigo'].'</td>
							<td>'.date("d-m-Y", strtotime($rows['compra_fecha'])).' '.$rows['compra_hora'].'</td>
							<td>'.$this->limitarCadena($rows['supplier_nombre'],30,"...").'</td>
							<td>'.$this->limitarCadena($rows['usuario_nombre'].' '.$rows['usuario_apellido'],30,"...").'</td>
							<td>'.MONEDA_SIMBOLO.number_format($rows['compra_total']).' '.MONEDA_NOMBRE.'</td>
							<td>

								<button type="button" class="button is-link is-outlined is-rounded is-small btn-sale-options" onclick="print_invoiceBuy(\''.APP_URL.'app/pdf/invoiceB.php?code='.$rows['compra_codigo'].'\')" title="Imprimir factura de compra Nro. '.$rows['compra_id'].'" >
									<i class="fas fa-file-invoice-dollar fa-fw"></i>
								</button>

								<button type="button" class="button is-link is-outlined is-rounded is-small btn-sale-options" onclick="print_ticketBuy(\''.APP_URL.'app/pdf/ticketB.php?code='.$rows['compra_codigo'].'\')" title="Imprimir ticket de compra Nro. '.$rows['compra_id'].'" >
									<i class="fas fa-receipt fa-fw"></i>
								</button>

								<a href="'.APP_URL.'buyDetail/'.$rows['compra_codigo'].'/" class="button is-link is-rounded is-small" title="Informacion de compra Nro. '.$rows['compra_id'].'" >
									<i class="fas fa-shopping-bag fa-fw"></i>
								</a>

								<form class="FormularioAjax is-inline-block" action="'.APP_URL.'app/ajax/buyAjax.php" method="POST" autocomplete="off" >

									<input type="hidden" name="modulo_compra" value="eliminar_compra">
									<input type="hidden" name="compra_id" value="'.$rows['compra_id'].'">

									<button type="submit" class="button is-danger is-rounded is-small" title="Eliminar compra Nro. '.$rows['compra_id'].'" >
										<i class="far fa-trash-alt fa-fw"></i>
									</button>
								</form>

							</td>
						</tr>
					';
					$contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
					$tabla.='
						<tr class="has-text-centered" >
							<td colspan="7">
								<a href="'.$url.'1/" class="button is-link is-rounded is-small mt-4 mb-4">
									Haga clic acá para recargar el listado
								</a>
							</td>
						</tr>
					';
				}else{
					$tabla.='
						<tr class="has-text-centered" >
							<td colspan="7">
								No hay compras registradas en esta fecha en el sistema
							</td>
						</tr>
					';
				}
			}

			$tabla.='</tbody></table></div>';

			### Paginacion ###
			if($total>0 && $pagina<=$numeroPaginas){
				$tabla.='<p class="has-text-right">Mostrando compras <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';

				$tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7);
			}

			return $tabla;
		}

        /*----------  Controlador listar compra  ----------*/
		public function listarCompraControlador($pagina,$registros,$url,$busqueda){

			$pagina=$this->limpiarCadena($pagina);
			$registros=$this->limpiarCadena($registros);

			$url=$this->limpiarCadena($url);
			$url=APP_URL.$url."/";

			$busqueda=$this->limpiarCadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			$campos_tablas="compra.compra_id,compra.compra_codigo,compra.compra_fecha,compra.compra_hora,compra.compra_total,compra.usuario_id,compra.supplier_id,compra.caja_id,usuario.usuario_id,usuario.usuario_nombre,usuario.usuario_apellido,provedor.supplier_id,provedor.supplier_nombre,provedor.supplier_representante";

			if(isset($busqueda) && $busqueda!=""){

				$consulta_datos="SELECT $campos_tablas FROM compra INNER JOIN provedor ON compra.supplier_id=provedor.supplier_id INNER JOIN usuario ON compra.usuario_id=usuario.usuario_id WHERE (compra.compra_codigo='$busqueda') ORDER BY compra.compra_id DESC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(compra_id) FROM compra WHERE (compra.compra_codigo='$busqueda')";

			}else{

				$consulta_datos="SELECT $campos_tablas FROM compra INNER JOIN provedor ON compra.supplier_id=provedor.supplier_id INNER JOIN usuario ON compra.usuario_id=usuario.usuario_id ORDER BY compra.compra_id DESC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(compra_id) FROM compra";

			}

			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();

			$total = $this->ejecutarConsulta($consulta_total);
			$total = (int) $total->fetchColumn();

			$numeroPaginas =ceil($total/$registros);

			$tabla.='
		        <div class="table-container">
		        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
		            <thead>
		                <tr>
		                    <th class="has-text-centered">NRO.</th>
		                    <th class="has-text-centered">Codigo</th>
		                    <th class="has-text-centered">Fecha</th>
		                    <th class="has-text-centered">Proveedor</th>
		                    <th class="has-text-centered">usuario</th>
		                    <th class="has-text-centered">Total</th>
		                    <th class="has-text-centered">Opciones</th>
		                </tr>
		            </thead>
		            <tbody>
		    ';

		    if($total>=1 && $pagina<=$numeroPaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){
					$tabla.='
						<tr class="has-text-centered" >
							<td>'.$rows['compra_id'].'</td>
							<td>'.$rows['compra_codigo'].'</td>
							<td>'.date("d-m-Y", strtotime($rows['compra_fecha'])).' '.$rows['compra_hora'].'</td>
							<td>'.$this->limitarCadena($rows['supplier_nombre'],30,"...").'</td>
							<td>'.$this->limitarCadena($rows['usuario_nombre'].' '.$rows['usuario_apellido'],30,"...").'</td>
							<td>'.MONEDA_SIMBOLO.number_format($rows['compra_total']).' '.MONEDA_NOMBRE.'</td>
			                <td>

			                	<button type="button" class="button is-link is-outlined is-rounded is-small btn-sale-options" onclick="print_invoiceBuy(\''.APP_URL.'app/pdf/invoiceB.php?code='.$rows['compra_codigo'].'\')" title="Imprimir factura de compra Nro. '.$rows['compra_id'].'" >
	                                <i class="fas fa-file-invoice-dollar fa-fw"></i>
	                            </button>

                                <button type="button" class="button is-link is-outlined is-rounded is-small btn-sale-options" onclick="print_ticketBuy(\''.APP_URL.'app/pdf/ticketB.php?code='.$rows['compra_codigo'].'\')" title="Imprimir ticket de compra Nro. '.$rows['compra_id'].'" >
                                    <i class="fas fa-receipt fa-fw"></i>
                                </button>

			                    <a href="'.APP_URL.'buyDetail/'.$rows['compra_codigo'].'/" class="button is-link is-rounded is-small" title="Informacion de compra Nro. '.$rows['compra_id'].'" >
			                    	<i class="fas fa-shopping-bag fa-fw"></i>
			                    </a>

			                	<form class="FormularioAjax is-inline-block" action="'.APP_URL.'app/ajax/buyAjax.php" method="POST" autocomplete="off" >

			                		<input type="hidden" name="modulo_compra" value="eliminar_compra">
			                		<input type="hidden" name="compra_id" value="'.$rows['compra_id'].'">

			                    	<button type="submit" class="button is-danger is-rounded is-small" title="Eliminar compra Nro. '.$rows['compra_id'].'" >
			                    		<i class="far fa-trash-alt fa-fw"></i>
			                    	</button>
			                    </form>

			                </td>
						</tr>
					';
					$contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
					$tabla.='
						<tr class="has-text-centered" >
			                <td colspan="7">
			                    <a href="'.$url.'1/" class="button is-link is-rounded is-small mt-4 mb-4">
			                        Haga clic acá para recargar el listado
			                    </a>
			                </td>
			            </tr>
					';
				}else{
					$tabla.='
						<tr class="has-text-centered" >
			                <td colspan="7">
			                    No hay registros en el sistema
			                </td>
			            </tr>
					';
				}
			}

			$tabla.='</tbody></table></div>';

			### Paginacion ###
			if($total>0 && $pagina<=$numeroPaginas){
				$tabla.='<p class="has-text-right">Mostrando compras <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';

				$tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7);
			}

			return $tabla;
		}

		/*----------  Controlador eliminar compra  ----------*/
		public function eliminarCompraControlador(){

			$id=$this->limpiarCadena($_POST['compra_id']);

			# Verificando Privilegios de Usuario #
			if($_SESSION['rol']=="Empleado" || $_SESSION['rol']=="Cajero"){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Error Inesperado",
					"texto"=>"El Usuario ".$_SESSION['rol']." no esta autorizado para realizar esta acción",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}

			# Verificando compra #
		    $datos=$this->ejecutarConsulta("SELECT * FROM compra WHERE compra_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la compra en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Verificando detalles de compra #
		    $check_detalle_compra=$this->ejecutarConsulta("SELECT compra_detalle_id FROM compra_detalle WHERE compra_codigo='".$datos['compra_codigo']."'");
		    $check_detalle_compra=$check_detalle_compra->rowCount();

		    if($check_detalle_compra>0){

		        $eliminarCompraDetalle=$this->eliminarRegistro("compra_detalle","compra_codigo",$datos['compra_codigo']);

		        if($eliminarCompraDetalle->rowCount()!=$check_detalle_compra){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"No hemos podido eliminar la compra del sistema, por favor intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
		        }

		    }


		    $eliminarCompra=$this->eliminarRegistro("compra","compra_id",$id);

		    if($eliminarCompra->rowCount()==1){

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Compra eliminada",
					"texto"=>"La compra ha sido eliminada del sistema correctamente",
					"icono"=>"success"
				];

		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar la compra del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }

		    return json_encode($alerta);
		}

	}