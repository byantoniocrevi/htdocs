<?php
session_start();
ob_start();
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ejercicio 1</title>
	<link rel="stylesheet" href="./css/bootstrap.min.css" />
		<link rel="stylesheet" href="./css/style.css" />
		      <script src="./lib/js.js" type="text/javascript"></script>


	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<style type="text/css">


		body{margin:0;padding:0;}
		header, picture, img{
			width:100%;
		}
	    a:link, a:visited, a:active {
            text-decoration:none;
			color:white;
        }
		header div:nth-child(1){
			display:flex;
			justify-content:space-between;
			padding-left:5%;
			padding-right:5%;
			background-color:black;
			color:white;
			align-items:center;

		}
		header div h1{
			min-width:35%;
		}
		#btn-menu{
			display:none;
		}
		.barras{
			font-size:30px;
			cursor:pointer;
		}
		nav ul{
			display:flex;
			flex-direction:column;
			justify-content:flex-end;

		}
		nav{
			background-color:black;
			position:absolute;
			/* top:73px;  */
			top:43px;
			left:0px;
			width:100%;
			transform:translateX(-100%);
			transition:all 0.3;
		}
	
		nav li{
			list-style:none;
			margin:5%;
			margin-left:25px;
		}
		nav a{
			display:block;
			text-decoration:none;
			color:white;
			font-size:1.5em;
		}

		#btn-menu:checked ~ nav{
			transform:translateX(0%);
				z-index:3;
		}
		@media (min-width:480px){
		}
		@media (min-width:770px){
			nav{
				position:static;
				transform:translateX(0%);
			}
			nav ul{
				flex-direction:row;
			}
			.barras{
				display:none;
			}
		}
	</style>
</head>
<body>
<?php

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

}else{
	session_unset();
	header("location: index.php");

}
?>
	<header>
		<div>
			<h1><a href="index.php">TecnoPlux</a></h1>
			<input type="checkbox" id="btn-menu">
			<label for="btn-menu" class="fa fa-bars barras"></label>
			<nav>
				<ul>
				<?php 
				
				$tipo=$_SESSION["tipo"];
if($tipo==1)
{
	
				?>
					<li><a href="./nuevareparacion.php">Nueva Reparacion</a></li>
					<li><a href="./misreparaciones.php">Mis reparaciones</a></li>
					<li><a href="./misfacturas.php">Mis facturas</a></li>
					<?php
					
}else{
	
?>
		<li><a href="./misreparaciones.php">Pendiente</a></li>
		<li><a href="./misreparacionesenprogreso.php">En progreso</a></li>
		<li><a href="./misreparacionescompletado.php">Completado</a></li>
					<li><a href="./misfacturas.php">Facturas</a></li>

<?php
}
	ob_end_flush();
?>					
					
					<li><a href="./logout.php">Cerrar sesión</a></li>
				</ul>
			</nav>
		</div>
	</header>


</body>
</html>