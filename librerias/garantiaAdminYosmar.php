<?php

//CLASE GARANTIA

class garantia {
	private $idGarantia,
	$idInventario,
	$statusGarantia,
	$fechaReportado,
	$fechaSalida,
	$fechaFueraPlanta,
	$fechaRemplazo,
	$fechaInicio,
	$fechaFinal,
	$serial,
	$proveedor,
	$pedido,
	$idEstatusGarantia,
	$fechaAsociacion;
	
	function garantia($idGarantia="",$idInventario="",$statusGarantia="",$fechaReportado="",$fechaSalida="",$fechaFueraPlanta="",$fechaRemplazo="",
	$fechaInicio="",$fechaFinal="",$serial="",$proveedor="",$pedido="",$idEstatusGarantia="",$fechaAsociacion="") {
		$this->idGarantia=$idGarantia;
		$this->idInventario=$idInventario;
		$this->statusGarantia=$statusGarantia;
		$this->fechaReportado=$fechaSalida;
		$this->fechaSalida=$fechaSalida;
		$this->fechaFueraPlanta=$fechaFueraPlanta;
		$this->fechaRemplazo=$fechaRemplazo;
		$this->pedido=$pedido;
		$this->fechaFinal=$fechaFinal;
		$this->serial=$serial;
		$this->proveedor=$proveedor;
		$this->idEstatusGarantia=$idEstatusGarantia;
		$this->fechaAsociacion=$fechaAsociacion;
		
		//convertir fechas
		$this->fechaInicio=$fechaInicio;
		
		$anho=substr($this->fechaInicio,6,6);
		$mes=substr($this->fechaInicio,3,2);
		$dia=substr($this->fechaInicio,0,2);
		$this->fechaInicio=$anho."-".$mes."-".$dia;	
		$this->fechaFinal=$fechaFinal;	

		$anho=substr($this->fechaFinal,6,6);
		$mes=substr($this->fechaFinal,3,2);
		$dia=substr($this->fechaFinal,0,2);
		$this->fechaFinal=$anho."-".$mes."-".$dia;	

	}




//FUNCION BUSCAR EQUIPO Y COMPONENTES FUERA DE PLANTA FORMULARIO REEMPLAZO
function equipoFueraPlantaPrueba() {
	
	$conEquipoFueraPlanta2="Select
		garantia.ID_GARANTIA,
		garantia.ID_INVENTARIO,
		inventario.SERIAL,
		pedido.ID_PEDIDO,
		pedido.ID_PROVEEDOR,
		proveedor.PROVEEDOR,
		marca.MARCA,
		descripcion.DESCRIPCION,
		modelo.MODELO,
		modelo.CAP_VEL,
		modelo.UNIDAD,
		inventario.FECHA_INICIO,
		inventario.FECHA_FINAL,
		equipo_campo.CONFIGURACION,
		componente_garantia.CONFIGURACION,
		equipo_campo.ACTIVO_FIJO,
		descripcion.ID_DESCRIPCION_PROPIEDAD
		From
		garantia
		Inner Join inventario ON garantia.ID_INVENTARIO = inventario.ID_INVENTARIO
		Inner Join pedido ON inventario.ID_PEDIDO = pedido.ID_PEDIDO
		,
		descripcion
		,
		marca
		Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO AND modelo.ID_MARCA = marca.ID_MARCA AND modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
		Inner Join proveedor ON pedido.ID_PROVEEDOR = proveedor.ID_PROVEEDOR
		Left Join equipo_campo ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
		Left Join componente_garantia ON componente_garantia.ID_INVENTARIO = inventario.ID_INVENTARIO
		Inner Join garantia_estado ON garantia.ID_GARANTIA = garantia_estado.ID_GARANTIA
		where inventario.serial like '%$this->serial' and proveedor.id_proveedor='$this->proveedor'
		and (garantia_estado.id_estatus_garantia like '%$this->statusGarantia' and garantia_estado.id_estatus_garantia<>'STG0000004') 
		and GARANTIA_ESTADO.STATUS_ACTIVO='1'
		and garantia.status_activo='1'
		 	ORDER BY inventario.serial";
	conectarMysql();
			$result=mysql_query($conEquipoFueraPlanta2);
			if($result) {
				$this->total=mysql_num_rows($result);
				mysql_close();
				return $result;	
			}	else {
				mysql_close();
				return 1;	
			}

		}
		//FUNCION BUSCAR EQUIPO Y COMPONENTES PARA GENERAR REPORTES
function equipoGarantiaReportar() {
	if (isset($_POST[txtFechaInicio]) && !empty($_POST[txtFechaInicio])) {
$conEquipoFueraPlanta2="SELECT garantia.id_garantia,garantia.id_inventario,inventario.SERIAL,
pedido.id_pedido, pedido.id_proveedor, proveedor.proveedor,marca.marca
, descripcion.descripcion,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
inventario.fecha_inicio,fecha_final,
equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion,
equipo_garantia.activo_fijo,
DESCRIPCION_PROPIEDAD.ID_DESCRIPCION_PROPIEDAD,garantia.id_garantia,
GARANTIA_ESTADO.FECHA_ASOCIACION,GARANTIA_STATUS.ESTATUS_GARANTIA,GARANTIA_ESTADO.ID_ESTATUS_GARANTIA
FROM garantia
inner join inventario on garantia.id_inventario=inventario.id_inventario
inner join pedido on inventario.id_pedido=pedido.id_pedido
inner join proveedor on pedido.id_proveedor= proveedor.id_proveedor
inner join marca on inventario.id_marca= marca.id_marca
inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
inner join modelo on inventario.id_modelo=modelo.id_modelo
left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
inner join garantia_estado on garantia.id_garantia=garantia_estado.id_garantia
INNER JOIN GARANTIA_STATUS ON GARANTIA_ESTADO.ID_ESTATUS_GARANTIA=GARANTIA_STATUS.ID_ESTATUS_GARANTIA
inner join descripcion_propiedad on descripcion.id_descripcion_propiedad=descripcion_propiedad.id_descripcion_propiedad
where inventario.serial like '%$this->serial' and proveedor.id_proveedor='$this->proveedor'
and garantia_estado.id_estatus_garantia like '%$_POST[selStatus]' 
and GARANTIA_ESTADO.STATUS_ACTIVO='1' 
and  garantia_estado.fecha_asociacion between '$this->fechaInicio' and '$this->fechaFinal'

 	ORDER BY inventario.serial";
	conectarMysql();
			$result=mysql_query($conEquipoFueraPlanta2);
			if($result) {
				$this->total=mysql_num_rows($result);
				mysql_close();
				return $result;	
			}	else {
				mysql_close();
				return 1;	
			}
} else {
	$conEquipoFueraPlanta2="SELECT garantia.id_garantia,garantia.id_inventario,inventario.SERIAL,
pedido.id_pedido, pedido.id_proveedor, proveedor.proveedor,marca.marca
, descripcion.descripcion,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
inventario.fecha_inicio,fecha_final,
equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion,
equipo_garantia.activo_fijo,
DESCRIPCION_PROPIEDAD.ID_DESCRIPCION_PROPIEDAD,garantia.id_garantia,
GARANTIA_ESTADO.FECHA_ASOCIACION,GARANTIA_STATUS.ESTATUS_GARANTIA,GARANTIA_ESTADO.ID_ESTATUS_GARANTIA
FROM garantia
inner join inventario on garantia.id_inventario=inventario.id_inventario
inner join pedido on inventario.id_pedido=pedido.id_pedido
inner join proveedor on pedido.id_proveedor= proveedor.id_proveedor
inner join marca on inventario.id_marca= marca.id_marca
inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
inner join modelo on inventario.id_modelo=modelo.id_modelo
left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
inner join garantia_estado on garantia.id_garantia=garantia_estado.id_garantia
INNER JOIN GARANTIA_STATUS ON GARANTIA_ESTADO.ID_ESTATUS_GARANTIA=GARANTIA_STATUS.ID_ESTATUS_GARANTIA
inner join descripcion_propiedad on descripcion.id_descripcion_propiedad=descripcion_propiedad.id_descripcion_propiedad
where inventario.serial like '%$this->serial' and proveedor.id_proveedor='$this->proveedor'
and garantia_estado.id_estatus_garantia like '%$_POST[selStatus]' 
and GARANTIA_ESTADO.STATUS_ACTIVO='1' 

 	ORDER BY inventario.serial";
	conectarMysql();
			$result=mysql_query($conEquipoFueraPlanta2);
			if($result) {
				$this->total=mysql_num_rows($result);
				mysql_close();
				return $result;	
			}	else {
				mysql_close();
				return 1;	
			}
}
		}
//FUNCION MOSTRAR EQUIPOS PARA GENERAR SALIDA
function equipoSalida() {
	$garantia1=$this->idGarantia;
	
	$conSalida="SELECT garantia.id_garantia,garantia.id_inventario,inventario.SERIAL,
pedido.id_pedido, pedido.id_proveedor, proveedor.proveedor,
marca.marca, descripcion.descripcion,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
inventario.fecha_inicio,fecha_final,
equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion,
equipo_garantia.activo_fijo, garantia.id_garantia,descripcion.id_descripcion
FROM garantia
inner join inventario on garantia.id_inventario=inventario.id_inventario
inner join pedido on inventario.id_pedido=pedido.id_pedido
inner join proveedor on pedido.id_proveedor= proveedor.id_proveedor
inner join marca on inventario.id_marca= marca.id_marca
inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
inner join modelo on inventario.id_modelo=modelo.id_modelo
left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
inner join garantia_estado on garantia.id_garantia=garantia_estado.id_garantia
 where garantia.id_garantia in ($this->idGarantia)
 
and GARANTIA_ESTADO.STATUS_ACTIVO='1'
and garantia.status_activo='1'
 	ORDER BY inventario.serial";
	conectarMysql();
			$result=mysql_query($conSalida);
			if($result) {
				$this->total=mysql_num_rows($result);
				mysql_close();
				return $result;	
			}	else {
				mysql_close();
				return 1;	
			}

		
}

