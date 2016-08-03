// JavaScript Document
// Este programa se encarga de generar ventanas modales usando JS y ajax
//Contiene funciones que se encargan de abrir dichas ventanas. 
//Cada función es invocada desde los programas php
function objetoAjax(){
 var xmlhttp=false;//define el nombre del objeto
 try {
  xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");//instacia al navegador web
 } catch (e) {
  try {
   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (E) {
   xmlhttp = false;
  }
 }
 if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
  xmlhttp = new XMLHttpRequest();
 }
 return xmlhttp;
}
//función para mostrar gráficos de cantidad de accesos por usuario en diferentes meses
function mostrar(){
	var posicionTipo=document.getElementById("tipo").options.selectedIndex;//captura el valor del tipo de grágico
	var posicionAnio=document.getElementById("anio").options.selectedIndex;//captura el valor de anio
	var posicionMes=document.getElementById("mes").options.selectedIndex;//valor de mes
	var anio=document.getElementById("anio").options[posicionAnio].value;//define la posición del arreglo
	var mes=document.getElementById("mes").options[posicionMes].value;
	var tipo=document.getElementById("tipo").options[posicionTipo].value;
	if(anio=="" || mes=="" || tipo==""){//validación para pedir al usuario el ingreso de estos parámetros para el gráfico
		alert("Debe seleccionar las tres opciones de para imprimir el gráfico");
		}else if(tipo=="barra"){
	var url="../reportes/administracion/grSesion?anio="+anio+"&mes="+mes;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");		
			} else if(tipo=="torta"){
				var url="../reportes/administracion/grSesiontorta?anio="+anio+"&mes="+mes;//envía las variables mediante url
	objwindow=window.open(url,"","width=900","height=100");
				}
		}
//función para desplegar los gráficos en barra y torta referentes a costos de actividad
function sendGrcostoAc(){
	var idactividad=document.getElementById("idactividad").value;//captura del ID de actividad
	var costo_prog=document.getElementById("costoprogramado").value;//costo programado  
	var costo_real=document.getElementById("costoreal").value; //costo real
	var posicionTipo=document.getElementById("tipo").options.selectedIndex;//posicion del tipo de gráfico
	var tipo=document.getElementById("tipo").options[posicionTipo].value;//valor del tipo de gráfico
	if(tipo=="barra"){//direge al gráfico en barra
		var url="../reportes/proyectos/grCostoAct?idactividad="+idactividad+"&costo_prog="+costo_prog+"&costo_real="+costo_real;//envía las variables mediante url
objwindow=window.open(url,"","width=800","height=100");	
		} else if(tipo=="torta"){//dirige al tipo de gráfico torta
			var url="../reportes/proyectos/grCostoActpie?idactividad="+idactividad+"&costo_prog="+costo_prog+"&costo_real="+costo_real;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
			} else if(tipo==""){//mensaje que indica que debe seleccionar un tipo de gráfico
				alert("Debe seleccionar un tipo de gráfico");
				} 
	}
	//función para mostrar el porcentaje de avance programado en barras
	function sendGPorcentaje(){  
	    var proyecto=document.getElementById("proyecto").value;
		var duracionPr=document.getElementById("duracionpr").value; 
		var duracionReal=document.getElementById("duracionreal").value;
		var url="../reportes/proyectos/grPorcentaje?proyecto="+proyecto+"&duracionpr="+duracionPr+"&duracionreal="+duracionReal;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
		}
