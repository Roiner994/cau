<?php 
	require_once ("formularios.php");
	require_once ("conexionsql.php");
	require_once ("administracion.php");
	
	$observaciones="''";	
	$errorPlanilla="''";
	$planillaAsignacion="''";
	if(isset($_POST['observacion']))	
		$observaciones=$_POST['observacion'];		
		$errorPlanilla=isset($_POST['errorPlanilla'])? $_POST['errorPlanilla'] : 0;
		$planillaAsignacion=isset($_POST['planillaAsignacion'])? $_POST['planillaAsignacion'] : 0;
	
		
	
	conectarMysql();
	$query1="SELECT ID_DETALLE_MANTENIMIENTO_PREVENTIVO FROM detalle_mantenimiento_preventivo WHERE ID_MANTENIMIENTO_PREVENTIVO='".$_GET['target']."'";	
	$rs=mysql_query($query1);
	$status="";
	$error="";
	
	if(isset($_POST['sw']))
	if ($rs && mysql_numrows($rs)>0) {		
			$query2="UPDATE detalle_mantenimiento_preventivo SET ".
			"OBSERVACIONES='$observaciones',".
			"ERROR_PLANILLA='$errorPlanilla',".
			"PLANILLA_ASIGNACION_MANTENIMIENTO='$planillaAsignacion'".
			"WHERE ID_MANTENIMIENTO_PREVENTIVO='".$_GET['target']."'";			
			$rs=mysql_query($query2);
			if($rs && mysql_affected_rows()>0)
				$status="var lol=window.opener.document.getElementById('".$_GET['target']."'); if(!lol.checked)lol.checked=true; window.close();";
			else
				$error="OCURRIO UN ERROR AL ACTUALIZAR";
			
			
			
	}else{		
		$conUltimo="SELECT ID_DETALLE_MANTENIMIENTO_PREVENTIVO FROM detalle_mantenimiento_preventivo ORDER BY ID_DETALLE_MANTENIMIENTO_PREVENTIVO DESC";
		$cons=new consecutivo("DMT",$conUltimo);	
		$id_detalle=$cons->retornar();
		$query2="INSERT INTO detalle_mantenimiento_preventivo values(".
		"'".$id_detalle."',".
		"'".$_GET['target']."',".
		"0,".
		"'',".
		"'',".
		"'',".
		"'',".
		"0,".
		"'$observaciones',".
		"'',".
		"'',".
		"0,".
		"0,".
		"0,".
		"0,".
		"$errorPlanilla,".
		"$planillaAsignacion".		
		")";
		
		
		$rs=mysql_query($query2);		
		if($rs && mysql_affected_rows()>0)
				$status="var lol=window.opener.document.getElementById('".$_GET['target']."'); if(!lol.checked)lol.checked=true; window.close();";
		else
				$error="OCURRIO UN ERROR AL REGISTRAR";
	}	
	
	$query1="SELECT OBSERVACIONES, ERROR_PLANILLA, PLANILLA_ASIGNACION_MANTENIMIENTO FROM detalle_mantenimiento_preventivo WHERE ID_MANTENIMIENTO_PREVENTIVO='".$_GET['target']."'";
	$rs=mysql_query($query1);
	if($rs && mysql_num_rows($rs)>0){
		$row=mysql_fetch_array($rs);
			$_POST['observacion']=$row[0];
			$_POST['errorPlanilla']=$row[1];
			$_POST['planillaAsignacion']=$row[2];
	}
	
	
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>DETALLE DEL MANTENIMIENTO <?php echo strtoupper($_GET['target']); ?></title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.22" />
	<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">

</head>

<body onload="<?php echo $status; ?>">
	
	
	<?php 
	
		$epl=new campo("errorPlanilla","checkbox","","1","","","","",$_POST['errorPlanilla']!="" ?  $_POST['errorPlanilla']+0 : 0,"errorPlanilla");
		$errorPlanilla=$epl->retornar();
		
		$pla=new campo("planillaAsignacion","checkbox","","1","","","","",$_POST['planillaAsignacion']!="" ? $_POST['planillaAsignacion']+0 : 0,"planillaAsignacion");
		$planillaAsignacion=$pla->retornar();
		require_once 'administracion.php';
		
		
		
		
		echo "<form name=\"frmEquipo\" method=\"post\" action=\"\">";
	
	echo "<table class=\"formularioTabla\"align=center width=\"500\" border=\"0\">";
	if(!empty($error))
		echo "<tr><td class=\"tituloPagina\" colspan=\"2\">$error</td>
  				</tr>";
		echo "<tr>";
		echo "<td class=\"tituloPagina\" colspan=\"2\">EDICION DE DETALLES DE MANTENIMIENTO PREVENTIVO</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DETALLES</td>
  				</tr>";
			echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\">ERROR EN PLANILLA<br>$errorPlanilla<br>";
			echo "</tr>";			
			
			
			echo "<tr>";			
			echo "<td valign=top class=\"formularioCampoTitulo\" >PLANILLA DE ASIGNACION DE MANTENIMIENTO<br>$planillaAsignacion</td>";
			echo "</tr>";			
			
			echo "<tr>";			
			echo "<td valign=top class=\"formularioCampoTitulo\" >OBSERVACIONES<br><textarea name='observacion' id='observacion'>$_POST[observacion]</textarea>
			
			
			</td>";
			echo "</tr>";
			
			
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
