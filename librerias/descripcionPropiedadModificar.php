<?php
include "../librerias/administracion.php";
include "../LIBRERIAS/conexionsql.php";

switch($_POST[funcion])
{
	case '1':
		modificar();
	break 1;

	case '2':
		insertar();
	break 1;
	
	default:
		formulariomodificar();
	break 1;
	
}

function formulariomodificar()
{
	conectarMysql();
	
	echo " <em><strong><center>MODIFICAR DESCRIPCION PROPIEDAD</center>"
  	. "  </strong></em>"
  	."";
	 
  	$consulta="SELECT * FROM descripcion_propiedad ORDER BY ID_DESCRIPCION_PROPIEDAD DESC";
  	$Rsdsp= mysql_query($consulta);
 
	echo "<form name=\"prueba\" method=\"post\" action=\"$ruta\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
    echo "<b><td><H4 align='center'>DESCRIPCION:</b></td>"."<td>"; 	

	echo "<select name=\"seldsp\">";
	echo "<option value=\"100\">-DSP-</option>";
	while ($row=mysql_fetch_array($Rsdsp)) 
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

	echo "<center><input name=\"submit\" type=\"submit\" value=\"Modificar\"></center>";
	echo "</form>";

	mysql_close();
}	

function modificar()
{
	$valor=$_POST[seldsp];
	conectarMysql();

	$sql= "SELECT DESCRIPCION_PROPIEDAD FROM descripcion_propiedad WHERE ID_DESCRIPCION_PROPIEDAD = '$_POST[seldsp]'";
	$Rsdsp= mysql_query($sql);

	echo "<form input name=\"formmod\" method=\"post\" action=\"$ruta\">";
	if ($row=mysql_fetch_array($Rsdsp))
	{
		//echo $row[0];
		echo " <em><strong><center>HACER MODIFICACION</center>"
  		. "  </strong></em>"
  		."";

		echo "<p>&nbsp;</p>";

		echo "<center><strong>Nº: $_POST[seldsp]</strong></center>";


    	echo "<input name=\"prueba\" type=\"hidden\" value=\"$valor\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";

		echo "<center><strong>DESCRIPCION:</strong><input name=\"etidsp\" type=\"text\" size=\"60\" value=\"$row[0]\"></center>";
		
		echo "<p>&nbsp;</p>";
		echo "<center><input name=\"btnatras\" type=\"submit\" value=\"Modificar\"></center>";

	}
	else
	{

		echo "<center><strong>ERROR INTRODUZCA UNA DESCRIPCION EXISTENTE</strong></center>";
		echo "<p>&nbsp;</p>";
		echo "<center><input name=\"btnatra\" type=\"submit\" value=\"Atras\"></center>";
	}	
		echo "</form>";

	mysql_close();

}

function insertar()
{
	$idprueba=$_POST[prueba];

	conectarMysql();
	$dsp=strtoupper($_POST[etidsp]);
if($dsp!='')
{
	$sql=  "UPDATE descripcion_propiedad SET DESCRIPCION_PROPIEDAD = '$dsp' WHERE  ID_DESCRIPCION_PROPIEDAD='$_POST[prueba]'";

	echo "<form name =\"frmporox\" method =\"post\" action =\"$ruta\">";
	$mod=mysql_query($sql);

	if ($mod)
	{
		echo "<p>&nbsp;</P>";
		echo "<center><strong>REGISTRO MODIFICADO CON EXITO</strong></center>";
		echo "<p>&nbsp;</P>";
	}
	else
	{
		echo "<center><strong>ERROR AL MODIFICAR EN LA BD</strong></center>";
	}

  	echo "<center><input name=\"btnmodificar\" type=\"submit\" value=\"Modificar Otro\" ></center>";
  	echo "</form>";

	mysql_close(); 
}
}
?>