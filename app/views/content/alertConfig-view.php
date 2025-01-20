<head>
    <style>
        *{
            user-select: none;
        }
        #container-numIcon{

            width: 55px;
            border-radius: 5px;
            height: auto;
            padding: 5px 5px;
            background-color: #3F51B5;
            text-align: center;
            align-items: center;
        }
        #container-numIcon > i{
            font-size: 20px;
            padding: 0;
            margin: 0;
            color: white;
            
        }
        .input{
            margin-bottom: 15px;
            width: 250px;
        }
        label{
            width: auto;
            display:block;
        }
        .color{
            width: 50px;
            border-radius: 5px;
            outline: #3F51B5;
        }
        button{
            margin-bottom: 10px;
        }
    </style>
</head>
<div class="container is-fluid mb-6">
	<h1 class="title">Configuración De Alerta</h1>
	<h2 class="subtitle"><i class="bi bi-exclamation-triangle-fill"></i> &nbsp; Configurá tu alerta de inventario</h2>
</div>

<div class="container is-fluid mb-6">
    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/alertAjax.php" method="get" autocomplete="off" >
        <input type="hidden" name="modulo_alert" value="guardar">

        <div>
            <label for="metodo">
            <i class="bi bi-info-circle-fill"></i>
                Alertar por:
                <?php echo CAMPO_OBLIGATORIO; ?>
            </label>
        <label for="metodo"><i class="bi bi-123"></i> Cantidad especifica
            <input type="radio" name="metodo" value="numero" id="tipo">
        </label>

        <label><i class="bi bi-percent"></i> Porcentaje
            <input type="radio" name="metodo" value="porcentaje" id="tipo">
        </label>
        </div>

        <label for="cant">
            <div id="container-numIcon">
                <i class="bi bi-1-square-fill"></i>
                <i class="bi bi-0-square-fill"></i>
            </div>
            <h3><?php echo CAMPO_OBLIGATORIO; ?> Notificar cuando posea menos o igual :</h3>
            
        </label>
        <input name="cant" min="1" class="input" type="number" value="10" placeholder="Cantidad para notificar" >


        <div>
            <label>
                Color de cantidad normal
            <input name="colorOk" id="colorOn" class="input color" type="color" value="#12F332">
            </label>
            <label >
                Color de cantidad baja
                <input name="color!Ok" id="colorOff" class="input color" type="color" value="#FF3333">
            </label>
            <button id="guardar" type="submit" class="button is-info is-rounded"><i class="far fa-save"></i> &nbsp; Guardar</button>
        </div>
    </form>

        <!-- <input type="hidden" name="modulo_alert" value="restaurar">
        <button type="reset" class="button is-info is-rounded"><i class="bi bi-arrow-clockwise"></i> &nbsp; Restaurar</button> -->
    
</div>
<script>
    const tipo =document.getElementById("tipo");
    const selector =document.getElementById("metodoId");
    const guardar =document.getElementById("guardar");
    const colorOK =document.getElementsById('colorOn');
    const colorOff =document.getElementsById('colorOff');
    selector.addEventListener("input",()=>{
        tipo.value=selector.value;
    })
alert(colorOK);
alert(colorOff);
</script>