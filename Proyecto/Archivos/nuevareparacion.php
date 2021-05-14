<?php
require("./lib/reparacion.php");
require("./lib/conexion.php");
require("menu.php");
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
  <link rel="stylesheet" href="./lib/alertifyjs/css/alertify.min.css">  
  <script src="./lib/alertifyjs/js/alertify.min.js"></script>     

    
	<script>
	</script>
</head>
<body>


<?php
if (isset($_POST['nuevo'])) {

$reparacion = new reparacion();
$marca = htmlspecialchars(trim($_POST['marca']));
$modelo = htmlspecialchars(trim($_POST['modelo']));
$nserie = htmlspecialchars(trim($_POST['nserie']));
$tipodispositivo = htmlspecialchars(trim($_POST['tipodispositivo']));
$detallesaveria = htmlspecialchars(trim($_POST['detallesaveria']));
$direccion = htmlspecialchars(trim($_POST['direccion']));
$reparacion = new reparacion();
$resultado=$reparacion->checkcampos($marca,$nserie,$detallesaveria,$direccion);
$fecha=$reparacion->fecha();
$id = $_SESSION["id"];
if($resultado){


  $resultado=$reparacion->nuevareparacion($marca,$modelo,$nserie,$tipodispositivo,$detallesaveria,$fecha,$id,$direccion);



  
  echo "<div class='alert alert-success text-center' role='alert' id='borrar'>Has registrado una nueva reparación con éxito</div>";


}else{

  echo "<div class='alert alert-danger text-center' role='alert' id='borrar'>Error debes completar todos los campos</div>";
}

}
?>
<div class="container">
  <main>
  <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h4 class="mb-2">Nueva Reparacion</h4>
        <form class="needs-validation" name="newreparacion" method="post">
          <div class="row g-3">

            <div class="col-sm-6">
              <label  class="form-label">Marca</label>
              <input type="text" name="marca" id="marca" class="form-control"  placeholder="Introduce la marca del dispositivo"  >
              <label id="marcaerr" ></label>
            </div>
            
            <div class="col-sm-6">
              <label  class="form-label">Modelo</label>
              <input type="text" name="modelo" id="modelo" class="form-control" id="lastName" placeholder="Introduce el modelo del dispositivo" >
              <label id="modeloerr" ></label>
            </div>

          <div class="col-sm-6">
              <label class="form-label">Numero de serie</label>
              <input type="text" name="nserie" id="nserie" class="form-control" id="lastName" placeholder="Introduce el número de serie del dispositivo"  >
              <label id="nserieerr" ></label>
            </div>



                      <div class="col-sm-6">
                <label class="form-label">Tipo de dispositivo</label>
              <select class="form-select" id="tipodispositivo" name="tipodispositivo">
                  <option value="Telefono" selected="selected">Teléfono</option>

    	<option value="Tablet">Tablet</option>
    	<option value="Television">Televisión</option>
   		 <option value="Otro">Otro</option>
              </select>

              <label id="tipodispositivoerr" ></label>
            </div>
            <div class="col-12">
              <label class="form-label">Dirección de entrega</label>
              <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Introduce la direccion de entrega, por ejemplo C/Plaza España, Elche 03201 ">
              <label id="direccionerr" ></label>

            </div>


            <div class="col-12">
              <label class="form-label">Detalles de la averia</label>
			<textarea class="form-control" id="detallesaveria" name="detallesaveria" rows="3" placeholder="Introduce detalladamente lo que le ocurre al dispositivo"></textarea>
      <label id="detalleserr" ></label>
            
            </div>

            </div>
          </div>



       <hr class="my-4">
          <button id="new" class="w-100 btn btn-primary btn-lg"  type="submit"  name="nuevo">Nueva reparación</button>
        </form>
      </div>
    </div>
  </main>





<?php
include("./footer.php"); 
?>

<script>



$("#new").click(function (){                 
  alertify.notify('Comprobando campos..', 'success', 5, function(){});
   });


</script>

</body>
</html>
