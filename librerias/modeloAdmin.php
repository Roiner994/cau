<?php
//CLASE MODELO

class modelo {
	private $idDescripcion,
		$idMarca,
		$idModelo,
		$modelo,
		$tipo,
		$unidad,
		$statusActivo;
			

function modelo ($idDescripcion="",$idMarca="",$idModelo="",$modelo="",$tipo="",$unidad="",$statusActivo="") {
	$this->idDescripcion=$idDescripcion;
	$this->idMarca=$idMarca;
	$this->idModelo=$idModelo;
	$this->modelo=strtoupper($modelo);
	$this->tipo=strtoupper($tipo);
	$this->unidad=strtoupper($unidad);
	$this->statusActivo=$statusActivo;
	
}

//FUNCION INGRESAR MODELO

function ingresarModelo() {
if ($this-> buscarDuplicadoModelo()!=0) {
			return 1;
		}
		else {
		$conUltimo="select id_modelo from modelo order by id_modelo DESC";
			$cons=new consecutivo("MOD",$conUltimo);
			$this->idModelo=$cons->retornar();
			$conIngresarModelo="insert into modelo(id_descripcion,id_marca,id_modelo,modelo,cap_vel,unidad,status_activo)
			VALUES('$this->idDescripcion','$this->idMarca','$this->idModelo','$this->modelo','$this->tipo','$this->unidad','1')";
			conectarMysql();
			$result=mysql_query($conIngresarModelo);
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

//FUNCION MODIFICAR MODELO
function modificarModelo() {
	 			
			$conModificarModelo="update modelo set
						 id_descripcion='$this->idDescripcion',
						 id_marca='$this->idMarca',
						 modelo='$this->modelo',
						 cap_vel='$this->tipo',
						 unidad='$this->unidad'
						 where id_modelo='$this->idModelo'";
			//echo"$conModificarModelo"; 
			conectarMysql();
			$result=mysql_query($conModificarModelo);
			$affected=mysql_affected_rows();
			if ($affected>0) {
				mysql_close();
				return 0;
			} else {
				mysql_close();
				return 3;
			  }
		
	}
//FUNCION ELIMINAR MODELO
	function modeloEliminar1() {
		conectarMysql();

		$conEliminar="update modelo set
			status_activo=0 
			where id_modelo='$this->idModelo'";
		//echo"$conEliminar";
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

//FUNCION BUSCAR DUPLICADO DE MODELO
	
	private function buscarDuplicadoModelo() {
	conectarMysql();
				$conBuscarDuplicadoModelo= "select modelo from modelo where modelo='$this->modelo' and id_descripcion='$this->idDescripcion' and id_marca='$this->idMarca' and cap_vel='$this->tipo' and unidad='$this->unidad'";
				$result=mysql_query($conBuscarDuplicadoModelo);
				$num=mysql_num_rows($result);
				if($num>0) {
					mysql_close();
					return 2;
				} else {
					mysql_close();
					return 0;
				}
				    
	}


		
	function desactivar() {
		conectarMysql();
		$conModificar="update modelo set status_activo=0 where id_modelo='$this->id_modelo'";
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
		$conModificar="update modelo set status_activo=1 where id_modelo='$this->id_modelo'";
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
	
	
	function buscarModelo() {
		$consulta="Select
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			modelo.ID_MARCA,
			marca.MARCA,
			modelo.ID_DESCRIPCION,
			descripcion.DESCRIPCION
			
			
			From
			modelo
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON marca.ID_MARCA = modelo.ID_MARCA
			
			where modelo.id_modelo='$this->idModelo'";
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
