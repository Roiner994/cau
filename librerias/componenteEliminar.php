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
		//echo "<br> llego: ".	
		$veli[$p]=$pal;
		$pal='';
	}
}

if ($p>0) {
	for($i=1; $i<=$p; $i++){
		//echo "<br> $i $p $cont llego: ".	$veli[$i];
		if ($veli[$i]!="on"){
			$componente= new componente();
			$componente->setInventario($veli[$i]);
			$resultadoEliminar=$componente->eliminarComponente();
			if ($resultadoEliminar==0) { 				
				$cont++;	
			}	
		}else {
			$cont++;
		}
	}
	//echo "<br>".$cont." == ".$p;
	if ($cont==$p){		?>
		<br><br><br><br><br><br><br><br>
		<table class="mensajeTitulo" align="center">
			<tr><td align=center>MENSAJE: INVENTARIO - ELIMINAR COMPONENTES</td></tr>
			<tr><td valign="top" class="mensaje" align="center">
				<form name="frmComponenteEliminar" method="GET">
					<p>Componente Eliminado<br>
					<input name="btnContinuar" type="button" value="Continuar" onclick="location.href='rptResumenComponentes.php?funcion=<?=1?>&sitio=<?=$_GET[sitio]?>&idGerencia=<?=$_GET[idGerencia]?>&idDescripcion=<?=$_GET[idDescripcion]?>&idMarca=<?=$_GET[idMarca]?>&idModelo=<?=$_GET[idModelo]?>&idPedido=<?=$_GET[idPedido]?>&idEstado=<?=$_GET[idEstado]?>'">	
					</p>
				</form>
			</td></tr>
		</table>
		<?php
		exit();			
	} else { ?>
		<br><br><br><br><br><br><br><br>
		<table class="mensajeTitulo" align="center">
			<tr><td align=center>MENSAJE: INVENTARIO - ELIMINAR COMPONENTES</td></tr>
			<tr><td valign="top" class="mensaje" align="center">
				<form name="frmComponenteEliminar" method="GET"></form>
				<p>La Eliminación de Componentes no fue satisfactoria<br>
				<input name="btnCancelar" type="button" value="Cancelar" onclick="location.href='rptResumenComponentes.php?funcion=<?=1?>&sitio=<?=$_GET[sitio]?>&idGerencia=<?=$_GET[idGerencia]?>&idDescripcion=<?=$_GET[idDescripcion]?>&idMarca=<?=$_GET[idMarca]?>&idModelo=<?=$_GET[idModelo]?>&idPedido=<?=$_GET[idPedido]?>&idEstado=<?=$_GET[idEstado]?>'">	
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
				<td align=center>MENSAJE: INVENTARIO - ELIMINAR COMPONENTES</td>
				</tr>
				
				<tr>
					<td valign="top" class="mensaje" align="center">
					<form name="frmComponenteEliminar" method="GET"></form>
					<p>No Selecciono Componentes para Eliminar<br>
					<input name="btnCancelar" type="button" value="Cancelar" onclick="location.href='rptResumenComponentes.php?funcion=<?=1?>&sitio=<?=$_GET[sitio]?>&idGerencia=<?=$_GET[idGerencia]?>&idDescripcion=<?=$_GET[idDescripcion]?>&idMarca=<?=$_GET[idMarca]?>&idModelo=<?=$_GET[idModelo]?>&idPedido=<?=$_GET[idPedido]?>&idEstado=<?=$_GET[idEstado]?>'">	
					</p>
					</td>
				</tr>
				</table>		
	<?php		exit();
}

?>