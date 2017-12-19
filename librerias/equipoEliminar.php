<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("inventarioAdmin.php");
require_once("conexionsql.php");
?>

<?php

$t=strlen($_POST[nfil]); //nfil es un campo donde se guardan los elementos que le diste check, q no te asuste me toco hacerlo asi, y asi me funciona perfectamente.

$p=0;
$cont=0;

for($i=0;$i<$t;$i++){
	$x=substr($_POST[nfil],$i,1);
	if($x!='*'){
		$pal=$pal.$x;
	}
	else{
		$p++;
		//echo "<br> llego: ".$veli[$i];	
		$veli[$p]=$pal;
		$pal='';
	}
}

if ($p>0) {
	for($i=1; $i<=$p; $i++){
		//echo "<br> $t $i $p $cont se elimino: ".$veli[$i];
		if ($veli[$i]!="on"){
			$equipoBuscar=new equipo();
			$equipoBuscar->setEquipo($veli[$i]);
			$resultado=$equipoBuscar->buscarEquipo();	
			//echo "Equipo:".$resultado;
			$resultadoEliminar=$equipoBuscar->eliminarEquipo();
			//echo "Equipo:".$resultadoEliminar;
			if ($resultadoEliminar==0) { 				
				$cont++;	
				$row=mysql_fetch_array($resultado);
				$serialInventario=$row[3];
				$consulta="delete from inventario where serial='$serialInventario'";
				conectarMysql();
				$result=mysql_query($consulta);
				mysql_close();	
			}else {
				$cont++;
		}
	}
	}
	if ($cont==$p){		?>
		<br><br><br><br><br><br><br><br>
		<table class="mensajeTitulo" align="center">
			<tr><td align=center>MENSAJE: INVENTARIO - ELIMINAR EQUIPOS</td></tr>
			<tr><td valign="top" class="mensaje" align="center">
				<form name="frmEquipoEliminar" method="GET">
					<p>Equipo Eliminado<br>
					<input name="btnContinuar" type="button" value="Continuar" onclick="location.href='rptResumenInventarios.php?funcion=<?=1?>&sitio=<?=$_GET[sitio]?>&idGerencia=<?=$_GET[idGerencia]?>&idDescripcion=<?=$_GET[idDescripcion]?>&idMarca=<?=$_GET[idMarca]?>&idModelo=<?=$_GET[idModelo]?>&idPedido=<?=$_GET[idPedido]?>&idEstado=<?=$_GET[idEstado]?>'">	
					</p>
				</form>
			</td></tr>
		</table>
		<?php
		exit();			
	} else { ?>
		<br><br><br><br><br><br><br><br>
		<table class="mensajeTitulo" align="center">
			<tr><td align=center>MENSAJE: INVENTARIO - ELIMINAR EQUIPOS</td></tr>
			<tr><td valign="top" class="mensaje" align="center">
				<form name="frmEquipoEliminar" method="GET"></form>
				<p>La Eliminación de los equipos no fue satisfactoria<br>
				<input name="btnCancelar" type="button" value="Cancelar" onclick="location.href='rptResumenInventarios.php?funcion=<?=1?>&sitio=<?=$_GET[sitio]?>&idGerencia=<?=$_GET[idGerencia]?>&idDescripcion=<?=$_GET[idDescripcion]?>&idMarca=<?=$_GET[idMarca]?>&idModelo=<?=$_GET[idModelo]?>&idPedido=<?=$_GET[idPedido]?>&idEstado=<?=$_GET[idEstado]?>'">	
				</p>
			</td></tr>
		</table>		
		<?php 
		exit();
	}	
}else {
	?>
				<br><br><br><br><br><br><br><br>
				<table class="mensajeTitulo" align="center">
				<tr>
				<td align=center>MENSAJE: INVENTARIO - ELIMINAR EQUIPOS</td>
				</tr>
				
				<tr>
					<td valign="top" class="mensaje" align="center">
					<form name="frmEquipoEliminar" method="GET"></form>
					<p>No Selecciono Equipo para Eliminar<br>
					<input name="btnCancelar" type="button" value="Cancelar" onclick="location.href='rptResumenInventarios.php?funcion=<?=1?>&sitio=<?=$_GET[sitio]?>&idGerencia=<?=$_GET[idGerencia]?>&idDescripcion=<?=$_GET[idDescripcion]?>&idMarca=<?=$_GET[idMarca]?>&idModelo=<?=$_GET[idModelo]?>&idPedido=<?=$_GET[idPedido]?>&idEstado=<?=$_GET[idEstado]?>'">	
					</p>
					</td>
				</tr>
				</table>		
	<?php		exit();
}

?>