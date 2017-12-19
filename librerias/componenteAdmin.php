<?php
class componente {
	//Inventario
	protected  $idInventario,
	$serial,
	$descripcion,
	$marca,
	$modelo,
	$fru,
	$productNumber,
	$spareNumber,
	$ct,
	$fechaIngreso,
	$fechaFinal,
	$idPedido,
	$disponible,
	//Inventario_UsuarioSistema
	$idInventarioUsuarioSistema,
	$fechaAsociacion,
	$idUss,
	$cambio,
	//Inventario_Propiedad
	$idInventarioPropiedad,
	$idEstado,
	//InventarioUbicacion
	$idInventarioUbicacion,
	$idUbicacion,
	$statusActual,
	//Ubicacion
	$idGerencia,
	$idDivision,
	$idDepartamento,
	$idSitio,
	
	//Datos de InventarioUsuario
	$idInventarioUsuario,
	
	//Datos de Asociacion de componentes con un Equipo
	$idEquipoComponenteCampo,
	$configuracion,
	$inventarioEquipo,
	$ficha,
	$garantia,
	$idGarantia,
	$idEstatusGarantia,

	//Validacion
	$mensaje,
	$camposValidos,
	$serialViejo;

	function __construct($idInventario="",$serial="",$descripcion="",$marca="",$modelo="",$fru="",$productNumber="",$spareNumber="",
		$ct="",$fechaAsociacion="",$idEstado="",$fechaIngreso="",$fechaFinal="",$idPedido="",$disponible="",$idUbicacion="",$idGerencia="",$idDivision="",
		$idDepartamento="",$idSitio="",$idUss="",$inventarioEquipo="",$ficha="9999999",$garantia="",$serialViejo="",$ingresarGarantia=0,$cambio="",$configuracion="") {
		
		//INVENTARIO
		$this->idInventario=$idInventario;
		$this->serial=strtoupper($serial);
		$this->descripcion=$descripcion;
		$this->marca=$marca;
		$this->modelo=$modelo;
		$this->fru=strtoupper($fru);
		$this->productNumber=strtoupper($productNumber);
		$this->spareNumber=strtoupper($spareNumber);
		$this->ct=strtoupper($ct);
		$this->serialViejo=strtoupper($serialViejo);
		//INVENTARIO_USUARIO_SISTEMA
		$this->fechaAsociacion=$fechaAsociacion;
		$this->idInventarioUsuarioSistema="";
		$this->cambio=$cambio;
		$this->idUss=$idUss;
		//InventarioPropiedad
		$this->idEstado=$idEstado;
		$this->fechaIngreso=$fechaIngreso;
		
		$anho=substr($this->fechaIngreso,6,6);
		$mes=substr($this->fechaIngreso,3,2);
		$dia=substr($this->fechaIngreso,0,2);
		$this->fechaIngreso=$anho."-".$mes."-".$dia;
		
		
		$this->fechaFinal=$fechaFinal;
		
		$anho=substr($this->fechaFinal,6,6);
		$mes=substr($this->fechaFinal,3,2);
		$dia=substr($this->fechaFinal,0,2);
		$this->fechaFinal=$anho."-".$mes."-".$dia;
		
		$this->idPedido=strtoupper($idPedido);
		$this->disponible=$disponible;
		
		//Inventario Ubicacion
		$this->idUbicacion=$idUbicacion;
		
		//Ubicacion
		$this->idGerencia=$idGerencia;
		$this->idDivision=$idDivision;
		$this->idDepartamento=$idDepartamento;
		$this->idSitio=$idSitio;
		
		//Asociar Componente a Equipo;
		$this->inventarioEquipo=$inventarioEquipo;
		$this->ficha=$ficha;
		$this->garantia=$garantia;
	}
	function cargarComponente($idInventario="",$serial="",$descripcion="",$marca="",$modelo="",$fru="",$productNumber="",$spareNumber="",
		$ct="",$fechaAsociacion="",$idEstado="",$fechaIngreso="",$fechaFinal="",$idPedido="",$disponible="",$idUbicacion="",$idGerencia="",$idDivision="",
		$idDepartamento="",$idSitio="",$idUss="",$inventarioEquipo="",$ficha="9999999",$ingresarGarantia=0,$cambio="") {
		//INVENTARIO
		$this->idInventario=$idInventario;
		$this->serial=strtoupper($serial);
		$this->descripcion=$descripcion;
		$this->marca=$marca;
		$this->modelo=$modelo;
		$this->fru=strtoupper($fru);
		$this->productNumber=strtoupper($productNumber);
		$this->spareNumber=strtoupper($spareNumber);
		$this->ct=strtoupper($ct);
		
		//INVENTARIO_USUARIO_SISTEMA
		$this->fechaAsociacion=$fechaAsociacion;
		$this->idInventarioUsuarioSistema="";
		$this->idUss=$idUss;
		$this->cambio=$cambio;
		//InventarioPropiedad
		$this->idEstado=$idEstado;
		$this->fechaIngreso=$fechaIngreso;
		 
		$anho=substr($this->fechaIngreso,6,6);
		$mes=substr($this->fechaIngreso,3,2);
		$dia=substr($this->fechaIngreso,0,2);
		$this->fechaIngreso=$anho."-".$mes."-".$dia;
		 
		$this->fechaFinal=$fechaFinal;
		
		$anho=substr($this->fechaFinal,6,6);
		$mes=substr($this->fechaFinal,3,2);
		$dia=substr($this->fechaFinal,0,2);
		 
		$this->fechaFinal=$anho."-".$mes."-".$dia;
		 
		$this->idPedido=strtoupper($idPedido);
		$this->disponible=$disponible;
		
		//Inventario Ubicacion
		$this->idUbicacion=$idUbicacion;
		
		//Ubicacion
		$this->idGerencia=$idGerencia;
		$this->idDivision=$idDivision;
		$this->idDepartamento=$idDepartamento;
		$this->idSitio=$idSitio;
		
		//Asociar Componente a Equipo;
		$this->inventarioEquipo=$inventarioEquipo;
		$this->ficha=$ficha;
		$this->garantia=$garantia;		
	}
	function setIdInventario($idInventario) {
		$this->idInventario=$idInventario;
	}
	function setConfiguracion($configuracion) {
		$this->configuracion=$configuracion;	
	}
	function setUbicacion($idGerencia,$idDivision,$idDepartamento,$idSitio) {
		$this->idGerencia=$idGerencia;
		$this->idDivision=$idDivision;
		$this->idDepartamento=$idDepartamento;
		$this->idSitio=$idSitio;	
	}
	function setUsuario($ficha) {
		$this->ficha=$ficha;
	}
	function ingresar() {
		switch($this->buscarSerialDuplicado()) {
			case 0:
				return 2;
				break 1;
			case 1:
				conectarMysql();
				$conUltimo="SELECT ID_INVENTARIO FROM inventario ORDER BY ID_INVENTARIO DESC";
				$cons=new consecutivo("INV",$conUltimo);
				$this->idInventario=$cons->retornar();
				mysql_close();
				$resultadoIngresarInventario=$this->ingresarInventario();
				$resultadoIngresarInventarioPropiedad=$this->ingresarInventarioPropiedad();
				$this->cambio="NUEVO COMPONENTE";
				$resultadoIngresarInventarioUsuarioSistema=$this->ingresarInventarioUsuarioSistema();
				$resultadoIngresarComponenteCampo=$this->ingresarComponenteCampo();
				$resultadoIngresarInventarioUbicacion=$this->ingresarInventarioUbicacion();
				if ($this->idPedido!="1000000000") {
					$resultadoIngresarComponenteGarantia=$this->ingresarComponenteGarantia();
				}
				$resultado=$resultadoIngresarInventario+$resultadoIngresarInventarioPropiedad+$resultadoIngresarInventarioUsuarioSistema+$resultadoIngresarComponenteCampo+$resultadoIngresarInventarioUbicacion;
				if ($resultado==0) {
					return 0;
				} else {
					$this->deshacerIngresar();
					return 1;
				}
		break 1;
		}
	}
	//FUNCION INGRESAR COMPONENTES POR GARANTIA
		function ingresar2() {
		switch($this->buscarSerialDuplicado()) {
			case 0:
				return 2;
				break 1;
			case 1:
				conectarMysql();
				$conUltimo="SELECT ID_INVENTARIO FROM inventario ORDER BY ID_INVENTARIO DESC";
				$cons=new consecutivo("INV",$conUltimo);
				$this->idInventario=$cons->retornar();
				mysql_close();
				$resultadoIngresarInventario=$this->ingresarInventarioNuevo();
				$resultadoIngresarInventarioPropiedad=$this->ingresarInventarioPropiedad();
				$this->cambio="NUEVO COMPONENTE";
				$resultadoIngresarInventarioUsuarioSistema=$this->ingresarInventarioUsuarioSistema();
				$resultadoIngresarComponenteCampo=$this->ingresarComponenteCampo();
				$resultadoIngresarInventarioUbicacion=$this->ingresarInventarioUbicacion();
				if ($this->idPedido!="1000000000") {
					$resultadoIngresarComponenteGarantia=$this->ingresarComponenteGarantia();
				}
				$resultado=$resultadoIngresarInventario+$resultadoIngresarInventarioPropiedad+$resultadoIngresarInventarioUsuarioSistema+$resultadoIngresarComponenteCampo+$resultadoIngresarInventarioUbicacion;
				if ($resultado==0) {
					return 0;
				} else {
					$this->deshacerIngresar();
					return 1;
				}
		break 1;
		}
	}
	function ingresarInventario() {
			
		
		conectarMysql();
			$conUltimo="SELECT ID_INVENTARIO FROM inventario ORDER BY ID_INVENTARIO DESC";
			$cons=new consecutivo("INV",$conUltimo);
			$this->idInventario=$cons->retornar();
			if($this->serial=="") {
				$this->serial=$this->idInventario;	
			}
			if ($this->garantia==1) {
				$this->ActualizarPedido();	
			}
			$hora=getdate();
			$hora=$hora[hours].":".$hora[minutes].":".$hora[seconds];
			
			$conInsertar="INSERT INTO inventario (ID_INVENTARIO,SERIAL,ID_DESCRIPCION,ID_MARCA,ID_MODELO,FRU,PRODUCT_NUMBER,SPARE_NUMBER,CT,ID_PEDIDO,FECHA_INICIO,FECHA_FINAL,DISPONIBLE) VALUES 
			('$this->idInventario','$this->serial','$this->descripcion','$this->marca','$this->modelo','$this->fru','$this->productNumber','$this->spareNumber','$this->ct','$this->idPedido','$this->fechaIngreso $hora','$this->fechaFinal $hora','$this->disponible')";
			$result=mysql_query($conInsertar);
			$affected=mysql_affected_rows();
			if($affected>0) {
				if($this->serial==$this->idInventario) {
					$this->serial="";
				}
				
				mysql_close();
				return 0;
			} else {
				mysql_close();
				return 1;	
			}
	}
	//FUNCION INGRESAR COMPONENTES TRAIDOS POR GARANTIA
		function ingresarInventarioNuevo() {
			conectarMysql();
			$conUltimo="SELECT ID_INVENTARIO FROM inventario ORDER BY ID_INVENTARIO DESC";
			$cons=new consecutivo("INV",$conUltimo);
			$this->idInventario=$cons->retornar();
			if($this->serial=="") {
				$this->serial=$this->idInventario;	
			}
			if ($this->garantia==1) {
				$this->ActualizarPedido();	
			}
			$hora=getdate();
			$hora=$hora[hours].":".$hora[minutes].":".$hora[seconds];
			
			$conInsertar="INSERT INTO inventario (ID_INVENTARIO,SERIAL,ID_DESCRIPCION,ID_MARCA,ID_MODELO,FRU,PRODUCT_NUMBER,SPARE_NUMBER,CT,ID_PEDIDO,FECHA_INICIO,FECHA_FINAL,DISPONIBLE) VALUES 
			('$this->idInventario','$this->serial','$this->descripcion','$this->marca','$this->modelo','$this->fru','$this->productNumber','$this->spareNumber','$this->ct','$this->idPedido','$this->fechaIngreso $hora','$this->fechaFinal $hora','$this->disponible')";
			$result=mysql_query($conInsertar);
			$affected=mysql_affected_rows();
			
			if($affected>0) {
				if($this->serial==$this->idInventario) {
					$this->serial="";
				}
				
				mysql_close();
				return 0;
			} else {
				mysql_close();
				return 1;	
			}
	}
	function deshacerIngresar() {
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
	function ingresarInventarioPropiedad() {
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
		conectarMysql();
		$conInsertar="INSERT INTO inventario_ubicacion (ID_INVENTARIO_UBICACION,ID_INVENTARIO,ID_UBICACION,STATUS_ACTUAL,FECHA_ASOCIACION)
		VALUES ('$this->idInventarioUbicacion','$this->idInventario','$this->idUbicacion','$this->statusActual','$this->fechaAsociacion')";
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
	//CAMBIAR UBICACION FUERA DE PLANTA
		function ingresarInventarioUbicacionFueraPlanta() {
		$conUltimo="SELECT ID_INVENTARIO_UBICACION FROM inventario_ubicacion ORDER BY ID_INVENTARIO_UBICACION DESC";
		$cons=new consecutivo("EUB",$conUltimo);
		$this->idInventarioUbicacion=$cons->retornar();
		$ubi=new ubicacion("",$this->idGerencia,$this->idDivision,$this->idDepartamento,$this->idSitio);
		$this->idUbicacion=$ubi->ingresar();
		$this->statusActual='1';
		conectarMysql();
		$conInsertar="INSERT INTO inventario_ubicacion (ID_INVENTARIO_UBICACION,ID_INVENTARIO,ID_UBICACION,STATUS_ACTUAL,FECHA_ASOCIACION)
		VALUES ('$this->idInventarioUbicacion','$this->idInventario','$this->idUbicacion','$this->statusActual','$this->fechaAsociacion')";
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
	function verificarUbicacion() {
		$conUbicacion="select id_inventario_ubicacion from inventario_ubicacion 
		where id_inventario='$this->idInventario' and id_ubicacion='$this->idUbicacion' and status_actual='1'";
		conectarMysql();
		$result=mysql_query($conUbicacion);
		if ($result) {
			mysql_close();
			return 0;	
		} else {
			mysql_close();
			return 1;
		}	
	}
	function ingresarInventarioUsuarioSistema() {
		conectarMysql();
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$conUltimo="SELECT ID_INVENTARIO_USUARIO FROM inventario_usuario_sistema ORDER BY ID_INVENTARIO_USUARIO DESC";
		$cons=new consecutivo("IIU",$conUltimo);
		$this->idInventarioUsuarioSistema=$cons->retornar();
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
	function ingresarInventarioUsuario() {
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
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
	function ingresarComponenteCampo() {
		conectarMysql();
		$conInsertar="INSERT INTO componente_campo (ID_INVENTARIO,FECHA_CREACION) VALUES ('$this->idInventario','$this->fechaAsociacion')";
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


	function ingresarComponenteGarantia() {
		$this->configuracion=$this->retornaConfiguracion();
		conectarMysql();
		$conInsertar="insert into componente_garantia (id_inventario,configuracion,fecha_asociacion,status_actual)
		values ('$this->idInventario','$this->configuracion','$this->fechaAsociacion',1)";
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
	function ActualizarPedido() {
		$consulta="SELECT id_pedido,fecha_inicio,fecha_final from inventario WHERE ID_INVENTARIO='$this->inventarioEquipo'";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result) {
			$row=mysql_fetch_array($result);
			$this->idPedido=$row[0];
			$this->fechaIngreso=$row[1];
			$this->fechaFinal=$row[2];
		}
	}
	function buscarSerialDuplicado() {
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
	function validarFormulario() {
		if (isset($this->descripcion) && $this->descripcion==100) {
			if ($sw==1) {
				$this->mensaje=$this->mensaje."<b>,</b>";
			}
			$this->mensaje=$this->mensaje." <b>DESCRIPCION</b>";
			$this->camposValidos++;
			$sw=1;
		}
		if (isset($this->marca) && $this->marca==100) {
			if ($sw==1) {
				$this->mensaje=$this->mensaje."<b>,</b>";
			}
			$this->mensaje=$this->mensaje." <b>MARCA</b>";
			$this->camposValidos++;
			$sw=1;
		}
		if (isset($this->modelo) && $this->modelo==100) {
			if ($sw==1) {
				$this->mensaje=$this->mensaje."<b>,</b>";
			}
			$this->mensaje=$this->mensaje." <b>MODELO</b>";
			$this->camposValidos++;
			$sw=1;
		}
		if (isset($this->serial) && empty($this->serial)) {
			if ($sw==1) {
				$this->mensaje=$this->mensaje."<b>,</b>";
			}
			$this->mensaje=$this->mensaje." <b>SERIAL</b>";
			$this->camposValidos++;
			$sw=1;
		}
		return $this->camposValidos;
	}
	function asociarComponente($asociar=0) {
		conectarMysql();
		$conUltimo="SELECT ID_EQUIPO_COMPONENTE_CAMPO FROM equipo_componente_campo ORDER BY ID_EQUIPO_COMPONENTE_CAMPO DESC";
		$cons=new consecutivo("INV",$conUltimo);
		$this->idEquipoComponenteCampo=$cons->retornar();
		if ($asociar==0) {
			$this->configuracion=$this->retornaConfiguracion();
		}
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$consultaAsociar="INSERT INTO equipo_componente_campo (ID_EQUIPO_COMPONENTE_CAMPO,CONFIGURACION,ID_INVENTARIO,FECHA_ASOCIACION,STATUS_ACTUAL) VALUES
						('$this->idEquipoComponenteCampo','$this->configuracion','$this->idInventario','$this->fechaAsociacion','1')";
		$result=mysql_query($consultaAsociar);
		$affected=mysql_affected_rows(); 
		if($affected>0) {
			$disponible=$this->noDisponible();
			return 0;
		} else {
			mysql_close();
			return 1;
		}
	}
	function noDisponible($disponible=0) {
		conectarMysql();
		//0 Es no Disponible 1 es Disponible
		$consultaDisponible="update inventario set
					DISPONIBLE=$disponible
					where ID_INVENTARIO='$this->idInventario'";
		$result=mysql_query($consultaDisponible);
		$affected=mysql_affected_rows(); 
		if($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}
	}
	function desasociarComponente() {
		$consulta="update equipo_componente_campo set status_actual=0 where configuracion<>'$this->configuracion' and id_inventario='$this->idInventario'";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}
	}
	function retornarComponente() {
		$consulta="SELECT inventario.id_inventario,inventario.ID_DESCRIPCION,DESCRIPCION,inventario.ID_MARCA, marca.MARCA, inventario.ID_MODELO,
			concat(modelo.modelo,' ',cap_vel,' ',unidad)as modelo,inventario.SERIAL,inventario.ct,inventario.fru,inventario.product_number,inventario.spare_number, inventario.disponible,inventario.fecha_inicio,inventario.fecha_final,inventario.id_pedido,proveedor.proveedor
			FROM inventario inner join componente_campo on inventario.id_inventario=componente_campo.id_inventario
			INNER JOIN descripcion ON inventario.ID_DESCRIPCION=descripcion.ID_DESCRIPCION
			INNER JOIN marca on inventario.ID_MARCA=marca.ID_MARCA
			INNER JOIN modelo on inventario.ID_MODELO=modelo.ID_MODELO
			inner join pedido on inventario.id_pedido=pedido.id_pedido
			inner join proveedor on pedido.id_proveedor=proveedor.id_proveedor
			where inventario.id_inventario='$this->idInventario'";
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
	function retornarPropiedad() {
		$consulta="SELECT inventario_propiedad.id_inventario_propiedad,inventario_propiedad.id_inventario,
		inventario_propiedad.id_estado,inventario_estado.estado
		FROM inventario_propiedad
		inner join inventario_estado on inventario_propiedad.id_estado=inventario_estado.id_estado
		where inventario_propiedad.id_inventario='$this->idInventario'
		order by fecha_cambio desc limit 1";
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
	function setIdUbicacion($idUbicacion) {
		$this->idUbicacion=$idUbicacion;
	}
	function setFicha($ficha="9999999") {
		if (empty($ficha)) {
			$this->ficha="9999999";
		} else {
			$this->ficha=$ficha;
		}
	}
	function retornarUbicacion() {
		$consulta="SELECT inventario_ubicacion.id_inventario_ubicacion,inventario_ubicacion.id_inventario,inventario_ubicacion.id_ubicacion,
		ubicacion.id_gerencia,gerencia.gerencia,
		ubicacion.id_division,division.division,ubicacion.id_departamento,departamento.departamento,ubicacion.id_sitio,sitio.sitio,inventario_ubicacion.fecha_asociacion
		FROM inventario_ubicacion
		inner join ubicacion on inventario_ubicacion.id_ubicacion=ubicacion.id_ubicacion
		inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia
		inner join division on ubicacion.id_division=division.id_division
		inner join departamento on ubicacion.id_departamento=departamento.id_departamento
		inner join sitio on ubicacion.id_sitio=sitio.id_sitio
		where inventario_ubicacion.id_inventario='$this->idInventario' order by inventario_ubicacion.fecha_asociacion desc limit 1";
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
	function retornarEquipo() {
		$consulta="select equipo_componente_campo.id_equipo_componente_campo,equipo_componente_campo.configuracion,
		equipo_componente_campo.id_inventario,equipo_componente_campo.fecha_asociacion,
		equipo_componente_campo.status_actual,inventario.id_inventario as id_inventario_equipo,inventario.id_descripcion,descripcion.descripcion,
		inventario.id_marca,marca.marca,inventario.id_modelo,modelo.modelo,inventario.serial
		 from equipo_componente_campo inner join equipo_campo on equipo_componente_campo.configuracion=equipo_campo.configuracion
		 inner join inventario on equipo_campo.id_inventario=inventario.id_inventario
		 inner join descripcion on inventario.id_descripcion=descripcion.id_descripcion
		 inner join marca on inventario.id_marca=marca.id_marca
		 inner join modelo on inventario.id_modelo=modelo.id_modelo
		 where equipo_componente_campo.id_inventario='$this->idInventario' and status_actual=1";
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
	function retornarUsuario() {
		$consulta="select inventario.id_inventario,usuario.ficha, concat(usuario.nombre_usuario, ' ', usuario.apellido_usuario) as nombres,
		usuario.id_cargo, cargo.cargo, ubicacion.id_sitio,sitio.sitio,ubicacion.id_gerencia,gerencia.gerencia, ubicacion.id_division,division.division,ubicacion.id_departamento,departamento.departamento, usuario.extension
		from inventario inner join inventario_usuario on inventario.id_inventario=inventario_usuario.id_inventario
		inner join usuario on inventario_usuario.ficha=usuario.ficha
		inner join cargo on usuario.id_cargo=cargo.id_cargo
		inner join ubicacion on usuario.id_ubicacion=ubicacion.id_ubicacion
		inner join sitio on ubicacion.id_sitio=sitio.id_sitio
		inner join gerencia on ubicacion.id_gerencia=gerencia.id_gerencia
		inner join division on ubicacion.id_division=division.id_division
		inner join departamento on ubicacion.id_departamento=departamento.id_departamento
		where inventario.id_inventario='$this->idInventario' order by inventario_usuario.fecha_asociacion desc limit 1";
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
	function setInventario($idInventario,$idPedido,$fechaInicio,$fechaFinal) {
		$this->idPedido=$idPedido;
		$this->idInventario=$idInventario;
		$this->fechaIngreso=$fechaInicio;
		$this->fechaIngreso=substr($this->fechaIngreso,6,6)."-".substr($this->fechaIngreso,3,2)."-".substr($this->fechaIngreso,0,2);
		
		$this->fechaFinal=$fechaFinal;
		$this->fechaFinal=substr($this->fechaFinal,6,6)."-".substr($this->fechaFinal,3,2)."-".substr($this->fechaFinal,0,2);
	}
	function actualizarInventario() {
		$consulta="update inventario 
		set fecha_inicio='$this->fechaIngreso',
		fecha_final='$this->fechaFinal',
		id_pedido='$this->idPedido' where inventario.id_inventario='$this->idInventario'";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result) {
			mysql_close();
			return 0;	
		} else {
			mysql_close();
			return 1;
		}
	}
	function  actualizarInventarioPropiedad() {
		$conUltimo="SELECT ID_INVENTARIO_PROPIEDAD FROM inventario_propiedad ORDER BY ID_INVENTARIO_PROPIEDAD DESC";
		$cons=new consecutivo("INP",$conUltimo);
		$this->idInventarioPropiedad=$cons->retornar();
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
	function desactivarInventarioPropiedad() {
		$consulta="update inventario_propiedad set status_actual=0 
		where id_inventario='$this->idInventario' 
		and id_inventario_propiedad<>'$this->idInventarioPropiedad'";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result) {
			mysql_close();
			return 0;	
		} else {
			mysql_close();
			return 1;
		}
	}
	function desactivarInventarioUbicacion() {
		$consulta="update inventario_ubicacion set status_actual=0 where id_inventario='$this->idInventario' 
		and id_inventario_ubicacion<>'$this->idInventarioUbicacion'";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result) {
			mysql_close();
			return 0;	
		} else {
			mysql_close();
			return 1;
		}
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
	
	
	function insertarGarantia() {
		$conUltimo="SELECT id_garantia FROM garantia ORDER BY id_garantia DESC limit 1";
		$cons=new consecutivo("GAR",$conUltimo);
		$this->idGarantia=$cons->retornar();
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$consulta="insert into garantia (id_garantia,id_inventario,fecha_reportado,status_activo)
		 values ('$this->idGarantia','$this->idInventario','$this->fechaAsociacion',1)";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}	
	}
	function setUsuarioSistema($idUss) {
		$this->idUss=$idUss;
	}
	
	function insertarGarantiaEstado() {
		$consulta="insert into garantia_estado(id_garantia,id_estatus_garantia,fecha_asociacion,status_activo) values
		('$this->idGarantia','STG0000001','$this->fechaAsociacion',1)";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result) {
			mysql_close();
			return 0;	
		} else {
			mysql_close();
			return 1;
		}	
	}
	function verificarTablaGarantia() {
		$consulta="SELECT garantia.id_garantia,garantia.id_inventario,garantia_estado.ID_ESTATUS_GARANTIA,
		garantia_estado.FECHA_ASOCIACION,garantia_estado.STATUS_ACTIVO
		FROM garantia inner join garantia_estado on garantia.id_garantia=garantia_estado.id_garantia
		where garantia.id_inventario='$this->idInventario'";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result && mysql_numrows($result)>0) {
			mysql_close();
			$row=mysql_fetch_array($result);
			$this->idGarantia=$row[0];
			return 0;	
		} else {
			mysql_close();
			return 1;
		}	
	}
	function deshacerGarantia() {
		$consulta="delete from garantia where id_garantia='$this->idGarantia'";
		conectarMysql();
		$result=mysql_query($consulta);
	}
	function verificarEstadoGarantia($estado) {
		$consulta="SELECT garantia.id_garantia,garantia.id_inventario,garantia_estado.ID_ESTATUS_GARANTIA,
		garantia_estado.FECHA_ASOCIACION,garantia_estado.STATUS_ACTIVO
		FROM garantia inner join garantia_estado on garantia.id_garantia=garantia_estado.id_garantia
		where garantia.id_inventario='$this->idInventario' and garantia_estado.id_estatus_garantia='$estado' and garantia_estado.status_activo=1";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result && mysql_numrows($result)>0) {
			mysql_close();
			return 0;	
		}	else {
			mysql_close();
			return 1;	
		}
	}
	
	
	
	function retornaConfiguracion() {
	conectarMysql();
	$conEquipo="SELECT configuracion from equipo_campo WHERE ID_INVENTARIO='$this->inventarioEquipo'";
	$result=mysql_query($conEquipo);
	$row=mysql_fetch_array($result);
	$this->configuracion=$row[0];
	return $this->configuracion;
	}
	function retornaMensajeCampoVacio() {
		switch($this->campoValidos) {
			case 1:
				$tmp="EL CAMPO $this->mensaje ESTA VAC&Iacute;O";
				return $tmp;
				break 1;
			default:
				$tmp="LOS CAMPOS $this->mensaje ESTAN VAC&Iacute;OS";
				return $tmp;
		}
	}
}
class suministro extends componente {
	private $cantidad;

	function suministro($cantidad=0) {
		parent::__construct($idInventario="",$serial="",$descripcion="",$marca="",$modelo="",$fru="",$productNumber="",$spareNumber="",
		$ct="",$fechaAsociacion="",$idEstado="",$fechaIngreso="",$fechaFinal="",$idPedido="",$disponible="",$idUbicacion="",$idGerencia="",$idDivision="",
		$idDepartamento="",$idSitio="",$idUss="",$inventarioEquipo="",$ficha="99999999"); 

	}
	function cantidad($cantidad=0){
		$this->cantidad=$cantidad;

	}
	function ingresarVarios() {
		for ($i=0;$i<$this->cantidad;$i++) {
			$resultadoIngresarInventario=$this->ingresarInventario();
			$resultadoIngresarInventarioPropiedad=$this->ingresarInventarioPropiedad();
			$this->cambio="NUEVO EQUIPO";
			$resultadoIngresarInventarioUsuarioSistema=$this->ingresarInventarioUsuarioSistema();
			$resultadoIngresarComponenteCampo=$this->ingresarComponenteCampo();
			$resultadoIngresarInventarioUbicacion=$this->ingresarInventarioUbicacion();
			$resultado=$resultadoIngresarInventario+$resultadoIngresarInventarioPropiedad+$resultadoIngresarInventarioUsuarioSistema+
			$resultadoIngresarComponenteCampo+$resultadoIngresarEquipoGarantia+$resultadoIngresarInventarioUbicacion;
		}
			if ($resultado==0) {
				return 0;
			} else {
				return 1;
			}
	}
}



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
$configuracion,
$idUbicacion,
$idinventarioUbicacion,
$idSitio;


	function asignacion($idAsignacion="",$idInventarioEntrante="",$idInventarioSaliente="",$fechaAsignacion="",$observacion="",$idUssAdmin="",$idDetalleAsignacion="",$idGerencia="",$idDivision="",$idDepartamento="",$idSitio="",$configuracion="",$ficha="",$idUss="",$idInventario="",$tipo="") {
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
		$this->configuracion=$configuracion;
		$this->ficha=$ficha;
		$this->idUss=$idUss;
		$this->tipo=$tipo;
	}
	function retornarAsignacion() {
		return $this->idAsignacion;	
	}
	function ingresar() {
		$resultadoAsignacion=$this->ingresarAsignacion();
		$resultadoDetallalleAsignacionEntrantes=$this->ingresarDetalleAsignacionEntrantes();
		if ($this->tipo==2) {
			$resultadoDetallalleAsignacionSalientes=$this->ingresarDetalleAsignacionSalientes();
		}
		$resultado=$resultadoAsignacion+$resultadoDetallalleAsignacionEntrantes+$resultadoDetallalleAsignacionSalientes;
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
			$conInsertar="insert into asignacion(id_asignacion,fecha_asignacion,ficha,id_uss,configuracion,id_ubicacion,observacion,id_uss_admin,tipo)
			values ('$this->idAsignacion','$this->fechaAsignacion','$this->ficha','$this->idUss','$this->configuracion','$this->idUbicacion','$this->observacion','$this->idUssAdmin','$this->tipo')";
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
		function ingresarDetalleAsignacionEntrantes() {
			$componentes=$this->idInventarioEntrante;
			for ($i=0;$i<count($componentes);$i++) {
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
			}
			if($affected>0) {
				mysql_close();
				return 0;
			} else {
				mysql_close();
				return 1;
			}
		}
		function ingresarDetalleAsignacionEquipoEntrantes() {
			$componentes=$this->idInventarioEntrante;
			for ($i=0;$i<count($componentes);$i++) {
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
?>