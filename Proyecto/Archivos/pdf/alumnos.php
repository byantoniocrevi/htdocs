<!DOCTYPE html>
<html>
    <head>
        <title>LISTA ALUMNOS</title>
        <meta charset="UFT-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="stylesheets/screen.css">

	<style>
		table td{
			border: 1px solid black;
		}
	</style>
    </head>
<body>
<?php
$inicio=0;
$cuantos=2; //cuantas filas quiero ver por página
$anterior=0;
$siguiente=0;

if(isset($_GET['p'])){


	$inicio=$_GET['p'];
}
	$conexion= new mysqli("localhost","root","","ejemplo");
	$result2=$conexion->query("Select count(*) as total from alumnos");
	$result=$conexion->query("Select * from alumnos limit $inicio,$cuantos");

	$columnas=$result->field_count;
	$campos=$result->fetch_fields();
	$filas=$result->num_rows;

	$fila2=$result2->fetch_assoc();
	$totalfilas = $fila2['total'];

	echo "<table border='1'>";
	echo "<tr>";
	for($col=0;$col<$columnas;$col++){
		echo"<td>";
		echo $campos[$col]->name;
		echo"</td>";
	}
	echo "</tr>";
	for($cont=1;$cont<=$filas ;$cont++){
		echo "<tr>";
		$fila=$result->fetch_assoc();
		for($col=0;$col<$columnas;$col++){
			echo"<td>";
			echo $fila[$campos[$col]->name];
			echo"</td>";
		}
		echo "</tr>";
	}
	echo "</table>";

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
	echo "<a href='alumnos.php?p=$anterior'>[anterior]</a> <a href='alumnos.php?p=$siguiente'>[siguiente] </a>";
	echo "<a href=';

	$conexion->close();
	
?>
</body>
</html>