//función para mostrar la ventana modal para el gráfico de utilidad de materiales
function sendGmat(){
	//captura de variables mediante su identificador html
	var idactividad=document.getElementById("idactividad").value;
	var actividad=document.getElementById("actividad").value;
	var posicionMaterial=document.getElementById("idmaterial").options.selectedIndex;
	var material=document.getElementById("idmaterial").options[posicionMaterial].value;
	var posicionTipo=document.getElementById("tipo").options.selectedIndex;
	var tipo=document.getElementById("tipo").options[posicionTipo].value;
	if(material!=""){
	if(tipo=="barra"){//verifica si el tipo de gráfico es barra
		var url="../reportes/proyectos/grMat?idactividad="+idactividad+"&actividad="+actividad+"&material="+material;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
		} else if(tipo=="torta"){//verifica si el tipo de gráfico es de torta
			var url="../reportes/proyectos/grMatpie?idactividad="+idactividad+"&actividad="+actividad+"&material="+material;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
			}else if(tipo==""){
				alert("Debe seleccionar las listas desplegables de gráfico y material");
				} 
	}else{
		alert("Sin material asignado");
		}
	}
	//función para graficar el uso de equipamiento
	function sendGeq(){
	//captura de variables mediante su identificador html
	var idactividad=document.getElementById("idactividad").value;
	var actividad=document.getElementById("actividad").value;
	var posicionEq=document.getElementById("idequipamiento").options.selectedIndex;
	var equipamiento=document.getElementById("idequipamiento").options[posicionEq].value;
	var posicionTipo=document.getElementById("tipo").options.selectedIndex;
	var tipo=document.getElementById("tipo").options[posicionTipo].value;
	if(equipamiento!=""){
	if(tipo=="barra"){//verifica si el tipo de gráfico es barra
		var url="../reportes/proyectos/grEq?idactividad="+idactividad+"&actividad="+actividad+"&equipamiento="+equipamiento;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
		} else if(tipo=="torta"){//verifica si el tipo de gráfico es de torta
			var url="../reportes/proyectos/grEqpie?idactividad="+idactividad+"&actividad="+actividad+"&equipamiento="+equipamiento;//envía las variables mediante url
objwindow=window.open(url,"","width=800","height=100");	
			}else if(tipo==""){
				alert("Debe seleccionar las listas desplegables de gráfico y equipamiento");
				} 
	}else{
		alert("Sin equipamiento programado");
		}
	}
	//función que envía al gráfico de avance de trabajadores por actividad
function sendGtr(){
	var idactividad=document.getElementById("idactividad").value;
	var actividad=document.getElementById("actividad").value;
	var posicionTipo=document.getElementById("tipo").options.selectedIndex;
	var tipo=document.getElementById("tipo").options[posicionTipo].value;
	var unidad=document.getElementById("unidades").value;
	if(tipo=="barra"){
		var url="../reportes/proyectos/grTrab?idactividad="+idactividad+"&actividad="+actividad+"&unidad="+unidad;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
		}else if(tipo=="torta"){
			var url="../reportes/proyectos/grTrabpie?idactividad="+idactividad+"&actividad="+actividad+"&unidad="+unidad;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
			}else if(tipo==""){
				alert("Seleccione un tipo de gráfico");
				}
	}
	//función que envia al gráfico de diferencia de duracion en días de un proyecto
function sendGrduracion(){
	var idproyecto=document.getElementById("idproyecto").value;
	var duracion_prog=document.getElementById("duracionpr").value;
	var duracion_real=document.getElementById("duracionreal").value;
	var posicionTipo=document.getElementById("tipo").options.selectedIndex;//captura el valor del dropdown tipo
	var tipo=document.getElementById("tipo").options[posicionTipo].value;
	if(tipo=="barra"){//si el tipo de gráfico es barra en
	var url="../reportes/proyectos/grDuracion?idproyecto="+idproyecto+"&duracion_prog="+duracion_prog+"&duracion_real="+duracion_real;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
	}else if(tipo=="torta"){
		var url="../reportes/proyectos/grDuracionPie?idproyecto="+idproyecto+"&duracion_prog="+duracion_prog+"&duracion_real="+duracion_real;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
	}else if(tipo==""){
		alert("Debe seleccionar un tipo de gráfico");
		}
	}
	//función que envía al gráfico de diferencia de costos de un proyecto
