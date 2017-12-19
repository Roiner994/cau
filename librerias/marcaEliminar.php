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

<?PHP
switch($_POST["funcionEliminar"]) {
case "1":
elimMarca($_POST["elimMarc"]);							
break 1;

case "0":
break 1;

default:
eliminarMarca();
break 1;
}
?>
<?PHP
function elimMarca($var){
$swich=0;
conectarMysql();
$var=(strtoupper($_POST["elimMarc"]));
if  (($_POST["funcionEliminar"])==1){
    $swich=1;
}
if  ($swich==1){
    $consulta= "UPDATE marca set STATUS_ACTIVO='0' where ID_MARCA= '$var'";  
    $result = mysql_query($consulta);    	
    mysql_close();
}	
}  
?>
<?PHP
function eliminarMarca(){
echo "<FORM name=\"eliminarMarca\" action=\"\" method=\"post\">";
arribaAlinear("left");
echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"0\">".
"<TD bgColor=\"#FFFFFF\">".
"<FONT face=\"Verdana\" size=\"1\">".
"<td class=\"Estilo71\" <b>MARCAS »</td> <td class=\"Estilo70\"><I>Eliminar</I></TD></b></td>".
"</FONT></TD></TABLE>";
abajoAlinear();
echo "<CENTER>";
echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\">";
echo "<TR vAlign=\"top\">";
echo "<TD bgColor=\"#ffffff\">";
echo "<FONT face=\"Verdana\" size=\"2\">";
echo "<b>Marcas:</b></FONT></TD>";
echo "<TD align=\"left\" bgColor=\"#ffffff\">";
echo "<FONT face=\"Verdana\" size=\"1\">";
//APUNTADOR A LA CLASE CAMPO DE SELECCION PARA MANIPULAR LA GERENCIA
$consulta= "SELECT ID_MARCA,MARCA from marca WHERE STATUS_ACTIVO = '1' ORDER BY ID_MARCA";
$marca=new campoSeleccion("elimMarc","","","","","",$consulta);
echo $marca->retornaSubmit($_POST["elimMarc"],""); 
echo "</FONT>";
echo "</TD></TR>";  
echo"</TABLE></CENTER>";
echo "<CENTER>";	
echo "<TABLE cellSpacing=\"0\" cellPadding=\"0\" border=\"1\">";	
echo "<TR vAlign=\"top\">";
echo "<TD bgcolor=\"#ECE9D8\">";
echo "<FONT face=\"Verdana\" size=\"2\">";
echo "<input type=\"hidden\" name=\"funcionEliminar\">";
echo "<INPUT type=\"button\" value=\"Eliminar »\" name=\"eliminar\" onClick=\"EliminarMarca()\">";
echo "</FONT></TD></TR>";	
echo "</TABLE></CENTER>";
echo "<CENTER>";
echo "</CENTER>"."</FORM>"."</body>"."</html>";
}
?>