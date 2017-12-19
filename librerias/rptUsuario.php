<?php
class rptEquipos {
	private 
	$idGerencia,
	$idCargo,
	$idDepartamento,
	$idDivision,
	$nombre,
	$apellido,
	$cedula,
	$idSitio,
	$ficha;	

	function __construct($idSitio="",$idGerencia="",$idCargo="",$idDepartamento="",$idDivision="",$ficha="",$nombre="",$apellido="",$cedula="") {
		
		$this->idGerencia=$idGerencia;
		$this->idCargo=$idCargo;		
		$this->idDepartamento=$idDepartamento;
		$this->idDivision=$idDivision;
		$this->idSitio=$idSitio;		
		$this->ficha=$ficha;
		$this->nombre=$nombre;
		$this->apellido=$apellido;
		$this->cedula=$cedula;		
	}

	function setValores($idSitio="",$idGerencia="",$idCargo="",$idDepartamento="",$idDivision="",$ficha="",$nombre="",$apellido="",$cedula="") {
		
		$this->idGerencia=$idGerencia;
		$this->idCargo=$idCargo;
		$this->idDepartamento=$idDepartamento;
		$this->idDivision=$idDivision;
		$this->idSitio=$idSitio;		
		$this->ficha=$ficha;
		$this->nombre=$nombre;
		$this->apellido=$apellido;	
		$this->cedula=$cedula;			
	}

	function setUbicacion($idDepartamento="",$idSitio="") {
		$this->idDepartamento=$idDepartamento;
		$this->idSitio=$idSitio;
	}


	function retornarInventarioEquipos($idSitio="",$idGerencia="",$idCargo="",$idDepartamento="",$idDivision="",$ficha="",$nombre="",$apellido="",$cedula="",$agruparPor="") {
				
		if (isset($agruparPor) && !empty($agruparPor)){
			$agrupar=" Group By	$agruparPor ";
			$cantidad= ",count(*)";
		}
		if (isset($ficha) && !empty($ficha)) {
			$conFicha=" AND (FICHA like '$ficha' OR NOMBRE_USUARIO like '%$ficha%' OR APELLIDO_USUARIO like '%$ficha%')  ";
		}

		$consulta="SELECT * $cantidad FROM vistausuario 
		Where
		ID_SITIO  Like '%$idSitio' AND
    	ID_GERENCIA Like '%$idGerencia' AND
    	ID_CARGO like '%$idCargo' AND		
    	ID_DEPARTAMENTO Like '%$idDepartamento' AND
    	ID_DIVISION Like '%$idDivision' AND
    	NOMBRE_USUARIO LIKE '%$nombre%' AND
    	APELLIDO_USUARIO Like '%$apellido%' AND
    	CEDULA like '%$cedula'
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

	}
	
	

}//fin de la clase


?>

