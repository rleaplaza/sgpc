function cargarUnidad(str){
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
					 document.getElementById("unidad").innerHTML=xmlhttp.responseText;
					 }
				 }
				 xmlhttp.open("GET","../view/cargarUnidad.php?idmaterial="+str,true);
				 xmlhttp.send();
	}