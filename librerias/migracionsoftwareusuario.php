<?php
// Formulario para ingresar los Software instalados en cada una de las Maquinas para luego hacer la Migración
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>MIGRACION SOFTWARE LIBRE</title>
</head>
<body>
<h1>FORMULARIO PARA VERIFICAR LOS SOFTWARE INSTALADOS EN CADA UNO DE LOS EQUIPO PARA REALIZAR LA MIGRACIÓN A SOFTWARE LIBRE SEGUN EL DECRETO 3390.</h1>
<fieldset class="front" id="validate-by-uri"><legend>ESCRIBA EL NUMERO DE CONFIGURACION DEL EQUIPO Y LA FICHA DEL USUARIO Y PRESIONE CONTINUAR</legend>
<form action="migracionsoftwareinstalados.php" method="get">
<p>
<label for="configuracion">ESCRIBA EL N&Uacute;MERO DE <strong>CONFIGURACION</strong> DEL EQUIPO.</label><br>
<input type="text" id="configuracion" name="txtConfiguracion" value="<?=$_GET[txtConfiguracion]?>">*<br>
<label for="ficha">ESCRIBA EL N&Uacute;MERO DE <strong>FICHA</strong> DEL USUARIO</label><br>
<input type="text" id="ficha" name="txtFicha" value="<?=$_GET[txtFicha]?>">*<br>
<INPUT type="submit" value="CONTINUAR">
</p>
</form>
<p>* Campo Requerido</p>
</body>
</html>
