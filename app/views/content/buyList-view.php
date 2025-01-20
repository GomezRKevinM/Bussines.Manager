<div class="container is-fluid mb-6">
	<h1 class="title">Compras</h1>
	<h2 class="subtitle"><i class="bi bi-bar-chart-steps"></i> &nbsp; Lista de Compras</h2>
</div>
<div class="container is-fluid">

	<div class="form-rest mb-6 mt-6"></div>

	<?php
		use app\controllers\buyController;

		$insVenta = new buyController();

		echo $insVenta->listarCompraControlador($url[1],15,$url[0],"");

		include "./app/views/inc/print_invoice_script.php";
	?>
</div>