<?php
session_start();
?>
<script> 
function insertarppt() {
            document.frmpuntopendiente.funcion.value=11;
            document.frmpuntopendiente.submit();
}

function atrasppt() {
            document.frmpuntopendiente.funcion.value=2;
            document.frmpuntopendiente.submit();
}

function imprime() {
            document.frmcaptura.funcion.value=8;
            document.frmcaptura.submit();
}

function reserva() {
            document.frmcaptura.funcion.value=7;
            document.frmcaptura.submit();
}
           
function actualizar() {
            document.captmtto.funcion.value=3;
            document.captmtto.submit();
}
function insertar() {
            document.captmtto.funcion.value=5;
            document.captmtto.submit();
}
function atras() {
            document.captmtt.funcion.value=2;
            document.captmtt.submit();
}
function cambiarSeleccion() {
	document.frmUsuario.funcion.value=50;
	document.frmUsuario.submit();
}
	function numero(){ 
		var key=window.event.keyCode; 
 		if (key < 48 || key > 57){  
    		window.event.keyCode=0; 
 		}

} 

</script>

<?php
include "../librerias/administracion.php";
include "../librerias/conexionsql.php";
include "../librerias/fechas.php";
include "../librerias/formularios.php";

if (isset($ficha) && !empty($ficha) && $_POST[funcion] != 2)
{
	if ($_POST[funcion]!=5 &&  $cont==0)
	{
		$_POST[funcion]=3;
	}
}	

	if ($cont==1 && $_POST[funcion]!=6 && $_POST[funcion]!=7 )
	{
		if ($_POST[funcion]!=2)
		{
				$_POST[funcion]=4;
				$cont=0;
		}
	}

if ($opcion==1 && $_POST[funcion]!=11) 
{
	if ($_POST[funcion]!=2) 
		{
			$_POST[funcion]=10;
		}
}

	switch($_POST[funcion])
	{	
		case '1':
			introconfiguracion();
		break 1;
		case '2':
			mostrar();
		break 1;
		case '3':
			continuamtto($ficha,$configuracion,$_SESSION[usu1]);
		break 1;
		case '4':
		conectarMysql();
		if ($_POST[aux]==0)
		{
			$sitio = "SELECT ID_SITIO,ID_GERENCIA,ID_DIVISION,ID_DEPARTAMENTO FROM ubicacion WHERE ID_UBICACION = '$ubica'";
			$ressitio = mysql_query($sitio);
			$row=mysql_fetch_array($ressitio);
			//echo "SITIO: $row[0]";
			$_POST[selSitio] = $row[0];
			$_POST[selGerencia] = $row[1];
			$_POST[selDivision] = $row[2];
			$_POST[selDepartamento] = $row[3];
			mysql_close();
			formularioModificar($ubica,$invent,$configuracion,$_SESSION[usu1]);
		}
		else
		{
		formularioModificar($ubica,$invent,$configuracion,$_SESSION[usu1]);
		}
		break 1;
		case '5';
			intromodusuario();
		break 1;
		case '6';
			intromodubicacion();
		break 1;
		case '7';
			cerrarmtto();
		break 1;
		case '8';
			imprimir();
		break 1;
		case '9';
			mensajeerrorseleccion();
		break 1;
		case '10':
			puntopendiente($configuracion,$ubica,$invent);
		break 1;
		case '11':
			insertarpuntopendiente($configuracion);
		break 1;

		default:
		
		frminicial();
		break 1;
	}
function frminicial()	/*****************************************************/
{
echo "<form name=\"formcaptsitio\" method=\"post\" action=\"\">";

echo "<table class=\"formularioTabla\"align=center width=\"200\" border=\"0\">";
	echo "<tr>";
	echo "<center><td class=\"tituloPagina\" aling=center colspan=\"2\">MANTENIMIENTO PREVENTIVO - NUEVO</td>
  		</tr>";


 	echo"<tr>";
    echo "<b><td><H4 align='center'>Configuracion: </b></td>"."<td>";	
	echo "<input name=\"conf\" type=\"text\" size=\"30\" maxlength=\"\">";
	require_once "usuarioSistemaAdmin.php";
	$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
	$id_usu=$acceso->login();

	echo"</tr>";
	echo "</table>";
   	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
   	echo "<input name=\"id_usuario\" type=\"hidden\" value=\"$id_usu\">";
	echo "<center><input name=\"submit\" type=\"submit\" value=\"Buscar\" ></center>";

  	echo "</form>";
}	

