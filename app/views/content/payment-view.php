<head>
<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/sweetalert2.min.css">
<script src="<?php echo APP_URL; ?>app/views/js/sweetalert2.all.min.js" ></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<style>
		#container_date{
			width: 100%;
			height: 100%;
			opacity: 50%;
			background-color: black;
			position: fixed;
			top: 0;
			left:0;
			right: 0;
		}
		#SelectDate label{
			color: white;
			font-weight: 700;
			font-size: 2vw;
		}
		#SelectDate input::-webkit-calendar-picker-indicator{
			filter: invert(20%);
			background-color: #3F51B5;
			border-radius: 2px;
			border-top-right-radius: 5px;
			border-bottom-right-radius: 5px;
		}
		#SelectDate input{
			width: 20vw;
			height: 3vw;
			border-radius: 5px;
			outline: none;
			border: none;
			padding: 5px 20px;
			margin: 1.4vw 0;
			color: #3F51B5;
			font-size: 1.4vw;
			font-weight: 600;
			fill:#3F51B5;
		}
		#SelectDate input:hover{
			border: 2px solid #683FB5;
		}
		#SelectDate button{
			background-color: #51B53F;
			border: none;
			outline: none;
			width: 130px;
			height: 35x;
			padding: 10px 20px;	
			border-radius: 5px;
			font-size: 1vw;
			font-weight: 400;
			color:#FFF;
			transition: all 300ms;
		}
		#SelectDate button:hover{
			width: 150px;
			background-color: #FFF;
			color: #3F51B5;
			font-weight: 900;
			cursor: pointer;
			box-shadow: 1px 1px 200px #FFF;
			border: 2px solid #683FB5;
		}
		#SelectDate{
			width: 30vw;
			height: 20vw;
			background-color: #3F51B5;
			border-radius: 5px;
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%,-50%);
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 10px 55px;
			text-align: center;
		}
		.container pb-6 pt-6{
			max-width:540px;
		}
		#tittlePayment{
			text-align: center;
			padding: 15px 0;
			background-color: #3F51B5;
			color: #FFF;
			width: 100vw;
			margin-left: 0;
			margin-bottom: 50px;
			font-size: 2rem;
			font-weight: 600;
			line-height: 1.125;
		}
		.subtittlePayment{
			font-weight: 900;
			font-size: 1.4rem;
		}
		.iconsP{
			display: inline-block;
			margin-right: 5px;

		}
		.image{
			height: 328px;
			width: 328px;
			margin-bottom: 15px;
			border-radius: 50%;
			box-shadow: #3F51B5 1px 1px 30px;
		}
		.subtitle{
			font-size: 2rem;
		}
		.IconText{
			display: flex;
			align-items: center;
		}
		div{
			user-select: none;
		}
		#ancores_container{
			display: flex;
			flex-direction: column;
			align-items: flex-start;

		}
		/* seudo Elementos Hover*/
		#wp {
            position: relative;
            display: inline-block;
            transition: opacity 200ms;
			background-color: #FFF;
        }
		#wp::after{
			position: relative;
			left:-190px;
			display:inline-block;
			opacity:0;
			content: "Escribir a WhatsApp";
			font-size: 15px;
			color: white;
			background-color: #3F51B5;
			border-radius: 10px;
			padding: 5px 7px;
			user-select: none;
			box-shadow: inset black -1px -1px 5px,inset #c3c3c3 1px 1px 5px;
		}
		#wp:hover::after{
			opacity:1;
		}
		#wp:hover{
			color:transparent;
		}
		#email {
            position: relative;
            display: inline-block;
            transition: opacity 200ms;
			background-color: #FFF;
        }
		#email::after{
			position: relative;
			left:-250px;
			display:inline-block;
			opacity:0;
			content: "Escribir un correo";
			font-size: 15px;
			color: white;
			background-color: #3F51B5;
			border-radius: 10px;
			padding: 5px 7px;
			user-select: none;
			box-shadow: inset black -1px -1px 5px,inset #c3c3c3 1px 1px 5px;
		}
		#email:hover::after{
			opacity:1;
		}
		#email:hover{
			color:transparent;
		}

		/*Boton*/
		#btnLicencia{
			background-color: #3F51B5;
			border-radius: 5px;
			padding: 10px 25px;
			color: #FFF;
			font-weight: 800;
			outline: none;
			border: none;
			font-size: 1.2rem;
			margin-left: 90px;
		}
		#btnLicencia:hover{
			cursor: pointer;
		}
	</style>
