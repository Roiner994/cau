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
	$idModelo;

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
			$rangoFecha=" vistaInventarioEquipos.EQUIPO_FECHA_CREACION Between '$fechaInicio' AND '$fechaFinal' AND ";
		}
		if (isset($agruparPor) && !empty($agruparPor)){
			$agrupar=" Group By	$agruparPor ";
			$cantidad= ",count(*)";
		}
		if (isset($ficha) && !empty($ficha)) {
			$conFicha=" AND (FICHA like '$ficha' OR NOMBRE_USUARIO like '%$ficha%' OR APELLIDO_USUARIO like '%$ficha%')  ";
		}

	$consulta="SELECT * $cantidad FROM vistaInventarioEquipos
	Where
	$rangoFecha	
	SERIAL LIKE '%$serial' AND
	ID_SITIO  Like '%$idSitio' AND
    ID_GERENCIA Like '%$idGerencia' AND
    ID_DESCRIPCION LIKE '%$idDescripcion' AND
    ACTIVO_FIJO LIKE '%$activoFijo' AND
    ID_Marca Like '%$idMarca' AND
    ID_Modelo Like '%$idModelo' AND       
    CONFIGURACION like '%$configuracion'   
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

class rptComponentes {
	private $fechaInicio,
	$fechaFinal,
	$idInventario,
	$serial,
	$configuracion,
	$idEstado,
	$idMarca,
	$idModelo,
	$critico;

	function __construct($fechaInicio="",$fechaFinal="",$idInventario="",$serial="",$configuracion="",$idEstado="",$activoFijo="",$idMarca="",$idModelo="") {
		$this->fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
		$this->fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
		$this->serial=strtoupper($serial);
		$this->configuracion=strtoupper($configuracion);
		$this->idEstado=$idEstado;
		$this->idMarca=$idMarca;
		$this->idModelo=$idModelo;
	}


function retornarInventarioComponentes($fechaInicio="",$fechaFinal="",$idDescripcion="",$idEstado="",$serial="",$configuracion="",$idMarca="",$idModelo="",$agruparPor="",$red="",$critico="",$idInventario="") {
		$rangoFecha="";
		if ((isset($fechaInicio) && !empty($fechaInicio)) || (isset($fechaFinal) && !empty($fechaFinal))) {
			$fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
			$fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
			$rangoFecha=" vistacomponentes.FECHA_ASOCIACION Between '$fechaInicio' AND '$fechaFinal' AND ";
		}
		if (isset($agruparPor) && !empty($agruparPor)){
			$agrupar=" Group By	$agruparPor ";
			$cantidad= ",count(*)";
		}
		
	$consulta="SELECT * $cantidad FROM vistacomponentes
	Where
	$rangoFecha	
	SERIAL LIKE '%$serial' AND
    ID_DESCRIPCION LIKE '%$idDescripcion' AND
    ID_ESTADO like '%$idEstado' AND
    ID_Marca Like '%$idMarca' AND
    ID_Modelo Like '%$idModelo' AND
    ID_INVENTARIO like '%$idInventario'  
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
	
}
?>
