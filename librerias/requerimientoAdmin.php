<?php
require_once("conexionsql.php");
require_once("administracion.php");
class requerimientoHardware {
	
	//Atributos RequerimientoHardware
	
	private $idRequerimiento,
	$ficha,
	$idUss,
	$fechaAsociacion;
	
	
	//Atributos Detalle Requerimientos Hardware
	private $idDetalleRequerimiento,
	$idDescripcion,
	$descripcionDetalle,
	$idRequerimientoMotivo,
	$idRequerimientoEstado,
	$statusActual;
	
	function requerimientoHardware($idRequerimiento="",$ficha="",$idUss="",$idDetalleRequerimiento="",$idDescripcion="",
	$descripcionDetalle="",$idRequerimientoMotivo="",$idRequerimientoEstado="",$statusActual=0) {
		
		$this->idRequerimiento=$idRequerimiento;
		$this->ficha=$ficha;
		$this->idUss=$idUss;
		
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		
		$this->idDetalleRequerimiento=$idDetalleRequerimiento;
		$this->idDescripcion=$idDescripcion;
		$this->descripcionDetalle=$descripcionDetalle;
		$this->idRequerimientoMotivo=$idRequerimientoMotivo;
		$this->idRequerimientoEstado=$idRequerimientoEstado;
		$this->statusActual=$statusActual;
	}
	
	
	function setRequerimientoHardware($idRequerimiento="",$ficha="",$idUss="") {
		$this->idRequerimiento=$idRequerimiento;
		$this->ficha=$ficha;
		$this->idUss=$idUss;
		
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
	}
	
	function setDetalleRequerimiento($idDetalleRequerimiento="",$idDescripcion="",$descripcionDetalle="",$idRequerimientoMotivo="",$idRequerimientoEstado="",$statusActual=0) {
		$this->idDetalleRequerimiento=$idDetalleRequerimiento;
		$this->idDescripcion=$idDescripcion;
		$this->descripcionDetalle=strtoupper($descripcionDetalle);
		$this->idRequerimientoMotivo=$idRequerimientoMotivo;
		$this->idRequerimientoEstado=$idRequerimientoEstado;
		$this->statusActual=$statusActual;
	}
	
	function nuevoIdRequerimiento() {
		$conUltimo="select id_requerimiento from requerimiento_equipo order by id_requerimiento desc limit 1";
		$cons=new consecutivo("SOL",$conUltimo);
		$this->idRequerimiento=$cons->retornar();
	}
	
	function nuevoIdDetalleRequerimiento() {
		$conUltimo="select id_detalle_requerimiento from detalle_requerimiento_equipo order by id_detalle_requerimiento desc limit 1";
		$cons=new consecutivo("SOL",$conUltimo);
		$this->idDetalleRequerimiento=$cons->retornar();
	}	
	
	function retornaIdRequerimiento() {
		return $this->idRequerimiento;
	}
	
	function ingresar() {

		if (isset($this->idRequerimiento) && !empty($this->idRequerimiento)) {
			if($this->ingresarDetalle()==0) {
				return 0;
			} else {
				return 1;
			}
		} else {
			if ($this->ingresarRequerimiento()==0) {
				$resultado=$this->ingresarDetalle();
				if ($resultado==0) {
					return 0;
				} else {
					return 1;
				}
			} else {
				return 1;
			}
		}
		
	}

	function ingresarRequerimiento() {
		$this->nuevoIdRequerimiento();
		$conInsertar="insert into requerimiento_equipo (id_requerimiento,ficha,id_uss,fecha_asociacion) values
		('$this->idRequerimiento','$this->ficha','$this->idUss','$this->fechaAsociacion')";
	
		conectarMysql();
		$result=mysql_query($conInsertar);
		$affected=mysql_affected_rows();
		mysql_close();
		
		if ($result && $affected>0) {
			return 0;
		} else {
			return 1;
		}
	}
	
	function ingresarDetalle() {
		$this->nuevoIdDetalleRequerimiento();
		$conInsertar="insert into detalle_requerimiento_equipo (id_detalle_requerimiento,id_requerimiento,id_descripcion,descripcion_detalle,id_uss,
		fecha_asociacion,id_requerimiento_motivo,id_estado_requerimiento) 
		values ('$this->idDetalleRequerimiento','$this->idRequerimiento','$this->idDescripcion','$this->descripcionDetalle','$this->idUss','$this->fechaAsociacion','$this->idRequerimientoMotivo','$this->idRequerimientoEstado')";
	
		conectarMysql();
		$result=mysql_query($conInsertar);
		$affected=mysql_affected_rows();
		mysql_close();
		
