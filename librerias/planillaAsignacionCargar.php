<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<?php
require_once("seguridad.php");
require_once ("formularios.php");
require_once ("conexionsql.php");
require_once("archivos.php");
if(!isset($_GET['configuracion']))
	exit(0);

conectarMysql();
$conDespacho="	SELECT ec1.CONFIGURACION,iu1.FECHA_ASOCIACION, SHA1(iu1.FECHA_ASOCIACION) FROM
				usuario AS u1,inventario_usuario AS iu1, equipo_campo AS ec1,inventario AS i1
					WHERE
							ec1.CONFIGURACION='$configuracion' AND
							i1.ID_INVENTARIO=ec1.ID_INVENTARIO AND
							iu1.ID_INVENTARIO=i1.ID_INVENTARIO AND
							iu1.FICHA=u1.FICHA AND 							
							iu1.FECHA_ASOCIACION IN (SELECT MAX(iu2.FECHA_ASOCIACION) FROM
														inventario_usuario as iu2
														WHERE
														iu2.FICHA=iu1.FICHA AND
														iu2.ID_INVENTARIO=iu1.ID_INVENTARIO
														GROUP BY iu2.FICHA
													)AND
							iu1.STATUS_ACTUAL=1";
//echo $conDespacho;
$result=mysql_query($conDespacho);
if ($result && mysql_numrows($result)>0) {
	$row=mysql_fetch_array($result);	
	$configuracion=$row[0];
	$fecha_asociacion=$row[1];
	$huella=$row[2];
	$qu="SELECT COUNT(*), (SELECT ID_PLANILLA_ASIGNACION FROM planillas_asignacion WHERE  CONFIGURACION='$configuracion'  ORDER BY FECHA_CREACION DESC LIMIT 1)AS pla FROM planillas_asignacion WHERE FECHA_ASOCIACION_EQUIPO='$fecha_asociacion' AND CONFIGURACION='$configuracion'";	
	
	$re=mysql_query($qu);
	if($re){
		$row=mysql_fetch_array($re);	
		$cantidad=$row[0]+0;
		$anterior=$row[1];
	}
		
	
	
	
	
}else;
	
	//el formulario contiene un archivo
	if(isset($_POST['sw'])&&isset($_FILES['archivo']['name'])){	
		$info=getimagesize($_FILES['archivo']['tmp_name']);
		
		
		$uploaddir="../planillasequipos/";
		$uploadfile=$uploaddir.basename($_FILES['archivo']['name']);		
			
		$destino=$uploaddir."".$configuracion.";". $cantidad.";".$huella;				
		
		
		if(copy($_FILES['archivo']['tmp_name'],$destino.'.pdf')){
			$destino=$uploaddir."".$configuracion.";". $cantidad.";";
			$in="INSERT INTO planillas_asignacion VALUES(CONCAT('$destino',SHA1('$fecha_asociacion'),'.pdf'),'$configuracion',NOW(),'$fecha_asociacion')";					
			mysql_query($in);
			$qu="(SELECT ID_PLANILLA_ASIGNACION FROM planillas_asignacion WHERE  CONFIGURACION='$configuracion'  ORDER BY FECHA_CREACION DESC LIMIT 1)AS pla";
			
			$ld='onload="window.opener.buscarConfiguracion(); window.close();"';
			
			$tmp=mysql_query($qu);
			if($tmp){
				$row=mysql_fetch_array($tmp);
				$anterior=$row[0];
			}
				
			
		} 
		
		
	}
	
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>PLANILLA DE ASIGNACI&Oacute;N <?php echo strtoupper($_GET['target']); ?></title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.22" />
	<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">

</head>

<body <?php echo $ld;?>>
	
	
	<?php 
	
		
		$fl=new campo("archivo","file","","","","","onchange","document.imagen.src='file:///'+this.value;","","archivo");
		$filepl=$fl->retornar();		
		require_once 'administracion.php';
		
		
		
		
		echo "<form name=\"frmEquipo\" method=\"post\" enctype='multipart/form-data' action=\"\">";
	
	echo "<table class=\"formularioTabla\"align=center width=\"500\" border=\"0\">";
	if(!empty($error))
		echo "<tr><td class=\"tituloPagina\" colspan=\"2\">$error</td>
  				</tr>";
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">CARGA DE PLANILLA DE ASIGNACI&Oacute;N</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DETALLES</td>
  				</tr>";
			echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\"><br>Imagen<br>$filepl<br>";
			
			echo "</tr>";						
			
			
			
			
			if(isset($anterior)){
				echo "<tr>";
			echo "<td align=\"left\"><a class=enlace href=\"#\" onclick=\"window.open('planillas_asignacion.php?url=$anterior');\">Planilla de Asignacion Anterior</a></td>";
			
			echo "<br><br></tr>";						
				
			}
			
			
			
			echo "<tr>
			<td class=\"formularioTablaBotones\" align=\"center\" colspan=\"2\">
			<input name=\"btnBuscar\" type=\"submit\" value=\"ACTUALIZAR\">
			<input name='sw' type='hidden' value=1>
			</td>
			</tr>";
		echo "</table>";
		
	echo "</form>";			
	
	?>
	
</body>

</html>
