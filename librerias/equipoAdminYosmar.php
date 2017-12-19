<?php
//Administraci�n de Equipos

class equipo {
	//equipo en Campo, Equipo en Garantia
	private $configuracion,
	$activoFijo,
	//$fechaCreacion=$fechaAsociacion
	
	//Inventario
	$idInventario,
	$serial,
	$idDescripcion,
	$idMarca,
	$idModelo,
	$ct,
	$fru,
	$spareNumber,
	$productNumber,

	//Inventario Propiedad
	$idEstado,
	$disponible,
	$idPedido,
	$fechaInicio,
	$fechaFinal,
	
	//Inventario Ubicacion
	$idInventarioUbicacion,
	$idUbicacion,
	$idStatusActual,
	
	//Ubicacion
	
	$idGerencia,
	$idDivision,
	$idDepartamento,
	$idSitio,

	//Ficha Usuario
	$ficha,
	$statusActual,

	//Inventario Usuario Sistema
	$idInventarioUsuario,
	$idUss,
	$cambio,
	
	//Comun para Todos Usuario Sistema, Usuario, Ubicacion
	$fechaAsociacion;
	
	function equipo($configuracion="",$activoFijo="",$idInventario="",$serial="",$idDescripcion="",$idMarca="",$idModelo="",$ct="",$fru="",$spareNumber="",$productNumber="",
	$idEstado="",$disponible="",$idPedido="",$fechaInicio="",$fechaFinal="",$idInventarioUbicacion="",$idStatusActual="",
	$idGerencia="",$idDivision="",$idDepartamento="",$idSitio="",$ficha="99999999",$fechaAsociacion="",$statusActual="",$idInventarioUsuario="",$idUss="",
	$cambio="",$fechaAsociacion="") {
		$this->configuracion=strtoupper($configuracion);
		$this->activoFijo=strtoupper($activoFijo);
		$this->idInventario=$idInventario;
		$this->serial=strtoupper($serial);
		$this->idDescripcion=$idDescripcion;
		$this->idMarca=$idMarca;
		$this->idModelo=$idModelo;
		$this->ct=strtoupper($ct);
		$this->fru=strtoupper($fru);
		$this->spareNumber=strtoupper($spareNumber);
		$this->productNumber=strtoupper($productNumber);
		$this->idEstado=$idEstado;
		$this->disponible=$disponible;
		$this->idPedido=$idPedido;

		$this->fechaInicio=$fechaInicio;
		$anho=substr($this->fechaInicio,6,6);
		$mes=substr($this->fechaInicio,3,2);
		$dia=substr($this->fechaInicio,0,2);
		$this->fechaInicio=$anho."-".$mes."-".$dia;

		$this->fechaFinal=$fechaFinal;
		$anho=substr($this->fechaFinal,6,6);
		$mes=substr($this->fechaFinal,3,2);
		$dia=substr($this->fechaFinal,0,2);
		$this->fechaFinal=$anho."-".$mes."-".$dia;
		
		$this->idInventarioUbicacion=$idInventarioUbicacion;
		$this->idStatusActual=$idStatusActual;
		$this->idGerencia=$idGerencia;
		$this->idDivision=$idDivision;
		$this->idDepartamento=$idDepartamento;
		$this->idSitio=$idSitio;
		$this->ficha=$ficha;
		$this->fechaAsociacion=$fechaAsociacion;
		$this->statusActual=$statusActual;
		$this->idInventarioUsuario=$idInventarioUsuario;
		$this->idUss=$idUss;
		$this->cambio=strtoupper($cambio);
		$this->fechaAsociacion=$fechaAsociacion;
	
	}

