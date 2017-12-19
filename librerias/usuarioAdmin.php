<?php
//Clase Usuario
class usuario {
	private $ficha,
		$cedula,
		$nombre,
		$apellido,
		$idCargo,
		$idUbicacion,
		$idSitio,
		$idGerencia,
		$idDivision,
		$idDepartamento,
		$extension,
		$fichaAntigua,
		$email;
		
	function usuario($ficha="",$cedula="",$nombre="",$apellido="",$idCargo="",$idGerencia="",$idDivision="",$idDepartamento="",$idSitio="",$extension="",$idUbicacion="",$fichaAntigua="",$email="") {
		$this->ficha=strtoupper($ficha);
		$this->cedula=strtoupper($cedula);
		$this->nombre=strtoupper($nombre);
		$this->apellido=strtoupper($apellido);
		$this->idCargo=strtoupper($idCargo);
		$this->idUbicacion=$idUbicacion;
		$this->idSitio=$idSitio;
		$this->idGerencia=$idGerencia;
		$this->idDivision=$idDivision;
		$this->idDepartamento=$idDepartamento;
		$this->extension=strtoupper($extension);
		$this->fichaAntigua=$fichaAntigua;
		$this->email=$email;
		
	}
	function ingresar() {
	
		if ($this->buscarDuplicado('cedula')==0) {
			return 1;
		}
		if ($this->buscarDuplicado('ficha')==0) {
			return 2;
		} else {			
			$conIngresar="insert into usuario(ficha,cedula,nombre_usuario,apellido_usuario,id_cargo,id_departamento,id_sitio,extension,status_activo,email)
			VALUES('$this->ficha','$this->cedula','$this->nombre','$this->apellido','$this->idCargo','$this->idDepartamento','$this->idSitio','$this->extension','1','$this->email')";
			conectarMysql();
			$result=mysql_query($conIngresar);
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
	private function buscarDuplicado($por) {
		conectarMysql();
		switch($por) {
			case 'cedula':
				$conBuscar="select cedula from usuario where cedula='$this->cedula'";
				$result=mysql_query($conBuscar);
				$num=mysql_num_rows($result);
				if($num>0) {
					mysql_close();
					return 0;
				} else {
					mysql_close();
					return 1;
				}
				case 'ficha':
					$conBuscar="select ficha from usuario where ficha='$this->ficha'";
					$result=mysql_query($conBuscar);
					$num=mysql_num_rows($result);
					if($num>0) {
						mysql_close();
						return 0;
					} else {
						mysql_close();
						return 1;
					}
				case 'cedulaModificar':
					$conBuscar="select cedula from usuario where cedula='$this->cedula' and ficha<>'$this->fichaAntigua'";
					$result=mysql_query($conBuscar);
					$num=mysql_num_rows($result);
					if($num>0) {
						mysql_close();
						return 0;
					} else {
						mysql_close();
						return 1;
					}
			}
	}
	function buscarUsuario() {
		conectarMysql();
		$conBuscar="select ficha,cedula,nombre_usuario,apellido_usuario,email from usuario where (ficha like '%$this->ficha' or cedula like '%$this->cedula' or nombre_usuario like '$this->nombre%' or apellido_usuario like '$this->apellido%') and status_activo=1 order by ficha";
		$result=mysql_query($conBuscar);
		if ($result) {
			mysql_close();
			return $result;
		} else {
			mysql_close();
			return 1; 
		}
	}
	function modificar() {
		if ($this->buscarDuplicado('cedulaModificar')==0) {
			return 1;
		}
		if (($this->buscarDuplicado('ficha')==0) && ($this->ficha!=$this->fichaAntigua)) {
			return 2;
		} else {			
			$ubi=new ubicacion("",$this->idGerencia,$this->idDivision,$this->idDepartamento,$this->idSitio);
			$this->idUbicacion=$ubi->ingresar();

			$conModificar="update usuario set
						ficha='$this->ficha', 
						cedula='$this->cedula', 
						nombre_usuario='$this->nombre', 
						apellido_usuario='$this->apellido', 
						id_cargo='$this->idCargo', 
						id_departamento='$this->idDepartamento', 
						id_sitio='$this->idSitio',
						extension='$this->extension', 
						email='$this->email'
						where ficha='$this->fichaAntigua'";
			conectarMysql();
			$result=mysql_query($conModificar);
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
	function actualizarUsuario() {
		$conModificar="update usuario set
			id_departamento='$this->idDepartamento', 
			id_sitio='$this->idSitio',
			extension='$this->extension' 
			 where ficha='$this->ficha'";
		conectarMysql();
		$result=mysql_query($conModificar);
		$affected=mysql_affected_rows();
		if ($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 3;
		}
	}
	
	function actualizarExtension() {
		$conModificar="update usuario set
			extension='$this->extension' 
	  		where ficha='$this->ficha'";
		conectarMysql();
		$result=mysql_query($conModificar);
		$affected=mysql_affected_rows();
		if ($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}
	}
	function actualizarSitio() {
		$conModificar="update usuario set
			id_sitio='$this->idSitio' 
	  		where ficha='$this->ficha'";
		conectarMysql();
		$result=mysql_query($conModificar);
		$affected=mysql_affected_rows();
		if ($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}
	}

	function actualizarDepartamento() {
		$conModificar="update usuario set
			id_departamento='$this->idDepartamento' 
	  		where ficha='$this->ficha'";
	
		conectarMysql();
		$result=mysql_query($conModificar);
		$affected=mysql_affected_rows();
		if ($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}
	}	
	
	function retornaUsuario() {
		$consultaUsuario="Select
			usuario.FICHA,
			usuario.CEDULA,
			concat(nombre_usuario,' ',apellido_usuario) AS nombres,
			usuario.NOMBRE_USUARIO,
			usuario.APELLIDO_USUARIO,
			usuario.ID_CARGO,
			cargo.CARGO,
			sitio.ID_SITIO,
			sitio.SITIO,
			gerencia.ID_GERENCIA,
			gerencia.GERENCIA,
			division.ID_DIVISION,
			division.DIVISION,
			departamento.ID_DEPARTAMENTO,
			departamento.DEPARTAMENTO,
			usuario.EXTENSION,
			usuario.EMAIL
			From
			usuario
			Inner Join sitio ON usuario.ID_SITIO = sitio.ID_SITIO
			Inner Join departamento ON departamento.ID_DEPARTAMENTO = usuario.ID_DEPARTAMENTO
			Inner Join division ON departamento.ID_DIVISION = division.ID_DIVISION
			Inner Join gerencia ON division.ID_GERENCIA = gerencia.ID_GERENCIA
			Inner Join cargo ON usuario.ID_CARGO = cargo.ID_CARGO
			Where
			usuario.FICHA = '$this->ficha'";
		conectarMysql();
		$result=mysql_query($consultaUsuario);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		}	else {
			return 1;	
		}
		
	}
	function desactivar() {
		conectarMysql();
		$conModificar="update usuario set status_activo=0 where ficha='$this->ficha'";
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
		$conModificar="update usuario set status_activo=1 where ficha='$this->ficha'";
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

	function setUsuario($ficha="",$nombre="",$apellido="",$email="") {
		$this->ficha=$ficha;
		$this->nombre=strtoupper($nombre);
		$this->apellido=strtoupper($apellido);
		$this->email=strtoupper($email);
	}
	
	function mostrarRemitentes($ficha) {
		$consulta="Select * from usuario Where ficha in ($ficha)";
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