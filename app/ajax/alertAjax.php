<?php 

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\alertController;

if(isset($_POST['modulo_alert'])){
    $insAlert = new alertController();

    if($_POST['modulo_alert']=="restaurar"){
        echo $insAlert->restaurar();
    }

    if($_POST['modulo_alert']=="guardar"){
        echo $insAlert->guardar();
    }
}