function introconfiguracion()	/**********************************************/
{
conectarMysql();
//echo "USUARIO: $_POST[id_usuario]";
$_SESSION[usu1] = $_POST[id_usuario];

$valor = $_POST[conf];
$usuario = $_POST[id_usuario];

$sol = "SELECT ID_INVENTARIO FROM equipo_campo WHERE CONFIGURACION = '$valor'";
$sola = mysql_query($sol);

if($row=mysql_fetch_array($sola))
{$id_inv = $row[0]; }
//else
//{echo "ERROR AL ACCESAR LA BASE DE DATOS ";}

$confex = "SELECT * FROM equipo_campo WHERE CONFIGURACION = '$valor'";
$varia = mysql_query($confex);

if ($row=mysql_fetch_array($varia))
{

	//echo " <em><strong><center>MANTENIMIENTO PREVENTIV</center>"
	 // . "  </strong></em>"
	 // ."";
	
	$fecha=gmdate("Y-m-d"); 
	//echo "<strong>FECHA ACTUAL:</strong> $fecha<br>";
	
	$consulta = "SELECT ID_MANTENIMIENTO_PREVENTIVO FROM mantenimiento_preventivo WHERE mantenimiento_preventivo.CONFIGURACION = '$valor' ORDER BY ID_MANTENIMIENTO_PREVENTIVO DESC";
	$cons = mysql_query($consulta);
	
	if ($row=mysql_fetch_array($cons))
		{
			$con1="SELECT ID_MANTENIMIENTO_PREVENTIVO, FECHA_MANTENIMIENTO_FIN FROM mantenimiento_preventivo WHERE CONFIGURACION = '$valor' AND STATUS_MTTO = '1' ORDER BY ID_MANTENIMIENTO_PREVENTIVO ASC";
			$aux = mysql_query($con1);
			
			if ($row=mysql_fetch_array($aux))
			{
				
				$cosas="SELECT ID_MANTENIMIENTO_PREVENTIVO FROM mantenimiento_preventivo WHERE CONFIGURACION = '$valor' AND ID_USS = '$usuario' AND STATUS_MTTO = '1' ORDER BY ID_MANTENIMIENTO_PREVENTIVO DESC";
				$valores = mysql_query($cosas);
				if	($row=mysql_fetch_array($valores))
				{
					echo "<form name=\"frmacceso\" method= \"post\" action = \"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value = \"2\">";
					echo "<input name=\"conf\" type=\"hidden\" value = \"$valor\">";
					echo "<input name=\"mtto\" type=\"hidden\" value = \"$id_mtto\">";
					echo "<input name=\"usu\" type=\"hidden\" value = \"$usuario\">";	
					echo "<input name=\"band\" type=\"hidden\" value = \"0\">";							
							
					echo "<input name=\"inventario\" type=\"hidden\" value = \"$id_inv\">";			
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>ESTE EQUIPO TIENE UN MTTO PREVENTIVO PENDIENTE</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";
				}
				else
				{
					echo "<form name=\"frmacceso1\" method= \"post\" action = \"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value = \"\">";					
					//echo "ESTE MTTO ESTA EN PROCESO Y USTED NO PUEDE ACCESARLO";
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>ESTE MTTO ESTA EN PROCESO Y USTED NO PUEDE ACCESARLO</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";
					
				}			
			}
			else
			{
				$control="SELECT ID_MANTENIMIENTO_PREVENTIVO, FECHA_MANTENIMIENTO_FIN FROM mantenimiento_preventivo WHERE CONFIGURACION = '$valor' AND STATUS_MTTO = '0' ORDER BY ID_MANTENIMIENTO_PREVENTIVO DESC";
				$auxiliar = mysql_query($control);
				
				if ($row=mysql_fetch_array($auxiliar))
				{
					$id_mtto = $row[0];
					$i = 'd';
					$resultado = datediff($i,$fecha,$row[1]);
		
					$controles="SELECT ID_MANTENIMIENTO_PREVENTIVO, FECHA_MANTENIMIENTO_FIN FROM mantenimiento_preventivo WHERE STATUS_MTTO = '1' AND ID_USS = '$usuario' ORDER BY ID_MANTENIMIENTO_PREVENTIVO DESC";
					$auxi = mysql_query($controles);
					if	($row=mysql_fetch_array($auxi))
					{
						echo "<form name=\"frmacceso2\" method= \"post\" action = \"\">";
						echo "<input name=\"funcion\" type=\"hidden\" value = \"\">";					
						echo "<br><br><br><br>";
						echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
						echo "<tr>";
						echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
						</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center>USTED TIENE UN MANTENIMIETO PREVENTIVO PENDIENTE</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";

					}
					else 
					{
						if  ($resultado > 90)
						{
							echo "<form name=\"frmacceso\" method= \"post\" action = \"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value = \"2\">";
							echo "<input name=\"band\" type=\"hidden\" value = \"1\">";							
							echo "<input name=\"conf\" type=\"hidden\" value = \"$valor\">";
							echo "<input name=\"mtto\" type=\"hidden\" value = \"$id_mtto\">";
							echo "<input name=\"usu\" type=\"hidden\" value = \"$usuario\">";		
							echo "<input name=\"inventario\" type=\"hidden\" value = \"$id_inv\">";			
							echo "<strong>FECHA DE ULTIMO MANTENIMIENTO: </strong>$row[2]<br>";
				
			
							echo "ESTA MAQUINA TIENE <strong>$resultado</strong> DIAS DE HABERSELE HECHO EL ULTIMO MANTENIMIENTO<br>";
							echo "EJECUTE MANTENIMIENTO.<br>";			
							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>EJECUTE MTTO PREVENTIVO. MTTO ANTERIOR <strong>$resultado</strong> DIAS</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";
						}
						else
						{
							echo "<form name=\"frmacceso3\" method= \"post\" action = \"\">";
							echo "<input name=\"funcion\" type=\"hidden\" value = \"\">";					
 							echo "<br><br><br><br>";
							echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
							echo "<tr>";
							echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
							</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center>LA FECHA NO PERMITE REALIZAR EL MTTO PREVENTIVO</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";

							
						}
					}	
				}		
			}
		}	
	else
		{
	
			$contr="SELECT ID_MANTENIMIENTO_PREVENTIVO, FECHA_MANTENIMIENTO_FIN FROM mantenimiento_preventivo WHERE STATUS_MTTO = '1' AND ID_USS = '$usuario' ORDER BY ID_MANTENIMIENTO_PREVENTIVO DESC";
			$auxil = mysql_query($contr);
			if	($row=mysql_fetch_array($auxil))
			{
					echo "<form name=\"frmacceso4\" method= \"post\" action = \"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value = \"\">";					
					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>USTED TIENE UN MANTENIMIETO PREVENTIVO PENDIENTE</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";
			}
			else 
			{
				echo "<form name=\"frmacceso\" method= \"post\" action = \"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value = \"2\">";
				echo "<input name=\"conf\" type=\"hidden\" value = \"$valor\">";
				echo "<input name=\"band\" type=\"hidden\" value = \"1\">";
				echo "<input name=\"mtto\" type=\"hidden\" value = \"$id_mtto\">";
				echo "<input name=\"usu\" type=\"hidden\" value = \"$usuario\">";			
				echo "<input name=\"inventario\" type=\"hidden\" value = \"$id_inv\">";			
				
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>ESTE EQUIPO NO TIENE NINGUN MTTO PREVENTIVO </td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
			}
		}	
}
else
{
	echo "<form name=\"frmacceso5\" method= \"post\" action = \"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value = \"\">";					
	
	echo "<br><br><br><br>";
	echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
	echo "<tr>";
	echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
	</tr>";
	echo "<tr>";
	echo "<td valign=top class=\"mensaje\" align=center>CONFIGURACION NO EXISTE</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
	echo "</tr>";
	echo "</table>";
	echo "</form>";	
}
	
	mysql_close();
}

