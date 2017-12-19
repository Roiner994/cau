<?php
//Puntos Pendientes Administracion
require_once("conexionsql.php");
class puntoPendiente {
	private $idPuntoPendiente,
	$configuracion,
	$fechaAsociacion,
	$idDetallePendiente,
	$idTipoPendiente,
	$observacion,
	$idEstado,
	$idUss;

	function __construct($idPuntoPendiente="",$configuracion="",$fechaAsociacion="",$idDetallePendiente="",$idTipoPendiente="",$observacion="",$idEstado="",$idUss="") {
		$this->idPuntoPendiente=$idPuntoPendiente;
		$this->configuracion=$configuracion;
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$this->idDetallePendiente=$idDetallePendiente;
		$this->idTipoPendiente=$idTipoPendiente;
		$this->observacion=$observacion;
		$this->idEstado=$idEstado;
		$this->idUss=$idUss;	
	}
	
	function setPuntoPendiente($idPuntoPendiente="",$configuracion="",$fechaAsociacion="") {
		$this->idPuntoPendiente=$idPuntoPendiente;
		$this->configuracion=$configuracion;
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
	}
	function setDetallePuntoPendiente($idDetallePendiente="",$idTipoPendiente="",$observacion="",$idEstado="",$idUss="") {
		$this->idDetallePendiente=$idDetallePendiente;
		$this->idTipoPendiente=$idTipoPendiente;
		$this->observacion=$observacion;
		$this->idEstado=$idEstado;
		$this->idUss=$idUss;
	}
	
	function nuevoIdPuntoPendiente() {
		$conUltimo="select id_punto_pendiente from punto_pendiente order by id_punto_pendiente desc limit 1";
		$cons=new consecutivo("IPP",$conUltimo);
		$this->idPuntoPendiente=$cons->retornar();
	}
	function nuevoIdDetallePuntoPendiente() {
		$conUltimo="select id_detalle_pendiente from detalle_punto_pendiente order by id_detalle_pendiente desc limit 1";
		$cons=new consecutivo("IDP",$conUltimo);
		$this->idDetallePendiente=$cons->retornar();
	}
	
