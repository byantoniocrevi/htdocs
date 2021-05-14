<?php
ob_start();
require("menu.php");
require("./lib/reparacion.php");
require("./lib/conexion.php");
?>


<html>
<head>
	<title>TecnoPlux - Home</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="keywords" content="Tecnoplux">
	<link rel="stylesheet" href="./css/style.css" />
  <script src="./lib/js.js" type="text/javascript"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script>
	</script>
</head>
<body>

<?php

$reparacion = new reparacion();
  $idusuario = $_SESSION["id"];
  $idreparacion = $_GET["viewid"];
  $tipo = $_SESSION['tipo'];

  //si es usuario deberá pasar por el filtro, sin embargo si es tecnico no deberá pasar por el fitro, por lo tanto podrá ver los detalles de todas las reparaciones
  if($tipo==1){
    //como aquí solo entran los usuarios que no son tecnico tenemos que filtrar para que solo pueda entrar la persona correspondiente a su avería, si no seria un fallo de seguridad grande
  $rs=$reparacion->filtroreparacion($idusuario,$idreparacion);
if(!$rs){
  header("location: misreparaciones.php");
}
  }
//comprobamos que exista la reparacion
  $rs=$reparacion->existereparacion($idreparacion);

//comprobamos que le llega una id, que no está vacia y que existe realmente.
if(!isset($_GET['viewid']) || $_GET['viewid'] == "" || !$rs){
  header("location: misreparaciones.php");




}else{

   $id;
   $marca;
   $modelo;
   $nserie;
   $tipodedispositivo;
   $detalles;
   $fecha;
   $nombreusuario;
   $direccion;
  

  $rs=$reparacion->getdatoreparacion($idreparacion);

  if($rs){
    $id=$reparacion->get_id();
    $marca = $reparacion -> get_marca();
    $modelo = $reparacion -> get_modelo();
    $nserie = $reparacion -> get_nserie();
    $tipodedispositivo = $reparacion -> get_tipodedispositivo();
    $detalles = $reparacion -> get_detalles();
    $fecha = $reparacion -> get_fecha();
    $estado = $reparacion -> get_estado();
    $precio = $reparacion -> get_precio();
 
$correousuario=$reparacion->getcorreoclienterep($id);
  $nombreusuario=$reparacion->getnombreclienterep($id);








    $ndecomentarios=$reparacion->gentnumerodecomentarios($idreparacion);
    $direccion=$reparacion->get_direccion($idusuario);
  }

}


if (isset($_POST['modificar'])) {

  $reparacion = new reparacion();
	$marca = htmlspecialchars(trim($_POST['marca']));
	$modelo = htmlspecialchars(trim($_POST['modelo']));
	$nserie = htmlspecialchars(trim($_POST['nserie']));
	$precio = htmlspecialchars(trim($_POST['precio']));
	$detalles = htmlspecialchars(trim($_POST['detalles']));
  $estado = htmlspecialchars(trim($_POST['estado']));
	$rs=$reparacion->modificarreparacion($idreparacion,$marca,$modelo,$nserie,$precio,$detalles,$estado);
	if($rs){
	//	$rs=$usuario->getdatosuser($email);
		//$nombredatos=$usuario->get_nombre();
		$estado=$reparacion->get_estado();
		if($rs){
		echo "<div  class='alert alert-success text-center' role='alert' id='borrar'>Cambios aplicados con éxito</div>";
		}else{
			echo "<div class='alert alert-danger text-center' role='alert' id='borrar'>ERROR: No se han podido aplicar los cambios</div>";
		}
	}
}


if (isset($_POST['borrar'])) {

    $rs=$reparacion->borrarreparacion($idreparacion);

		if($rs){
		echo "<div  class='alert alert-success text-center' role='alert' id='borrar'>Se ha borrado la reparación</div>";
		}else{
			echo "<div class='alert alert-danger text-center' role='alert' id='borrar'>ERROR: No se han podido borrar la reparación</div>";
		}
	}


