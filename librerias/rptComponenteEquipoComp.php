<?php

class rptComponentes{
	private
	$descripcion;
	

	function __construct($descripcion="",$numerocomponente="") {		
		$this->descripcion=strtoupper($descripcion);
	}


	
	function retornarFaltantesInventarioComponentes($descripcion="",$agruparPor="") {

		if (isset($agruparPor) && !empty($agruparPor)){
			$agrupar=" Group By	$agruparPor ";
			$cantidad= ", count(*)";
		}

			
		
		
		$consulta="Select equipo_campo.CONFIGURACION
			
			
			From
			equipo_campo			
			WHERE 			
			equipo_campo.CONFIGURACION NOT IN (
				Select
			equipo_componente_campo.CONFIGURACION
			From
			equipo_componente_campo
			Inner Join inventario ON equipo_componente_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION			
			INNER JOIN descripcion_propiedad ON descripcion_propiedad.ID_DESCRIPCION_PROPIEDAD=descripcion.ID_DESCRIPCION_PROPIEDAD
			WHERE descripcion.ID_DESCRIPCION='$descripcion' AND
			equipo_componente_campo.STATUS_ACTUAL=1
			GROUP BY equipo_componente_campo.CONFIGURACION	)
			


			";
		
		
		conectarMysql();
			
		//$result=Array(mysql_query($consulta),$numerocomponente);
		set_time_limit(60);
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}

	}
	
	
	function retornarInventarioComponentes($descripcion="",$agruparPor="") {

		if (isset($agruparPor) && !empty($agruparPor)){
			$agrupar=" Group By	$agruparPor ";
			$cantidad= ", count(*)";
		}

		$consulta="SELECT vistacomponentesasociadosequiposgarantia.configuracion , 
		      	count(componente_id_descripcion),
		      	vistacomponentesasociadosequiposgarantia.equipo_descripcion,
		      	vistacomponentesasociadosequiposgarantia.equipo_id_inventario,
		      	vistacomponentesasociadosequiposgarantia.componente_id_inventario,
		      	vistacomponentes.ID_INVENTARIO,
		      	vistacomponentes.ID_ESTADO,
		      	vistacomponentes.ESTADO,
		      	vistacomponentesasociadosequiposgarantia.activo_fijo,
		      	vistacomponentesasociadosequiposgarantia.equipo_serial
				FROM 
				vistacomponentesasociadosequiposgarantia
				Inner Join vistacomponentes ON vistacomponentesasociadosequiposgarantia.componente_id_inventario = vistacomponentes.ID_INVENTARIO		
				WHERE 
				vistacomponentes.ESTADO	= 'OPERATIVO'
				AND vistacomponentesasociadosequiposgarantia.equipo_descripcion = 'MICROCOMPUTADOR' and
				vistacomponentesasociadosequiposgarantia.componente_id_descripcion ='$descripcion'
	    		Group By vistacomponentesasociadosequiposgarantia.configuracion
	    		HAVING count(vistacomponentesasociadosequiposgarantia.componente_id_descripcion ) > 1";
		
		
		
		
		$consulta="Select
			equipo_componente_campo.CONFIGURACION,
			COUNT(*),
			equipo_componente_campo.ID_INVENTARIO,
			descripcion.ID_DESCRIPCION
			From
			equipo_componente_campo
			Inner Join inventario ON equipo_componente_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON marca.ID_MARCA = modelo.ID_MARCA
			Inner Join pedido ON inventario.ID_PEDIDO = pedido.ID_PEDIDO
			Inner Join proveedor ON proveedor.ID_PROVEEDOR = pedido.ID_PROVEEDOR
			WHERE descripcion.ID_DESCRIPCION='$descripcion' AND
			equipo_componente_campo.STATUS_ACTUAL=1
			GROUP BY equipo_componente_campo.CONFIGURACION
			HAVING COUNT(*)>1
			ORDER BY equipo_componente_campo.CONFIGURACION";
		/*
			"SELECT configuracion , count(componente_id_descripcion)   
			FROM vistacomponentesasociadosequiposgarantia
			WHERE componente_id_descripcion ='$descripcion'
	    	Group By configuracion
	    	HAVING count(componente_id_descripcion ) > 1";			
		*/
		
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