function mostrar()	/*******************************************************/
{
	//echo "funcion: $_POST[funcion]" ;
	//echo "CONFIGURACION: $_POST[conf]" ;
	//echo "INVENTARIO:: $_POST[inventario] ID ANALISTA:: $_SESSION[usu1]";
	conectarMysql();
	if ($_POST[band]==1)
	{
		$id_mtto = insertamttoenproceso($_POST[conf],$_POST[inventario], $_SESSION[usu1]);
		echo "<center><strong>MANTENIMIENTO CREADO:<em>$id_mtto</em></strong></center>";
	}
	else
	{
		$consp= "SELECT ID_MANTENIMIENTO_PREVENTIVO FROM mantenimiento_preventivo WHERE CONFIGURACION = '$_POST[conf]' AND STATUS_MTTO = '1'";
		$resultp= mysql_query($consp);
		if ($row = mysql_fetch_array ($resultp))
		{
			echo "<center><strong>MANTENIMIENTO PREVENTIVO PENDIENTE: <em>$row[0]</em></strong></center>";
			$id_mtto = $row[0];
		}
	}

$inventa= strtoupper($_POST[inventario]);
$config = strtoupper($_POST[conf]);
echo "<form name = \"frmcaptura\" method = \"post\" action =\"\"> ";
echo "<input name= \"conf\" type= \"hidden\" value= \"$config\" >";
echo "<input name=\"idmtto\" type=\"hidden\" value=\"$id_mtto\">";
echo "<input name=\"invent\" type=\"hidden\" value=\"$inventa\">";

echo "<em><strong>DATOS DEL USUARIO:</strong></em>";

$con = "SELECT inventario_usuario.FICHA_USUARIO, usuario.NOMBRE_USUARIO, usuario.EXTENSION, cargo.CARGO, usuario.APELLIDO_USUARIO FROM inventario INNER JOIN inventario_usuario ON inventario.ID_INVENTARIO = inventario_usuario.ID_INVENTARIO 
INNER JOIN usuario ON inventario_usuario.FICHA_USUARIO = usuario.FICHA 
INNER JOIN cargo ON usuario.ID_CARGO = cargo.ID_CARGO WHERE inventario.ID_INVENTARIO = '$_POST[inventario]' AND inventario_usuario.STATUS_ACTUAL = 1";

$valor = mysql_query($con);
 
 echo "<style type= \"text/css\">";
 echo ".Estilo1 {font-size: 12px}";
 echo "</style>";
 
  echo "<table width=\"690\" border=\"4\" >";
  echo "  <tr bordercolor=\"#CCCCCC\" bgcolor=\"#CCCCCC\">";
  echo "    <th width=\"300\" scope=\"col\"><span class=\"Estilo1\">Nombre</span></th>";
  echo "    <th width=\"80\" scope=\"col\"><span class=\"Estilo1\">Ficha</span></th>";
  echo "    <th width=\"240\" scope=\"col\"><span class=\"Estilo1\">Cargo</span></th>";
  echo "    <th width=\"70\" scope=\"col\"><span class=\"Estilo1\">Extension</span></th>";
  
  echo "  </tr>";
  echo "</table>";

 while ($row=mysql_fetch_array($valor))
 {
  echo "<table width=\"690\" border=\"2\" >";
  echo "  <tr bordercolor=\"#CCCCCC\" >";
  echo "    <th width=\"300\" scope=\"col\"><span class=\"Estilo1\">$row[1]&nbsp;&nbsp;&nbsp$row[4]</span></th>";
  echo "    <th width=\"80\" scope=\"col\"><span class=\"Estilo1\"><a href=\"secciones.php?item=300&ficha=$row[0]&configuracion=$config&cont=0\">$row[0]</a></span></th>";
  echo "    <th width=\"240\" scope=\"col\"><span class=\"Estilo1\">$row[3]</span></th>";
  echo "    <th width=\"70\" scope=\"col\"><span class=\"Estilo1\">$row[2]</span></th>";

  
  echo "  </tr>";
  echo "</table>";
 }
 echo "<em><strong>DATOS DEL EQUIPO:</strong> $config</em>";

$con1 = "SELECT gerencia.GERENCIA, division.DIVISION, departamento.DEPARTAMENTO, division.centro_costo, sitio.SITIO, ubicacion.ID_UBICACION FROM equipo_campo INNER JOIN inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO  
INNER JOIN inventario_ubicacion ON inventario.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO 
INNER JOIN ubicacion ON inventario_ubicacion.ID_UBICACION = ubicacion.ID_UBICACION 
INNER JOIN gerencia ON ubicacion.ID_GERENCIA = gerencia.ID_GERENCIA 
INNER JOIN division ON ubicacion.ID_DIVISION = division.ID_DIVISION 
INNER JOIN departamento ON ubicacion.ID_DEPARTAMENTO = departamento.ID_DEPARTAMENTO 
INNER JOIN sitio ON ubicacion.ID_SITIO = sitio.ID_SITIO WHERE equipo_campo.CONFIGURACION = '$config' AND inventario_ubicacion.STATUS_ACTUAL = 1";  
 $valor1 = mysql_query($con1);
 
  echo "<table width=\"690\" border=\"4\" >";
  echo "  <tr bordercolor=\"#CCCCCC\" bgcolor=\"#CCCCCC\">";
  echo "    <th width=\"310\" scope=\"col\"><span class=\"Estilo1\">Gerencia</span></th>";
  echo "    <th width=\"310\" scope=\"col\"><span class=\"Estilo1\">Division</span></th>";
  echo "    <th width=\"70\" scope=\"col\"><span class=\"Estilo1\">C.Costo</span></th>";
  echo "  </tr>";
  echo "</table>";
 
 while ($row=mysql_fetch_array($valor1))
 {
 	echo "  <table width=\"690\" border=\"2\" >";
	echo "  <tr bordercolor=\"#CCCCCC\" >";
  	echo "  <th width=\"310\" scope=\"col\"><span class=\"Estilo1\"><a href=\"secciones.php?item=300&ubica=$row[5]&invent=$_POST[inventario]&cont=1&configuracion=$config\">$row[0]</a></span></th>";
  	echo "  <th width=\"310\" scope=\"col\"><span class=\"Estilo1\">$row[1]</span></th>";
  	echo "  <th width=\"70\" scope=\"col\"><span class=\"Estilo1\">$row[3]</span></th>";
  	echo "  </tr>";
	echo "</table>";

    echo "<table width=\"690\" border=\"4\" >";
    echo "  <tr bordercolor=\"#CCCCCC\" bgcolor=\"#CCCCCC\">";
	echo "  <th width=\"345\" scope=\"col\"><span class=\"Estilo1\">Departamento</span></th>";
    echo "  <th width=\"345\" scope=\"col\"><span class=\"Estilo1\">Ubicacion</span></th>";
	echo "  </tr>";
	echo "</table>";

 	echo "  <table width=\"690\" border=\"2\" >";
	echo "  <tr bordercolor=\"#CCCCCC\" >";
	echo "  <th width=\"345\"><span class=\"Estilo1\">$row[2]</span></th>";
  	echo "  <th width=\"345\"><span class=\"Estilo1\">$row[4]</span></th>";
  	echo "  </tr>";
	echo "</table>";
 }

 
 $consulta = "SELECT equipo_campo.ACTIVO_FIJO, descripcion.DESCRIPCION, marca.MARCA, modelo.MODELO,inventario.SERIAL,modelo.CAP_VEL, modelo.UNIDAD  FROM equipo_campo INNER JOIN inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO 
 INNER JOIN descripcion ON inventario.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
 INNER JOIN marca ON inventario.ID_MARCA = marca.ID_MARCA 
 INNER JOIN modelo ON inventario.ID_MODELO = modelo.ID_MODELO 
 INNER JOIN inventario_usuario ON inventario.ID_INVENTARIO = inventario_usuario.ID_INVENTARIO WHERE equipo_campo.ID_INVENTARIO = '$_POST[inventario]' AND STATUS_ACTUAL = '1'"; 

 $resultado = mysql_query($consulta);
  echo "<table width=\"690\" border=\"4\" >";
  echo "  <tr bordercolor=\"#CCCCCC\" bgcolor=\"#CCCCCC\">";
  echo "    <th width=\"170\" scope=\"col\"><span class=\"Estilo1\">Descripcion</span></th>";
  echo "    <th width=\"173\" scope=\"col\"><span class=\"Estilo1\">Marca</span></th>";
  echo "    <th width=\"173\" scope=\"col\"><span class=\"Estilo1\">Modelo</span></th>";
  echo "    <th width=\"172\" scope=\"col\"><span class=\"Estilo1\">Serial</span></th>";
  
  echo "  </tr>";
  echo "</table>";


 while ($row=mysql_fetch_array($resultado))
 {
 	echo "  <table width=\"690\" border=\"2\" >";
	echo "  <tr bordercolor=\"#CCCCCC\" >";
  	echo "  <th width=\"170\" scope=\"col\"><span class=\"Estilo1\">$row[1]</span></th>";
  	echo "  <th width=\"173\" scope=\"col\"><span class=\"Estilo1\">$row[2]</span></th>";
  	echo "  <th width=\"173\" scope=\"col\"><span class=\"Estilo1\">$row[3] $row[5] $row[6]</span></th>";
  	echo "  <th width=\"172\" scope=\"col\"><span class=\"Estilo1\">$row[4]</span></th>";
  
  	echo "  </tr>";
	echo "</table>";
 }
 
 $consul = "SELECT  equipo_componente_campo.ID_INVENTARIO, descripcion.DESCRIPCION, marca.MARCA, modelo.MODELO, inventario.SERIAL,modelo.CAP_VEL, modelo.UNIDAD  FROM equipo_componente_campo INNER JOIN inventario ON equipo_componente_campo.ID_INVENTARIO = inventario.ID_INVENTARIO 
INNER JOIN descripcion ON inventario.ID_DESCRIPCION = descripcion.ID_DESCRIPCION 
INNER JOIN marca ON inventario.ID_MARCA = marca.ID_MARCA 
INNER JOIN modelo ON inventario.ID_MODELO = modelo.ID_MODELO WHERE equipo_componente_campo.CONFIGURACION = '$config' "; 

$consultaso = "SELECT ID_SOFTWARE, SOFTWARE FROM softwares";

$res = mysql_query($consul);
$Rsso=mysql_query($consultaso); 

 while ($row=mysql_fetch_array($res))
 {
 	echo "  <table width=\"690\" border=\"2\" >";
	echo "  <tr bordercolor=\"#CCCCCC\" >";
  	echo "  <th width=\"170\"><span class=\"Estilo1\">$row[1]</span></th>";
  	echo "  <th width=\"173\"><span class=\"Estilo1\">$row[2]</span></th>";
  	echo "  <th width=\"173\"><span class=\"Estilo1\">$row[3] $row[5] $row[6]</span></th>";
  	echo "  <th width=\"172\"><span class=\"Estilo1\">$row[4]</span></th>";
  
  	echo "  </tr>";

	
	echo "</table>";
	
 }
	echo "<p>&nbsp;</p>";
	echo "<strong>MISCELANEOS</strong><br>";
	echo "Procesador:&nbsp;<input name=\"procesador\" type=\"text\" value=\"\" >&nbsp;";
	echo "Particiones:&nbsp;<input name=\"particiones\" type=\"text\" value=\"\" size=\"5\">&nbsp;";
	echo "Cant. Discos Duros:&nbsp;<input name=\"cantidaddiscos\" type=\"text\" value=\"\" size=\"5\"><br>";
	
	echo " <input name=\"conexred\" type=\"radio\" value=\"1\" >Si";
	echo "<input name=\"conexred\" type=\"radio\" value=\"0\" >No Conectado en red<br>";
	
	echo "<input name=\"etiqueta\" type=\"radio\" value=\"1\" >Si";
	echo "<input name=\"etiqueta\" type=\"radio\" value=\"0\" >No Etiqueta en buen estado<br>";

	echo "<br><strong>SOFTWARE/APLICACIONES</strong><br>";
	echo "S.Operativo:&nbsp;<select name=\"selso\" >";
	echo "<option value=\"100\">-SO-</option>";
		while ($row=mysql_fetch_array($Rsso)) {
			if ($row[0]==$Idso) {
				echo "<option selected value=$row[0]>$row[1]</option>";	
			}
			else {
				echo "<option value=$row[0]>$row[1]</option>";
			}
		}
		echo "</select>";		
	echo " <input name=\"actualizacion1\" type=\"radio\" value=\"1\" >Si";
	echo "<input name=\"actualizacion1\" type=\"radio\" value=\"0\" >No Actualizacion";

  	echo " <span class=\"Estilo1\"><a href=\"secciones.php?item=300&configuracion=$config&opcion=1&invent=$_POST[inventario]\">PUNTO PENDIENTE</a></span><br>";

	$Rsso=mysql_query($consultaso); 
	echo "Antivirus:.....&nbsp;<select name=\"sela\" >";
	echo "<option value=\"100\">-SO-</option>";
		while ($row=mysql_fetch_array($Rsso)) {
			if ($row[0]==$Ida) {
				echo "<option selected value=$row[0]>$row[1]</option>";	
			}
			else {
				echo "<option value=$row[0]>$row[1]</option>";
			}
		}
		echo "</select>";		
	echo "<input name=\"actualizacion2\" type=\"radio\" value=\"1\" >Si";
	echo "<input name=\"actualizacion2\" type=\"radio\" value=\"0\" >No Actualizacion<br>";
				
	echo "<br><strong>CONDICIONES AMBIENTALES</strong><br>";

	echo " <input name=\"humedad\" type=\"radio\" value=\"1\" >Si";
	echo "<input name=\"humedad\" type=\"radio\" value=\"0\" >No Humedad Abundante<br>";
	
	echo " <input name=\"particulas\" type=\"radio\" value=\"1\" >Si";
	echo "<input name=\"particulas\" type=\"radio\" value=\"0\" >No Polvo Abundante<br>";

	echo " <input name=\"aire\" type=\"radio\" value=\"1\" >Si";
	echo "<input name=\"aire\" type=\"radio\" value=\"0\" >No Aire Acondicionado:<br>";
	
	echo "Observacion:........&nbsp;<input name=\"observaciones\" type=\"text\" value=\"\"size=\"70\" ><br>";
	echo "Trabajo Realizado:&nbsp;<input name=\"trabajo\" type=\"text\" value=\"\"size=\"70\" ><br>";	
	
	
	echo "<input name =\"funcion\" type=\"hidden\" value=\"7\">";
	echo "<input name=\"btnacep\" type=\"submit\" onClick= \"\" value=\"Aceptar\">";
	echo "</form>"; 
	

mysql_close(); 

}
function mensajeerrorseleccion($texto,$confi,$invent)
{
	echo "<form name=\"frmmsjerror\" method=\"post\" action=\"\">";
	//echo $texto;
	echo "<br><br><br><br>";
	echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
	echo "<tr>";
	echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
	</tr>";
	echo "<tr>";
	echo "<td valign=top class=\"mensaje\" align=center>$texto</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
	echo "</tr>";
	echo "</table>";
	
	echo "<input name =\"funcion\" type=\"hidden\" value=\"2\">";
		echo "<input name= \"conf\" type= \"hidden\" value= \"$confi\" >";
		echo "<input name=\"inventario\" type=\"hidden\" value=\"$invent\">";
		echo "<input name=\"band\" type=\"hidden\" value = \"0\">";
	//echo "<input name =\"boton\" type=\"submit\" value=\"Atras\">";
	echo "</form>"; 

}
function cerrarmtto()
{

if (!isset ($_POST[conexred]))
{
	mensajeerrorseleccion("NO FUE SELECCIONADA LA OPCION CONECTADO A RED",$_POST[conf],$_POST[invent]);	
}	
else
{
	if ($_POST[conexred])
	{
		$valorred= 1;
	}	
	if (!isset ($_POST[etiqueta]))
	{
		mensajeerrorseleccion("NO FUE SELECCIONADA LA OPCION ETIQUETA EN BUEN ESTADO",$_POST[conf],$_POST[invent]);	
	}	
	else
	{
		if ($_POST[etiqueta])
		{
			$valoreti= 1;
		}

		if (!isset ($_POST[humedad]))
		{
			mensajeerrorseleccion("NO FUE SELECCIONADA LA OPCION HUMEDAD",$_POST[conf],$_POST[invent]);	
		}	
		else
		{
			if ($_POST[humedad])
			{
				$valorhum= 1;
			}

			if (!isset ($_POST[particulas]))
			{
				mensajeerrorseleccion("NO FUE SELECCIONADA LA OPCION POLVO ABUNDANTE",$_POST[conf],$_POST[invent]);	
			}	
			else
			{
				if ($_POST[particulas])
				{
					$valorpar= 1;
				}

				if (!isset ($_POST[aire]))
				{
					mensajeerrorseleccion("NO FUE SELECCIONADA LA OPCION AIRE ACONDICIONADO",$_POST[conf],$_POST[invent]);	
				}	
				else
				{
					if ($_POST[aire])
					{
						$valorair= 1;
					}
	
					if (!isset ($_POST[actualizacion1]))
					{
						mensajeerrorseleccion("NO FUE SELECCIONADA LA OPCION ACTUALIZACION DE SISTEMA OPERATIVO",$_POST[conf],$_POST[invent]);	
					}	
					else
					{
						if ($_POST[actualizacion1])
						{
							$valorso= 1;
						}

						if (!isset ($_POST[actualizacion2]))
						{
							mensajeerrorseleccion("NO FUE SELECCIONADA LA OPCION ACTUALIZACION DE ANTIVIRUS",$_POST[conf],$_POST[invent]);	
						}	
						else
						{
							if ($_POST[actualizacion2])
							{
								$valora= 1;
							}
							
						if ($_POST[selso]==100)
						{
							mensajeerrorseleccion("NO FUE SELECCIONADO EL SISTEMA OPERATIVO",$_POST[conf],$_POST[invent]);	
						}	
						else
						{
					
							if ($_POST[sela]==100)
							{
								mensajeerrorseleccion("NO FUE SELECCIONADO EL ANTIVIRUS",$_POST[conf],$_POST[invent]);	
							}	
							else
							{

			$id_det_mtto = creardetmttoprev($_POST[idmtto],$valorred,$_POST[particiones],strtoupper($_POST[procesador]),strtoupper($_POST[velocidadprocesador]),$_POST[cantidaddiscos],$valoreti,strtoupper($_POST[observaciones]),strtoupper($_POST[trabajo]),$valorhum,$valorpar,$valorair); 
			$_SESSION[inventarios]=$_POST[invent];
			$_SESSION[configuraciones]=$_POST[conf];
			//echo "CONFIGURACION: $_SESSION[configuraciones]";
			/*echo "<form name=\"pruebas\" method=\"post\" action=\"\">";
		
			echo "<input name=\"funcion\" type=\"hidden\" value = \"\">";
			echo "<input name=\"bto\" type=\"submit\" value=\"OK\">";
			
			echo "</form>";*/
			
			echo "<form name = \"frmimprimir\" method = \"post\" action =\"\"> ";
			echo "<input name= \"confi\" type= \"hidden\" value= \"$_POST[conf]\" >";
			echo "<input name= \"funcion\" type= \"hidden\" value= \"\" >";
			echo "<input name= \"usu\" type= \"hidden\" value= \"$_SESSION[usu1]\" >";
		
			echo "<input name=\"conect\" type=\"hidden\" value=\"$valorred\">";
			echo "<input name=\"hum\" type=\"hidden\" value=\"$valorhum\">";
			echo "<input name=\"par\" type=\"hidden\" value=\"$valorpar\">";
			echo "<input name=\"air\" type=\"hidden\" value=\"$valorair\">";
			
			echo "<input name=\"inventa\" type=\"hidden\" value=\"$_POST[invent]\">";
		
			echo "<input name=\"etiq\" type=\"hidden\" value=\"$valoreti\">";
			echo "<input name=\"actso\" type=\"hidden\" value=\"$valorso\">";
			echo "<input name=\"acta\" type=\"hidden\" value=\"$valora\">";
		
			echo "<input name=\"so\" type=\"hidden\" value=\"$_POST[selso]\">";
			echo "<input name=\"act\" type=\"hidden\" value=\"$_POST[sela]\">";
			
			echo "<input name=\"procesa\" type=\"hidden\" value=\"$_POST[procesador]\">";
			echo "<input name=\"part\" type=\"hidden\" value=\"$_POST[particiones]\">";
			echo "<input name=\"cant\" type=\"hidden\" value=\"$_POST[cantidaddiscos]\">";
			
			echo "<input name=\"trab\" type=\"hidden\" value=\"$_POST[trabajo]\">";
			echo "<input name=\"obser\" type=\"hidden\" value=\"$_POST[observaciones]\">";
			echo "<input name=\"mtto\" type=\"hidden\" value=\"$_POST[idmtto]\">";
			
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>MANTENIMIENTO PREVENTIVO EJECUTADO CON EXITO</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" onClick=\"window.open('../librerias/reportertfs.php?config=$_POST[conf]&inventario=$_POST[invent]&mtto=$_POST[idmtto]&usuario=$_SESSION[usu1]&so=$_POST[selso]&ant=$_POST[sela]&trabajo=$_POST[trabajo]&observacion=$_POST[observaciones]&particiones=$_POST[particiones]&procesador=$_POST[procesador]')\" value=\"Imprimir\">";
			echo "<valign=top class=\"mensaje\" align=center><input name=\"txtBoton1\" type=\"submit\" value=\"Atras\"></td>";
			echo "</tr>";
			echo "</table>";
			
//			echo "<input name=\"btnimp\" type=\"button\" onClick=\"window.open('../librerias/reportertfs.php?config=$_POST[conf]&inventario=$_POST[invent]&mtto=$_POST[idmtto]&usuario=$_SESSION[usu1]&so=$_POST[selso]&ant=$_POST[sela]&trabajo=$_POST[trabajo]&observacion=$_POST[observaciones]&particiones=$_POST[particiones]&procesador=$_POST[procesador]')\" value=\"Imprimir\">";

			echo "</form>";
	}
	}			 
	}		
	}		
	}
	}
	}		
	}
	}
}

