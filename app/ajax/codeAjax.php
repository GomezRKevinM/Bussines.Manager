<?php 

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\CodeController;

if(isset($_POST['modulo_code'])){
    $insAlert = new CodeController();

    if($_POST['modulo_code']=="registrar"){
        echo $insAlert->registrarCodigo();
    }
    if($_POST['modulo_code']=="eliminar"){
        echo $insAlert->removerCodigo();
    }
}