	function ingresar() {
		//Ingresa un nuevo Equipo al Inventario.
		// Retorna 0 cuando ingresa el Equipo al inventario.
		// Retorna 1 cuando se hace imposible guardar el equipo por cualquier falla.
		// Retorna 2 si Existe un Serial Duplicado
		switch($this->buscarSerialDuplicado()) {
			case 0:
				return 2;
				break 1;
			case 1:
				$conUltimo="SELECT ID_INVENTARIO FROM inventario ORDER BY ID_INVENTARIO DESC";
				$cons=new consecutivo("INV",$conUltimo);
				$this->idInventario=$cons->retornar();
				conectarMysql();
				$resultadoIngresarInventario=$this->ingresarInventario();
				$resultadoIngresarInventarioPropiedad=$this->ingresarInventarioPropiedad();
				$this->cambio="NUEVO EQUIPO";
				$resultadoIngresarInventarioUsuarioSistema=$this->ingresarInventarioUsuarioSistema();
				$resultadoIngresarEquipoCampo=$this->ingresarEquipoCampo();
				if (!empty($this->fechaInicio) && !empty($this->fechaFinal) && !empty($this->idPedido)) {
					$resultadoIngresarEquipoGarantia=$this->ingresarEquipoGarantia();
				}
				$resultadoIngresarInventarioUbicacion=$this->ingresarInventarioUbicacion();
				$resultado=$resultadoIngresarInventario+$resultadoIngresarInventarioPropiedad+$resultadoIngresarInventarioUsuarioSistema+
				$resultadoIngresarEquipoCampo+$resultadoIngresarEquipoGarantia+$resultadoIngresarInventarioUbicacion;

				if ($resultado==0) {
					return 0;
				} else {
					$this->deshacerIngresar();
					return 1;
				}
		break 1;
		}
	}
	function ingresarInvMantenimiento() {
		//Ingresa un nuevo Equipo al Inventario.
		// Retorna 0 cuando ingresa el Equipo al inventario.
		// Retorna 1 cuando se hace imposible guardar el equipo por cualquier falla.
		// Retorna 2 si Existe un Serial Duplicado
		switch($this->buscarSerialDuplicado()) {
			case 0:
				return 2;
				break 1;
			case 1:
				$conUltimo="SELECT ID_INVENTARIO FROM inventario ORDER BY ID_INVENTARIO DESC";
				$cons=new consecutivo("INV",$conUltimo);
				$this->idInventario=$cons->retornar();
				conectarMysql();
				$resultadoIngresarInventario=$this->ingresarInventario();
				$resultadoIngresarInventarioPropiedad=$this->ingresarInventarioPropiedad();
				$this->cambio="NUEVO EQUIPO";
				$resultadoIngresarInventarioUsuarioSistema=$this->ingresarInventarioUsuarioSistema();
				$resultadoIngresarEquipoCampo=$this->ingresarEquipoCampo();
				if (!empty($this->fechaInicio) && !empty($this->fechaFinal) && !empty($this->idPedido)) {
					$resultadoIngresarEquipoGarantia=$this->ingresarEquipoGarantia();
				}
				$resultadoIngresarInventarioUbicacion=$this->ingresarInventarioUbicacion();
				$resultadoIngresarInventarioUsuario=$this->ingresarInventarioUsuario();
				$resultado=$resultadoIngresarInventario+$resultadoIngresarInventarioPropiedad+$resultadoIngresarInventarioUsuarioSistema+
				$resultadoIngresarEquipoCampo+$resultadoIngresarEquipoGarantia+$resultadoIngresarInventarioUbicacion+$resultadoIngresarInventarioUsuario;

				if ($resultado==0) {
					return 0;
				} else {
					$this->deshacerIngresar();
					return 1;
				}
		break 1;
		}
	}

