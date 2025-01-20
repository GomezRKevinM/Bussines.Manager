<head>
    <style>
        .is-120x120{
            height: 120px;
            width: 120px;
            border-radius: 5px;
        }
        .list-company{
            display: flex;
            flex-wrap: wrap;
        }
        .circle_status{
            
        }
    </style>
</head>
<div class="container is-fluid mb-6">
	<h1 class="title">Empresa</h1>
	<h2 class="subtitle"><i class="bi bi-buildings-fill"></i> &nbsp; Lista de empresas</h2>
</div>

<div class="container is-fluid">

<div class="columns list-company">
    <?php 		
        use app\controllers\companyController; $insCompany = new companyController();
        echo $insCompany->listarCompanyController($url[1],10,$url[0],""); 
    ?>
</div>  
 
</div>