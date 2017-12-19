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
$fechaActual=getdate();
$anhoActual=$fechaActual[year];
unset($fechaActual);
?>
<link rel="STYLESHEET" type="text/css" href="../site/migracionestilo.css">
<table border="1" width="80%">
<caption>MANTANIMIENTOS PROGRAMADOS PARA EL AÑO <?=$anhoActual?></caption>
<tr>
<th>MES</th>
<th>CANTIDAD</th>
<th>PERSONAL</th>
</tr>
<?php
conectarMysql();
$conMeses="select id_mes,mes,cantidad,personal from param_mantenimiento order by id_mes";
$result=mysql_query($conMeses);
mysql_close();
if ($result && mysql_numrows($result)>0) {
	unset($total);
	while ($row=mysql_fetch_array($result)) { 
		if ($i%2==0) {
			$clase="FilaPar";
		} else {
			$clase="FilaNone";
		}?>
		<tr class="<?=$clase?>">
		<td><a class="enlace" href="index2.php?item=621&idMes=<?=$row[0]?>"><?=$row[1]?></a></td>
		<td><?=$row[2]?></td>
		<td><?=$row[3]?></td>
		</tr>

		
<?php
		$total=$total+$row[2];
		$i++;
	}
}
?>
<tr class="pieTabla">
<td>TOTAL</td>
<td><?=$total?></td>
<td>&nbsp;</td>
</tr>
</table>

</html>