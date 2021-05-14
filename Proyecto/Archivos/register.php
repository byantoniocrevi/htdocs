<?php
session_start();
?>

<html>
<head>
	<title>TecnoPlux - Registro</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="keywords" content="Tecnoplux">
	<script>
	</script>
	<link href="css/font-awesome.css" rel="stylesheet">
	<link href="css/login.css" rel='stylesheet' type='text/css' />

	<script src="./lib/js.js" type="text/javascript"></script>
	<link rel="shortcut icon" href="images/favicon.png" />
	<link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=devanagari,latin-ext" rel="stylesheet">
</head>
<body>
<?php
require("./lib/conexion.php");
require("./lib/user.php");
?>
<?php

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: home.php");
  exit;
}
    $nombre="";
    $email="";
    $password="";
    $password2="";

if (isset($_POST['registro'])) {
	$usuario = new usuario();
	$nombre = htmlspecialchars(trim($_POST['nombre']));
	$email = htmlspecialchars(trim($_POST['email']));
	$password = htmlspecialchars(trim($_POST['password']));
	$password2 = htmlspecialchars(trim($_POST['password2']));
	$resultado=$usuario->checkform($nombre,$email,$password,$password2);
	if($resultado=="ok"){
		$resultado=$usuario->comprobaremail($email);
		if($resultado=="ok"){
			$resultado=$usuario->registrar($nombre,$email,$password);
			echo "<p style='background-color:white;color:green'>Usuario " . $email . " registrado con éxito</p>";

		}else{
			echo $resultado;
		}	
	}else{
		echo $resultado;
	}
	
}
	  ?>


	<h1>TecnoPlux Registro </h1>
	<div class="w3ls-login box box--big">
		<form  method="post"  name="formulario1">
			<div class="agile-field-txt">
				<label><i class="fa fa-user"></i> Nombre </label>
				<input type="text" name="nombre" placeholder="Introuce el nombre" required="" />
				<label id="labelnombre"></label>
			</div>
			<div class="agile-field-txt">
				<label><i class="fa fa-user" ></i> Correo </label>
				<input type="text" name="email" placeholder="Introduce el correo" required="" />
				<label id="labelmail" ></label>
			</div>
			<div class="agile-field-txt">
				<label><i class="fa fa-envelope"></i> Contraseña </label>
				<input type="password" name="password" placeholder="Introduce la contraseña " required="" id="password1" />
				<i class="fa fa-envelope"></i></label>
				<label id="labelpass1" ></label>
				<input type="password" name="password2" placeholder="Repite la contraseña " required="" id="password2" />
				<label id="labelpass2" ></label>

			</div>
			<div class="w3ls-bot">
				<div class="switch-agileits">
					<label class="switch">
						<input type="checkbox" onclick="passwordvisible()">
						<span class="slider round"></span>
						Ver contraseña
					</label>
				</div>
				<div class="form-end">
					<input type="submit" name="registro" value="registrar" onclick="validarformregister()">
					<hr>
					<a style="color:white;"href="./index.php">Volver</a>
					<br>
					
				</div>
				

			</div>
		</form>
	</div>
	<div class="copy-wthree">
		<p>© 2021 TecnoPlux All Rights Reserved
		</p>
	</div>
</body>
</html>