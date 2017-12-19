<?php
require_once "administracion.php";
require_once "conexionsql.php";
	switch($_POST[funcion])
	{	
		case '1':
			insertar();
		break 1;
		case '2':
		//echo "yes<b>";
			asociamarca();
		//echo "yes<b>";
		break 1;
		case '3':
		//echo "yes<b>";
			insertarmarca();
		//echo "yes<b>";
		break 1;

		default:
		formularioagregar();
		break 1;
	}

function formularioagregar()
{
	conectarMysql();
	$abreviatura = "DES";

	echo " <em><strong><center>AGREGAR DESCRIPCION</center>"
	  . "  </strong></em>"
	  ."";
	 
	$consulta="SELECT ID_DESCRIPCION FROM descripcion ORDER BY ID_DESCRIPCION DESC";
	$idConsecutivo= new consecutivo("DES", $consulta);
	$Id_descripcion=$idConsecutivo->retornar();

	$consultades = "SELECT ID_DESCRIPCION_PROPIEDAD, DESCRIPCION_PROPIEDAD FROM descripcion_propiedad";

	$Rsdes=mysql_query($consultades);

	echo "<form name=\"formcaptdescripcion\" method=\"post\" action=\"\">"
	   	."<input name=\"ocultaficha\" type=\"hidden\" value=\"$valor_busqueda\">"	  
   		."<input name=\"funcion\" type=\"hidden\" value=\"1\">"	
		."";	
	
 	echo"<tr>";
    echo "<b><td><H4 align='center'>Descripcion:</b></td>"."<td>";	
	echo "<input name=\"cdescripcion\" type=\"text\" size=\"30\" maxlength=\"\" value=$Idvdescripcion>";

	echo"<tr>";
    echo "<b><td><H4 align='center'>DES:</b></td>"."<td>"; 	

	echo "<select name=\"seldes\">";
	echo "<option value=\"100\">-DES-</option>";
		while ($row=mysql_fetch_array($Rsdes)) {
			if ($row[0]==$Iddes) {
				echo "<option selected value=$row[0]>$row[1]</option>";	
			}
			else {
				echo "<option value=$row[0]>$row[1]</option>";
			}
		}
		echo "</select>";		
	echo "<br>¿SUMINISTRO?<select name=\"selSuministro\">";
		echo "<option value=\"0\" selected>NO</option>";
		echo "<option value=\"1\">SI</option>";
	echo "</select>";		
	
	echo "<br><center><input name=\"submit\" type=\"submit\" value=\"Almacenar\" ></center>";
  	echo "</form>";
 
mysql_close();
}	

function insertar()
 {
	$status='1';
	conectarMysql();
  	$consulta="SELECT ID_DESCRIPCION FROM descripcion ORDER BY ID_DESCRIPCION DESC";
  	$idConsecutivo= new consecutivo("DES", $consulta);
  	$id_descripcion=$idConsecutivo->retornar();
  	$descripcion=strtoupper($_POST[cdescripcion]);
	$valor = $id_descripcion;
echo "<form name=\"frmdescripcion\" method= \"post\" action =\"\">";   

 if(($descripcion!='')&& ($_POST[seldes]!=100))	
	{
		$sql = "INSERT INTO descripcion(ID_DESCRIPCION,DESCRIPCION,STATUS_ACTIVO,ID_DESCRIPCION_PROPIEDAD,SUMINISTRO) VALUES ('$id_descripcion','$descripcion','$status','$_POST[seldes]',$_POST[selSuministro])";

		$result = mysql_query($sql); 
		if(($result) AND ($_POST[cdescripcion]))
		{
        	echo "<br>";
       		echo "<center><strong>REGISTRO INSERTADO CORRECTAMENTE</strong></center>";
			echo "<p>&nbsp;</p>";
			echo "<center><strong><input name=\"btnotro\" type=\"submit\" value=\"Ingresar otro\"></strong></center>";
    	}
    	else
		{
     		echo "<br>";
    		echo "<center><strong>ERROR AL INSERTAR EN LA BD</strong></center>";
			echo "<p>&nbsp;</p>";
			echo "<center><strong><input name=\"btnatras\" type=\"submit\" value=\"Atras\">";
    	} 

	}	
	else
	{
   		echo "<br>";
   		echo "<center><strong>ERROR INTRODUZCA UNA DESCRIPCION</strong></center>";
		echo "<p>&nbsp;</p>";
		echo "<center><strong><input name=\"btnatra\" type=\"submit\" value=\"Atras\">";

	}
echo "</form>";

echo "<form name=\"vinculo\" method=\"post\" action=>";
echo "<center><strong><input name=\"btnmarca\" type=\"submit\" value=\"Asociar marca\"></strong></center>";			
echo "<input name = \"funcion\" type=\"hidden\" value=\"2\" >";
echo "<input name = \"descrip\" type=\"hidden\" value=\"$valor\" >";
echo "</form>";
mysql_close(); 
}

