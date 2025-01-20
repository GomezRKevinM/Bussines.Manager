<?php

	namespace app\controllers;
	use app\models\mainModel;

	class SupplierController extends mainModel{

		/*----------  Controlador registrar proveedor  ----------*/		
		public function registrarSupplierControlador(){

			# Almacenando datos#

		    $nombre=$this->limpiarCadena($_POST['supplier_nombre']);
		    $representante=$this->limpiarCadena($_POST['supplier_representante']);
			$empresa=$_SESSION['company'];

		    $provincia=$this->limpiarCadena($_POST['supplier_provincia']);
		    $ciudad=$this->limpiarCadena($_POST['supplier_ciudad']);
		    $direccion=$this->limpiarCadena($_POST['supplier_direccion']);

		    $telefono=$this->limpiarCadena($_POST['supplier_telefono']);
		    $email=$this->limpiarCadena($_POST['supplier_email']);

		    # Verificando campos obligatorios #
            if($nombre=="" || $provincia=="" || $ciudad=="" || $direccion==""){
            	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            # Verificando integridad de los datos #

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}",$provincia)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El ESTADO, PROVINCIA O DEPARTAMENTO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}",$ciudad)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La CIUDAD O PUEBLO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,70}",$direccion)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La DIRECCION O CALLE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($telefono!=""){
		    	if($this->verificarDatos("[0-9()+]{8,20}",$telefono)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El TELEFONO no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }


		    # Verificando email #
		    if($email!=""){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email=$this->ejecutarConsulta("SELECT supplier_email FROM provedor WHERE company_id=".$empresa." AND supplier_email='$email'");
					if($check_email->rowCount()>0){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
							"icono"=>"error"
						];
						return json_encode($alerta);
						exit();
					}
				}else{
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Ha ingresado un correo electrónico no valido",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
            }

            # Comprobando documento #
		    $check_documento=$this->ejecutarConsulta("SELECT supplier_id FROM provedor WHERE company_id=".$empresa." AND supplier_nombre='$nombre'");
		    if($check_documento->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El proveedor ingresado ya se encuentra registrado en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }


		    $cliente_datos_reg=[
				[
					"campo_nombre"=>"supplier_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"supplier_Representante",
					"campo_marcador"=>":Representante",
					"campo_valor"=>$representante
				],
				[
					"campo_nombre"=>"supplier_provincia",
					"campo_marcador"=>":Provincia",
					"campo_valor"=>$provincia
				],
				[
					"campo_nombre"=>"supplier_ciudad",
					"campo_marcador"=>":Ciudad",
					"campo_valor"=>$ciudad
				],
				[
					"campo_nombre"=>"supplier_direccion",
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
				],
				[
					"campo_nombre"=>"supplier_telefono",
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
				[
					"campo_nombre"=>"supplier_email",
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				[
					"campo_nombre"=>"company_id",
					"campo_marcador"=>":Company",
					"campo_valor"=>$empresa
				]
			];

			$registrar_cliente=$this->guardarDatos("provedor",$cliente_datos_reg);

			if($registrar_cliente->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Cliente registrado",
					"texto"=>"El cliente ".$nombre." se registro con exito",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo registrar el cliente, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}


		/*----------  Controlador listar proveedor  ----------*/
		public function listarSupplierControlador($pagina,$registros,$url,$busqueda){

			$pagina=$this->limpiarCadena($pagina);
			$registros=$this->limpiarCadena($registros);
			$empresa=$_SESSION['company'];

			$url=$this->limpiarCadena($url);
			$url=APP_URL.$url."/";

			$busqueda=$this->limpiarCadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){

				$consulta_datos="SELECT * FROM provedor WHERE (company_id=".$empresa." AND supplier_nombre LIKE '%$busqueda%' OR supplier_representante LIKE '%$busqueda%' OR supplier_email LIKE '%$busqueda%' OR supplier_provincia LIKE '%$busqueda%' OR supplier_ciudad LIKE '%$busqueda%')) ORDER BY supplier_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(supplier_id) FROM provedor WHERE ( company_id=".$empresa." AND supplier_nombre LIKE '%$busqueda%' OR supplier_representante LIKE '%$busqueda%' OR supplier_email LIKE '%$busqueda%' OR supplier_provincia LIKE '%$busqueda%' OR supplier_ciudad LIKE '%$busqueda%'))";

			}else{

				$consulta_datos="SELECT * FROM provedor WHERE company_id=".$empresa." ORDER BY supplier_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(supplier_id) FROM provedor WHERE company_id=".$empresa;

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
		                    <th class="has-text-centered">#</th>
		                    <th class="has-text-centered">Nombre</th>
		                    <th class="has-text-centered">Representante</th>
		                    <th class="has-text-centered">Email</th>
		                    <th class="has-text-centered">Actualizar</th>
		                    <th class="has-text-centered">Eliminar</th>
		                </tr>
		            </thead>
		            <tbody>
		    ';

		    if($total>=1 && $pagina<=$numeroPaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){
					$representante="";
					if($rows['supplier_representante']==""){
						$representante="No registra";
					}else{
						$representante=$rows['supplier_representante'];
					}
					$tabla.='
						<tr class="has-text-centered" >
							<td>'.$contador.'</td>
							<td>'.$rows['supplier_nombre'].'</td>
							<td>'.$representante.'</td>
							<td>'.$rows['supplier_email'].'</td>
			                <td>
			                    <a href="'.APP_URL.'supplierUpdate/'.$rows['supplier_id'].'/" class="button is-success is-rounded is-small">
			                    	<i class="fas fa-sync fa-fw"></i>
			                    </a>
			                </td>
			                <td>
			                	<form class="FormularioAjax" action="'.APP_URL.'app/ajax/supplierAjax.php" method="POST" autocomplete="off" >

			                		<input type="hidden" name="modulo_supplier" value="eliminar">
			                		<input type="hidden" name="supplier_id" value="'.$rows['supplier_id'].'">

			                    	<button type="submit" class="button is-danger is-rounded is-small">
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
			                <td colspan="6">
			                    <a href="'.$url.'1/" class="button is-link is-rounded is-small mt-4 mb-4">
			                        Haga clic acá para recargar el listado
			                    </a>
			                </td>
			            </tr>
					';
				}else{
					$tabla.='
						<tr class="has-text-centered" >
			                <td colspan="6">
			                    No hay registros en el sistema
			                </td>
			            </tr>
					';
				}
			}

			$tabla.='</tbody></table></div>';

			### Paginacion ###
			if($total>0 && $pagina<=$numeroPaginas){
				$tabla.='<p class="has-text-right">Mostrando Proveedores <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';

				$tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7);
			}

			return $tabla;
		}


		/*----------  Controlador eliminar proveedor  ----------*/
		public function eliminarSupplierControlador(){

			$id=$this->limpiarCadena($_POST['supplier_id']);

			if($id==1){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar el proveedor principal del sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			# Verificando proveedor #
		    $datos=$this->ejecutarConsulta("SELECT * FROM provedor WHERE supplier_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el proveedor en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Verificando compras #
		    $check_ventas=$this->ejecutarConsulta("SELECT supplier_id FROM compra WHERE supplier_id='$id' LIMIT 1");
		    if($check_ventas->rowCount()>0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar el proveedor del sistema ya que tiene compras asociadas",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $eliminarCliente=$this->eliminarRegistro("provedor","supplier_id",$id);

		    if($eliminarCliente->rowCount()==1){

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Proveedor eliminado",
					"texto"=>"El Proveedor ".$datos['supplier_nombre']." ha sido eliminado del sistema correctamente",
					"icono"=>"success"
				];

		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar el proveedor ".$datos['supplier_nombre']." del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }

		    return json_encode($alerta);
		}


		/*----------  Controlador actualizar proveedor  ----------*/
		public function actualizarSupplierControlador(){

			$id=$this->limpiarCadena($_POST['supplier_id']);

			# Verificando proveedor #
		    $datos=$this->ejecutarConsulta("SELECT * FROM provedor WHERE supplier_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el proveedor en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Almacenando datos#
		    $nombre=$this->limpiarCadena($_POST['supplier_nombre']);
		    $representante=$this->limpiarCadena($_POST['supplier_representante']);
			$empresa=$_SESSION['company'];

		    $provincia=$this->limpiarCadena($_POST['supplier_provincia']);
		    $ciudad=$this->limpiarCadena($_POST['supplier_ciudad']);
		    $direccion=$this->limpiarCadena($_POST['supplier_direccion']);

		    $telefono=$this->limpiarCadena($_POST['supplier_telefono']);
		    $email=$this->limpiarCadena($_POST['supplier_email']);

		    # Verificando campos obligatorios #
            if($nombre=="" || $provincia=="" || $ciudad=="" || $direccion==""){
            	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            # Verificando integridad de los datos #

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$representante)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El Representante no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}",$provincia)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El ESTADO, PROVINCIA O DEPARTAMENTO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,30}",$ciudad)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La CIUDAD O PUEBLO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,70}",$direccion)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La DIRECCION O CALLE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($telefono!=""){
		    	if($this->verificarDatos("[0-9()+]{8,20}",$telefono)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El TELEFONO no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

			# Verificando email #
		    if($email!="" && $datos['supplier_email']!=$email){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email=$this->ejecutarConsulta("SELECT supplier_email FROM provedor WHERE company_id=".$empresa." AND supplier_email='$email'");
					if($check_email->rowCount()>0){
						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
							"icono"=>"error"
						];
						return json_encode($alerta);
						exit();
					}
				}else{
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Ha ingresado un correo electrónico no valido",
						"icono"=>"error"
					];
					return json_encode($alerta);
					exit();
				}
            }

            $cliente_datos_up=[
				[
					"campo_nombre"=>"supplier_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"supplier_representante",
					"campo_marcador"=>":Representante",
					"campo_valor"=>$representante
				],
				[
					"campo_nombre"=>"supplier_provincia",
					"campo_marcador"=>":Provincia",
					"campo_valor"=>$provincia
				],
				[
					"campo_nombre"=>"supplier_ciudad",
					"campo_marcador"=>":Ciudad",
					"campo_valor"=>$ciudad
				],
				[
					"campo_nombre"=>"supplier_direccion",
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
				],
				[
					"campo_nombre"=>"supplier_telefono",
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
				[
					"campo_nombre"=>"supplier_email",
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				[
					"campo_nombre"=>"company_id",
					"campo_marcador"=>":Company",
					"campo_valor"=>$empresa
				]
			];

			$condicion=[
				"condicion_campo"=>"supplier_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("provedor",$cliente_datos_up,$condicion)){
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Proveedor actualizado",
					"texto"=>"Los datos del Proveedor ".$datos['supplier_nombre']." se actualizaron correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido actualizar los datos del proveedor ".$datos['supplier_nombre'].", por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}

	}