<?php
//Seguridad.php
//Inicio la sesión 
session_start(); 
//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    header("Location: index.php"); 
    exit(); 
} 
?>