function sendGrcosto(){
	var idproyecto=document.getElementById("idproyecto").value;
	var costoProg=document.getElementById("costoprog").value;
	var costoReal=document.getElementById("costoReal").value;
	var posicionTipo=document.getElementById("tipo").options.selectedIndex;//captura el valor del dropdown tipo
	var tipo=document.getElementById("tipo").options[posicionTipo].value;
	if(tipo=="barra"){
		var url="../reportes/proyectos/grCosto?idproyecto="+idproyecto+"&costoProg="+costoProg+"&costoReal="+costoReal;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
		}else if(tipo=="torta"){
			var url="../reportes/proyectos/grCostoPie?idproyecto="+idproyecto+"&costoProg="+costoProg+"&costoReal="+costoReal;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
		}else if(tipo==""){
			alert("Debe seleccionar un tipo de gráfico");
			}
	
	}
//función para enviar a los graficos de progreso del proyecto
function sendGrProgreso(){
	var idproyecto=document.getElementById("idproyecto").value;
	var progreso=document.getElementById('progreso').value;
	var posicionTipo=document.getElementById("tipo").options.selectedIndex;//captura el valor del dropdown tipo
	var tipo=document.getElementById("tipo").options[posicionTipo].value;
	if(tipo=="barra"){
		var url="../reportes/proyectos/grProgreso?idproyecto="+idproyecto+"&progreso="+progreso;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
		}else if(tipo=="torta"){
			var url="../reportes/proyectos/grProgresoPie?idproyecto="+idproyecto+"&progreso="+progreso+"&progreso="+progreso;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
	}else if(tipo==""){
		 alert("Debe seleccionar un tipo de gráfico");
		}
}
//función para enviar a gráficos de cantidad y porcentaje de cargos participantes en el proyecto
function sendGCargo(){
	var idproyecto=document.getElementById("idproyecto").value;
	var posicionTipo=document.getElementById("tipo").options.selectedIndex;//captura el valor del dropdown tipo
	var tipo=document.getElementById("tipo").options[posicionTipo].value;
	if(tipo=="barra"){
		var url="../reportes/proyectos/grCargo?idproyecto="+idproyecto;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
		}else if(tipo=="torta"){
			var url="../reportes/proyectos/grCargoPie?idproyecto="+idproyecto;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
	}	
}
//función que desplegará el gráfico de diferencias de costo programado y real por fases
function sendGCostoPrevisto(){ 
	var idproyecto=document.getElementById("idproyecto").value;
	var posidfase=document.getElementById("fase").options.selectedIndex;
	var idfase=document.getElementById("fase").options[posidfase].value; 
	var url="../reportes/proyectos/grCostoPrevisto?idproyecto="+idproyecto+"&idfase="+idfase;
	objwindow=window.open(url,"","width=800","height=100");	
	}
	//función para enviar al gráfico curva de gastos real y programado
	function grGastoCurva(){
	var posicionIdfase=document.getElementById("idfase").options.selectedIndex;//captura el valor del dropdown tipo
	var idfase=document.getElementById("idfase").options[posicionIdfase].value;
	var fec1=document.getElementById("fec1").value;
	var fec2=document.getElementById("fec2").value;
	var url="../reportes/proyectos/grGastoCurva?idfase="+idfase+"&fec1="+fec1+"&fec2="+fec2;
	objwindow=window.open(url,"","width=800","height=100");	
		}
//función para desplegar el gráfico de detalle de costos en tipo torta
function sendGDetCosto(){
	var idactividad=document.getElementById("idactividad").value;
	var url="../reportes/proyectos/grDetCostoActividad?idactividad="+idactividad;
objwindow=window.open(url,"","width=800","height=100");	
	}
//función que envia al formulario de plan de compra de materiales	
function plan(desc, idopcion,cantidad){
	var url="fplancompra?desc="+desc+"&idopcion="+idopcion+"&cantidad="+cantidad;//define la url de envío y las variables
objwindow=window.open(url,"","width=800","height=100");	
	}
//función para asignar la actividad al trabajador	
function asignar(idactividad, fase,actividad, idplan,idopcion,idproyecto){
	
	var url="asignaCargo?idactividad="+idactividad+"&fase="+fase+"&actividad="+actividad+"&idplan="+idplan+"&idopcion="+idopcion+"&idproyecto="+idproyecto;
	objwindow=window.open(url,"","width=800","height=100");	
	}