function creardetmttoprev($id_mtto,$red,$particiones,$procesador,$vprocesador,$cantdiscos,$eti,$observ,$trab,$humedad,$particulas,$aire)
{
	$consulta="SELECT ID_DETALLE_MANTENIMIENTO_PREVENTIVO FROM detalle_mantenimiento_preventivo ORDER BY ID_DETALLE_MANTENIMIENTO_PREVENTIVO DESC";
	$idConsecutivo= new consecutivo("DMT", $consulta);
	$id_detalle_mtto=$idConsecutivo->retornar();


	$sq= "INSERT INTO detalle_mantenimiento_preventivo (ID_DETALLE_MANTENIMIENTO_PREVENTIVO, ID_MANTENIMIENTO_PREVENTIVO, CONECTADO_RED, PARTICIONES, PROCESADOR, VELOCIDAD_PROCESADOR, CANT_DISCOS_DUROS, ETIQUETA,OBSERVACIONES,DESCRIPCION_TRABAJO,HUMEDAD,PARTICULAS,AIRE) VALUE ('$id_detalle_mtto', '$id_mtto', '$red','$particiones','$procesador','$vprocesador','$cantdiscos','$eti','$observ','$trab','$humedad','$particulas','$aire')";
	$res = mysql_query($sq);
	/*if($res)
	{echo "DETALLE MTTO INSERTADO CON EXITO";}
	else{echo "NO PUDO SER INSERTADO EL DETALLE MTTO";}*/

	$fechafin=date("Y-m-d h:i:s");
	$sql= "UPDATE mantenimiento_preventivo SET FECHA_MANTENIMIENTO_FIN = '$fechafin', STATUS_MTTO = '0' WHERE ID_MANTENIMIENTO_PREVENTIVO = '$id_mtto'";
	$resulta = mysql_query($sql);
	/*if($resulta)
	{echo "CERRADO MTTO PREVENTIVO CON EXITO";}
	else{echo "NO PUDO SER CERRADO SU MTTO";}*/

	
	return $id_detalle_mtto;

}
function insertamttoenproceso($config, $inv, $usuario)	/***************************************/
{
$conf = strtoupper($config);
$id_inv = strtoupper($inv);
$usu = strtoupper($usuario);
$fechainicio=date("Y-m-d h:i:s");
	$abreviatura = "MTO";
	
	echo " <em><strong><center>AGREGAR MANTENIMIENTO PREVENTIVO</center>"
	  . "  </strong></em>"
	  ."";
	//conectarMysql();
	$cons="SELECT ID_INVENTARIO_USUARIO FROM inventario_usuario WHERE ID_INVENTARIO = '$id_inv' AND STATUS_ACTUAL = '1'";	 
	
	$resultado=mysql_query($cons);
	if ($row=mysql_fetch_array($resultado))
		{$id_equipou = $row[0];}
	else
		{echo "NO HAY ACCESO A LA BASE DE DATOS";}
	
	$consulta="SELECT ID_MANTENIMIENTO_PREVENTIVO FROM mantenimiento_preventivo ORDER BY ID_MANTENIMIENTO_PREVENTIVO DESC";
	$idConsecutivo= new consecutivo("MTO", $consulta);
	$id_mantenimiento=$idConsecutivo->retornar();


$sq= "INSERT INTO mantenimiento_preventivo (ID_MANTENIMIENTO_PREVENTIVO, FECHA_MANTENIMIENTO_INICIO, CONFIGURACION, ID_USS, ID_INVENTARIO_USUARIO, STATUS_MTTO) VALUE ('$id_mantenimiento', '$fechainicio', '$conf', '$usu','$id_equipou', '1')";
$res = mysql_query($sq);
if($res)
{//echo "MTTO INSERTADO CON EXITO";
}
else{echo "NO PUDO SER INSERTADO EL MTTO";}

//mysql_close();
return $id_mantenimiento;
}

