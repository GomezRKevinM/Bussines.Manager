<?php

	namespace app\controllers;
	use app\models\mainModel;

	class searchController extends mainModel{

		/*----------  Controlador modulos de busquedas  ----------*/
		public function modulosBusquedaControlador($modulo){

			$listaModulos=['buySearch','buySearchDate','searchByItem','userSearch','cashierSearch','clientSearch','categorySearch','productSearch','saleSearch','saleSearchDate','cotizacionSearch','servicesSearchDate','servicesSearch','servicesSearchR','cotizacionSearchDate','searchDate'];

			if(in_array($modulo, $listaModulos)){
				return false;
			}else{
				return true;
			}
		}


		/*----------  Controlador iniciar busqueda  ----------*/
		public function iniciarBuscadorControlador(){

		    $url=$this->limpiarCadena($_POST['modulo_url']);
			$texto=$this->limpiarCadena($_POST['txt_buscador']);


			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			if($texto==""){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Introduce un termino de busqueda",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\- ]{1,30}",$texto)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El termino de busqueda no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			$_SESSION[$url]=$texto;



			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

		/*----------  Controlador iniciar busqueda por fecha ----------*/
		public function iniciarBuscadorFechaControlador(){

		    $url=$this->limpiarCadena($_POST['modulo_url']);
			$texto=$this->limpiarCadena($_POST['txt_buscador']);
			$texto2=$this->limpiarCadena($_POST['fecha_finish']);



			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			if($texto==""){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Introduce un termino de busqueda",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\- ]{1,30}",$texto)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El termino de busqueda no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			$_SESSION[$url]=$texto;
			$_SESSION['fechaF']=$texto2;


			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}
		/*----------  Controlador iniciar busqueda por fecha todos los servicios ----------*/
		public function iniciarBuscadorAllFechaControlador(){

		    $url=$this->limpiarCadena($_POST['modulo_url']);
			$texto=$this->limpiarCadena($_POST['txt_buscador']);
			$texto2=$this->limpiarCadena($_POST['fecha_finish']);
			$texto3=$this->limpiarCadena($_POST['table']);


			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			if($texto==""){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Introduce un termino de busqueda",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\- ]{1,30}",$texto)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El termino de busqueda no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			$_SESSION[$url]=$texto;
			$_SESSION['fechaF']=$texto2;
			$_SESSION['campo']=$texto3;

			#----verificando selector#
			if($_SESSION['campo']==="0"){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"ERROR",
					"texto"=>"No has seleccionado ningún campo",
					"icono"=>"error"
				];
				return json_encode($alerta);
			}

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}
		/*----------  Controlador iniciar busqueda por items----------*/
		public function iniciarBuscadorItemControlador(){

		    $url=$this->limpiarCadena($_POST['modulo_url']);
			$texto=$this->limpiarCadena($_POST['txt_buscador']);
			$texto2=$this->limpiarCadena($_POST['fecha_finish']);
			$texto3=$this->limpiarCadena($_POST['table']);
			$item=$this->limpiarCadena($_POST['item']);


			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			if($texto==""){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Introduce un termino de busqueda",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\- ]{1,30}",$texto)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El termino de busqueda no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			$_SESSION[$url]=$texto;
			$_SESSION['fechaF']=$texto2;
			$_SESSION['campo']=$texto3;
			$_SESSION['item']=$item;

			#----verificando selector#
			if($_SESSION['campo']==="0"){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"ERROR",
					"texto"=>"No has seleccionado ningún campo",
					"icono"=>"error"
				];
				return json_encode($alerta);
			}

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

		/*----------  Controlador eliminar busqueda  ----------*/
		public function eliminarBuscadorControlador(){

			$url=$this->limpiarCadena($_POST['modulo_url']);

			if($this->modulosBusquedaControlador($url)){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos procesar la petición en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
			}

			unset($_SESSION[$url]);

			$alerta=[
				"tipo"=>"redireccionar",
				"url"=>APP_URL.$url."/"
			];

			return json_encode($alerta);
		}

	}