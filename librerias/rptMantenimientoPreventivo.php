<?php
require_once("administracion.php");
class reporteMantenimientos {
	private $fechaInicio,
	$fechaFinal,
	$idSitio,
	$idDepartamento,
	$idGerencia,
	$idDivision,
	$soActualizado,
	$puntoRed,
	$mantCorrectivo,
	$configuracion,
	$ficha,
	$idUss;
	function __construct($fechaInicio="",$fechaFinal="",$idSitio="",$idGerencia="",$idDivision="",$idDepartamento="",$soActualizado=0,
	$puntoRed=0,$mantCorrectivo=1,$configuracion="",$ficha="",$idUss="") {
		$this->fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
		$this->fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
		$this->idSitio=$idSitio;
		$this->idGerencia=$idGerencia;
		$this->idDivision=$idDivision;
		$this->idDepartamento=$IdDepartamento;
		$this->soActualizado=$soActualizado;
		$this->puntoRed=$puntoRed;
		$this->mantCorrectivo=$mantCorrectivo;
		$this->configuracion=$configuracion;
		$this->ficha=$ficha;
		$this->idUss=$idUss;
	}
	function retornarMantenimientosPorEdificios($soActualizado="",$antivirusActualizado="",$red="",$correctivo="") {
		if ($soActualizado==0 || $antivirusActualizado==0) {
			$descrip=" AND (descripcion.ID_DESCRIPCION = 'DES0000001' OR descripcion.ID_DESCRIPCION = 'DES0000042')";
		} else {
			unset($descrip);	
		}
		$consultaSitio="Select distinct
			sitio.ID_SITIO,
			sitio.SITIO
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Where
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.SISTEMA_OPERATIVO LIKE '%$soActualizado' AND
			mantenimiento_preventivo.ANTIVIRUS LIKE '%$antivirusActualizado' AND
			mantenimiento_preventivo.CORRECTIVO LIKE '%$correctivo' AND
			mantenimiento_preventivo.RED LIKE '%$red' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' $descrip
			Order By
			sitio.SITIO Asc";
		conectarMysql();
		$result=mysql_query($consultaSitio);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;	
		}
	}
	function retornarCantidadEquipos($idSitio="",$idDescripcion="",$agruparPor="a") {
		switch ($agruparPor) {
			case "a":
				$agrupar="Group By sitio.ID_SITIO,descripcion.ID_DESCRIPCION";
				break 1;
			case "s":
				$agrupar="Group By sitio.ID_SITIO";
				break 1;
			case "d":
				$agrupar="Group By descripcion.ID_DESCRIPCION";
				break 1;
			default:
				$agrupar="Group By sitio.ID_SITIO,descripcion.ID_DESCRIPCION";
		}

		$consulta="Select
			sitio.ID_SITIO,
			sitio.SITIO,
			Count(mantenimiento_preventivo.CONFIGURACION) AS CANTIDAD,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Where
			sitio.ID_SITIO like '%$idSitio' AND
			descripcion.ID_DESCRIPCION like '%$idDescripcion' AND
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' $agrupar";
		conectarMysql();
		$result=mysql_query($consulta);	
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[2];	
		} else {
			return 0;	
		}
	}
	function totalMantenimientos() {
		$consulta="Select
			Count(mantenimiento_preventivo.CONFIGURACION) AS cantidad
			From
			mantenimiento_preventivo
			Where 
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[0];	
		} else {
			return 0;	
		}
	}
	function soSinActualizar($idSitio="") {
		$consulta="Select
			sitio.ID_SITIO,
			sitio.SITIO,
			Count(mantenimiento_preventivo.CONFIGURACION),
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Where
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
			mantenimiento_preventivo.SISTEMA_OPERATIVO = '0' AND
			sitio.ID_SITIO Like '%$idSitio' AND
			(descripcion.ID_DESCRIPCION = 'DES0000001' OR
			descripcion.ID_DESCRIPCION = 'DES0000042')
			Group By
			sitio.ID_SITIO,
			sitio.SITIO";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[2];	
		} else {
			return 0;	
		}
	}
	function equiposSinRed($idSitio="") {
		$consulta="Select
			sitio.ID_SITIO,
			sitio.SITIO,
			Count(mantenimiento_preventivo.CONFIGURACION)
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Where
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
			mantenimiento_preventivo.RED = '0' AND
			sitio.ID_SITIO LIKE '%$idSitio'
			Group By
			sitio.ID_SITIO,
			sitio.SITIO";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[2];	
		} else {
			return 0;	
		}
	}
	function equiposSinAntivirus($idSitio="") {
		$consulta="Select
			sitio.ID_SITIO,
			sitio.SITIO,
			Count(mantenimiento_preventivo.CONFIGURACION),
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Where
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
			mantenimiento_preventivo.ANTIVIRUS = '0' AND
			sitio.ID_SITIO Like '%$idSitio' AND
			(descripcion.ID_DESCRIPCION = 'DES0000001' OR
			descripcion.ID_DESCRIPCION = 'DES0000042')
			Group By
			sitio.ID_SITIO,
			sitio.SITIO";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[2];	
		} else {
			return 0;	
		}
	}
	function equipoMantCorrectivo($idSitio="") {
		$consulta="Select
			sitio.ID_SITIO,
			sitio.SITIO,
			Count(mantenimiento_preventivo.CONFIGURACION)
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Where
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
			mantenimiento_preventivo.CORRECTIVO = '1' AND
			sitio.ID_SITIO LIKE '%$idSitio'
			Group By
			sitio.ID_SITIO,
			sitio.SITIO";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[2];	
		} else {
			return 0;	
		}
	}
	function cantidadEquipoSinSo() {
		$consulta="Select
		Count(mantenimiento_preventivo.CONFIGURACION)
		From
		mantenimiento_preventivo
		Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
		Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
		Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
		Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
		Where
		mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
		mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
		mantenimiento_preventivo.SISTEMA_OPERATIVO = '0' AND
		(descripcion.ID_DESCRIPCION = 'DES0000001' OR
		descripcion.ID_DESCRIPCION = 'DES0000042')";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[0];	
		} else {
			return 0;	
		}

	}
	function cantidadEquipoSinRed() {
		$consulta="Select
			Count(mantenimiento_preventivo.CONFIGURACION)
			From
			mantenimiento_preventivo
			Where
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
			mantenimiento_preventivo.RED = '0'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[0];	
		} else {
			return 0;	
		}

	}
	function cantidadEquipoSinAntivirus() {
		$consulta="Select
		Count(mantenimiento_preventivo.CONFIGURACION)
		From
		mantenimiento_preventivo
		Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
		Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
		Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
		Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
		Where
		mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
		mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
		mantenimiento_preventivo.ANTIVIRUS = '0' AND
		(descripcion.ID_DESCRIPCION = 'DES0000001' OR
		descripcion.ID_DESCRIPCION = 'DES0000042')";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[0];	
		} else {
			return 0;	
		}

	}
	function cantidadCorrectivos() {
		$consulta="Select
			Count(mantenimiento_preventivo.CONFIGURACION)
			From
			mantenimiento_preventivo
			Where
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
			mantenimiento_preventivo.CORRECTIVO = '1'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[0];	
		} else {
			return 0;	
		}
	}
	function detalleMantenimiento($idSitio="",$so="",$soloComputadoras=0,$antivirus="",$red="",$correctivo="") {
		switch ($soloComputadoras) {
			case 1:
				$descrip=" AND (descripcion.ID_DESCRIPCION = 'DES0000001' OR descripcion.ID_DESCRIPCION = 'DES0000042')";
				break 1;
			default:
				$descrip="";
		}
		$consulta="Select
			mantenimiento_preventivo.ID_MANTENIMIENTO,
			mantenimiento_preventivo.CONFIGURACION,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			mantenimiento_preventivo.ID_USS,
			usuario_sistema.NOMBRE,
			usuario_sistema.APELLIDO,
			mantenimiento_preventivo.FICHA,
			usuario.NOMBRE_USUARIO,
			usuario.APELLIDO_USUARIO,
			usuario.ID_CARGO,
			cargo.CARGO,
			gerencia.ID_GERENCIA,
			gerencia.GERENCIA,
			division.ID_DIVISION,
			division.DIVISION,
			departamento.ID_DEPARTAMENTO,
			departamento.DEPARTAMENTO,
			sitio.ID_SITIO,
			sitio.SITIO,
			usuario.EXTENSION,
			mantenimiento_preventivo.HORA_INICIO,
			mantenimiento_preventivo.HORA_FINAL,
			mantenimiento_preventivo.STATUS_MANTENIMIENTO,
			mantenimiento_preventivo.SISTEMA_OPERATIVO,
			mantenimiento_preventivo.ANTIVIRUS,
			mantenimiento_preventivo.RED,
			mantenimiento_preventivo.TRABAJO_REALIZADO,
			mantenimiento_preventivo.OBSERVACION,
			mantenimiento_preventivo.PENDIENTE,
			mantenimiento_preventivo.PUNTO_PENDIENTE,
			mantenimiento_preventivo.CORRECTIVO,
			mantenimiento_preventivo.TRABAJO_CORRECTIVO
			From
			mantenimiento_preventivo
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			,
			marca
			Inner Join modelo ON modelo.ID_MODELO = inventario.ID_MODELO AND marca.ID_MARCA = modelo.ID_MARCA
			Inner Join descripcion ON descripcion.ID_DESCRIPCION = modelo.ID_DESCRIPCION
			Inner Join departamento ON mantenimiento_preventivo.ID_DEPARTAMENTO = departamento.ID_DEPARTAMENTO
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Inner Join usuario_sistema ON mantenimiento_preventivo.ID_USS = usuario_sistema.ID_USS
			Inner Join usuario ON mantenimiento_preventivo.FICHA = usuario.FICHA
			Inner Join cargo ON usuario.ID_CARGO = cargo.ID_CARGO
			,
			gerencia
			Inner Join division ON division.ID_DIVISION = departamento.ID_DIVISION AND division.ID_GERENCIA = gerencia.ID_GERENCIA
			WHERE
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
			mantenimiento_preventivo.ID_SITIO LIKE '%$idSitio' AND
			mantenimiento_preventivo.ANTIVIRUS LIKE '%$antivirus' AND
			mantenimiento_preventivo.RED LIKE '%$red' AND
			mantenimiento_preventivo.CORRECTIVO LIKE '%$correctivo' AND
			mantenimiento_preventivo.SISTEMA_OPERATIVO LIKE '%$so' $descrip
			Order By
			sitio.SITIO Asc,
			descripcion.DESCRIPCION Asc,
			mantenimiento_preventivo.CONFIGURACION Asc";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;	
		}
	}	
	
}
?>
<?php
$fechaInicial='01/03/2006';
$fechaFinal='01/04/2006';



