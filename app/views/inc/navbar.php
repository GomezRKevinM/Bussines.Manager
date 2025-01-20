<?php include_once "app/controllers/styleController.php";?>
<?php $datos=$insLogin->seleccionarDatos("Normal","diseño","*",1);

if($datos->rowCount()==1){
    $datos=$datos->fetch(); ?>
<head>
    <style>
        #headerNav{
            background-color: <?php echo $datos['nav_color']; ?>;
        }
        #btn-menu:hover{
            background-color: white;
            color: <?php echo $datos['nav_color'] ?>;
            border-radius: 5px;
            scale: 0.8;
        }
        .fa-power-off{
            padding: 2px;
            border-radius: 50%;
        }
        .fa-power-off:hover{
            background-color: white;
            color: <?php echo $datos['nav_color'] ?>;
        }
            #fechaYHora{
                user-select: none;
                cursor:default;
            }
            #contador{
                width: 40%;
                height: 25px;
                padding: 1px 7px;
                background-color: white;
                color: #3F51B5;
                border-radius: 5px;
                user-select: none;
                text-align: center;
                display: flex;
                align-items: center;
                transition: all 300ms;
                position: absolute;
                top: 10px;
                left:5%;
                border: 2px solid #683FB5;
                z-index:9;
                font-size: 15px;
            }
            #contador:hover::before{
                visibility: visible;
            }
            #contador::before{
                visibility: hidden;
                content: "Días restantes";
                margin-right: 5px;
                position: absolute;
                top: 15px;
                left: 25px;
                border: 2px solid #683FB5;
                border-radius: 20px;
                padding:0 5px;
                height: 30px;
                width: auto;
                display: flex;
                align-items: center;
                background-color: #3F51B5;
                color: white;
            }
            #contadorAfter{
                background-color: <?php if(isset($colorHEX)){echo $colorHEX;}else{echo '#3f51b5';}  ?>;
                height: 45px;
                width: 46%;
                position: absolute;
                top: 0;
                left:5%;
                z-index:10;
                color:transparent;
                user-select: none;
            }
            @media (max-width:1024px) {
                #contador{
                    visibility: hidden;
                }
                #contadorAfter{
                    visibility: hidden;
                }
            }.full-width{
                margin-bottom: 0;
            }
    </style>
</head><?php }?>
<div class="full-width navBar">
    <div id="headerNav" class="full-width navBar-options">
        <i class="fas fa-exchange-alt fa-fw" id="btn-menu"></i> 
        <?php 
            if($_SESSION['usuario']=="Administrador"){
                echo"";
            }else{
                echo '<div id="contadorAfter"></div>';
                echo '<div id="contador"></div>';
            }
        ?>
        <nav class="navBar-options-list">
            <ul class="list-unstyle">
                <li><div id="fechaYHora"></div></li>
                <li class="text-condensedLight noLink" >
                    <a class="btn-exit" href="<?php echo APP_URL."logOut/"; ?>" >
                        <i class="fas fa-power-off"></i>
                    </a>
                </li>
                <li class="text-condensedLight noLink" >
                    <small><?php echo $_SESSION['usuario']; ?></small>
                </li>
                <li class="noLink">
                    <?php
                        if(is_file("./app/views/fotos/".$_SESSION['foto'])){
                            echo '<img class="is-rounded img-responsive" src="'.APP_URL.'app/views/fotos/'.$_SESSION['foto'].'">';
                        }else{
                            echo '<img class="is-rounded img-responsive" src="'.APP_URL.'app/views/fotos/default.png">';
                        }
                    ?>
                </li>
            </ul>
        </nav>
    </div>
</div>
<script>
    function mostrarFechaYHora() {
    var diasSemana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
    var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    
    var fecha = new Date();
    var diaSemana = diasSemana[fecha.getDay()];
    var dia = fecha.getDate();
    var mes = meses[fecha.getMonth()];
    var hora = fecha.getHours();
    var minutos = fecha.getMinutes();
    var segundos = fecha.getSeconds();

        if(hora>12){
            var Horaformato = hora - 12;
            var fechaHora = diaSemana + " " + dia + " de " + mes + " " +" "+ Horaformato + ":" + minutos + ":" + segundos + " Pm";
        }else if(hora == 12){
            var fechaHora = diaSemana + " " + dia + " de " + mes + " " +" "+ hora + ":" + minutos + ":" + segundos + " Pm"; 
        }else if(hora==0){
            var Horaformato = 12;
            var fechaHora = diaSemana + " " + dia + " de " + mes + " " +" "+ Horaformato + ":" + minutos + ":" + segundos + " Am";
        }else{
            var fechaHora = diaSemana + " " + dia + " de " + mes + " " +" "+ hora + ":" + minutos + ":" + segundos + " Am";
        }
    // Formatear la fecha y la hora

    // Mostrar la fecha y la hora en un elemento HTML con el id "fecha-hora"
    document.getElementById("fechaYHora").textContent = fechaHora;
}

// Llamar a la función para mostrar la fecha y la hora al cargar la página
window.onload = function() {
    mostrarFechaYHora(); // Llamar por primera vez
    setInterval(mostrarFechaYHora, 1000); // Actualizar cada segundo
};
</script>