/*****************FUNCIONES UTILIZADAS POR EL VINCULO GERENCIA PARA MODIFICAR UBICACION************/
function formularioModificar($ubicacion,$inventario,$confi,$usa) {
		//echo "funcion: $_POST[funcion]";
		conectarmysql();
		$conCargo="SELECT ID_CARGO, CARGO FROM CARGO ORDER BY CARGO";
		$conSitio="SELECT ID_SITIO, SITIO FROM SITIO ORDER BY SITIO";
		$conGerencia="SELECT ID_GERENCIA, GERENCIA FROM GERENCIA ORDER BY GERENCIA";
		$conDivision="SELECT ID_DIVISION, DIVISION FROM DIVISION  WHERE ID_GERENCIA='$_POST[selGerencia]' ORDER BY DIVISION";
		$conDepartamento="SELECT ID_DEPARTAMENTO, DEPARTAMENTO FROM DEPARTAMENTO  WHERE ID_DIVISION='$_POST[selDivision]' ORDER BY DEPARTAMENTO";
		echo "<center><strong>MODIFICAR UBICACION</strong></center>";
		echo "<br>";
		$clase="";
		echo "<form name=\"frmUsuario\" method=\"post\" action=\"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value=\"6\">";
		echo "<input name=\"ubic\" type=\"hidden\" value=\"$ubicacion\">";
		echo "<input name=\"invent\" type=\"hidden\" value=\"$inventario\">";
		echo "<input name=\"confa\" type=\"hidden\" value=\"$confi\">";
		echo "<input name=\"usa1\" type=\"hidden\" value=\"$usa\">";
		echo "<input name=\"aux\" type=\"hidden\" value=\"1\">";

		echo "<br>";
		echo "<strong>UBICACION</strong>";
		echo "<br>";
		$sitio= new campoSeleccion("selSitio","$clase","$_POST[selSitio]","","",$conSitio,"--UBICACION--","");
		$selSitio=$sitio->retornar();
		echo $selSitio;
		echo "<br>";
		echo "<strong>GERENCIA</strong>";
		echo "<br>";
		$gerencia= new campoSeleccion("selGerencia","$clase","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--GERENCIA--","");
		$selGerencia=$gerencia->retornar();
		echo $selGerencia;
		echo "<br>";
		echo "<strong>DIVISION</strong>";
		echo "<br>";
		$division= new campoSeleccion("selDivision","$clase","$_POST[selDivision]","onChange","cambiarSeleccion()",$conDivision,"--DIVISION--","");
		$selDivision=$division->retornar();
		echo $selDivision;
		echo "<br>";
		echo "<strong>DEPARTAMENTO</strong>";
		echo "<br>";
		$departamento= new campoSeleccion("selDepartamento","$clase","$_POST[selDepartamento]","onChange","cambiarSeleccion()",$conDepartamento,"--DEPARTAMENTO--","");
		$selDepartamento=$departamento->retornar();
		echo $selDepartamento;
		echo "<br><input name=\"btnAgregar\" type=\"submit\" value=\"ACTUALIZAR\">";
		echo "</form>";
	}
