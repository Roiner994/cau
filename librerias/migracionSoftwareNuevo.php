<?php
//Migracion Nuevo Software

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>MIGRACION SOFTWARE LIBRE - AGREGAR NUEVO SOFTWARE</title>
</head>
<body>
<fieldset class="front" id="validate-by-uri"><legend>ESCRIBA EL NOMBRE DEL SOFTWARE Y LA DESCRIPCI&Oacute;N</legend>
<form action="migracionsoftwarevalidar.php" method="post">
<p>
<label for="software">NOMBRE DEL SOFTWARE</label><br>
<input type="text" id="software" name="txtSoftware" value="<?=$_POST[txtSoftware]?>">*<br>
<label for="descripcion">DESCRIPCION DEL SOFTWARE</label><br>
<input type="text" id="descripcion" name="txtDescripcionSoftware" value="<?=$_POST[txtDescripcionSoftware]?>">*<br>
<INPUT type="submit" value="ENVIAR">
</p>
</form>
<p>* Campo Requerido</p>
</body>
</html>
