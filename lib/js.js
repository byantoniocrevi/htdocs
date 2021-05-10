				

				//Permitimos hacer visible el campo de la contraseña en el login
				function passwordvisible() {
					var x = document.getElementById("password1");
					if (x.type === "password") {
						x.type = "text";
					} else {
						x.type = "password";
					}
					var y = document.getElementById("password2");
					if (y.type === "password") {
						y.type = "text";
					} else {
						y.type = "password";
					}
				}
				//validamos los campos de registro 
				function validarformregister() {
				var nombre = document.formulario1.nombre.value;
				var mail = document.formulario1.email.value;
				var pass1 = document.formulario1.password.value;
				var pass2 = document.formulario1.password2.value;
				var emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

						if (!emailRegex.test(mail)){
				document.getElementById('labelmail').innerHTML = '¡Debes introducir un correo válido!';
				document.getElementById("labelmail").style.color = "red";
			}else{
document.getElementById('labelmail').innerHTML = '';

			}
		//	console.log(mail);
				if (nombre == "") {
				document.getElementById('labelnombre').innerHTML = '¡Debes introducir un nombre!';
				document.getElementById("labelnombre").style.color = "red";
				}else{
			document.getElementById('labelnombre').innerHTML = '';

				}


				if (pass1 == "") {
				document.getElementById('labelpass1').innerHTML = '¡Debes introducir una contraseña!';
				document.getElementById("labelpass1").style.color = "red";
			}else{
document.getElementById('labelpass1').innerHTML = '';


			}

					if (pass2 == "") {
				document.getElementById('labelpass2').innerHTML = '¡Debes repetir la contraseña!';
				document.getElementById("labelpass2").style.color = "red";
			}else{
				document.getElementById('labelpass2').innerHTML = '';
			}

			if(pass1 != pass2){
				document.getElementById('labelpass2').innerHTML = '¡Las contraseñas no coinciden!';
				document.getElementById("labelpass2").style.color = "red";

			}else{
				document.getElementById('labelpass2').innerHTML = '';
			}

		}




function editar(){
//permito poder editar los campos necesarios para el tecnico
var precio = document.getElementById('precio');
var marca = document.getElementById('marca');
var modelo = document.getElementById('modelo');
var nserie = document.getElementById('nserie');
var detalles = document.getElementById('detalles');
var estado = document.getElementById('estado');
precio.readOnly = false;
marca.readOnly = false;
modelo.readOnly=false;
nserie.readOnly=false;
detalles.readOnly=false;
estado.disabled=false;
}

//OnInit de manera que pueda lanzar el mensaje de saludo conm datesin necesidad de acceder desde ningún botón
window.onload = function() {

  saludar();
  fancybox();
  borraralerts();
};
function saludar(){
		var actual = "";
var fecha = new Date();
var añoactual = fecha.getFullYear();
var horactual = fecha.getHours();
var minutoactual  = fecha.getMinutes();
var segundosactual = fecha.getSeconds();

if((horactual>7) && (horactual<14)){
actual="Buenos dias";
}else if((horactual>=14)&&(horactual<=21)){
	actual ="Buenas tardes";
}else if((horactual>=22)){
	actual = "Buenas noches";
}
//console.log(horactual);
//console.log(actual);
var saludo = document.getElementById('saludo').innerHTML = actual;
}


//carrusel de imágenes
function fancybox(){ 
$(function(){
        $("#galeria a").fancybox({
        helpers:{
        title:{
        type:'over'}
        },
                
      }); // Fin de la función FancyBox
    }); // Fin de la funcion JQuery

}



function borraralerts(){

	    $(function(){
      $("#borrar").hover(function(){
        $("#borrar").hide(3000);
      });
    });
}


//mostramos la hora en la home de manera actualizada
 function mostrarhora(){
myDate = new Date();
hours = myDate.getHours();
minutes = myDate.getMinutes();
seconds = myDate.getSeconds();
if (hours < 10) hours = 0 + hours;
if (minutes < 10) minutes = "0" + minutes;
if (seconds < 10) seconds = "0" + seconds;
$("#horaactuals").text(hours+ ":" +minutes+ ":" +seconds);
setTimeout("mostrarhora()", 1000);
}
setTimeout("mostrarhora()", 1000);

//obtenemos fecha y hora para indicar el ultimo login mediante LocalStorage
 function obtenerfechayhora(){
myDate = new Date();
dia = myDate.getDate();
mes = myDate.getMonth()+1;
year = myDate.getFullYear();

h = myDate.getHours();
m = myDate.getMinutes();
fecha = dia+ "/" + mes + "/" +year + "  (" + h + ":" + m + ")";
return fecha;
 }


//registramos la fecha y hora en la que hacemos login para despues mostrarla en la home
function registrarlogin (){
if (typeof(Storage) !== 'undefined') {
var fecha = obtenerfechayhora();
localStorage.setItem("iniciosesion", fecha);
var datesesion = localStorage.getItem("iniciosesion");
}
}
//mostramos la fecha y hora en la que hemos hecho el último login (lo mostramos en la home)
function mostramoslogin(){

	if (typeof(Storage) !== 'undefined') {
var date = localStorage.getItem("iniciosesion");
document.getElementById("textoultm").innerHTML = "Último login a TecnoPlux: ";
document.getElementById("fechaactual").innerHTML =  date;
}
}


//la direccion ip la recibimos desde el localstorage y mostramos mediante la api ipapi.co la ubicación de la IP
//nos devuelve un json y dentro del json elijo el campo que me interesa, que en este caso es city, pero hay mas campos podria coger el que me interesara, en este
//caso solo me interesa mostrar (crevillent), puede variar segun el proveedor de internet, en mi casa si me devuelve crevillent.
function apimostrarubicacion(ip){
$.ajax({
	url: 'https://ipapi.co/' + ip + "/json",
	dataType: 'json',
	success: function (json) {
		$("#ubicacion").text(json.city);
		
	}
});

}


/* UBICADO EN HOME

	$(document).ready(function(){
		$("#mostrar").click(function(){
			$('#galeriajquery').show(300);


		 });
		$("#ocultar").click(function(){

			$('#galeriajquery').hide(3000);
			
		 });
	});

	*/
/* UBICADO EN LOGIN
	function get_ip(obj){
		var ip = obj.ip;
		sessionStorage.setItem('ip', ip)
	}

	*/

	// LIMPIO EN EL LOGOUT 
/*
localStorage.clear()
sessionStorage.clear()

*/