echo "<table border=1>
<tr>
<td colspan=\"8\">RESUMEN DE MANTENIMIENTOS POR EDIFICIOS</td>
</tr>";
echo "<tr>
<td>EDIFICIO</td>
<td>COMPUTADORAS</td>
<td>IMPRESORAS</td>
<td>LAPTOP</td>
<td>S.O SIN ACTUALIZAR</td>
<td>EQUIPOS SIN RED</td>
<td>ANTIVIRUS SIN ACTUALIZAR</td>
<td>MANTTO CORRECTIVO</td>
</tr>";
$mantenimiento= new reporteMantenimientos($fechaInicial,$fechaFinal);
$Sitios=$mantenimiento->retornarMantenimientosPorEdificios();
while ($row=mysql_fetch_array($Sitios)) {
echo "<tr>";
echo "<td>$row[1]</td>
<td>".$mantenimiento->retornarCantidadEquipos($row[0],'DES0000001')."</td>
<td>".$mantenimiento->retornarCantidadEquipos($row[0],'DES0000008')."</td>
<td>".$mantenimiento->retornarCantidadEquipos($row[0],'DES0000042')."</td>
<td>".$mantenimiento->soSinActualizar($row[0])."</td>
<td>".$mantenimiento->equiposSinRed($row[0])."</td>
<td>".$mantenimiento->equiposSinAntivirus($row[0])."</td>
<td>".$mantenimiento->equipoMantCorrectivo($row[0])."</td>";
echo "</tr>";
}

echo "<tr>";
echo "<td>TOTAL</td>
<td>".$mantenimiento->retornarCantidadEquipos("","DES0000001","d")."</td>
<td>".$mantenimiento->retornarCantidadEquipos($row[0],'DES0000008',"d")."</td>
<td>".$mantenimiento->retornarCantidadEquipos($row[0],'DES0000042',"d")."</td>
<td>".$mantenimiento->cantidadEquipoSinSo()."</td>
<td>".$mantenimiento->cantidadEquipoSinRed()."</td>
<td>".$mantenimiento->cantidadEquipoSinAntivirus()."</td>
<td>".$mantenimiento->cantidadCorrectivos()."</td>";
echo "</tr>";

echo "</table>";
?>