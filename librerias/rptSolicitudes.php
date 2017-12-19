<?php
class rptSolicitudes {
private $idSolicitud,
$idGerencia,
$idSitio,
$ficha,
$status,
$motivo;

function construct($idSolicitud="",$idGerencia="",$idSitio="",$ficha="",$status="",$motivo="") {
	$this->idSolicitud=$idSolicitud;	
	$this->idGerencia=$idGerencia;
	$this->idSitio=$idSitio;	
	$this->ficha=$ficha;
	$this->status=$status;
	$this->motivo=$motivo;
}

function setValores($idSolicitud="",$serial="",$idGerencia="",$idSitio="",$ficha="",$status="",$motivo="") {
	$this->idSolicitud=$idSolicitud;	
	$this->idGerencia=$idGerencia;
	$this->idSitio=$idSitio;	
	$this->ficha=$ficha;
	$this->status=$status;
	$this->motivo=$motivo;

}

function setUbicacion($idDepartamento="",$idSitio="") {
		$this->idDepartamento=$idDepartamento;
		$this->idSitio=$idSitio;
	}




	


 function retornarSolicitudes($idSitio="",$fechaInicio="",$fechaFinal="",$idGerencia="",$idDescripcion="",$ficha="",$agruparPor="",$status="",$motivo="") {
		$rangoFecha="";
		if ((isset($fechaInicio) && !empty($fechaInicio)) && (isset($fechaFinal) && !empty($fechaFinal))) {
			$fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
			$fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);

		 	$rangoFecha=" vistasolicitudes.FECHA_I Between '$fechaInicio' AND '$fechaFinal' AND ";
		}
		if (isset($agruparPor) && !empty($agruparPor)){
			$agrupar=" Group By	$agruparPor ";
			$cantidad= ",count(*)";
		    }
		 if (isset($ficha) && !empty($ficha)) {
		  $conFicha=" AND (FICHA like '%$ficha' OR NOMBRE_USUARIO like '%$ficha%' OR APELLIDO_USUARIO like '%$ficha%')  ";	
		 }
			
	$consulta="SELECT * FROM vistasolicitudes
	Where
	$rangoFecha		
	ID_SITIO  Like '%$idSitio' AND
    ID_GERENCIA Like '%$idGerencia' AND
    ID_DESCRIPCION LIKE '%$idDescripcion' AND
    ID_STATUS like '%$status' AND
    ID_MOTIVO_SOLICITUD like '%$motivo'
    $conFicha     
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
?>
