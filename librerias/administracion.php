<?php
require_once("conexionsql.php");
//Conexion con la base de datos;
//require_once "conexionsql.php";

//Generar Numeros consecutivos
// crear("ABREVIATURA","CONSULTA SQL");
class consecutivo {
	private $sql;
	private $abreviatura;
	private $id;
	private $num;

	function consecutivo($abv="error",$cons="error") {

		$this->sql=$cons;
		$this->abreviatura=$abv;
	}

	function retornar() {

		conectarMysql();
		$consql=$this->sql;
		$result = mysql_query($consql);
		if($result) {
		$row = mysql_fetch_array($result);
		$this->num=substr($row[0],3,7);
		}
		$this->num=$this->num+1;
		switch(strlen($this->num)) {
			case 1:
			$this->id=$this->abreviatura."000000".$this->num;
			break 1;
			case 2:
			$this->id=$this->abreviatura."00000".$this->num;
			break 1;
			case 3:
			$this->id=$this->abreviatura."0000".$this->num;
			break 1;
			case 4:
			$this->id=$this->abreviatura."000".$this->num;
			break 1;
			case 5:
			$this->id=$this->abreviatura."00".$this->num;
			break 1;
			case 6:
			$this->id=$this->abreviatura."0".$this->num;
			break 1;
			case 7:
			$this->id=$this->abreviatura.$this->num;
			break 1;
		}
		return $this->id;
		mysql_close();
	}
}

//Clase para generar Consultas para utilizar en los campo Select
//Ingresar el campo clave, campo a mostrar, tabla, y filtro.



class gerencia {
	private
	$idGerencia,
	$gerencia,
	$statusActivo;

	function __construct($idGerencia="",$gerencia="",$statusActivo=1) {
		$this->idGerencia=$idGerencia;
		$this->gerencia=strtoupper($gerencia);
		$this->statusActivo=$statusActivo;	
	}
	
	function setGerencia($idGerencia="",$gerencia="",$statusActivo=1) {
		$this->idGerencia=$idGerencia;
		$this->gerencia=strtoupper($gerencia);
		$this->statusActivo=$statusActivo;
	}
	
	function nuevoIdGerencia() {
		$conUltimo="select id_gerencia from gerencia order by id_gerencia desc limit 1";
		$cons=new consecutivo("ORG",$conUltimo);
		$this->idGerencia=$cons->retornar();
	}
	
