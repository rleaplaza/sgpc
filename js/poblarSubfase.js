function Subfase(str){
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
					 document.getElementById("idsubfase").innerHTML=xmlhttp.responseText;
					 }
				 }
				 xmlhttp.open("GET","../view/cargarSubfase.php?idfase="+str,true);
				 xmlhttp.send();
	}