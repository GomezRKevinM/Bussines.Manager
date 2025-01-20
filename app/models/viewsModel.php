<?php
	
	namespace app\models;

	class viewsModel{

		/*---------- Modelo obtener vista ----------*/
		protected function obtenerVistasModelo($vista){

			$listaBlanca=["dashboard","codeNew","codeList","cashierNew","cashierList","cashierSearch","cashierUpdate","userNew","userList","userUpdate","userSearch","userPhoto","clientNew","clientList","clientListStar","clientSearch","clientUpdate","clientDetail","callNew","callList","callUpdate","visitNew","visitList","visitUpdate","categoryNew","categoryList","categorySearch","categoryUpdate","presentacionNew","presentacionList","presentacionUpdate","productNew","productList","productSearch","productUpdate","productPhoto","productCategory","companyNew","companyList","companyUpdate","companyUpdatePhoto","companyDetail","saleNew","saleList","saleSearch","saleSearchDate","saleDetail","alertConfig","styleConfig","cotizacionNew","cotizacionList","cotizacionDetail","cotizacionSearch","cotizacionSearchDate","services","addService","servicesNew","servicesList","servicesDetail","servicesSearch","servicesSearchR","servicePhoto","serviceUpdate","servicesSearchDate","searchDate","searchByItem","buyNew","buyList","buyDetail","buyXnew","buySearch","buySearchDate","supplierNew","supplierList","supplierSearch","supplierUpdate","logOut","productListSlow","notificacion",];

			if(in_array($vista, $listaBlanca)){
				if(is_file("./app/views/content/".$vista."-view.php")){
					$contenido="./app/views/content/".$vista."-view.php";
				}else{
					$contenido="404";
				}
			}elseif($vista=="login" || $vista=="index"){
				$contenido="login";
			}elseif($vista=="payment"){
				$contenido="payment";
			}elseif($vista=="userPedido"){
				$contenido="userPedido";
			}
			else{
				$contenido="404";
			}
			return $contenido;
		}

	}