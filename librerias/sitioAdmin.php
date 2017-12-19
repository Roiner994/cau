<?php
require_once("conexionsql.php");
require_once("administracion.php");
class seccion {
private $idSeccionPagina,$nombreSeccion;
	function seccion($idSeccionPagina="",$nombreSeccion="") {
		$this->idSeccionPagina=$idSeccionPagina;
		$this->nombreSeccion=strtoupper($nombreSeccion);
	}
	function ingresar() {
		if ($this->buscarDuplicado()==0) {
			return 2;	
		}
		$conUltimo="select id_seccion_pagina from seccion_pagina order by id_seccion_pagina DESC limit 1";
		$cons=new consecutivo("SEC",$conUltimo);
		$this->idSeccionPagina=$cons->retornar();
		$conIngresar="insert into seccion_pagina (id_seccion_pagina,nombre_seccion)
		 values ('$this->idSeccionPagina','$this->nombreSeccion')";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}	
	}
	function buscarDuplicado() {
		$consulta="select id_seccion_pagina from seccion_pagina where id_seccion_pagina<>'$this->idSeccionPagina' and nombre_seccion='$this->nombreSeccion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return 0;	
		} else {
			return 1;
		}
	}
	function modificar() {
		$conModificar="update seccion_pagina set
			nombreSeccion='$this->nombreSeccion' where id_seccion_pagina='$this->idSeccionPagina'";
		conectarMysql();
		$result=mysql_query($conModificar);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;	
		}
	}
	function eliminar() {
		$conEliminar="delete fromo seccion_pagina where id_seccion_pagina='$this->idSeccionPagina'";
		conectarMysql();
		$result=mysql_query($conEliminar);
		mysql_close();
		if ($result)
			return 0;
		else
			return 1;	
	}
}
class pagina {
	private $idPagina,
	$nombre,
	$ruta,
	$idSeccionPagina,
	$idPrivilegio;
	
	function pagina($idPagina="",$nombre="",$ruta="",$idSeccionPagina="",$idPrivilegio="") {
		$this->idPagina=$idPagina;
		$this->nombre=$nombre;
		$this->ruta=$ruta;
		$this->idSeccionPagina=$idSeccionPagina;
		$this->idPrivilegio=$idPrivilegio;
	}
	function ingresar() {
		$conUltimo="select ID_PAGINA from pagina order by id_pagina desc limit 1";
		$cons=new consecutivo("PAG",$conUltimo);
		$this->idPagina=$cons->retornar();
		$conIngresar="insert into pagina (id_pagina,nombre,ruta,id_seccion_pagina)
		 values ('$this->idPagina','$this->nombre','$this->ruta','$this->idSeccionPagina')";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
		if ($result) {
			$resultado=$this->ingresarPrivilegios();
			return 0;		
		} else {
			return 1;
		}
	}
	function ingresarPrivilegios() {
			$conBorrar="delete from pagina_privileio where id_pagina='$this->idPagina'";
			conectarMysql();	
			$result=mysql_query($conBorrar);
			$lista=$this->idPrivilegio;
			for ($i=0;$i<count($lista);$i++) {
				$conInsertar="insert into pagina_privilegio (ID_PAGINA,ID_PRIVILEGIO) values
				('$this->idPagina','$lista[$i]')";
				$result=mysql_query($conInsertar);
			}
			mysql_close();
			return 0;
	}
}
?>