<?php
//FORMULARIO INGRESAR DESCRIPCION
function formularioIngresarDescripcion() {
	require_once "formularios.php";
	require_once "conexionsql.php";
	
	$conDescripcion= "SELECT DESCRIPCION,ID_DESCRIPCION_PROPIEDAD,SUMINISTRO from descripcion WHERE ID_DESCRIPCION = '$_POST[selDescripcion]'";
	
	conectarMysql();
	$result= mysql_query($conDescripcion);
	$row=mysql_fetch_array($result);
	$_POST[txtDescripcion]=$row[0];
	$_POST[selTipo]=$row[1];
	$_POST[selSuministro]=$row[2];
	
	
	//CAMPO DESCRIPCION
	$conDescripcion= "SELECT ID_DESCRIPCION,DESCRIPCION from descripcion WHERE STATUS_ACTIVO = '1' ORDER BY DESCRIPCION ASC";
	$descripcion= new campoSeleccion("selDescripcion","formularioCampoTexto","$_POST[selDescripcion]","onChange","","$conDescripcion","--DESCRIPCION--","");
	$selDescripcion=$descripcion->retornar();
	
	//CAMPO MARCA
	$conMarca= "SELECT ID_MARCA,MARCA from marca WHERE STATUS_ACTIVO = '1' ORDER BY MARCA ASC";
	$marca= new campoSeleccion("selMarca","formularioCampoSeleccion","$_POST[selMarca]","onChange","",$conMarca,"--MARCA--","");
	$selMarca=$marca->retornar();
	
	//CAMPO MODELO
	$modelo= new campo("txtModelo","text","formularioCampoTexto","$_POST[txtModelo]","30","30","","");
	$txtModelo=$modelo->retornar();
	
	//CAMPO TIPO
	$tipo= new campo("txtTipo","text","formularioCampoTexto","$_POST[txtTipo]","30","30","","");
	$txtTipo=$tipo->retornar();
	
	//CAMPO UNIDAD
	$unidad= new campo("txtUnidad","text","formularioCampoTexto","$_POST[txtUnidad]","30","30","","");
	$txtUnidad=$unidad->retornar();
	
	echo "<form name=\"frmModelo\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
	echo "<input name=\"selModelo\" type=\"hidden\" value=\"$_POST[selModelo]\">";
	

	echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - MODIFICAR MODELO</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">MODIFICAR MODELO</td>
  				</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">DESCRIPCION<br>
			$selDescripcion<br>
			MARCA<br>$selMarca<br>
			MODELO<br>$txtModelo<br>
			TIPO<br>$txtTipo<br>
			UNIDAD<br>$txtUnidad<br></td>
		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='secciones.php?item=21'\"><input name=\"Limpiar\" type=\"submit\" value=\"GUARDAR\"></td>
  				</tr>";
	echo "</table>";
	echo "</form>";	
}
?>