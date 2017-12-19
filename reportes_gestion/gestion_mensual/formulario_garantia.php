<?php
include("...\libreria\calendario\calendario.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Gestión Mensual CAU</title>
<link rel="STYLESHEET" type="text/css" href="../estilomantenimiento.css">
<script language="javascript" type="text/javascript"src="date-picker.js"></script>
</head>

<body>
<div id="contenedor">
	<div id="encabezado">
		<h1>GERENCIA SISTEMAS Y ORGANIZACI&Oacute;N<br>
		DIVISI&Oacute;N CENTRO ATENCI&Oacute;N A USUARIOS
		</h1>

	</div>	
	<div id="cuerpo">
	<h2>REPORTE DE PEDIDO</h2>

	<br><br><br>
<form name="fcalen" action="nuevo.php"  method="GET">

    <tr>
<td colspan="2"><div align="center">
      

      </tr>
    <tr>
     <tr>
   <td valign=top class="formularioCampoTitulo" ><h2>PEDIDO A CONSULTAR</h2><br><select name="Pedido"  onChange="cambiarPedido()" class="formularioCampoSeleccion" size="">
   <option selected value="100">--TODOS--</option>
   <option value="4500000000">4500000000, SIN GARANTIA</option>
   <option value="4500000001">4500000001, ALMACEN</option>
   <option value="4500045839">4500045839, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500052459">4500052459, SITEC</option>
   <option value="4500059444">4500059444, DATA MAX, C.A.</option>
   <option value="4500059453">4500059453, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500070820">4500070820, DATA MAX, C.A.</option>
   <option value="4500071856">4500071856, COMERCIAL SUPERSONICO</option>
   <option value="4500072535">4500072535, DATA MAX, C.A.</option>
   <option value="4500074279">4500074279, COMCIVE, C.A.</option>
   <option value="4500074280">4500074280, COMCIVE, C.A.</option>
   <option value="4500075197">4500075197, DATA MAX, C.A.</option>
   <option value="4500076251">4500076251, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500076274">4500076274, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500076452">4500076452, DATA MAX, C.A.</option>
   <option value="4500077863">4500077863, DATA MAX, C.A.</option>
   <option value="4500077967">4500077967, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500078091">4500078091, DATA MAX, C.A.</option>
   <option value="4500078434">4500078434, COMCIVE, C.A.</option>
   <option value="4500078594">4500078594, DATA MAX, C.A.</option>
   <option value="4500078654">4500078654, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500079870">4500079870, COMCIVE, C.A.</option>
   <option value="4500080341">4500080341, COMCIVE, C.A.</option>
   <option value="4500080489">4500080489, DATA MAX, C.A.</option>
   <option value="4500080491">4500080491, DATA MAX, C.A.</option>
   <option value="4500081877">4500081877, DATA MAX, C.A.</option>
   <option value="4500088669">4500088669, COMCIVE, C.A.</option>
   <option value="4500089220">4500089220, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500089221">4500089221, DATA MAX, C.A.</option>
   <option value="4500089227">4500089227, INTERPLOT C.A</option>
   <option value="4500089836">4500089836, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500090506">4500090506, COMCIVE, C.A.</option>
   <option value="4500090515">4500090515, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500090517">4500090517, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500092222">4500092222, DATA MAX, C.A.</option>
   <option value="4500092331">4500092331, REYSUCA C.A</option>
   <option value="4500092383">4500092383, COMPU SERVICIOS GUTIERREZ C.A.</option>
   <option value="4500092384">4500092384, INTERPLOT C.A</option>
   <option value="4500093360">4500093360, INSERVE DE VENEZUELA, C.A.</option>
   <option value="4500095006">4500095006, DATA MAX, C.A.</option>
   <option value="4500095172">4500095172, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500095224">4500095224, DATA MAX, C.A.</option>
   <option value="4500095232">4500095232, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500095402">4500095402,  GRUPO EMPRESARIAL AMSEICA</option>
   <option value="4500095532">4500095532, MARSE, C.A.</option>
   <option value="4500096284">4500096284, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500097709">4500097709, SERVICIOS Y SUMINISTROS H Y M</option>
   <option value="4500097948">4500097948, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500098073">4500098073, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500099044">4500099044, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500099273">4500099273, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500099321">4500099321, SERVINEMECA, C.A</option>
   <option value="4500100397">4500100397, DATA MAX, C.A.</option>
   <option value="4500100993">4500100993, COMPUTER CITY VENEZUELA, C.A.</option>
   <option value="4500101639">4500101639, MARSE, C.A.</option>
   <option value="4500103339">4500103339, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500103637">4500103637, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500103638">4500103638, COMERCIAL SUPERSONICO</option>
   <option value="4500104805">4500104805, INDUSTRIAL EHR C.A</option>
   <option value="4500105986">4500105986, TECNISISTEMA LANWORKPLACE C.A.</option>
   <option value="4500106282">4500106282, MARSE, C.A.</option>
   <option value="4500106684">4500106684, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500107056">4500107056, COMERCIAL SUPERSONICO</option>
   <option value="4500107090">4500107090, DATA MAX, C.A.</option>
   <option value="4500107645">4500107645, DATA MAX, C.A.</option>
   <option value="4500107691">4500107691, DATA MAX, C.A.</option>
   <option value="4500107922">4500107922, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500108104">4500108104, INVERSIONES LAGAMA, C.A</option>
   <option value="4500109912">4500109912, COMCIVE, C.A.</option>
   <option value="45001100893">45001100893, MB SUPPLY SOLUTIONS,</option>
   <option value="4500110823">4500110823, DATA MAX, C.A.</option>
   <option value="4500111170">4500111170, CORPORACION VENEZOLANA DEL CARONI, C.A.</option>
   <option value="4500111356">4500111356, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500113083">4500113083, CORPORACION VENEZOLANA DEL CARONI, C.A.</option>
   <option value="4500113145">4500113145, CONTINENTAL DE SISTEMAS Y MAQUINAS (CONTIMACA)</option>
   <option value="4500113289">4500113289, GRUPO BEKESANTOS, C.A.</option>
   <option value="4500113338">4500113338, DATA MAX, C.A.</option>
   <option value="4500113798">4500113798, CORPORACION VENEZOLANA DEL CARONI, C.A.</option>
   <option value="4500113802">4500113802, CORPORACION VENEZOLANA DEL CARONI, C.A.</option>
   <option value="4500113939">4500113939, COMCIVE, C.A.</option>
   <option value="4500114101">4500114101, TECNISISTEMA LANWORKPLACE C.A.</option>
   <option value="4500114502">4500114502, COMCIVE, C.A.</option>
   <option value="4500114676">4500114676, COMCIVE, C.A.</option>
   <option value="4500114846">4500114846, SUMEING, C.A.</option>
   <option value="4500114934">4500114934, SERVICIOS Y SOLUCIONES DE TECNOLOGIA, C.A</option>
   <option value="4500115047">4500115047, COMCIVE, C.A.</option>
   <option value="4500115060">4500115060, COMCIVE, C.A.</option>
   <option value="4500115258">4500115258, CORPORACION VENEZOLANA DEL CARONI, C.A.</option>
   <option value="4500115326">4500115326, INVERSIONES LAGAMA, C.A</option>
   <option value="4500117323">4500117323, COMCIVE, C.A.</option>
   <option value="4500708093">4500708093, COMERCIAL SUPERSONICO</option>
   </select></td>
       <td colspan="2"><div align="center">
       <p><INPUT TYPE="submit"><INPUT TYPE="Reset"> </p> 
        </div></td>


			

</tr>
    <tr>
     
    
  </table>
</form>

</body>
</html>
