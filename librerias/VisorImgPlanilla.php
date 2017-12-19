<?php 
	require_once ("formularios.php");
	require_once ("conexionsql.php");
	require_once ("administracion.php");
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
		echo "<td class=\"tituloPagina\" colspan=\"2\">PLANILLA CORRESPONDIENTE ".($GET['tipo']=='E' ? "A LA CONFIGURACION $GET[data]" : "AL EQUIPO $GET[data]")." </td>
  				</tr>";
		echo "<tr>";
		
		
		echo "<td class=\"tituloPagina\" colspan=\"2\"> 
		<img src='$GET[url]'>
		
		</td>		
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DETALLES</td>
  				</tr>";
			echo "<tr>";
			echo "<td class=\"formularioCampoTitulo\">ERROR EN PLANILLA<br>$errorPlanilla<br>";
			echo "</tr>";			
			
			
			
			
			
			
		echo "</table>";
		
	echo "</form>";			
	
	?>
	
</body>

</html>
