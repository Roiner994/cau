<script>

  function cambiaropcion(){ 
    var i 
    for (i=0;i<document.forminicio.opc.length;i++){ 
       if (document.forminicio.opc[i].checked) 
          break; 
    } 

    document.forminicio.vista.value = document.forminicio.opc[i].value ;
    document.forminicio.submit();

 
    for (i=0;i<document.forminicio.opc1.length;i++){ 
       if (document.forminicio.opc1[i].checked) 
          break; 
    } 

    document.forminicio.vista1.value = document.forminicio.opc1[i].value ;
    document.forminicio.submit();

} 

 

</script>
<?php
include "../librerias/administracion.php";
include "../librerias/conexionsql.php";
include "../librerias/fechas.php";
include "../librerias/formularios.php";

switch($_POST[funcion])
{	
	case '1':
		opcion();
	break 1;

	case '2':
		mostrar();
	break 1;
	default:
		frminicial();
	break 1;
}

function frminicial()
{
	echo "<form name=\"forminicio\" method=\"post\" action=\"\">";
   	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
   	echo "<input name=\"vista\" type=\"hidden\" value=\"\">";
   	echo "<input name=\"vista1\" type=\"hidden\" value=\"\">";

	echo "<input name=\"opc\" type=\"radio\" value=\"1\" checked>Edificio<br>";
	echo "<input name=\"opc\" type=\"radio\" value=\"0\" >Gerencia<br>";
	echo "<input name=\"opc1\" type=\"radio\" value=\"1\" checked>No Ejecutadas<br>";
	echo "<input name=\"opc1\" type=\"radio\" value=\"0\" >Ejecutadas<br>";

	echo "<center><input name=\"op\" type=\"button\" value=\"Buscar\" onClick=\"cambiaropcion()\" ></center>";
	echo "</form>";
}

function opcion()	
{
	conectarMysql();

echo "<form name=\"frmrepo\" method= \"post\" action = \"\">";
//echo "VISTA:$_POST[vista]";

if ($_POST[vista])
{
	$consul = "SELECT ID_SITIO, SITIO FROM sitio";	
	$res = mysql_query($consul);
	
	echo "<center><strong>REPORTES POR EDIFICIO</strong>";
	echo "<p>&nbsp;<p>";
	echo "<strong>EDIFICIO:</strong>&nbsp;<select name=\"seledif\" >";
	echo "<option value=\"100\">-TODO-</option></center>";
		while ($row=mysql_fetch_array($res)) {
			if ($row[0]==$Idso) {
				echo "<option selected value=$row[0]>$row[1]</option>";	
				
			}
			else {
				echo "<option value=$row[0]>$row[1]</option>";

			}

		}
	echo "</select>";	
}
else
{
	$consu2 = "SELECT ID_GERENCIA, GERENCIA FROM gerencia";
	$res2 = mysql_query($consu2);

	echo "<strong><center>REPORTES POR GERENCIA</strong>";
	echo "<p>&nbsp;<p>";
	echo "<strong>GERENCIA:</strong>&nbsp;<select name=\"selger\" >";
	echo "<option value=\"100\">-TODO-</option></center>";
		while ($row=mysql_fetch_array($res2)) {
			if ($row[0]==$Idso) {
				echo "<option selected value=$row[0]>$row[1]</option>";	
			}
			else {
				echo "<option value=$row[0]>$row[1]</option>";
			}
		}
	echo "</select>";	

}	
echo "<p>&nbsp;<p>";
echo "<center><strong>Fecha Inicial:</strong><input name=\"fechai\" type=\"text\" value=\"\">";  
echo "<strong>Fecha Final:</strong><input name=\"fechaf\" type=\"text\" value=\"\"></center><br>";	

   	echo "<input name=\"opcionejnoej\" type=\"hidden\" value=\"$_POST[vista1]\">";
   	echo "<input name=\"vist\" type=\"hidden\" value=\"$_POST[vista]\">";
   	echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
	echo "<center><input name=\"bus\" type=\"submit\" value=\"Aceptar\" ></center>";

	echo "</form>";	
		
mysql_close();
}
		
