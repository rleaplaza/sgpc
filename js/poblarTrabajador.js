function trabajador(str,idproyecto){
	var xmlhttp;
	if(str==''){
		document.getElementById('txtHint').innerHTML="";
		return;
		}
     if(window.XMLHttpRequest){
		 xmlhttp=new XMLHttpRequest();
		 }else{
			 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			 }
			 xmlhttp.onreadystatechange=function(){
				 if(xmlhttp.readyState==4 && xmlhttp.status==200){
					 document.getElementById("trabajador").innerHTML=xmlhttp.responseText;
					 }
				 }
				 xmlhttp.open("GET","../view/cargarTrabajador.php?idcargo="+str+"&idproyecto="+idproyecto,true);
				 xmlhttp.send();
	}