if (isset($_POST['notas'])) {
  $comentario = htmlspecialchars(trim($_POST['comentario']));
  $fechayhora= $reparacion->fechayhora();


  $rs=$reparacion->comprobarlongitudcomentario($comentario);
  if(!isset($_COOKIE['cookie_escribir'])) {
  if($rs){
    if($comentario!=""){
	$rs=$reparacion->nuevocomentario($idreparacion,$idusuario,$comentario,$fechayhora);
  setcookie('cookie_escribir', 'escribir', 10  + time(), "/"); 


if($rs){
  echo "<div class='alert alert-success text-center' role='alert' id='borrar'>Comentario añadido con éxito</div>";



  echo '<meta http-equiv="Refresh" content="5;'.$_SERVER["REQUEST_URI"].'">';

}else{
  echo "<div class='alert alert-danger text-center' role='alert' id='borrar'>ERROR: No se ha podido añadir el comentario </div>";
}

}else{
  echo "<div class='alert alert-danger text-center' role='alert' id='borrar'>ERROR: No puedes añadir un comentario vacio </div>";
}
  }else{
    echo "<div class='alert alert-danger text-center' role='alert' id='borrar'>ERROR: No puedes añadir mas de 24 carácteres </div>";
  }




}else{
  echo "<div class='alert alert-danger text-center' role='alert' id='borrar'>ERROR: Debes esperar al menos 10 segundos antes de volver a comentar</div>";

}

}



?>
<main class=".container-fluid">
<section>
<div class="container">
  

<?php
$mysql = Conexion::conectarBD();
?>

<div class="container">
  <main>
    <div class="py-5 text-center">
    <!--  <img class="d-block mx-auto mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
      <h2>Reparacion #<?php echo $idreparacion ?></h2>
     <!-- <p class="lead">Below is an example form built entirely with Bootstrap’s form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p> -->
    </div>

    <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Notas</span>
          <span class="badge bg-primary rounded-pill"><?php echo $ndecomentarios; ?></span>
        </h4>
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
             
             <?php

   $inicio=0;
   $cuantos=5;
   $anterior=0;
   $siguiente=0;
  
 

if(isset($_GET['p'])){
	$inicio=$_GET['p'];
}
$result2=$mysql->query("Select count(*) as total from comentarios");

$result=$mysql->query("SELECT nombre,fecha,comentario FROM `comentarios` INNER JOIN usuarios ON usuarios.id_usr = comentarios.id_usr WHERE id_rep =$idreparacion ORDER BY fecha DESC limit $inicio,$cuantos;");

$columnas=$result->field_count;
$campos=$result->fetch_fields();
$filas=$result->num_rows;
$fila2=$result2->fetch_assoc();
$totalfilas = $fila2['total'];
 while($fila=$result->fetch_assoc()){
  echo "<p style='color:black;'>";
  foreach($fila as $indice=>$valor){
   

    if($indice == "fecha"){
      echo " escribió ";
    }
    if($indice == "comentario"){
    echo "<br>";
    }
    echo $valor;//fecha
    
  }
  echo "<p/>";



  echo '<li class="list-group-item">' ;



  
}


 echo "<a href='reparacion.php?viewid=$idreparacion&p=$anterior' style='color:black; '> [&laquo;]</a> <a href='reparacion.php?viewid=$idreparacion&p=$siguiente' style='color:black;'> [&raquo;] </a>"; 
    

if($inicio+$cuantos<$totalfilas)
{
	$siguiente = $inicio+$cuantos;
}else{
	$siguiente = $inicio;
}
   if($inicio-$cuantos>=0){
		$anterior = $inicio-$cuantos;
	}else{
		$anterior = $inicio;
	}


