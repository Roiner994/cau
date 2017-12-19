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
	$idGerencia="",$idDivision="",$idDepartamento="",$idSitio="",$ficha="9999999",$fechaAsociacion="",$statusActual="",$idInventarioUsuario="",$idUss="",
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
	function ingresarInventarioUbicacion() {
		$conUltimo="SELECT ID_INVENTARIO_UBICACION FROM inventario_ubicacion ORDER BY ID_INVENTARIO_UBICACION DESC";
		$cons=new consecutivo("EUB",$conUltimo);
		$this->idInventarioUbicacion=$cons->retornar();
		$ubi=new ubicacion("",$this->idGerencia,$this->idDivision,$this->idDepartamento,$this->idSitio);
		$this->idUbicacion=$ubi->ingresar();
		$this->statusActual='1';
		if ($this->retornarUltimaUbicacion()!=$this->idUbicacion) {
			conectarMysql();
			$conInsertar="INSERT INTO inventario_ubicacion (ID_INVENTARIO_UBICACION,ID_INVENTARIO,ID_UBICACION,STATUS_ACTUAL,FECHA_ASOCIACION) VALUES
			 ('$this->idInventarioUbicacion','$this->idInventario','$this->idUbicacion','$this->statusActual','$this->fechaAsociacion')";
			$result=mysql_query($conInsertar);
			$affected=mysql_affected_rows();
			if($affected>0) {
				mysql_close();
				$this->desactivarUbicacionEquipo();
				return 0;
			} else {
				mysql_close();
				return 1;
			}
		}
	}
	function CambiarUbicacion() {
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$consulta="SELECT ID_INVENTARIO FROM equipo_campo WHERE CONFIGURACION='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result) {
			$row=mysql_fetch_array($result);
			$this->idInventario=$row[0];
		}
		mysql_close();
		$this->statusActual=1;
		$resultadoCambiarUbicacion=$this->ingresarInventarioUbicacion();
		
	}
	function desactivarUbicacionEquipo() {
		conectarMysql();
		$conModificar="UPDATE inventario_ubicacion SET
					STATUS_ACTUAL=0 WHERE ID_INVENTARIO='$this->idInventario' and id_inventario_ubicacion<>'$this->idInventarioUbicacion'";
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
	function setUbicacion($idGerencia,$idDivision,$idDepartamento,$idSitio) {
		$this->idGerencia=$idGerencia;
		$this->idDivision=$idDivision;
		$this->idDepartamento=$idDepartamento;
		$this->idSitio=$idSitio;	
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
	function setUsuario($ficha) {
		$this->ficha=$ficha;
	}	
	function ingresarInventarioUsuario() {
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$conUltimo="SELECT ID_INVENTARIO_USUARIO FROM inventario_usuario ORDER BY ID_INVENTARIO_USUARIO DESC";
		$cons=new consecutivo("IIU",$conUltimo);
		$this->idInventarioUsuario=$cons->retornar();		
		
		if ($this->retornarUltimoUsuario()!=$this->ficha) {
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
	private function ingresarEquipoCampo() {
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
	}
	function retornarComponenteAsociados() {
		$consultaComponentesAsociados="SELECT descripcion.DESCRIPCION,marca.Marca,
		concat(modelo.MODELO,\" \",modelo.CAP_VEL,modelo.UNIDAD) as MODELO,
		inventario.SERIAL,equipo_componente_campo.CONFIGURACION,
		componente_campo.ID_INVENTARIO, inventario.ID_DESCRIPCION,
		inventario.ID_MARCA, inventario.ID_MODELO, modelo.CAP_VEL,
		modelo.UNIDAD 
		from equipo_componente_campo 
		inner join componente_campo on equipo_componente_campo.ID_INVENTARIO=componente_campo.ID_INVENTARIO  
		inner join inventario on componente_campo.ID_INVENTARIO=inventario.ID_INVENTARIO 
		inner join descripcion on inventario.ID_DESCRIPCION=descripcion.ID_DESCRIPCION  
		inner join marca on inventario.ID_MARCA=marca.ID_MARCA 
		inner join modelo on inventario.ID_MODELO=modelo.ID_MODELO
		 WHERE equipo_componente_campo.STATUS_ACTUAL=1 and equipo_componente_campo.CONFIGURACION LIKE '$this->configuracion' order by descripcion.descripcion";
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
		$consultaEquipoCampo="select equipo_campo.CONFIGURACION, equipo_campo.ACTIVO_FIJO,equipo_campo.ID_INVENTARIO,inventario.SERIAL,inventario.ID_DESCRIPCION,descripcion.DESCRIPCION,inventario.ID_MARCA,marca.MARCA,inventario.ID_MODELO,modelo.MODELO, modelo.CAP_VEL,modelo.UNIDAD,
		inventario.id_pedido,inventario.fecha_inicio,inventario.fecha_final,inventario.disponible
		from equipo_campo
		inner join inventario on equipo_campo.ID_INVENTARIO=inventario.ID_INVENTARIO
		inner join descripcion on inventario.ID_DESCRIPCION=descripcion.ID_DESCRIPCION
		inner join marca on inventario.ID_MARCA=marca.ID_MARCA
		inner join modelo on inventario.ID_MODELO=modelo.ID_MODELO
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
		$consultaEquipoUbicacion="select equipo_campo.CONFIGURACION,equipo_campo.ID_INVENTARIO, 
		ubicacion.ID_GERENCIA,
		gerencia.GERENCIA,ubicacion.ID_DIVISION,
		division.DIVISION,ubicacion.ID_DEPARTAMENTO,
		departamento.DEPARTAMENTO,ubicacion.ID_SITIO,
		sitio.SITIO,inventario_ubicacion.id_ubicacion 
		from equipo_campo 
		inner join inventario on equipo_campo.ID_INVENTARIO=inventario.ID_INVENTARIO 
		inner join inventario_ubicacion on inventario.ID_INVENTARIO=inventario_ubicacion.ID_INVENTARIO 
		inner join ubicacion on inventario_ubicacion.ID_UBICACION=ubicacion.ID_UBICACION 
		inner join gerencia on ubicacion.ID_GERENCIA=gerencia.ID_GERENCIA 
		inner join division on ubicacion.ID_DIVISION=division.ID_DIVISION 
		inner join departamento on ubicacion.ID_DEPARTAMENTO=departamento.ID_DEPARTAMENTO 
		inner join sitio on ubicacion.ID_SITIO=sitio.ID_SITIO 
		WHERE CONFIGURACION LIKE '$this->configuracion' and inventario_ubicacion.status_actual=1 order by inventario_ubicacion.fecha_asociacion desc limit 1";
		conectarMysql();
		$result=mysql_query($consultaEquipoUbicacion);
		if ($result && mysql_num_rows($result)>0) {
			mysql_close();
			return $result;
		} else {
			mysql_close();
			return 1;
		}
	}
	function retornarEquipoPropiedad() {
		$consultaEquipoPropiedad="Select
			equipo_campo.CONFIGURACION,
			equipo_campo.ID_INVENTARIO,
			inventario_propiedad.ID_ESTADO
			From
			equipo_campo
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join inventario_propiedad ON inventario.ID_INVENTARIO = inventario_propiedad.ID_INVENTARIO
			Where
			equipo_campo.CONFIGURACION = '$this->configuracion' AND
			inventario_propiedad.STATUS_ACTUAL = '1'";
		conectarMysql();
		$result=mysql_query($consultaEquipoPropiedad);
		mysql_close();
		if ($result && mysql_num_rows($result)>0) {
			return $result;
		} else {
			return 1;
		}
	}
	function retornarUltimaUbicacion() {
		$consultaEquipoUbicacion="select id_ubicacion from inventario_ubicacion where id_inventario='$this->idInventario' order by fecha_asociacion desc limit 1";
		conectarMysql();
		$result=mysql_query($consultaEquipoUbicacion);
		if ($result) {
			mysql_close();
			$row=mysql_fetch_array($result);
			return $row[0];	
		} else {
			mysql_close();
			return 1;
		}
	}
	function retornarUltimoUsuario() {
		$consultaEquipoUsuario="select ficha from inventario_usuario where id_inventario='$this->idInventario' order by fecha_asociacion desc limit 1";
		conectarMysql();
		$result=mysql_query($consultaEquipoUsuario);
		if ($result) {
			mysql_close();
			$row=mysql_fetch_array($result);
			return $row[0];
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
	function verificarTiempoGarantia() {
		$consulta="SELECT inventario.id_inventario,inventario.fecha_inicio,inventario.fecha_final,
		DATEDIFF(inventario.fecha_final,curdate()) as diferencia_fecha
		FROM inventario
		where id_inventario='$this->idInventario'";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result) {
			mysql_close();
			$row=mysql_fetch_array($result);
			if ($row[3]>0) {
				return 0;	
			} else {
				return 2;
			}
		} else {
			mysql_close();
			return 1;
		}
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
			$row=mysql_fetch_array($result);
			$this->idInventario=$row[0];
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
	function retornarIdInventarioConfiguracion() {
		$conBuscar="SELECT ID_INVENTARIO FROM equipo_campo WHERE CONFIGURACION='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($conBuscar);
		if($result) {
			$row=mysql_fetch_array($result);
			return $row[0];
		} else {
			mysql_close();
			return 1;
		}
	}	
	function actualizarComponentesAsociados() {
		require_once("equipoAdmin.php");
		$equipo=new equipo($this->configuracion);
		$resultado=$this->retornarComponenteAsociados();
		if ($resultado && $resultado!=1) {
			while($row=mysql_fetch_array($resultado)) {
				$this->idInventario=$row[5];
				$resultadoUsuario=$this->ingresarInventarioUsuario();
				$resultadoUbicacion=$this->ingresarInventarioUbicacion();
			}	
			
		}	
	}
	function ingresarSoftware($software) {
		$listaPrivilegio=$_POST[campo];
		$tmp;
		if (count($software)>0) {
			$conDelete="delete from equipo_campo_software where configuracion='$this->configuracion'";
			conectarMysql();
			$result=mysql_query($conDelete);
			for ($i=0;$i<count($software);$i++) {
				$conInsertar="insert into equipo_campo_software(configuracion,id_software)
				values ('$this->configuracion','$software[$i]')";	
				$result=mysql_query($conInsertar);
				
			}
		}
	}
	function verificarSoftwareInstalado($idSoftware) {
		$consulta="select id_software from equipo_campo_software where configuracion='$this->configuracion' and id_software='$idSoftware'";
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
	
	
	function disponible($disponible) {
		$consulta="update inventario 
			set disponible=$disponible;
			where id_inventario='$this->idInventario'";
	}
}
/*
class asignacion {
private 
$idAsignacion,
$ficha,
$idUss,
$idInventario,
$idInventarioEntrante,
$idInventarioSaliente,
$fechaAsignacion,
$observacion,
$idUssAdmin,
$tipo,
$idDetalleAsignacion,
$idGerencia,
$idDivision,
$idDepartamento,
$configuracionNueva,
$configuracionAnterior,
$idUbicacion,
$idinventarioUbicacion,
$idSitio;


	function asignacion($idAsignacion="",$idInventarioEntrante="",$idInventarioSaliente="",$fechaAsignacion="",$observacion="",$idUssAdmin="",$idDetalleAsignacion="",$idGerencia="",$idDivision="",$idDepartamento="",$idSitio="",$configuracionNueva="",$ficha="",$idUss="",$idInventario="",$tipo="",$configuracionAnterior="") {
		$this->idAsignacion=$idAsignacion;
		$this->idInventario=$idInventario;
		$this->idInventarioEntrante=$idInventarioEntrante;
		$this->idInventarioSaliente=$idInventarioSaliente;
		$this->fechaAsignacion=$fechaAsignacion;
		$this->observacion=$observacion;
		$this->idUssAdmin=$idUssAdmin;
		$this->idDetalleAsignacion=$idDetalleAsignacion;
		$this->idGerencia=$idGerencia;
		$this->idDivision=$idDivision;
		$this->idDepartamento=$idDepartamento;
		$this->idSitio=$idSitio;	
		$this->configuracionNueva=$configuracionNueva;
		echo "<br>CONFIGURACION NUEVA: $this->configuracionNueva<br>";
		$this->configuracionAnterior=$configuracionAnterior;
		$this->ficha=$ficha;
		$this->idUss=$idUss;
		$this->tipo=$tipo;
	}
	function retornarAsignacion() {
		return $this->idAsignacion;	
	}
	function ingresar() {
		$resultadoAsignacion=$this->ingresarAsignacion();
		$resultadoDetalleAsignacionEquipoEntrantes=$this->ingresarDetalleAsignacionEquipoEntrantes();
		//$resultadoDetallalleAsignacionEntrantes=$this->ingresarDetalleAsignacionEntrantes();
		if ($this->tipo==2) {
			$resultadoDetalleASignacionEquipoSalientes=$this->ingresarDetalleAsignacionEquipoSalientes();
			//$resultadoDetallalleAsignacionSalientes=$this->ingresarDetalleAsignacionSalientes();
		}
		/*$resultado=$resultadoAsignacion+$resultadoDetallalleAsignacionEntrantes+$resultadoDetallalleAsignacionSalientes;
		if ($resultado==0) {
			$this->actualizarComponentesAsignados();
			if ($this->tipo==2) {
				$this->actualizarComponentesReemplazados();	
			}
			$this->actualizarTodos();
			$this->actualizarDespacho();
			return 0;	
		} else {
			return 1;
		}
	}
		function ingresarAsignacion() {
			$this->fechaAsignacion=getdate();
			$this->fechaAsignacion=$this->fechaAsignacion[year]."-".$this->fechaAsignacion[mon]."-".$this->fechaAsignacion[mday]." "
			.$this->fechaAsignacion[hours].":".$this->fechaAsignacion[minutes].":".$this->fechaAsignacion[seconds];
			$conUltimo="select id_asignacion from asignacion order by id_asignacion desc";
			$cons=new consecutivo("ASG",$conUltimo);
			$this->idAsignacion=$cons->retornar();
			$ubi=new ubicacion("",$this->idGerencia,$this->idDivision,$this->idDepartamento,$this->idSitio);
			$this->idUbicacion=$ubi->ingresar();
			$conInsertar="insert into asignacion(id_asignacion,fecha_asignacion,ficha,id_uss,id_ubicacion,observacion,id_uss_admin,tipo)
			values ('$this->idAsignacion','$this->fechaAsignacion','$this->ficha','$this->idUss','$this->idUbicacion','$this->observacion','$this->idUssAdmin','$this->tipo')";
			conectarMysql();
			echo "<BR>INGRESAR ASIGNACION<BR>$conInsertar<BR>";
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
		function ingresarDetalleAsignacionEntrantes() {
			$equipo=new equipo($this->configuracionNueva);
			$idInventario=$equipo->retornarEquipoCampo();
				$idInventario=$this->retornaridInventarioDespacho($componentes[$i]);
				$conUltimo="select id_detalle_asignacion from detalle_asignacion order by id_detalle_asignacion desc";
				$cons=new consecutivo("ASG",$conUltimo);
				$this->idDetalleAsignacion=$cons->retornar();
				$this->fechaAsociacion=getdate();
				$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
				.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
				$conInsertar="insert into detalle_asignacion(id_detalle_asignacion,id_asignacion,id_inventario,status,fecha_asociacion)
				values ('$this->idDetalleAsignacion','$this->idAsignacion','$idInventario',1,'$this->fechaAsociacion')";
				conectarMysql();
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
		function ingresarDetalleAsignacionEquipoEntrantes() {
				$idInventario=$this->retornaridInventarioDespacho($componentes[$i]);
				$conUltimo="select id_detalle_asignacion_equipo from detalle_asignacion order by id_detalle_asignacion_equipo desc";
				$cons=new consecutivo("ASG",$conUltimo);
				$this->idDetalleAsignacion=$cons->retornar();
				$this->fechaAsociacion=getdate();
				$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
				.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
				$conInsertar="insert into detalle_asignacion_equipo(id_detalle_asignacion,id_asignacion,id_inventario,status,fecha_asociacion)
				values ('$this->idDetalleAsignacion','$this->idAsignacion','$idInventario',1,'$this->fechaAsociacion')";
				conectarMysql();
				echo "<br><b>Equipo Entrante</b><br>$conInsertar<br>"; 
				$result=mysql_query($conInsertar);
				$affected=mysql_affected_rows();
				$equipo=new equipo($this->configuracionNueva);
				$idInventario=$equipo->retornarIdInventarioConfiguracion();
				echo "<br>id Inventario: $idInventario<br>";
			if($affected>0) {
				mysql_close();
				return 0;
			} else {
				mysql_close();
				return 1;
			}			
		}
		function ingresarDetalleAsignacionSalientes() {
			$componentes=$this->idInventarioSaliente;
			for ($i=0;$i<count($componentes);$i++) {
				$conUltimo="select id_detalle_asignacion from detalle_asignacion order by id_detalle_asignacion desc";
				$cons=new consecutivo("ASG",$conUltimo);
				$this->idDetalleAsignacion=$cons->retornar();
				$this->fechaAsociacion=getdate();
				$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
				.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
				$conInsertar="insert into detalle_asignacion(id_detalle_asignacion,id_asignacion,id_inventario,status,fecha_asociacion)
				values ('$this->idDetalleAsignacion','$this->idAsignacion','$componentes[$i]',0,'$this->fechaAsociacion')";
				conectarMysql();
				$result=mysql_query($conInsertar);
				$affected=mysql_affected_rows();
			}
			if($affected>0) {
				mysql_close();
				return 0;
			} else {
				mysql_close();
				return 1;
			}
		}
		function ingresarDetalleAsignacionEquipoSalientes() {
			$componentes=$this->idInventarioSaliente;
			for ($i=0;$i<count($componentes);$i++) {
				$conUltimo="select id_detalle_asignacion from detalle_asignacion order by id_detalle_asignacion desc";
				$cons=new consecutivo("ASG",$conUltimo);
				$this->idDetalleAsignacion=$cons->retornar();
				$this->fechaAsociacion=getdate();
				$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
				.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
				$conInsertar="insert into detalle_asignacion(id_detalle_asignacion,id_asignacion,id_inventario,status,fecha_asociacion)
				values ('$this->idDetalleAsignacion','$this->idAsignacion','$componentes[$i]',0,'$this->fechaAsociacion')";
				conectarMysql();
				$result=mysql_query($conInsertar);
				$affected=mysql_affected_rows();
			}
			if($affected>0) {
				mysql_close();
				return 0;
			} else {
				mysql_close();
				return 1;
			}
		}
		
	function retornaridInventarioDespacho($idDespacho) {
		$consulta="select id_inventario from despacho where id_despacho='$idDespacho'";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result) {
			$row=mysql_fetch_array($result);
			return $row[0];
			mysql_close();
		}		
	}
	
	function retonaridInventarioConfiguracion() {
		$consulta="select id_inventario from equipo_campo where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result) {
			$row=mysql_fetch_array($result);
			return $row[0];
			mysql_close();	
		}	
	}
	function actualizarInventarioUbicacion($idInventario) {
		//$idInventario=$this->retonaridInventarioConfiguracion();
		$consulta="select id_ubicacion from inventario_ubicacion where id_inventario='$idInventario' order by fecha_asociacion desc limit 1";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result) {
			$row=mysql_fetch_array($result);
			$idUbicacion=$row[0];
			if ($idUbicacion!=$this->idUbicacion) {
				$conInsertar="insert into inventario_ubicacion(id_inventario_ubicacion,id_inventario,id_ubicacion,status_actual,fecha_asociacion)
				values ('$idInventarioUbicacion','$idInventario','$this->idUbicacion',1,'$this->fechaAsignacion')";
				$result=mysql_query($conInsertar);
			}
		}	
	}

	function actualizarComponentesAsignados() {
		$conAsignacion="select id_inventario from detalle_asignacion where id_asignacion='$this->idAsignacion' and status=1";
		conectarMysql();
		$result=mysql_query($conAsignacion);
		if ($result) {
			while ($row=mysql_fetch_array($result)) {
				$componente= new componente($row[0],"","","","","","","","","","","","","",0,"",$this->idGerencia,$this->idDivision,$this->idDepartamento,$this->idSitio,$this->idUss,"",$this->ficha);
				//$resultado=$componente->asociarComponente();
				$resultado=$componente->ingresarInventarioUsuario();
				$resultado=$componente->ingresarInventarioUbicacion();
				$resultado=$componente->ingresarInventarioUsuarioSistema();
				$this->idInventario=$row[0];
				$resultado=$this->asociarComponente();
			}	
		}
	}
	function asociarComponente() {
		conectarMysql();
		$conUltimo="SELECT ID_EQUIPO_COMPONENTE_CAMPO FROM equipo_componente_campo ORDER BY ID_EQUIPO_COMPONENTE_CAMPO DESC";
		$cons=new consecutivo("INV",$conUltimo);
		$this->idEquipoComponenteCampo=$cons->retornar();
		$consultaAsociar="INSERT INTO equipo_componente_campo (ID_EQUIPO_COMPONENTE_CAMPO,CONFIGURACION,ID_INVENTARIO,FECHA_ASOCIACION,STATUS_ACTUAL) VALUES
						('$this->idEquipoComponenteCampo','$this->configuracion','$this->idInventario','$this->fechaAsociacion','1')";
		$result=mysql_query($consultaAsociar);
		$affected=mysql_affected_rows(); 
		if($affected>0) {
			$componente2= new componente($this->idInventario);
			$disponible=$componente2->noDisponible();
			return 0;
		} else {
			mysql_close();
			return 1;
		}
	}	
	
	function actualizarComponentesReemplazados() {
		$conAsignacion="select id_inventario from detalle_asignacion where id_asignacion='$this->idAsignacion' and status=0";
		conectarMysql();
		$result=mysql_query($conAsignacion);
		if ($result) {
			while ($row=mysql_fetch_array($result)) {
				$conModifcar="update equipo_componente_campo set status_actual=0 where id_inventario='$row[0]' and configuracion='$this->configuracion'";
				$result2=mysql_query($conModifcar);
			}
		}
		mysql_close();	
	}
	function actualizarTodos() {
		$consulta="select id_inventario from equipo_componente_campo where configuracion='$this->configuracion' and status_actual='1'";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result) {
			$cambio="ASIGNACION DE COMPONENTES";
			while ($row=mysql_fetch_array($result)) {
				$componente= new componente($row[0],"","","","","","","","","","","","","","","",$this->idGerencia,$this->idDivision,$this->idDepartamento,$this->idSitio,$this->idUssAdmin,"",$this->ficha,$cambio);
				$resultado=$componente->ingresarInventarioUsuario();
				$resultado=$componente->ingresarInventarioUsuarioSistema();
				$resultado=$componente->ingresarInventarioUbicacion();
			}
		}
		$consulta="select id_inventario from equipo_campo where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);		
		if ($result) {
			$cambio="ASIGNACION DE COMPONENTES";
			while ($row=mysql_fetch_array($result)) {
				$componente= new componente($row[0],"","","","","","","","","","","","","","","",$this->idGerencia,$this->idDivision,$this->idDepartamento,$this->idSitio,$this->idUssAdmin,"",$this->ficha,$cambio);
				$resultado=$componente->ingresarInventarioUsuario();
				$resultado=$componente->ingresarInventarioUsuarioSistema();
				$resultado=$componente->ingresarInventarioUbicacion();
			}
		}				
	}
	function actualizarDespacho() {
		$componentes=$this->idInventarioEntrante;
		conectarMysql();
		for ($i=0;$i<count($componentes);$i++) {
			$conModificar="update despacho set status=1 where id_despacho='$componentes[$i]'";
			$result=mysql_query($conModificar);
			if ($result) {
			} else {
				$resultado=$resultado++;	
			}
		}
		mysql_close();
		return $resultado;	
	}

	
}
*/
?>