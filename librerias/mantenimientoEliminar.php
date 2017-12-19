<?php
require_once("seguridad.php");
require_once 'formularios.php';
?>


<script type="text/javascript">
	function confirmar_eliminacion(id){
			if(confirm("Esta seguro que desea eliminar el Mantenimiento "+id.value)){
					id.form.submit();
			}else
				id.checked=false;
	}


</script>
<?php
require_once("conexionsql.php");

if(isset($_POST['blanco'])){
	$consulta="DELETE FROM mantenimiento_preventivo WHERE ID_MANTENIMIENTO='$_POST[blanco]'";
	conectarMysql();
	$rs=mysql_query($consulta);

	if($rs){
		
	echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
	echo "<tr>";
	echo "<td align=center>MANTENIMIENTO ELIMINADO CON EXITO</td>
	</tr></table><br><br>";
	
		
	}
	
}


$login=$_SESSION["login"];
if ($login!="USS0000004" && $login!="USS0000003" && $login!="USS0000013" && $login!="USS0000031" && $login!="USS0000011" && $login!="USS0000014" && $login!="USS0000071") {
	
	
	echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";

	echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[txtConfiguracion]\">";
	echo "<br><br><br><br>";
	echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
	echo "<tr>";
	echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
	</tr>";
	echo "<tr>";
	echo "<td valign=top class=\"mensaje\" align=center>LLAMAR A LA EXTENSION 4809 O 5856 PARA REACTIVAR EL MANTENIMIENTO</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
	echo "</tr>";
	echo "</table>";
	echo "</form>";
	exit();			
}

	echo "<form name=\"frmMantenimiento\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<input name=\"idMantenimiento\" type=\"hidden\" value=\"$_POST[idMantenimiento]\">";
	echo "<table class=\"formularioTabla\"align=center width=\"300\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"tituloPagina\">MANTENIMIENTO PREVENTIVO</td>
	</tr>";
	echo "<tr>
	<td valign=top class=\"formularioTablaTitulo\" colspan=\"2\">ELIMINAR MANTENIMIENTO PREVENTIVO</td>";
	echo "</tr>
	<tr>
	<td valign=top class=\"formularioCampoTitulo\">
	CONFIGURACION<br>
	<input class=\"formularioCampoTexto\" name=\"txtConfiguracion\" type=\"text\" value=\"$_POST[txtConfiguracion]\">
	</td>
	</tr>";
	echo "<tr>
		<td class=\"formularioTablaBotones\" align=\"center\">
		<input name=\"btnAsociar\" type=\"submit\" value=\"EJECUTAR\"></td>
	</tr>";
	echo "</table>";
	echo "</form>";

		$consulta="SELECT ".					
					"mantenimiento_preventivo.ID_MANTENIMIENTO, ".
					"DATE(mantenimiento_preventivo.HORA_INICIO), ".
					"usuario_sistema.NOMBRE, ".
					"usuario_sistema.APELLIDO, ".
					"mantenimiento_preventivo.CONFIGURACION ".
					"FROM mantenimiento_preventivo,usuario_sistema WHERE ".
					"mantenimiento_preventivo.CONFIGURACION LIKE '%$_POST[txtConfiguracion]%' AND ".
					"mantenimiento_preventivo.ID_USS=usuario_sistema.ID_USS ".
					"ORDER BY mantenimiento_preventivo.HORA_INICIO DESC LIMIT 20";				
		conectarMysql();
		$result=mysql_query($consulta);
		
		
		
		
		if ($result && mysql_numrows($result)>0) {
			
			
			echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";			
			echo "<tr><td class=\"tituloPagina\" colspan=4>MANTENIMIENTOS EFECTUADOS</td></tr>";
			echo "<tr valign=top class=\"tablaTitulo\">
				<td valign=top class=\"tablaTitulo\">CONFIGURACION</td>
				<td align=\"left\" class=\"tablaTitulo\">MANTENIMIENTO</td>
				<td valign=top class=\"tablaTitulo\">ANALISTA</td>
				<td valign=top class=\"tablaTitulo\">FECHA</td>				
				<td valign=top class=\"tablaTitulo\">ELIMINAR</td>								
				</tr>";			
			while($row=mysql_fetch_array($result)){
				if ($i++%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
				}
				
				
				$Id= new campo("blanco","checkbox","",$row[0],"","","onclick","confirmar_eliminacion(this);",0,$row[0]);
				$txtId=$Id->retornar();				
				echo "<tr class=\"$clase\">";
				echo "	<td>$row[4]</td>					
						<td>$row[0]</td>
						<td>$row[2] $row[3]</td>							
						<td>$row[1]</td>		
						
						<form name=\"$row[0]\" method=\"post\" action=\"\">
						<input name='txtConfiguracion' value='$_POST[txtConfiguracion]' type='hidden'>
						<td>$txtId</td>
						</form>
					</tr>";
				
				
			}
			echo "</table>";		
		
		}
		mysql_close;


?>

