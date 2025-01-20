<?php
namespace app\controllers;
use app\models\mainModel;
use PDF_Code128;

    class CodeController extends mainModel{

        public function registrarCodigo(){
            $nombre=$this->limpiarCadena($_POST['nombreCode']);

            /*------------ comprobando nombre de codigo en DB ------------*/
            $check_code=$this->ejecutarConsulta("SELECT * FROM codeBar WHERE codigo_nombre='$nombre'");
            if($check_code->rowCount()>=1){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El codigo ".$nombre." ya está registrado en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }else{
                $datos_codigo=$check_code->fetch();
            }

            /*== generando codigo de barra ==*/
            $correlativo=$this->ejecutarConsulta("SELECT codigo_id FROM codeBar");
            $correlativo=($correlativo->rowCount())+1;
            $codigo_codigo=$this->generarCodigoAleatorio(10,$correlativo);
            $datos_codigo_generado=[
                    [
                        "campo_nombre"=>"codigo_nombre",
                        "campo_marcador"=>":Nombre",
                        "campo_valor"=>$nombre
                    ],
                    [
                        "campo_nombre"=>"codigo_codigo",
                        "campo_marcador"=>":Codigo",
                        "campo_valor"=>$codigo_codigo
                    ],
                    [
                        "campo_nombre"=>"producto_id",
                        "campo_marcador"=>":Producto",
                        "campo_valor"=>0
                    ]
                    ];

        $agregar_codigo=$this->guardarDatos("codeBar",$datos_codigo_generado);

        if($agregar_codigo->rowCount()>= 1){
            $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Codigo eliminado",
					"texto"=>"El Codigo '".$nombre."' ha sido eliminado del sistema correctamente",
					"icono"=>"success"
				];
        }
		 return json_encode($alerta);
        }

		public function listarCode($pagina,$registros,$url,$busqueda){

			$pagina=$this->limpiarCadena($pagina);
			$registros=$this->limpiarCadena($registros);

			$url=$this->limpiarCadena($url);
			$url=APP_URL.$url."/";

			$busqueda=$this->limpiarCadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){

				$consulta_datos="SELECT * FROM presentacion WHERE presentacion_nombre LIKE '%$busqueda%'  ORDER BY presentacion_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(presentacion_id) FROM presentacion WHERE presentacion_nombre LIKE '%$busqueda%'";

			}else{

				$consulta_datos="SELECT * FROM codebar ORDER BY codigo_id ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(codigo_id) FROM codebar";

			}

			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();

			$total = $this->ejecutarConsulta($consulta_total);
			$total = (int) $total->fetchColumn();

            $producto="";

			$numeroPaginas =ceil($total/$registros);

			$tabla.='
		        <div class="table-container">
		        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
		            <thead>
		                <tr>
		                    <th class="has-text-centered">#</th>
		                    <th class="has-text-centered">Nombre</th>
		                    <th class="has-text-centered">Codigo</th>
		                    <th class="has-text-centered">Ver</th>
							<th class="has-text-centered">Eliminar</th>
		                </tr>
		            </thead>
		            <tbody>
		    ';
            
		    if($total>=1 && $pagina<=$numeroPaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){

                    if($rows['producto_id'==0]){
                        $producto.='
                        <a href="'.APP_URL.'codeUpdate/'.$rows['codigo_id'].'/" >
                            Asignar un producto
                        </a>';
                    }else{
                        $datos_producto="SELECT * producto WHERE producto_id='".$rows['producto_id']."'";
                        $datos_producto=$this->ejecutarConsulta($datos_producto);
                        $datos_producto = $datos_producto->fetch();

                        $producto=$rows[0]['producto_nombre'];
                    }

					$delected='	';

					$tabla.='
						<tr class="has-text-centered" >
							<td>'.$contador.'</td>
							<td>'.$rows['codigo_nombre'].'</td>
							<td><span class="codigo">'.$rows['codigo_codigo'].'</span></td>
							<td>
                                <button type="button" class="button is-link is-outlined is-rounded is-small btn-sale-options" onclick="print_invoiceCode(\''.APP_URL.'app/pdf/invoiceCode.php?code='.$rows['codigo_codigo'].'\')" title="Imprimir codigo Nro. '.$rows['codigo_id'].'" >
	                                <i class="bi bi-upc-scan"></i>
	                            </button>
							</td>
							<td>
			                	<form class="FormularioAjax" action="'.APP_URL.'app/ajax/codeAjax.php" method="POST" autocomplete="off" >

			                		<input type="hidden" name="modulo_code" value="eliminar">
			                		<input type="hidden" name="code_id" value="'.$rows['codigo_id'].'">

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
			                    No hay registros de codigo en el sistema
			                </td>
			            </tr>
					';
				}
			}

			$tabla.='</tbody></table></div>';

			### Paginacion ###
			if($total>0 && $pagina<=$numeroPaginas){
				$tabla.='<p class="has-text-right">Mostrando codigos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';

				$tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7);
			}

			return $tabla;
		}

        public function removerCodigo(){

			$id=$this->limpiarCadena($_POST['code_id']);

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

			# Verificando Codigo #
		    $datos=$this->ejecutarConsulta("SELECT * FROM codebar WHERE codigo_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el codigo en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

			$eliminarCodigo=$this->eliminarRegistro("codebar","codigo_id",$id);

			if($eliminarCodigo->rowCount()==1){
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Codigo eliminado",
					"texto"=>"El Codigo ".$datos['codigo_nombre']." ha sido eliminado del sistema correctamente",
					"icono"=>"success"
				];
			}else{
					$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"No hemos podido eliminar el Codigo '".$datos['codigo_nombre']."' del sistema, por favor intente nuevamente",
						"icono"=>"error"
					];
				}
				return json_encode($alerta);
		}	
}