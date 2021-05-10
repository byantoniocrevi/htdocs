<?php

Class usuario{
	
	private $id;
	private $nombre;
	private $email;
	private $password;
	private $tipo;

	function __construct($id="",$nombre="",$email="",$password="",$tipo=""){
				$this->id = $id;
				$this->nombre = $nombre;
				$this->email = $email;
				$this->password = $password;
				$this->tipo = $tipo;
			}

			function get_id(){
				return $this->id;
			}


			function get_nombre(){
				return $this->nombre;
			}

			function get_email(){
				return $this->email;
			}

			function get_contraseña(){
				return $this->contraseña;
			}

			function get_contraseñarep(){
				return $this->contraseña;
			}
			
				function get_tipo(){
				return $this->tipo;
			}
			
					function checkform($nombre,$email,$password,$password2){
				$campocomprobado=0;
				$resultado="<p style='color:red;'><b>ERROR: los siguientes campos</b></p>";
				if(strlen($nombre)==0){
					$resultado.="<p style='color:red;'>Nombre está vacio</p>";
					$campocomprobado++;
				}
				if(strlen($nombre)<3){
					$resultado.="<p style='color:red;'>Nombre debe tener al menos 3 carácteres</p>";
					$campocomprobado++;
				}
				if(strlen($email)==0){
					$resultado.="<p style='color:red;'>Email está vacio</p>";
					$campocomprobado++;
				}
				if($email){
					$em = true;
					$em = (false !== strpos($email, "@") && false !== strpos($email, "."));
					if($em == false){
						$resultado.="<p style='color:red;'>Email no válido</p>";
						$campocomprobado++;
					}
				}
				
				if($password!=$password2){
				$resultado.="<p style='color:red;'>Las contraseñas no coinciden</p>";
				$campocomprobado++;
				}else{
					if(strlen($password)==0&&strlen($password2)==0){
						$resultado.="<p style='color:red;'>Las contraseñas están vacias</p>";
						$campocomprobado++;
					}

				}
					
					
				if ($campocomprobado>0) {
					return $resultado;
				}else{
					$resultado="ok";
					return $resultado;
				}
			}
			
					function comprobaremail($email){
				$this->email = $email;
				$resultado="";
				$conexion = Conexion::conectarBD();
				$sql ="SELECT * FROM usuarios WHERE email='$email'";
				$ncorreo=$conexion->query($sql);
					$ncorreo = $ncorreo->num_rows;
					if($ncorreo>0){
						$resultado="<p style='color:red;'>El correo ya existe</p>";
					}else{
						$resultado="ok";
					}
					
					return $resultado;
			}
			/*
							function comprobarcargo($email){
				$this->email = $email;
				$resultado="";
				$conexion = Conexion::conectarBD();
				$sql ="SELECT tipo FROM usuarios WHERE email='$email'";
				$tipo=$conexion->query($sql);
					$ncorreo = $ncorreo->num_rows;
					if($ncorreo>0){
						$resultado="<p style='color:red;'>El correo ya existe</p>";
					}else{
						$resultado="ok";
					}
					
					return $resultado;
			}
			*/
			
			
					
			
			
			
			
				function comprobarcargo($email){
				$this->email = $email;
				$resultado=false;
				$cargo = 0;
				$conexion = Conexion::conectarBD();
				$sql ="SELECT tipo FROM usuarios WHERE email='$this->email'";
				$resultadonombre = $conexion->query($sql);
					while ($fila = $resultadonombre->fetch_assoc()){
						$this->id = $fila['id_usr'];
						$this->nombre = $fila['nombre'];
						$this->email = $fila['email'];
						$this->contraseña = $fila['pass'];
						$cargo = $fila['tipo'];
					}
					$resultado=true;
					
					return $cargo;
			}


				

			
				
			
		
		
			
			

					function registrar($nombre,$email,$password){
				$this->nombre = $nombre;
				$this->email = $email;
				$this->password = $password;
				$resultado="";

				$conexion = Conexion::conectarBD();
				$sql = "INSERT INTO usuarios (nombre, email, pass) VALUES ('$nombre', '$email', '$password');";

				if ($conexion->query($sql)) {
					$resultado="<h1 style='color:green'>Te has registrado correctamente.</h1>";
				}else{
					$resultado="<p style='color:red'><b>Ha ocurrido un error prueba de nuevo a registrarte.</b></p>";
				}
			
				Conexion::desconectarBD($conexion);	
				return $resultado;
			}
			
			
			
			
			

			
					function checkcamposlogin($email,$password){
				$resultado="";
				$comprobados=0;
				if(strlen($email)==0){
					$resultado.="<p style='color:red'>El correo no puede estar vacio </p>";
					$comprobados++;
				}else{
				}if(strlen($password)==0){
				$resultado.="<p style='color:red'>La contraseña no puede estar vacia </p>";
				$comprobados++;
			}

			if(strlen($email)==0 && strlen($password)==0){
				$resultado = "";
				$resultado.="<p style='color:red'>El correo no puede estar vacio </p>";
				$resultado.="<p style='color:red'>La contraseña no puede estar vacia </p>";
				$comprobados++;

			}
				if ($comprobados>0) {
					return $resultado;
				}else{
					$resultado="";
					return $resultado;
				}
			}
			
			

			function checkloginemail($email){
				$resultado="";
				$this->email = $email;
				$conexion = Conexion::conectarBD();
				$sql ="SELECT * FROM usuarios WHERE email='$email'";
				if ($checkemail=$conexion->query($sql)) {
					$checkemail = $checkemail->num_rows;					
				if($checkemail<1){
				$resultado.="<p style='color:red'>El correo no se encuentra en la base de datos.</p>";
				}else{
				$resultado="";
					}
					return $resultado;
				}else{
					return $resultado;
				}		
			}

			
			
			function loginusuario($email,$contraseña){
				$this->email = $email;
				$resultado="";
				$conexion = Conexion::conectarBD();
				$sql ="SELECT pass FROM usuarios WHERE email='$this->email'";
				if ($resultadocontraseña = $conexion->query($sql)) {
					while ($fila = $resultadocontraseña->fetch_assoc()){
						$this->contraseña = $fila['pass'];
					}
					if($contraseña==$this->contraseña){
						$resultado="";
						
					}else{
						$resultado.="<p style='color:red'>Contraseña incorrecta</p>";
					}
					return $resultado;
					
				}else{
					return $resultado;
				}
			}

			function getdatosuser($email){
				$this->email = $email;
				$resultado=false;
				$conexion = Conexion::conectarBD();
				$sql ="SELECT * FROM usuarios WHERE email='$this->email'";
				$resultadonombre = $conexion->query($sql);
					while ($fila = $resultadonombre->fetch_assoc()){
						$this->id = $fila['id_usr'];
						$this->nombre = $fila['nombre'];
						$this->email = $fila['email'];
						$this->contraseña = $fila['pass'];
					}
					$resultado=true;
					return $resultado;
			}
	
			function modificarusuario($nombre,$contraseña,$email){
				$this->nombre = $nombre;
				$this->contraseña = $contraseña;
				$this->email = $email;
				$modificado=false;
				$conexion = Conexion::conectarBD();
				$sql ="UPDATE usuarios SET nombre='$nombre',pass='$contraseña' WHERE email='$email'";
				if ($conexion->query($sql)) {
					$modificado = true;
				}else{
					$modificado = false;
				}
				return $modificado;

			}

			function comentar($comentario,$fecha,$id){
				$rs=false;
				$conexion = Conexion::conectarBD();
			$sql ="INSERT INTO comentarios (comentario, fecha, id_usr) VALUES ('$comentario', '$fecha', '$id');";
				if ($conexion->query($sql)) {
					$rs=true;
				}else{
					$rs=false;
				}
				return $rs;
			}

			function fecha(){
				$fecha = date('Y-m-d H:i:s');
				return $fecha;

			}
			
}







		



			

?>