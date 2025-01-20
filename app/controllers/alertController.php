<?php 

    namespace app\controllers;
	use app\models\mainModel;

    class AlertController extends mainModel{
        public function restaurar(){
        #Almacenando Datos
        $tipo_cant=$this->limpiarCadena($_POST['metodo']);
        $cantidad=$this->limpiarCadena($_POST['cant']);
        $color_ok=$this->limpiarCadena($_POST['colorOk']);
        $color_bajo=$this->limpiarCadena($_POST['color!Ok']);

        #Restaurando datos
        $restaurar=$this->limpiarCadena($_POST['modulo_alert']);
        if($_POST['modulo_alert'] == "restaurar"){
            $alerta=[
                "tipo"=>"simple",
                "titulo"=>"Congifuración restaurada",
                "texto"=>"Su configuración ha sido restaurada exitosamente",
                "icono"=>"success"
            ];
            return json_encode($alerta);
            }
        }

        public function guardar(){

        #Almacenando Datos#
        $tipo_cant=$this->limpiarCadena($_POST['metodo']);
        $cantidad=$this->limpiarCadena($_POST['cant']);
        $color_ok=$this->limpiarCadena($_POST['colorOk']);
        $color_bajo=$this->limpiarCadena($_POST['color!Ok']);

        # Verificando campos obligatorios #
		    if($tipo_cant=="" || $cantidad==""){
                $alerta=[
                    "tipo"=>"simple",
                    "titulo"=>"Error",
                    "texto"=>"No ha llenado los campos obligatorios",
                    "icono"=>"error"
                ];
                return json_encode($alerta);
            }

            # Comprobando datos#
		    $check_style=$this->ejecutarConsulta("SELECT cantidad FROM alert WHERE cantidad='$cantidad'");
            if($check_style->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Esta cantidad ya se encuentra registrada en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		    }
            
             # Comprobando Color normal #
		     $check_colorOK=$this->ejecutarConsulta("SELECT color_cantidad_normal FROM alert WHERE color_cantidad_normal='$color_ok'");
		     if($check_colorOK->rowCount()>0){
		     	$alerta=[
			 		"tipo"=>"simple",
			 		"titulo"=>"Ocurrió un error inesperado",
			 		"texto"=>"El color para stock normal ingresado ya se encuentra registrado en el sistema",
			 		"icono"=>"error"
			 	];
			 	return json_encode($alerta);
		     }
             # Comprobando Color bajo #
		     $check_colorOff=$this->ejecutarConsulta("SELECT color_cantidad_baja FROM alert WHERE color_cantidad_bajal='$color_bajo'");
		     if($check_colorOff->rowCount()>0){
		     	$alerta=[
			 		"tipo"=>"simple",
			 		"titulo"=>"Ocurrió un error inesperado",
			 		"texto"=>"El color para stock bajo ingresado ya se encuentra registrado en el sistema",
			 		"icono"=>"error"
			 	];
			 	return json_encode($alerta);
		     }

            # `alert` SET `alert_config`='default',`tipo_cant`='num',`cantidad`='10',`color_cantidad_normal`='#12D332',`color_cantidad_baja`='#FF3333' WHERE 1#
            $query="INSERT INTO 'alert' ('config', 'tipo_cant', 'cantidad', 'color_cantidad_normal', 'color_cantidad_baja') VALUES ('usuario', 'porcentaje', '2', '#cecece', '#FF3333');";
			$sql=$this->conectar()->prepare($query);
            $sql->execute();
    }
}