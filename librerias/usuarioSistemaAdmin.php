<?php
class usuarioSistema {
	private $idUss,
		$login,
		$password,
		$nombre,
		$apellido,
		$reset,
		$listaPrivilegio,
		$idUsuarioSistemaPrivilegio,
		$statusActivo,
		$idPrivilegio;
	
	function usuarioSistema($idUss="",$login="",$password="",$nombre="",$apellido="",$listaPrivilegio="",$reset="",$statusActivo="",$idPrivilegio="") {
		$this->idUss=$idUss;
		$this->login=$login;
		$this->password=md5($password);
		$this->nombre=strtoupper($nombre);
		$this->apellido=strtoupper($apellido);
		$this->reset=$reset;
		$this->listaPrivilegio=$listaPrivilegio;
		$this->statusActivo=$statusActivo;
		$this->idPrivilegio=$idPrivilegio;
	}
	function ingresar() {
		switch($this->buscarDuplicado()) {
			case 0:
				return 2;
				break 1;
			case 1:
				$conUltimo="SELECT ID_USS FROM usuario_sistema ORDER BY ID_USS DESC";
				$cons=new consecutivo("USS",$conUltimo);
				$this->idUss=$cons->retornar();
				$this->password=md5('123456');
				$this->reset='1';
				$conInsertar="INSERT INTO usuario_sistema (ID_USS,LOGIN,PASSWORD,NOMBRE,APELLIDO,RESET,STATUS_ACTIVO)
				VALUES ('$this->idUss','$this->login','$this->password','$this->nombre','$this->apellido','$this->reset','1')";
				conectarMysql();
				$result=mysql_query($conInsertar);
				$affected=mysql_affected_rows();
				mysql_close();

				if($result && $affected>0) {
					$resultado=$this->ingresarPrivilegios();
					return 0;
				} else {
					return 1;	
				}
		}
	}
	
	function ingresarPrivilegios() {
		$privilegio=$this->idPrivilegio;
			$conDelete="delete from usuario_sistema_privilegio where id_uss='$this->idUss'";
			
			conectarMysql();
			$result=mysql_query($conDelete);

			if (count($privilegio)>0) {

			for ($i=0;$i<count($privilegio);$i++) {
				$conInsertar="insert into usuario_sistema_privilegio (id_uss,id_privilegio)
				values ('$this->idUss','$privilegio[$i]')";	
				$result=mysql_query($conInsertar);
			}
			mysql_close();
		}
	}
	
	function modificar() {
		$this->ingresarPrivilegios();
		if ($this->reset==1) {
			$resultado=$this->resetPassword();
			if ($resultado!=0) {
				return 1;
			}
		}
		
		$resultado=$this->buscarUsuarioSistema();
		if ($resultado && $resultado!=1) {
			$row=mysql_fetch_array($resultado);
			if ($row[1]!=$this->login) {
				$resultadoLogin=$this->modificarLogin();
			}
			if ($row[2]!=$this->nombre) {
				$resultadoNombre=$this->modificarNombre();
			}
			if ($row[3]!=$this->apellido) {
				$resultadoApellido=$this->modificarApellido();
			}
			if ($resultadoNombre==0 || $resultadoApellido==0 || $resultadoLogin==0) {
				return 0;
			} else {
				return 1;
			}
			
		} else {
			return 1;
		}
	}
	function resetPassword() {
		$password=md5('123456');
		$consulta="update usuario_sistema set password='$password' where id_uss='$this->idUss'";
		conectarMysql();
		$result=mysql_query($consulta);
		$affected=mysql_affected_rows();
		mysql_close();
		if ($result && $affected>0) {
			return 0;
		} else {
			return 1;
		}
	}
	
	function buscarUsuarioSistema() {
		$consulta="select id_uss,login,nombre,apellido,status_activo from usuario_sistema where id_uss='$this->idUss'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
	}
	
