 <script language="javascript">
	function cambiarSeleccion() {
		document.frmBuscar.funcion.value=0;
		document.frmBuscar.submit();
	}
</script>

<?php
switch ($funcion) {
	
	case 1:
	frmBuscar(1,$pagina,$_POST[txtBuscar]);
	break 1;
	default:
	$txtBuscar=$_POST[txtBuscar];
	frmBuscar(1,$pagina,$_POST[txtBuscar]);
}

function frmBuscar($tipo=0,$pagina=0,$txtBuscar) {
$_POST[txtBuscar]=$txtBuscar;
echo $_POST[txtBuscar];
	//Buscar Componentes
	require_once "formularios.php";
	require_once "conexionsql.php";
	require_once "inventarioAdmin.php";
	$conDescripcion="SELECT ID_DESCRIPCION, DESCRIPCION FROM descripcion ORDER BY descripcion";
	$conMarca="SELECT descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA
	WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY marca";
	$conModelo="SELECT ID_MODELO, concat(MODELO,' ',cap_vel,' ',unidad) as MODELO FROM modelo WHERE ID_MARCA='$_POST[selMarca]' AND ID_DESCRIPCION='$_POST[selDescripcion]' ORDER BY modelo";
	$conSitio="SELECT ID_SITIO,SITIO FROM sitio ORDER BY SITIO";
	$conGerencia="SELECT ID_GERENCIA, GERENCIA FROM gerencia ORDER BY GERENCIA";

	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion200","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--TODOS--","");
	$selDescripcion=$descripcion->retornar();
		
	$marca= new campoSeleccion("selMarca","formularioCampoSeleccion200","$_POST[selMarca]","onchange","cambiarSeleccion()",$conMarca,"--TODOS--","");
	$selMarca=$marca->retornar();

	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion200","$_POST[selModelo]","onchange","cambiarSeleccion()",$conModelo,"--TODOS--","");
	$selModelo=$modelo->retornar();
	//Campo del Sitio
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion200","$_POST[selSitio]","","",$conSitio,"--TODOS--","");
	$selSitio=$sitio->retornar();
	//Campo de la Gerencia		
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion200","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--TODOS--","");
	$selGerencia=$gerencia->retornar();
echo "<form name=\"frmBuscar\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">INVENTARIO - BUSCAR</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"3\">DATOS DEL EQUIPO O COMPONENTE A BUSCAR</td>
		</tr>";
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">PALABRA CLAVE<BR><input class=\"formularioCampoTexto\" name=\"txtBuscar\" type=\"text\" value=$_POST[txtBuscar]></td>
		<td valign=top class=\"formularioCampoTitulo\">DESCRIPCION<BR>$selDescripcion</td>
		<td valign=top class=\"formularioCampoTitulo\">MARCA<BR>$selMarca</td>

		</tr>";
		echo "<tr>
		<td valign=top class=\"formularioCampoTitulo\">MODELO<BR>$selModelo</td>
		<td valign=top class=\"formularioCampoTitulo\">GERENCIA<BR>$selGerencia</td>
		<td valign=top class=\"formularioCampoTitulo\">EDIFICIO<BR>$selSitio</td>

		</tr>";
	 	echo "<tr>";
			echo "<td class=\"formularioTablaBotones\" colspan=\"3\">
				<input name=\"btnBuscar\" type=\"submit\" value=\"BUSCAR\">
				</td>
  				</tr>";	
		echo "</table>";

	echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
	echo "<tr>";
	echo "<td class=\"formularioTablaTitulo\" colspan=\"5\">RESULTADOS DE LA BUSQUEDA</td>
	</tr>";
	if ($tipo==1) {
		$busqueda= new inventario("",$_POST[txtBuscar],"",$_POST[selDescripcion],$_POST[selMarca],$_POST[selModelo],"","","","","","","",$_POST[selGerencia],$_POST[selSitio]);
		$resultado=$busqueda->buscarTodo($pagina);
		if ($resultado && $resultado!=1) {
			echo "<tr valign=top class=\"tablaTitulo\">
			<td align=\"left\" class=\"tablaTitulo\">SERIAL</td>
			<td valign=top class=\"tablaTitulo\">DESCRIPCION</td>
			<td valign=top class=\"tablaTitulo\">MARCA</td>
			<td valign=top class=\"tablaTitulo\">MODELO</td>
			<td valign=top class=\"tablaTitulo\">UBICACION</td>
			</tr>";
			while ($row=mysql_fetch_array($resultado)) {
				if ($i%2==0) {
					$clase="tablaFilaPar";
				} else {
					$clase="tablaFilaNone";
				}
				echo "<tr class=\"$clase\">
					<td align=\"left\">$row[9]</td>
					<td>$row[2]</td>
					<td>$row[4]</td>
					<td>$row[6]</td>
					<td align=\"left\">
					$row[13]</td>";
				echo "</tr>";
				$i++;
			}
			echo "</table>";
			if ($busqueda->retornarTotaPaginas()>1) {
				for ($i=1;$i<$busqueda->retornarTotaPaginas();$i++){
					if($pagina==$i)
						echo $pagina." ";
					else 
						echo "<a href='secciones.php?item=136&pagina=".$i."'> ".$i." </a>";
				}
			}
		}
	}

		

}
?>