
<?php
require("./lib/reparacion.php");
require("./lib/conexion.php");
require("menu.php");
$mysql = Conexion::conectarBD();
$id= $_SESSION["id"];
$tipo = $_SESSION["tipo"];
?>
<html>
<head>
	<title>TecnoPlux - Home</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="keywords" content="Tecnoplux">
	<link rel="stylesheet" href="./css/style.css" />
	<script>
	</script>
</head>
<body>
<main class=".container-fluid">
<section>
<div class="container">
<div class="table-responsive-md">
<table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">Fecha</th>
      <th scope="col">Marca</th>
      <th scope="col">Modelo</th>
      <th scope="col">Numero de serie</th>
      <th scope="col">Tipo</th>
      <th scope="col">Precio</th>
      <th scope="col">Detalles</th>
      <th scope="col">Estado</th>
      <th scope="col">Ver</th>
    </tr>
  </thead>
  <tbody>
 <?php


 $inicio=0;
   $cuantos=10;
   $anterior=0;
   $siguiente=0;

 if(isset($_GET['p'])){
  $inicio=$_GET['p'];
}

$result2=$mysql->query("Select count(*) as total from reparaciones");


$fila2=$result2->fetch_assoc();
$totalfilas = $fila2['total'];
?>
<?php
//si somos tipo 1 no debe de acceder
if($tipo==1){
   header("location: home.php");
?>
<?php
}else{
  //si somos usuario 2 entonces tenemos que mostrar todos los registros en estado en progreso
	$result = $mysql->query("SELECT * FROM reparaciones where estado LIKE 'en progreso' ORDER BY fecha DESC limit $inicio,$cuantos");
while($row = $result->fetch_assoc()) {
    ?>
<tr>
<th scope="row"><?php echo $row['id'] ?></th>
    <td><?php echo $row['fecha'] ?></td>
    <td><?php echo $row['marca'] ?></td>
    <td><?php echo $row['modelo'] ?></td>
    <td><?php echo $row['nserie'] ?></td>
    <td><?php echo $row['tipodispositivo'] ?></td>
    <td><?php echo $row['precio'] ?></td>
    <td><?php echo $row['detalles'] ?></td>
    <td><?php echo $row['estado'] ?></td>
    <td><a href="./reparacion.php?viewid=<?php echo $row['id'] ?>" style="color:black"type="button" class="btn btn-light">Ver</button></td>
 </tr>
<?php
}
}
?>
</div>
</tbody>
</table>
<?php
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
  <ul class="pagination justify-content-center">
    <li class="page-item">
            <?php
     echo '<a class="page-link" href="./misreparacionesenprogreso.php?p='.$anterior.'" tabindex="-1" style="color:black">Anterior</a>';
      ?>
    </li>
    <li class="page-item">
      <?php
     echo '<a class="page-link" href="./misreparacionesenprogreso.php?p='.$siguiente.'" style="color:black">Siguiente</a>';
      ?>
    </li>
  </ul>
</section>
</tbody>
</table>
</div>
</main>
</div>
</section>
<?php
include("./footer.php"); 
?>
</body>
</html>
