<div class="container is-fluid mb-6">
	<h1 class="title">Presentación</h1>
	<h2 class="subtitle"><i class="bi bi-exclude"></i> &nbsp; Lista de Presentaciones</h2>
</div>
<div class="container is-fluid">

	<div class="form-rest mb-6 mt-6"></div>

	<?php
		use app\controllers\presentacionController;

		$insCategoria = new presentacionController();

		echo $insCategoria->listarPresentacionControlador($url[1],15,$url[0],"");
	?>
</div>