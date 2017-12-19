<?php  
	include 'connect.php';

	function buscar_personal($ficha)
	{
		$sql = "SELECT * FROM usuario_sistema WHERE ficha=$ficha";

		$res =mysql_query($sql);

		while ($row = mysql_fetch_array($res)){ 
			$id_personal=$row['ID_USS']; 
		}
		return $id_personal;
	}

	function agregar_Excel($trabajadores)
	{
		$id_fecha=$trabajadores[0]['fecha'];
		$auxiliar=array('fecha' => $trabajadores[0]['fecha']);
		$sql = "INSERT INTO asistencias(fecha)";
				$sql.="VALUES('$fecha_id')";
				$res = mysql_query($sql,$con) or die (mysql_error());
		for ($i=0; $i < count($trabajadores); $i++) {
			if ($trabajadores[$i]['fecha']== $auxiliar['fecha']) {
				$id_fecha=$trabajadores[$i]['fecha'];
				$id_trabajador=$trabajadores[$i]['id_trabajador'];
				$hora_entrada=$trabajadores[$i]['hora_entrada'];
				$hora_salida=$trabajadores[$i]['hora_salida'];
				$horas_trabajadas=$trabajadores[$i]['horas_trabajadas'];
				$sql = "INSERT INTO detalle_asistencias(fecha,id_trabajador,hora_entrada,hora_salida,horas_trabajadas)";
				$sql.="VALUES('$fecha_id','$id_trabajador','$hora_entrada','$hora_salida','$horas_trabajadas')";
				$res = mysql_query($sql,$con) or die (mysql_error());
			 }else{
			 	$id_fecha=$trabajadores[$i]['fecha'];
			 	$sql = "INSERT INTO asistencias(fecha)";
				$sql.="VALUES('$fecha_id')";
				$res = mysql_query($sql,$con) or die (mysql_error());
			 	$i--;
			 }
		}
	}

	function codigo($ficha)
	{
		$sql = "SELECT * FROM usuario_sistema WHERE ficha=$ficha";

		$res =mysql_query($sql);

		while ($row = mysql_fetch_array($res)){ 
			$codigo=$row['codigo']; 
		}
		return $codigo;
	}
?>