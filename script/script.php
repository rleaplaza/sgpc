<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
#Programa desarrollado por Rodrigo Iván Lea Plaza Chávez
/*
Script de registro de módulos del sistema, permisos, creación del usuario admin, roles y asignaciones
*/
try{
	require_once("connect.php");//llama a la conexión global
$consulta=$dbh->prepare("select *from menu");//consulta el registro de menús
$consulta->execute();//ejecuta la instrucción
   if($consulta->rowCount()>0){
     echo "<img src=no.jpg height=20 width=20/>Error, insercion ya ejecutada<br>";
   }
     else{//inserción del menú principal
       $sql=$dbh->prepare("INSERT INTO `menu` (`IDmenu`, `nombreMenu`, `descripcion`, `fecCreacion`, `hraCreacion`) VALUES
(1, 'ADMIN', 'modulo general de seguridad y accesos del sistema ', '2014-11-14', '20:00:00'),
(2, 'PLANIFICACION ', 'modulo de planificacion de acciones para ejecutar proyectos', '2014-11-14', '20:00:00'),
(3, 'PERSONAL', 'modulo de control de recursos humanos', '2014-11-14', '20:00:00'),
(4, 'COMPRA Y ALQUILER', 'modulo de control de compra y alquiler de items para obras civiles', '2014-11-14', '20:00:00'),
(5, 'MANTENIMIENTO DE MAQUINARIA', 'modulo de control y reparacion de maquinaria', '2014-11-14', '20:00:00'),
(6, 'REPORTES', 'modulo de informes, graficos', '2014-11-14', '20:00:00'),
(7, 'CUSTOM MODULE', 'modulo de pruebas', '2014-03-01', '22:35:21'),
(8, 'ARCHIVOS', 'Modulo de gestion de archivos', '2014-04-02', '10:46:48'),
(9, 'INFORME DE AVANCES', 'Modulo de ejecucion de obras civiles', '2014-04-19', '20:01:22'),
(10, 'SEGUIMIENTO', 'Modulo de control y seguimiento de proyectos', '2014-04-19', '20:02:56'),
(11, 'EJECUCIONES', 'Modulo correspondiente a ejecucion de trabajos para proyecto', '2014-04-26', '21:52:04'),
(12, 'ALMACEN', 'Control de logistica de ingresos de items y salidas', '2014-04-29', '21:17:07'),
(13, 'CONTROL Y SEGUIMIENTO', 'modulo de control y seguimiento de proyectos carreteros', '2014-04-30', '09:47:48')");
      if( $sql->execute()) {
	echo "<img src=yes.jpg height=20 width=20/>Inserción de menú completa<br>";
      }else{
		  echo "<img src=no.jpg height=20 width=20/>Error al registrar los menus<br>";
		  }
}
#consulta de inserción de submenús
	$sql1=$dbh->prepare("INSERT INTO `submenu` (`IDsubMenu`, `IDmenu`, `nombreSubmenu`, `fecCreacion`, `hraCreacion`) VALUES  (1, 1, 'USUARIOS', '2014-11-16', '20:15:12'),
        (2, 1, 'ROLES ', '2014-11-16', '20:15:12'),
	    (3, 2, 'PUBLICACION DE PROYECTOS', '2014-11-16', '20:15:12'),
	    (4, 1, 'SESIONES', '2014-11-16', '20:15:12'),
        (6, 2, 'PROYECTOS', '2014-11-16', '20:15:12'),
		(7, 2, 'MANO DE OBRA', '2014-11-16', '20:15:12'),
		(8, 2, 'REQUERIMIENTOS', '2014-11-16', '20:15:12'),
		(9, 2, 'ACTIVIDADES', '2014-11-16', '20:15:12'),
		(10, 2, 'TRAMOS', '2014-11-16', '20:15:12'),
		(11, 2, 'CARGO MANO DE OBRA', '2014-11-16', '20:15:12'),
		(12, 2, 'ENCARGADOS DE MANO DE OBRA', '2014-11-16', '20:15:12'),
		(13, 2, 'PERSONAL TECNICO CLAVE', '2014-11-16', '20:15:12'),
		(14, 2, 'ROLES DE PARTICIPACION', '2014-11-16', '20:15:12'),
		(15, 2, 'RECEPCIONES POR PROYECTO', '2014-11-16', '20:15:12'),
		(16, 13, 'ANALISIS DE PRECIOS UNITARIOS', '2014-11-16', '20:15:12'),
		(17, 3, 'EMPLEADOS', '2014-11-16', '20:15:12'),
		(18, 3, 'DEPARTAMENTOS', '2014-11-16', '20:15:12'),
		(19, 3, 'CARGOS', '2014-11-16', '20:15:12'),
		(20, 3, 'ACTIVIDADES LABORALES', '2014-11-16', '20:15:12'),
		(21, 4, 'SOLICITUD DE ITEMS', '2014-11-16', '20:15:12'),
		(22, 4, 'PROVEEDORES', '2014-11-16', '20:15:12'),
		(23, 4, 'MATERIALES', '2014-11-16', '20:15:12'),
		(24, 4, 'MAQUINARIA ', '2014-11-16', '20:15:12'),
		(25, 4, 'SUMINISTROS', '2014-11-16', '20:15:12'),
		(26, 5, 'MAQUINARIA EN REPARACION', '2014-11-16', '20:15:12'),
		(27, 5, 'REPARACIONES', '2014-11-16', '20:15:12'),
		(28, 6, 'REPORTES PLANOS-USUARIOS', '2014-11-16', '20:15:12'),
		(29, 6, 'REPORTES PLANOS-PROYECTOS', '2014-11-16', '20:15:12'),
		(31, 6, 'REPORTES PLANOS-EMPLEADOS', '2014-11-16', '20:15:12'),
		(32, 1, 'ACCESOS', '2014-11-16', '20:15:12'),
		(33, 6, 'REPORTES GRAFICOS-PROYECTOS', '2014-11-16', '20:15:12'),
		(34, 1, 'AUDITORIA', '2014-11-16', '20:15:12'),
		(35, 1, 'MODULOS', '2014-11-16', '20:15:12'),
		(36, 4, 'REPORTE-COMPRA Y ALQUILER', '2014-11-16', '20:15:12'),
		(37, 6, 'REPORTE GRAFICO SESION', '2014-11-16', '20:15:12'),
		(38, 3, 'CONTROL DE ASISTENCIA', '2014-11-16', '20:15:12'),
		(39, 3, 'CONTROL DE PERMISOS', '2014-11-16', '20:15:12'),
		(40, 1, 'SUBMENU DE PRUEBA', '2014-03-03', '19:00:23'),
		(42, 1, 'SUBMENU PERZONALIZADO', '2014-03-03', '19:03:10'),
		(43, 7, 'CUSTOM SUBMENU', '2014-03-09', '14:58:49'),
		(44, 3, 'PLANILLAS', '2014-03-11', '10:20:19'),
		(45, 3, 'FORMULARIO DE EMPLEADOS', '2014-03-11', '11:36:14'),
		(46, 3, 'PROFESIONES', '2014-03-13', '12:14:40'),
		(47, 6, 'REPORTE POR SESION', '2014-03-13', '15:58:33'),
		(48, 2, 'FASES', '2014-03-21', '16:53:54'),
		(49, 2, 'SUBFASE', '2014-03-21', '16:56:26'),
		(50, 2, 'SOLICITUD MANO DE OBRA', '2014-03-21', '17:04:59'),
		(51, 1, 'MENSAJES DE AYUDA', '2014-03-21', '17:21:16'),
		(52, 6, 'REPORTE DE MANO DE OBRA', '2014-03-23', '21:27:32'),
		(53, 3, 'CONTRATACION DE TRABAJADORES', '2014-03-24', '09:54:42'),
		(54, 1, 'CALENDARIO', '2014-03-25', '20:28:20'),
		(55, 4, 'LISTADO DE MAQUINARIA', '2014-03-28', '18:36:32'),
		(56, 4, 'LISTADO DE MATERIALES', '2014-03-28', '18:36:47'),
		(57, 1, 'PARAMETROS', '2014-03-29', '18:42:26'),
		(58, 1, 'FORMULARIO DE PARAMETROS', '2014-03-29', '20:26:07'),
		(59, 6, 'REPORTE POR SOLICITUDES', '2014-03-31', '11:04:46'),
		(60, 6, 'REPORTE MANO DE OBRA', '2014-03-31', '11:06:26'),
		(61, 4, 'ALMACENES', '2014-03-31', '20:59:51'),
		(62, 4, 'COTIZACION', '2014-03-31', '21:04:53'),
		(63, 8, 'DOCUMENTOS DE ENTRADA', '2014-04-02', '10:47:13'),
		(64, 1, 'ENVIO DE MENSAJES', '2014-04-04', '11:18:25'),
		(65, 4, 'PEDIDOS', '2014-04-05', '17:02:10'),
		(66, 4, 'SOLICITUD DE MAQUINARIA', '2014-04-07', '09:37:49'),
		(67, 4, 'NOTAS DE REMISIÃ“N', '2014-04-11', '14:55:49'),
		(68, 6, 'COTIZACIONES', '2014-04-11', '18:06:22'),
		(69, 6, 'REPORTE GRAFICO DE MATERIALES', '2014-04-14', '16:06:27'),
		(70, 2, 'PLANIFICACION', '2014-04-15', '14:57:30'),
		(71, 2, 'ASIGNACION DE ACTIVIDADES', '2014-04-16', '15:03:36'),
		(72, 2, 'CONTROL DE PLANIFICACION', '2014-04-19', '16:52:50'),
		(73, 9, 'EJECUCION DE ACTIVIDADES', '2014-04-19', '20:03:57'),
		(74, 10, 'CONTROL DE SEGUIMIENTO', '2014-04-19', '20:05:02'),
		(75, 12, 'INCORPORACION DE ITEMS', '2014-04-19', '20:13:15'),
		(76, 4, 'PLANIFICACION DE COMPRAS', '2014-04-21', '20:29:21'),
		(77, 6, 'COMPRAS', '2014-04-21', '22:07:52'),
		(78, 3, 'CALENDARIO DE TRABAJADOR', '2014-04-24', '15:39:18'),
		(79, 9, 'CONTROL DE EJECUCIONES', '2014-04-26', '21:52:31'),
		(80, 6, 'PRECIOS UNITARIOS', '2014-04-29', '16:05:11'),
		(81, 13, 'SEGUIMIENTO GENERAL DEL PROYECTO', '2014-04-30', '09:49:09'),
		(82, 12, 'PEDIDO DE ITEMS', '2014-05-09', '11:59:26')");
   
	if( $sql1->execute()){
		echo "<img src=yes.jpg height=20 width=20/>Inserción de submenú completa<br>";
		}else{
			echo "<img src=no.jpg height=20 width=20/>Error al registrar los submenus<br>";
			}

 #Consulta de registro de opciones del sistema
   $sql2=$dbh->prepare("INSERT INTO `opcion` (`IDopcion`, `IDsubMenu`, `nombreOpcion`, `descripcion`, `url`, `estado`, `fecCreacion`, `hraCreacion`) VALUES
(1, 1, 'REGISTRO DE USUARIOS', 'control de registro de usuarios en el sistema', 'userlist.php', 'activo', '2014-11-18', '19:20:10'),
(2, 2, 'REGISTRO DE ROLES', 'control de registro de roles', 'rolelist.php', 'activo', '2014-11-18', '19:20:10'),
(3, 3, 'REGISTRO DE PUBLICACIONES', 'opcion de registro de publicaciones de proyectos', 'pubproyectos.php', 'activo', '2014-11-18', '19:20:10'),
(4, 4, 'LOG DE SESIONES', 'registro de sesiones de los usuarios', 'sessionlog.php', 'activo', '2014-11-18', '19:20:10'),
(6, 6, 'REGISTRO DE PROYECTOS', 'control de registro de proyectos de carreteras', 'logproyectos.php', 'activo', '2014-11-18', '19:20:10'),
(7, 7, 'REGISTRO DE MANO DE OBRA', 'opcion de registro de empleados de obras civiles', 'manoobra.php', 'activo', '2014-11-18', '19:20:10'),
(8, 8, 'REGISTRO DE REQUERIMIENTOS', 'registro de cheque de requerimientos para proyectos', 'req.php', 'activo', '2014-11-18', '19:20:10'),
(9, 9, 'REGISTRO DE ACTIVIDADES', 'opcion de control de actividades por tramo de un proyecto', 'formActividad.php', 'activo', '2014-11-18', '19:20:10'),
(10, 10, 'REGISTRO DE TRAMOS', 'opcion de registro de tramos carreteros para proyectos', 'listatramos.php', 'activo', '2014-11-18', '19:20:10'),
(11, 11, 'REGISTRO DE CARGOS DE MANO DE OBRA', 'control de cargos de mano de obra', 'cmanoobra.php', 'activo', '2014-11-18', '19:20:10'),
(12, 12, 'REGISTRO DE ENCARGADOS DE MANO DE OBRA', 'control de encargados que ofrecen mano de obra civil', 'encmanoobra.php', 'activo', '2014-11-18', '19:20:10'),
(13, 13, 'DESIGNACION DE PERSONAL TECNICO', 'control de designacion de empleados para proyectos de carreteras', 'proyectos.php', 'activo', '2014-11-18', '19:20:10'),
(14, 14, 'REGISTRO DE ROLES DE PARTICIPACION', '', 'rolepartlist.php', 'inactivo', '2014-11-18', '19:20:10'),
(15, 15, 'REGISTRO DE RECEPCIONES', 'control de recepciones de empleados de mano de obra', 'recepcionlist.php', 'activo', '2014-11-18', '19:20:10'),
(16, 16, 'PRECIOS UNITARIOS ', 'control de precios unitarios por item de trabajo de obras civiles', 'precunitarios.php', 'activo', '2014-11-18', '19:20:10'),
(18, 17, 'REGISTRO DE EMPLEADOS', 'control de los empleados que trabajan en la empresa', 'userEmpleado.php', 'activo', '2014-11-18', '19:20:10'),
(19, 18, 'REGISTRO DE DEPARTAMENTOS', 'registro de los departamentos de la empresa', 'listdept.php', 'activo', '2014-11-18', '19:20:10'),
(20, 19, 'REGISTRO DE CARGOS', 'registro de los cargos correspondientes a la empresa', 'listcargos.php', 'activo', '2014-11-18', '19:20:10'),
(21, 20, 'REGISTRO DE ACTIVIDADES LABORALES', 'control de actividades laborales de cada empleado', 'listactividades.php', 'activo', '2014-11-18', '19:20:10'),
(22, 21, 'REGISTRO DE PEDIDO DE ITEMS', 'control de solicitud de items para obras civiles', 'solicituditems.php', 'activo', '2014-11-18', '19:20:10'),
(23, 22, 'REGISTRO DE PROVEEDORES', '', 'listprov.php', 'activo', '2014-11-18', '19:20:10'),
(24, 23, 'REGISTRO DE MATERIALES', '', 'formMateriales.php', 'activo', '2014-11-18', '19:20:10'),
(25, 24, 'REGISTRO DE MAQUINARIA', '', 'FormEquipos.php', 'activo', '2014-11-18', '19:20:10'),
(26, 25, 'REGISTRO DE SUMINISTROS', '', 'listsuministro.php', 'activo', '2014-11-18', '19:20:10'),
(27, 26, 'REGISTRO DE MAQUINARIA EN REPARACION', '', 'maqreparacion.php', 'activo', '2014-11-18', '19:20:10'),
(28, 27, 'REGISTRO DE REPARACIONES', '', 'listreparacion.php', 'activo', '2014-11-18', '19:20:10'),
(29, 28, 'REPORTE POR FECHA DE SESION', 'reporte de sesiones de usuarios por fecha', 'enviaRepSesion.php', 'activo', '2014-11-18', '19:20:10'),
(30, 29, 'REPORTE POR PROYECTO', 'Informe correspondiente a los trabajos realizados por proyecto', 'repproyecto.php', 'activo', '2014-11-18', '19:20:10'),
(51, 34, 'LOG DE AUDITORIA', 'control detallado de las acciones de los usuarios dentro del sistema', 'auditoria.php', 'activo', '2014-11-18', '19:20:10'),
(52, 32, 'CONTADOR DE ACCESOS', 'control de cantidad de accesos por sesion de usuario', 'contAccesos.php', 'activo', '2014-11-18', '19:20:10'),
(53, 31, 'REPORTE POR EMPLEADO', '', 'repempleado.php', 'activo', '2014-11-18', '19:20:10'),
(54, 33, 'GRAFICO DE PROYECTO', '', 'graphproyecto.php', 'activo', '2014-11-18', '19:20:10'),
(55, 35, 'GESTION DE MODULOS', 'control de modulos del sistema', 'menuList.php', 'activo', '2014-11-18', '19:20:10'),
(56, 36, 'REPORTE DE COMPRA Y ALQUILER', '', 'repComAlq.php', 'activo', '2014-11-18', '19:20:10'),
(57, 37, 'REPORTE DE CANTIDAD DE ACCESOS POR MES', 'reporte grafico de la cantidad de accesos por sesion de usuario', 'enviaGrafico.php', 'activo', '2014-11-18', '19:20:10'),
(58, 38, 'CONTROL DE ASISTENCIA', '', 'asistencia.php', 'activo', '2014-11-18', '19:20:10'),
(59, 39, 'REGISTRO DE PERMISOS', '', 'permEmpleado.php', 'activo', '2014-11-18', '19:20:10'),
(60, 32, 'REGISTRO DE DATOS PERSONALIZADOS', 'control de datos personalizados', 'example.php', 'inactivo', '2014-03-03', '21:11:21'),
(61, 32, 'CUSTOM OPTION', 'opcion personalizada', 'example1.gif', 'inactivo', '2014-03-03', '21:48:48'),
(62, 43, 'REGISTRO DE DATOS ARCHIVADOS', 'control de datos eliminados', 'example1.php', 'activo', '2014-03-09', '15:00:51'),
(63, 44, 'PLANILLA SALARIAL', 'Control y registro de planillas salariales', 'planilla.php', 'activo', '2014-03-11', '10:20:53'),
(64, 45, 'NUEVO EMPLEADO', 'Formulario de registro de nuevos empleados', 'nuevoempleado.php', 'activo', '2014-03-11', '11:36:50'),
(65, 46, 'REGISTRO DE PROFESIONES', 'Listado de profesiones de la empresa', 'listProfesion.php', 'activo', '2014-03-13', '12:18:07'),
(66, 48, 'REGISTRO DE FASES', 'Formulario de registro de fases para un proyecto', 'formFase.php', 'activo', '2014-03-21', '16:55:18'),
(67, 49, 'REGISTRO DE SUBFASES', 'Formulario para el registro de subfases de un proyecto', 'formSubfase.php', 'activo', '2014-03-21', '16:56:59'),
(68, 50, 'FORMULARIO DE SOLICITUD', 'Formulario de solicitud de mano de obra', 'formSolicitud.php', 'activo', '2014-03-21', '17:05:43'),
(69, 51, 'REGISTRO DE MENSAJES DE AYUDA', 'Listado de mensajes de ayuda por opcion y por subpermiso', 'listAyuda.php', 'activo', '2014-03-21', '17:22:04'),
(70, 50, 'LISTADO DE SOLICITUDES', 'Listado de solicitudes de cargos de mano de obra', 'listSolicitud.php', 'activo', '2014-03-22', '21:07:32'),
(71, 52, 'REPORTE DE SOLICITUD DE MANO DE OBRA', 'Informa de solicitudes de mano de obra para proyectos', 'envRepSolManoobra.php', 'inactivo', '2014-03-23', '21:28:22'),
(72, 53, 'CONTRATACION EN PROYECTO', 'Registrar asignacion de trabajadores a proyecto', 'procContrato.php', 'activo', '2014-03-24', '09:55:25'),
(73, 54, 'DEFINICION DE CALENDARIO DE FERIADOS', 'Definicion de calendario de trabajos', 'calendarioFeriado.php', 'activo', '2014-03-25', '20:29:10'),
(74, 55, 'CONTROL DE MAQUINARIA', 'Registro de toda la informacion correspondiente a maquinaria y equipo pesado', 'listMaquinaria.php', 'activo', '2014-03-28', '18:38:06'),
(75, 56, 'CONTROL DE MATERIALES', 'Registro de toda la informacion correspondiente a materiales de obras y construcciones civiles', 'listMaterial.php', 'activo', '2014-03-28', '18:38:47'),
(76, 57, 'CONTROL DE PARAMETROS', 'Registro de parametros con sus respectivos valores', 'listParametros.php', 'activo', '2014-03-29', '18:43:32'),
(77, 58, 'NUEVO PARAMETRO', 'Formulario para el registro de parametros de calculo', 'formParametro.php', 'activo', '2014-03-29', '20:26:38'),
(78, 21, 'FORMULARIO DE SOLICITUD DE MAQUINARIA', 'Formuliario para realizar el registro de solicitud de items para incorportar a proyectos civiles', 'formSolicitudItem.php', 'activo', '2014-03-30', '19:49:20'),
(79, 29, 'REPORTE DE ACTIVIDADES', 'Reporte de actividades', 'envRepSolM.php', 'activo', '2014-03-31', '10:48:50'),
(80, 59, 'SOLICITUDES DE ITEMS', 'Reporte de solicitudes atenditas de items', 'envRepSolItems.php', 'inactivo', '2014-03-31', '11:05:54'),
(81, 60, 'REPORTE SOLICITUD MANO DE OBRA', 'Reporte de solicitudes procesadas de mano de obra', 'envRepSolMPr.php', 'activo', '2014-03-31', '11:07:14'),
(82, 61, 'REGISTRO DE ENTRADAS', 'Control de ingreso de items solicitados por la empresa', 'entalmacen.php', 'activo', '2014-03-31', '21:00:19'),
(83, 62, 'SOLICITUD DE COTIZACIONES', 'Control de cotizacion de materiales ofertados', 'cotizacionMat.php', 'activo', '2014-03-31', '21:05:36'),
(84, 62, 'COTIZACIONES APROBADAS', 'Listado de cotizaciones aprobadas de items para pedido', 'cotizacionAprobada.php', 'activo', '2014-04-01', '13:09:49'),
(85, 63, 'LISTADO DE ARCHIVOS', 'Listado de archivos segun los permisos de acceso', 'listArchivos.php', 'activo', '2014-04-02', '10:47:55'),
(86, 64, 'NUEVO MENSAJE DE CORREO', 'Esta opcion se encarga de realizar envio y recepcion de mensajes de correo electronico usando gmail.com', 'formMessage.php', 'activo', '2014-04-04', '11:19:17'),
(87, 65, 'PEDIDO DE MATERIALES', 'Control de solicitud de pedidos para materiales aprobados por gerencia tecnica', 'pedido.php', 'activo', '2014-04-05', '17:03:12'),
(88, 66, 'CONSULTAR SOLICITUD', 'Listado de solicitudes de maquinaria y equipos', 'solicitudMaq.php', 'activo', '2014-04-07', '09:38:36'),
(89, 62, 'REGISTRO DE COTIZACION', 'Control de registro de cotizaciones', 'formCotizacion.php', 'activo', '2014-04-11', '14:55:17'),
(90, 67, 'FORMULARIO DE NOTAS DE REMISIÃ“N', 'Formulario de registro de notas de remision de pedido de materiales', 'NotaRemision.php', 'activo', '2014-04-11', '14:56:52'),
(91, 68, 'REPORTE DE COTIZACIONES DE MATERIALES', 'Reportes que describen los registro de cotizaciones de materiales', 'envRepCot.php', 'activo', '2014-04-11', '18:07:04'),
(92, 69, 'CANTIDAD DE MATERIALES ALMACENADOS', 'Reporte que describe la cantidad de items adquiridos por la empresa', 'envRitems.php', 'activo', '2014-04-14', '16:08:49'),
(93, 70, 'REGISTRO DE PLANIFICACIONES', 'Control y registro de etapas de planificacion para proyectos', 'Planificacion.php', 'activo', '2014-04-15', '14:58:15'),
(94, 71, 'CONTROL DE ASIGNACION', 'registro de asignaciones de actividades para un determinado proyecto', 'formAsignacion.php', 'activo', '2014-04-16', '15:04:44'),
(95, 72, 'LISTADO DE PLANIFICACIONES', 'Control de planificaciones para la finalizacion', 'finPlan.php', 'activo', '2014-04-19', '16:53:42'),
(96, 73, 'CONTROL DE AVANCES', 'Opcion de control de avances', 'avance.php', 'activo', '2014-04-19', '20:04:39'),
(97, 74, 'REGISTRO DE SEGUIMIENTO', 'Opcion encargada de controlar el progreso de avance de las obras segun duraciones', 'seguimiento.php', 'activo', '2014-04-19', '20:05:50'),
(98, 29, 'REPORTE DE AVANCE DE ACTIVIDADES', 'Reporte grafico del progreso de avance de actividades', 'Avance.php', 'activo', '2014-04-19', '20:08:31'),
(99, 75, 'REGISTRO DE INCORPORACION', 'Control de incorporacion de items materiales y maquinaria al proyecto civil', 'incorporacion.php', 'activo', '2014-04-19', '20:20:26'),
(100, 76, 'LISTADO DE COMPRA', 'Control de detalle de cotizaciÃ³n para planificar compras', 'listCompra.php', 'activo', '2014-04-21', '20:30:22'),
(101, 77, 'REPORTE DE COMPRAS AL MES', 'Reporte de compras planificadas por mes', 'envRepcompra.php', 'activo', '2014-04-21', '22:08:33'),
(102, 78, 'REGISTRO DE CALENDARIO', 'Control de calendario de trabajo de los trabajadores participantes en proyecto', 'calendariotrabajador.php', 'activo', '2014-04-24', '15:40:09'),
(103, 73, 'REGISTRO DE AVANCES', 'Registro de avance de ejecuciones de actividades', 'regejecucion.php', 'activo', '2014-04-26', '21:53:33'),
(104, 80, 'REPORTE DE PRECIOS UNITARIOS', 'Reporte de precios unitarios por actividad de fase', 'envgrprecio.php', 'activo', '2014-04-29', '16:05:53'),
(105, 81, 'REGISTRO DE SEGUIMIENTOS', 'Control de registro de avances por fase, actividad de proyectos', 'listseguimiento.php', 'activo', '2014-04-30', '09:50:15'),
(106, 82, 'PEDIDO A ALMACEN', 'Pedido de items registrados en almacen para las actividades del proyecto', 'pedidoalmacen.php', 'activo', '2014-05-09', '12:00:19'),
(107, 82, 'SOLICITUDES DE PEDIDOS', 'Solicitud de pedido para proyectos', 'solPedidoAlmacen.php', 'activo', '2014-05-09', '19:24:44')");
   if($sql2->execute()){
	   echo "<img src=yes.jpg height=20 width=20/>Inserción de opciones completa<br>";
	   }else{
		   echo "<img src=no.jpg height=20 width=20/>Error al registrar opciones<br>";
		   }
  #consulta de registro de profesión administrador de empresas
  $insertProfesion=$dbh->prepare("INSERT INTO `profesion` (`IDprofesion`, `nombre`, `descripcion`, `fecCreacion`, `hraCreacion`) VALUES ('br7ozar04owlcnon47nbnnoeagzavaqlbvm', 'administrador de empresas', 'licenciatura en administracion de empresas', '2014-03-13', '19:42:36')");
  if($insertProfesion->execute()){
	  echo "<img src=yes.jpg height=20 width=20/>Registro de profesión completo<br>";
	  }else{
		  echo "<img src=no.jpg height=20 width=20/>Error al registrar la profesión<br>";
		  }
  #consulta de registro de departamento
  $insertDpto=$dbh->prepare("INSERT INTO `departamento` (`IDdepto`, `nombre`, `descripcion`, `fecCreacion`, `hraCreacion`) VALUES 
('00000000000000000000000000000001', 'GERENCIA GENERAL', 'departamento de administracion de la empresa', '2014-03-10', '17:42:50'),
('00000000000000000000000000000002', 'SECRETARIA', 'departamento de secretaria de la empresa', '2014-03-10', '17:42:50'),
('00000000000000000000000000000003', 'GERENCIA ADMINISTRATIVA', 'gerencia de administracion', '2014-03-10', '17:42:50'),
('00000000000000000000000000000004', 'GERENCIA TECNICA', 'gerencia de planificacion', '2014-03-10', '17:42:50'),
('00000000000000000000000000000005', 'GERENCIA DE EQUIPOS', 'gerencia de equipos pesados ', '2014-03-10', '17:42:50'),
('00000000000000000000000000000006', 'COTIZACIONES', 'departamento de cotizaciones de precios unitarios de items', '2014-03-10', '17:42:50'),
('00000000000000000000000000000007', 'COMPRA Y ALQUILER', 'departamento de compra y alquiler de items', '2014-03-10', '17:42:50'),
('00000000000000000000000000000008', 'PROYECTOS', 'departamento de planificacion de proyectos', '2014-03-10', '17:42:50'),
('00000000000000000000000000000009', 'SUPERINTENDENCIA DE OBRAS', 'departamento de superintendencia de obras civiles', '2014-03-10', '17:42:50'),
('00000000000000000000000000000010', 'MECANICOS', 'departamento de mecanicos', '2014-03-10', '17:42:50'),
('00000000000000000000000000000011', 'OPERARIOS', 'departamento de operarios', '2014-03-10', '17:42:50'),
('00000000000000000000000000000012', 'SISTEMAS', 'departamento de control de sistemas', '2014-03-10', '17:42:50'),
('00000000000000000000000000000013', 'RECURSOS HUMANOS', 'departamento de gestion de personal', '2014-03-10', '17:42:50'),
('00000000000000000000000000000014', 'ADMINISTRACION', 'departamento de administracion de la empresa', '2014-03-11', '10:14:00')");
if($insertDpto->execute()){
	echo "<img src=yes.jpg height=20 width=20/>Registro de departamento completo<br>";
	  }else{
		  echo "<img src=no.jpg height=20 width=20/>Error al registrar la el departamento<br>";
		  }
  #consulta de regsitro de cargo
  $insertCargo=$dbh->prepare("INSERT INTO `cargo` (`IDcargo`, `nombre`, `descripcion`, `fecCreacion`, `hraCreacion`) VALUES ('bt26493p9s4amydy6bo5qef47badb2eii0z', 'administrador/a general', 'encargado de la administracion general de la empresa', '2014-03-10', '17:44:31')");
  if($insertCargo->execute()){
	   echo "<img src=yes.jpg height=20 width=20/>Registro de cargo completo<br>";
	  }else{
		  echo "<img src=no.jpg height=20 width=20/>Error al registrar la el cargo<br>";
		  }
  #consulta de registro de roles
	$query=$dbh->prepare("INSERT INTO `rol` (`IDrol`, `nombreRol`, `descripcion`, `fecCreacion`, `hraCreacion`) VALUES
('SC_ADMINISTRADOR', 'administrador general del sistema', 'encargado de la administracion de la seguridad del sistema', curdate(), curtime()),
('SC_EMPLEADO', 'empleado', 'empleado de la empresa', curdate(), curtime())");
	
	if($query->execute()){
		echo "<img src=yes.jpg height=20 width=20/>Roles creados<br>";
		}else{
			echo "<img src=no.jpg height=20 width=20/>Error al crear los roles<br>";
			}
#consulta de registro de empleados
$insertEmp=$dbh->prepare("INSERT INTO `empleado` (`IDempleado`, `nombres`, `app`, `apm`, `CI`, `telefonos`, `direccion`, `fecNacimiento`, `estadoCivil`, `fecIngreso`, `IDcargo`, `IDdepto`, `IDprofesion`, `haberBasico`, `aniosTrabajo`, `fechaRegistro`, `hraRegistro`) VALUES
('qt1w7wkalr7lo0edkz2jaf78fma8d7x8lmw', 'Maria', 'Perez', 'Vargas', '449984 L.P', '75044334', 'san pedro', '1976-09-15', 'soltero/a', '2009-08-15', 'bt26493p9s4amydy6bo5qef47badb2eii0z', '00000000000000000000000000000014', 'br7ozar04owlcnon47nbnnoeagzavaqlbvm', '2500.00', '4.50', '2014-03-10', '21:12:35')
");
if($insertEmp->execute())
{
		echo "<img src=yes.jpg height=20 width=20/>Empleado registrado<br>";
		}else{
			echo "<img src=no.jpg height=20 width=20/>Error al registrar empleado<br>";
			}
#asignación de ids de usuario para verificar si están registrados
    $usr_uid="00000000000000000000000000000001";//id del usuario admin
	$usr_uid_emp="MPV2013907";//id del usuario administrador de la empresa
	$consulta=$dbh->prepare("select *from usuario where in(?,?)");//consulta el registro
	$consulta->bindParam(1,$usr_uid);//enlaza al id del administrador
	$consulta->bindParam(2,$usr_uid_emp);//enlaza al id del administrador general
	$consulta->execute();
	if($consulta->rowCount()>0){
		echo "<img src=no.jpg height=20 width=20/>Usuarios ya registrados<br>";
		}
         else{//prepara el registro de usuarios
	$sql3=$dbh->prepare("INSERT INTO `usuario` (`USR_UID`, `username`, `CI`, `email`, `password`, `confpwd`, `estado`, `fecCreacion`, `hraCreacion`, `IDrol`) VALUES
('00000000000000000000000000000001', 'admin', NULL, 'admin@sercoamerica.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'activo', '2014-03-10', '21:10:41', 'SC_ADMINISTRADOR'),
('MPV2013907', 'mperez', '449984 L.P', 'mperez@gmaillcom', '8151325dcdbae9e0ff95f9f9658432dbedfdb209', '8151325dcdbae9e0ff95f9f9658432dbedfdb209', 'activo', '2014-03-10', '21:14:00', 'SC_EMPLEADO')
");
  
   if( $sql3->execute()){
	   echo "<img src=yes.jpg height=20 width=20/>Usuarios creado<br>";
	   }else{
		   echo "<img src=no.jpg height=20 width=20/>Error al crear el usuario<br>";
		   }
		 }
     #Permiso de opciones a roles
	$permisoRol=$dbh->prepare("INSERT INTO `rol_opcion` (`IDperm_rol`, `IDrol`, `IDopcion`, `estado`, `fecAsignacion`, `hraAsignacion`) VALUES
('tsm82vrjqk1xjjdd6glwuhuujs391rqp3dp', 'SC_ADMINISTRADOR', 1, 'activo', '2014-03-10', '21:21:47'),
('8e6ruk84ykv4x8nsmv80r160j4znbyljgqs', 'SC_ADMINISTRADOR', 2, 'activo', '2014-03-10', '21:21:59'),
('zfkt65paeqwzqhktxs81xrbx5sf2d3badfh', 'SC_ADMINISTRADOR', 4, 'activo', '2014-03-10', '21:22:17'),
('adkt5rpdeqwznhkmxs9xrdbx5sgt63sddxl', 'SC_ADMINISTRADOR', 29, 'activo', '2014-03-10', '21:22:17'),
('5iv1fqotb6th57fzj0bf2tfmchduz1y4ah5', 'SC_ADMINISTRADOR', 51, 'activo', '2014-03-10', '21:23:27'),
('8h75g1qk4ne32h6l6gdogiqx23ov3dz9zv0', 'SC_ADMINISTRADOR', 52, 'activo', '2014-03-10', '21:24:56'),
('8p4u9gm5lzdv5usbvz2xteabdmvnhs1p5mh', 'SC_ADMINISTRADOR', 55, 'activo', '2014-03-10', '21:25:25'),
('r8015ru2spwe13ppn32gqsc21piaofmd62u', 'SC_ADMINISTRADOR', 57, 'activo', '2014-03-10', '21:25:16'),
('i1x9q9eletxnfkifz33bgyyxltdqk21anoc', 'SC_ADMINISTRADOR', 73, 'activo', '2014-03-10', '21:25:16'),
('lxmpvciorryyx8t01xeu4wslldxmchfc7am', 'SC_ADMINISTRADOR', 76, 'activo', '2014-03-10', '21:25:16'),
('6mobdfqu4jn5e8w9fxa5mko2sfnskutbbiv', 'SC_ADMINISTRADOR', 77, 'activo', '2014-03-10', '21:25:16'),
('9zwgygpsi21jlnvgepysvjecsjuqwn9lr4j', 'SC_ADMINISTRADOR', 83, 'activo', '2014-03-10', '21:25:16')");
	if($permisoRol->execute()){
		echo "<img src=yes.jpg height=20 width=20/>Permisos asignados al rol<br>";
		}else{
			echo "<img src=no.jpg height=20 width=20/>No se han podido asignar los permisos al rol<br>";
			}
#consulta de permisos de usuario
$insertPermiso=$dbh->prepare("INSERT INTO `permiso` (`UID_PERM`, `USR_UID`, `IDopcion`, `estado`, `fecha_asignacion`, `hraAsignacion`) VALUES
('qt1w7wkalr7lo0edkz2jaf78fma8d7x8lmw','00000000000000000000000000000001', 1, 'activo', '2014-03-10', '21:16:59'),
('j8owu1gh16w1z7nwv6rzp0sfcgzg28qpasl','00000000000000000000000000000001', 2, 'activo', '2014-03-10', '21:17:26'),
('wc5taga7mfpz6469h7wl1bxrh531an1vu8y','00000000000000000000000000000001', 4, 'activo', '2014-03-10', '21:17:59'),
('r7al01pusos766vax6b1qmxbl2ynuwu7yjs','00000000000000000000000000000001', 29, 'activo', '2014-03-13', '16:08:08'),
('1sh3tu0m20slksw1u9lwcvuq2e4r17lvokz','00000000000000000000000000000001', 51, 'activo', '2014-03-10', '21:18:43'),
('0hi2k2q8p110uibuwl8tvllnffgkknkrrv8','00000000000000000000000000000001', 52, 'activo', '2014-03-10', '21:19:45'),
('rnddobbfhi4hrbc8hay0pdxpnkwxflhevna','00000000000000000000000000000001', 55, 'activo', '2014-03-10', '21:20:30'),
('i2uidf43jhiwor00hzay5t0ingafhms5uwi','00000000000000000000000000000001', 57, 'activo', '2014-03-10', '21:21:16'),
('d8qfi61v7gw18moclf94y4y0zocjoqabjby','00000000000000000000000000000001', 73, 'activo', '2014-03-25', '20:30:25'),
('c1phkey2rlu6y9cxjee6jd2bpz9gajcxxuj','00000000000000000000000000000001', 76, 'activo', '2014-03-29', '18:47:10'),
('c5dxqyh4qvopq41z6grfj6fqvm6d6mjn5yp','00000000000000000000000000000001', 77, 'activo', '2014-03-29', '20:27:45'),
('xw4g8jj3ty9lmgnl99a2l43bx6p8w3bqpoq','00000000000000000000000000000001', 86, 'activo', '2014-04-04', '11:23:45')");																																									
if($insertPermiso->execute()){
	echo "<img src=yes.jpg height=20 width=20/>Permisos ingresados<br>";
	}else{
		echo "<img src=no.jpg height=20 width=20/>No se pudieron registrar los permisos<br>";
		}
		#consulta de registro de subpermisos
	$pag_opcion=$dbh->prepare("INSERT INTO `pagina_opcion` (`IDpagina`, `IDopcion`, `nombre`, `descripcion`, `url`, `fecCreacion`, `hraCreacion`) VALUES
(1, 1, 'NUEVO USUARIO', 'formulario de registro de nuevos usuarios', 'nuevousuario.php', '2013-11-12', '15:09:10'),
(2, 1, 'EDITAR SU CUENTA DE USUARIO', '', 'vercuenta.php', '2014-03-11', '09:10:31'),
(3, 18, 'INFORMACION LABORAL DE EMPLEADOS', '', 'listEmpleados.php', '2014-03-11', '09:10:31'),
(4, 18, 'NUEVO EMPLEADO', 'Registro de nuevos empleados', 'nuevoempleado.php', '2014-03-11', '09:10:31'),
(5, 59, 'VER REGISTRO DE CONTROL DE PERMISOS', '', 'controlPermiso.php', '2014-03-11', '09:10:31'),
(6, 58, 'FORMULARIO DE CONTROL DE ASISTENCIA', '', 'formAsistencia.php', '2014-03-11', '09:10:31'),
(7, 55, 'CREAR NUEVO MODULO', '', 'nuevoModulo.php', '2014-03-11', '09:10:31'),
(8, 2, 'NUEVO ROL', 'fornulario de creacion de nuevos roles del sistema', 'nuevoRol.php', '2013-11-21', '20:20:16'),
(9, 3, 'FORMULARIO DE PUBLICACION', 'formulario que permite realizar la publicación de proyectos', 'formPublicacion.php', '2014-03-04', '20:05:39'),
(10, 6, 'FORMULARIO DE REGISTRO DE PROYECTOS', 'formulario que permite realizar el registro de proyectos de carreteras', 'formProyecto.php', '2014-03-04', '20:09:09'),
(11, 6, 'REGISTRO DE CONTRATOS', 'registro del contrato de proyectos', 'contrato.php', '2014-03-04', '20:13:13'),
(12, 20, 'NUEVO CARGO', 'Formulario de creacion de nuevos cargos', 'nuevoCargo.php', '2014-03-11', '17:35:40'),
(13, 19, 'NUEVO DEPARTAMENTO', 'Formulario de creaciÃ³n de nuevos departamentos', 'nuevodepto.php', '2014-03-11', '17:36:19'),
(14, 65, 'NUEVA PROFESION', 'Formulario de registro de profesiones', 'nuevaProfesion.php', '2014-03-13', '12:20:15'),
(15, 11, 'NUEVO CARGO DE MANO DE OBRA', 'Formulario de registro de cargos de mano de obra para proyectos civiles', 'nuevoCargoM.php', '2014-03-15', '12:10:11'),
(16, 7, 'NUEVOS TRABAJADORES', 'Formulario de regsitro de trabajadores de mano de obra', 'nuevoTrabajador.php', '2014-03-15', '21:02:34'),
(17, 12, 'INFORMACION DE ENCARGADO', 'Listado con la informacion detallada de encargados de mano de obra', 'verInfoEnc.php', '2014-03-17', '14:45:15'),
(18, 23, 'INFORMACION DE PROVEEDOR', 'Listado con la informacion especifica de proveedores', 'verInfoProv.php', '2014-03-17', '14:46:49'),
(19, 13, 'REGISTRO DE PERSONAL TECNICO CLAVE', 'Listado de personal de recursos humanos participante en proyectos', 'viewPersonalTecnico.php', '2014-03-18', '11:12:26'),
(20, 71, 'REPORTE DE SOLICITUDES POR FECHA', 'Reporte de solicitudes de mano de obra por fecha', 'envRepSolFecha.php', '2014-03-23', '21:29:01'),
(21, 30, 'INFORME DE ACTIVIDADES', 'Informe de progreso de actividades', 'envInfoActividad.php', '2014-03-31', '11:08:56')");
if($pag_opcion->execute()){
	echo "<img src=yes.jpg height=20 width=20/>Páginas de opcion creadas<br>";
	}else{
		echo "<img src=no.jpg height=20 width=20/>No se ha podido crear las páginas de opcion<br>";
		}
#consulta de regsitro de asignación de subpermisos
$perm_pagina=$dbh->prepare("INSERT INTO `permiso_pagina` (`IDpermpag`, `USR_UID`, `IDpagina`, `estado`, `fecAssignacion`, `hra_asignacion`) VALUES
('6nzpoh6z9vvghxcxyf2k4umcnaro2y8pdf9', 'MPV2013907', 3, 'activo', '2014-03-11', '09:02:06'),
('j9zqgrbffl7mljm65pq2tbmybj0b6pal0lb', 'MPV2013907', 13, 'activo', '2014-03-11', '17:43:35'),
('kv9uv5fsmjc8amx75klyz73zscm8dvqf885', '00000000000000000000000000000001', 7, 'activo', '2014-03-10', '21:27:45'),
('m8nhqd0pvkkhb553wesq0iy6vb4ye3fcsyh', 'MPV2013907', 12, 'activo', '2014-03-11', '17:43:26'),
('p1jdxsglzugu1g57ttvtpg4ascoog5c7lhe', '00000000000000000000000000000001', 8, 'activo', '2014-03-10', '21:28:53'),
('px91ni6nobgze5b0k4418wcdj708b2hk680', '00000000000000000000000000000001', 1, 'activo', '2014-03-10', '21:26:45'),
('sdb4ygs6syx7kugdy73rsnj9cflss3x06m7', 'MPV2013907', 14, 'activo', '2014-03-13', '19:28:55')");

if($perm_pagina->execute()){
	echo "<img src=yes.jpg height=20 width=20/>Subpermisos creados<br>";
	}else{
		echo "<img src=no.jpg height=20 width=20/>No se ha podido crear los permisos de pagina<br>";
		}
$licitacion=$dbh->prepare("insert into licitacion values('L0000000000001','Licitacion publica nacional'),
                                                        ('L0000000000002','Licitacion local')");
if($licitacion->execute()){
	echo "<img src=yes.jpg height=20 width=20/>Licitaciones creadas<br>";
	}else{
		echo "<img src=no.jpg height=20 width=20/>No se pudieron crear las licitacions<br>";
		}
}catch(PDOException $e){

	echo("Error de ejecución".$e->getMessage);
}
?>