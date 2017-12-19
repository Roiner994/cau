<?php

class rptComponenteEquipo {
	private
	$descripcion,
	$configuracion;
	

	function __construct($descripcion="") {		
		$this->descripcion=strtoupper($descripcion);		
	}


	function retornarInventarioComponentes($descripcion="",$configuracion="",$agruparPor="") {
			
		if (isset($agruparPor) && !empty($agruparPor)){
			$agrupar=" Group By	$agruparPor ";
			$cantidad= ", count(*)";
		}
				
	  $consulta="Select DISTINCT equipo_componente_campo.CONFIGURACION,
			equipo_componente_campo.ID_EQUIPO_COMPONENTE_CAMPO,
			equipo_componente_campo.ID_INVENTARIO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			inventario.FRU,
			inventario.PRODUCT_NUMBER,
			inventario.SPARE_NUMBER,
			inventario.CT,
			inventario.ID_PEDIDO,
			inventario.FECHA_INICIO,
			inventario.FECHA_FINAL,
			inventario_propiedad.ID_SITIO,
			sitio.SITIO,
			inventario_propiedad.ID_ESTADO,
			inventario_estado.ESTADO,
			equipo_componente_campo.FECHA_ASOCIACION,
			pedido.ID_PROVEEDOR,
			proveedor.PROVEEDOR
			From
			equipo_componente_campo
			Inner Join inventario ON equipo_componente_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join inventario_propiedad ON inventario.ID_INVENTARIO = inventario_propiedad.ID_INVENTARIO			
			Inner Join inventario_estado ON inventario_propiedad.ID_ESTADO = inventario_estado.ID_ESTADO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON marca.ID_MARCA = modelo.ID_MARCA
			Inner Join pedido ON inventario.ID_PEDIDO = pedido.ID_PEDIDO
			Inner Join proveedor ON proveedor.ID_PROVEEDOR = pedido.ID_PROVEEDOR
			Inner Join sitio ON inventario_propiedad.ID_SITIO = sitio.ID_SITIO
			Where
			inventario_estado.ESTADO='OPERATIVO' AND
			equipo_componente_campo.CONFIGURACION Like '%$configuracion' and 
			descripcion.ID_DESCRIPCION Like '%$descripcion' "; 
			
				
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