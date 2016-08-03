function cargarPagina(pagina) {
var ajax;
ajax = ajaxFunction();

ajax.open("POST", pagina, true);

ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
ajax.onreadystatechange = function(){

if (ajax.readyState == 4){
	document.getElementById("url").innerHTML= 'cargando' + '<img src="../../images/ajax.gif">' ;
document.getElementById("url").style.display="block";
document.getElementById("url").src=pagina;

}}
ajax.send(null);
}