<div class="container is-fluid mb-6">
	<h1 class="title">Proveedores</h1>
	<h2 class="subtitle"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de Proveedores</h2>
</div>
<div class="container is-fluid">

	<div class="form-rest mb-6 mt-6"></div>

	<?php
		use app\controllers\SupplierController;

		$insCliente = new SupplierController();

		echo $insCliente->listarSupplierControlador($url[1],15,$url[0],"");
	?>
</div>