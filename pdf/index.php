<?php
require('./pdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('logo.jpg',10,4,33);
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

//db
$conexion= new mysqli("localhost","root","","ejemplo");
$result2=$conexion->query("Select count(*) as total from alumnos");
$result=$conexion->query("Select * from alumnos");
$columnas=$result->field_count;
$campos=$result->fetch_fields();
$filas=$result->num_rows;
$fila2=$result2->fetch_assoc();
$totalfilas = $fila2['total'];


// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

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