function intromodubicacion()
{
	conectarMysql();
	$sql="SELECT ID_UBICACION FROM ubicacion WHERE ID_GERENCIA = '$_POST[selGerencia]' AND ID_DIVISION = '$_POST[selDivision]' AND ID_DEPARTAMENTO = '$_POST[selDepartamento]' AND ID_SITIO = '$_POST[selSitio]'";
	$consu=mysql_query($sql);
	if($row=mysql_fetch_array($consu))//existe la ubicacion
	{
		if ($row[0]==$_POST[ubic])
		{
			echo "<form name=\"frmubiigual\" method= \"post\" action = \"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value = \"2\">";					
			echo "<input name=\"band\" type=\"hidden\" value = \"0\">";
			echo "<input name=\"conf\" type=\"hidden\" value = \"$_POST[confa]\">";
			echo "<input name=\"inventario\" type=\"hidden\" value = \"$_POST[invent]\">";			
			
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>LA UBICACION ES LA MISMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
//			echo "<input name= \"btnatras\" type=\"submit\"value =\"Atras\" ";
			echo "</form>";
		}
		else
		{
			echo "<form name=\"frmubidist\" method= \"post\" action = \"\">";
			echo "<input name=\"funcion\" type=\"hidden\" value = \"2\">";					
			echo "<input name=\"band\" type=\"hidden\" value = \"0\">";
			echo "<input name=\"conf\" type=\"hidden\" value = \"$_POST[confa]\">";
			echo "<input name=\"inventario\" type=\"hidden\" value = \"$_POST[invent]\">";			

			ingresarinvubi($row[0], $_POST[invent], $_POST[ubic]);
//			echo "LA UBICACION FUE MODIFICADA CORRECTAMENTE ";
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>UBICACION MODIFICADA CORRECTAMENTE</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
			//echo "<input name= \"btnatras2\" type=\"submit\"value =\"Atras\" ";
			echo "</form>";
		}
	}
	else
	{
		echo "<form name=\"frmubidist\" method= \"post\" action = \"\">";
		echo "<input name=\"funcion\" type=\"hidden\" value = \"2\">";					
		echo "<input name=\"band\" type=\"hidden\" value = \"0\">";
		echo "<input name=\"conf\" type=\"hidden\" value = \"$_POST[confa]\">";
		echo "<input name=\"inventario\" type=\"hidden\" value = \"$_POST[invent]\">";			

		//echo "no existe ubicacion";
		$ubinueva=creaubicacion($_POST[selGerencia], $_POST[selDivision], $_POST[selDepartamento], $_POST[selSitio]);
		ingresarinvubi($ubinueva, $_POST[invent], $_POST[ubic]);				
		//echo " UBICACION CREADA:$ubinueva";
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
		</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>UBICACIONA CREADA E INSERTADA CON EXITO</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table>";

//		echo "<input name= \"btnatras3\" type=\"submit\"value =\"Atras\" ";
		echo "</form>";

	}
	mysql_close();
}	
function ingresarinvubi($ubireal,$invent,$ubianterior)
{
	modificastatusinv($invent);
	//conectarMysql();
	
	$fecha=date("Y-m-d h:i:s");//gmdate("Y-m-d"); 
	
	$consulta="SELECT ID_INVENTARIO_UBICACION FROM inventario_ubicacion ORDER BY ID_INVENTARIO_UBICACION DESC";
 	$idConsecutivo= new consecutivo("EUB", $consulta);
	$id_invubi=$idConsecutivo->retornar();

	//echo "ID_INVENTARIO_USUARIO: $id_invu ID_INVENTARIO: $id_invusuario FICHA: $ficha  FECHA_ASOCIA: $fecha STATUS = '1'";

	$sql2 = "INSERT INTO inventario_ubicacion (ID_INVENTARIO_UBICACION, ID_INVENTARIO, ID_UBICACION, STATUS_ACTUAL, FECHA_ASOCIACION) VALUE ('$id_invubi', '$invent','$ubireal','1','$fecha')";
	$result = mysql_query($sql2);    

	/*if($result)
		{echo "REGISTRO INSERTADO CON EXITO";}
     else
	    {echo "Error al Insertar";} */

	//mysql_close();
}

