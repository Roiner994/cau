<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>GESTION MANTENIMIENTO PREVENTIVO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<html>
<head>

<title>GESTION MANTENIMIENTO PREVENTIVO</title>
</head>

</head>

<body>
 <h1 align="center">GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
               DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
               </h1>
<?
require ("../conexionsql.php");;

$fecha_ini="$year-$month-$day";
$fecha_fin="$year2-$month2-$day2";

//echo "$fecha_ini<br>";
//echo "$fecha_fin<br>";


echo "<table align=center border=1 cellpadding=0 cellspacing=0 borercolor width=600>";
echo "<tr bgcolor=#d6d6d6 height=25><td><b>DETALLES</b></td><td><b>DEPARTAMENTO</b></td><td><b>MANTENIMIENTOS</b></td></TR>";

	$conn = conectarMysql();
   $query = "SELECT * FROM mantenimiento_preventivo WHERE HORA_INICIO between '$fecha_ini' and '$fecha_fin' order by ID_DEPARTAMENTO;";
   $result1 = @mysql_query($query);
   $result = db_result_to_array($result1);
   $registros=@mysql_num_rows($result1);
   function db_result_to_array($result) 
{ 

   if ($registros==0)
 {
 echo "no hay registros";
 }

  else
  { 
  $i=1;
  $cont=1;
  }

	foreach ($result as $r)
	{
	
	
		$dpto[$i]=$r["ID_DEPARTAMENTO"];
		
		if ($dpto[$i]!=$dpto[$i-1])
		{
				$j=$i-1;
				if ($j==0)
				{
				}
				else
				{
				$conn = conectarMysql();
   				$query = "select * from departamento where ID_DEPARTAMENTO = '$dpto[$j]'";
				$result = mysql_query($query);
				$result = db_result_to_array($result);
					foreach ($result as $r)
					{
					echo "<tr><td align=center><a href=detalle_matenimiento.php?id_depto=$dpto[$j]><img src=imagenes/lupa.jpg border=0></a></td><td>";
					echo "$r[DEPARTAMENTO]</td>";
					echo"<td ALIGN=CENTER>$cont</td></tr>";
					}
   				
				$cont=1;
				}
		}
		else
	{
		$cont++;
		}
		
		
		$i++;
	}
	
	$j++;
	$query = "select * from departamento where ID_DEPARTAMENTO = '$dpto[$j]'";
				$result = mysql_query($query);
				//$result = db_result_to_array($result);
					//foreach ($result as $r)
					{
					echo "<tr><td align=center><a href=detalle_matenimiento.php?id_depto=$dpto[$j]><img src=imagenes/lupa.jpg border=0></a></td><td>";
					echo "$r[DEPARTAMENTO]</td>";
					echo"<td ALIGN=CENTER>$cont</td></tr>";
					}
	
}
?>
</body>
</html>
