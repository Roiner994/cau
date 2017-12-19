<?php
//funcion que conecta con la base de datos Mysql
function conectarMysql() {
$servidor="localhost";
$usuario="root";
$passwd=null;
$nombreDB="cau";
	$enlace=mysql_connect($servidor,$usuario,$passwd) or die("No se pudo conectar a servidor");
	$base_datos=mysql_select_db($nombreDB, $enlace) or die ("No se pudo conectar con la base de datos");
}
?>