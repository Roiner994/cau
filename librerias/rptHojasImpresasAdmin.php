<?php
class rptEquipos {
	private $fechaInicio,
	$fechaFinal,
	$idInventario,
	$serial,
	$configuracion,
	$activoFijo,
	$idGerencia,
	$idSitio,
	$ficha,
	$idMarca,
	$idModelo,
	$idDescipcion;

	function __construct($fechaInicio="",$fechaFinal="",$idInventario="",$serial="",$configuracion="",$activoFijo="",$idGerencia="",$idSitio="",$ficha="",$idMarca="",$idModelo="") {
		$this->fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
		$this->fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
		$this->idInventario=$idInventario;
		$this->serial=$serial;
		$this->configuracion=$configuracion;
		$this->activoFijo=$activoFijo;		
		$this->idGerencia=$idGerencia;
		$this->idSitio=$idSitio;		
		$this->ficha=$ficha;
		$this->idMarca=$idMarca;
		$this->idModelo=$idModelo;
		
	}

	function setValores($fechaInicio="",$fechaFinal="",$idInventario="",$serial="",$configuracion="",$activoFijo="",$idGerencia="",$idSitio="",$idEstado="",$ficha="",$idMarca="",$idModelo="",$idPedido="") {
		$this->fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
		$this->fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
		$this->idInventario=$idInventario;
		$this->serial=strtoupper($serial);
		$this->configuracion=strtoupper($configuracion);
		$this->activoFijo=$activoFijo;		
		$this->idGerencia=$idGerencia;
		$this->idSitio=$idSitio;		
		$this->ficha=$ficha;
		$this->idMarca=$idMarca;
		$this->idModelo=$idModelo;
		
	}

	function setUbicacion($idDepartamento="",$idSitio="") {
		$this->idDepartamento=$idDepartamento;
		$this->idSitio=$idSitio;
	}


	function retornarInventarioEquipos($idSitio="",$fechaInicio="",$fechaFinal="",$idGerencia="",$idDescripcion="",$activoFijo="",$ficha="",$serial="",$configuracion="",$idMarca="",$idModelo="",$agruparPor="") {
		
		$rangoFecha="";
		if ((isset($fechaInicio) && !empty($fechaInicio)) || (isset($fechaFinal) && !empty($fechaFinal))) {
			$fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
			$fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
			$rangoFecha=" vistamantenimientospreventivos.FECHA_INICIO Between '$fechaInicio' AND '$fechaFinal' AND ";
		}
		if (isset($agruparPor) && !empty($agruparPor)){
			$agrupar=" Group By	$agruparPor ";
			$cantidad= ",count(*)";
		}
		if (isset($ficha) && !empty($ficha)) {
			$conFicha=" AND (FICHA like '$ficha' OR NOMBRE_USUARIO like '%$ficha%' OR APELLIDO_USUARIO like '%$ficha%')  ";
		}
		if (isset($configuracion) && !empty($configuracion)) {
			$conConfig=" CONFIGURACION like '%$configuracion' AND CONFIGURACION NOT IN (Select equipo_campo.CONFIGURACION From equipo_campo Inner Join inventario_propiedad ON equipo_campo.ID_INVENTARIO = inventario_propiedad.ID_INVENTARIO Where ((inventario_propiedad.ID_ESTADO Not Like 'EST0000001') AND (equipo_campo.CONFIGURACION Like '%VEI%')) Group By equipo_campo.CONFIGURACION) AND ";
		}else
			$conConfig=" CONFIGURACION like '%$configuracion' AND CONFIGURACION NOT IN (Select equipo_campo.CONFIGURACION From equipo_campo Inner Join inventario_propiedad ON equipo_campo.ID_INVENTARIO = inventario_propiedad.ID_INVENTARIO Where ((inventario_propiedad.ID_ESTADO Not Like 'EST0000001') AND (equipo_campo.CONFIGURACION Like '%VEI%')) Group By equipo_campo.CONFIGURACION) AND ";

	$consulta="SELECT * $cantidad FROM vistamantenimientospreventivos
	Where
	$rangoFecha	
	$conConfig
	SERIAL LIKE '%$serial' AND
	ID_SITIO  Like '%$idSitio' AND
    ID_GERENCIA Like '%$idGerencia' AND
    ID_DESCRIPCION LIKE '%$idDescripcion' AND
    ACTIVO_FIJO LIKE '%$activoFijo' AND
    ID_Marca Like '%$idMarca' AND
    ID_Modelo Like '%$idModelo'
    $conFicha      
    $agrupar";
		
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}

	}
	function retornaEquipoAsignadoporUsuario($ficha) {
		$consulta="select id_descripcion, descripcion, count(*) as cantidad 
		from vistainventarioequipos 
		where ficha='$ficha'
		group by id_descripcion";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
	}
}//fin de la clase
?>
