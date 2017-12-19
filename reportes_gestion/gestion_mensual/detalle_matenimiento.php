<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>GESTION MANTENIMIENTO PREVENTIVO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">

<body>
<h3 align="center">GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
               DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
</h3>
<p align="center">&nbsp;</p>
<h3 align="center">MANTENIMIENTOS PREVENTIVOS </h3>




<?
require ("../conexionsql.php");;

$registros = 1;
if (!$pagina) { 
   $inicio = 0; 
   $pagina = 1; 
} 
else { 
   $inicio = ($pagina - 1) * $registros; 
} 


$conn = conectarMysql();
   $query = "SELECT * FROM mantenimiento_preventivo WHERE ID_DEPARTAMENTO = '$id_depto'";
   $result = @mysql_query($query);
   $total_registros = @mysql_num_rows($result);
   
   

	$query = "SELECT * FROM mantenimiento_preventivo WHERE ID_DEPARTAMENTO = '$id_depto' order by ID_DEPARTAMENTO ASC LIMIT $inicio, $registros";
	function db_result_to_array($result) 
{ 
	$result = @mysql_query($query);
	

	$result = db_result_to_array($result);

 
   $total_paginas = ceil($total_registros / $registros); 



foreach ($result as $r)
	{
	
	echo "<table width=800 align=center>";
	echo "<tr height=25 bgcolor=#d6d6d6><td colspan=2><b>DETALLE DE MANTENIMIENTO PREVENTIVO</b></td></tr>";
	$id_mantenimiento=$r["ID_MANTENIMIENTO"];
	echo "<tr><td>ID MANTENIMIENTO</td><td>$r[ID_MANTENIMIENTO]</td></tr>";
	echo "<tr><td>FECHA</td><td>$r[HORA_INICIO]</td></tr>";
	echo "<tr height=25 bgcolor=#d6d6d6><td colspan=2><b>USUARIO</b></td></tr>";
	echo "<tr><td>FICHA</td><td>$r[FICHA]</td></tr>";
	$ficha=$r["FICHA"];
	$conn = conectarMysql();
   				$query = "select * from usuario where FICHA = '$ficha'";
				$result = @mysql_query($query);
				$result = db_result_to_array($result1);
					foreach ($result as $r)
					{
					echo "<tr><td>NOMBRE</td><td>$r[NOMBRE_USUARIO]</td></tr>";
					echo "<tr><td>APELLIDO</td><td>$r[APELLIDO_USUARIO]</td></tr>";
						$idcargo=$r["ID_CARGO"];
						$query = "select * from CARGO where ID_CARGO = '$idcargo'";
						$cargo = @mysql_query($query);
						$cargo = db_result_to_array($cargo);
						foreach ($cargo as $car)
						{
						echo "<tr><td>CARGO</td><td>$car[CARGO]</td></tr>";
						}
					
					echo "<tr><td>EXTENSION</td><td>$r[EXTENSION]</td></tr>";
					}
	echo "<tr height=25 bgcolor=#d6d6d6><td colspan=2><b><strong>UBICACI&Oacute;N DEL EQUIPO EN EL MOMENTO QUE SE REALIZ&Oacute; EL MANTENIMIENTO PREVENTIVO</strong></b></td></tr>";
	$query = "select * from departamento WHERE ID_DEPARTAMENTO = '$id_depto'";
	$id_div = @mysql_query($query);
	$id_div = @mysql_result($id_div, 0, "ID_DIVISION");
	
	$query = "select * from departamento WHERE ID_DEPARTAMENTO = '$id_depto'";
	$nombre_dpto = @mysql_query($query);
	$nombre_dpto = @mysql_result($nombre_dpto, 0, "DEPARTAMENTO");

	$query = "select * from division where ID_DIVISION = '$id_div'";
	$id_ger = @mysql_query($query);
	
	
	$id_ger = db_result_to_array($id_ger);
	
	foreach ($id_ger as $ger)
	{
	$id_gerencia=$ger["ID_GERENCIA"];
	$nombre_div=$ger["DIVISION"];
	}
	
	$query = "select * from gerencia WHERE ID_GERENCIA = '$id_gerencia'";
	$gerencia = @mysql_query($query);
	$gerencia = @mysql_result($gerencia, 0, "GERENCIA");
	
	
	
	//echo $id_div;
	//echo $division;
	echo "<tr><td>GERENCIA</td><td>$gerencia </td></tr>";
	echo "<tr><td>DIVISION</td><td>$nombre_div</td></tr>";
	echo "<tr><td>DEPARTAMENTO</td><td>$nombre_dpto</td></tr>";
	echo "<tr height=25 bgcolor=#d6d6d6><td colspan=2><strong>EQUIPO AL QUE SE LE HIZO MANTENIMIENTO PREVENTIVO</strong></td></tr>";
	
	$query = "SELECT * FROM mantenimiento_preventivo WHERE ID_MANTENIMIENTO = '$id_mantenimiento'";
   $result = @mysql_query($query);
   $result = db_result_to_array($result);
   
	foreach ($result as $row)
	{
	$config=$row["CONFIGURACION"];
	$trabajo=$row["TRABAJO_REALIZADO"];
	$observacion=$row["OBSERVACION"];
	$iduss=$row["ID_USS"];
	}
	echo "<tr><td>CONFIGURACION</td><td>$config</td></tr>";
	echo "<tr><td>DESCRIPCION</td><td></td></tr>";
	echo "<tr><td>MARCA</td><td></td></tr>";
	echo "<tr><td>MODELO</td><td></td></tr>";
	echo "<tr><td>SERIAL</td><td></td></tr>";
	
	
	echo "<tr height=25 bgcolor=#d6d6d6><td colspan=2><strong>TRABAJO REALIZADO</strong></td></tr>";
	echo "<tr><td colspan=2>$trabajo</td></tr>";
	echo "<tr height=25 bgcolor=#d6d6d6><td colspan=2><strong>OBSERVACIONES</strong></td></tr>";
	
	if ($observacion = " ")
	{
	$observacion="NO HAY OBSERVACIONES";
	}
	echo "<tr><td colspan=2>$observacion</td></tr>";
	echo "<tr height=25 bgcolor=#d6d6d6><td colspan=2><strong>T&Eacute;CNICO QUE REALIZO EL MANTENIMIENTO</strong></td></tr>";
	
	$query = "SELECT * FROM usuario_sistema WHERE ID_USS = '$iduss'";
   $result = @mysql_query($query);
   $result = db_result_to_array($result1);
   
	foreach ($result as $row)
	{
	$nombre=$row["NOMBRE"];
	$apellido=$row["APELLIDO"];
	
	}
	
	echo "<tr><td colspan=2>$nombre $apellido</td></tr>";
	
	}

echo "</table>";
	
	echo "<center>";
if(($pagina - 1) > 0) {
   echo "<a href='detalle_matenimiento.php?pagina=".($pagina-1)."&&id_depto=$id_depto'>< Anterior</a> ";
}

for ($i=1; $i<=$total_paginas; $i++){ 
   if ($pagina == $i) 
      echo "<b>".$pagina."</b> "; 
   else
      echo "<a href='detalle_matenimiento.php?pagina=$i&&id_depto=$id_depto'>$i</a> "; 
}

if(($pagina + 1)<=$total_paginas) {
   echo " <a href='detalle_matenimiento.php?pagina=".($pagina+1)."&&id_depto=$id_depto'>Siguiente ></a>";
}
echo "</center>";
echo "<p>&nbsp</p>";
echo "<p align=center><a href=formulario.php>VOLVER AL FORMULARIO DE CONSULTA</a></p>";
}
?>
</body>
</html>