	function buscarDuplicado() {
		$consulta="select id_gerencia from gerencia where id_gerencia<>'$this->idGerencia' and gerencia='$this->gerencia'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)) {
			return 0;	
		} else {
			return 1;	
		}
	}
	
	function ingresar() {
		$this->nuevoIdGerencia();
		if ($this->buscarDuplicado()==0) {
			return 2;	
		}
		$conIngresar="insert into gerencia (id_gerencia,gerencia)
		values ('$this->idGerencia','$this->gerencia')";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
		if ($result) {
			$division= new division();
			$division->setDivision($this->idGerencia,$this->idGerencia,$this->gerencia);
			$resultado=$division->ingresar();
			return 0;
		} else {
			return 1;
		}	
	}
	function modificar() {
		if ($this->buscarDuplicado()==0) {
			return 2;	
		}
		
		$conModificar="update gerencia set gerencia='$this->gerencia' where id_gerencia='$this->idGerencia'";
		conectarMysql();
		$result=mysql_query($conModificar);
		$affected=mysql_affected_rows();
		mysql_close();

		if ($result && $affected>0) {
			$division=new division($this->idGerencia,$this->idGerencia,$this->gerencia,1);
			$resultado=$division->modificar();
			$departamento= new departamento($this->idGerencia,$this->idGerencia,$this->gerencia,1);
			$resultado=$departamento->modificar();
			return 0;
		} else {
			return 1;
		}
		
	}
	
	function buscarGerencia() {
		$consulta="select id_gerencia,gerencia from gerencia where status_activo=1 and id_gerencia='$this->idGerencia'";
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


class tipo{	
	private
	$idTipo,
	$tipo;
	
	
	function __construct($idTipo="",$tipo="") {
		$this->idTipo=$idTipo;
		$this->tipo=strtoupper($tipo);		
	}
	
	function setTipo($idTipo="",$tipo="") {
		$this->idTipo=$idTipo;
		$this->tipo=strtoupper($tipo);		
	}
	
	function nuevoIdTipo() {
		$conUltimo="select ID_TIPO from tipo order by ID_TIPO desc limit 1";
		$cons=new consecutivo("TIP",$conUltimo);
		$this->idTipo=$cons->retornar();
	}
	
	function buscarDuplicado() {
		$consulta="select id_tipo from tipo where id_tipo<>'$this->idTip' and tipo='$this->tipo'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)) {
			return 0;	
		} else {
			return 1;	
		}
	}
	
	
	function ingresar() {
		$this->nuevoIdTipo();
		if ($this->buscarDuplicado()==0) {
			return 2;	
		}
		$conIngresar="insert into tipo (id_tipo,tipo)
		values ('$this->idTipo','$this->tipo')";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
		if ($result) {
			return 0;
		} else {
			return 1;
		}	
	}
	function modificar() {
		if ($this->buscarDuplicado()==0) {
			return 2;	
		}
		
		$conModificar="update tipo set tipo='$this->tipo' where id_tipo='$this->idTipo'";
		conectarMysql();
		$result=mysql_query($conModificar);
		$affected=mysql_affected_rows();
		mysql_close();

		if ($result && $affected>0) {
			return 0;
		} else {
			return 1;
		}
		
	}
	
	function buscarTipo() {
		$consulta="select id_tipo,tipo from tipo where id_tipo='$this->idTipo'";
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




class sitio {
	private
	$idSitio,
	$sitio,
	$statusActivo;

	function __construct($idSitio="",$sitio="",$statusActivo=1) {
		$this->idSitio=$idSitio;
		$this->sitio=strtoupper($sitio);
		$this->statusActivo=$statusActivo;	
	}
	
	function setSitio($idSitio="",$sitio="",$statusActivo=1) {
		$this->idSitio=$idSitio;
		$this->sitio=strtoupper($sitio);
		$this->statusActivo=$statusActivo;
	}
	
	function nuevoIdSitio() {
		$conUltimo="select id_sitio from sitio order by id_sitio desc limit 1";
		$cons=new consecutivo("SIT",$conUltimo);
		$this->idSitio=$cons->retornar();
	}
	
	function buscarDuplicado() {
		$consulta="select id_sitio from sitio where id_sitio<>'$this->idSitio' and sitio='$this->sitio'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)) {
			return 0;	
		} else {
			return 1;	
		}
	}
	
	function ingresar() {
		$this->nuevoIdSitio();
		if ($this->buscarDuplicado()==0) {
			return 2;	
		}
		$conIngresar="insert into sitio (id_sitio,sitio,id_ubicacion_propiedad,status_activo)
		values ('$this->idSitio','$this->sitio','UBP0000002','1')";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
		if ($result) {
			return 0;
		} else {
			return 1;
		}	
	}
	function modificar() {
		if ($this->buscarDuplicado()==0) {
			return 2;	
		}
		
		$conModificar="update sitio set sitio='$this->sitio' where id_sitio='$this->idSitio'";
		conectarMysql();
		$result=mysql_query($conModificar);
		$affected=mysql_affected_rows();
		mysql_close();

		if ($result && $affected>0) {
			return 0;
		} else {
			return 1;
		}
		
	}
	
	function buscarSitio() {
		$consulta="select id_sitio,sitio from sitio where status_activo=1 and id_sitio='$this->idSitio'";
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
class division {
	private 
	$idDivision,
	$idGerencia,
	$division,
	$statusActivo;
	
	function __construct($idDivision="",$idGerencia="",$division="",$statusActivo=1) {
		$this->idDivision=$idDivision;
		$this->idGerencia=$idGerencia;
		$this->division=strtoupper($division);
		$this->statusActivo=$statusActivo;
	}

	function setDivision($idDivision="",$idGerencia="",$division="",$statusActivo=1) {
		$this->idDivision=$idDivision;
		$this->idGerencia=$idGerencia;
		$this->division=$division;
		$this->statusActivo=$statusActivo;
	}
	
	
	function nuevoIdDivision() {
		$conUltimo="select id_division from division order by id_division desc limit 1";
		$cons=new consecutivo("ORG",$conUltimo);
		$this->idDivision=$cons->retornar();
	}

	
	function buscarDuplicado() {
		$consulta="select id_division from division where id_division<>'$this->idDivision' and division='$this->division'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)) {
			return 0;	
		} else {
			return 1;	
		}
	}
	
	function ingresar() {
		if (empty($this->idDivision))
			$this->nuevoIdDivision();
		if ($this->buscarDuplicado()==0) {
			return 2;	
		}
		$conIngresar="insert into division (id_division,id_gerencia,division)
		values ('$this->idDivision','$this->idGerencia','$this->division')";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
		if ($result) {
			$departamento= new departamento();
			$departamento->setDepartamento($this->idDivision,$this->idDivision,$this->division);
			$resultado=$departamento->ingresar();
			return 0;
		} else {
			return 1;
		}	
	}
	
	function buscarDivision() {
		$consulta="select id_division,id_gerencia,division from division where status_activo=1 and id_division='$this->idDivision'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
	}	
	
	function modificar() {
		if ($this->buscarDuplicado()==0) {
			return 2;	
		}
		$conModificar="update division set id_division='$this->idDivision', 
			id_gerencia='$this->idGerencia',
			division='$this->division' 
			where id_division='$this->idDivision'";
		conectarMysql();
		$result=mysql_query($conModificar);
		$affected=mysql_affected_rows();
		mysql_close();
		
		if ($result && $affected>0) {
			$departamento= new departamento($this->idDivision,$this->idDivision,$this->division,1);
			$resultado=$departamento->modificar();
			return 0;
		} else {
			return 1;
		}
	
	}
}

class departamento {
	private $idDepartamento,
	$idDivision,
	$departamento,
	$statusActivo;
	

	function __construct($idDepartamento="",$idDivision="",$departamento="",$statusActivo=1) {
		$this->idDepartamento=$idDepartamento;
		$this->idDivision=$idDivision;
		$this->departamento=strtoupper($departamento);
		$this->statusActivo=$statusActivo;
	}

	function setDepartamento($idDepartamento="",$idDivision="",$departamento="",$statusActivo=1) {
		$this->idDepartamento=$idDepartamento;
		$this->idDivision=$idDivision;
		$this->departamento=$departamento;
		$this->statusActivo=$statusActivo;
	}
	
	
	function nuevoIdDepartamento() {
		$conUltimo="select id_departamento from departamento order by id_departamento desc limit 1";
		$cons=new consecutivo("ORG",$conUltimo);
		$this->idDepartamento=$cons->retornar();
	}

	
	function buscarDuplicado() {
		$consulta="select id_departamento from departamento where id_departamento<>'$this->idDepartamento' and departamento='$this->departamento'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)) {
			return 0;	
		} else {
			return 1;	
		}
	}
	
	function ingresar() {
		if (empty($this->idDepartamento))
			$this->nuevoIdDepartamento();
		if ($this->buscarDuplicado()==0) {
			return 2;	
		}
		$conIngresar="insert into departamento (id_departamento,id_division,departamento)
		values ('$this->idDepartamento','$this->idDivision','$this->departamento')";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
		if ($result) {
			return 0;
		} else {
			return 1;
		}	
	}
	function buscarDepartamento() {
		$consulta="select id_departamento,id_division,departamento from departamento where status_activo=1 and id_departamento='$this->idDepartamento'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
	}	
	function modificar() {
		if ($this->buscarDuplicado()==0) {
			return 2;	
		}
		$conModificar="update departamento set 
			id_departamento='$this->idDepartamento', 
			id_division='$this->idDivision',
			departamento='$this->departamento' 
			where id_departamento='$this->idDepartamento'";
		conectarMysql();
		$result=mysql_query($conModificar);
		$affected=mysql_affected_rows();
		mysql_close();
		
		if ($result && $affected>0) {
			return 0;
		} else {
			return 1;
		}		
	}
}

//Clase Ubicacion
class ubicacion {
	private $idUbicacion,
		$idGerencia,
		$idDivision,
		$idDepartamento,
		$idSitio;
		
		//constructor
		function ubicacion($idUbicacion="",$idGerencia="",$idDivision="",$idDepartamento="",$idSitio="") {
			$this->idUbicacion=$idUbicacion;
			$this->idGerencia=$idGerencia;
			$this->idDivision=$idDivision;
			$this->idDepartamento=$idDepartamento;
			$this->idSitio=$idSitio;
		
		}
		function ingresar() {
			switch($this->buscarDuplicado()) {
				case 0:
					return $this->buscar();
					break 1;
				case 1:
					conectarMysql();
					$conUltimo="SELECT ID_UBICACION FROM ubicacion ORDER BY ID_UBICACION DESC";
					$cons=new consecutivo("UBI",$conUltimo);
					$this->idUbicacion=$cons->retornar();
					$conInsertar="INSERT INTO UBICACION(ID_UBICACION,ID_GERENCIA,ID_DIVISION,ID_DEPARTAMENTO,ID_SITIO)
						VALUES('$this->idUbicacion','$this->idGerencia','$this->idDivision','$this->idDepartamento','$this->idSitio')";
					$result=mysql_query($conInsertar);
					mysql_close();
					return $this->buscar();
					break 1;
			}
		}
		function buscarDuplicado() {
			conectarMysql();
			$conBuscar="SELECT ID_UBICACION FROM ubicacion WHERE ID_GERENCIA='$this->idGerencia' AND ID_DIVISION='$this->idDivision' AND ID_DEPARTAMENTO='$this->idDepartamento' AND ID_SITIO='$this->idSitio'";
			$result=mysql_query($conBuscar);
			$num=mysql_num_rows($result);
			if($num>0) {
				//Entra siempre y cuando consiga un registro
				$row=mysql_fetch_array($result);
				mysql_close();
				return 0;
			} else {
				//No consiguio ningun Registro
				mysql_close();
				return 1;
			}
		}
		function buscar() {
			conectarMysql();
			$conBuscar="SELECT ID_UBICACION FROM ubicacion WHERE ID_GERENCIA='$this->idGerencia' AND ID_DIVISION='$this->idDivision' AND ID_DEPARTAMENTO='$this->idDepartamento' AND ID_SITIO='$this->idSitio'";
			$result=mysql_query($conBuscar);
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
		function retornarUbicacion() {
			require_once("conexionsql.php");
			$conBuscar="Select
				gerencia.ID_GERENCIA,
				gerencia.GERENCIA,
				division.ID_DIVISION,
				division.DIVISION,
				departamento.ID_DEPARTAMENTO,
				departamento.DEPARTAMENTO
				From
				gerencia
				Inner Join division ON gerencia.ID_GERENCIA = division.ID_GERENCIA
				Inner Join departamento ON division.ID_DIVISION = departamento.ID_DIVISION where id_departamento='$this->idDepartamento'";
			conectarMysql();
			$result=mysql_query($conBuscar);
			mysql_close();
			if ($result && mysql_numrows($result)>0) {
				return $result;
			} else {
				return 1;	
			}
		}
		function retornarSitio() {
			require_once("conexionsql.php");
			$conBuscar="SELECT ID_SITIO, SITIO from sitio where id_sitio='$this->idSitio'";
			conectarMysql();
			$result=mysql_query($conBuscar);
			mysql_close();
			if ($result && mysql_numrows($result)) {
				return $result;	
			} else {
				return 1;
			}
		}
		
}


class cargo {
	private
	$idCargo,
	$cargo,
	$statusActivo;

	function __construct($idCargo="",$cargo="",$statusActivo=1) {
		$this->idCargo=$idCargo;
		$this->cargo=strtoupper($cargo);
		$this->statusActivo=$statusActivo;	
	}
	
	function setCargo($idCargo="",$cargo="",$statusActivo=1) {
		$this->idCargo=$idCargo;
		$this->cargo=strtoupper($cargo);
		$this->statusActivo=$statusActivo;
	}
	
	function nuevoIdCargo() {
		$conUltimo="select id_cargo from cargo order by id_cargo desc limit 1";
		$cons=new consecutivo("ORG",$conUltimo);
		$this->idCargo=$cons->retornar();
	}
	
	function buscarDuplicado() {
		$consulta="select id_cargo from cargo where id_cargo<>'$this->idCargo' and cargo='$this->cargo'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)) {
			return 0;	
		} else {
			return 1;	
		}
	}
	
	function ingresar() {
		$this->nuevoIdCargo();
		if ($this->buscarDuplicado()==0) {
			return 2;	
		}
		$conIngresar="insert into cargo (id_cargo,cargo)
		values ('$this->idCargo','$this->cargo')";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
		if ($result) {
			return 0;
		} else {
			return 1;
		}	
	}
	function modificar() {
		if ($this->buscarDuplicado()==0) {
			return 2;	
		}
		
		$conModificar="update cargo set cargo='$this->cargo' where id_cargo='$this->idCargo'";
		conectarMysql();
		$result=mysql_query($conModificar);
		$affected=mysql_affected_rows();
		mysql_close();

		if ($result && $affected>0) {
			return 0;
		} else {
			return 1;
		}
		
	}
	
	function buscarCargo() {
		$consulta="select id_cargo,cargo from cargo where id_cargo='$this->idCargo'";
		
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

class fecha {
	private $dia,
		$mes,
		$anho,
		$fecha;
		
	function fecha($fecha="") {
		$this->fecha=$fecha;
		$this->dia=substr($this->fecha,0,2);
		$this->mes=substr($this->fecha,3,2);
		$this->anho=substr($this->fecha,6,4);
	}
	function validar() {
		if (strlen($this->fecha)==10) {
			if (substr($this->fecha,2,1)=="/" && substr($this->fecha,5,1)=="/") {
				if (checkdate($this->mes,$this->dia,$this->anho)==true) {
					//La Fecha es Valida
					return 0;
				} else {
					//La Fecha es Invalida
					return 1;
				}
			} else {
				//La Fecha es Invalida
				return 1;
			}
		} else {
			//La Fecha es Invalida
			return 1;
		}	
	}
}
function compara_fechas($fecha1,$fecha2)
{
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
              list($dia1,$mes1,$anho1)=split("/",$fecha1);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
              list($dia1,$mes1,$anho1)=split("-",$fecha1);
        if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
              list($dia2,$mes2,$anho2)=split("/",$fecha2);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
              list($dia2,$mes2,$anho2)=split("-",$fecha2);
        $dif = mktime(0,0,0,$mes1,$dia1,$anho1) - mktime(0,0,0, $mes2,$dia2,$anho2);
        return ($dif);                         
}
?>
