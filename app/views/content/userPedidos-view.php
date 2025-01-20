<?php
    use app\controllers\categoryController;

    $insCategoria = new categoryController();

    echo $insCategoria->listarCategoriaControlador($url[1],15,$url[0],"");
?>