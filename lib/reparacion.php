<?php

Class reparacion{
	private $id;
	private $marca;
	private $modelo;
	private $nserie;
	private $tipodedispositivo;
	private $detalles;
	private $fecha;
	private $estado;
	private $precio;
	private $direccion;

	function __construct($id="",$marca="",$modelo="",$nserie="",$tipodedispositivo="",$detalles="",$fecha="",$estado="",$precio="",$direccion=""){
				$this->id = $id;
				$this->marca = $marca;
				$this->modelo = $modelo;
				$this->nserie = $nserie;
				$this->tipodedispositivo = $tipodedispositivo;
				$this->detalles = $detalles;
				$this->fecha = $fecha;
				$this->estado = $estado;
				$this->precio = $precio;
				$this->direccion = $direccion;
			}

			function get_id(){
				return $this->id;
			}



			function get_marca(){
				return $this->marca;
			}


			function get_modelo(){
				return $this->modelo;
			}

			function get_nserie(){
				return $this->nserie;
			}

		

			function get_tipodedispositivo(){
				return $this->tipodedispositivo;
			}
			
				function get_detalles(){
				return $this->detalles;
			}
			function get_fecha(){
				return $this->fecha;
			}

			function get_estado(){
				return $this->estado;
			}	
			function get_precio(){
				return $this->precio;
			}
			function get_direccion(){
				return $this->direccion;
			}


			//Compruebo que los campos para una nueva reparacion no esten vacios
						function checkcampos($marca,$nserie,$detallesaveria,$direccion){
				$resultado=false;
				$comprobados=0;

				if(strlen($marca)==0){
					$comprobados++;
				}if(strlen($nserie)==0){
				$comprobados++;
			}

		if(strlen($detallesaveria)==0){
			$comprobados++;


		}

				if(strlen($direccion)==0){
			$comprobados++;
		}
		
				if ($comprobados>0) {
					
					$resultado=false;
				}else{
					
					$resultado=true;
				}
				return $resultado;
			}


			
//Nueva reparación
			function nuevareparacion($marca,$modelo,$nserie,$tipodispositivo,$detallesaveria,$fecha,$id,$direccion){
				$this->marca = $marca;
				$this->modelo = $modelo;
				$this->nserie = $nserie;
				$this->tipodedispositivo = $tipodispositivo;
				$this->detallesaveria = $detallesaveria;
				$this->direccion = $direccion;
				$resultado=false;
				$conexion = Conexion::conectarBD();
				$sql ="INSERT INTO reparaciones (marca, modelo, nserie, tipodispositivo, detalles, fecha, id_usr, direccion) VALUES ('$marca', '$modelo', '$nserie', '$tipodispositivo','$detallesaveria', '$fecha', '$id', '$direccion' );";
				if ($conexion->query($sql)) {
$resultado=true;

				}else{

					
$resultado=false;

				}
				Conexion::desconectarBD($conexion);	
				return $resultado;
			}

//obtengo los datos
			function getdatoreparacion($id){
				$this->id = $id;
				$resultado=false;
				$conexion = Conexion::conectarBD();
				$sql ="SELECT * FROM reparaciones WHERE id='$this->id'";
				$rs = $conexion->query($sql);
					while ($fila = $rs->fetch_assoc()){
						
						$this->id = $fila['id'];
						$this->fecha = $fila['fecha'];
						$this->marca = $fila['marca'];
						$this->modelo = $fila['modelo'];
						$this->nserie = $fila['nserie'];
						$this->tipodedispositivo = $fila['tipodispositivo'];
						$this->estado = $fila['estado'];
						$this->detalles = $fila['detalles'];
						$this->precio = $fila['precio'];
						$this->direccion = $fila['direccion'];
					}
					$resultado=true;
					return $resultado;
			}

//obtengo el nombre de usuario
			function getnombre($id){
				
		$nombre="";
				$resultado=false;
				$conexion = Conexion::conectarBD();
				$sql ="SELECT nombre FROM usuarios WHERE id_usr='$id'";
				$rs = $conexion->query($sql);
					while ($fila = $rs->fetch_assoc()){
						
						$nombre = $fila['nombre'];

					}
			
					return $nombre;
		}
//obtengo el correo
		function getcorreo($id){

			$correo="";
			$resultado=false;
			$conexion = Conexion::conectarBD();
			$sql ="SELECT email FROM usuarios WHERE id_usr='$id'";
			$rs = $conexion->query($sql);
				while ($fila = $rs->fetch_assoc()){
					
					$correo = $fila['email'];

				}
		
				return $correo;
	}


	

//filtro reparacion para que no pueda entrar un usuario que no sea su reparación
function filtroreparacion($id,$idreparacion){
	$resultado=false;
	$conexion = Conexion::conectarBD();
	$sql ="SELECT * FROM reparaciones WHERE id_usr='$id' AND id='$idreparacion'";
	if ($checkemail=$conexion->query($sql)) {
		$checkemail = $checkemail->num_rows;
	if($checkemail<1){
	$resultado=false;
	}else{
	$resultado=true;
	}
	return $resultado;
	}
}




//comprobamos que existe reparación
function existereparacion($idreparacion){
	$resultado=false;
	$conexion = Conexion::conectarBD();
	$sql ="SELECT * FROM reparaciones WHERE  id='$idreparacion'";
	if ($re=$conexion->query($sql)) {
		$re = $re->num_rows;
	if($re<1){
	$resultado=false;
	}else{
	$resultado=true;
	}
	return $resultado;
	}
}
//comprobamos que existe usuario
function existereusuario($id){
	$resultado=false;
	$conexion = Conexion::conectarBD();
	$sql ="SELECT * FROM usuarios WHERE  id_usr='$id'";
	if ($usr=$conexion->query($sql)) {
		$usr = $usr->num_rows;
	if($usr<1){
	$resultado=false;
	}else{
	$resultado=true;
	}
	return $resultado;
	}
}


//modificamos reparacion
function modificarreparacion($id,$marca,$modelo,$nserie,$precio,$detalles,$estado){
	$this->marca = $marca;
	$this->modelo = $modelo;
	$this->nserie = $nserie;
	$this->detalles = $detalles;
	$this->estado = $estado;

	$modificado=false;
	$conexion = Conexion::conectarBD();
	$sql ="UPDATE reparaciones SET marca='$marca',modelo='$modelo', nserie='$nserie', detalles='$detalles', estado='$estado' WHERE id='$id'";


	if ($conexion->query($sql)) {
		$modificado = true;
	}else{
		$modificado = false;
	}
	return $modificado;

}


//lanzamos un nuevo comentario en la db
function nuevocomentario($id,$idusuario,$comentario,$fecha){
	$resultado=false;
	$conexion = Conexion::conectarBD();
	$sql ="INSERT INTO comentarios (comentario,id_rep,id_usr,fecha) VALUES ('$comentario', '$id', '$idusuario'   ,'$fecha');";
	if ($conexion->query($sql)) {
	$resultado=true;
	}else{
$resultado=false;
	}
	Conexion::desconectarBD($conexion);	
	return $resultado;
}

//comprobamos la longitud del comentario
function comprobarlongitudcomentario($comentario){
	$resultado=false;
	if(strlen($comentario)>24){
$resultado=false;
	}else{
		$resultado=true;
	}





	return $resultado;
}


//obtenemos el numero de comentarios para despues mostrarlo
function gentnumerodecomentarios($id){
			$total = 0;
			$conexion = Conexion::conectarBD();
			$sql ="SELECT COUNT(*) total FROM comentarios WHERE id_rep='$id'";
			$rs = $conexion->query($sql);
				while ($fila = $rs->fetch_assoc()){
					$total = $fila['total'];
				}
				return $total;
	}

//borramos la reparacion en base a una id
	function borrarreparacion($id){
		$borrado=false;
		$conexion = Conexion::conectarBD();
		$sql ="DELETE FROM reparaciones WHERE id='$id'";
		if ($conexion->query($sql)) {
			$borrado = true;
		}else{
			$borrado = false;
		}
		return $borrado;
	
	}


//para las reparaciones no es necesario hora
			function fecha(){
				$fecha = date('Y-m-d');
				return $fecha;

			}
			//Para los comentarios prefiero especificar fecha y hora
			function fechayhora(){
				$DateAndTime = date('Y-m-d h:i:s', time());  
				return $DateAndTime;
			}

			






		}


		


			

?>