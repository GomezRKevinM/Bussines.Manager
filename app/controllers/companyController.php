<?php

	namespace app\controllers;
	use app\models\mainModel;

	class companyController extends mainModel{

		/*----------  Controlador registrar empresa  ----------*/
		public function registrarEmpresaControlador(){

			# Almacenando datos#
		    $nombre=$this->limpiarCadena($_POST['empresa_nombre']);
			$nit=$this->limpiarCadena($_POST['empresa_nit']);
		    $telefono=$this->limpiarCadena($_POST['empresa_telefono']);
		    $email=$this->limpiarCadena($_POST['empresa_email']);

		    $direccion=$this->limpiarCadena($_POST['empresa_direccion']);

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

		    # Verificando campos obligatorios #
            if($nombre==""){
            	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

			# Verificando Nit #
			if($nit== ""){
				$nit="No Registra";
			}

            # Verificando integridad de los datos #
		    if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{4,85}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
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

		    if($direccion!=""){
		    	if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}",$direccion)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La DIRECCION no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

			 # Directorio de imagenes #
			 $img_dir="../views/fotos/";

			 # Comprobar si se selecciono una imagen #
			 if($_FILES['usuario_foto']['name']!="" && $_FILES['usuario_foto']['size']>0){
 
				 # Creando directorio #
				 if(!file_exists($img_dir)){
					 if(!mkdir($img_dir,0777)){
						 $alerta=[
							 "tipo"=>"simple",
							 "titulo"=>"Ocurrió un error inesperado",
							 "texto"=>"Error al crear el directorio",
							 "icono"=>"error"
						 ];
						 return json_encode($alerta);
						 exit();
					 } 
				 }
 
				 # Verificando formato de imagenes #
				 if(mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/png"){
					 $alerta=[
						 "tipo"=>"simple",
						 "titulo"=>"Ocurrió un error inesperado",
						 "texto"=>"La imagen que ha seleccionado es de un formato no permitido",
						 "icono"=>"error"
					 ];
					 return json_encode($alerta);
					 exit();
				 }
 
				 # Verificando peso de imagen #
				 if(($_FILES['usuario_foto']['size']/1024)>5120){
					 $alerta=[
						 "tipo"=>"simple",
						 "titulo"=>"Ocurrió un error inesperado",
						 "texto"=>"La imagen que ha seleccionado supera el peso permitido",
						 "icono"=>"error"
					 ];
					 return json_encode($alerta);
					 exit();
				 }
 
				 # Nombre de la foto #
				 $foto=str_ireplace(" ","_",$nombre);
				 $foto=$foto."_".rand(0,100);
 
				 # Extension de la imagen #
				 switch(mime_content_type($_FILES['usuario_foto']['tmp_name'])){
					 case 'image/jpeg':
						 $foto=$foto.".jpg";
					 break;
					 case 'image/png':
						 $foto=$foto.".png";
					 break;
				 }
 
				 chmod($img_dir,0777);
 
				 # Moviendo imagen al directorio #
				 if(!move_uploaded_file($_FILES['usuario_foto']['tmp_name'],$img_dir.$foto)){
					 $alerta=[
						 "tipo"=>"simple",
						 "titulo"=>"Ocurrió un error inesperado",
						 "texto"=>"No podemos subir la imagen al sistema en este momento",
						 "icono"=>"error"
					 ];
					 return json_encode($alerta);
					 exit();
				 }
 
			 }else{
				 $foto="";
			 }

		    # Verificando email #
		    if($email!=""){
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
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
            $empresa_datos_reg=[
				[
					"campo_nombre"=>"empresa_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"empresa_nit",
					"campo_marcador"=>":Nit",
					"campo_valor"=>$nit
				],
				[
					"campo_nombre"=>"empresa_telefono",
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
				[
					"campo_nombre"=>"empresa_email",
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				[
					"campo_nombre"=>"empresa_direccion",
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
				],
				[
					"campo_nombre"=>"logo",
					"campo_marcador"=>":Logo",
					"campo_valor"=>$foto
				]
			];

			$registrar_empresa=$this->guardarDatos("empresa",$empresa_datos_reg);

			if($registrar_empresa->rowCount()==1){
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Empresa registrada",
					"texto"=>"Los datos de la empresa se registraron con exito",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo registrar los datos de la empresa, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}


		/*----------  Controlador actualizar empresa  ----------*/
		public function actualizarEmpresaControlador(){

			$id=$this->limpiarCadena($_POST['empresa_id']);

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

			# Verificando empresa #
		    $datos=$this->ejecutarConsulta("SELECT * FROM empresa WHERE empresa_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la empresa en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Almacenando datos#
		    $nombre=$this->limpiarCadena($_POST['empresa_nombre']);
			$nit=$this->limpiarCadena($_POST['empresa_nit']);
		    $telefono=$this->limpiarCadena($_POST['empresa_telefono']);
		    $email=$this->limpiarCadena($_POST['empresa_email']);

		    $direccion=$this->limpiarCadena($_POST['empresa_direccion']);

		    # Verificando campos obligatorios #
            if($nombre==""){
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
		    if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{4,85}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
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

		    if($direccion!=""){
		    	if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}",$direccion)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La DIRECCION no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

		    # Verificando email #
		    if($email!=""){
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
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

            $empresa_datos_up=[
				[
					"campo_nombre"=>"empresa_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"empresa_nit",
					"campo_marcador"=>":Nit",
					"campo_valor"=>$nit
				],
				[
					"campo_nombre"=>"empresa_telefono",
					"campo_marcador"=>":Telefono",
					"campo_valor"=>$telefono
				],
				[
					"campo_nombre"=>"empresa_email",
					"campo_marcador"=>":Email",
					"campo_valor"=>$email
				],
				[
					"campo_nombre"=>"empresa_direccion",
					"campo_marcador"=>":Direccion",
					"campo_valor"=>$direccion
				]
			];

			$condicion=[
				"condicion_campo"=>"empresa_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("empresa",$empresa_datos_up,$condicion)){
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Empresa actualizada",
					"texto"=>"Los datos de la empresa se actualizaron correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido actualizar los datos de la empresa, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}

		/*----------  Controlador actualizar Foto empresa  ----------*/

		public function actualizarFotoEmpresaControlador(){

			$id=$this->limpiarCadena($_POST['empresa_id']);

			# Verificando Empresa #
		    $datos=$this->ejecutarConsulta("SELECT * FROM empresa WHERE empresa_id='$id'");
			if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la empresa en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

			 # Directorio de imagenes #
			 $img_dir="../views/fotos/";

			 # Comprobar si se selecciono una imagen #
			 if($_FILES['usuario_foto']['name']=="" && $_FILES['usuario_foto']['size']<=0){
				 $alerta=[
					 "tipo"=>"simple",
					 "titulo"=>"Ocurrió un error inesperado",
					 "texto"=>"No ha seleccionado una foto para la empresa",
					 "icono"=>"error"
				 ];
				 return json_encode($alerta);
				 exit();
			 }
 
			 # Creando directorio #
			 if(!file_exists($img_dir)){
				 if(!mkdir($img_dir,0777)){
					 $alerta=[
						 "tipo"=>"simple",
						 "titulo"=>"Ocurrió un error inesperado",
						 "texto"=>"Error al crear el directorio",
						 "icono"=>"error"
					 ];
					 return json_encode($alerta);
					 exit();
				 } 
			 }
 
			 # Verificando formato de imagenes #
			 if(mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/png"){
				 $alerta=[
					 "tipo"=>"simple",
					 "titulo"=>"Ocurrió un error inesperado",
					 "texto"=>"La imagen que ha seleccionado es de un formato no permitido",
					 "icono"=>"error"
				 ];
				 return json_encode($alerta);
				 exit();
			 }
 
			 # Verificando peso de imagen #
			 if(($_FILES['usuario_foto']['size']/1024)>5120){
				 $alerta=[
					 "tipo"=>"simple",
					 "titulo"=>"Ocurrió un error inesperado",
					 "texto"=>"La imagen que ha seleccionado supera el peso permitido",
					 "icono"=>"error"
				 ];
				 return json_encode($alerta);
				 exit();
			 }
 
			 # Nombre de la foto #
			 if($datos['logo']!=""){
				 $foto=explode(".", $datos['logo']);
				 $foto=$foto[0];
			 }else{
				 $foto=str_ireplace(" ","_",$datos['empresa_nombre']);
				 $foto=$foto."_".rand(0,100);
			 }
			 
 
			 # Extension de la imagen #
			 switch(mime_content_type($_FILES['usuario_foto']['tmp_name'])){
				 case 'image/jpeg':
					 $foto=$foto.".jpg";
				 break;
				 case 'image/png':
					 $foto=$foto.".png";
				 break;
			 }
 
			 chmod($img_dir,0777);
 
			 # Moviendo imagen al directorio #
			 if(!move_uploaded_file($_FILES['usuario_foto']['tmp_name'],$img_dir.$foto)){
				 $alerta=[
					 "tipo"=>"simple",
					 "titulo"=>"Ocurrió un error inesperado",
					 "texto"=>"No podemos subir la imagen al sistema en este momento",
					 "icono"=>"error"
				 ];
				 return json_encode($alerta);
				 exit();
			 }
 
			 # Eliminando imagen anterior #
			 if(is_file($img_dir.$datos['logo']) && $datos['logo']!=$foto){
				 chmod($img_dir.$datos['logo'], 0777);
				 unlink($img_dir.$datos['logo']);
			 }
 
			 $empresa_datos_up=[
				 [
					 "campo_nombre"=>"logo",
					 "campo_marcador"=>":Logo",
					 "campo_valor"=>$foto
				 ]
			 ];
 
			 $condicion=[
				 "condicion_campo"=>"empresa_id",
				 "condicion_marcador"=>":ID",
				 "condicion_valor"=>$id
			 ];

			 if($this->actualizarDatos("empresa",$empresa_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']=$foto;
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"La foto de la empresa ".$datos['empresa_nombre']." se actualizo correctamente",
					"icono"=>"success"
				];
			}else{

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"No hemos podido actualizar algunos datos de la empresa ".$datos['empresa_nombre']." , sin embargo la foto ha sido actualizada",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}

		/*----------  Controlador actualizar empresa  ----------*/
		public function listarCompanyController($pagina,$registros,$url,$busqueda){
			
			$pagina=$this->limpiarCadena($pagina);
			$registros=$this->limpiarCadena($registros);

			$url=$this->limpiarCadena($url);
			$url=APP_URL.$url."/";

			$busqueda=$this->limpiarCadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){

				$consulta_datos="SELECT * FROM empresa WHERE empresa_id LIKE '%$busqueda%' OR empresa_nombre LIKE '%$busqueda%' OR empresa_nit LIKE '%$busqueda%' ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(empresa_id) FROM empresa WHERE empresa_id LIKE '%$busqueda%' OR empresa_nombre LIKE '%$busqueda%' OR empresa_nit LIKE '%$busqueda%' ";

			}else{

				$consulta_datos="SELECT * FROM empresa ORDER BY empresa_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(empresa_id) FROM empresa ";

			}

			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();

			$total = $this->ejecutarConsulta($consulta_total);
			$total = (int) $total->fetchColumn();

			$numeroPaginas =ceil($total/$registros);

			$component='';


			if($total>=1 && $pagina<=$numeroPaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){

					$component.='
					<div class="column">
						<nav class="level is-mobile">
							<div class="level-item has-text-centered">
								<div class="box">
								<a title="Categorias Agregadas" href="'.APP_URL.'companyDetail/'.$rows['empresa_id'].'/">
									<p class="heading"><i class="bi bi-circle-fill circle_status"></i>&nbsp;'.$rows['empresa_nombre'].'</p>
									<p class="title"><img src="'.APP_URL.'app/views/fotos/'.$rows['logo'].'" alt="" class="image is-120x120"></p>
									</a>
								</div>
							</div>
						</nav>
					</div>';
				}
				return $component;
		}

		}

		public function seleccionarCompany($tipo,$id){
			if($tipo=="*"){

			$empresas="SELECT * FROM empresa";

			$empresas=$this->ejecutarConsulta($empresas);
			$datos=$empresas->fetchAll();

			$option='<option selected disabled> Elige una empresa </option>';
			$cc=1;

			foreach ($datos as $rows) {
				$option.='<option value="'.$rows['empresa_id'].'">'.$cc.' - '.$rows['empresa_nombre'].'</option>';
				$cc++;
			}
		}
		if($tipo=="Unico"){
			$empresas="SELECT * FROM empresa WHERE empresa_id = ".$id;
			$empresas= $this->ejecutarConsulta($empresas);
			$datos_empresa = $empresas->fetch();

			$option='<option value="'.$datos_empresa['empresa_id'].'" selected disabled>'.$datos_empresa['empresa_nombre'].'</option>';
		}
			return $option;
		
		}

}