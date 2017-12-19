<?php
//CLASE PROVEEDOR

class proveedor {
	private $idProveedor,
		$proveedor,
		$contactos,
		$direccion,
		$correo,
		$telefono,
		$statusActivo;

	function proveedor ($idProveedor="",$proveedor="",$contactos="",$direccion="",$correo="",$telefono="",$statusActivo=""){
		$this->idProveedor=$idProveedor;
		$this->proveedor=strtoupper($proveedor);
		$this->contactos=strtoupper($contactos);
		$this->direccion=strtoupper($direccion);
		$this->correo=$correo;
		$this->telefono=$telefono;
		$this->statusActivo=$statusActivo;
		
		//ECHO "$this->proveedor";
		//ECHO "$proveedor";
	}
	//FUNCION INGRESAR PROVEEDOR
	function ingresarProveedor() {
	if ($this->buscarDuplicadoProveedor('proveedor')!=0) {
			return 1;
		}
		else {
		$conUltimo="select id_proveedor from proveedor order by id_proveedor DESC";
			$cons=new consecutivo("PRO",$conUltimo);
			$this->idProveedor=$cons->retornar();
			$conIngresarProveedor="insert into proveedor(id_proveedor,proveedor,contactos,direccion,correo,telefono,status_activo)
			VALUES('$this->idProveedor','$this->proveedor','$this->contactos','$this->direccion','$this->correo','$this->telefono','1')";
			//echo "$conIngresarProveedor";
			conectarMysql();
			$result=mysql_query($conIngresarProveedor);
			
			$affected=mysql_affected_rows();
			if ($affected>0) {
				mysql_close();
				return 0;
			} else {
				mysql_close();
				return 1;
			}
		}
	}
	

//FUNCION BUSCAR DUPLICADO PROVEEDOR

private function buscarDuplicadoProveedor() {
	conectarMysql();
	 
			$conBuscarDuplicadoProveedor="select proveedor from proveedor where proveedor='$this->proveedor'";
		
			$result=mysql_query($conBuscarDuplicadoProveedor);
			$num=mysql_num_rows($result);
				if($num>0) {
					mysql_close();
					return 1;
				} else {
					mysql_close();
					return 0;
				}
}
//FUNCION ELIMINAR PROVEEDOR
	
function eliminarProveedor() {
		conectarMysql();
		$conEliminar="update proveedor set
			status_activo='$this->statusActivo' 
			where id_proveedor='$this->idProveedor'";
		$result=mysql_query($conEliminar);
		$affected=mysql_affected_rows();
			if($affected>0) {
				mysql_close();
				return 0;
			} else {
				mysql_close();
				return 1;	
			}
	}




//FUNCION MODIFICAR PROVEEDOR

function modificarProveedor() {
			
			$conModificarProveedor="update proveedor set
						 proveedor='$this->proveedor',
						 contactos='$this->contactos',
						 direccion='$this->direccion',
						 correo='$this->correo',
						 telefono='$this->telefono'
						 where id_proveedor='$this->idProveedor'";
			//echo"$conModificarProveedor"; 
			conectarMysql();
			$result=mysql_query($conModificarProveedor);
			$affected=mysql_affected_rows();
			if ($affected>0) {
				mysql_close();
				return 0;
			} else {
				mysql_close();
				return 3;
			  }
		
	}
	



		
function desactivar() {
		conectarMysql();
		$conModificar="update proveedor set status_activo=0 where id_marca='$this->id_marca'";
		$result=mysql_query($conModificar);
		$affected=mysql_affected_rows();
		if($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;	
		}

	}
	function activar() {
		conectarMysql();
		$conModificar="update proveedor set status_activo=1 where id_marca='$this->id_marca'";
		$result=mysql_query($conModificar);
		$affected=mysql_affected_rows();
		if($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;	
		}
	}
}

?>
