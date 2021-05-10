<?php
require("./lib/reparacion.php");
require("./lib/conexion.php");


$mysql = Conexion::conectarBD();
$reparacion = new reparacion();
$idreparacion = $_GET["viewid"]; 
session_start();
$idusuario = $_SESSION["id"];
 $tipo = $_SESSION['tipo'];

//verificamos que los parámetros que mandamos por el get sean correctos
$rs=$reparacion->existereparacion($idreparacion);
$rs2=$reparacion->existereusuario($idusuario);
if(!isset($_GET['viewid']) || $_GET['viewid'] == "" || !$rs || !$rs2){
  header("location: misfacturas.php");
}





//en caso de ser tipo 1 filtramos para que no pueda entrar en otras facturas
if($tipo==1){
  $rs=$reparacion->filtroreparacion($idusuario,$idreparacion);
if(!$rs){
  header("location: misfacturas.php");
}
}



require('./pdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('./pdf/logo_small.png',10,4,33);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'Title',1,0,'C');
    // Salto de línea
    $this->Ln(20);
}
// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}







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

  }


$result=$mysql->query("Select id,marca,modelo,nserie,precio from reparaciones WHERE id='$idreparacion'");
$columnas=$result->field_count;
$campos=$result->fetch_fields();
$filas=$result->num_rows;





$pdf = new FPDF($orientation='P',$unit='mm');
$pdf->AddPage();
$pdf->SetFont('Arial','B',20);    
$textypos = 5;
$pdf->setY(12);
$pdf->setX(10);
// Agregamos los datos de la empresa
$pdf->Cell(5,$textypos,"FACTURA #". $id );
$pdf->SetFont('Arial','B',10);    
$pdf->setY(30);$pdf->setX(10);
$pdf->Cell(5,$textypos,"DE:");
$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(10);
$pdf->Cell(5,$textypos,"".$configpdf['nombre']);
$pdf->setY(40);$pdf->setX(10);
$pdf->Cell(5,$textypos,"Alicante".$configpdf['ubicacion']);
$pdf->setY(45);$pdf->setX(10);
$pdf->Cell(5,$textypos,"".$configpdf['telefono']);
$pdf->setY(50);$pdf->setX(10);
$pdf->Cell(5,$textypos,"".$configpdf['correo']);

// Agregamos los datos del cliente
$pdf->SetFont('Arial','B',10);    
$pdf->setY(30);$pdf->setX(75);
$pdf->Cell(5,$textypos,"PARA:");
$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(75);
$pdf->Cell(5,$textypos,"Nombre del cliente: ". $nombreusuario);
$pdf->setY(40);$pdf->setX(75);
$pdf->Cell(5,$textypos,"Correo del cliente: " .$correousuario);



// Agregamos los datos del cliente
$pdf->SetFont('Arial','B',10);    
$pdf->setY(30);$pdf->setX(135);
$pdf->Cell(5,$textypos,"FACTURA " . $id);
$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(135);
$pdf->Cell(5,$textypos,"Fecha: " . $fecha);
$pdf->setY(40);$pdf->setX(135);
$pdf->Cell(5,$textypos,"Precio Final: " . $precio . " euros");
$pdf->setY(45);$pdf->setX(135);
$pdf->Cell(5,$textypos,"");
$pdf->setY(50);$pdf->setX(135);
$pdf->Cell(5,$textypos,"");

$pdf->setY(60);$pdf->setX(135);
    $pdf->Ln();



for($col=0;$col<$columnas;$col++){
    $pdf->SetFillColor(133,129,125);
    $pdf->Cell(35,10,$campos[$col]->name,0,0,"C",true);

}
$pdf->ln(10);
for($cont=1;$cont<=$filas ;$cont++){
    $fila=$result->fetch_assoc();
    for($col=0;$col<$columnas;$col++){
        $pdf->Cell(35,10,$fila[$campos[$col]->name],0,0,"C");
      
   
    }
    $pdf->ln(10);
}




$pdf->Output();
$result->free();

?>