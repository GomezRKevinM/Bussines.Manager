<head>
	<style>
		img{
			max-height: 90px;
			max-width: 90px;
		}
		.numFloat{
			width: 15px;
			height: auto;
			background-color: white;
			border-radius: 50%;
			color: #3f51b5;
			font-weight: bold;
			position: relative;
			left: 5px;
		}
	</style>
</head>
	<div class="container is-fluid mb-6">
		<h1 class="title">Productos</h1>				
		<h2 class="subtitle"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de productos</h2>
	</div>
<div class="container is-fluid">
		<div class="columns">
			<div class="container is-fluid mb-6 column"><i class="bi bi-archive-fill"></i> Productos:
				<strong class=>
					<span id="totalBar"></span>
				</strong>
			</div>
			<div class="column">
				<button onclick="mostrarSlow();" id="pocas_unidades" class="button is-danger is-rounded is-small">Pocas unidades <span id="slowCant" class="numFloat">2</span></button>
				<button onclick="ocultarSlow();" id="all_unidades" class="button is-success is-rounded is-small">Todos</button>
			</div>
		</div>

</div>
<div id="productSlow" class="container is-fluid">
	<?php
		use app\controllers\productController; $insProducto = new productController();
		echo $insProducto->listarProductoSlowControlador($url[1],10,$url[0],"",0);
	?>		
	</div>
	<div id="productAll" class="container is-fluid">
		<?php echo $insProducto->listarProductoControlador($url[1],10,$url[0],"",0);?>
	</div>

</div>
<script>
	const containerSlow =document.getElementById("productSlow");
	const containerAll=document.getElementById("productAll");
	const pocasUnidades =document.getElementById("pocas_unidades");
	const todasUnidades =document.getElementById("all_unidades");
		containerSlow.style.display="none";
		todasUnidades.style.display="none";
		function mostrarSlow(){
			 containerSlow.style.display="inline-block";
			 containerAll.style.display="none";
			 pocasUnidades.style.display="none";
			 todasUnidades.style.display="inline-block";
		}
		function ocultarSlow(){
			containerSlow.style.display="none";
			containerAll.style.display="inline-block";
			pocasUnidades.style.display="inline-flex";
			todasUnidades.style.display="none";
		}
</script>
