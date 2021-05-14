<?php

Class Conexion{

	public static function conectarBD(){
		$server="localhost";
		$usr="root";
		$pass="password";
		$bd="db";
		$mysqli = new mysqli($server, $usr, $pass, $bd); 
		if ($mysqli->connect_errno) { 
			echo "Error: Fallo al conectarse a MySQL debido a: \n"; 
			echo "Errno: " . $mysqli->connect_errno . "\n"; 
			echo "Error: " . $mysqli->connect_error . "\n"; 
			exit;
		}
		$mysqli->set_charset("utf8");
		return $mysqli;
	}

	public static function desconectarBD($mysqli){
  		$mysqli->close();
	}
}


$configpdf['nombre'] = "TecnoPlux";
$configpdf['correo'] = "soporte@tecnoplux.es";
$configpdf['ubicacion'] = "Alicante";
$configpdf['telefono'] = "696969696";

?>