function modificastatusinv($id_inv)
{
		
		//conectarMysql();
		$sql2 = "UPDATE inventario_ubicacion SET STATUS_ACTUAL = '0' WHERE ID_INVENTARIO = '$id_inv'"; 
		$mod = mysql_query($sql2);	
/*		if ($mod)
		{
			echo "MODIFICADO STATUS CORRECTAMENTE";
		}
		else
		{
			echo "ERROR AL MODIFICAR EL STATUS DEL USUARIO ANTERIOR";
		}
		//mysql_close();*/
	
}
function creaubicacion($gerencia, $division, $departamento, $sitio)
{
	$consulta="SELECT ID_UBICACION FROM ubicacion ORDER BY ID_UBICACION DESC";
 	$idConsecutivo= new consecutivo("UBI", $consulta);
	$id_ubi=$idConsecutivo->retornar();

	$sql2 = "INSERT INTO ubicacion (ID_UBICACION, ID_GERENCIA, ID_DIVISION, ID_DEPARTAMENTO, ID_SITIO) VALUE ('$id_ubi', '$gerencia','$division','$departamento','$sitio')";
	$result = mysql_query($sql2);    

	if($result)
	{
		//echo "REGISTRO UBICACION INSERTADO CON EXITO";
		return $id_ubi;
	}
     /*else
	    {echo "Error al Insertar";} */

}
/*******************FUNCIONES UTILIZADAS POR EL VINCULO FICHA PARA CAMBIAR USUARIO****************/

function continuamtto($fichas, $configu, $usua)		/*********************************************/
{
	echo "<table class=\"formularioTabla\"align=center width=\"300\" border=\"0\">";
	echo "<tr>";
	echo "<center><td class=\"tituloPagina\" aling=center colspan=\"2\">MANTENIMIENTO PREVENTIVO </td>
  		</tr>";

	echo "</table>";
	conectarMysql();
	$cons = "SELECT CEDULA, NOMBRE_USUARIO, APELLIDO_USUARIO, EXTENSION FROM usuario WHERE FICHA = '$fichas'";
	$res = mysql_query($cons);

	if($row = mysql_fetch_array($res))
	{
		echo "<form name=\"captmtto\" method=\"post\" action=\"\">";	
		echo "<input name=\"funcion\" type=\"hidden\">";
		echo "<input name =\"config\" type = \"hidden\" value=\"$configu\">";	
		echo "<input name =\"usuarioana\" type = \"hidden\" value=\"$usua\">";	

   		echo "<input name=\"fich\" type=\"hidden\" value=\"$fichas\">";
   		echo "<input name=\"ext\" type=\"hidden\" value=\"$ext\">";

    	echo "<strong>FICHA:.........</strong>";	
		echo "<input name=\"ficha\" type=\"text\" size=\"20\" value=\"$fichas\" ><br>";
    	echo "<strong>CEDULA:......</strong>";	
		echo "<input name=\"nombreusuario\" type=\"text\" size=\"20\" maxlength=\"\" value=\"$row[0]\" disabled><br>";
    	echo "<strong>NOMBRES:..</strong>";	
		echo "<input name=\"nombreusuario\" type=\"text\" size=\"20\" maxlength=\"\" value=\"$row[1]\" disabled><br>";
    	echo "<strong>APELLIDOS:</strong>";	
		echo "<input name=\"apellidousuario\" type=\"text\" size=\"20\" value=\"$row[2]\" disabled><br>";
    	echo "<strong>EXTENSION:</strong>";	
		echo "<input name=\"extension\" type=\"text\" size=\"20\" value=\"$row[3]\"><br>";
		
		echo "<input name=\"btnActualizar\" type=\"button\" onClick=\"actualizar()\" value=\"ACTUALIZAR\">";
		echo "<input name=\"btnInsertar\" type=\"button\" onClick=\"insertar()\" value=\"INSERTAR\">";
  		echo "</form>";	
	
	}
	else
	{
		echo "<form name=\"frmnoexisteusuario\" method=\"post\" action=\"\">";
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
		</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>FICHA NO EXISTE</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table>";
		echo "<input name =\"funcion\" type=\"hidden\" value=\"3\">";
		//echo "<input name= \"conf\" type= \"hidden\" value= \"$confi\" >";
		//echo "<input name= \"usu\" type= \"hidden\" value= \"$_POST[usuario]\" >";
		//echo "<input name=\"inventario\" type=\"hidden\" value=\"$invent\">";
		//echo "<input name=\"band\" type=\"hidden\" value = \"0\">";
		//echo "<input name =\"boton\" type=\"submit\" value=\"Atras\">";
		echo "</form>"; 
		
		
	}	
	mysql_close();
}
function intromodusuario()/*********************************************************/
{

	/*echo " <em><strong><center>MANTENIMIENTO PREVENTIVO</center>"
  	. "  </strong></em>"
  	."";*/
	conectarMysql();
	//echo "Ficha Modificada: $_POST[fich]";
	//echo "Extension: $_POST[extension]";	
	//echo "Configuracion: $_POST[config]";
	$configuracion = $_POST[config];
	$sql = "SELECT inventario_usuario.FICHA_USUARIO, inventario_usuario.ID_INVENTARIO_USUARIO, inventario_usuario.ID_INVENTARIO FROM equipo_campo INNER JOIN inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO 
	INNER JOIN inventario_usuario ON inventario.ID_INVENTARIO = inventario_usuario.ID_INVENTARIO WHERE equipo_campo.CONFIGURACION = '$_POST[config]' AND inventario_usuario.STATUS_ACTUAL = 1";
	
	echo "<form name=\"captmtt\" method=\"post\" action=\"\">";	
	
	$res = mysql_query($sql);
	if($row = mysql_fetch_array($res))
	{
 		//echo "<input name=\"fich\" type=\"hidden\" value=\"$fichas\">";
		//echo " Ficha BD:$row[0]";
		//echo "ID_INV_USU: $row[1]";
		//echo "ID_INVENTARIO: $row[2];";
		$fichabd=$row[0];
		$id_inv_usu = $row[1];
		$id_inv = $row[2];
	}
	else
	{
		echo "ERROR NO HAY ACCESO A LA BASE DE DATOS usu";
	}	

	if ($fichabd!=$_POST[fich] && isset($fichabd) && !empty($fichabd))
	{
		insertaidinvusu($_POST[fich],$id_inv);
		modificastatus($id_inv_usu);
		modificaextension($_POST[fich],$_POST[extension]);
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
		</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>MODIFICACION INSERTADA CORRECTAMENTE</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" onClick = \"atras()\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table>";
	}
	else
	{
		echo "<br><br><br><br>";
		echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
		echo "<tr>";
		echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
		</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center>EL USUARIO ES EL MISMO</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" onClick = \"atras()\" value=\"Aceptar\"></td>";
		echo "</tr>";
		echo "</table>";

		modificaextension($_POST[fich],$_POST[extension]);
	}
	echo "<input name=\"funcion\" type=\"hidden\"> ";
	echo "<input name=\"band\" type=\"hidden\" value = \"0\">";
	echo "<input name=\"conf\" type=\"hidden\" value = \"$configuracion\">";
	echo "<input name=\"inventario\" type=\"hidden\" value = \"$id_inv\">";			
	
  	//echo "<center><input name=\"btnatrasa\" type=\"button\" onClick = \"atras()\"value=\"Atras\" ></center>";
  	echo "</form>";
	mysql_close();

}

