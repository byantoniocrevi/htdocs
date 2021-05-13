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
//compruebo si hay sesión, si hay sesión entonces no hace falta loguearse por lo que no entramos aquí.
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: home.php");
  exit;
}

 if (isset($_POST['login'])) {

 	$usuario = new Usuario();
 	$email = htmlspecialchars(trim($_POST['email']));
 	$contraseña = htmlspecialchars(trim($_POST['contraseña']));
 	$usuario = new Usuario();


 	$resultado=$usuario->checkcamposlogin($email,$contraseña);
 	if($resultado==""){
 		$resultado=$usuario->checkloginemail($email);
 		if($resultado==""){
 			$resultado=$usuario->loginusuario($email,$contraseña);
 			if($resultado==""){
 	
		
				
			$tipo=$usuario->comprobarcargo($email);

			$id=$usuario->getdatosuser($email);

			$id=$usuario->get_id();
			$nombre=$usuario->get_nombre();

                             $_SESSION["loggedin"] = true;
                             $_SESSION["email"] = $email;
							 $_SESSION["contraseña"] = $contraseña;
							 $_SESSION["nombre"] = $nombre;
							 $_SESSION["tipo"] = $tipo;
							 $_SESSION["id"] = $id;
						//	session_unset();
 			 				 header("location: home.php");
							// ob_end_flush();
 			}else{
 				echo $resultado;
 			}
 		}else{
			echo $resultado;
 		}
 	}else{
 		echo $resultado;
 	}

 }

	  ?>
	<h1>TecnoPlux Login </h1>
	<div class="w3ls-login box box--big">
		<form  method="post" name="login">

			<div class="agile-field-txt">
				<label><i class="fa fa-user" ></i> Correo </label>
				<input type="text" name="email" placeholder="Introduce el correo" required="" />
				<label id="labelmail"></label>
			</div>
			<div class="agile-field-txt">
				<label><i class="fa fa-envelope"></i> Contraseña </label>
				<input type="password" name="contraseña" placeholder="Introduce la contraseña " required="" id="password1" />
				<label id="labelpassw" ></label>

			</div>
			<script>

			</script>
			<div class="w3ls-bot">
				<div class="switch-agileits">
					<label class="switch">
						<input type="checkbox" onclick="passwordvisible()">
						<span class="slider round"></span>
						Ver contraseña
					</label>
				</div>
				<div class="form-end">
					<input type="submit" name="login" value="Entrar">
<hr>
					<a style="color:white;"href="./register.php">¿No tienes cuenta?, Regístrate</a>
				</div>
			</div>
		</form>
	</div>

<script type="text/javascript">
	registrarlogin();
	//registarmos la direccion ip en LocalStorage
	function get_ip(obj){
            var ip = obj.ip;

			localStorage.setItem("ip", ip);




        }




		
</script>
<script type="text/javascript" src="https://api.ipify.org/?format=jsonp&callback=get_ip"></script>
	<div class="copy-wthree">
		<p>© 2021 TecnoPlux All Rights Reserved
		</p>
	</div>
</body>
</html>