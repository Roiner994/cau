<?php
include "../libreriasCarlos/administracion.php";
include "../librerias/conexionsql.php";
switch ($_POST[funcion])
{
	case '1':
		agregar();
	break 1;
	
	default:
		formulariodsp();
	break 1;

}

function formulariodsp()
{
	conectarMysql();
	$abreviatura = "DSP";
	echo " <em><strong><center>AGREGAR DESCRIPCION PROPIEDAD</center>"
  	. "  </strong></em>"
  	."";
	 
  	$consulta="SELECT ID_DESCRIPCION_PROPIEDAD FROM descripcion_propiedad ORDER BY ID_DESCRIPCION_PROPIEDAD DESC";
  	$idConsecutivo= new consecutivo("DSP", $consulta);
  	$Id_dsp=$idConsecutivo->retornar();

	echo"<form action=\"$ruta\" method=\"post\"  name=\"formulariocaptdsp\">"
	. "<input name=\"funcion\" type=\"hidden\" value=\"1\">"
  	. "  <table width=\"200\" align='center' border=\"0\">"
  	. "    <tr>"
  	. "      <td><strong>DESCRIPCION:</strong></td>"
  	. "	  <td><input type=\"text\" name=\"cdescripcion_propiedad\"></td>"
  	. "      <td>&nbsp;</td>"
  	. "    </tr>"
  	. "  </table>"
  	. "  <p>&nbsp;</p>"
  	."<center><input name=\"btnalmacenar\" type=\"submit\" value=\"Almacenar\" ></center>"
   	. "</form>"
  	. ""; 
 
	mysql_close();
}	
 
function agregar()
{
	//$ruta="index.php?item=115";	
	$status='1';
 	conectarMysql();
  	$consulta="SELECT ID_DESCRIPCION_PROPIEDAD FROM descripcion_propiedad ORDER BY ID_DESCRIPCION_PROPIEDAD DESC";
  	$idConsecutivo= new consecutivo("DSP", $consulta);
  	$id_dsp=$idConsecutivo->retornar();
	$dsp= strtoupper($_POST[cdescripcion_propiedad]);

	echo"<form action=\"$ruta\" method=\"post\"  name=\"formularioagregar\">";
	if ($dsp!='')
	{
		$sql = "INSERT INTO descripcion_propiedad(ID_DESCRIPCION_PROPIEDAD,DESCRIPCION_PROPIEDAD,STATUS_ACTIVO) VALUES ('$id_dsp','$dsp','$status')";
		$result = mysql_query($sql);    
		if(($result) AND ($_POST[cdescripcion_propiedad]))
		{
			echo "<br>";
       		echo "<center><strong>REGISTRO INSERTADO CORRECTAMENTE</strong></center>";
    	}
    	else
		{
    		echo "<br>";
       		echo "<center><strong>ERROR AL INSERTAR EN LA BD</strong></center>";
    	} 

  		echo "<p>&nbsp;</p>";
  		echo "<p>&nbsp;</p>";
  		echo "<div align=\"center\">";
  		echo "<input name=\"Volver\" type=\"submit\" value=\"Agregar otro\">";
  		echo "</div>";

		
	}
	else
	{
	   	echo "<br>";
   		echo "<center><strong>ERROR INTRODUZCA UNA DESCRIPCION</strong></center>";
		echo "<p>&nbsp;</p>";
		echo "<center><strong><input name=\"btnatra\" type=\"submit\" value=\"Atras\">";

	}
	echo "</form>";

	mysql_close(); 
} 
 ?>
