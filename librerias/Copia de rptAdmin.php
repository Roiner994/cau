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
	$idEstado,
	$ficha,
	$idMarca,
	$idModelo,
	$idPedido,
	$critico,
	$usuarioEspecializado,
	$SP,
	$correctivo,
	$encontrado,
	$uso,
	$equipodisponible,
	$soActualizado,
	$antivirusActualizado;

	function __construct($fechaInicio="",$fechaFinal="",$idInventario="",$serial="",$configuracion="",$activoFijo="",$idGerencia="",$idSitio="",$idEstado="",$ficha="",$idMarca="",$idModelo="",$idPedido="") {
		$this->fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
		$this->fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
		$this->idInventario=$idInventario;
		$this->serial=$serial;
		$this->configuracion=$configuracion;
		$this->activoFijo=$activoFijo;
		$this->idGerencia=$idGerencia;
		$this->idSitio=$idSitio;
		$this->idEstado=$idEstado;
		$this->ficha=$ficha;
		$this->idMarca=$idMarca;
		$this->idModelo=$idModelo;
		$this->idPedido=$idPedido;
	}

	function setValores($fechaInicio="",$fechaFinal="",$idInventario="",$serial="",$configuracion="",$activoFijo="",$idGerencia="",$idSitio="",$idEstado="",$ficha="",$idMarca="",$idModelo="",$idPedido="") {
		$this->fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
		$this->fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
		$this->idInventario=$idInventario;
		$this->serial=strtoupper($serial);
		$this->configuracion=strtoupper($configuracion);
		$this->activoFijo=strtoupper($activoFijo);
		$this->idGerencia=$idGerencia;
		$this->idSitio=$idSitio;
		$this->idEstado=$idEstado;
		$this->ficha=$ficha;
		$this->idMarca=$idMarca;
		$this->idModelo=$idModelo;
		$this->idPedido=$idPedido;
	}

	function setUbicacion($idDepartamento="",$idSitio="") {
		$this->idDepartamento=$idDepartamento;
		$this->idSitio=$idSitio;
	}

	function retornarInventarioEquipos($idSitio="",$fechaInicio="",$fechaFinal="",$idGerencia="",$idDescripcion="",$ficha="",$serial="",$configuracion="",$activoFijo="",$idMarca="",$idModelo="",$idPedido="",$idEstado="",$agruparPor="",$red="",$critico="",$usuarioEspecializado="",$SP="",$correctivo="",$encontrado="",$uso="",$equipodisponible="",$soActualizado="",$antivirusActualizado="") {
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
    ID_Marca Like '%$idMarca' AND
    ID_Modelo Like '%$idModelo' AND    
    ID_PEDIDO like '%$idPedido'  AND
    ID_ESTADO like '%$idEstado' AND
    CONFIGURACION like '%$configuracion' AND 
    RED  like '%$red' AND 
    CRITICO like '%$critico' AND
    USUARIO_ESPECIALIZADO like '%$usuarioEspecializado' AND   
    SP like '%$SP' AND
	CORRECTIVO like '%$correctivo' AND
	ENCONTRADO like '%$encontrado' AND
	USO like '%$uso' AND
	DISPONIBLE like '%$equipodisponible' AND
	SISTEMA_OPERATIVO like '%$soActualizado' AND
	ANTIVIRUS like '%$antivirusActualizado' AND
    ACTIVO_FIJO like '%$activoFijo' $conFicha     
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
	$activoFijo,
	$idGerencia,
	$idSitio,
	$idEstado,
	$ficha,
	$idMarca,
	$idModelo,
	$idPedido,
	$critico;

	function __construct($fechaInicio="",$fechaFinal="",$idInventario="",$serial="",$configuracion="",$activoFijo="",$idGerencia="",$idSitio="",$idEstado="",$ficha="",$idMarca="",$idModelo="",$idPedido="") {
		$this->fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
		$this->fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
		$this->idInventario=$idInventario;
		$this->serial=$serial;
		$this->configuracion=$configuracion;
		$this->activoFijo=$activoFijo;
		$this->idGerencia=$idGerencia;
		$this->idSitio=$idSitio;
		$this->idEstado=$idEstado;
		$this->ficha=$ficha;
		$this->idMarca=$idMarca;
		$this->idModelo=$idModelo;
		$this->idPedido=$idPedido;
	}


function retornarInventarioComponentes($idSitio="",$fechaInicio="",$fechaFinal="",$idGerencia="",$idDescripcion="",$ficha="",$serial="",$configuracion="",$activoFijo="",$idMarca="",$idModelo="",$idPedido="",$idEstado="",$agruparPor="",$red="",$critico="",$idInventario="") {
	$rangoFecha="";
	if ((isset($fechaInicio) && !empty($fechaInicio)) || (isset($fechaFinal) && !empty($fechaFinal))) {
		$fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
		$fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
		$rangoFecha=" vistacomponentes.FECHA_ASOCIACION Between '$fechaInicio 00:00:00' AND '$fechaFinal 23:59:59' AND ";
	}
	if (isset($agruparPor) && !empty($agruparPor)){
		$agrupar=" Group By	$agruparPor ";
		$cantidad= ",count(*)";
	}
	if (isset($idSitio) && !empty($idSitio) && ($idSitio == 'SIT0000057') ){
		$consitio=" AND ID_SITIO  Like '%$idSitio' AND ID_INVENTARIO NOT IN (SELECT ID_INVENTARIO FROM vistacomponentesasociadosequipos)";
	}else
		$consitio=" AND ID_SITIO  Like '%$idSitio'";
		
	if (isset($ficha) && !empty($ficha)) {
		$conFicha=" AND (FICHA like '$ficha' OR NOMBRE_USUARIO like '%$ficha%' OR APELLIDO_USUARIO like '%$ficha%')  ";
	}

	//ECHO 
	$consulta="SELECT * $cantidad FROM vistacomponentes
	Where
	$rangoFecha	
	SERIAL LIKE '%$serial' AND
    ID_GERENCIA Like '%$idGerencia' AND
    ID_DESCRIPCION LIKE '%$idDescripcion' AND
    ID_Marca Like '%$idMarca' AND
    ID_Modelo Like '%$idModelo' AND
    ID_PEDIDO like '%$idPedido'  AND
    ID_ESTADO like '%$idEstado' AND    
    ID_INVENTARIO like '%$idInventario' 
       $consitio
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
	
}
?>
