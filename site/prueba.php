<link rel="STYLESHEET" type="text/css" href="estilos.css">
<?php
echo phpinfo();;


//Prueba
/*require_once("../librerias/tablas.php");
require_once("../librerias/conexionsql.php");
require_once "../librerias/formularios.php";
$conDescripcion="SELECT DISTINCT solicitud_equipo.ID_DESCRIPCION,descripcion.DESCRIPCION 
FROM solicitud_equipo INNER JOIN descripcion WHERE solicitud_equipo.ID_DESCRIPCION=descripcion.ID_DESCRIPCION";
$conGerencia="SELECT DISTINCT ubicacion.ID_GERENCIA,gerencia.GERENCIA FROM solicitud_equipo INNER JOIN ubicacion INNER JOIN gerencia
ON solicitud_equipo.ID_UBICACION=ubicacion.ID_UBICACION ON ubicacion.ID_GERENCIA=gerencia.ID_GERENCIA WHERE solicitud_equipo.ID_DESCRIPCION LIKE '%$_POST[selDescripcion]' ORDER BY gerencia.GERENCIA";

$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","onChange","submit()",$conDescripcion,"--TODOS--","");
$selDescripcion=$descripcion->retornar();	
$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","submit()",$conGerencia,"--TODOS--","");
$selGerencia=$gerencia->retornar();	
if ($_POST[selDescripcion]==100) {
	$filtroDescripcion='';
} else {
	$filtroDescripcion=$_POST[selDescripcion];
}
if ($_POST[selGerencia]==100) {
	$filtroGerencia='';
} else {
	$filtroGerencia=$_POST[selGerencia];
}

echo "<form action=\"\" method=\"post\">";
echo $selDescripcion;
echo $selGerencia;
echo "</form>";
$columnas = array('ID SOLICITUD','GERENCIA','DESCRIPCION','FECHA');
$consulta="SELECT solicitud_equipo.ID_SOLICITUD, gerencia.GERENCIA, descripcion.DESCRIPCION,solicitud_equipo.Fecha_I
 FROM cau_inventario.solicitud_equipo INNER JOIN ubicacion INNER JOIN gerencia INNER JOIN descripcion ON solicitud_equipo.ID_UBICACION=ubicacion.ID_UBICACION ON ubicacion.ID_GERENCIA=gerencia.ID_GERENCIA ON solicitud_equipo.ID_DESCRIPCION=descripcion.ID_DESCRIPCION
 WHERE solicitud_equipo.ID_DESCRIPCION LIKE '%$filtroDescripcion' AND ubicacion.ID_GERENCIA LIKE '%$filtroGerencia' AND fecha_I between '2005-10-17' AND '2005-10-17'";


$tabla= new tabla($consulta,$columnas,'tabla','SOLICITUDES DE EQUIPO POR GERENCIA');
$resultado=$tabla->retornarTabla();
echo $resultado;
*/?>