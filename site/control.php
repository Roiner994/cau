<?php
require_once("../librerias/conexionsql.php");
conectarMysql();
$password;
if (isset($_POST['txtPassword'])){
	$password=md5($_POST['txtPassword']);
}
$conUsuario="Select distinct
usuario_sistema.ID_USS
From
usuario_sistema
Inner Join usuario_sistema_privilegio ON usuario_sistema.ID_USS = usuario_sistema_privilegio.ID_USS where login='$_POST[txtUsuario]' and password='$password'  AND
usuario_sistema.STATUS_ACTIVO = '1'";
$result=mysql_query($conUsuario);
if ($result && mysql_numrows($result)>0) {
   session_start(); 
   
   $autentificado = "SI";
   $_SESSION['autentificado']="SI";
   $row=mysql_fetch_array($result);
   $_SESSION["login"]=$row[0];
   header ("Location: index2.php"); 
} else {
	header("Location: index.php?errorUsuario=si"); 
}
mysql_free_result($result);
mysql_close();
?>