function mostrar()
{
	//echo "fechai: $_POST[fechai]<br>";
	//echo "fechaf: $_POST[fechaf]<br>";
	//echo "VISTA:$_POST[vist]";
	if ($_POST[opcionejnoej])
	{$ejecu='NO EJECUTAD0S';}
	else {$ejecu='EJECUTAD0S';}
	conectarMysql();
	
	$consu2 = "SELECT ID_GERENCIA, GERENCIA FROM gerencia WHERE ID_GERENCIA = '$_POST[selger]'";
	$res2 = mysql_query($consu2);
	$row=mysql_fetch_array($res2);
	$gerencias=$row[1];
	
	$consu1 = "SELECT ID_SITIO, SITIO FROM sitio WHERE ID_SITIO = '$_POST[seledif]'";
	$res1 = mysql_query($consu1);
	$row=mysql_fetch_array($res1);
	$edificios=$row[1];

	if ($_POST[vist])
	{
		if ($_POST[fechai] and $_POST[fechaf])
		{
			if ($_POST[seledif]== 100)
			{
				$opcion=1;
				$consultaubp = "SELECT mantenimiento_preventivo.ID_MANTENIMIENTO_PREVENTIVO, mantenimiento_preventivo.CONFIGURACION, marca.MARCA, modelo.MODELO FROM mantenimiento_preventivo INNER JOIN equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
				INNER JOIN inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
				INNER JOIN inventario_ubicacion ON inventario.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO	
				INNER JOIN marca ON inventario.ID_MARCA = marca.ID_MARCA	
				INNER JOIN modelo ON inventario.ID_MODELO = modelo.ID_MODELO	
				INNER JOIN ubicacion ON inventario_ubicacion.ID_UBICACION = ubicacion.ID_UBICACION WHERE mantenimiento_preventivo.STATUS_MTTO = '$_POST[opcionejnoej]' AND mantenimiento_preventivo.FECHA_MANTENIMIENTO_INICIO >= '$_POST[fechai]' AND mantenimiento_preventivo.FECHA_MANTENIMIENTO_INICIO <= '$_POST[fechaf]'ORDER BY ID_MANTENIMIENTO_PREVENTIVO";
			}
			else
			{
				$opcion=2;
				$consultaubp = "SELECT mantenimiento_preventivo.ID_MANTENIMIENTO_PREVENTIVO, mantenimiento_preventivo.CONFIGURACION, marca.MARCA, modelo.MODELO FROM mantenimiento_preventivo INNER JOIN equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
				INNER JOIN inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
				INNER JOIN inventario_ubicacion ON inventario.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO	
				INNER JOIN marca ON inventario.ID_MARCA = marca.ID_MARCA	
				INNER JOIN modelo ON inventario.ID_MODELO = modelo.ID_MODELO	
				INNER JOIN ubicacion ON inventario_ubicacion.ID_UBICACION = ubicacion.ID_UBICACION WHERE ubicacion.ID_SITIO = '$_POST[seledif]' AND mantenimiento_preventivo.STATUS_MTTO = '$_POST[opcionejnoej]' AND mantenimiento_preventivo.FECHA_MANTENIMIENTO_INICIO >= '$_POST[fechai]' AND mantenimiento_preventivo.FECHA_MANTENIMIENTO_INICIO <= '$_POST[fechaf]' ORDER BY ID_MANTENIMIENTO_PREVENTIVO";
			}
		}
		else	
		{
			if ($_POST[seledif]== 100)
			{
				$opcion=3;
				$consultaubp = "SELECT mantenimiento_preventivo.ID_MANTENIMIENTO_PREVENTIVO, mantenimiento_preventivo.CONFIGURACION, marca.MARCA, modelo.MODELO FROM mantenimiento_preventivo INNER JOIN equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
				INNER JOIN inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
				INNER JOIN inventario_ubicacion ON inventario.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO	
				INNER JOIN marca ON inventario.ID_MARCA = marca.ID_MARCA	
				INNER JOIN modelo ON inventario.ID_MODELO = modelo.ID_MODELO	
				INNER JOIN ubicacion ON inventario_ubicacion.ID_UBICACION = ubicacion.ID_UBICACION WHERE mantenimiento_preventivo.STATUS_MTTO = '$_POST[opcionejnoej]' AND inventario_ubicacion.STATUS_ACTUAL = '1' ORDER BY ID_MANTENIMIENTO_PREVENTIVO";
			}
			else
			{
				$opcion=4;
				$consultaubp = "SELECT mantenimiento_preventivo.ID_MANTENIMIENTO_PREVENTIVO, mantenimiento_preventivo.CONFIGURACION, marca.MARCA, modelo.MODELO FROM mantenimiento_preventivo INNER JOIN equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
				INNER JOIN inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
				INNER JOIN inventario_ubicacion ON inventario.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO	
				INNER JOIN marca ON inventario.ID_MARCA = marca.ID_MARCA	
				INNER JOIN modelo ON inventario.ID_MODELO = modelo.ID_MODELO	
				INNER JOIN ubicacion ON inventario_ubicacion.ID_UBICACION = ubicacion.ID_UBICACION WHERE ubicacion.ID_SITIO = '$_POST[seledif]' AND mantenimiento_preventivo.STATUS_MTTO = '$_POST[opcionejnoej]' ORDER BY ID_MANTENIMIENTO_PREVENTIVO";
			}
		
		
		
		}
	}
	else
	{
		if ($_POST[fechai] and $_POST[fechaf])
		{	
			if ($_POST[selger]== 100)
			{
				$opcion=5;
				$consultaubp = "SELECT mantenimiento_preventivo.ID_MANTENIMIENTO_PREVENTIVO, mantenimiento_preventivo.CONFIGURACION, marca.MARCA, modelo.MODELO FROM mantenimiento_preventivo INNER JOIN equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
				INNER JOIN inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
				INNER JOIN inventario_ubicacion ON inventario.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO	
				INNER JOIN marca ON inventario.ID_MARCA = marca.ID_MARCA	
				INNER JOIN modelo ON inventario.ID_MODELO = modelo.ID_MODELO	
				INNER JOIN ubicacion ON inventario_ubicacion.ID_UBICACION = ubicacion.ID_UBICACION WHERE mantenimiento_preventivo.STATUS_MTTO = '$_POST[opcionejnoej]' AND mantenimiento_preventivo.FECHA_MANTENIMIENTO_INICIO >= '$_POST[fechai]' AND mantenimiento_preventivo.FECHA_MANTENIMIENTO_INICIO <= '$_POST[fechaf]' ORDER BY ID_MANTENIMIENTO_PREVENTIVO";
			}
			else
			{
				$opcion=6;
				$consultaubp = "SELECT mantenimiento_preventivo.ID_MANTENIMIENTO_PREVENTIVO, mantenimiento_preventivo.CONFIGURACION, marca.MARCA, modelo.MODELO FROM mantenimiento_preventivo INNER JOIN equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
				INNER JOIN inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
				INNER JOIN inventario_ubicacion ON inventario.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO	
				INNER JOIN marca ON inventario.ID_MARCA = marca.ID_MARCA	
				INNER JOIN modelo ON inventario.ID_MODELO = modelo.ID_MODELO	
				INNER JOIN ubicacion ON inventario_ubicacion.ID_UBICACION = ubicacion.ID_UBICACION WHERE ubicacion.ID_GERENCIA = '$_POST[selger]' AND mantenimiento_preventivo.STATUS_MTTO = '$_POST[opcionejnoej]' AND mantenimiento_preventivo.FECHA_MANTENIMIENTO_INICIO >= '$_POST[fechai]' AND mantenimiento_preventivo.FECHA_MANTENIMIENTO_INICIO <= '$_POST[fechaf]' ORDER BY ID_MANTENIMIENTO_PREVENTIVO";
			}
		}
		else
		{
			if ($_POST[selger]== 100)
			{
				$opcion=7;
				$consultaubp = "SELECT mantenimiento_preventivo.ID_MANTENIMIENTO_PREVENTIVO, mantenimiento_preventivo.CONFIGURACION, marca.MARCA, modelo.MODELO FROM mantenimiento_preventivo INNER JOIN equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
				INNER JOIN inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
				INNER JOIN inventario_ubicacion ON inventario.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO	
				INNER JOIN marca ON inventario.ID_MARCA = marca.ID_MARCA	
				INNER JOIN modelo ON inventario.ID_MODELO = modelo.ID_MODELO	
				INNER JOIN ubicacion ON inventario_ubicacion.ID_UBICACION = ubicacion.ID_UBICACION WHERE mantenimiento_preventivo.STATUS_MTTO = '$_POST[opcionejnoej]' AND inventario_ubicacion.STATUS_ACTUAL = '1'ORDER BY ID_MANTENIMIENTO_PREVENTIVO";
			}
			else
			{
				$opcion=8;
				$consultaubp = "SELECT mantenimiento_preventivo.ID_MANTENIMIENTO_PREVENTIVO, mantenimiento_preventivo.CONFIGURACION, marca.MARCA, modelo.MODELO FROM mantenimiento_preventivo INNER JOIN equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
				INNER JOIN inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
				INNER JOIN inventario_ubicacion ON inventario.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO	
				INNER JOIN marca ON inventario.ID_MARCA = marca.ID_MARCA	
				INNER JOIN modelo ON inventario.ID_MODELO = modelo.ID_MODELO	
				INNER JOIN ubicacion ON inventario_ubicacion.ID_UBICACION = ubicacion.ID_UBICACION WHERE ubicacion.ID_GERENCIA = '$_POST[selger]' AND mantenimiento_preventivo.STATUS_MTTO = '$_POST[opcionejnoej]' ORDER BY ID_MANTENIMIENTO_PREVENTIVO";
			}
		
		}	
	}
	$Rsubp=mysql_query($consultaubp);
	
	switch($opcion)
	{
		case '1':
			echo "<strong><center>REPORTE DE MANTENIMIENTO PREVENTIVO $ejecu ENTRE $_POST[fechai] Y $_POST[fechaf] GENERAL DE EDIFICIOS </center></strong>";
		break 1;
		case '2':
			echo "<strong><center>REPORTE DE MANTENIMIENTO PREVENTIVO $ejecu ENTRE $_POST[fechai] Y $_POST[fechaf] DEL EDIFICIO: $edificios</center></strong>";
		break 1;
		case '3':
			echo "<strong><center>REPORTE DE MANTENIMIENTO PREVENTIVO $ejecu GENERAL DE EDIFICIOS</center></strong>";
		break 1;
		case '4':
			echo "<strong><center>REPORTE DE MANTENIMIENTO PREVENTIVO $ejecu DEL EDIFICIO: $edificios </center></strong>";
		break 1;
		case '5':
			echo "<strong><center>REPORTE DE MANTENIMIENTO PREVENTIVO $ejecu ENTRE $_POST[fechai] Y $_POST[fechaf] GENERAL DE GERENCIAS</center></strong>";
		break 1;
		case '6':
			echo "<strong><center>REPORTE DE MANTENIMIENTO PREVENTIVO $ejecu ENTRE $_POST[fechai] Y $_POST[fechaf] DE LA GERENCIA: $gerencias</center></strong>";
		break 1;
		case '7':
			echo "<strong><center>REPORTE DE MANTENIMIENTO PREVENTIVO $ejecu GENERAL DE GERENCIAS </center></strong>";
		break 1;
		case '8':
			echo "<strong><center>REPORTE DE MANTENIMIENTO PREVENTIVO $ejecu DE LA GERENCIA: $gerencias</center></strong>";
		break 1;
		default:
		echo "lo perdimos";
		break 1;

	}
	
	 echo "<style type= \"text/css\">";
 echo ".Estilo1 {font-size: 12px}";
 echo "</style>";
 
  echo "<table width=\"690\" border=\"4\" >";
  echo "  <tr bordercolor=\"#CCCCCC\" bgcolor=\"#CCCCCC\">";
  echo "    <th width=\"250\" scope=\"col\"><span class=\"Estilo1\">Mantenimiento Preventivo</span></th>";
  echo "    <th width=\"120\" scope=\"col\"><span class=\"Estilo1\">Configuración</span></th>";
  echo "    <th width=\"200\" scope=\"col\"><span class=\"Estilo1\">Marca</span></th>";
  echo "    <th width=\"120\" scope=\"col\"><span class=\"Estilo1\">Modelo</span></th>";
  
  echo "  </tr>";
  echo "</table>";

	while ($row=mysql_fetch_array($Rsubp)) 
	{
	  echo "<table width=\"690\" border=\"2\" >";
	  echo "  <tr bordercolor=\"#CCCCCC\" >";
	  echo "    <th width=\"250\" scope=\"col\"><span class=\"Estilo1\">$row[0]</span></th>";
	  echo "    <th width=\"120\" scope=\"col\"><span class=\"Estilo1\">$row[1]</span></th>";
	  echo "    <th width=\"200\" scope=\"col\"><span class=\"Estilo1\">$row[2]</span></th>";
	  echo "    <th width=\"120\" scope=\"col\"><span class=\"Estilo1\">$row[3]</span></th>";
	
	  
	  echo "  </tr>";
	  echo "</table>";
		
	}
mysql_close();
}

?>