		//FUNCION mostrar equipo seleccionado a reemplazar
function equipoReemplazoPrueba() {
	
	$conEquipoFueraPlanta2="SELECT garantia.id_garantia,garantia.id_inventario,inventario.SERIAL,
pedido.id_pedido, pedido.id_proveedor, proveedor.proveedor,
marca.marca, descripcion.descripcion,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
inventario.fecha_inicio,fecha_final,
equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion,
equipo_garantia.activo_fijo, garantia.id_garantia,descripcion.id_descripcion
FROM garantia
inner join inventario on garantia.id_inventario=inventario.id_inventario
inner join pedido on inventario.id_pedido=pedido.id_pedido
inner join proveedor on pedido.id_proveedor= proveedor.id_proveedor
inner join marca on inventario.id_marca= marca.id_marca
inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
inner join modelo on inventario.id_modelo=modelo.id_modelo
left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
inner join garantia_estado on garantia.id_garantia=garantia_estado.id_garantia
 where inventario.serial like '%$this->serial'  
and garantia_estado.id_estatus_garantia='STG0000003'


order by inventario.serial";
 

	conectarMysql();
			$result=mysql_query($conEquipoFueraPlanta2);
			if($result) {
				$this->total=mysql_num_rows($result);
				mysql_close();
				return $result;	
			}	else {
				mysql_close();
				return 1;	
			}

		}

// FUNCION CAMBIAR ESTATUS DE GARANTIA
function cambiarStatusGarantia(){
	$garantia1=$this->idGarantia;
	for ($i=0;$i<count($garantia1);$i++) {
	$this->fechaAsociacion=getdate();
	$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
	.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
	$conCambiarStatus="insert into garantia_estado (ID_GARANTIA, ID_ESTATUS_GARANTIA,FECHA_ASOCIACION,STATUS_ACTIVO )
	   VALUES ('$garantia1[$i]','$this->idEstatusGarantia','$this->fechaAsociacion','1')";
	$conCambiarStatus2="update garantia_estado set STATUS_ACTIVO='0'
 	where id_garantia='$garantia1[$i]' 
 	and id_estatus_garantia='$this->statusGarantia' ";
	conectarMysql();
	$result=mysql_query($conCambiarStatus2);
	$result=mysql_query($conCambiarStatus);
		$affected=mysql_affected_rows();
			mysql_close();
			}
}
//CAMBIAR UBICACION A FUERA DE PLANTA POR GARANTIA EN INVENTARIO_UBICACION

