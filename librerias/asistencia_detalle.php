<!DOCTYPE html>
<?php 

require_once("../dompdf/dompdf_config.inc.php");
include 'horas.php';
include 'connect.php';
$fecha=$_GET['fecha'];
$codigo=$_GET['codigo'];
$opcion=$_GET['opcion'];
$sql = "SELECT * FROM detalle_asistencias,usuario_sistema where fecha='$fecha' and cod='$codigo' and detalle_asistencias.id_trabajador=usuario_sistema.ID_USS";
$res =mysql_query($sql,$con);
$horas_totales=0;

$codigoHTML='
<html>
<head>
	<title>PDF</title>
	<link rel="STYLESHEET" type="text/css" href="../site/estilo_pdf.css">
</head>
<body>
	<table class="tabla_pdf">
		<thead>
			<tr>
				<th colspan="2">
					<img class="imagen1" src="../imagenes/venalum1.png">
				</th>
				<th colspan="2">
					<h1>Control Diario de Asistencia <br>Personal Contratistas</h1>
				</th>
				<th colspan="2">
					<img class="imagen2" src="../imagenes/venalum2.png">
				</th>
			</tr>
		</thead>
		<thead>
			<tr>
				<th class="derecha" colspan="6">fecha '.$fecha.'</th>
			</tr>
		</thead>
		<tr>
			<td colspan="1">Turno <br> Normal</td>
			<td colspan="1">Grupo<br> Normal</td>
			<td colspan="4">Descripcion del Servicio <br> Mantenimiento preventivo y correctivo plataforma de impresion CVG VENALUM.</td>
		</tr>
		<tr>
			<td colspan="4">Proveedor <br> Computer City Venezuela, C.A.</td>
			<td colspan="2"> Pedido/Contrato <br> N° '.$codigo.'</td>
		</tr>
		<tr>
			<td colspan="4">Actividad Realizada <br> Mantenimiento Correctivo y Preventivo a Impresoras</td>
			<td colspan="2">Unidad Receptora del servicio <br> DVI. CENTRO DE ATENCION A USUARIOS</td>
		</tr>
		<tr>
			<td>Nombres y Apellidos</td>
			<td>Cedula de identidad</td>
			<td>Hora de Entrada</td>
			<td>Hora de Salida</td>
			<td>Horas Trabajadas</td>
			<td>Firma</td>
		</tr>
';
  
while ($row = mysql_fetch_array($res)){
$horas_totales+=$row['horas_trabajadas'];
$codigoHTML.='	
	<tr>
		<td>'.$row['NOMBRE']." ".$row['APELLIDO'].'</td>
		<td>'.$row['cedula'].'</td>
		<td>'.$row['hora_entrada'].'</td>
		<td>'.$row['hora_salida'].'</td>
		<td>'.$row['horas_trabajadas'].'</td>
		<td></td>										
	</tr>';
	
}
$codigoHTML.='
		<tr>
			<td class="derecha" colspan="4"> horas trabajadas</td>
			<td colspan="2">'.$horas_totales.'</td>
		</tr>
		<tr>
			<td colspan="2">
				Elaborado <br> 
				CVG Venalum <br>
				Cargo Analista Atencion a Usuarios <br>
				Nombre y Apellido <br>
				Jesus Lopez <br>
				firma <br>
				N° Personal:10087558 <br>
				Fecha: '.$fecha.'<br>
			</td>
			<td colspan="2">
				Conforme <br>
				Contratista <br>
				Nombre y Apellido <br>
				Raul Prieto <br>
				Firma: <br>
				C.I 13.089.040 <br>
				Fecha: '.$fecha.'<br>
			</td>
			<td colspan="2">
				CVG Venalum (Supervisor Inmediato) <br>
				Cargo <br>
				Jefe Div Centro Atencion a Usuario (E) <br>
				Nombre y Apellido <br>
				Jose Newman <br>
				Firma <br>
				N° Personal:10005085 <br>
				Fecha: '.$fecha.'<br>
			</td>
		</tr>
</table>
</body>
</html>';

if ($opcion==1) {
	$boton="<tr><td class='menuBloque'><a class='botonLateral' href='../site/index2.php?item=701'>REGRESAR</a></td></tr>";
	echo $boton;
	echo $codigoHTML;
}elseif ($opcion==2) {
	$codigoHTML=utf8_encode($codigoHTML);
	$dompdf=new DOMPDF();
	$dompdf->load_html($codigoHTML);
	ini_set("memory_limit","128M");
	$dompdf->render();
	$dompdf->stream("Reporte_asistencias.pdf");
}else{
	echo "LA OPCION NO PUDO SER PROCESADA";
}
?>