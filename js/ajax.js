function ajaxFunction() {
var xmlHttp;//define el objeto ajax
try {
// Firefox, Opera 8.0+, Safari
xmlHttp=new XMLHttpRequest(); //instancia al navegador
return xmlHttp;
} catch (e) {
// Internet Explorer
try {//instancia a los objetos según el navegador que se esté utilizando
         xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
         return xmlHttp;
} catch (e) {
                try { //navegador internex explorer
                      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  return xmlHttp;
}              catch (e) {
               alert("Tu navegador no soporta AJAX!");
              return false;
            }}}
}