<?php
require_once("seguridad.php");
$priv="'PRV0000001'";

require_once("conexionsql.php");
require_once("usuarioSistemaAdmin.php");
$login=$_SESSION["login"];
$user= new usuarioSistema($login);
$resultado=$user->verificarAcceso($priv);
if ($resultado==1) {
		echo "<form name=\"frmComponente\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: INVENTARIO - EQUIPOS</td>
		</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>NO TIENE SUFICIENTE PRIVILEGIO PARA ENTRAR A ESTE MODULO.</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"button\" value=\"CANCELAR\" onclick=\"location.href='index2.php'\"></td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";	
		exit();
}
?>
<?php
require_once("conexionsql.php");
if ((isset($_GET[txtCantidad]) && !empty($_GET[txtCantidad])) && (isset($_GET[txtPersonal]) && !empty($_GET[txtPersonal])))  {
	conectarMysql();
	$conUpdate="update param_mantenimiento 
	set cantidad='$_GET[txtCantidad]',
	personal='$_GET[txtPersonal]'  
	where id_mes='$_GET[idMes]'";
	 $result=mysql_query($conUpdate);
	 $affected=mysql_affected_rows();
	 mysql_close();
	 if ($affected>0) { ?>
	 	<script type="text/javascript">location.href='index2.php?item=620';</script>
<?php
	}
}



?>

<link rel="STYLESHEET" type="text/css" href="../site/migracionestilo.css">	

<?php
conectarMysql();
$conMeses="select id_mes,mes,cantidad,personal from param_mantenimiento where id_mes='$_GET[idMes]'";
$result=mysql_query($conMeses);
mysql_close();
if ($result && mysql_numrows($result)>0) {
	$row=mysql_fetch_array($result);
}
?>
<h1>MES DE <?=$row[1]?></h1>
<fieldset>
<form name="frmMantenimiento" method="GET" action="<?=$_SERVER[PHP_SELF]?>">
<input name="item" type="hidden" value="621">
<input class="inputTexto" name="idMes" type="hidden" value="<?=$_GET[idMes]?>">
<p>
<label for="cantidad">CANTIDAD DE MANTENIMIENTOS PROGRAMADOS:</label><br>
<input class="inputTexto" name="txtCantidad" type="text" value="<?=$row[2]?>" onkeypress="if (event.keyCode > 47 && event.keyCode > 58) event.returnValue = false;">
</p>
<p>
<label for="personal">PERSONAL DISPONIBLE:</label><br>
<input class="inputTexto" name="txtPersonal" type="text" value="<?=$row[3]?>" onkeypress="if (event.keyCode > 47 && event.keyCode > 58) event.returnValue = false;">
</p>
<input name="btnSalir" type="button" value="REGRESAR" onclick="location.href='index2.php?item=620'">
<input name="btnGuardar" type="submit" value="GUARDAR">
</form>
</fieldset>
