<?php
session_start();
$Acceso=array ("PRV0000001");
switch ($_SESSION['authUser']) {
	case '0':
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
		</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>SITIO RESTRINGIDO. NO PUEDE ENTRAR AL SISTEMA</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table>";
		exit();
		break 1;
	case '1':
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
		</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>SISTEMA DEL CENTRO DE ATENCI&Oacute;N A USUARIO. SISTRIO RESTRINGIDO</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table>";
		exit();
		break 1;
	default:
	require_once  "../librerias/usuarioSistemaAdmin.php";
	require_once "../librerias/conexionsql.php";
	$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
	$resultado= $acceso->validar();
	switch ($resultado) {
		case 1:
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>CLAVE INCORRECTA. NO PUEDE ENTRAR A LA P&Aacute;GINA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
			exit();
			break 1;
		case 2:
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
			exit();
			break 1;
		default:
			foreach($Acceso as $valor) {
				if ($_SESSION['authUser']!=$valor) {
					$sw=1;
				} else {
					$sw=0;
					break 1;
				}
			}
			if ($sw==1) {
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>DISCULPE,USTED NO TIENE SUFUCIENTE PRIVILEGIO PARA ENTRAR A ESTE SITIO</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				exit();
			}
	}
}
?>
<script language="javascript">
	function cambiarSeleccion() {
		//document.frmGarantia.funcion.value=0;
		document.frmGarantia.submit();
	}
	function cambiarGerencia() {
		document.frmGarantia.funcion.value=2;
		document.frmGarantia.submit();
	}
	function cambiarMarca() {
		document.frmGarantia.funcion.value=3;
		document.frmGarantia.submit();
	}			

</script>

<?php 
require_once "formularios.php";
require_once "conexionsql.php";	
switch(funcion) {
case 2:  
proveedor();
break 1;
default:
proveedor();
} 
function proveedor(){
$conProveedor="SELECT DISTINCT proveedor.ID_PROVEEDOR,proveedor.PROVEEDOR FROM proveedor INNER JOIN pedido ON proveedor.ID_PROVEEDOR=pedido.ID_PROVEEDOR INNER JOIN inventario ON pedido.ID_PEDIDO=inventario.ID_PEDIDO INNER JOIN equipo_garantia ON inventario.ID_INVENTARIO=equipo_garantia.ID_INVENTARIO";
//Campo Proveedor
$proveedor= new campoSeleccion("selProveedor","formularioCampoSeleccion","$_POST[selProveedor]","onchange","cambiarSeleccion()",$conProveedor,"--TODOS--","");
$selProveedor=$proveedor->retornar();
echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
echo "<form name=\"frmGarantia\" method=\"post\" action=\"\">";
//echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";			
echo "<tr>";
conectarMysql(); 
$result=mysql_query($conProveedor);
$row=mysql_fetch_array($result);
echo "<td class=\"tituloPagina\" colspan=\"2\">NOTIFICACIÓN DE EQUIPOS Y COMPONENTES</td></tr>";
echo "<tr>";
echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS</td></tr><tr><br>";
//Datos del Componente.	
echo "<td class=\"formularioTablaTitulo\">PROVEEDOR</td><td>$selProveedor </td></tr>";
$resultado="SELECT inventario.SERIAL,equipo_garantia.CONFIGURACION,descripcion.DESCRIPCION,marca.MARCA,modelo.MODELO,componente_garantia.FECHA_ASOCIACION FROM componente_garantia 
			INNER JOIN inventario ON componente_garantia.ID_INVENTARIO=inventario.ID_INVENTARIO 
			INNER JOIN equipo_garantia ON componente_garantia.CONFIGURACION=equipo_garantia.CONFIGURACION 
			INNER JOIN marca ON inventario.ID_MARCA=marca.ID_MARCA 
			INNER JOIN modelo ON inventario.ID_MODELO=modelo.ID_MODELO 
			INNER JOIN descripcion ON inventario.ID_DESCRIPCION=descripcion.ID_DESCRIPCION ";
$result=mysql_query($resultado);
if (isset($_POST[selProveedor]) && $_POST[selProveedor]!=100){  
  echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
			echo "<br><tr>
			<td class=\"formularioTablaTitulo\" colspan=\"5\">NOTIFICACION_GARANTIA - PROVEEDOR: $row[1]			
			</td>
			</tr>";	
			echo "<tr valign=top class=\"tablaTitulo\">
				<td align=\"left\" class=\"tablaTitulo\">SERIAL</td>
				<td align=\"left\" class=\"tablaTitulo\">CONFIGURACION</td>
				<td valign=top class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
				<td valign=top class=\"tablaTitulo\">MARCA</td>
				<td valign=top class=\"tablaTitulo\">MODELO</td>				
				<td valign=top class=\"tablaTitulo\">FECHA_NOTIFICACIÓN</td>				
				</tr>";
				if ($result) {
					while ($row=mysql_fetch_array($result)) {
					$fecha=substr($row[5],8,2).'-'.substr($row[5],5,2).'-'.substr($row[5],0,4);	  		  
						if ($i%2==0) {
							$clase="tablaFilaPar";
						} else {
							$clase="tablaFilaNone";
						}
						echo "<tr class=\"$clase\">						
						<td align=\"left\"><input name=\"optGarantia\" type=\"radio\" value=\"muestra\" checked>$row[0]</td>
						<td>$row[1]</td>
						<td>$row[2]</td>
						<td>$row[3]</td>
						<td>$row[4]</td>
						<td>$fecha</td>											
						</tr>";
						$i++;							
					}											
			    }	                
		      echo "</table>";
					                 
				    	 		  			  						
}	
	
}
?>