	function ingresarPuntoPendiente() {
		$this->nuevoIdPuntoPendiente();
		$conInsertar="insert into punto_pendiente values ('$this->idPuntoPendiente','$this->configuracion','$this->fechaAsociacion')";
		conectarMysql();
		$result=mysql_query($conInsertar);
		mysql_close();
		if ($result) {
			$resultDetalle=$this->ingresarDetallePuntoPendiente();
			if ($resultDetalle==1) {
				$this->deshacerPuntoPendiente();
				return 1;	
			}
			return 0;	
		} else {
			return 1;				
		}
	}
	function ingresarDetallePuntoPendiente() {
		$this->nuevoIdDetallePuntoPendiente();
		$conInsertar="insert into detalle_punto_pendiente values ('$this->idDetallePendiente','$this->idPuntoPendiente','$this->idTipoPendiente','$this->observacion',0,'$this->idUss','$this->fechaAsociacion',1)";
		conectarMysql();
		$result=mysql_query($conInsertar);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;	
		}
	}
	function actualizarDetallePuntoPendiente() {
		$this->nuevoIdDetallePuntoPendiente();
		$conInsertar="insert into detalle_punto_pendiente values ('$this->idDetallePendiente','$this->idPuntoPendiente','$this->idTipoPendiente','$this->observacion',1,'$this->idUss','$this->fechaAsociacion',1)";
		$conDeshacerAnterior="update detalle_punto_pendiente set status_actual=0 where id_punto_pendiente='$this->idPuntoPendiente' and id_detalle_pendiente<>'$this->idDetallePendiente'";
		conectarMysql();
		$result=mysql_query($conInsertar);
		mysql_close();
		if ($result) {
			conectarMysql();
			$resultado=mysql_query($conDeshacerAnterior);
			mysql_close();
			return 0;	
		} else {
			return 1;	
		}		
	}
	
	
	function deshacerPuntoPendiente() {
		$conEliminar="delete from punto_pendiente where id_pendiente='$this->idPuntoPendiente'";
		conectarMysql();
		$result=mysql_query($conEliminar);
		mysql_close();
	}
	function retornarPuntosPendientes($fechaInicial="",$fechaFinal="",$idSitio="") {
		
		if ($idSitio==100)
			$idSitio="";
		
		$rangoFecha="";
		if ((isset($fechaInicial) && !empty($fechaInicial)) && (isset($fechaFinal) && !empty($fechaFinal))) {
		 	$fechaInicial=substr($fechaInicial,6,6)."-".substr($fechaInicial,3,2)."-".substr($fechaInicial,0,2);
		 	$fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
			$rangoFecha=" detalle_punto_pendiente.FECHA_ASOCIACION Between '$fechaInicial' AND '$fechaFinal' AND ";
		}
		
		$consulta="Select
			punto_pendiente.ID_PUNTO_PENDIENTE,
			punto_pendiente.CONFIGURACION,
			punto_pendiente.FECHA_ASOCIACION,
			detalle_punto_pendiente.ID_DETALLE_PENDIENTE,
			detalle_punto_pendiente.ID_TIPO_PENDIENTE,
			tipo_punto_pendiente.NOMBRE_PUNTO_PENDIENTE,
			detalle_punto_pendiente.OBSERVACION,
			detalle_punto_pendiente.ID_ESTADO,
			detalle_punto_pendiente.ID_USS,
			usuario_sistema.NOMBRE,
			usuario_sistema.APELLIDO,
			date_format(detalle_punto_pendiente.FECHA_ASOCIACION,'%d/%m/%Y') AS FECHA_ASOCIACION,
			gerencia.ID_GERENCIA,
			gerencia.GERENCIA,
			division.ID_DIVISION,
			division.DIVISION,
			departamento.ID_DEPARTAMENTO,
			departamento.DEPARTAMENTO,
			sitio.ID_SITIO,
			sitio.SITIO,
			inventario_ubicacion.STATUS_ACTUAL
			From
			punto_pendiente
			Inner Join detalle_punto_pendiente ON punto_pendiente.ID_PUNTO_PENDIENTE = detalle_punto_pendiente.ID_PUNTO_PENDIENTE
			Inner Join usuario_sistema ON detalle_punto_pendiente.ID_USS = usuario_sistema.ID_USS
			Inner Join tipo_punto_pendiente ON detalle_punto_pendiente.ID_TIPO_PENDIENTE = tipo_punto_pendiente.ID_TIPO_PENDIENTE
			Inner Join equipo_campo ON punto_pendiente.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join inventario_ubicacion ON equipo_campo.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO
			Inner Join departamento ON inventario_ubicacion.ID_DEPARTAMENTO = departamento.ID_DEPARTAMENTO
			Inner Join division ON departamento.ID_DIVISION = division.ID_DIVISION
			Inner Join gerencia ON division.ID_GERENCIA = gerencia.ID_GERENCIA
			Inner Join sitio ON inventario_ubicacion.ID_SITIO = sitio.ID_SITIO 
			Where
			$rangoFecha
			punto_pendiente.ID_PUNTO_PENDIENTE like '%$this->idPuntoPendiente' AND
			detalle_punto_pendiente.ID_ESTADO = $this->idEstado AND
			punto_pendiente.CONFIGURACION like '%$this->configuracion' AND
			detalle_punto_pendiente.ID_TIPO_PENDIENTE like '%$this->idTipoPendiente' AND
			sitio.id_sitio like '%$idSitio%' and
			detalle_punto_pendiente.STATUS_ACTUAL =1 and inventario_ubicacion.STATUS_ACTUAL = '1'
			Order By
			detalle_punto_pendiente.FECHA_ASOCIACION Desc
		";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;	
		}
	}
	
	function retornarCantidadPuntosPendientes($fechaInicial="",$fechaFinal="",$idSitio="") {
		
		if ($idSitio==100)
			$idSitio="";
		
		$rangoFecha="";
		if ((isset($fechaInicial) && !empty($fechaInicial)) && (isset($fechaFinal) && !empty($fechaFinal))) {
		 	$fechaInicial=substr($fechaInicial,6,6)."-".substr($fechaInicial,3,2)."-".substr($fechaInicial,0,2);
		 	$fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
			$rangoFecha=" detalle_punto_pendiente.FECHA_ASOCIACION Between '$fechaInicial' AND '$fechaFinal' AND ";
		}
		
		$consulta="	Select
						punto_pendiente.CONFIGURACION,
						Count(punto_pendiente.ID_PUNTO_PENDIENTE)
					From
						punto_pendiente
						Inner Join detalle_punto_pendiente ON punto_pendiente.ID_PUNTO_PENDIENTE = detalle_punto_pendiente.ID_PUNTO_PENDIENTE
						Inner Join tipo_punto_pendiente ON detalle_punto_pendiente.ID_TIPO_PENDIENTE = tipo_punto_pendiente.ID_TIPO_PENDIENTE
					Where
						punto_pendiente.ID_PUNTO_PENDIENTE like '%$this->idPuntoPendiente' AND
						detalle_punto_pendiente.ID_ESTADO = $this->idEstado AND
						detalle_punto_pendiente.ID_TIPO_PENDIENTE like '%$this->idTipoPendiente' AND
						detalle_punto_pendiente.STATUS_ACTUAL =1
					Group By
						punto_pendiente.CONFIGURACION
		";
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

class tipoPuntoPendiente {
	private $idTipoPuntoPendiente,
	$puntoPendiente;

	function __construct($idTipoPuntoPendiente="",$puntoPendiente="") {
		$this->idTipoPuntoPendiente=$idTipoPuntoPendiente;
		$this->puntoPendiente=strtoupper($puntoPendiente);	
	}
	function setPuntoPendiente($idTipoPuntoPendiente="",$puntoPendiente="") {
		$this->idTipoPuntoPendiente=$idTipoPuntoPendiente;
		$this->puntoPendiente=strtoupper($puntoPendiente);			
	}
	
	function nuevoIdTipoPendiente() {
		$conUltimo="select ID_TIPO_PENDIENTE from tipo_punto_pendiente order by ID_TIPO_PENDIENTE desc limit 1";
		$cons=new consecutivo("TPP",$conUltimo);
		$this->idTipoPuntoPendiente=$cons->retornar();
	}
	
	function ingresar() {
		$this->nuevoIdTipoPendiente();
		$conIngresar="insert into tipo_punto_pendiente values ('$this->idTipoPuntoPendiente','$this->puntoPendiente')";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;	
		}
	}
	
	
}
?>