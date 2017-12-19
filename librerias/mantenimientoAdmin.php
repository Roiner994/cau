<?php
//Mantenimiento Administracion
require_once("administracion.php");
require_once("conexionsql.php");

/**
 * Clase del Mantenimiento Preventivo
 *
 */
class mantenimiento {
	private $idMantenimiento,
	$configuracion,
	$idUss,
	$ficha,
	$horaInicio,
	$horaFinal,
	$statusMantenimiento,
	$idSitio,
	$idDepartamento,
	$ubicacion,
	$so,
	$observacionSO,
	$antivirus,
	$observacionAntivirus,
	$red,
	$observacionRed,
	$trabajoRealizado,
	$observacion,
	$pendiente,
	$puntoPendiente,
	$correctivo,
	$docCorrectivo,
	$cantidadHojas,
	$idUssAdmin;
	
	function mantenimiento($idMantenimiento="",$configuracion="",$idUss="",$ficha="",$horaInicio="",$horaFinal="",
	$statusMantenimiento="",$idUssAdmin="",$idDepartamento="",$idSitio="",$ubicacion="",$cantidadHojas=0,$antivirus=0,$so=0) {
		$this->idMantenimiento=$idMantenimiento;
		$this->configuracion=$configuracion;
		$this->idUss=$idUss;
		$this->ficha=$ficha;
		$this->horaInicio=$horaInicio;
		$this->horaFinal=$horaFinal;
		$this->statusMantenimiento=$statusMantenimiento;
		$this->idUssAdmin=$idUssAdmin;
		$this->idSitio=$idSitio;
		$this->ubicacion=$ubicacion;
		$this->idDepartamento=$idDepartamento;
		$this->cantidadHojas=$cantidadHojas;
		$this->antivirus=$antivirus;
		//$this->txtAntivirus=$txtAntivirus;
		$this->so=$so;
		//$this->txtSO=$txtSO;
	}
	function verificarMantenimiento() {
		if ($this->retornarUltimoMantenimiento()==1) {
			return 3;		
		}

		$consulta="select mantenimiento from equipo_campo where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			if ($row[0]==1)
				return 1;
			else
				return 4;
		} else {
			return 2;
		}	
	}
	
	function verificarMantenimientoSinCompletar() {
		$consulta="Select
			mantenimiento_preventivo.ID_MANTENIMIENTO
			From
			mantenimiento_preventivo
			Where
			mantenimiento_preventivo.CONFIGURACION = '$this->configuracion' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '1'";
		
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result  && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			$this->idMantenimiento=$row[0];
			return 0;
		} else {
			return 1;	
		}
	}
	function verificarTecnicoMantenimiento() {
		$consulta="Select ID_MANTENIMIENTO, CONFIGURACION, ID_USS,NOMBRE,APELLIDO from vistamantenimientospreventivos where id_mantenimiento='$this->idMantenimiento'";
		
		
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if (result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[2];	
		} else {
			return 1;
		}
	}
	
	function retornaUltimoMantenimiento() {
		$consulta="Select
			mantenimiento_preventivo.ID_MANTENIMIENTO,
			mantenimiento_preventivo.CONFIGURACION,
			usuario_sistema.ID_USS,
			usuario_sistema.NOMBRE,
			usuario_sistema.APELLIDO,
			DATE_FORMAT(hora_inicio,'%d/%m/%Y'),
			sitio.ID_SITIO,
			sitio.SITIO
			From
			mantenimiento_preventivo
			Inner Join usuario_sistema ON mantenimiento_preventivo.ID_USS = usuario_sistema.ID_USS
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Where
			mantenimiento_preventivo.CONFIGURACION = '$this->configuracion'
			Order By
			mantenimiento_preventivo.HORA_INICIO Desc
			Limit 1";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;	
		}
	}
	
	function verificarTiempoMantenimiento() {
		$consulta="Select
			mantenimiento_preventivo.ID_MANTENIMIENTO,
			mantenimiento_preventivo.CONFIGURACION,
			mantenimiento_preventivo.HORA_INICIO,
			mantenimiento_preventivo.STATUS_MANTENIMIENTO,
			mantenimiento_preventivo.HORA_FINAL,
			datediff(curdate(),mantenimiento_preventivo.hora_inicio) as dias
			From
			mantenimiento_preventivo
			Where
			mantenimiento_preventivo.CONFIGURACION = '$this->configuracion' and mantenimiento_preventivo.STATUS_MANTENIMIENTO=2
			Order By
			mantenimiento_preventivo.HORA_INICIO Desc limit 1";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			if ($row[5]>60) {
				//El mantenimiento tiene mas de 2 meses
				return 0;
			} else {
				// El mantenimiento no tiene mas de 2 meses
				return 1;	
			}
		} else {
			//No se encontró mantenimientos para este equipo
			return 2;	
		}
	}
	function habilitarMantenimiento() {	
		$consulta="update equipo_campo set mantenimiento=1 where configuracion='$this->configuracion'";
		
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	function verificarSiEquipoExiste() {
		$consulta="select id_inventario from equipo_campo where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return 0;	
		} else {
			return 1;	
		}
	}
	function verificarSiMantenimientoHabilitado() {
		$consulta="select configuracion from equipo_campo where configuracion='$this->configuracion' and mantenimiento=1";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)) {
			return 0;	
		} else {
			return 1;	
		}
	}
	function retornarEstadoMantenimiento() {
		if ($this->verificarSiEquipoExiste()==1) {
			return 1;	
		}
		if ($this->verificarSiMantenimientoHabilitado()==0) {
			return 6;	
		}
		
		
		if ($this->verificarMantenimientoSinCompletar()==0) {
			return 2;
		}
		switch ($this->verificarTiempoMantenimiento()) {
			case 0:
				//$resultado=$this->habilitarMantenimiento();
				return 3;
				break 1;
			case 1:
				return 4;
				break 1;
			case 2:
				return 5;
				break 1;	
		}
	}
	
	function setDatosMantenimiento($idMantenimiento="",$configuracion="",$idUss="") {
		$this->idMantenimiento=$idMantenimiento;
		$this->configuracion=strtoupper($configuracion);
		$this->idUss=$idUss;
	}
	function setUsuario($ficha) {
		$this->ficha=$ficha;
	}
	function setUbicacion($idDepartamento="",$idSitio="",$ubicacion="") {
		$this->idDepartamento=$idDepartamento;
		$this->idSitio=$idSitio;
		$this->ubicacion=$ubicacion;
	}
	function setDetalleMantenimiento($so=0,$antivirus=0,$trabajoRealizado,$observacion,$correctivo=0,$docCorrectivo) {
		$this->so=$so;
		$this->antivirus=$antivirus;
		$this->trabajoRealizado=$trabajoRealizado;
		$this->observacion=$observacion;
		$this->correctivo=$correctivo;
		$this->docCorrectivo=$docCorrectivo;
		//$this->txtSO=$txtSO;
		//$this->txtAntivirus=$txtAntivirus;

	}
	function setHoraFinal($horaFinal) {
		$this->horaFinal=$horaFinal;
	}
	function ingresarMantenimiento() {
		require_once("inventarioAdmin.php");
		//Retorna la Ubicacion de El Equipo para almacenarla en el Mantenimiento
		$equipoBuscar=new equipo();
		$equipoBuscar->setEquipo($this->configuracion);
		$resultado=$equipoBuscar->buscarEquipo();
		if ($equipoBuscar->retornarUltimaUbicacion('d')!=1) {
			$this->idSitio=$equipoBuscar->retornarUltimaUbicacion('u');
			$this->idDepartamento=$equipoBuscar->retornarUltimaUbicacion('d');
			$this->ubicacion=$equipoBuscar->retornarUltimaUbicacion('e');
		}
		
		$conUltimo="select id_mantenimiento from mantenimiento_preventivo order by id_mantenimiento DESC";
		$cons=new consecutivo("MAN",$conUltimo);
		$this->idMantenimiento=$cons->retornar();		

		$this->horaInicio=getdate();
		$this->horaInicio=$this->horaInicio[year]."-".$this->horaInicio[mon]."-".$this->horaInicio[mday]." ".
		$this->horaInicio[hours].":".$this->horaInicio[minutes].":".$this->horaInicio[seconds];
		$consulta="insert into mantenimiento_preventivo(id_mantenimiento,configuracion,id_uss,hora_inicio,id_sitio,id_departamento,ubicacion)
		values ('$this->idMantenimiento','$this->configuracion','$this->idUss','$this->horaInicio','$this->idSitio','$this->idDepartamento','$this->ubicacion')";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
 		if ($result) {
			$this->noMantenimiento();
			return 0;	
		} else {
			return 1;
		}
	}
	function continuarMantenimiento() {
		$consulta="Select
			mantenimiento_preventivo.ID_MANTENIMIENTO,
			mantenimiento_preventivo.CONFIGURACION,
			mantenimiento_preventivo.ID_USS,
			mantenimiento_preventivo.FICHA,
			mantenimiento_preventivo.ID_DEPARTAMENTO,
			mantenimiento_preventivo.ID_SITIO,
			mantenimiento_preventivo.HORA_INICIO,
			mantenimiento_preventivo.HORA_FINAL,
			mantenimiento_preventivo.STATUS_MANTENIMIENTO,
			mantenimiento_preventivo.ID_USS_ADMIN
			From
			mantenimiento_preventivo 
			where configuracion='$this->configuracion' and status_mantenimiento=1 and id_uss='$this->idUss'";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			$this->idMantenimiento=$row[0];
			$this->configuracion=$row[1];
			$this->horaInicio=$row[6];
			mysql_close();	
			return 1;
		} else {
			mysql_close();
			return 0;	
		}		
	}
	function verMantenimientoAbierto() {
		$consulta="select configuracion from mantenimiento_preventivo 
		where configuracion<>'$this->configuracion' and status_mantenimiento=1 and id_uss='$this->idUss'";
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
	function retornarMantenimiento($statusMantenimiento=1) {
		$consulta="Select
			mantenimiento_preventivo.ID_MANTENIMIENTO,
			mantenimiento_preventivo.CONFIGURACION,
			mantenimiento_preventivo.ID_USS,
			mantenimiento_preventivo.FICHA,
			mantenimiento_preventivo.ID_DEPARTAMENTO,
			mantenimiento_preventivo.ID_SITIO,
			mantenimiento_preventivo.UBICACION,
			mantenimiento_preventivo.HORA_INICIO,
			mantenimiento_preventivo.HORA_FINAL,
			mantenimiento_preventivo.STATUS_MANTENIMIENTO,
			mantenimiento_preventivo.SISTEMA_OPERATIVO,
			mantenimiento_preventivo.ANTIVIRUS,
			mantenimiento_preventivo.TRABAJO_REALIZADO,
			mantenimiento_preventivo.OBSERVACION,
			mantenimiento_preventivo.CORRECTIVO,
			mantenimiento_preventivo.TRABAJO_CORRECTIVO,
			mantenimiento_preventivo.CANT_HOJAS_IMPRESAS,
			TIME_TO_SEC(TIMEDIFF(HORA_FINAL,HORA_INICIO))/60 AS TIEMPO_EJECUCION
			From
			mantenimiento_preventivo
			Where
			mantenimiento_preventivo.ID_MANTENIMIENTO = '$this->idMantenimiento' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '$statusMantenimiento'";
		
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
		
	}
	function retornarMantenimientoPlanilla() {
		$consulta="Select
			mantenimiento_preventivo.ID_MANTENIMIENTO,
			mantenimiento_preventivo.FICHA,
			usuario.NOMBRE_USUARIO,
			usuario.APELLIDO_USUARIO,
			usuario.ID_CARGO,
			cargo.CARGO,
			usuario.EXTENSION,
			mantenimiento_preventivo.CONFIGURACION,
			equipo_campo.ACTIVO_FIJO,
			equipo_campo.ID_INVENTARIO,
			gerencia.ID_GERENCIA,
			gerencia.GERENCIA,
			division.ID_DIVISION,
			division.DIVISION,
			division.Centro_Costo,
			departamento.ID_DEPARTAMENTO,
			departamento.DEPARTAMENTO,
			sitio.ID_SITIO,
			sitio.SITIO,
			mantenimiento_preventivo.HORA_INICIO,
			mantenimiento_preventivo.HORA_FINAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD
			From
			mantenimiento_preventivo
			Inner Join usuario ON mantenimiento_preventivo.FICHA = usuario.FICHA
			Inner Join cargo ON usuario.ID_CARGO = cargo.ID_CARGO
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join departamento ON mantenimiento_preventivo.ID_DEPARTAMENTO = departamento.ID_DEPARTAMENTO
			Inner Join division ON departamento.ID_DIVISION = division.ID_DIVISION
			Inner Join gerencia ON division.ID_GERENCIA = gerencia.ID_GERENCIA
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			,
			descripcion
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO AND modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Where
			mantenimiento_preventivo.ID_MANTENIMIENTO = '$this->idMantenimiento'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;
		}	
	}
	function retornaridMantenimiento() {
		return $this->idMantenimiento;	
	}
	function retornarUltimoMantenimiento() {
		$consulta="Select
		mantenimiento_preventivo.ID_MANTENIMIENTO,
		mantenimiento_preventivo.CONFIGURACION,
		mantenimiento_preventivo.HORA_INICIO,
		mantenimiento_preventivo.STATUS_MANTENIMIENTO,
		mantenimiento_preventivo.HORA_FINAL,
		datediff(curdate(),mantenimiento_preventivo.hora_inicio) as dias
		From
		mantenimiento_preventivo
		Where
		mantenimiento_preventivo.CONFIGURACION = '$this->configuracion'";
		conectarMysql();

		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			$row=mysql_fetch_array($result);
			if ($row[3]==1) {
				//tiene un mantenimiento pendiente
				return 1;	
		} else {
			if ($row[5]>=60) {
				$consulta="update equipo_campo set matenimiento=1 where configuracion='$this->configuracion'";
				conectarMysql();
				$result=mysql_query($consulta);
				mysql_close();
			}
			return 0;
		}
		}
	}
	function actualizarMantenimiento($status=1) {
		/**
		 * Sirve para Actualizar el Mantenimiento
		 */
		
		
		$conActualizar="update mantenimiento_preventivo set
		ficha='$this->ficha',
		id_departamento='$this->idDepartamento',
		id_sitio='$this->idSitio',
		ubicacion='$this->ubicacion',
		SISTEMA_OPERATIVO='$this->so',
		ANTIVIRUS='$this->antivirus',
		TRABAJO_REALIZADO='$this->trabajoRealizado',
		OBSERVACION='$this->observacion',
		CORRECTIVO='$this->correctivo',
		TRABAJO_CORRECTIVO='$this->docCorrectivo',
		status_mantenimiento=$status
		where id_mantenimiento='$this->idMantenimiento'";
		conectarMysql();
		$result=mysql_query($conActualizar);
		mysql_close();
		if ($result){
			return 0;
		} else {
			return 1;
		}

	}
	function finalizarMantenimiento() {
		//$this->horaFinal=getdate();
		//$this->horaFinal=$this->horaFinal[year]."-".$this->horaFinal[mon]."-".$this->horaFinal[mday]." ".
		//$this->horaFinal[hours].":".$this->horaFinal[minutes].":".$this->horaFinal[seconds];

		switch ($this->horaFinal) {
			case 45:
				$hora='00:45';
				break 1;
			case 60:
				$hora='01:00';
				break 1;
			case 90:
				$hora='01:30';
				break 1;
			case 120:
				$hora='02:00';
				break 1;
		}
		$conActualizar="update mantenimiento_preventivo set 
		status_mantenimiento=2,
		hora_final=ADDTIME(HORA_INICIO, '$hora') where id_mantenimiento='$this->idMantenimiento'";
		conectarMysql();
		$result=mysql_query($conActualizar);
		mysql_close();
		if ($result) {
			$this->obtenerConfiguracion();
			$noMantenimiento=$this->noMantenimiento();
			return 0;	
		} else {
			return 1;	
		}
	}
	function obtenerConfiguracion() {
		$consulta="select configuracion from mantenimiento_preventivo where id_mantenimiento='$this->idMantenimiento'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			$row=mysql_fetch_array($result);
			$this->configuracion=$row[0];	
		} else {
			
		}
	}
	function noMantenimiento() {
		$conActualizar="update equipo_campo set mantenimiento=0 where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($conActualizar);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	
	function retornarSitiosConMantenimientos($fechaInicial,$fechaFinal) {
		$consulta="Select distinct
			sitio.ID_SITIO,
			sitio.SITIO
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Where
			mantenimiento_preventivo.HORA_INICIO Between '$fechaInicial' AND '$fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2'
			Order By
			sitio.SITIO Asc";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;
		}
	}
	
	function retornaMantenimientosPorPersonas($fechaInicial="",$fechaFinal="",$idUss="") {
		$rangoFecha="";
		if ((isset($fechaInicial) && !empty($fechaInicial)) && (isset($fechaFinal) && !empty($fechaFinal))) {
		 	$fechaInicial=substr($fechaInicial,6,6)."-".substr($fechaInicial,3,2)."-".substr($fechaInicial,0,2);
		 	$fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
			$rangoFecha=" mantenimiento_preventivo.HORA_INICIO Between '$fechaInicial' AND '$fechaFinal' AND ";
		}
		
		$consulta="Select
		usuario_sistema.ID_USS,
		usuario_sistema.NOMBRE,
		usuario_sistema.APELLIDO,
		Count(mantenimiento_preventivo.CONFIGURACION) AS cuenta,
		SUM(TIME_TO_SEC(TIMEDIFF(HORA_FINAL,HORA_INICIO))/3600) AS SUMA_HORAS,
		(SUM(TIME_TO_SEC(TIMEDIFF(HORA_FINAL,HORA_INICIO))/3600)/count(*)) AS PROMEDIO
		From
		mantenimiento_preventivo
		Inner Join usuario_sistema ON mantenimiento_preventivo.ID_USS = usuario_sistema.ID_USS
		Where
		$rangoFecha
		mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' and
		mantenimiento_preventivo.id_uss like '%$idUss'
		Group By
		usuario_sistema.NOMBRE,
		usuario_sistema.APELLIDO
		Order By
		cuenta Desc";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;	
		}
	}
	
	function retornaMantenimientos($idUss="",$fechaInicial="",$fechaFinal="",$statusMantenimiento=2,$idGerencia="",$idSitio="",$idDescripcion="",$correctivo="",$red="",$sistemaOperativo="",$antivirus="",$configuracion="") {
		$rangoFecha="";
		if ((isset($fechaInicial) && !empty($fechaInicial)) && (isset($fechaFinal) && !empty($fechaFinal))) {
		 	$fechaInicial=substr($fechaInicial,6,6)."-".substr($fechaInicial,3,2)."-".substr($fechaInicial,0,2);
		 	$fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
			$rangoFecha=" vistamantenimientospreventivos.HORA_INICIO Between '$fechaInicial' AND '$fechaFinal' AND ";
		}
		
		$consulta="SELECT * from vistamantenimientospreventivos
		Where 
		$rangoFecha
		vistamantenimientospreventivos.STATUS_MANTENIMIENTO like '%$statusMantenimiento' and
		vistamantenimientospreventivos.id_uss like '%$idUss' and
		vistamantenimientospreventivos.id_mantenimiento like '%$this->idMantenimiento' and
		vistamantenimientospreventivos.ID_GERENCIA like '%$idGerencia' and
		vistamantenimientospreventivos.ID_SITIO like '%$idSitio' and
		vistamantenimientospreventivos.ID_DESCRIPCION like '%$idDescripcion' and 
		vistamantenimientospreventivos.CORRECTIVO like '%$correctivo' and
		vistamantenimientospreventivos.SISTEMA_OPERATIVO like '%$sistemaOperativo' and
		vistamantenimientospreventivos.ANTIVIRUS like '%$antivirus' and
		vistamantenimientospreventivos.CONFIGURACION like '%$configuracion'
		";
		conectarMysql();
		$result=mysql_query($consulta);	
		mysql_close();
		if ($result && mysql_num_rows($result)>0) {
			return $result;	
		} else {
			return 1;	
		}
	}

	function buscarMantenimiento() {
		$consulta="select *,(SELECT ID_PLANILLA_MANTENIMIENTO FROM planillas_mantenimientos WHERE  ID_MANTENIMIENTO=vistamantenimientospreventivos.ID_MANTENIMIENTO  ORDER BY FECHA_CREACION DESC LIMIT 1)as pla from vistamantenimientospreventivos where configuracion like'%$this->configuracion'  and status_mantenimiento=2 order by fecha_inicio desc";
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


class reporteMantenimientos {
	private $fechaInicio,
	$fechaFinal,
	$idSitio,
	$idDepartamento,
	$idGerencia,
	$idDivision,
	$soActualizado,
	$puntoRed,
	$mantCorrectivo,
	$configuracion,
	$ficha,
	$idUss;
	function __construct($fechaInicio="",$fechaFinal="",$idSitio="",$idGerencia="",$idDivision="",$idDepartamento="",$soActualizado=0,
	$puntoRed=0,$mantCorrectivo=1,$configuracion="",$ficha="",$idUss="") {
		$this->fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
		$this->fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
		$this->idSitio=$idSitio;
		$this->idGerencia=$idGerencia;
		$this->idDivision=$idDivision;
		$this->idDepartamento=$IdDepartamento;
		$this->soActualizado=$soActualizado;
		$this->puntoRed=$puntoRed;
		$this->mantCorrectivo=$mantCorrectivo;
		$this->configuracion=$configuracion;
		$this->ficha=$ficha;
		$this->idUss=$idUss;
	}
	function retornarMantenimientosPorEdificios($soActualizado="",$antivirusActualizado="",$red="",$correctivo="") {
		if ($soActualizado==0 || $antivirusActualizado==0) {
			$descrip=" AND (descripcion.ID_DESCRIPCION = 'DES0000001' OR descripcion.ID_DESCRIPCION = 'DES0000042')";
		} else {
			unset($descrip);	
		}
		$consultaSitio="Select distinct
			sitio.ID_SITIO,
			sitio.SITIO
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Where
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.SISTEMA_OPERATIVO LIKE '%$soActualizado' AND
			mantenimiento_preventivo.ANTIVIRUS LIKE '%$antivirusActualizado' AND
			mantenimiento_preventivo.CORRECTIVO LIKE '%$correctivo' AND
			mantenimiento_preventivo.RED LIKE '%$red' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' $descrip
			Order By
			sitio.SITIO Asc";
		conectarMysql();
		$result=mysql_query($consultaSitio);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;	
		}
	}
	function retornarCantidadEquipos($idSitio="",$idDescripcion="",$agruparPor="a") {
		switch ($agruparPor) {
			case "a":
				$agrupar="Group By sitio.ID_SITIO,descripcion.ID_DESCRIPCION";
				break 1;
			case "s":
				$agrupar="Group By sitio.ID_SITIO";
				break 1;
			case "d":
				$agrupar="Group By descripcion.ID_DESCRIPCION";
				break 1;
			default:
				$agrupar="Group By sitio.ID_SITIO,descripcion.ID_DESCRIPCION";
		}

		$consulta="Select
			sitio.ID_SITIO,
			sitio.SITIO,
			Count(mantenimiento_preventivo.CONFIGURACION) AS CANTIDAD,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Where
			sitio.ID_SITIO like '%$idSitio' AND
			descripcion.ID_DESCRIPCION like '%$idDescripcion' AND
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' $agrupar";
		conectarMysql();
		$result=mysql_query($consulta);	
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[2];	
		} else {
			return 0;	
		}
	}
	function totalMantenimientos() {
		$consulta="Select
			Count(mantenimiento_preventivo.CONFIGURACION) AS cantidad
			From
			mantenimiento_preventivo
			Where 
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[0];	
		} else {
			return 0;	
		}
	}
	function soSinActualizar($idSitio="") {
		$consulta="Select
			sitio.ID_SITIO,
			sitio.SITIO,
			Count(mantenimiento_preventivo.CONFIGURACION),
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Where
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
			mantenimiento_preventivo.SISTEMA_OPERATIVO = '0' AND
			sitio.ID_SITIO Like '%$idSitio' AND
			(descripcion.ID_DESCRIPCION = 'DES0000001' OR
			descripcion.ID_DESCRIPCION = 'DES0000042')
			Group By
			sitio.ID_SITIO,
			sitio.SITIO";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[2];	
		} else {
			return 0;	
		}
	}
	function equiposSinRed($idSitio="") {
		$consulta="Select
			sitio.ID_SITIO,
			sitio.SITIO,
			Count(mantenimiento_preventivo.CONFIGURACION)
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Where
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
			mantenimiento_preventivo.RED = '0' AND
			sitio.ID_SITIO LIKE '%$idSitio'
			Group By
			sitio.ID_SITIO,
			sitio.SITIO";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[2];	
		} else {
			return 0;	
		}
	}
	function equiposSinAntivirus($idSitio="") {
		$consulta="Select
			sitio.ID_SITIO,
			sitio.SITIO,
			Count(mantenimiento_preventivo.CONFIGURACION),
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Where
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
			mantenimiento_preventivo.ANTIVIRUS = '0' AND
			sitio.ID_SITIO Like '%$idSitio' AND
			(descripcion.ID_DESCRIPCION = 'DES0000001' OR
			descripcion.ID_DESCRIPCION = 'DES0000042')
			Group By
			sitio.ID_SITIO,
			sitio.SITIO";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[2];	
		} else {
			return 0;	
		}
	}
	function equipoMantCorrectivo($idSitio="") {
		$consulta="Select
			sitio.ID_SITIO,
			sitio.SITIO,
			Count(mantenimiento_preventivo.CONFIGURACION)
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Where
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
			mantenimiento_preventivo.CORRECTIVO = '1' AND
			sitio.ID_SITIO LIKE '%$idSitio'
			Group By
			sitio.ID_SITIO,
			sitio.SITIO";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[2];	
		} else {
			return 0;	
		}
	}
	function cantidadEquipoSinSo() {
		$consulta="Select
		Count(mantenimiento_preventivo.CONFIGURACION)
		From
		mantenimiento_preventivo
		Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
		Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
		Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
		Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
		Where
		mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
		mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
		mantenimiento_preventivo.SISTEMA_OPERATIVO = '0' AND
		(descripcion.ID_DESCRIPCION = 'DES0000001' OR
		descripcion.ID_DESCRIPCION = 'DES0000042')";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[0];	
		} else {
			return 0;	
		}

	}
	function cantidadEquipoSinRed() {
		$consulta="Select
			Count(mantenimiento_preventivo.CONFIGURACION)
			From
			mantenimiento_preventivo
			Where
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
			mantenimiento_preventivo.RED = '0'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[0];	
		} else {
			return 0;	
		}

	}
	function cantidadEquipoSinAntivirus() {
		$consulta="Select
		Count(mantenimiento_preventivo.CONFIGURACION)
		From
		mantenimiento_preventivo
		Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
		Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
		Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
		Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
		Where
		mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
		mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
		mantenimiento_preventivo.ANTIVIRUS = '0' AND
		(descripcion.ID_DESCRIPCION = 'DES0000001' OR
		descripcion.ID_DESCRIPCION = 'DES0000042')";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[0];	
		} else {
			return 0;	
		}

	}
	function cantidadCorrectivos() {
		$consulta="Select
			Count(mantenimiento_preventivo.CONFIGURACION)
			From
			mantenimiento_preventivo
			Where
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
			mantenimiento_preventivo.CORRECTIVO = '1'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[0];	
		} else {
			return 0;	
		}
	}
	function detalleMantenimiento($idSitio="",$so="",$soloComputadoras=0,$antivirus="",$red="",$correctivo="") {
		switch ($soloComputadoras) {
			case 1:
				$descrip=" AND (descripcion.ID_DESCRIPCION = 'DES0000001' OR descripcion.ID_DESCRIPCION = 'DES0000042')";
				break 1;
			default:
				$descrip="";
		}
		$consulta="Select
			mantenimiento_preventivo.ID_MANTENIMIENTO,
			mantenimiento_preventivo.CONFIGURACION,
			equipo_campo.ACTIVO_FIJO,
			equipo_campo.ID_INVENTARIO,
			inventario.ID_INVENTARIO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			mantenimiento_preventivo.ID_USS,
			usuario_sistema.NOMBRE,
			usuario_sistema.APELLIDO,
			mantenimiento_preventivo.FICHA,
			usuario.CEDULA,
			usuario.NOMBRE_USUARIO,
			usuario.APELLIDO_USUARIO,
			usuario.EXTENSION,
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
			mantenimiento_preventivo.HORA_INICIO,
			mantenimiento_preventivo.HORA_FINAL,
			mantenimiento_preventivo.STATUS_MANTENIMIENTO,
			mantenimiento_preventivo.ID_USS_ADMIN,
			mantenimiento_preventivo.SISTEMA_OPERATIVO,
			mantenimiento_preventivo.OBSERVACION_SISTEMA_OPERATIVO,
			mantenimiento_preventivo.ANTIVIRUS,
			mantenimiento_preventivo.OBSERVACION_ANTIVIRUS,
			mantenimiento_preventivo.RED,
			mantenimiento_preventivo.OBSERVACION_RED,
			mantenimiento_preventivo.TRABAJO_REALIZADO,
			mantenimiento_preventivo.OBSERVACION,
			mantenimiento_preventivo.PENDIENTE,
			mantenimiento_preventivo.PUNTO_PENDIENTE,
			mantenimiento_preventivo.CORRECTIVO,
			mantenimiento_preventivo.TRABAJO_CORRECTIVO,
			mantenimiento_preventivo.FECHA_CIERRE
			From
			mantenimiento_preventivo
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join usuario_sistema ON mantenimiento_preventivo.ID_USS = usuario_sistema.ID_USS
			Left Join usuario ON mantenimiento_preventivo.FICHA = usuario.FICHA
			Left Join cargo ON usuario.ID_CARGO = cargo.ID_CARGO
			Inner Join departamento ON mantenimiento_preventivo.ID_DEPARTAMENTO = departamento.ID_DEPARTAMENTO
			Inner Join division ON departamento.ID_DIVISION = division.ID_DIVISION
			Inner Join gerencia ON division.ID_GERENCIA = gerencia.ID_GERENCIA
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			WHERE
			mantenimiento_preventivo.HORA_INICIO Between '$this->fechaInicio' AND '$this->fechaFinal' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
			mantenimiento_preventivo.ID_SITIO LIKE '%$idSitio' AND
			mantenimiento_preventivo.ANTIVIRUS LIKE '%$antivirus' AND
			mantenimiento_preventivo.RED LIKE '%$red' AND
			mantenimiento_preventivo.CORRECTIVO LIKE '%$correctivo' AND
			mantenimiento_preventivo.SISTEMA_OPERATIVO LIKE '%$so' $descrip
			Order By
			sitio.SITIO Asc,
			descripcion.DESCRIPCION Asc,
			mantenimiento_preventivo.CONFIGURACION Asc";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;	
		}
	}

	function vistaMatenimientosPorFecha($fecha="") {
		$fecha="";
		if ((isset($fecha) && !empty($fecha))) {
		 	$fecha=substr($fecha,6,6)."-".substr($fecha,3,2)."-".substr($fecha,0,2);
		}		
		
		$consulta="Select
			sitio.ID_SITIO,
			sitio.SITIO,
			mantenimiento_preventivo.CONFIGURACION,
			descripcion.DESCRIPCION,
			marca.MARCA,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			inventario.ID_INVENTARIO,
			inventario.SERIAL,
			usuario.FICHA,
			usuario.NOMBRE_USUARIO,
			usuario.APELLIDO_USUARIO,
			inventario_propiedad.ID_ESTADO,
			inventario_estado.ESTADO,
			inventario_propiedad.FECHA_ASOCIACION,
			inventario_propiedad.STATUS_ACTUAL
			From
			mantenimiento_preventivo
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Inner Join usuario ON mantenimiento_preventivo.FICHA = usuario.FICHA
			Inner Join inventario_propiedad ON inventario.ID_INVENTARIO = inventario_propiedad.ID_INVENTARIO
			Inner Join inventario_estado ON inventario_propiedad.ID_ESTADO = inventario_estado.ID_ESTADO
			Where
			sitio.ID_SITIO Like '%$this->idSitio' AND
			mantenimiento_preventivo.HORA_INICIO < '$fecha' AND inventario_propiedad.status_actual=1 and mantenimiento_preventivo.configuracion not in (Select
			mantenimiento_preventivo.CONFIGURACION
			From
			mantenimiento_preventivo
			Inner Join sitio ON mantenimiento_preventivo.ID_SITIO = sitio.ID_SITIO
			Where
			sitio.SITIO Like '%PROYECTO%' AND
			mantenimiento_preventivo.HORA_INICIO > '$fecha'
			Group By
			mantenimiento_preventivo.CONFIGURACION
			)
			Group By
			mantenimiento_preventivo.CONFIGURACION";
		
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