	function ingresarInventarioUbicacion() {
			$garantia1=$this->idGarantia;
		for ($i=0;$i<count($garantia1);$i++) {
		$conUltimo="SELECT ID_INVENTARIO_UBICACION FROM inventario_ubicacion ORDER BY ID_INVENTARIO_UBICACION DESC";
		$cons=new consecutivo("EUB",$conUltimo);
		$this->idInventarioUbicacion=$cons->retornar();
		$ubi=new ubicacion("",$this->idGerencia,$this->idDivision,$this->idDepartamento,$this->idSitio);
		$this->idUbicacion=$ubi->ingresar();
		$this->statusActual='1';
		
		$conInventarioViejo="select id_inventario from garantia where id_garantia='$garantia1[$i]'";
		$result1=mysql_query($conInventarioViejo);
		$row=mysql_fetch_array($result1);
		//$inv=new garantia($conInventarioViejo);
		conectarMysql();
		$conInsertar="INSERT INTO inventario_ubicacion (ID_INVENTARIO_UBICACION,ID_INVENTARIO,
		ID_UBICACION,STATUS_ACTUAL,FECHA_ASOCIACION)
		VALUES ('$this->idInventarioUbicacion','$row[0]','$this->idUbicacion','$this->statusActual','$this->fechaAsociacion')";
		$result=mysql_query($conInsertar);
		$affected=mysql_affected_rows();
		if($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}
	}
	}
function total() {
			return $this->total;

}


}
class status{
	private $idEstatusGarantia,
	$estatusGarantia,
	$stausActivo;
	
	
	function estatus($idEstatusGarantia="",$estatusGarantia="",$statusActivo="") {
		$this->idEstatusGarantia=$idEstatusGarantia;
		$this->estatusGarantia=$estatusGarantia;
		$this->stausActivo=$statusActivo;
	}

//FUNCION MODIFICAR EL ESTATUS DE GARANTIA
		function modificarStatus() {
		
			
				conectarMysql();
				$conModificar="UPDATE STATUS_GARANTIA SET 
				ESTATUS_GARANTIA='$this->ESTATUS_GARANTIA'
				WHERE ID_ESTATUS_GARANTIA IN ($tmp)";
				$result=mysql_query($conModificar);
				$affected=mysql_affected_rows();
				if($affected>0) {
					mysql_close();
					return 0;
				} else {
					mysql_close();
					return 1;
				}
				
		
	}
	
}
?>

