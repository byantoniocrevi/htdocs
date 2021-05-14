<?php
require("./lib/reparacion.php");
require("./lib/conexion.php");
require("menu.php");
?>
<html>
<head>
	<title>TecnoPlux - Home</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="Tecnoplux">
  <!-- Add jQuery library -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
  <!-- Add jQuery library -->
  <!-- Add fancyBox -->
  <link rel="stylesheet" href="fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
  <script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
  <!-- Add fancyBox -->
</head>
<body>
<?php
 $nombre = $_SESSION["nombre"];

?>

<?php
if($tipo==1){
?>
<div class="b-example-divider"></div>
  <div class="container px-4 py-5" id="hanging-icons">
    <h2 class="pb-2 border-bottom"><label id="saludo"> </label> <?php echo $nombre; ?>, Gestiona tus reparaciones en TecnoPlux <a id="horaactuals" style="color:white"> </a><br> <a id="textoultm"><a id="fechaactual" style="color:white"> </a></a><a id="ubicacion1"> </a><a id="ubicacion" style="color:white"> </a></h2>
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
      <div class="col d-flex align-items-start">
        <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
       <i class="fas fa-wrench"></i>

        </div>
        <div>
          <h2>Solicita una reparación</h2>
          <p>Para poder reparar tu dispositivo deberás comenzar solicitando una reparación, indicando los detalles del dispositivo y los detalles de la posible avería.</p>
          <a href="./nuevareparacion.php" class="btn btn-primary">
            Solicitar reparacion
          </a>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
          <i class="fas fa-edit"></i>
        </div>
        <div>
          <h2>Visualiza tus reparaciones</h2>
          <p>Una vez hayas solicitado tu reparación podrás visitar el apartado "mis reparaciones" para comprobar el estado de esta y aportar/leer notas para el técnico.</p>
          <a href="./misreparaciones.php" class="btn btn-primary">
            Ver mis reparaciones
          </a>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
                 <i class="fas fa-print"></i>
        </div>
        <div>
          <h2>Visualiza tus facturas</h2>
          <p>Una vez la reparación haya finalizado y esté como completada te aparecerá en el apartado "mis facturas" la factura correspondiente a la reparación.</p>

          <a href="./misfacturas.php" class="btn btn-primary">
            Ver mis facturas
          </a>
          <br><hr>
             <button type="button" id="mostrar" class="btn btn-info">Ver galería</button>
<button type="button" id="ocultar" class="btn btn-warning">Ocultar galería</button>
        </div>
      </div>
    </div>
  </div>


<?php

}else{

?>

<div class="b-example-divider"></div>
  <div class="container px-4 py-5" id="hanging-icons">
    <h2 class="pb-2 border-bottom"><label id="saludo"> </label> <?php echo $nombre; ?>, Gestiona las reparaciones de los clientes <a id="horaactuals" style="color:white"> </a><br> <a id="textoultm"><a id="fechaactual" style="color:white"> </a> <a id="ubicacion1"> </a><a id="ubicacion" style="color:white"> </a></h2>
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
      <div class="col d-flex align-items-start">
        <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
       <i class="fas fa-wrench"></i>
        </div>
        <div>
          <h2>Gestiona las reparaciones</h2>
          <p>Como tecnico debes de gestionar las reparaciones de una manera eficaz.</p>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
      <i class="far fa-clipboard"></i>
        </div>
        <div>
          <h2>Aporta notas</h2>
          <p>Es importante comunicar bien al cliente los detalles de la reparación de una manera clara.</p>
     
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
                 <i class="far fa-check-circle"></i>
        </div>
        <div>
          <h2>Cliente satisfecho</h2>
          <p>Como tecnico debes de asegurar que el cliente final quede satisfecho, es nuestra prioridad.</p>
   <button type="button" id="mostrar" class="btn btn-primary">Ver galería</button>
<button type="button" id="ocultar" class="btn btn-warning">Ocultar galería</button>
        </div>
      </div>
    </div>
  </div>


<?php

}

?>

























    <div class="container"  style="padding-bottom: 10%">

      <div  id="galeriajquery" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

        <div class="col">

          <div class="card shadow-sm" id="galeria">

        <a href="images/carrusel-1.jpg" rel="galeria" title="Nuestros técnicos cualificados"><img src="images/carrusel-1.jpg" alt=""/>
          </a>

            <div class="card-body">
              <p class="card-text">Tenemos un gran equipo de soporte frente a cualquier tipo de incidencia con tu dispositivo, solicita ya la reparación de tu dispositivo.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    
                      </div>
              </div>
            </div>
          </div>
        </div>
    
    
    <div class="col">

          <div class="card shadow-sm" id="galeria">

        <a href="images/carrusel-2.jpg" rel="galeria" title="Servicio tecnico de apple autorizado"><img src="images/carrusel-2.jpg" alt=""/>
          </a>

            <div class="card-body">
              <p class="card-text">Somos servicio técnico de apple autorizado, porque sabemos que todo el que tiene un dispositivo de apple le tiene cariño.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    

                      </div>
        
              </div>
            </div>
          </div>
        </div>


<div class="col">


          <div class="card shadow-sm" id="galeria">

        <a href="images/carrusel-3.jpg" rel="galeria" title="Trabajamos con todas las marcas del mercado"><img src="images/carrusel-3.jpg" alt=""/>
          </a>

            <div class="card-body">
              <p class="card-text">Trabajamos con cualquier marca de teléfono, con nosotros tendrás tu teléfono reparado sea cual sea tu marca.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    

                      </div>
        
              </div>
            </div>
          </div>
        </div>




</div>




    </div>



<script>

	$(document).ready(function(){
		$("#mostrar").click(function(){
			$('#galeriajquery').show(300);


		 });
		$("#ocultar").click(function(){

			$('#galeriajquery').hide(3000);
			
		 });
	});

mostramoslogin();

var ipv4 = localStorage.getItem("ip");
     //   console.log(ipv4);
          apimostrarubicacion(ipv4);
   
   function apimostrarubicacion(ip){
   console.log(ip);
   $.ajax({
     url: 'https://ipapi.co/' + ip + "/json",
     dataType: 'json',
     success: function (json) {
       $("#ubicacion1").text("Te conectastes desde " + json.city);
   
   
   console.log(json.city);
       
     }
   });
   
   
   
   


$("#ubicacion").text(ubicacion);
}
</script>
<?php
include("./footer.php"); 
?>

</body>
</html>