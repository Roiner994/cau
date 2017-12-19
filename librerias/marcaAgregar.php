<style type="text/css">
.Estilo70 {color: #FF0000; 	font-size:11px; font-family: Arial, Helvetica, sans-serif;}
.Estilo71 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #000000;
	}	
</style>
<?PHP
include "alineacion.php";
include "conexionsql.php";
include "formularios2.php";
include "administracion.php";
?>
<?PHP
echo "<html>"."<head>";
?>
<?PHP
include "libreriaScript2.php";
?>
<?PHP
echo "</head>"."<body>"; 
?>
<?php
switch($_POST["funcionAgregar"]) {
case "1":
procesarMarca($_POST["marc1"]);								
break 1;

case "0":
break 1;

default:
agregarMarca();
}
?>				
<?PHP
function procesarMarca($var){
conectarMysql();
$var=(strtoupper($_POST["marc1"]));
if ($_POST["marc1"]!=""){
$sql="SELECT MARCA,STATUS_ACTIVO from marca where MARCA='$var' ORDER BY MARCA DESC";
$result = mysql_query($sql);
$row=mysql_fetch_array($result);
}
if ($row["STATUS_ACTIVO"]=='1'){
arribaAlinear("center");
echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"0\">";
echo "<TR vAlign=\"top\">";
echo "<TD align=\"center\" bgColor=\"#FFFFFF\">"; 
echo "<FONT face=\"Verdana\" size=\"2\">";
echo "<B>Error Marca Existente en la Base de Dato</B>"."<br>";     
echo "</table>";
echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\">";
echo "<TR vAlign=\"top\">";
echo "<TD align=\"center\" bgColor=\"#FFFFFF\">"; 
echo "<FONT face=\"Verdana\" size=\"2\">";
echo "<INPUT type=\"reset\" value=\"Continuar\" onClick=\" history.go(-1)\">";			 
echo "</table>";
abajoAlinear();
}	
else{   
       if ($row["STATUS_ACTIVO"]!='1'){
  	      $consulta= "select ID_MARCA from marca ORDER BY ID_MARCA DESC";  
          $idConse= new consecutivo("MAR", $consulta);
          $idMarc=$idConse->retornar();  
		  if (($row["MARCA"]==$var) && ($row["STATUS_ACTIVO"]=='0')){		  
		     $consulta1= "UPDATE marca set STATUS_ACTIVO='1' where MARCA= '$var'";  
             $result = mysql_query($consulta1);				 			
		  }	 
		  else{
          $sql = "INSERT INTO marca(ID_MARCA,MARCA,STATUS_ACTIVO)".
  	             "VALUES ('$idMarc','$var','1')";
          $result = mysql_query($sql); 		 
		  }
       }       
       mysql_close();	
}
}  
?>
<?PHP //AGREGAR UNA GERENCIA
function agregarMarca(){
echo "<FORM name=\"agregarMarca\" action=\"\" method=\"post\">"."<CENTER>";
arribaAlinear("left");
echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"0\">".
"<TD bgColor=\"#FFFFFF\">".
"<FONT face=\"Verdana\" size=\"1\">".
"<td class=\"Estilo71\" <b>MARCAS »</td> <td class=\"Estilo70\"><I>Agregar</I></TD></b></td>".
"</FONT></TD></TABLE>";
abajoAlinear();
echo "<CENTER>";
echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\">";
echo "<TR vAlign=\"top\">";
echo "<TD bgColor=\"#FFFFFF\">";
echo "<FONT face=\"Verdana\" size=\"2\">";
echo "<b>Marcas:</b></FONT></TD>";
echo "<TD align=\"left\" bgColor=\"#FFFFFF\">";
echo "<FONT face=\"Verdana\" size=\"2\">";
echo "<INPUT maxLength=\"50\" size=\"50\" name=\"marc\" value=\"\" onBlur=\"captTextMarc()\" onkeypress=\"return Letras(event)\">";
echo "</FONT></TD></TR></TABLE></CENTER>";
echo "<CENTER>";
echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"2\">";
echo "<TR vAlign=\"top\">";
echo "<TD bgcolor=\"#ECE9D8\">";
echo "<FONT face=\"Verdana\" size=\"2\">";
echo "<INPUT type=\"button\" value=\"Ingresar »\" name=\"ingresar\"  onClick=\"comprobarMarca(document.agregarMarca.marc.value)\">";
echo "</FONT></TD></TR>";
echo "</TABLE></CENTER>";
echo "<CENTER>";
echo "<INPUT name=\"marc1\" type=\"hidden\" value=\"$_POST[marc]\">";
echo "<INPUT type=\"hidden\" name=\"funcionAgregar\">"; 
echo "</FORM>";  
}
?>
<?PHP
echo "</body>"; 
echo "</html>"; 
?>