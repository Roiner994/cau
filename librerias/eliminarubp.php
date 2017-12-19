<?php
include "../librerias/administracion.php";
include "../LIBRERIAS/conexionsql.php";

switch($_POST[funcion])
{
	case '1':
		msjeliminar();
	break 1;

	case '2':
		eliminar();
	break 1;
	
	default:
		formularioborrar();
	break 1;
	
}

function formularioborrar()
{
	conectarMysql();
	echo " <em><strong><center>ELIMINAR UBICACION PROPIEDAD</center>"
  	. "  </strong></em>"
  	."";
	
  	$consulta="SELECT * FROM ubicacion_propiedad WHERE STATUS_ACTIVO = '1' ORDER BY ID_UBICACION_PROPIEDAD DESC";
  	$Rsubp= mysql_query($consulta);
 
	echo "<form name=\"formborrar\" method=\"post\" action=\"$ruta\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";

    echo "<b><td><H4 align='center'>UBICACION:</b></td>"."<td>"; 	

	echo "<select name=\"selubp\" >";
	echo "<option value=\"100\">-UBP-</option>";
	while ($row=mysql_fetch_array($Rsubp)) 
	{
		if ($row[0]==$Idsit) 
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

		echo "<center><input name=\"btneliminar\" type=\"submit\" value=\"Eliminar\"></center>";
		echo "</form>";

		mysql_close();
}	

function msjeliminar()
{
	$valo=$_POST[selubp];
	conectarMysql();

	$sql= "SELECT * FROM ubicacion_propiedad WHERE ID_UBICACION_PROPIEDAD='$_POST[selubp]'";
	$Rsubp= mysql_query($sql);

	if ($row=mysql_fetch_array($Rsubp))
	{
		echo "<center><strong>DESEA ELIMINAR ESTA UBICACION:</strong></center>";
		echo "<p>&nbsp;</p>";

		echo "<form input name=\"formmod\" method=\"post\" action = \"$ruta\" >";

		echo "<center><strong>Nº: </strong>$_POST[selubp]</center>";
		echo "<center><strong>UBICACION:</strong> $row[1]</center>";
	  
    	echo "<input name=\"prueb\" type=\"hidden\" value=\"$valo\">";
    	echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
	
		echo "<p>&nbsp;</p>";
		echo "<center>";
		echo "<input name=\"btnsi\" type=\"submit\" value=\"SI\" >";
		echo "<input name=\"btnNo\" type=\"button\" value=\"NO\" onClick=\"history.go(-1)\">";
		echo "</center>";
		echo "</form>";

	}
	else
	{
		echo "<p>&nbsp;</p>";
		echo "<center><strong>INTRODUZCA UNA UBICACION EXISTENTE</strong></center>";

	 	echo"<form action=\"$ruta\" method=\"post\"  name=\"atras\">";
  		echo "<center><input name=\"btnatras\" type=\"submit\" value=\"Atras\" ></center>";
  		echo "</form>";
	}
	mysql_close();
}

function eliminar()
{
	conectarMysql();
	$valoculto=$_POST[prueb];
	$sql= "UPDATE ubicacion_propiedad SET STATUS_ACTIVO = '0' WHERE ID_UBICACION_PROPIEDAD = '$_POST[prueb]'";

	echo "<form inpur name =\"frmporox\" method =\"post\" action =\"$ruta\">";
	$mod=mysql_query($sql);

	if ($mod)
	{
		echo "<p>&nbsp;</P>";
		echo "<center><strong>REGISTRO ELIMINADO CON EXITO</strong></center>";
		echo "<p>&nbsp;</P>";
		
	}
	else
	{
		echo "<center><strong>ERROR AL ELIMINAR EN LA BD</strong></center>";
	}

  	echo "<center><input name=\"btnborrar\" type=\"submit\" value=\"Borrar Otro\" ></center>";
	echo "</form>";

	mysql_close();

}
?>