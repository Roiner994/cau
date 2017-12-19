<?php
require_once("../librerias/conexionsql.php");
conectarMysql();
$password=md5($_POST[txtPassword]);
$conUsuario="select id_uss from usuario_sistema where login='$_POST[txtUsuario]' and password='$password'";
$result=mysql_query($conUsuario);
if ($result && mysql_numrows($result)>0) {
   session_start(); 
   session_register("autentificado"); 
   $autentificado = "SI";
   $row=mysql_fetch_array($result);
   $_SESSION["login"]=$row[0];
   header ("Location: index2.php"); 
} else {
	header("Location: index.php?errorUsuario=si"); 
}
mysql_free_result($result);
mysql_close();
?>