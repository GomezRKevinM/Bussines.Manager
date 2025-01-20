<div class="container is-fluid mb-6">
	<h1 class="title">Servicios</h1>
	<h2 class="subtitle"><i class="bi bi-card-checklist"></i> &nbsp; Lista de Servicios Realizados</h2>
</div>
<div class="container is-fluid">

	<div class="form-rest mb-6 mt-6"></div>

	<?php
		use app\controllers\serviceController;

		$insVenta = new serviceController();

		echo $insVenta->listarVentaControlador($url[1],15,$url[0],"");

		include "./app/views/inc/print_invoice_script.php";
	?>
</div>