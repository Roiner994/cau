<?php 
include 'connect.php';
	
	if ($_POST['fecha_inicio']!=null && $_POST['fecha_inicio']!=null) {
		$fecha_inicio=$_POST['fecha_inicio'];
		$fecha_final=$_POST['fecha_final'];
		$sql="SELECT * FROM asistencias WHERE fecha>='$fecha_inicio' and fecha<='$fecha_final'";
		$res =mysql_query($sql,$con);
	}
	else{
		$sql = "SELECT * FROM asistencias";
		$res =mysql_query($sql,$con);
	}
?>
<form name="importa" method="POST" action="index2.php?item=701">
	<table class="formularioTabla" align="center" width="500" border="0">
	<tr>
		<td class="tituloPagina" colspan="2">ASISTENCIA DE PERSONAL</td>
	</tr>
	<tr>
		<td class="formularioTablaTitulo" colspan="2">FILTRAR</td>
	</tr>
	<tr>
		<td class="formularioTablaTitulo">
			<input type="date" name="fecha_inicio" required> FECHA INICIO
			<br>
			<br>
			<input type="date" name="fecha_final" required> FECHA FINAL
		</td>
	</tr>
	<tr>
		<td>
			<input type="submit" name="">
		</td>
	</tr>
	</table>
</form>
<table border="1px" class="formularioTabla tabla_p" align="center" width="400">
	<thead>
		<tr>
			<td >FECHA</td>
			<td>CODIGO</td>
			<td >ACCION</td>
		</tr>
	</thead>
	<?php while ($row = mysql_fetch_array($res)){  ?>
	<tr>
		<td><?php echo $row['fecha']; ?></td>
		<td><?php echo $row['codigo']; ?></td>
		<td align="center" class="btnver">
			<a href="../librerias/asistencia_detalle.php?fecha=<?php echo $row ['fecha'];?>&codigo=<?php echo $row ['codigo'];?>&opcion=1" class="btnagregar btnverde">Ver</a>
			<a href="../librerias/asistencia_detalle.php?fecha=<?php echo $row ['fecha'];?>&codigo=<?php echo $row ['codigo'];?>&opcion=2" class="btnagregar btnverde">Descargar</a>
		</td>
	</tr>
	<?php } ?>
</table>