?>


            
          </li>


        <form class="card p-2" method="POST">
          <div class="input-group">
            <input type="text" name="comentario" class="form-control" placeholder="Añadir comentario">
            <button type="submit" name="notas" class="btn btn-secondary">Comentar</button>
            <i class="bi bi-arrow-bar-left"></i>
            
       
          </div>
        </form>
      </div>
      <div class="col-md-7 col-lg-8">

        <form class="needs-validation" method="POST">
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label">ID de reparación</label>
              <input type="text" class="form-control" id="idreparacion" placeholder="" value="<?php echo $id  ?>" readonly>
              <div class="invalid-feedback" >

              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
              
    <label >Estado</label>
    <select class="form-control" id="estado" name="estado" disabled>
      <option value="pendiente" <?php if($estado=="pendiente") echo "selected" ?>>Pendiente</option>
      <option  value="en progreso" <?php if($estado=="en progreso") echo "selected" ?>>En progreso</option>
      <option value="completado" <?php if($estado=="completado") echo "selected" ?>>Completado</option>

    </select>
    
  </div>
            
    
            </div>
            <div class="col-sm-6">
              <label  class="form-label">Nombre de cliente</label>
              <input type="text" class="form-control" id="nombrecliente" placeholder="" value="<?php echo $nombreusuario ?>" readonly>
              <div class="invalid-feedback" >

              </div>
            </div>

            <div class="col-sm-6">
              <label  class="form-label">Correo de cliente</label>
              <input type="text" class="form-control" id="correocliente" placeholder="" value="<?php echo $correousuario ?>" readonly>
              <div class="invalid-feedback" >

              </div>
            </div>
            
            <div class="col-sm-6">
              <label  class="form-label">Tipo de dispositivo</label>
              <input type="text" class="form-control" id="tipo" placeholder="" value="<?php echo $tipodedispositivo  ?>" readonly>
        
            </div>
            
   

            <div class="col-sm-6">
              <label  class="form-label">Fecha de emisión</label>
              <input type="text" class="form-control" id="fecha" placeholder="" value="<?php echo $fecha  ?>" readonly>
        
            </div>

            <div class="col-sm-6">
              <label class="form-label">Marca</label>
              <input type="text" class="form-control" id="marca" name="marca" placeholder="" value="<?php echo $marca  ?>" readonly>
              <div class="invalid-feedback" >

              </div>
            </div>

            <div class="col-sm-6">
              <label  class="form-label">Modelo</label>
              <input type="text" class="form-control" id="modelo" name="modelo" placeholder="" value="<?php echo $modelo  ?>" readonly>
        
            </div>

            <div class="col-sm-6">
              <label  class="form-label">Nº de serie</label>
              <input type="text" class="form-control" id="nserie" name="nserie" placeholder="" value="<?php echo $nserie  ?>" readonly>
              <div class="invalid-feedback" >

              </div>
            </div>
            <div class="col-sm-6">
              <label class="form-label">Precio</label>
              <input type="text" class="form-control" id="precio" name="precio" placeholder="" value="<?php echo $precio ?>" readonly>
              <div class="invalid-feedback" >

              </div>
            </div>

            <div class="col-12">
              <label  class="form-label">Direccion de entrega</label>
              <input type="text" class="form-control" id="address" placeholder="Dirección de entrega" value="<?php echo $direccion ?>" readonly>
  
  
            </div>

            <div class="col-12">
              <label class="form-label">Detalles</label>
              <textarea class="form-control" id="detalles" name="detalles" rows="3" readonly><?php echo $detalles  ?></textarea>

            </div>

       





<?php
if($tipo==2){
?>
          <hr class="my-4">
          <a class="btn btn-secondary" href="javascript:editar();" role="button">Editar</a>
        
  
          <button class="w-100 btn btn-primary btn-lg" name="modificar" type="submit">Guardar</button>
          <button class="w-100 btn btn-danger btn-lg" onClick="return confirm('¿Estas seguro de que quieres eliminar esta reparacion?');" name="borrar" type="submit">BORRAR</button>
   
<?php
}

?>



        </form>
      </div>
    </div>






</section>
</main>
</section>
</div>
<?php
include("./footer.php"); 
?>

</body>


</body>
</html>
<?php
ob_end_flush();
?>