//Este programa se encarga de cargar todas las páginas dentro del contenido de iframe, al dar click en una opción solamente el contenido debajo del menú se recargará facilitando la navegación del usuario.
function initPage(){
	document.getElementById("work").style.display="none";//captura el ID del iframe y no muestra ningún contenido
}
//function cargarPagina(pagina){
//	document.getElementById("work").style.display="block";
//	document.getElementById("work").src=pagina;
//	}
function cargarPagina(pagina) {//función para cargar la página
var ajax;
ajax = ajaxFunction();//función ejax

ajax.open("POST", pagina, true);//llama a la página usando el método post

ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");//llama al contenido
ajax.onreadystatechange = function(){//función anónima que llama al estado de la página

if (ajax.readyState == 4){
 document.getElementById("work").innerHTML= 'cargando' + '<img src="../images/load.gif">' ;
 document.getElementById("work").style.display="block";//bloquea el contenido hasta que este se abra
 document.getElementById("work").src=pagina;//carga la página seleccionada por el usuario

}}
ajax.send(null);//envío
}