//función para asignar la actividad a materiales		
function asignarM(idactividad, fase,actividad, idplan,idopcion,idproyecto){
	var url="asignaMat?idactividad="+idactividad+"&fase="+fase+"&actividad="+actividad+"&idplan="+idplan+"&idopcion="+idopcion+"&idproyecto="+idproyecto;
	objwindow=window.open(url,"","width=800","height=100");	
	}
	
	//función para solicitar materiales		
function solicitarMat(idactividad, fase,actividad, idplan,idopcion,idproyecto,idmaterial,fechas){
	var url="solicitarMaterial?idactividad="+idactividad+"&fase="+fase+"&actividad="+actividad+"&idplan="+idplan+"&idopcion="+idopcion+"&idproyecto="+idproyecto+"&idmaterial="+idmaterial+"&fechas="+fechas;
objwindow=window.open(url,"","width=800","height=100");	
	}
	
//función para asignar la actividad a maquinaria
function asignarMq(idactividad, fase,actividad, idplan,idopcion,idproyecto){
var url="asignaMaq?idactividad="+idactividad+"&fase="+fase+"&actividad="+actividad+"&idplan="+idplan+"&idopcion="+idopcion+"&idproyecto="+idproyecto;
	objwindow=window.open(url,"","width=800","height=100");	
	}

//función para enviar a la ventana de definicón de calendario de hroas
function calendario(ci,idopcion,trabajador,cargo){
	var url="defcalendario?ci="+ci+"&idopcion="+idopcion+"&trabajador="+trabajador+"&cargo="+cargo;
	objwindow=window.open(url,"","width=800","height=100");	
	}
//función para consultar el calendario del trabajador	
function consultaCalendario(ci,idopcion,cargo){
	var url="listCalendario?idopcion="+idopcion+"&ci="+ci+"&cargo="+cargo;
	objwindow=window.open(url,"","width=800","height=100");	
	}
//función para la edición de avance de actividades	
function editAvance(idactividad,ci,nombre){
	var url="editAvance?idactividad="+idactividad+"&ci="+ci+"&nombre="+nombre;
    objwindow=window.open(url,"","width=800","height=100");	
	}
//función para consultar precios unitarios
function ConsultaCosto(idactividad){
	var url="consultarCosto?idactividad="+idactividad;
	objwindow=window.open(url,"","width=800","height=100");	
	}	
//función para consultar el plan de proyectos
function consultaPlan(idproyecto,idopcion){
	var url="consultarPlan?idproyecto="+idproyecto+"&idopcion="+idopcion;
	objwindow=window.open(url,"","width=800","height=100");	
	}

//función para editar la información de actividades
function editActividad(idactividad,estado,total_avance){
	var url="edit/editActividad?idactividad="+idactividad+"&estado="+estado+"&total_avance="+total_avance;
	objwindow=window.open(url,"","width=800","height=100");	
	}

//función para consultar informe de avances por trabajador en todas las fechas
function consultarInforme(idactividad,ci,nombre){
	var url="consultaInforme?idactividad="+idactividad+"&ci="+ci+"&nombre="+nombre;
	objwindow=window.open(url,"","width=800","height=100");	
	}
//función para consultar materiales asignados a la actividadd
function consultaMat(idactividad,nombreActividad,idopcion){
	var url="consultaMatAsignado?idactividad="+idactividad+"&nombreActividad="+nombreActividad+"&idopcion="+idopcion;
	objwindow=window.open(url,"","width=800","height=100");	
	}
 
//funcion para consultar pedidos de materiales 
function consultaPedido(idpedido,idopcion,idactividad,idempleado,idproyecto,idplan,estado){
	var url="consultaPedidoMaterial?idpedido="+idpedido+"&idopcion="+idopcion+"&idactividad="+idactividad+"&idempleado="+idempleado+"&idproyecto="+idproyecto+"&idplan="+idplan+"&estado="+estado;
	objwindow=window.open(url,"","width=800","height=100");	
	}
	