</head>
<div id="contenedor_payment">
	<div>
		<h1 id="tittlePayment">Renovar Licencia</h1>
		<div class="columns is-flex is-justify-content-center">
			<figure class="image">
				<?php
					if(is_file("./app/views/fotos/".$_SESSION['foto'])){
						echo '<img class="is-rounded" src="'.APP_URL.'app/views/fotos/'.$_SESSION['foto'].'">';
					}else{
						echo '<img class="is-rounded" src="'.APP_URL.'app/views/fotos/default.png">';
					}
				?>
			</figure>
		</div>
	<div id="infoPayment">
		<div class="columns is-flex is-justify-content-center">
			<h2 class="subtitle">¡Tu licencia necesita ser renovada <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?> para seguir administrando tu negocio!</h2>
		</div>
		</div>
		<div class="container pb-6 pt-6">
			<div class="IconText">
			<svg class="iconsP" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card-fill" viewBox="0 0 16 16">
		<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1"/>
		</svg>
			<p class="subtittlePayment">Contacta nos Para realizar la renovación de la licencia:</p>
			</div>
			<div id="ancores_container">
				<a id="wp" href="https://api.whatsapp.com/send?phone=573215970852&text=Hola,Soy20%<?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>20%y20%necesito20%renovar20%mi20%licencia." class="payment"><i class="bi bi-whatsapp"></i><span> WhatsApp: 3215970852</span></a><span id="wpafter"></span>
				<a id="email" href="mailto:kevingomezdp2212@gmail.com,ayssoluciones@gamil.com?subject=Renovar%20Licencia&body=Hola,Bussines%20Manager%20Deparment.%0D%0A%0D%0ASoy20%<?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>20%y20%necesito20%renovar20%mi20%licencia20%en20%la20%app." class="payment"><i class="bi bi-envelope-at-fill"></i><span> Email: ayssoluciones@gmail.com</span></a>
			</div>
		</div>
		<button  id="btnLicencia">Licencia Renovada</button>
	</div>
</div>
<div id="container_date"></div>
	<div id="SelectDate">
		<form action="<?php echo APP_URL.'dashboard' ?>">
			<label for="time">Seleccionar Fecha</label>
			<input type="datetime-local" name="date" id="date">
			<button onclick="obtenerComponentesFecha()" type="submit" >Enviar Datos</button>
		</form>
	</div>
<script>
	const BOTON_LICENCIA =document.getElementById("btnLicencia");
				BOTON_LICENCIA.addEventListener('click',clickear);
		function clickear(){

			async function getPassword() {
  const { value: password } = await Swal.fire({
    title: "Renovar Licencia",
    input: "password",
    inputLabel: "Password",
    inputPlaceholder: "Ingresar Contraseña",
    inputAttributes: {
      maxlength: "10",
      autocapitalize: "off",
      autocorrect: "off"
    },
    showCancelButton: false,
    confirmButtonText: "Verificar",
    cancelButtonText: "Cancel",
    showLoaderOnConfirm: true,
    allowOutsideClick: () => !Swal.isLoading()
  });
  if (password=="123") {
	// getDate();
	alert("Licencia Renovada!");
	window.location.href="dashboard";
  }else if(password!=="123"){
	swal.fire('Contraseña Incorrecta!');
  };

}

// Llamar a la función getPassword cuando sea necesario
getPassword();
		}

const div_date=document.getElementById("SelectDate");
const h1 = document.querySelector('h1');
const div_background_Date=document.getElementById("container_date");
		div_background_Date.style.display="none";
		div_date.style.display="none";

	function getDate(){
		h1.innerHTML="Seleccionar Fecha de Finalización";
		div_background_Date.style.display="block";
		div_date.style.display="flex";
		obtenerComponentesFecha()
	}
</script>
<script> 
function obtenerComponentesFecha() {
  var valorInput = document.getElementById("date").value;
  
  // Convertir el valor a un objeto Date
  var fecha = new Date(valorInput);
  
  // Obtener los componentes de la fecha
  var año = fecha.getFullYear();
  var mes = fecha.getMonth() + 1; // Los meses se indexan desde 0
  var dia = fecha.getDate();
  var hora = fecha.getHours();
  var minutos = fecha.getMinutes();
  
  // Devolver los componentes en un objeto
  return { año, mes, dia, hora, minutos };

  window
}
</script>

