<?php

class rptComponentes {
	private
	$descripcion;
	

	function __construct($descripcion="") {		
		$this->descripcion=strtoupper($descripcion);		
	}


	function retornarInventarioComponentes($descripcion="",$agruparPor="") {
			
		if (isset($agruparPor) && !empty($agruparPor)){
			$agrupar=" Group By	$agruparPor ";
			$cantidad= ", count(*)";
		}
				
			$consulta="SELECT *, count(*) FROM vistainventarioequipos
			WHERE 
			ID_ESTADO = 'EST0000001' AND
			ESTADO = 'OPERATIVO' AND
			DESCRIPCION ='MICROCOMPUTADOR' AND
			CONFIGURACION NOT IN (SELECT configuracion 
			FROM vistacomponentesasociadosequiposgarantia
			WHERE componente_id_descripcion ='$descripcion')
	    	GROUP BY DESCRIPCION"; 
			echo $consulta;
				
		conectarMysql();
			
		//$result=Array(mysql_query($consulta),$numerocomponente);
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
