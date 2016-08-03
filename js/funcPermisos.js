function cargarPagina(pagina) {
var ajax;
ajax = ajaxFunction();

ajax.open("POST", pagina, true);

ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
ajax.onreadystatechange = function(){

if (ajax.readyState == 4){
	document.getElementById("work").innerHTML= 'cargando' + '<img src="../images/load.gif">' ;
document.getElementById("work").style.display="block";
document.getElementById("work").src=pagina;

}}
ajax.send(null);
}