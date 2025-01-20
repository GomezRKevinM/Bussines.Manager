<?php

	namespace app\controllers;
	use app\models\mainModel;

	class clientController extends mainModel{

		/*----------  Controlador registrar cliente  ----------*/
		public function registrarClienteControlador(){

			# Almacenando datos#
		    $tipo_documento=$this->limpiarCadena($_POST['cliente_tipo_documento']);
		    $numero_documento=$this->limpiarCadena($_POST['cliente_numero_documento']);
		    $nombre=$this->limpiarCadena($_POST['cliente_nombre']);
		    $apellido=$this->limpiarCadena($_POST['cliente_apellido']);

		    $provincia=$this->limpiarCadena($_POST['cliente_provincia']);
		    $ciudad=$this->limpiarCadena($_POST['cliente_ciudad']);
		    $direccion=$this->limpiarCadena($_POST['cliente_direccion']);

		    $telefono=$this->limpiarCadena($_POST['cliente_telefono']);
		    $email=$this->limpiarCadena($_POST['cliente_email']);
			$empresa=$_SESSION['company'];

		    # Verificando campos obligatorios #
            if($numero_documento=="" || $nombre=="" || $apellido=="" || $provincia=="" || $ciudad=="" || $direccion==""){
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
		    if($this->verificarDatos("[a-zA-Z0-9-]{7,30}",$numero_documento)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NUMERO DE DOCUMENTO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

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

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El APELLIDO no coincide con el formato solicitado",
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

		    # Comprobando tipo de documento #
			if(!in_array($tipo_documento, DOCUMENTOS_USUARIOS)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El TIPO DE DOCUMENTO no es correcto o no lo ha seleccionado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

		    # Verificando email #
		    if($email!=""){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email=$this->ejecutarConsulta("SELECT cliente_email FROM cliente WHERE company_id=".$empresa." AND cliente_email='$email'");
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
		    $check_documento=$this->ejecutarConsulta("SELECT cliente_id FROM cliente WHERE company_id=".$empresa." AND cliente_tipo_documento='$tipo_documento' AND cliente_numero_documento='$numero_documento'");
		    if($check_documento->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El número y tipo de documento ingresado ya se encuentra registrado en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }


		    $cliente_datos_reg=[
				[
					"campo_nombre"=>"cliente_tipo_documento",
					"campo_marcador"=>":TipoDocumento",
					"campo_valor"=>$tipo_documento
				],
				[
					"campo_nombre"=>"cliente_numero_documento",
					"campo_marcador"=>":NumeroDocumento",
					"campo_valor"=>$numero_documento
				],
				[
					"campo_nombre"=>"cliente_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"cliente_apellido",
					"campo_marcador"=>":Apellido",
					"campo_valor"=>$apellido
				],
				[
					"campo_nombre"=>"cliente_provincia",
					"campo_marcador"=>":Provincia",
					"campo_valor"=>$provincia
				],
				[
					"campo_nombre"=>"cliente_ciudad",
					"campo_marcador"=>":Ciudad",
					"campo_valor"=>$ciudad
				],
				[
					"campo_nombre"=>"cliente_direccion",
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
				],
				[
					"campo_nombre"=>"cliente_telefono",
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
				[
					"campo_nombre"=>"cliente_email",
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				[
					"campo_nombre"=>"company_id",
					"campo_marcador"=>":Empresa",
					"campo_valor"=>$empresa
				]
			];

			$registrar_cliente=$this->guardarDatos("cliente",$cliente_datos_reg);

			if($registrar_cliente->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Cliente registrado",
					"texto"=>"El cliente ".$nombre." ".$apellido." se registro con exito",
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


		/*----------  Controlador listar cliente  ----------*/
		public function listarClienteControlador($pagina,$registros,$url,$busqueda){

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

				$consulta_datos="SELECT * FROM cliente WHERE company_id=".$empresa." AND (cliente_tipo_documento LIKE '%$busqueda%' OR cliente_numero_documento LIKE '%$busqueda%' OR cliente_nombre LIKE '%$busqueda%' OR cliente_apellido LIKE '%$busqueda%' OR cliente_email LIKE '%$busqueda%' OR cliente_provincia LIKE '%$busqueda%' OR cliente_ciudad LIKE '%$busqueda%') ORDER BY cliente_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(cliente_id) FROM cliente WHERE (company_id=".$empresa.") AND (cliente_tipo_documento LIKE '%$busqueda%' OR cliente_numero_documento LIKE '%$busqueda%' OR cliente_nombre LIKE '%$busqueda%' OR cliente_apellido LIKE '%$busqueda%' OR cliente_email LIKE '%$busqueda%' OR cliente_provincia LIKE '%$busqueda%' OR cliente_ciudad LIKE '%$busqueda%')";

			}else{

				$consulta_datos="SELECT * FROM cliente WHERE company_id=".$empresa." ORDER BY cliente_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(cliente_id) FROM cliente WHERE company_id=".$empresa."";

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
		                <tr class="is-primary">
		                    <th class="has-text-centered has-text-white">#</th>
		                    <th class="has-text-centered has-text-white">Documento</th>
		                    <th class="has-text-centered has-text-white">Nombre</th>
		                    <th class="has-text-centered has-text-white">Email</th>
		                    <th class="has-text-centered has-text-white">Actualizar</th>
		                    <th class="has-text-centered has-text-white">Eliminar</th>
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
							<td>'.$contador.'</td>
							<td>'.$rows['cliente_tipo_documento'].': '.$rows['cliente_numero_documento'].'</td>
							<td><a href="'.APP_URL.'clientDetail/'.$rows['cliente_id'].'/" >'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].'</a></td>
							<td>'.$rows['cliente_email'].'</td>
			                <td>
			                    <a href="'.APP_URL.'clientUpdate/'.$rows['cliente_id'].'/" class="button is-success is-rounded is-small">
			                    	<i class="fas fa-sync fa-fw"></i>
			                    </a>
			                </td>
			                <td>
			                	<form class="FormularioAjax" action="'.APP_URL.'app/ajax/clienteAjax.php" method="POST" autocomplete="off" >

			                		<input type="hidden" name="modulo_cliente" value="eliminar">
			                		<input type="hidden" name="cliente_id" value="'.$rows['cliente_id'].'">

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
				$tabla.='<p class="has-text-right">Mostrando clientes <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';

				$tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7);
			}

			return $tabla;
		}

		/*----------  Controlador listar llamadas  ----------*/
		public function listarLlamadaClientControlador($pagina,$registros,$url,$busqueda){

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

				$consulta_datos="SELECT * FROM llamada  WHERE company_id=".$empresa." AND (llamada.cliente_id='$busqueda') ORDER BY llamada.llamada_id DESC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT('llamada_id') FROM llamada WHERE company_id=".$empresa." AND cliente_id='$busqueda'";

				$consultarVenta="SELECT cliente_id FROM llamada WHERE company_id=".$empresa." AND cliente_id='$busqueda'";
			}else{

				$consulta_datos="SELECT * FROM llamada WHERE company_id=".$empresa." ORDER BY llamada_id ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(cliente_id) FROM llamada WHERE company_id=".$empresa."";

				$consultarVenta="SELECT cliente_id FROM llamada WHERE company_id=".$empresa." AND cliente_id='$busqueda'";
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
							<th class="has-text-centered is-primary">#</th>
							<th class="has-text-centered is-primary">Fecha</th>
							<th class="has-text-centered is-primary">Hora</th>
							<th class="has-text-centered is-primary">Cliente</th>
							<th class="has-text-centered is-primary">Cel</th>
							<th class="has-text-centered is-primary">Estado</th>
							<th class="has-text-centered is-primary">Actualizar</th>
							<th class="has-text-centered is-primary">Eliminar</th>
						</tr>
					</thead>
					<tbody>
			';
			
			if($total>=1 && $pagina<=$numeroPaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){

					$consulta_datos_cliente="SELECT * FROM cliente WHERE cliente_id=".$rows['cliente_id'];

						$cliente = $this->ejecutarConsulta($consulta_datos_cliente);
						$cliente = $cliente->fetchAll();
						$nombre = $cliente[0]['cliente_nombre'];
						$apellido = $cliente[0]['cliente_apellido'];
						$telefono = $cliente[0]['cliente_telefono'];

					$consultarVenta="SELECT cliente_id FROM llamada WHERE cliente_id=".$rows['cliente_id'];

								$ventasTotal = $this->ejecutarConsulta($consultarVenta);
								$ventasTotal = (int) $ventasTotal->fetchAll();
					$tabla.='
						<tr class="has-text-centered" >
							<td>'.$contador.'</td>
							<td>'.$rows['llamada_fecha'].'</td>
							<td>'.$rows['llamada_hora'].'</td>
							<td>'.$nombre.' '.$apellido.'</td>
							<td>'.$telefono.'</td>
							<td>'.$rows['llamada_estado'].'</td>
							<td>
								<a href="'.APP_URL.'callUpdate/'.$rows['llamada_id'].'/" class="button is-success is-rounded is-small">
									<i class="fas fa-sync fa-fw"></i>
								</a>
							</td>
							<td>
								<form class="FormularioAjax" action="'.APP_URL.'app/ajax/clienteAjax.php" method="POST" autocomplete="off" >

									<input type="hidden" name="modulo_cliente" value="eliminar_llamada">
									<input type="hidden" name="cliente_id" value="'.$rows['cliente_id'].'">
									<input type="hidden" name="llamada" value="'.$rows['llamada_id'].'">

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
								No hay llamadas registradas en el sistema
							</td>
						</tr>
					';
				}
			}

			$tabla.='<tr><th class="is-black has-text-centered" colspan="8">LLAMADAS REALIZADAS <span class="num_container">'.'1'.'<span></th></tr></tbody></table></div>';


			return $tabla;
		}

		/*----------  Controlador listar visita cliente  ----------*/
		public function listarVisitClientControlador($pagina,$registros,$url,$busqueda){

			$pagina=$this->limpiarCadena($pagina);
			$registros=$this->limpiarCadena($registros);

			$url=$this->limpiarCadena($url);
			$url=APP_URL.$url."/";

			$busqueda=$this->limpiarCadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){
				$consulta_datos="SELECT * FROM visitas  WHERE (visitas.cliente_id='$busqueda') ORDER BY visitas.visita_id DESC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT('visita_id') FROM visitas WHERE cliente_id='$busqueda'";

				$consultarVenta="SELECT cliente_id FROM visitas WHERE cliente_id='$busqueda'";
			}else{

				$consulta_datos="SELECT * FROM visitas  ORDER BY visita_fecha ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(cliente_id) FROM visitas";

				$consultarVenta="SELECT cliente_id FROM visitas";
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
							<th class="has-text-centered is-primary">#</th>
							<th class="has-text-centered is-primary">Fecha</th>
							<th class="has-text-centered is-primary">Hora</th>
							<th class="has-text-centered is-primary">Cliente</th>
							<th class="has-text-centered is-primary">Cel</th>
							<th class="has-text-centered is-primary">Dirección</th>
							<th class="has-text-centered is-primary">Estado</th>
							<th class="has-text-centered is-primary">Actualizar</th>
							<th class="has-text-centered is-primary">Eliminar</th>
						</tr>
					</thead>
					<tbody>
			';
			
			if($total>=1 && $pagina<=$numeroPaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){

					$consulta_datos_cliente="SELECT * FROM cliente WHERE cliente_id=".$rows['cliente_id'];

						$cliente = $this->ejecutarConsulta($consulta_datos_cliente);
						$cliente = $cliente->fetchAll();
						$nombre = $cliente[0]['cliente_nombre'];
						$apellido = $cliente[0]['cliente_apellido'];
						$telefono = $cliente[0]['cliente_telefono'];
						$provincia = $cliente[0]['cliente_provincia'];
						$ciudad = $cliente[0]['cliente_ciudad'];
						$direccion = $cliente[0]['cliente_direccion'];

						$direccion = "$provincia, $ciudad $direccion";

					$consultarVenta="SELECT cliente_id FROM llamada WHERE cliente_id=".$rows['cliente_id'];

								$ventasTotal = $this->ejecutarConsulta($consultarVenta);
								$ventasTotal = (int) $ventasTotal->fetchAll();
					$tabla.='
						<tr class="has-text-centered" >
							<td>'.$contador.'</td>
							<td>'.$rows['visita_fecha'].'</td>
							<td>'.$rows['visita_hora'].'</td>
							<td>'.$nombre.' '.$apellido.'</td>
							<td>'.$telefono.'</td>
							<td>'.$rows['visita_direccion'].'</td>
							<td>'.$rows['visita_estado'].'</td>
							<td>
								<a href="'.APP_URL.'visitUpdate/'.$rows['visita_id'].'/" class="button is-success is-rounded is-small">
									<i class="fas fa-sync fa-fw"></i>
								</a>
							</td>
							<td>
								<form class="FormularioAjax" action="'.APP_URL.'app/ajax/clienteAjax.php" method="POST" autocomplete="off" >

									<input type="hidden" name="modulo_cliente" value="eliminar_visita">
									<input type="hidden" name="cliente_id" value="'.$rows['cliente_id'].'">
									<input type="hidden" name="visita" value="'.$rows['visita_id'].'">

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
								No hay visitas registradas en el sistema
							</td>
						</tr>
					';
				}
			}

			$tabla.='<tr><th class="is-black has-text-centered" colspan="9">VISITAS REALIZADAS <span class="num_container">'.'1'.'<span></th></tr></tbody></table></div>';
			
			return $tabla;
		}


		/*----------  Controlador eliminar cliente  ----------*/
		public function eliminarClienteControlador(){

			$id=$this->limpiarCadena($_POST['cliente_id']);

			if($id==1){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar el cliente principal del sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			# Verificando Usuario #
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
			
			# Verificando cliente #
		    $datos=$this->ejecutarConsulta("SELECT * FROM cliente WHERE cliente_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el cliente en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Verificando ventas #
		    $check_ventas=$this->ejecutarConsulta("SELECT cliente_id FROM venta WHERE cliente_id='$id' LIMIT 1");
		    if($check_ventas->rowCount()>0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar el cliente del sistema ya que tiene ventas asociadas",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $eliminarCliente=$this->eliminarRegistro("cliente","cliente_id",$id);

		    if($eliminarCliente->rowCount()==1){

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Cliente eliminado",
					"texto"=>"El cliente ".$datos['cliente_nombre']." ".$datos['cliente_apellido']." ha sido eliminado del sistema correctamente",
					"icono"=>"success"
				];

		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar el cliente ".$datos['cliente_nombre']." ".$datos['cliente_apellido']." del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }

		    return json_encode($alerta);
		}


		/*----------  Controlador actualizar cliente  ----------*/
		public function actualizarClienteControlador(){

			$id=$this->limpiarCadena($_POST['cliente_id']);
			$empresa=$_SESSION['company'];

			# Verificando cliente #
		    $datos=$this->ejecutarConsulta("SELECT * FROM cliente WHERE cliente_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el cliente en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Almacenando datos#
		    $tipo_documento=$this->limpiarCadena($_POST['cliente_tipo_documento']);
		    $numero_documento=$this->limpiarCadena($_POST['cliente_numero_documento']);
		    $nombre=$this->limpiarCadena($_POST['cliente_nombre']);
		    $apellido=$this->limpiarCadena($_POST['cliente_apellido']);

		    $provincia=$this->limpiarCadena($_POST['cliente_provincia']);
		    $ciudad=$this->limpiarCadena($_POST['cliente_ciudad']);
		    $direccion=$this->limpiarCadena($_POST['cliente_direccion']);

		    $telefono=$this->limpiarCadena($_POST['cliente_telefono']);
		    $email=$this->limpiarCadena($_POST['cliente_email']);

		    # Verificando campos obligatorios #
            if($numero_documento=="" || $nombre=="" || $apellido=="" || $provincia=="" || $ciudad=="" || $direccion==""){
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
		    if($this->verificarDatos("[a-zA-Z0-9-]{7,30}",$numero_documento)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NUMERO DE DOCUMENTO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

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

		    if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El APELLIDO no coincide con el formato solicitado",
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

		    # Comprobando tipo de documento #
			if(!in_array($tipo_documento, DOCUMENTOS_USUARIOS)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El TIPO DE DOCUMENTO no es correcto",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			# Verificando email #
		    if($email!="" && $datos['cliente_email']!=$email){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$check_email=$this->ejecutarConsulta("SELECT cliente_email FROM cliente WHERE company_id=".$empresa." AND cliente_email='$email'");
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
            if($tipo_documento!=$datos['cliente_tipo_documento'] || $numero_documento!=$datos['cliente_numero_documento']){
			    $check_documento=$this->ejecutarConsulta("SELECT cliente_id FROM cliente WHERE company_id=".$empresa." AND cliente_tipo_documento='$tipo_documento' AND cliente_numero_documento='$numero_documento'");
			    if($check_documento->rowCount()>0){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El número y tipo de documento ingresado ya se encuentra registrado en el sistema",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
            }

            $cliente_datos_up=[
				[
					"campo_nombre"=>"cliente_tipo_documento",
					"campo_marcador"=>":TipoDocumento",
					"campo_valor"=>$tipo_documento
				],
				[
					"campo_nombre"=>"cliente_numero_documento",
					"campo_marcador"=>":NumeroDocumento",
					"campo_valor"=>$numero_documento
				],
				[
					"campo_nombre"=>"cliente_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"cliente_apellido",
					"campo_marcador"=>":Apellido",
					"campo_valor"=>$apellido
				],
				[
					"campo_nombre"=>"cliente_provincia",
					"campo_marcador"=>":Provincia",
					"campo_valor"=>$provincia
				],
				[
					"campo_nombre"=>"cliente_ciudad",
					"campo_marcador"=>":Ciudad",
					"campo_valor"=>$ciudad
				],
				[
					"campo_nombre"=>"cliente_direccion",
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
				],
				[
					"campo_nombre"=>"cliente_telefono",
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
				[
					"campo_nombre"=>"cliente_email",
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				[
					"campo_nombre"=>"company_id",
					"campo_marcador"=>":Empresa",
					"campo_valor"=>$empresa
				]
			];

			$condicion=[
				"condicion_campo"=>"cliente_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("cliente",$cliente_datos_up,$condicion)){
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Cliente actualizado",
					"texto"=>"Los datos del cliente ".$datos['cliente_nombre']." ".$datos['cliente_apellido']." se actualizaron correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido actualizar los datos del cliente ".$datos['cliente_nombre']." ".$datos['cliente_apellido'].", por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}

	}