function asociamarca() {
	
	echo "<em><center><strong>AGREGAR MARCAS RELACIOADAS A:</strong></center></em>";

	conectarMysql();

	$des=$_POST[descrip];
	$condesc = "SELECT  descripcion_marca.ID_MARCA, marca.MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA = marca.ID_MARCA  WHERE descripcion_marca.ID_DESCRIPCION = '$_POST[descrip]'";
	$conmarca = "SELECT  ID_MARCA, MARCA FROM marca WHERE ID_MARCA NOT IN (SELECT  descripcion_marca.ID_MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA = marca.ID_MARCA  WHERE descripcion_marca.ID_DESCRIPCION = '$_POST[descrip]')";
	
	$condescripcion="SELECT DESCRIPCION FROM descripcion WHERE ID_DESCRIPCION = '$_POST[descrip]'";
	$result3 = mysql_query($condescripcion);
	if ($row=mysql_fetch_array($result3))
	{
		echo "<center><strong>$row[0]</strong></center>";
	}
	
	echo "<form name=\"frmMarca\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"3\">";
	echo "<input name=\"prueba\" type=\"hidden\" value=\"$des\">";

	$result1 = mysql_query($condesc);
	$result2 = mysql_query($conmarca);
	
	while($row=mysql_fetch_array($result1)) 
	{
		echo "<input name=\"campo2[]\" type=\"checkbox\" value=\"$row[0]\" checked>$row[1]<br>";
	}
	while($row=mysql_fetch_array($result2)) 
	{
		echo "<input name=\"campo[]\" type=\"checkbox\" value=\"$row[0]\">$row[1]<br>";
	}
	echo "<p align=center><input name=\"btn\" type=\"submit\" value=\"ACEPTAR\"></p>";
	echo "</form>";
}

function insertarmarca()
{
	if(!empty($_POST['campo'])) 
		{ 
    		$aLista=$_POST['campo'];
		}
	if(!empty($_POST['campo2'])) 
		{ 
    	 	$aLista2=$_POST['campo2'];
		}
	
	conectarMysql();
	
	echo "<form name=\"frmMarca\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"4\">";
	
	$sqldel = "DELETE FROM descripcion_marca WHERE ID_DESCRIPCION = '$_POST[prueba]'";
	$result=mysql_query($sqldel);
	if ($result)
	{echo $cont++;}
	
	$resulta = count($aLista2);
	for($i=0; $i<=$resulta; $i++)
	{
		$sql = "INSERT INTO descripcion_marca(ID_MARCA, ID_DESCRIPCION) VALUES ('$aLista2[$i]','$_POST[prueba]')";
		$resultado=mysql_query($sql);
	}
	
	$resulta = count($aLista);
	for($i=0; $i<=$resulta; $i++)
	{
		$sql = "INSERT INTO descripcion_marca(ID_MARCA, ID_DESCRIPCION) VALUES ('$aLista[$i]','$_POST[prueba]')";
		$resultad=mysql_query($sql);
		$comp++;
	}
	errormarca($comp);
	echo "<p align=center><input name=\"btn\" type=\"submit\" value=\"Atras\"></p>";
	echo "</form>";
}
function errormarca($valor)
{
	if($valor){
        echo "<br>";
       echo "<center><strong>SUS MARCAS FUERON VINCULADAS CORRECTAMENTE</strong></center>";
      }
      else{
        echo "<br>";
       echo "<center><strong>**ERROR** AL INTRODUCIR EN LA BD</strong></center>";
     } 

}
?>
