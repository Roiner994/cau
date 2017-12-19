<?php
//CLASE MARCA
class marca {
	private $idMarca,
		$marca,
		$statusActivo;
	
	
	function marca($idMarca="",$marca="",$statusActivo=""){
		$this->idMarca=$idMarca;
		$this->marca=strtoupper($marca);
		$this->statusActivo=statusActivo;
	}
	function ingresarMarca() {
	if ($this->buscarDuplicadoMarca('marca')!=0) {
			return 1;
		}
		else {
			$conUltimo="select id_marca from marca order by id_marca DESC";
			$cons=new consecutivo("MAR",$conUltimo);
			$this->idMarca=$cons->retornar();
			$conIngresarMarca="insert into marca(id_marca,marca,status_activo)
			VALUES('$this->idMarca','$this->marca','1')";
			//echo "$conIngresarMarca";
			conectarMysql();
			$result=mysql_query($conIngresarMarca);
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
	//FUNCION BUSCAR DUPLICADO
	private function buscarDuplicadoMarca() {
	conectarMysql();
				$conBuscarMarca= "select marca from marca where marca='$this->marca'
				and status_activo='1'";
				$result=mysql_query($conBuscarMarca);
				$num=mysql_num_rows($result);
				if($num>0) {
					mysql_close();
					return 2;
				} else {
					mysql_close();
					return 0;
				}
		
		    
	}
	//FUNCION ELIMINAR MARCA
	function marcaEliminar1() {
		conectarMysql();
		$conEliminar="update marca set
			status_activo='0' 
			where id_marca='$this->idMarca'";
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
	//FUNCION MODIFICAR MARCA
	function marcaModificar() {
		if (($this->buscarDuplicadoMarca()!=0) ) {
			return 2;
		}else {			
			$conModificarMarca="update marca set
						 marca='$this->marca'
						 where id_marca='$this->idMarca'";
			//echo"$conModificarMarca"; 
			conectarMysql();
			$result=mysql_query($conModificarMarca);
			$affected=mysql_affected_rows();
			if ($affected>0) {
				mysql_close();
				return 0;
			} else {
				mysql_close();
				return 3;
			  }
		}
	}
	function buscarMarca() {
		$consulta="select id_marca,marca from marca where status_activo=1 order by marca";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		
		if ($result && mysql_query($result)>0) {
			return $result;
		} else {
			return 1;
		}
	}
	
	
	function desactivar() {
		conectarMysql();
		$conModificar="update marca set status_activo=0 where id_marca='$this->id_marca'";
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
		$conModificar="update marca set status_activo=1 where id_marca='$this->id_marca'";
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