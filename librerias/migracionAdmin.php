<?php
//Migracion Software Libre Admin

require_once("conexionsql.php");
require_once("administracion.php");

class migracionSoftware {
	private $idSoftware,
	$software,
	$descripcionSoftware;
	
	function migracionSoftware($idSoftware="",$software="",$descripcionSoftware="") {
		$this->idSoftware=$idSoftware;
		$this->software=trim(strtoupper($software));
		$this->descripcionSoftware=trim(strtoupper($descripcionSoftware));
	}
	
	function nuevoIdSoftware() {
		$conUltimo="select id_software from migracion_software order by id_software desc limit 1";
		$cons=new consecutivo("SOF",$conUltimo);
		$this->idSoftware=$cons->retornar();
	}	
	
	
	function ingresar() {
		
		if($this->buscarRepetido()==0) {
			return 2;
		}
	
		$this->nuevoIdSoftware();
		
		
		
		$consulta="insert into migracion_software (id_software,software,descripcion_software) values ('$this->idSoftware','$this->software','$this->descripcionSoftware')";
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
	
	function buscarRepetido() {
		$consulta="select id_software from migracion_software where software='$this->software'";
		conectarMysql();
		$resultado=mysql_query($consulta);
		mysql_close();
		
		if ($resultado && mysql_numrows($resultado)>0) {
			return 0;
		} else {
			return 1;
		}
	}
	
	function retornaSoftwareInstalado() {
		$consulta="select id_software,software,descripcion_software from migracion_software order by software";
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

class migracionSoftwareEquipo {
	private $configuracion,
	$idUss,
	$ficha,
	$idSoftware,
	$fechaAsociacion;
	
	function migracionSoftwareEquipo($configuracion="",$idUss="",$ficha="",$idSoftware="") {
		$this->configuracion=strtoupper($configuracion);
		$this->idUss=$idUss;
		$this->ficha=strtoupper($ficha);
		$this->idSoftware=$idSoftware;
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
	}
	
	function ingresar() {
		$consulta="insert into migracion_equipo (configuracion,ficha,id_uss,fecha_asociacion) values ('$this->configuracion','$this->ficha','$this->idUss','$this->fechaAsociacion')";
		
		conectarMysql();
		$result=mysql_query($consulta);
		$affected=mysql_affected_rows();
		mysql_close();
		
		if ($result && $affected>0) {
			return 0;
		} else {
			if ($this->modificarUsuario()==0)
				return 0;
			return 1;
		}
	}
	
	function modificarUsuario() {
		$consulta="update migracion_equipo set id_uss='$this->idUss', ficha='$this->ficha' where configuracion='$this->configuracion'";
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
	
	function ingresarSoftware($idSoftware) {
		
		if (count($idSoftware)>0) {
			$conDelete="delete from migracion_equipo_software_instalado where configuracion='$this->configuracion'";
			conectarMysql();
			$result=mysql_query($conDelete);
			for ($i=0;$i<count($idSoftware);$i++) {
				$conInsertar="insert into migracion_equipo_software_instalado(configuracion,id_software,fecha_asociacion)
				values ('$this->configuracion','$idSoftware[$i]','$this->fechaAsociacion')";	
				$result=mysql_query($conInsertar);
			}
			mysql_close();
		}

	}
	
	function verificarSoftwareInstalado($idSoftware) {
		$consulta="select id_software from migracion_equipo_software_instalado where configuracion='$this->configuracion' and id_software='$idSoftware'";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result && mysql_numrows($result)>0) {
			mysql_close();
			return 1;	
		} else {
			mysql_close();
			return 0;	
		}
	}
	
	function retornarSoftwareInstalado() {
		$consulta="select
			migracion_equipo_software_instalado.configuracion,
			migracion_equipo_software_instalado.fecha_asociacion,
			migracion_software.id_software,
			migracion_software.software,
			migracion_software.descripcion_software
			from
			migracion_equipo_software_instalado
			inner join migracion_software on migracion_equipo_software_instalado.id_software = migracion_software.id_software
			where configuracion='$this->configuracion' 
			order by
			migracion_software.software asc,
			migracion_software.descripcion_software asc";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
	}
	function retornaUsuarioSistema() {
		$consulta="Select
			migracion_equipo.CONFIGURACION,
			migracion_equipo.ID_USS,
			usuario_sistema.ID_USS,
			usuario_sistema.NOMBRE,
			usuario_sistema.APELLIDO,
			migracion_equipo.FECHA_ASOCIACION
			From
			migracion_equipo
			Inner Join usuario_sistema ON migracion_equipo.ID_USS = usuario_sistema.ID_USS
			where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
	}
	
	function ingresarSoftwareUtilizado($utilizacion="") {
		$utilizacion=strtoupper($utilizacion);
		$consulta="insert into migracion_equipo_software_utilizado (configuracion,id_software,utilizacion,fecha_asociacion) 
		values ('$this->configuracion','$this->idSoftware','$utilizacion','$this->fechaAsociacion')";
		conectarMysql();
		$result=mysql_query($consulta);
		$affected=mysql_affected_rows();
		mysql_close();
		if ($result && $affected>0) {
			return 0;
		} else {
			if ($this->actualizarSoftwareUtilizado($utilizacion)==0)
				return 0;
			return 1;
		}
		
	}
	function actualizarSoftwareUtilizado($utilizacion="") {
		$utilizacion=strtoupper($utilizacion);
		$consulta="update migracion_equipo_software_utilizado set utilizacion='$utilizacion' where configuracion='$this->configuracion' and id_software='$this->idSoftware'";
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
	
	function retornaUtilizacionSoftware($idSoftware) {
		$consulta="select utilizacion from migracion_equipo_software_utilizado where configuracion='$this->configuracion' and id_software='$idSoftware'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[0];
		} else {
			return 1;
		}
	}
	
	function buscarSoftwareUtilizado() {
		$consulta="Select
			migracion_equipo_software_utilizado.CONFIGURACION,
			migracion_equipo_software_utilizado.ID_SOFTWARE,
			migracion_software.ID_SOFTWARE,
			migracion_software.SOFTWARE,
			migracion_software.DESCRIPCION_SOFTWARE,
			migracion_equipo_software_utilizado.UTILIZACION,
			migracion_equipo_software_utilizado.FECHA_ASOCIACION
			From
			migracion_equipo_software_utilizado
			Inner Join migracion_software ON migracion_equipo_software_utilizado.ID_SOFTWARE = migracion_software.ID_SOFTWARE
			where configuracion='$this->configuracion'
			Order By
			migracion_software.SOFTWARE Asc,
			migracion_software.DESCRIPCION_SOFTWARE Asc";
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