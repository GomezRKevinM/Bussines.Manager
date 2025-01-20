<?php 

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $color = isset($_POST['color']) ? $_POST['color'] : '#3f51b5';
        $textColor = isset($_POST['textColor']) ? $_POST['textColor'] : '#4a4a4a';
        $colorLat = isset($_POST['colorLat']) ? $_POST['colorLat'] : '#FFF';

        $colorHEX = htmlspecialchars($color);
        $textHEX = htmlspecialchars($textColor); 
    }

    $modoOscuro ='<script>
    const body =document.querySelector("body");
    const navegador =document.getElementById("#headerNav");
    const contadorAfter=document.querySelector("#contadorAfter");
    navegador.style.backgroundColor=oscuro.nav[1];
    body.style.backgroundColor=oscuro.body[1];
    const oscuro = {
        nav:["#000000","#ffffff","#363636","#0a0a0a",],
        menLat:[fondo="#0a0a0a",fontsColor="#333",resalt="#FFF",companyBgc="rgba(0, 0, 0, .075)"],
        body:[fondo="#363636",fontsColor="#000000b3"]
    }
</script>';


    


