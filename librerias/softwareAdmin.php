<?php
//CLASE SOFTWARE

class software {
	private $idTipoSoftware,
		$tipoSoftware,
		$status_activo,
		$idSoftware,
		$software,
		$estatusActivo,
		$total;
		
	function software($idTipoSoftware="",$tipoSoftware="",$statusActivo="",
	$idSoftware="",$software="",$estatusActivo="",$total=0){
	$this->idSoftware=$idSoftware;
	$this->tipoSoftware=strtoupper($tipoSoftware);
	$this->status_activo=$statusActivo;
	$this->idSoftware=$idSoftware;
	$this->estatusActivo=$estatusActivo;
	$this->idTipoSoftware=$idTipoSoftware;
	$this->software=strtoupper($software);
	$this->total=$total;
	
	}
	//FUNCION INGRESAR TIPO DE SOFTWARE
	function ingresarTipoSoftware(){
			if ($this->buscarDuplicadoTipoSoftware('tipoSoftware')!=0) {
			return 1;
		}
		else {
			$conUltimo="select id_tipo_software from tipo_software order by id_tipo_software DESC";
			$cons=new consecutivo("ITS",$conUltimo);
			$this->idTipoSoftware=$cons->retornar();
			$conIngresarTipoSoftware="insert into tipo_software(id_tipo_software,tipo_software,status_activo)
			VALUES('$this->idTipoSoftware','$this->tipoSoftware',1)";
			conectarMysql();
			$result=mysql_query($conIngresarTipoSoftware);
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
	//FUNCION BUSCAR DUPLICADO DE TIPO DE SOFTWARE
	function buscarDuplicadoTipoSoftware() {
			conectarMysql();
				$conBuscarSoftware= "select tipo_software from tipo_software 
				where tipo_software='$this->tipoSoftware'
				and status_activo='1'";
				$result=mysql_query($conBuscarSoftware);
				$num=mysql_num_rows($result);
				if($num>0) {
					mysql_close();
					return 2;
				} else {
					mysql_close();
					return 0;
				} 		
	}
	
	//FUNCION MODIFICAR TIPO DE SOFTWARE
	function modificarTipoSoftware() {
				
			$conModificarTipoSoftware="update tipo_software set
						 tipo_software='$this->tipoSoftware'
						 where id_tipo_software='$this->idTipoSoftware'";
			conectarMysql();
			$result=mysql_query($conModificarTipoSoftware);
			$affected=mysql_affected_rows();
			if ($affected>0) {
				mysql_close();
				return 0;
			} else {
				mysql_close();
				return 3;
			  }
		
	}
		//FUNCION ELIMINAR TIPO DE SOFTWARE
	function eliminarTipoSoftware() {
		conectarMysql();
		$conEliminar="update tipo_software set
			status_activo='0' 
			where id_tipo_software='$this->idTipoSoftware'";
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
														////SOFTWARE/////
														
		//FUNCION BUSCAR DUPILICADO  DE SOFTWARE
	function buscarDuplicadoSoftware() {
			conectarMysql();
				$conBuscarSoftware= "select software from software 
				where software='$this->software'
				and estatus_activo='1'";
				$result=mysql_query($conBuscarSoftware);
				$num=mysql_num_rows($result);
				if($num>0) {
					mysql_close();
					return 2;
				} else {
					mysql_close();
					return 0;
				} 		
	}
	
	//FUNCION INGRESAR NUEVO SOFTWARE
	
		function ingresarSoftware(){
			if ($this->buscarDuplicadoSoftware('software')!=0) {
			return 1;
		}
		else {
			$conUltimo="select id_software from software order by id_software DESC";
			$cons=new consecutivo("RQS",$conUltimo);
			$this->idSoftware=$cons->retornar();
			$conIngresarSoftware="insert into software(id_software,software,id_tipo_software,estatus_activo)
			VALUES('$this->idSoftware','$this->software','$this->idTipoSoftware',1)";			
			conectarMysql();
			$result=mysql_query($conIngresarSoftware);
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
		//FUNCION ELIMINAR SOFTWARE
	function eliminarSoftware() {
		conectarMysql();
		$conEliminar="update software set estatus_activo='0' where id_software='$this->idSoftware'";
		
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
	//FUNCION MODIFICAR  SOFTWARE
	function modificarSoftware() {
				
			$conModificarSoftware="update software set
						 software='$this->software',
						 id_tipo_software='$this->idTipoSoftware'
						 where id_software='$this->idSoftware'";
			conectarMysql();
			$result=mysql_query($conModificarSoftware);
			$affected=mysql_affected_rows();
			if ($affected>0) {
				mysql_close();
				return 0;
			} else {
				mysql_close();
				return 3;
			  }
		
	}
	function retornaTotal() {
		return $this->total;	
	}
	
	function retornarSoftware() {
		$consulta="Select
		tipo_software.ID_TIPO_SOFTWARE,
		tipo_software.TIPO_SOFTWARE,
		software.ID_SOFTWARE,
		software.SOFTWARE
		From
		software
		Inner Join tipo_software ON software.ID_TIPO_SOFTWARE = tipo_software.ID_TIPO_SOFTWARE
		ORDER BY software.SOFTWARE";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$this->total=mysql_numrows($result);
			return $result;	
		} else {
			return 1;
		}
	}
	
	
}


?>