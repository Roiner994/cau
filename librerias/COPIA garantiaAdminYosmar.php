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
	$pedido;
	
	function garantia($idGarantia="",$idInventario="",$statusGarantia="",$fechaReportado="",$fechaSalida="",$fechaFueraPlanta="",$fechaRemplazo="",
	$fechaInicio="",$fechaFinal="",$serial="",$proveedor="",$pedido="") {
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
		//echo "$proveedor";
		//echo"$statusGarantia";
		
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


function buscar1() {
	
	switch ($_POST[selStatus]) {
		case 'STG0000001':
			$fechaDe="garantia.fecha_reportado";
			$conBuscar1="select garantia.id_garantia, garantia.id_inventario,serial,pedido.id_proveedor,proveedor.proveedor,inventario.id_descripcion,descripcion.descripcion, inventario.id_marca,marca.marca,
		inventario.id_modelo,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
		garantia.fecha_reportado, inventario.fecha_inicio,inventario.fecha_final
		,garantia.id_estatus_garantia,status_garantia.estatus_garantia,
		equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion
		from garantia inner join inventario on garantia.id_inventario=inventario.id_inventario
		inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
		inner join marca on inventario.id_marca=marca.id_marca
		inner join modelo on inventario.id_modelo=modelo.id_modelo
		inner join pedido on inventario.id_pedido=pedido.id_pedido
		inner join proveedor on pedido.id_proveedor=proveedor.id_proveedor
		left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
		left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
		inner join status_garantia on garantia.id_estatus_garantia=status_garantia.id_estatus_garantia
		where garantia.id_estatus_garantia='$_POST[selStatus]'
		

		ORDER BY PROVEEDOR.PROVEEDOR ";
			break 1;
		case 'STG0000002':
			$fechaDe="garantia.fecha_salida";
			$conBuscar1="select garantia.id_garantia, garantia.id_inventario,serial,pedido.id_proveedor,proveedor.proveedor,inventario.id_descripcion,descripcion.descripcion, inventario.id_marca,marca.marca,
		inventario.id_modelo,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
		garantia.fecha_salida, inventario.fecha_inicio,inventario.fecha_final
		,garantia.id_estatus_garantia,status_garantia.estatus_garantia,
		equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion
		from garantia inner join inventario on garantia.id_inventario=inventario.id_inventario
		inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
		inner join marca on inventario.id_marca=marca.id_marca
		inner join modelo on inventario.id_modelo=modelo.id_modelo
		inner join pedido on inventario.id_pedido=pedido.id_pedido
		inner join proveedor on pedido.id_proveedor=proveedor.id_proveedor
		left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
		left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
		inner join status_garantia on garantia.id_estatus_garantia=status_garantia.id_estatus_garantia
		where garantia.id_estatus_garantia='$_POST[selStatus]'
		 

		ORDER BY PROVEEDOR.PROVEEDOR ";
			break 1;
		case 'STG0000003':
			$fechaDe="garantia.fecha_fuera_planta";
			$conBuscar1="select garantia.id_garantia, garantia.id_inventario,serial,pedido.id_proveedor,proveedor.proveedor,inventario.id_descripcion,descripcion.descripcion, inventario.id_marca,marca.marca,
		inventario.id_modelo,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
		garantia.fecha_fuera_planta, inventario.fecha_inicio,inventario.fecha_final
		,garantia.id_estatus_garantia,status_garantia.estatus_garantia,
		equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion
		from garantia inner join inventario on garantia.id_inventario=inventario.id_inventario
		inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
		inner join marca on inventario.id_marca=marca.id_marca
		inner join modelo on inventario.id_modelo=modelo.id_modelo
		inner join pedido on inventario.id_pedido=pedido.id_pedido
		inner join proveedor on pedido.id_proveedor=proveedor.id_proveedor
		left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
		left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
		inner join status_garantia on garantia.id_estatus_garantia=status_garantia.id_estatus_garantia
		where garantia.id_estatus_garantia='$_POST[selStatus]'
		 

		ORDER BY PROVEEDOR.PROVEEDOR ";
			break 1;
		case 'STG0000004':
			$fechaDe="garantia.fecha_reemplazo";
			
			$conBuscar1="select garantia.id_garantia, garantia.id_inventario,serial,pedido.id_proveedor,proveedor.proveedor,inventario.id_descripcion,descripcion.descripcion, inventario.id_marca,marca.marca,
		inventario.id_modelo,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
		garantia.fecha_reemplazo, inventario.fecha_inicio,inventario.fecha_final
		,garantia.id_estatus_garantia,status_garantia.estatus_garantia,
		equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion
		from garantia inner join inventario on garantia.id_inventario=inventario.id_inventario
		inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
		inner join marca on inventario.id_marca=marca.id_marca
		inner join modelo on inventario.id_modelo=modelo.id_modelo
		inner join pedido on inventario.id_pedido=pedido.id_pedido
		inner join proveedor on pedido.id_proveedor=proveedor.id_proveedor
		left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
		left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
		inner join status_garantia on garantia.id_estatus_garantia=status_garantia.id_estatus_garantia
		where garantia.id_estatus_garantia='$_POST[selStatus]'
		

		ORDER BY PROVEEDOR.PROVEEDOR ";
			break 1;
		case '100':
		
		if ($this->statusGarantia='STG0000001') {
			$conBuscar1="select garantia.id_garantia, garantia.id_inventario,serial,pedido.id_proveedor,proveedor.proveedor,inventario.id_descripcion,descripcion.descripcion, inventario.id_marca,marca.marca,
		inventario.id_modelo,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
		garantia.fecha_reportado, inventario.fecha_inicio,inventario.fecha_final
		,garantia.id_estatus_garantia,status_garantia.estatus_garantia,
		equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion
		from garantia inner join inventario on garantia.id_inventario=inventario.id_inventario
		inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
		inner join marca on inventario.id_marca=marca.id_marca
		inner join modelo on inventario.id_modelo=modelo.id_modelo
		inner join pedido on inventario.id_pedido=pedido.id_pedido
		inner join proveedor on pedido.id_proveedor=proveedor.id_proveedor
		left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
		left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
		inner join status_garantia on garantia.id_estatus_garantia=status_garantia.id_estatus_garantia
		  
		
		ORDER BY PROVEEDOR.PROVEEDOR ";
			break 1;
			
		}
		
	}

	
	
	//echo "$conBuscar1";
	conectarMysql();
			$result=mysql_query($conBuscar1);
			if($result) {
				$this->total=mysql_num_rows($result);
				mysql_close();
				return $result;	
			}	else {
				mysql_close();
				return 1;	
			}

}
//FUNCION BUSCAR POR PROVEEDOR
function buscar() {
	$conBuscar="select garantia.id_garantia, garantia.id_inventario,serial,pedido.id_proveedor,proveedor.proveedor,inventario.id_descripcion,descripcion.descripcion, inventario.id_marca,marca.marca,
inventario.id_modelo,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
garantia.fecha_reportado, inventario.fecha_inicio,inventario.fecha_final
,garantia.id_estatus_garantia,status_garantia.estatus_garantia,
equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion
from garantia inner join inventario on garantia.id_inventario=inventario.id_inventario
inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
inner join marca on inventario.id_marca=marca.id_marca
inner join modelo on inventario.id_modelo=modelo.id_modelo
inner join pedido on inventario.id_pedido=pedido.id_pedido
inner join proveedor on pedido.id_proveedor=proveedor.id_proveedor
left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
inner join status_garantia on garantia.id_estatus_garantia=status_garantia.id_estatus_garantia
where proveedor.id_proveedor like '%$this->proveedor' and garantia.id_estatus_garantia like '%$this->statusGarantia' 
	ORDER BY garantia.FECHA_REPORTADO ";
	//echo "$conBuscar";
	conectarMysql();
			$result=mysql_query($conBuscar);
			if($result) {
				$this->total=mysql_num_rows($result);
				mysql_close();
				return $result;	
			}	else {
				mysql_close();
				return 1;	
			}

		}


function buscar4() {			
$fechaDe="garantia.fecha_reportado";
$conBuscar="select garantia.id_garantia, garantia.id_inventario,serial,pedido.id_proveedor,proveedor.proveedor,inventario.id_descripcion,descripcion.descripcion, inventario.id_marca,marca.marca,
inventario.id_modelo,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
garantia.fecha_reportado, inventario.fecha_inicio,inventario.fecha_final,
garantia.fecha_salida,fecha_fuera_planta,fecha_remplazo
,garantia.id_estatus_garantia,status_garantia.estatus_garantia,
equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion,
datediff(fecha_salida,fecha_reportado) as diferencia1,
datediff(fecha_fuera_planta,fecha_salida) as diferencia2,
datediff(fecha_remplazo,fecha_fuera_planta) as diferencia3,
datediff(fecha_remplazo,fecha_salida) as diferencia4
from garantia inner join inventario on garantia.id_inventario=inventario.id_inventario
inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
inner join marca on inventario.id_marca=marca.id_marca
inner join modelo on inventario.id_modelo=modelo.id_modelo
inner join pedido on inventario.id_pedido=pedido.id_pedido
inner join proveedor on pedido.id_proveedor=proveedor.id_proveedor
left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
inner join status_garantia on garantia.id_estatus_garantia=status_garantia.id_estatus_garantia
 where inventario.serial like '%$this->serial' and proveedor.id_proveedor like '%$this->proveedor' 
 
  
	ORDER BY garantia.FECHA_REPORTADO ";
	
	//echo "$this->proveedor";
	//echo "$conProveedor";
	//echo "$_POST[fechas]";
	
	conectarMysql();
			$result=mysql_query($conBuscar);
			if($result) {
				$this->total=mysql_num_rows($result);
				mysql_close();
				return $result;	
			}	else {
				mysql_close();
				return 1;	
			}
			
			
		
	

}
//FUNCION BUSCAR EQUIPO Y COMPONENTES FUERA DE PLANTA
function equipoFueraPlanta() {
	
	$conEquipoFueraPlanta="select garantia.id_garantia, garantia.id_inventario,serial,pedido.id_proveedor,proveedor.proveedor,inventario.id_descripcion,descripcion.descripcion, inventario.id_marca,marca.marca,
inventario.id_modelo,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
garantia.fecha_reportado, inventario.fecha_inicio,inventario.fecha_final,
garantia.fecha_salida,fecha_fuera_planta,fecha_remplazo
,garantia.id_estatus_garantia,status_garantia.estatus_garantia,
equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion,
datediff(fecha_salida,fecha_reportado) as diferencia1,
datediff(fecha_fuera_planta,fecha_salida) as diferencia2,
datediff(fecha_remplazo,fecha_fuera_planta) as diferencia3,
datediff(fecha_remplazo,fecha_salida) as diferencia4,
descripcion.id_descripcion_propiedad,
EQUIPO_GARANTIA.activo_fijo
from garantia inner join inventario on garantia.id_inventario=inventario.id_inventario
inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
inner join marca on inventario.id_marca=marca.id_marca
inner join modelo on inventario.id_modelo=modelo.id_modelo
inner join pedido on inventario.id_pedido=pedido.id_pedido
inner join proveedor on pedido.id_proveedor=proveedor.id_proveedor
left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
inner join status_garantia on garantia.id_estatus_garantia=status_garantia.id_estatus_garantia
 where inventario.serial like '%$this->serial' and proveedor.id_proveedor='$this->proveedor'
and garantia.id_estatus_garantia='STG0000003' 
 
  
	ORDER BY inventario.serial";
	//echo "$conBuscar";
	conectarMysql();
			$result=mysql_query($conEquipoFueraPlanta);
			if($result) {
				$this->total=mysql_num_rows($result);
				mysql_close();
				return $result;	
			}	else {
				mysql_close();
				return 1;	
			}

		}

//FUNCION BUSCAR EQUIPO Y COMPONENTES FUERA DE PLANTA ppppppppppppppppp
function equipoFueraPlantaPrueba() {
	
	$conEquipoFueraPlanta2="SELECT garantia_prueba.id_garantia,garantia_prueba.id_inventario,inventario.SERIAL,
pedido.id_pedido, pedido.id_proveedor, proveedor.proveedor,
marca.marca, descripcion.descripcion,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
inventario.fecha_inicio,fecha_final,
equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion,
equipo_garantia.activo_fijo
FROM GARANTIA_PRUEBA
inner join inventario on garantia_prueba.id_inventario=inventario.id_inventario
inner join pedido on inventario.id_pedido=pedido.id_pedido
inner join proveedor on pedido.id_proveedor= proveedor.id_proveedor
inner join marca on inventario.id_marca= marca.id_marca
inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
inner join modelo on inventario.id_modelo=modelo.id_modelo
left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
inner join garantia_estado on garantia_prueba.id_garantia=garantia_estado.id_garantia
 where inventario.serial like '%$this->serial' and proveedor.id_proveedor='$this->proveedor'
and (garantia_estado.id_estatus_garantia='STG0000003' and garantia_estado.id_estatus_garantia<>'STG0000004') 
and garantia_prueba.status_activo='1'
 	ORDER BY inventario.serial";
	//echo "$conEquipoFueraPlanta2";
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
		
//FUNCION mostrar equipo seleccionado a reemplazar
function equipoReemplazo() {
	
	$conEquipoFueraPlanta="select garantia.id_garantia, garantia.id_inventario,serial,pedido.id_pedido,pedido.id_proveedor,proveedor.proveedor,inventario.id_descripcion,descripcion.descripcion, inventario.id_marca,marca.marca,
inventario.id_modelo,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
garantia.fecha_reportado, inventario.fecha_inicio,inventario.fecha_final,
garantia.fecha_salida,fecha_fuera_planta,fecha_remplazo
,garantia.id_estatus_garantia,status_garantia.estatus_garantia,
equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion,
equipo_garantia.id_inventario,
datediff(fecha_salida,fecha_reportado) as diferencia1,
datediff(fecha_fuera_planta,fecha_salida) as diferencia2,
datediff(fecha_remplazo,fecha_fuera_planta) as diferencia3,
datediff(fecha_remplazo,fecha_salida) as diferencia4,
garantia.id_garantia,
EQUIPO_GARANTIA.activo_fijo
from garantia inner join inventario on garantia.id_inventario=inventario.id_inventario
inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
inner join marca on inventario.id_marca=marca.id_marca
inner join modelo on inventario.id_modelo=modelo.id_modelo
inner join pedido on inventario.id_pedido=pedido.id_pedido
inner join proveedor on pedido.id_proveedor=proveedor.id_proveedor
left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
inner join status_garantia on garantia.id_estatus_garantia=status_garantia.id_estatus_garantia
 
 where inventario.serial='$this->serial' 
and garantia.id_estatus_garantia='STG0000003'

order by inventario.serial";
 
//echo "aqui¿¿¿$conEquipoFueraPlanta";
	conectarMysql();
			$result=mysql_query($conEquipoFueraPlanta);
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
	
	$conEquipoFueraPlanta2="SELECT garantia_prueba.id_garantia,garantia_prueba.id_inventario,inventario.SERIAL,
pedido.id_pedido, pedido.id_proveedor, proveedor.proveedor,
marca.marca, descripcion.descripcion,concat(modelo.modelo,' ',cap_vel,' ',unidad) as modelo,
inventario.fecha_inicio,fecha_final,
equipo_garantia.configuracion as confiEquipo,componente_garantia.configuracion,
equipo_garantia.activo_fijo, garantia_prueba.id_garantia,descripcion.id_descripcion
FROM GARANTIA_PRUEBA
inner join inventario on garantia_prueba.id_inventario=inventario.id_inventario
inner join pedido on inventario.id_pedido=pedido.id_pedido
inner join proveedor on pedido.id_proveedor= proveedor.id_proveedor
inner join marca on inventario.id_marca= marca.id_marca
inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
inner join modelo on inventario.id_modelo=modelo.id_modelo
left join equipo_garantia on equipo_garantia.id_inventario=inventario.id_inventario
left join componente_garantia on componente_garantia.id_inventario=inventario.id_inventario
inner join garantia_estado on garantia_prueba.id_garantia=garantia_estado.id_garantia
 where inventario.serial like '%$this->serial'  
and garantia_estado.id_estatus_garantia='STG0000003'


order by inventario.serial";
 
//echo "aqui¿¿¿$conEquipoFueraPlanta2";
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
//FUNCION CAMBIAR ESTATUS EN GARANTIA

function cambiarStatus(){
	
	$conCambiarStatus="SELECT * FROM garantia
inner join inventario on garantia.id_inventario=inventario.id_inventario
where inventario.serial='$serial'";
	echo"$conCambiarStatus";
		conectarMysql();
			$result=mysql_query($conCambiarStatus);
			if($result) {
				id_estatus_garantia=='STG0000004';
				$this->total=mysql_num_rows($result);
				mysql_close();
				return $result;	
			}	else {
				mysql_close();
				return 1;	
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