		if ($result && $affected>0) {
			return 0;
		} else {
			return 1;
		}
	}
	
	function mostrarRequerimientoPorId() {
		$consulta="select * from vistarequerimientosequipos where id_detalle_requerimiento='$this->idDetalleRequerimiento'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
		
	}
	
	function buscarRequerimiento($idSitio="",$idGerencia="", $idDescripcion="",$idEstadoRequerimiento="",$idRequerimientoMotivo="",$idUss="",$fechaInicio="",$fechaFinal="",$ficha="") {
		//100 Esto todo. Se reemplaza 100 por vacio.
		if($idSitio==100) $idSitio="";
		
		if($idGerencia==100) $idGerencia="";
		
		if($idDescripcion==100) $idDescripcion="";
		
		if($idEstadoRequerimiento==100) $idEstadoRequerimiento="";
		
		if ($idRequerimientoMotivo==100) $idRequerimientoMotivo="";
		
		if ($idUss==100) $idUss="";
		
		
		if ((isset($fechaInicio) && !empty($fechaInicio)) && (isset($fechaFinal) && !empty($fechaFinal))) {

			$fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
			$fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
			
			$fecha=" and fecha_asociacion between '$fechaInicio' and '$fechaFinal'";
		}
		
		if (isset($ficha) && !empty($ficha)) {
			$conFicha=" AND (FICHA like '%$ficha' OR NOMBRE_USUARIO like '%$ficha%' OR APELLIDO_USUARIO like '%$ficha%')  ";
		}
		$consulta="select * from vistarequerimientosequipos where id_requerimiento like '%$this->idRequerimiento%' and
		id_sitio like '%$idSitio%' and id_gerencia like '%$idGerencia%' and id_descripcion like '%$idDescripcion%' and 
		id_estado_requerimiento like '%$idEstadoRequerimiento%' and id_requerimiento_motivo like '%$idRequerimientoMotivo%' and id_uss like '%$idUss%' $fecha $conFicha order by id_detalle_requerimiento";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
		
	}
	
	
	function buscarRequerimientoPorPersonas($txtFicha="") {
		$consulta="select id_descripcion,descripcion, count(*) from  vistarequerimientosequipos where ficha='$txtFicha' group by id_descripcion order by descripcion asc";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
	}
	
	function buscarCambioRequerimiento() {
		$consulta="select id_estado_requerimiento from vistarequerimientosequipos where id_detalle_requerimiento='$this->idDetalleRequerimiento'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		
		
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[0];
		} else {
			return 1;
		}
	}
	
	function buscarRequerimientoPorCerrar($idGerencia="") {
		$consulta="select * from vistarequerimientosequipos 
		where id_estado_requerimiento in ('STA0000001','STA0000003')";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
		
	}
	
	function cerrarRequerimientoComponente($idInventario) {
		
		$conInventario="select * from vistacomponentes where id_inventario='$idInventario'";
		conectarMysql();
		$result=mysql_query($conInventario);
		mysql_close();
		
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			$mensaje="SE INSTALÓ EL COMPONENTE $row[3] MARCA $row[5] $row[7] $row[8] $row[9] SERIAL $row[1]";
		}
		$consulta="update detalle_requerimiento_equipo set 
			descripcion_detalle='$mensaje',
			id_estado_requerimiento='STA0000004',
			id_uss='$this->idUss',
			fecha_asociacion='$this->fechaAsociacion' 
			where id_detalle_requerimiento='$this->idDetalleRequerimiento' and (id_estado_requerimiento='STA0000001' or id_estado_requerimiento='STA0000003')";
		conectarMysql();
		$result=mysql_query($consulta);
		$affected=mysql_affected_rows();
		mysql_close();
		
		if ($result && $affected>0) {
			return 0;
		} else {
			return 1;
		}
		
	}
	
	function cerrarRequerimientoEquipo($idInventario) {
		
		$conInventario="select * from vistainventarioequipos where id_inventario='$idInventario'";
		
		conectarMysql();
		$result=mysql_query($conInventario);
		mysql_close();
		
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			$mensaje="SE INSTALÓ EL EQUIPO $row[9] MARCA $row[12] $row[14] $row[15] $row[16] SERIAL $row[7]";
		}
		$consulta="update detalle_requerimiento_equipo set 
			descripcion_detalle='$mensaje',
			id_estado_requerimiento='STA0000004',
			id_uss='$this->idUss',
			fecha_asociacion='$this->fechaAsociacion' 
			where id_detalle_requerimiento='$this->idDetalleRequerimiento' and (id_estado_requerimiento='STA0000001' or id_estado_requerimiento='STA0000003')";
		
		conectarMysql();
		$result=mysql_query($consulta);
		$affected=mysql_affected_rows();
		mysql_close();
		
		if ($result && $affected>0) {
			return 0;
		} else {
			return 1;
		}
		
	}

	
	
	
	function modificarRequerimiento() {
		if ($this->buscarCambioRequerimiento()!=1) {
			
			$encontrado=$this->buscarCambioRequerimiento();

			if ($encontrado!=$this->idRequerimientoEstado) {
				$consulta="update detalle_requerimiento_equipo set 
					descripcion_detalle='$this->descripcionDetalle',
					id_estado_requerimiento='$this->idRequerimientoEstado',
					id_uss='$this->idUss',
					fecha_asociacion='$this->fechaAsociacion' 
					where id_detalle_requerimiento='$this->idDetalleRequerimiento'";

				conectarMysql();
				$result=mysql_query($consulta);
				$affected=mysql_affected_rows();
				mysql_close();
				if ($result && $affected>0) {
					return 0;
				} else {
					return 1;
				}
				
			} else {
				return 2;
			}
		} else {
			return 1;
		}
		
	}
	function eliminarRequerimiento() {
		$consulta="delete from detalle_requerimiento_equipo where id_detalle_requerimiento='$this->idRequerimiento'";
		conectarMysql();
		$result=mysql_query($consulta);
		$affected=mysql_affected_rows();
		mysql_close();
		if ($result && $affected>0) {
			return 0;
		} else {
			return 1;
		}
		
	}
}

?>