//función para cargar el formulario de avance por maquinaria y equipo
function editAvanceMaq(idactividad,idmaquinaria,descripcion){
	var url="editUsoMaq?idactividad="+idactividad+"&idmaquinaria="+idmaquinaria+"&descripcion="+descripcion;
	objwindow=window.open(url,"","width=800","height=100");	
	}

//función para cargar el formulario de cantidad de materiales usados
function editInformeMat(idactividad,idmaterial){
	var url="editUsoMaterial?idactividad="+idactividad+"&idmaterial="+idmaterial;
	objwindow=window.open(url,"","width=800","height=100");	
	}

//función para cargar el listado de informe de cantidad usada de materiales
function consultarInformeMat(idactividad, idmaterial,unidadTrabajo){
var url="consultaInfMaterial?idactividad="+idactividad+"&idmaterial="+idmaterial+"&unidadTrabajo="+unidadTrabajo;
	objwindow=window.open(url,"","width=800","height=100");	
	}

//función para editar avances de maquinaria
function editAvanceMaq(idactividad,idmaquinaria,descripcion){
var url="editUsoMaq?idactividad="+idactividad+"&idmaquinaria="+idmaquinaria+"&descripcion="+descripcion;
objwindow=window.open(url,"","width=800","height=100");	
	}
//función para consultar informe de avances de maquinaria
function consultarInformeMaq(idactividad,idmaquinaria,descripcion){
var url="consultaInfMaquinaria?idactividad="+idactividad+"&idmaquinaria="+idmaquinaria+"&descripcion="+descripcion;
objwindow=window.open(url,"","width=800","height=100");	
	}
	//función para la edición de feriados
function editFeriado(idferiado){
	var url="edit/editFeriado?idferiado="+idferiado;
objwindow=window.open(url,"","width=800","height=100");	
	}
//función para cargar el gráfico de progreso de actividades 
function printAvance(){
	var avance_prog=document.getElementById("avanceprog").value; 
	var avance_real=document.getElementById("avancereal").value;
	var idactividad=document.getElementById("idactividad").value;
	var unidad=document.getElementById("unidades").value;
	var progreso=document.getElementById("progreso").value;
	var posicionTipo=document.getElementById("tipo").options.selectedIndex;//captura el valor del dropdown tipo
	var tipo=document.getElementById("tipo").options[posicionTipo].value;
	if(tipo=="torta"){
	var url="../reportes/proyectos/progresoAct?idactividad="+idactividad+"&avanceProg="+avance_prog+"&avanceReal="+avance_real+"&unidad="+unidad+"&progreso="+progreso;
objwindow=window.open(url,"","width=800","height=100");	
	}else if(tipo=="barra"){
			var url="../reportes/proyectos/progresoActbar?idactividad="+idactividad+"&avanceProg="+avance_prog+"&avanceReal="+avance_real+"&unidad="+unidad+"&progreso="+progreso;
	
	objwindow=window.open(url,"","width=800","height=100");	
		} else if(tipo=="linea"){
			var url="../reportes/proyectos/progresoActLinea?idactividad="+idactividad+"&avanceProg="+avance_prog+"&avanceReal="+avance_real+"&unidad="+unidad+"&progreso="+progreso;
objwindow=window.open(url,"","width=800","height=100");	
			}else if(tipo==""){
			alert("Seleccione un tipo de gráfico");
			}
	}
