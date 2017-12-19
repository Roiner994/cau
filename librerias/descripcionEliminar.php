<?php
include "conexionsql.php";
include "administracion.php";
switch ($_POST[funcion])
{
	case '1':
		msjeliminar();
	break 1;
	
	case '2':
		eliminar();
	break 1;

	default:
		formularioeliminar();
	break 1;
}

function formularioeliminar()
{
	conectarMysql();
	echo " <em><strong><center>ELIMINAR SITIO</center>"
  		. "  </strong></em>"
  		."";
	
  	$consulta="SELECT * FROM descripcion WHERE STATUS_ACTIVO = '1' ORDER BY ID_DESCRIPCION DESC";
  	$Rsdescripcion= mysql_query($consulta);
 
	echo "<form name=\"formborrar\" method=\"post\" action=\"\">";
	echo "<input name =\"funcion\" type=\"hidden\" value=\"1\">";

    echo "<b><td><H4 align='center'>DESCRIPCION:</b></td>"."<td>"; 	

	echo "<select name=\"seldescripcion\" >";
	echo "<option value=\"100\">-DESCRIPCION-</option>";
	while ($row=mysql_fetch_array($Rsdescripcion)) 
	{
		if ($row[0]==$Iddes) 
		{
			echo "<option selected value=$row[0]>$row[1]</option>";	
		}
		else
		{
			echo "<option value=$row[0]>$row[1]</option>";
		}
	}
	echo "</select>";		
	
	echo "  <p>&nbsp;</p>";
	echo "<center><input name=\"submit\" type=\"submit\" value=\"Eliminar\"></center>";
	echo "</form>";

	mysql_close();
}	

function msjeliminar()
{
	
	$valo=$_POST[seldescripcion];
	conectarMysql();

	$sql= "SELECT * FROM descripcion WHERE ID_DESCRIPCION='$_POST[seldescripcion]'";
	$Rsdescripcion= mysql_query($sql);

	if ($row=mysql_fetch_array($Rsdescripcion))
	{
		echo "<center><strong>DESEA ELIMINAR ESTA DESCRIPCION:</strong></center>";
		echo "<p>&nbsp;</p>";

		echo "<form input name=\"formmod\" method=\"post\" action = \"\" >";

		echo "<center><strong>Nº: </strong>$_POST[seldescripcion]</center>";
		echo "<center><strong>DESCRIPCION:</strong> $row[1]</center>";
  
    	echo "<input name=\"prueb\" type=\"hidden\" value=\"$valo\">";
		echo "<input name =\"funcion\" type=\"hidden\" value=\"2\">";
		echo "<p>&nbsp;</p>";
		echo "<center>";
		echo "<input name=\"btnsi\" type=\"submit\" value=\"SI\" >";
		echo "<input name=\"btnNo\" type=\"button\" value=\"NO\" onClick=\"history.go(-1)\">";
		echo "</center>";
  		echo "</form>";
	}
	else
	{
		echo "<center><strong>INTRODUZCA UNA DESCRIPCION EXISTENTE</strong></center>";

 		echo"<form action=\"\" method=\"post\"  name=\"atras\">";
  		echo "<center><input name=\"btnatras\" type=\"submit\" value=\"Atras\" ></center>";
  		echo "</form>";

	}
	mysql_close();
}

function eliminar()
{
	conectarMysql();
	$valoculto=$_POST[prueb];

	$sql= "UPDATE descripcion SET STATUS_ACTIVO = '0' WHERE ID_DESCRIPCION = '$_POST[prueb]'";

	echo "<form inpur name =\"frmporox\" method =\"post\" action =\"\">";
	$mod=mysql_query($sql);

	if ($mod)
	{
		echo "<p>&nbsp;</P>";
		echo "<center><strong>REGISTRO ELIMINADO CON EXITO</strong></center>";
		echo "<p>&nbsp;</P>";
	}
	else{
		echo "<center><strong>OPERACION FALLIDA</strong></center>";
		}
  	echo "<center><input name=\"btnborrar\" type=\"submit\" value=\"Borrar Otro\" ></center>";
  	echo "</form>";

	mysql_close();
}
?>