	function modificarLogin() {
		$consulta="update usuario_sistema set login='$this->login' where id_uss='$this->idUss'";
		conectarMysql();
		$result=mysql_query($consulta);
		$affected=mysql_affected_rows();
		mysql_close();
		
		if ($result && $affected>0) {
			return 0;
		} else {
			return 1;
		}
	}
	function modificarNombre() {
		$consulta="update usuario_sistema set nombre='$this->nombre' where id_uss='$this->idUss'";
		conectarMysql();
		$result=mysql_query($consulta);
		$affected=mysql_affected_rows();
		mysql_close();
		
		if ($result && $affected>0) {
			return 0;
		} else {
			return 1;
		}
	}
	function modificarApellido() {
		$consulta="update usuario_sistema set apellido='$this->apellido' where id_uss='$this->idUss'";
		conectarMysql();
		$result=mysql_query($consulta);
		$affected=mysql_affected_rows();
		mysql_close();
		
		if ($result && $affected>0) {
			return 0;
		} else {
			return 1;
		}
	}


	
	private function buscarDuplicado() {
		conectarMysql();
		$conBuscar="select id_uss, login, status_activo from usuario_sistema where login='$this->login' and id_uss<>'$this->idUss'";
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
	function eliminar() {
		conectarMysql();
		$conEliminar="update usuario_sistema SET
			status_activo='$this->statusActivo' 
			where id_uss='$this->idUss'";
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
	function cambiarClave() {
		conectarMysql();
		$conModificar="update usuario_sistema set 
			reset=0, 
			password='$this->password' 
			where login='$this->login'";
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
	function validar() {
			$conValidar="SELECT ID_USS FROM usuario_sistema WHERE LOGIN='$this->login' AND PASSWORD='$this->password'";
			conectarMysql();
			$result=mysql_query($conValidar);
			$num=mysql_num_rows($result);
			if($result && mysql_numrows($result)>0) {
				$row=mysql_fetch_array($result);
				mysql_close();
				return $row[0];
			} else {
				mysql_close();
				return 1;
			}
	}	
	function validar2() {
		if ($this->login()==1) {
			return 2;
		} else {
			$this->idUss=$this->login();
			conectarMysql();
			$conValidar="select id_privilegio from usuario_sistema_privilegio where login='$this->login' and password='$this->password' and id_uss='$this->idUss'";
			$result=mysql_query($conValidar);
			$num=mysql_num_rows($result);
			if($num>0) {
				$row=mysql_fetch_array($result);
				mysql_close();
				return $row[0];
			} else {
				mysql_close();
				return 1;
			}
		}	
	}
	function login() {
		conectarMysql();
		$conLogin="select id_uss from usuario_sistema where login='$this->login'";
		$result=mysql_query($conLogin);
		$num=mysql_num_rows($result);
		if($num>0) {
			$row=mysql_fetch_array($result);
			mysql_close();
			return $row[0];
		} else {
			mysql_close();
			return 1;
		}	
	}
	function retornaUsuario() {
		conectarMysql();
		$conLogin="select id_uss, nombre, apellido from usuario_sistema where login='$this->login'";
		$result=mysql_query($conLogin);
		$num=mysql_num_rows($result);
		if($num>0) {
			$row=mysql_fetch_array($result);
			mysql_close();
			$tmp=$row[1].", ".$row[2];
			return $tmp;
		} else {
			mysql_close();
			return 1;
		}
	}
	function retornarUsuario() {
		$consulta="SELECT ID_USS,NOMBRE,APELLIDO,LOGIN,ID_PRIVILEGIO,RESET FROM USUARIO_SISTEMA WHERE ID_USS='$this->idUss'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;
		}
	}
	function retornarPrivilegioUsuario() {
		$consulta="select id_privilegio from usuario_sistema_privilegio where id_uss='$this->idUss'";
		
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;	
		}
		
	}
	function verificarAcceso($idPrivilegio) {
		if ($this->verificarAdministrador()==0) {
			return 0;
		}
		$consulta="select id_privilegio from usuario_sistema_privilegio where id_uss='$this->idUss' and id_privilegio in ($idPrivilegio)";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return 0;
		} else {
			return 1;
		}
	}
	
	function verificarAdministrador() {
		$consulta="select id_privilegio from usuario_sistema_privilegio where id_uss='$this->idUss' and id_privilegio='PRV0000001'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return 0;
		} else {
			return 1;
		}
	}
	

	
	
	function verificarPrivilegio($idPrivilegio) {
		$consulta="select id_privilegio from usuario_sistema_privilegio where id_uss='$this->idUss' and id_privilegio='$idPrivilegio'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return 1;	
		} else {
			return 0;	
		}		
	}
	function nuevoPassword() {
		conectarMysql();
		$conBuscar="select id_privilegio from usuario_sistema where login='$this->login' and reset=1";
		$result=mysql_query($conBuscar);
		$num=mysql_num_rows($result);
		if($num>0) {
			$row=mysql_fetch_array($result);
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}	
	}