	private function deshacerIngresar() {
		conectarMysql();
		$conEliminar="DELETE FROM inventario WHERE ID_INVENTARIO='$this->idInventario'";
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
	private function buscarSerialDuplicado() {
		conectarMysql();
		$conBuscar="SELECT ID_INVENTARIO STATUS_ACTIVO FROM inventario WHERE SERIAL='$this->serial'";
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
	
	private function buscarConfiguracionDuplicado() {
		conectarMysql();
		$conBuscar="SELECT ID_INVENTARIO FROM equipo_campo WHERE CONFIGURACION='$this->configuracion'";
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
	private function buscarActivoFijoDuplicado() {
		conectarMysql();
		$conBuscar="SELECT ID_INVENTARIO FROM equipo_campo WHERE ACTIVO_FIJO='$this->activoFijo'";
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
	private function ingresarInventario() {
			conectarMysql();
			$conUltimo="SELECT ID_INVENTARIO FROM inventario ORDER BY ID_INVENTARIO DESC";
			$cons=new consecutivo("INV",$conUltimo);
			$this->idInventario=$cons->retornar();
			$hora=getdate();
			$hora=$hora[hours].":".$hora[minutes].":".$hora[seconds];
			$conInsertar="INSERT INTO inventario (ID_INVENTARIO,SERIAL,ID_DESCRIPCION,ID_MARCA,ID_MODELO,FRU,PRODUCT_NUMBER,SPARE_NUMBER,CT,ID_PEDIDO,FECHA_INICIO,FECHA_FINAL,DISPONIBLE) VALUES 
			('$this->idInventario','$this->serial','$this->idDescripcion','$this->idMarca','$this->idModelo','$this->fru','$this->productNumber','$this->spareNumber','$this->ct','$this->idPedido','$this->fechaInicio $hora','$this->fechaFinal $hora','$this->disponible')";
			$result=mysql_query($conInsertar);
			$affected=mysql_affected_rows();
			if($affected>0) {
				mysql_close();
				return 0;
			} else {
				mysql_close();
				return 1;	
			}
	}
	private function ingresarInventarioPropiedad() {
		$conUltimo="SELECT ID_INVENTARIO_PROPIEDAD FROM inventario_propiedad ORDER BY ID_INVENTARIO_PROPIEDAD DESC";
		$cons=new consecutivo("INP",$conUltimo);
		$this->idInventarioPropiedad=$cons->retornar();
		$ubi=new ubicacion("",$this->idGerencia,$this->idDivision,$this->idDepartamento,$this->idSitio);
		$this->idUbicacion=$ubi->ingresar();
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		conectarMysql();
		$conInsertar="INSERT INTO inventario_propiedad (ID_INVENTARIO_PROPIEDAD,ID_INVENTARIO,ID_ESTADO,ID_USS,ID_UBICACION,FICHA,FECHA_CAMBIO)
		VALUES ('$this->idInventarioPropiedad','$this->idInventario','$this->idEstado','$this->idUss','$this->idUbicacion','$this->ficha','$this->fechaAsociacion')";
		$result=mysql_query($conInsertar);
		if(result) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}
	}
	private function ingresarInventarioUbicacion() {
		$conUltimo="SELECT ID_INVENTARIO_UBICACION FROM inventario_ubicacion ORDER BY ID_INVENTARIO_UBICACION DESC";
		$cons=new consecutivo("EUB",$conUltimo);
		$this->idInventarioUbicacion=$cons->retornar();
		$ubi=new ubicacion("",$this->idGerencia,$this->idDivision,$this->idDepartamento,$this->idSitio);
		$this->idUbicacion=$ubi->ingresar();
		$this->statusActual='1';
		conectarMysql();
		$conInsertar="INSERT INTO inventario_ubicacion (ID_INVENTARIO_UBICACION,ID_INVENTARIO,ID_UBICACION,STATUS_ACTUAL,FECHA_ASOCIACION) VALUES
		 ('$this->idInventarioUbicacion','$this->idInventario','$this->idUbicacion','$this->statusActual','$this->fechaAsociacion')";
		$result=mysql_query($conInsertar);
		$affected=mysql_affected_rows();
		if($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}
	}
	function CambiarUbicacion() {
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$consulta="SELECT ID_INVENTARIO FROM equipo_campo WHERE CONFIGURACION='$this->configuracion'";
		$result=mysql_query($consulta);
		if ($result) {
			$row=mysql_fetch_array($result);
			$this->idInventario=$row[0];
		}
		mysql_close();
		$this->desactivarUbicacionEquipo();
		$this->statusActual=1;
		$resultadoCambiarUbicacion=$this->ingresarInventarioUbicacion();
		
	}
	function desactivarUbicacionEquipo() {
		conectarMysql();
		$conModificar="UPDATE inventario_ubicacion SET
					STATUS_ACTUAL=0 WHERE ID_INVENTARIO='$this->idInventario'";
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
	function desactivarUbicacionComponentes() {
		conectarMysql();
		$conModificar="UPDATE inventario_ubicacion SET
					STATUS_ACTUAL=0 WHERE ID_INVENTARIO='$this->idInventario' AND STATUS_ACTUAL=1";
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
	function activarUbicacion() {
		conectarMysql();
		$conModificar="UPDATE inventario_ubicacion SET
					STATUS_ACTUAL=1 WHERE ID_INVENTARIO='$this->idInventario'";
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
	function ingresarInventarioUsuario() {
		$conUltimo="SELECT ID_INVENTARIO_USUARIO FROM inventario_usuario ORDER BY ID_INVENTARIO_USUARIO DESC";
		$cons=new consecutivo("IIU",$conUltimo);
		$this->idInventarioUsuario=$cons->retornar();		
		$consultaIngresar="insert into inventario_usuario(id_inventario_usuario,id_inventario,ficha,fecha_asociacion)
		values ('$this->idInventarioUsuario','$this->idInventario','$this->ficha','$this->fechaAsociacion')";
		conectarMysql();
		$result=mysql_query($consultaIngresar);
		$affected=mysql_affected_rows();
		if ($affected>0) {
			mysql_close();
			return 0;	
		} else {
			mysql_close();
			return 1;
		}
	}
	private function ingresarInventarioUsuarioSistema() {

		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$conUltimo="SELECT ID_INVENTARIO_USUARIO FROM inventario_usuario_sistema ORDER BY ID_INVENTARIO_USUARIO DESC";
		$cons=new consecutivo("IIU",$conUltimo);
		$this->idInventarioUsuarioSistema=$cons->retornar();
		conectarMysql();
		$conInsertar="INSERT INTO inventario_usuario_sistema (ID_INVENTARIO_USUARIO,ID_INVENTARIO,ID_USS,FECHA_ASOCIACION,CAMBIO) VALUES
		('$this->idInventarioUsuarioSistema','$this->idInventario','$this->idUss','$this->fechaAsociacion','$this->cambio')";
		
		$result=mysql_query($conInsertar);
		$affected=mysql_affected_rows();
		if($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}	
	}
	/*private function ingresarEquipoCampo() {
		conectarMysql();
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$conInsertar="INSERT INTO equipo_campo (CONFIGURACION,ACTIVO_FIJO,ID_INVENTARIO,FECHA_CREACION) VALUES
		('$this->configuracion','$this->activoFijo','$this->idInventario','$this->fechaAsociacion')";	
		$result=mysql_query($conInsertar);
		$affected=mysql_affected_rows();
		if($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}	
	}
	private function ingresarEquipoGarantia() {
		conectarMysql();
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$conInsertar="INSERT INTO equipo_garantia (CONFIGURACION,ACTIVO_FIJO,ID_INVENTARIO,FECHA_CREACION) VALUES
		('$this->configuracion','$this->activoFijo','$this->idInventario','$this->fechaAsociacion')";
		$result=mysql_query($conInsertar);
		$affected=mysql_affected_rows();
		if($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}	
	}*/
	function retornarComponenteAsociados() {
		$consultaComponentesAsociados="SELECT descripcion.DESCRIPCION,marca.Marca,concat(modelo.MODELO,\" \",modelo.CAP_VEL,modelo.UNIDAD)as MODELO,inventario.SERIAL,equipo_componente_campo.CONFIGURACION,componente_campo.ID_INVENTARIO, inventario.ID_DESCRIPCION,inventario.ID_MARCA,
		inventario.ID_MODELO 
		from equipo_componente_campo inner join componente_campo inner join inventario inner join descripcion inner join marca inner join modelo
		on equipo_componente_campo.ID_INVENTARIO=componente_campo.ID_INVENTARIO on componente_campo.ID_INVENTARIO=inventario.ID_INVENTARIO on inventario.ID_DESCRIPCION=descripcion.ID_DESCRIPCION
		on inventario.ID_MARCA=marca.ID_MARCA on inventario.ID_MODELO=modelo.ID_MODELO WHERE equipo_componente_campo.STATUS_ACTUAL=1 and equipo_componente_campo.CONFIGURACION LIKE '$this->configuracion' order by descripcion.descripcion";
		conectarMysql();
		$result=mysql_query($consultaComponentesAsociados);
		if ($result) {
			mysql_close();
			return $result;
		} else {
			mysql_close();
			return 1;
		}
	}
	function retornarEquipoCampo() {
		$consultaEquipoCampo="select equipo_campo.CONFIGURACION, equipo_campo.ACTIVO_FIJO,equipo_campo.ID_INVENTARIO,inventario.SERIAL,
		inventario.ID_DESCRIPCION,descripcion.DESCRIPCION,inventario.ID_MARCA,marca.MARCA,inventario.ID_MODELO,modelo.MODELO
		from equipo_campo inner join inventario inner join descripcion inner join marca inner join modelo
		on equipo_campo.ID_INVENTARIO=inventario.ID_INVENTARIO on inventario.ID_DESCRIPCION=descripcion.ID_DESCRIPCION on inventario.ID_MARCA=marca.ID_MARCA on inventario.ID_MODELO=modelo.ID_MODELO
		WHERE equipo_campo.CONFIGURACION LIKE '$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consultaEquipoCampo);
		$num=mysql_num_rows($result);
		if ($num>0) {
			mysql_close();
			return $result;
		} else {
			mysql_close();
			return 1;
		}
	}
	function retornarEquipoUbicacion() {
		$consultaEquipoUbicacion="select equipo_campo.CONFIGURACION,equipo_campo.ID_INVENTARIO, ubicacion.ID_GERENCIA,gerencia.GERENCIA,ubicacion.ID_DIVISION,division.DIVISION,ubicacion.ID_DEPARTAMENTO,departamento.DEPARTAMENTO,ubicacion.ID_SITIO,sitio.SITIO
		from equipo_campo inner join inventario inner join inventario_ubicacion inner join ubicacion inner join gerencia inner join division inner join departamento inner join sitio
		on equipo_campo.ID_INVENTARIO=inventario.ID_INVENTARIO on inventario.ID_INVENTARIO=inventario_ubicacion.ID_INVENTARIO
		on inventario_ubicacion.ID_UBICACION=ubicacion.ID_UBICACION on ubicacion.ID_GERENCIA=gerencia.ID_GERENCIA
		on ubicacion.ID_DIVISION=division.ID_DIVISION on ubicacion.ID_DEPARTAMENTO=departamento.ID_DEPARTAMENTO
		on ubicacion.ID_SITIO=sitio.ID_SITIO WHERE CONFIGURACION LIKE '$this->configuracion' and inventario_ubicacion.status_actual=1";
		conectarMysql();
		$result=mysql_query($consultaEquipoUbicacion);
		$num=mysql_num_rows($result);
		if ($num>0) {
			mysql_close();
			return $result;
		} else {
			mysql_close();
			return 1;
		}
	}
	function retornarEquipoUsuario() {
		$consultaEquipoUsuario="select equipo_campo.configuracion,equipo_campo.id_inventario,usuario.ficha, concat(usuario.nombre_usuario, ' ', usuario.apellido_usuario) as nombres,
		usuario.id_cargo, cargo.cargo, ubicacion.id_sitio,sitio.sitio,ubicacion.id_gerencia,gerencia.gerencia, ubicacion.id_division,division.division,ubicacion.id_departamento,departamento.departamento, usuario.extension
		from equipo_campo inner join inventario_usuario on equipo_campo.id_inventario=inventario_usuario.id_inventario
		inner join usuario on inventario_usuario.ficha=usuario.ficha
		inner join cargo on usuario.id_cargo=cargo.id_cargo
		inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion
		inner join sitio on ubicacion.id_sitio=sitio.id_sitio
		inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia
		inner join division on ubicacion.id_division=division.id_division
		inner join departamento on ubicacion.id_departamento=departamento.id_departamento
		where configuracion='$this->configuracion' order by inventario_usuario.fecha_asociacion desc limit 1";
		conectarMysql();
		$result=mysql_query($consultaEquipoUsuario);
		if ($result) {
			mysql_close();
			return $result;
		} else {
			mysql_close();
			return 1;
		}
	}
	
	function retornarIdInventario() {
		return $this->idInventario;
	}
	function retornarComponenteEquipoGarantia() {

	}
	function buscarSerial() {
		conectarMysql();
		$conBuscar="SELECT ID_INVENTARIO STATUS_ACTIVO FROM inventario WHERE SERIAL='$this->serial'";
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
	function buscarConfiguracion() {
		conectarMysql();
		$conBuscar="SELECT ID_INVENTARIO FROM equipo_campo WHERE CONFIGURACION='$this->configuracion'";
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
	function buscarActivoFijo() {
		conectarMysql();
		$conBuscar="SELECT ID_INVENTARIO FROM equipo_campo WHERE ACTIVO_FIJO='$this->activoFijo'";
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

?>