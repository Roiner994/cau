<?php
class rptEquipos {
	private $fechaInicio,
	$fechaFinal,
	$serial,
	$configuracion,
	$idDescripcion,
	$activoFijo,
	$idMarca,
	$idModelo,
	$idPedido;

	function __construct($fechaInicio="",$fechaFinal="",$idDescripcion="",$serial="",$configuracion="",$activoFijo="",$idMarca="",$idModelo="",$idPedido="") {
		$this->fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
		$this->fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
		$this->serial=$serial;
		$this->idDescripcion=$idDescripcion;
		$this->configuracion=$configuracion;
		$this->activoFijo=$activoFijo;		
		$this->idMarca=$idMarca;
		$this->idModelo=$idModelo;
		$this->idPedido=$idPedido;
	}

	function setValores($fechaInicio="",$fechaFinal="",$idDescripcion="",$serial="",$configuracion="",$activoFijo="",$idMarca="",$idModelo="",$idPedido="") {
		$this->fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
		$this->fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
		$this->serial=strtoupper($serial);
		$this->idDescripcion=$idDescripcion;
		$this->configuracion=strtoupper($configuracion);
		$this->activoFijo=strtoupper($activoFijo);		
		$this->idMarca=$idMarca;
		$this->idModelo=$idModelo;
		$this->idPedido=$idPedido;
	}


	function retornarInventarioEquipos($fechaInicio="",$fechaFinal="",$idDescripcion="",$serial="",$configuracion="",$activoFijo="",$idMarca="",$idModelo="",$idPedido="",$agruparPor="") {
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

		$consulta="SELECT * $cantidad FROM vistaInventarioEquipos
		Where
		$rangoFecha
		SERIAL LIKE '%$serial' AND
	    ID_DESCRIPCION LIKE '%$idDescripcion' AND
    	ID_Marca Like '%$idMarca' AND
    	ID_Modelo Like '%$idModelo' AND
    	ID_PEDIDO like '%$idPedido'  AND
    	CONFIGURACION like '%$configuracion' AND
    	ACTIVO_FIJO like '%$activoFijo'
    	$agrupar";
		
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0){
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
	$idMarca,
	$idModelo,
	$idPedido,
	$critico;

	function __construct($fechaInicio="",$fechaFinal="",$idInventario="",$serial="",$configuracion="",$activoFijo="",$idMarca="",$idModelo="",$idPedido="") {
		$this->fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
		$this->fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
		$this->serial=strtoupper($serial);
		$this->configuracion=strtoupper($configuracion);
		
		$this->idMarca=$idMarca;
		$this->idModelo=$idModelo;
		$this->idPedido=$idPedido;
	}


function retornarInventarioComponentes($fechaInicio="",$fechaFinal="",$idDescripcion="",$serial="",$configuracion="",$idMarca="",$idModelo="",$idPedido="",$agruparPor="",$red="",$critico="",$idInventario="") {
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
    ID_Marca Like '%$idMarca' AND
    ID_Modelo Like '%$idModelo' AND
    ID_PEDIDO like '%$idPedido'  AND 
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
