<?php
//CLASE GARANTIA
require_once("administracion.php");
class garantia {
	private $idGarantia,
	$idInventario,
	$fechaAsociacion,
	$statusActivo,
	$idGarantiaEstado,
	$fecha_inicio,
	$fecha_final;
	
	function __construct($idGarantia="",$idInventario="",$statusActivo="",$idGarantiaEstado="") {
		$this->idGarantia=$idGarantia;
		$this->idInventario=$idInventario;
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$this->statusActivo=$statusActivo;
		$this->idGarantiaEstado=$idGarantiaEstado;
	}

	function setGarantia($idGarantia="",$idInventario="",$statusActivo="",$idGarantiaEstado="") {
		$this->idGarantia=$idGarantia;
		$this->idInventario=$idInventario;
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$this->statusActivo=$statusActivo;
		$this->idGarantiaEstado=$idGarantiaEstado;
	}	
	
	function nuevoIdGarantia() {
		$conUltimo="SELECT id_garantia FROM garantia ORDER BY id_garantia DESC limit 1";
		$cons=new consecutivo("GAR",$conUltimo);
		$this->idGarantia=$cons->retornar();
	}
		
	function insertarGarantia() {
		$this->nuevoIdGarantia();

		$consulta="insert into garantia (id_garantia,id_inventario,fecha_asociacion,status_activo)
		 values ('$this->idGarantia','$this->idInventario','$this->fechaAsociacion',1)";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			$resultado=$this->insertarDetalleGarantia();
			return 0;
		} else {
			return 1;
		}	
	}
	function insertarDetalleGarantia($idGarantiaEstado='STG0000001') {
		$consulta="insert into detalle_garantia(id_garantia,id_garantia_estado,fecha_asociacion,status_activo) values
		('$this->idGarantia','$idGarantiaEstado','$this->fechaAsociacion',1)";
		
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}	
	}
	
	function retornarEquiposReportados($idGarantiaEstado='STG0000001',$idProveedor="",$serial="",$idDescripcion="",$fecha_inicio="",$fecha_final="") {
		$rangoFecha="";
		if ((isset($fecha_inicio) && !empty($fecha_inicio)) || (isset($fecha_final) && !empty($fecha_final))) {
			$fecha_inicio=substr($fecha_inicio,6,6)."-".substr($fecha_inicio,3,2)."-".substr($fecha_inicio,0,2);
			$fecha_final=substr($fecha_final,6,6)."-".substr($fecha_final,3,2)."-".substr($fecha_final,0,2);
			$rangoFecha=" garantia.FECHA_ASOCIACION Between '$fecha_inicio 00:00:00' AND '$fecha_final 23:59:59' AND ";
		}
		$consulta="Select
		garantia.ID_GARANTIA,
		garantia.ID_INVENTARIO,
		garantia.FECHA_ASOCIACION,
		detalle_garantia.ID_GARANTIA,
		detalle_garantia.ID_GARANTIA_ESTADO,
		garantia_estado.GARANTIA_ESTADO,
		detalle_garantia.FECHA_ASOCIACION,
		detalle_garantia.STATUS_ACTIVO,
		inventario.SERIAL,
		descripcion.ID_DESCRIPCION,
		descripcion.DESCRIPCION,
		descripcion.ID_DESCRIPCION_PROPIEDAD,
		marca.ID_MARCA,
		marca.MARCA,
		modelo.ID_MODELO,
		modelo.MODELO,
		modelo.CAP_VEL,
		modelo.UNIDAD,
		inventario.FRU,
		inventario.PRODUCT_NUMBER,
		inventario.SPARE_NUMBER,
		inventario.CT,
		inventario.FECHA_INICIO,
		inventario.FECHA_FINAL,
		pedido.ID_PEDIDO,
		pedido.ID_PROVEEDOR,
		proveedor.PROVEEDOR,
		proveedor.CONTACTOS,
		proveedor.DIRECCION,
		proveedor.TELEFONO,
		proveedor.STATUS_ACTIVO,
		proveedor.CORREO,
		componente_garantia.CONFIGURACION,
		equipo_campo.ACTIVO_FIJO,
		inventario_equipo.SERIAL,
		descripcion_equipo.ID_DESCRIPCION,
		descripcion_equipo.DESCRIPCION,
		marca_equipo.ID_MARCA,
		marca_equipo.MARCA,
		modelo_equipo.ID_MODELO,
		modelo_equipo.MODELO,
		modelo_equipo.CAP_VEL,
		modelo_equipo.UNIDAD,
		configuracion_equipo.CONFIGURACION,
		configuracion_equipo.ACTIVO_FIJO
		From
		garantia
		Inner Join detalle_garantia ON garantia.ID_GARANTIA = detalle_garantia.ID_GARANTIA
		Inner Join inventario ON garantia.ID_INVENTARIO = inventario.ID_INVENTARIO
		Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
		Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
		Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
		Inner Join pedido ON inventario.ID_PEDIDO = pedido.ID_PEDIDO
		Inner Join proveedor ON pedido.ID_PROVEEDOR = proveedor.ID_PROVEEDOR
		Left Join componente_garantia ON inventario.ID_INVENTARIO = componente_garantia.ID_INVENTARIO
		Left Join equipo_campo ON componente_garantia.CONFIGURACION = equipo_campo.CONFIGURACION
		Left Join inventario AS inventario_equipo ON equipo_campo.ID_INVENTARIO = inventario_equipo.ID_INVENTARIO
		Left Join modelo AS modelo_equipo ON inventario_equipo.ID_MODELO = modelo_equipo.ID_MODELO
		Left Join descripcion AS descripcion_equipo ON modelo_equipo.ID_DESCRIPCION = descripcion_equipo.ID_DESCRIPCION
		Left Join marca AS marca_equipo ON modelo_equipo.ID_MARCA = marca_equipo.ID_MARCA
		Inner Join garantia_estado ON detalle_garantia.ID_GARANTIA_ESTADO = garantia_estado.ID_GARANTIA_ESTADO
		Left Join equipo_campo AS configuracion_equipo ON configuracion_equipo.ID_INVENTARIO = garantia.ID_INVENTARIO
			Where
			$rangoFecha 
			descripcion.id_descripcion like '%$idDescripcion' and
			detalle_garantia.ID_GARANTIA_ESTADO like '%' AND
			detalle_garantia.STATUS_ACTIVO = '1' AND
			proveedor.ID_PROVEEDOR Like '%$idProveedor' AND
			inventario.SERIAL Like '%$serial' AND
			detalle_garantia.ID_GARANTIA_ESTADO Like '%$idGarantiaEstado'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;	
		}
	}
	function cambiarStatusGarantia(){
	$garantia=$this->idGarantia;
	
	conectarMysql();
	switch ($this->idGarantiaEstado) {
		case "STG0000002":
			$estado="STG0000001";
			break 1;
		case "STG0000003":
			$estado="STG0000002";
			break 1;
		case "STG0000004":
			$estado="STG0000003";
			break 1;
	}	
	for ($i=0;$i<count($garantia);$i++) {
			
			$conDesactivarEstado="update detalle_garantia set STATUS_ACTIVO=0
		 	where id_garantia='$garantia[$i]' 
		 	and id_garantia_estado='$estado' ";
		
			$conCambiarEstado="insert into detalle_garantia (ID_GARANTIA, ID_GARANTIA_ESTADO,FECHA_ASOCIACION,STATUS_ACTIVO )
			VALUES ('$garantia[$i]','$this->idGarantiaEstado','$this->fechaAsociacion',1)";
		$result=mysql_query($conDesactivarEstado);
		$result=mysql_query($conCambiarEstado);
		
	}
	mysql_close();
	if ($result) {
		return 0;	
	} else {
		return 1;	
	}
}

function cambiarStatusReemplazo(){
	conectarMysql();
		$conDesactivarEstado="update detalle_garantia set STATUS_ACTIVO=0
	 	where id_garantia='$this->idGarantia' 
	 	and id_garantia_estado='STG0000003'";
		$conCambiarEstado="insert into detalle_garantia (ID_GARANTIA, ID_GARANTIA_ESTADO,FECHA_ASOCIACION,STATUS_ACTIVO )
		VALUES ('$this->idGarantia','$this->idGarantiaEstado','$this->fechaAsociacion',1)";
		$result=mysql_query($conDesactivarEstado);
	mysql_close();
	if ($result) {
		return 0;	
	} else {
		return 1;	
	}
}
	
}


?>