function permisoUsuarioSistema($privilegio) {
	$consulta="Select
		usuario_sistema.ID_USS,
		usuario_sistema.LOGIN,
		usuario_sistema.ID_PRIVILEGIO,
		usuario_sistema.NOMBRE,
		usuario_sistema.APELLIDO
		From
		usuario_sistema
		Where id_uss='$this->idUss' and ID_PRIVILEGIO='$privilegio'";
	conectarMysql();
	$result=mysql_query($consulta);
	mysql_close();
	if ($result && mysql_numrows($result)>0) {
		return 0;
	} else {
		return 1;
	}
}
	
	                                        ///USUARIO SISTEMA PRIVILEGIO///

	    	function ingresarUsuario() {
	    		for ($i=0;$i<count($idPrivilegio);$i++) {			
				conectarMysql();
				$conUltimo="SELECT ID_USS FROM usuario_sistema ORDER BY ID_USS DESC";
				$cons=new consecutivo("USS",$conUltimo);
				$this->idUss=$cons->retornar();
				$this->password=md5('123456');
				$this->reset='1';
				$conInsertar="INSERT INTO usuario_sistema (ID_USS,LOGIN,PASSWORD,NOMBRE,APELLIDO,RESET,STATUS_ACTIVO)
				VALUES ('$this->idUss','$this->login','$this->password','$this->nombre','$this->apellido','$this->reset','$this->statusActivo')";
				$result=mysql_query($conInsertar);
				$affected=mysql_affected_rows();
				if($affected>0) {
					$resultado=$this->ingresarPrivilegios();
					mysql_close();
					return 0;
				} else {
					mysql_close();
					return 1;	
				}
	    	  }
	}                                    	          
		private function buscarDuplicadoUsuario() {
		conectarMysql();
		$conBuscar="select id_uss, login, status_activo from usuario_sistema where login='$this->login' and id_uss<>'$this->idUss'";
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
class privilegio {
//Nombres de los privilegios que tendrnhn cada uno de los usuarios
private $idPrivilegio,
		$privilegio;

	function privilegio($idPrivilegio="",$privilegio="") {
		$this->idPrivilegio=strtoupper($idPrivilegio);
		$this->privilegio=strtoupper($privilegio);
	}
	function ingresar() {
		switch($this->buscarDuplicado()) {
			case 0:
				return 2;
				break 1;
			case 1:
				conectarMysql();
				$conUltimo="SELECT ID_PRIVILEGIO FROM privilegio ORDER BY ID_PRIVILEGIO DESC";
				$cons=new consecutivo("PRV",$conUltimo);
				$this->idPrivilegio=$cons->retornar();
				$conIngresar="INSERT INTO PRIVILEGIO (ID_PRIVILEGIO,PRIVILEGIO) VALUES ('$this->idPrivilegio','$this->privilegio')";
				$result=mysql_query($conIngresar);
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
	private function buscarDuplicado() {
		conectarMysql();
		$conBuscar="SELECT ID_PRIVILEGIO, PRIVILEGIO FROM privilegio WHERE PRIVILEGIO='$this->privilegio'";
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
	function modificar() {
		switch($this->buscarDuplicado()) {
			case 0:
				return 2;
				break 1;
			case 1:
				conectarMysql();
				$conModificar="UPDATE PRIVILEGIO SET 
				PRIVILEGIO='$this->privilegio'
				WHERE ID_PRIVILEGIO='$this->idPrivilegio'";
				$result=mysql_query($conModificar);
				$affected=mysql_affected_rows();
				if($affected>0) {
					mysql_close();
					return 0;
				} else {
					mysql_close();
					return 1;
				}
				break 1;
		}
	}
	function eliminar() {
		$conEliminar="DELETE FROM privilegio WHERE ID_PRIVILEGIO='$this->idPrivilegio'";
		conectarMysql();
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
	function retornarPrivilegio() {
		$consulta="select id_privilegio,privilegio from privilegio order by privilegio";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result) {
			mysql_close();
			return $result;	
		} else {
			mysql_close();
			return 1;
		}	
	}
}

?>