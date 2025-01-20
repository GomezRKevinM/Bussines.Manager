<?php

	namespace app\controllers;
	use app\models\mainModel;

	class diseñoController extends mainModel{



		/*----------  Controlador actualizar colores  ----------*/

		public function actualizarStyleControlador(){

			$id=$this->limpiarCadena($_POST['diseño_id']);

			# Verificando config #
		    $datos=$this->ejecutarConsulta("SELECT * FROM diseño WHERE diseño_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la configuracion en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Almacenando datos#
		    $navBG=$this->limpiarCadena($_POST['navBG']);
		    $titleColor=$this->limpiarCadena($_POST['tituloColor']);



		    # Verificando campos obligatorios #
            if($navBG=="" || $titleColor==""){
            	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }


		    $diseño_datos_up=[
				[
					"campo_nombre"=>"nav_color",
					"campo_marcador"=>":NavBG",
					"campo_valor"=>$navBG
				],
				[
					"campo_nombre"=>"titulo_color",
					"campo_marcador"=>":titleColor",
					"campo_valor"=>$titleColor
				],
				[
					"campo_nombre"=>"diseño_tipo",
					"campo_marcador"=>":Stock",
					"campo_valor"=>"predeterminado"
				]
			];

			$condicion=[
				"condicion_campo"=>"diseño_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("diseño",$diseño_datos_up,$condicion)){
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Estilos actualizados",
					"texto"=>"Color de encabezado se actualizo correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido actualizar los datos de config, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}
	}