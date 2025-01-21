<?php

	namespace app\controllers;
	use app\models\mainModel;

	class presentacionController extends mainModel{

		/*----------  Controlador registrar presentación  ----------*/
		public function registrarPresentacionControlador(){

			# Almacenando datos#
		    $nombre=$this->limpiarCadena($_POST['presentacion_nombre']);
			$empresa=$_SESSION['company'];


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
		    if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }


		    # Verificando nombre #
		    $check_nombre=$this->ejecutarConsulta("SELECT presentacion_nombre FROM presentacion WHERE company_id=".$empresa." AND presentacion_nombre='$nombre'");
		    if($check_nombre->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE ingresado ya se encuentra registrado, por favor elija otro",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }


		    $presentacion_datos_reg=[
				[
					"campo_nombre"=>"presentacion_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"company_id",
					"campo_marcador"=>":Empresa",
					"campo_valor"=>$empresa
				]
			];

			$registrar_categoria=$this->guardarDatos("presentacion",$presentacion_datos_reg);

			if($registrar_categoria->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Presentación registrada",
					"texto"=>"La Presentación ".$nombre." se registro con exito",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo registrar la presentación, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}


		/*----------  Controlador listar presentación  ----------*/
		public function listarPresentacionControlador($pagina,$registros,$url,$busqueda){

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

				$consulta_datos="SELECT * FROM presentacion WHERE (company_id=".$empresa.") AND( presentacion_nombre LIKE '%$busqueda%') ORDER BY presentacion_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(presentacion_id) FROM presentacion WHERE (company_id=".$empresa.") AND (presentacion_nombre LIKE '%$busqueda%')";

			}else{

				$consulta_datos="SELECT * FROM presentacion WHERE company_id=".$empresa." ORDER BY presentacion_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(presentacion_id) FROM presentacion WHERE company_id=".$empresa;

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
		                    <th class="has-text-centered">#</th>
		                    <th class="has-text-centered">Nombre</th>
		                    <th class="has-text-centered">Eliminar</th>
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
							<td>'.$rows['presentacion_nombre'].'</td>
			                <td>
			                	<form class="FormularioAjax" action="'.APP_URL.'app/ajax/presentacionAjax.php" method="POST" autocomplete="off" >

			                		<input type="hidden" name="modulo_presentacion" value="eliminar">
			                		<input type="hidden" name="presentacion_id" value="'.$rows['presentacion_id'].'">

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
				$tabla.='<p class="has-text-right">Mostrando presentaciones <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';

				$tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7);
			}

			return $tabla;
		}


		/*----------  Controlador eliminar presentación  ----------*/
		public function eliminarPresentacionControlador(){

			$id=$this->limpiarCadena($_POST['presentacion_id']);
			
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

			# Verificando categoria #
		    $datos=$this->ejecutarConsulta("SELECT * FROM presentacion WHERE presentacion_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la presentación en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    $eliminarCategoria=$this->eliminarRegistro("presentacion","presentacion_id",$id);

		    if($eliminarCategoria->rowCount()==1){

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Presentación eliminada",
					"texto"=>"La presentación ".$datos['presentacion_nombre']." ha sido eliminada del sistema correctamente",
					"icono"=>"success"
				];

		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar la presentación ".$datos['presentacion_nombre']." del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }

		    return json_encode($alerta);
		}
	}