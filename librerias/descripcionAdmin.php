<?php
//CLASE DESCRIPCION

class descripcion {
	private $idDescripcion,
		$descripcion,
		$statusActivo,
		$idDescripcionPropiedad,
		$reserva,
		$suministro,
		$costoUnitario;

function descripcion ($idDescripcion="",$descripcion="",$statusActivo="",$idDescripcionPropiedad="",$reserva=0,$suministro=0,$costoUnitario=0) {
	$this->idDescripcion=strtoupper($idDescripcion);
	$this->descripcion=strtoupper($descripcion);
	$this->statusActivo=$statusActivo;
	$this->idDescripcionPropiedad=$idDescripcionPropiedad;
	$this->reserva=$reserva;
	$this->suministro=$suministro;
	$this->costoUnitario=$costoUnitario;
}
//FUNCION BUSCAR DUPLICADO DESCRIPCION

private function buscarDuplicadoDescripcion() {
	$conBuscarDupliDescrip="selet descripcion from descripcion where descripcion='$this->descripcion'";

	conectarMysql();
		$result=mysql_query($conBuscarDupliDescrip);
	mysql_close();
	if($result && mysql_numrows()>0) {
		return 0;
	}else {
		return 1;
	}	
}

function buscarMarcaAsociada($marca) {
	$consulta="Select
		descripcion.ID_DESCRIPCION,
		descripcion.DESCRIPCION,
		marca.ID_MARCA,
		marca.MARCA,
		descripcion.STATUS_ACTIVO,
		marca.STATUS_ACTIVO
		From
		descripcion
		Inner Join descripcion_marca ON descripcion.ID_DESCRIPCION = descripcion_marca.ID_DESCRIPCION
		Inner Join marca ON descripcion_marca.ID_MARCA = marca.ID_MARCA
		where descripcion.id_descripcion='$this->idDescripcion' and marca.id_marca='$marca'";

	conectarMysql();
	$result=mysql_query($consulta);
	mysql_close();
	
	if ($result && mysql_numrows($result)>0) {
		return 1;
	} else {
		return 0;
	}
}


	//Obtiene un Nuevo idInventario
	function nuevoIdDescripcion() {
		$conUltimo="select id_descripcion from descripcion order by id_descripcion desc limit 1";
		$cons=new consecutivo("DES",$conUltimo);
		$this->idDescripcion=$cons->retornar();
	}

	function buscarDescripcion() {
		$consulta= "Select
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			descripcion.ID_DESCRIPCION_PROPIEDAD,
			descripcion_propiedad.DESCRIPCION_PROPIEDAD,
			descripcion.SUMINISTRO,
			descripcion.STATUS_ACTIVO
			From
			descripcion
			left Join descripcion_marca ON descripcion.ID_DESCRIPCION = descripcion_marca.ID_DESCRIPCION
			left Join marca ON descripcion_marca.ID_MARCA = marca.ID_MARCA
			Inner Join descripcion_propiedad ON descripcion.ID_DESCRIPCION_PROPIEDAD = descripcion_propiedad.ID_DESCRIPCION_PROPIEDAD
			where descripcion.id_descripcion='$this->idDescripcion'";
	
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
	}


//FUNCION INGRESAR DESCRIPCION

function ingresarDescripcion($marca) {
	if ($this->buscarDuplicadoDescripcion()!=1) {
		return 2;
	}
	else {
		$this->nuevoIdDescripcion();
		$conInsertar="insert into descripcion (descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			descripcion.STATUS_ACTIVO,
			descripcion.ID_DESCRIPCION_PROPIEDAD,
			descripcion.RESERVA,
			descripcion.SUMINISTRO,
			descripcion.COSTO_UNITARIO)
			VALUES ('$this->idDescripcion',
					'$this->descripcion',
					'$this->statusActivo',
					'$this->idDescripcionPropiedad',
					'$this->reserva',
					'$this->suministro',
					'$this->costoUnitario')";
		conectarMysql();
		$result=mysql_query($conInsertar);
		$affected=mysql_affected_rows();
		mysql_close();
		if ($result && $affected>0) {
			$this->ingresarMarca($marca);
			return 0;
		} else {
			return 1;
		}
	}
}

	function descripcionModificar($marca) {
		if ($this->buscarDuplicadoDescripcion()!=1) {
			return 2;
		}		
		$consulta="update descripcion set descripcion='$this->descripcion',
		id_descripcion_propiedad='$this->idDescripcionPropiedad',
		suministro='$this->suministro' where id_descripcion='$this->idDescripcion'
		";
		conectarMysql();
		$result=mysql_query($consulta);
		$affected=mysql_affected_rows();
		mysql_close();	
		if ($result && $affected>0) {
			$this->ingresarMarca($marca);
			return 0;
		} else {
			$this->ingresarMarca($marca);
			return 1;
		}
	}

	function ingresarMarca($marca) {
		if (count($marca)>0) {
			$conDelete="delete from descripcion_marca where id_descripcion='$this->idDescripcion'";
			conectarMysql();
			$result=mysql_query($conDelete);
			for ($i=0;$i<count($marca);$i++) {
				$conInsertar="insert into descripcion_marca (id_descripcion,id_marca)
				values ('$this->idDescripcion','$marca[$i]')";	
				$result=mysql_query($conInsertar);
			}
			mysql_close();
		}
	}
	
}

?>

