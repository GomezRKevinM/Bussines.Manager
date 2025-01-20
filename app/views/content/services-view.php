<head>
	<style>
		img{
			max-height: 90px;
			max-width: 90px;
		}
	</style>
</head>
<div>
	
</div>
<div class="container is-fluid mb-6">
	<h1 class="title">Servicios</h1>
	<h2 class="subtitle"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de Servicios</h2>
</div>
	<div class="form-rest mb-6 mt-6"></div>
<div class="container">
	<?php

use app\controllers\saddController;

		$insProducto = new saddController();

		echo $insProducto->listarProductoControlador($url[1],10,$url[0],"",0);
	?>
</div>