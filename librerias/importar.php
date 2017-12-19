<?php

	include 'horas.php';
	include 'connect.php';
	session_start();
	$tabla_trabajadores=$_SESSION['tabla'];
	if (isset($tabla_trabajadores)) {
		$id_fecha=$tabla_trabajadores[0]['fecha'];
		$id_fecha=fecha($id_fecha);
		$id_fecha=strtotime($id_fecha);
		$newformat = date("Y-m-d", $id_fecha);
		$auxiliar=$tabla_trabajadores[0]['fecha'];
		$codigo=$tabla_trabajadores[0]['codigo'];
		$sql = "INSERT INTO asistencias(fecha,codigo)";
		$sql.="VALUES('$newformat','$codigo')";
		$res = mysql_query($sql,$con) or die (mysql_error());
		
		for ($i=0; $i < count($tabla_trabajadores); $i++) {
			if (($tabla_trabajadores[$i]['fecha']!=$auxiliar) || ($tabla_trabajadores[$i]['codigo']!=$codigo)) {
				$auxiliar=$tabla_trabajadores[$i]['fecha'];
				$id_fecha=$tabla_trabajadores[$i]['fecha'];
				$id_fecha=fecha($id_fecha);
				$id_fecha=strtotime($id_fecha);
				$newformat = date("Y-m-d", $id_fecha);
				$codigo=$tabla_trabajadores[$i]['codigo'];
				$sql = "INSERT INTO asistencias(fecha,codigo)";
				$sql.="VALUES('$newformat','$codigo')";
				$res = mysql_query($sql,$con) or die (mysql_error());		
			} 
			$id_trabajador=$tabla_trabajadores[$i]['id_usuario'];
			$hora_entrada=$tabla_trabajadores[$i]['hora_entrada'];
			$hora_salida=$tabla_trabajadores[$i]['hora_salida'];
			$horas_trabajadas=$tabla_trabajadores[$i]['horas_trabajadas'];
			$sql = "INSERT INTO detalle_asistencias(fecha,id_trabajador,hora_entrada,hora_salida,horas_trabajadas,cod)";
			$sql.="VALUES('$newformat','$id_trabajador','$hora_entrada','$hora_salida','$horas_trabajadas','$codigo')";
			$res = mysql_query($sql,$con) or die (mysql_error());
		}
	}
		header ("Location: ../site/index2.php?item=701");
?>