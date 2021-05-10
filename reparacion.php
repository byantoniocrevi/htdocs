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
    $nombreusuario=$reparacion->getnombre($idusuario);
    $correousuario=$reparacion->getcorreo($idusuario);
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
    <!--    <h4 class="mb-3">Billing address</h4> -->
        <form class="needs-validation" method="POST">
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">ID de reparación</label>
              <input type="text" class="form-control" id="idreparacion" placeholder="" value="<?php echo $id  ?>" readonly>
              <div class="invalid-feedback" >

              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
              
    <label for="exampleFormControlSelect1">Estado</label>
    <select class="form-control" id="estado" name="estado" disabled>
      <option value="pendiente" <?php if($estado=="pendiente") echo "selected" ?>>Pendiente</option>
      <option  value="en progreso" <?php if($estado=="en progreso") echo "selected" ?>>En progreso</option>
      <option value="completado" <?php if($estado=="completado") echo "selected" ?>>Completado</option>

    </select>
    
  </div>
            
    
            </div>
            <div class="col-sm-6">
              <label for="firstName" class="form-label">Nombre de cliente</label>
              <input type="text" class="form-control" id="nombrecliente" placeholder="" value="<?php echo $nombreusuario ?>" readonly>
              <div class="invalid-feedback" >

              </div>
            </div>

            <div class="col-sm-6">
              <label for="firstName" class="form-label">Correo de cliente</label>
              <input type="text" class="form-control" id="correocliente" placeholder="" value="<?php echo $correousuario ?>" readonly>
              <div class="invalid-feedback" >

              </div>
            </div>
            
            <div class="col-sm-6">
              <label for="lastName" class="form-label">Tipo de dispositivo</label>
              <input type="text" class="form-control" id="tipo" placeholder="" value="<?php echo $tipodedispositivo  ?>" readonly>
        
            </div>
            
   

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Fecha de emisión</label>
              <input type="text" class="form-control" id="fecha" placeholder="" value="<?php echo $fecha  ?>" readonly>
        
            </div>

            <div class="col-sm-6">
              <label for="firstName" class="form-label">Marca</label>
              <input type="text" class="form-control" id="marca" name="marca" placeholder="" value="<?php echo $marca  ?>" readonly>
              <div class="invalid-feedback" >

              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Modelo</label>
              <input type="text" class="form-control" id="modelo" name="modelo" placeholder="" value="<?php echo $modelo  ?>" readonly>
        
            </div>

            <div class="col-sm-6">
              <label for="firstName" class="form-label">Nº de serie</label>
              <input type="text" class="form-control" id="nserie" name="nserie" placeholder="" value="<?php echo $nserie  ?>" readonly>
              <div class="invalid-feedback" >

              </div>
            </div>
            <div class="col-sm-6">
              <label for="firstName" class="form-label">Precio</label>
              <input type="text" class="form-control" id="precio" name="precio" placeholder="" value="<?php echo $precio ?>" readonly>
              <div class="invalid-feedback" >

              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Direccion de entrega</label>
              <input type="text" class="form-control" id="address" placeholder="Dirección de entrega" value="<?php echo $direccion ?>" readonly>
  
  
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Detalles</label>
              <textarea class="form-control" id="detalles" name="detalles" rows="3" readonly><?php echo $detalles  ?></textarea>

            </div>

            <!--





<div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="col-12">
              <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
            </div>

            <div class="col-md-5">
              <label for="country" class="form-label">Country</label>
              <select class="form-select" id="country" required>
                <option value="">Choose...</option>
                <option>United States</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid country.
              </div>
            </div>

            <div class="col-md-4">
              <label for="state" class="form-label">State</label>
              <select class="form-select" id="state" required>
                <option value="">Choose...</option>
                <option>California</option>
              </select>
              <div class="invalid-feedback">
                Please provide a valid state.
              </div>
            </div>

            <div class="col-md-3">
              <label for="zip" class="form-label">Zip</label>
              <input type="text" class="form-control" id="zip" placeholder="" required>
              <div class="invalid-feedback">
                Zip code required.
              </div>
            </div>
          </div>

          <hr class="my-4">

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="same-address">
            <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="save-info">
            <label class="form-check-label" for="save-info">Save this information for next time</label>
          </div>

          <hr class="my-4">

          <h4 class="mb-3">Payment</h4>

          <div class="my-3">
            <div class="form-check">
              <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
              <label class="form-check-label" for="credit">Credit card</label>
            </div>
            <div class="form-check">
              <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
              <label class="form-check-label" for="debit">Debit card</label>
            </div>
            <div class="form-check">
              <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
              <label class="form-check-label" for="paypal">PayPal</label>
            </div>
          </div>

          <div class="row gy-3">
            <div class="col-md-6">
              <label for="cc-name" class="form-label">Name on card</label>
              <input type="text" class="form-control" id="cc-name" placeholder="" required>
              <small class="text-muted">Full name as displayed on card</small>
              <div class="invalid-feedback">
                Name on card is required
              </div>
            </div>

            <div class="col-md-6">
              <label for="cc-number" class="form-label">Credit card number</label>
              <input type="text" class="form-control" id="cc-number" placeholder="" required>
              <div class="invalid-feedback">
                Credit card number is required
              </div>
            </div>

            <div class="col-md-3">
              <label for="cc-expiration" class="form-label">Expiration</label>
              <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
              <div class="invalid-feedback">
                Expiration date required
              </div>
            </div>

            <div class="col-md-3">
              <label for="cc-cvv" class="form-label">CVV</label>
              <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
              <div class="invalid-feedback">
                Security code required
              </div>
            </div>
          </div>

-->


<?php
if($tipo==2){
?>
          <hr class="my-4">
          <a class="btn btn-secondary" href="javascript:editar();" role="button">Editar</a>
        
        
          <button class="w-100 btn btn-primary btn-lg" name="modificar" type="submit">Guardar</button>
   
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