function modificastatus($id_inv_us)/***********************************************************/
{
		//conectarMysql();
		$sql2 = "UPDATE inventario_usuario SET STATUS_ACTUAL = '0' WHERE ID_INVENTARIO_USUARIO = '$id_inv_us'"; 
		$mod = mysql_query($sql2);	
		/*if ($mod)
		{
			echo "MODIFICADO STATUS CORRECTAMENTE";
		}
		else
		{
			echo "ERROR AL MODIFICAR EL STATUS DEL USUARIO ANTERIOR";
		}
		//mysql_close();*/
	
}
function modificaextension($ficha,$extension)/***************************************************/
{
		//conectarMysql();
		$sql2 = "UPDATE usuario SET EXTENSION = '$extension' WHERE FICHA = '$ficha'"; 
		$mod = mysql_query($sql2);	
		/*if ($mod)
		{
			echo "MODIFICADO EXTENSION CORRECTAMENTE";
		}
		else
		{
			echo "ERROR AL MODIFICAR LA EXTENSION DEL USUARIO ANTERIOR";
		}
		//mysql_close();*/
	
	
}

function insertaidinvusu($ficha,$inv)/******************************************************/
{
	$fecha=date("Y-m-d h:i:s");//gmdate("Y-m-d"); 
//	conectarMysql();
	$consulta="SELECT ID_INVENTARIO_USUARIO FROM inventario_usuario ORDER BY ID_INVENTARIO_USUARIO DESC";
 	$idConsecutivo= new consecutivo("IUS", $consulta);
	$id_invu=$idConsecutivo->retornar();

	/*$sql = "SELECT ID_INVENTARIO FROM inventario_usuario WHERE ID_INVENTARIO_USUARIO = '$id_inv_ant' AND STATUS_ACTUAL = '1'";
	$cons = mysql_query($sql);
	if ($row=mysql_fetch_array($cons))
	{
		$id_inv=$row[0];
	}
	else
	{
		echo "no se pudo crear el id_inv_usu";
	}*/

	//echo "ID_INVENTARIO_USUARIO: $id_invu ID_INVENTARIO: $inv FICHA: $ficha  FECHA_ASOCIA: $fecha STATUS = '1'";

	$sql2 = "INSERT INTO inventario_usuario (ID_INVENTARIO_USUARIO, ID_INVENTARIO, FICHA_USUARIO, FECHA_ASOCIACION, STATUS_ACTUAL) VALUE ('$id_invu', '$inv','$ficha','$fecha','1')";
	$result = mysql_query($sql2);    

	/*if($result)
		{echo "REGISTRO INSERTADO CON EXITO";}
     else
	    {echo "Error al Insertar";} 

	//mysql_close();*/
	
}
/******************************PUNTO PENDIENTE**********************************************/
function puntopendiente($confi,$ubicacion,$inv)
{
	echo "<form name=\"frmpuntopendiente\" method=\"post\">";

	echo "<table class=\"formularioTabla\"align=center width=\"300\" border=\"0\">";
	echo "<tr>";
	echo "<center><td class=\"tituloPagina\" aling=center colspan=\"2\">MANTENIMIENTO PREVENTIVO </td>
  		</tr>";

	echo "</table>";
	echo "<center><strong> Configuracion=</strong> $confi</center><br>";
	echo "<center><strong>Descripcion Punto Pendiente:<br></strong><input name=\"descripcion\" align=center type=\"text\" size=\"80\"><br>";

	echo "<input name=\"funcion\" type=\"hidden\" >";					
	echo "<input name=\"band\" type=\"hidden\" value = \"0\">";
	echo "<input name=\"conf\" type=\"hidden\" value = \"$confi\">";
	echo "<input name=\"inventario\" type=\"hidden\" value = \"$inv\">";			

	echo "<center><input name=\"btnaceptarppt\" type=\"button\" onClick=\"insertarppt()\" value=\"Aceptar\">";
	echo "<input name=\"btnatrasppt\" type=\"button\" onClick=\"atrasppt()\" value=\"Atras\"></center>";

	echo "</form>";
}

function insertarpuntopendiente($conf)
{
	require_once "usuarioSistemaAdmin.php";
	$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
	$id_usu=$acceso->login();

	$fecha=date("Y-m-d");
	$consulta="SELECT ID_PUNTO_PENDIENTE FROM punto_pendiente ORDER BY ID_PUNTO_PENDIENTE DESC";
 	$idConsecutivo= new consecutivo("PPT", $consulta);
	$id_ppt=$idConsecutivo->retornar();

	$sql = "INSERT INTO punto_pendiente (ID_PUNTO_PENDIENTE, FECHA_PUNTO_PENDIENTE,STATUS_ACTUAL,CONFIGURACION,DESCRIPCION,ID_USS) VALUE ('$id_ppt', '$fecha','1','$conf','$_POST[descripcion]','$id_usu')";
	$result = mysql_query($sql);    
	echo "<form name=\"frminsertpuntopendiente\" method=\"post\"> ";
	if($result)
		{
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: MANTENIMIENTO PREVENTIVO</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>PUNTO PENDIENTE  INSERTADO CON EXITO</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
		}
	echo "<input name=\"funcion\" type=\"hidden\" value =\"10\">";					
	echo "</form>";
}
?>