//función para imprimir progreso de fase
function sendProgFase(){
	var idfase=document.getElementById("idfase").value;
	var fase=document.getElementById("fase").value;
	var actProg=document.getElementById("actpr").value;
	var actcon=document.getElementById("actcon").value;
	var posicionTipo=document.getElementById("tipo").options.selectedIndex;//captura el valor del dropdown tipo
	var tipo=document.getElementById("tipo").options[posicionTipo].value;
	var url="";
	if(tipo=="torta"){
	url="../reportes/proyectos/progresoFasePie?idfase="+idfase+"&fase="+fase+"&actProg="+actProg+"&actcon="+actcon;		
		objwindow=window.open(url,"","width=800","height=100");	
		}else if(tipo=="barra"){
url="../reportes/proyectos/progresoFase?idfase="+idfase+"&fase="+fase+"&actProg="+actProg+"&actcon="+actcon;
			objwindow=window.open(url,"","width=800","height=100");	
			}else if(tipo==""){
				alert("Debe seleccionar un tipo de gráfico");
				}
	}
	//función para imprimir el diagrama de gantt
function gantt(){
	var idfase=document.getElementById("idfase").value;
	var fase=document.getElementById("fase").value;
	var actProg=document.getElementById("actpr").value;
	var actcon=document.getElementById("actcon").value;
	var posicionTipo=document.getElementById("tipo").options.selectedIndex;//captura el valor del dropdown tipo
	var tipo=document.getElementById("tipo").options[posicionTipo].value;
	var url="";
	url="../reportes/proyectos/ganttFase?idfase="+idfase+"&fase="+fase+"&actProg="+actProg+"&actcon="+actcon;
	objwindow=window.open(url,"","width=800","height=100");	
	}
	//función para imprimir consumo de material en base al proyecto
function sendMaterial(){
	//captura de variables mediante su identificador html
	var idproyecto=document.getElementById("idproyecto").value;
	var proyecto=document.getElementById("proyecto").value;
	var posicionMaterial=document.getElementById("idmaterial").options.selectedIndex;
	var material=document.getElementById("idmaterial").options[posicionMaterial].value;
	var posicionTipo=document.getElementById("tipo").options.selectedIndex;
	var tipo=document.getElementById("tipo").options[posicionTipo].value;
	if(material!=""){
	if(tipo=="barra"){//verifica si el tipo de gráfico es barra
		var url="../reportes/proyectos/grMatProy?idproyecto="+idproyecto+"&proyecto="+proyecto+"&material="+material;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
		} else if(tipo=="torta"){//verifica si el tipo de gráfico es de torta
			var url="../reportes/proyectos/grMatProypie?idproyecto="+idproyecto+"&proyecto="+proyecto+"&material="+material;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
			}else if(tipo==""){
				alert("Debe seleccionar las listas desplegables de gráfico y material");
				} 
	}else{
		alert("Sin material programado");
		}
	}
	//función para imprimir consumo de equipamiento en base al proyecto
	function sendMaquinaria(){
	//captura de variables mediante su identificador html
	var idproyecto=document.getElementById("idproyecto").value;
	var proyecto=document.getElementById("proyecto").value;
	var posicionMaquinaria=document.getElementById("idequipamiento").options.selectedIndex;
	var equipamiento=document.getElementById("idequipamiento").options[posicionMaquinaria].value;
	var posicionTipo=document.getElementById("tipo").options.selectedIndex;
	var tipo=document.getElementById("tipo").options[posicionTipo].value;
	if(equipamiento!=""){
	if(tipo=="barra"){//verifica si el tipo de gráfico es barra
		var url="../reportes/proyectos/grEqProy?idproyecto="+idproyecto+"&proyecto="+proyecto+"&equipamiento="+equipamiento;//envía las variables mediante url
	objwindow=window.open(url,"","width=800","height=100");	
		} else if(tipo=="torta"){//verifica si el tipo de gráfico es de torta
		var url="../reportes/proyectos/grEqProypie?idproyecto="+idproyecto+"&proyecto="+proyecto+"&equipamiento="+equipamiento;//envía las variables mediante url
objwindow=window.open(url,"","width=800","height=100");	
			}else if(tipo==""){
				alert("Debe seleccionar las listas desplegables de gráfico y equipamiento");
				} 
	}else{
		alert("Sin equipamiento programado");
		}
	}
function aprobarActividad(idactividad){
	var url="formAprobaractividad?idactividad="+idactividad;
objwindow=window.open(url,"","width=800","height=100");	
	}