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
	$ingresarGarantia,
	//Inventario_UsuarioSistema
	$idInventarioUsuarioSistema,
	$fechaAsociacion,
	$idUss,
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

	//Validacion
	$mensaje,
	$camposValidos,
	$serialViejo,
	$activoFijo,
	$idInventarioViejo;

	function __construct($idInventario="",$serial="",$descripcion="",$marca="",$modelo="",$fru="",$productNumber="",$spareNumber="",
	$ct="",$fechaAsociacion="",$idEstado="",$fechaIngreso="",$fechaFinal="",$idPedido="",$disponible="",$idUbicacion="",$idGerencia="",$idDivision="",
	$idDepartamento="",$idSitio="",$idUss="",$inventarioEquipo="",$ficha="9999999",$garantia="",$serialViejo="",$ingresarGarantia=1,$configuracion="",$activoFijo="",$idInventarioViejo="",$idInventarioPropiedad="") {

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
		$this->serialViejo=$serialViejo;
		$this->idInventarioViejo=$idInventarioViejo;
		//echo "nojoda Configuracion: $configuracion<br>";
		$this->configuracion=$configuracion;
		$this->activoFijo=$activoFijo;
		//INVENTARIO_USUARIO_SISTEMA
		$this->fechaAsociacion=$fechaAsociacion;
		$this->idInventarioUsuarioSistema="";
		$this->idUss=$idUss;
		//InventarioPropiedad
		$this->idEstado=$idEstado;
		$this->ingresarGarantia=$ingresarGarantia;
		$this->idInventarioPropiedad=$idInventarioPropiedad;

		$this->fechaIngreso=$fechaIngreso;

		if ($ingresarGarantia==1) {
			$anho=substr($this->fechaIngreso,6,6);
			$mes=substr($this->fechaIngreso,3,2);
			$dia=substr($this->fechaIngreso,0,2);
			$this->fechaIngreso=$anho."-".$mes."-".$dia;
		}

		$this->fechaFinal=$fechaFinal;
		if ($ingresarGarantia==1) {
			$anho=substr($this->fechaFinal,6,6);
			$mes=substr($this->fechaFinal,3,2);
			$dia=substr($this->fechaFinal,0,2);
			$this->fechaFinal=$anho."-".$mes."-".$dia;
		}
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
	$idDepartamento="",$idSitio="",$idUss="",$inventarioEquipo="",$ficha="9999999",$garantia="",$serialViejo="",$ingresarGarantia=1,$configuracion="",$activoFijo="",$idInventarioViejo="",$idInventarioPropiedad="") {
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
		$this->configuracion=$configuracion;
		$this->serialViejo=$serialViejo;
		$this->activoFijo=$activoFijo;
		$this->idInventarioViejo=$idInventarioViejo;
		//INVENTARIO_USUARIO_SISTEMA
		$this->fechaAsociacion=$fechaAsociacion;
		$this->idInventarioUsuarioSistema="";
		$this->idUss=$idUss;
		//InventarioPropiedad
		$this->idEstado=$idEstado;
		$this->ingresarGarantia=$ingresarGarantia;

		$this->fechaIngreso=$fechaIngreso;
		if ($ingresarGarantia==1) {
			$anho=substr($this->fechaIngreso,6,6);
			$mes=substr($this->fechaIngreso,3,2);
			$dia=substr($this->fechaIngreso,0,2);
			$this->fechaIngreso=$anho."-".$mes."-".$dia;
		}
		$this->fechaFinal=$fechaFinal;
		if ($ingresarGarantia==1) {
			$anho=substr($this->fechaFinal,6,6);
			$mes=substr($this->fechaFinal,3,2);
			$dia=substr($this->fechaFinal,0,2);

			$this->fechaFinal=$anho."-".$mes."-".$dia;
		}
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
	//funcion ingresar componentes
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

			$this->cambio="REEMPLAZADO POR GARANTIA";
			$resultadoIngresarInventarioUsuarioSistema=$this->ingresarInventarioUsuarioSistema();

			$resultadoIngresarComponenteCampo=$this->ingresarComponenteCampo();
			$resultadoCambiarStatusActivo=$this->cambiarStatusActivo();
			$resultadoCambiarStatusGarantiaPrueba=$this->cambiarStatusGarantiaPrueba();

			$resultadoCambiarStatusGarantiaPrueba=$this->cambiarStatusPropiedadPrueba();

			$resultadoIngresarInventarioUbicacion=$this->ingresarInventarioUbicacion();
			$resultadoIngresarInventarioUbicacionViejo=$this->ingresarInventarioUbicacionViejo();
			if ($this->idPedido!="1000000000") {

				$resultadoIngresarComponenteGarantia=$this->ingresarComponenteGarantia();
			}

			$resultado=$resultadoIngresarInventario+$resultadoIngresarInventarioPropiedad
			+$resultadoIngresarInventarioUsuarioSistema+$resultadoIngresarComponenteCampo
			+$resultadoIngresarInventarioUbicacion;
			if ($resultado==0) {
				return 0;
			} else {
				$this->deshacerIngresar();
				return 1;
			}
			break 1;
		}
	}
	//FUNCION INGRESAR EQUIPOS POR GARANTIA
	function ingresarEquipos() {
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
			$this->cambio="REEMPLAZADO POR GARANTIA";
			$resultadoIngresarInventarioUsuarioSistema=$this->ingresarInventarioUsuarioSistema();
			$resultadoIngresarEquipoCampo=$this->ingresarEquipoCampo();
			$resultadoCambiarStatusActivo=$this->cambiarStatusActivo();
			$resultadoCambiarStatusGarantiaPrueba=$this->cambiarStatusGarantiaPrueba();
			$resultadoCambiarStatusGarantiaPrueba=$this->cambiarStatusPropiedadPrueba();
			$resultadoIngresarInventarioUbicacionViejo=$this->ingresarInventarioUbicacionViejo();
			if ($this->idPedido!="1000000000") {

				$resultadoIngresarEquipoGarantia=$this->ingresarEquipoGarantia();
			}

			$resultadoIngresarInventarioUbicacion=$this->ingresarInventarioUbicacion();
			$resultado=$resultadoIngresarInventario+$resultadoIngresarInventarioPropiedad+$resultadoIngresarInventarioUsuarioSistema+
			$resultadoIngresarEquipoCampo+$resultadoIngresarEquipoGarantia+$resultadoIngresarInventarioUbicacion+$resultadoCambiarStatusGarantia;
			if ($resultado==0) {
				return 0;
			} else {
				$this->deshacerIngresar();
				return 1;
			}
			break 1;
		}
	}

	function ingresarEquipoCampo() {
		conectarMysql();
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$conInsertar="INSERT INTO equipo_campo (CONFIGURACION,ACTIVO_FIJO,ID_INVENTARIO,FECHA_CREACION)
		VALUES ('$this->configuracion','$this->activoFijo','$this->idInventario','$this->fechaAsociacion')";
		//echo "<br>ingresar equipo campo:$conInsertar<br>";
		$result=mysql_query($conInsertar);
		//echo"<BR><BR>RESULTADO:  $result<BR><BR>";
		$affected=mysql_affected_rows();
		if($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
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
			('$this->idInventario','$this->serial','$this->descripcion','$this->marca','$this->modelo','$this->fru','$this->productNumber','$this->spareNumber','$this->ct','$this->idPedido','$this->fechaIngreso','$this->fechaFinal','$this->disponible')";
		//echo "INSERTAR INVENTARIO: $conInsertar";
		$result=mysql_query($conInsertar);
		//echo"<BR><BR>RESULTADO:  $result<BR><BR>";
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
		//echo "<BR>INSERTAR INVENTARIO PROPIEDAD: $conInsertar<BR>";

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
		$conInsertar="INSERT INTO inventario_ubicacion (ID_INVENTARIO_UBICACION,ID_INVENTARIO,ID_UBICACION,STATUS_ACTUAL,
		FECHA_ASOCIACION)
		VALUES ('$this->idInventarioUbicacion','$this->idInventario','$this->idUbicacion','$this->statusActual',
		'$this->fechaAsociacion')";
		//echo "<BR>INSERTAR INVENTARIO UBICACION: $conInsertar<BR>";
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
	//INGRESAR EN INVENTARIO UBICACION STATUS '0'
	function ingresarInventarioUbicacionViejo() {
		conectarMysql();

		$conModificar="update inventario_ubicacion set status_actual='0'
		where id_inventario='$this->idInventarioViejo' ";
		//echo "<BR>CAMBIAR STATUS: $conModificar<BR>";
		$result=mysql_query($conModificar);
		////echo "resultado: $result";
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
		$conInsertar="INSERT INTO inventario_usuario_sistema (ID_INVENTARIO_USUARIO,ID_INVENTARIO,
		ID_USS,FECHA_ASOCIACION,CAMBIO) VALUES
		('$this->idInventarioUsuarioSistema','$this->idInventario','$this->idUss','$this->fechaAsociacion','$this->cambio')";
		//echo "<BR>INSERTAR INVENTARIO USUARIO SISTEMA: $conInsertar<BR>";
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
		//echo "<BR>INSERTAR INVENTARIO USUARIO: $conInsertar<BR>";
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
		$conInsertar="INSERT INTO componente_campo (ID_INVENTARIO,FECHA_CREACION) VALUES ('$this->idInventario',
		'$this->fechaAsociacion')";
		//echo "<BR>INSERTAR COMPONENTE CAMPO: $conInsertar<BR>";
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
	/*function ingresarEquipoCampo() {

	conectarMysql();
	$conInsertar="INSERT INTO equipo_campo (CONFIGURACION,ACTIVO_FIJO,ID_INVENTARIO,FECHA_CREACION)
	VALUES ('$this->configuracion','$this->activoFijo','$this->idInventario','$this->fechaAsociacion')";
	//echo "$conInsertar";
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

	function ingresarComponenteGarantia() {
		//echo "ingresarGarantia=$this->ingresarGarantia<br>";
		//echo "configuracion= $this->configuracion<br>";
		//	if ($this->ingresarGarantia==1) {
		//			$this->configuracion=$this->retornaConfiguracion();
		//}

		conectarMysql();
		$conInsertar="insert into componente_garantia (id_inventario,configuracion,fecha_asociacion,status_actual)
		values ('$this->idInventario','$this->configuracion','$this->fechaAsociacion',1)";
		//echo "componente garantia: $conInsertar<br>";
		//echo"<BR>COMPONENTE GARANTIA: $conInsertar<BR>";
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
	function ingresarEquipoGarantia() {
		//echo "ingresarGarantia=$this->ingresarEquipoGarantia()";
		//echo "configuracion= $this->configuracion<br>";
		conectarMysql();
		$conInsertar="insert into equipo_garantia (configuracion,id_inventario,activo_fijo,fecha_creacion)
		values ('$this->configuracion','$this->idInventario','$this->activoFijo','$this->fechaAsociacion')";
		//echo "equipo garantia: $conInsertar<br>";
		$result=mysql_query($conInsertar);
		//echo "RESULTADO: $result<br>";
		$affected=mysql_affected_rows();
		if($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}
	}
	//FUNCION CAMBIAR STATUS EN GARANTIA
	function cambiarStatusGarantia() {
		//echo "ingresarGarantia=$this->ingresarGarantia<br>";
		//echo "SERIAL VIEJO= $this->serialViejo<br>";
		conectarMysql();

		$conModificar="update garantia set id_estatus_garantia='STG0000004',
		 fecha_remplazo='$this->fechaAsociacion',
		id_inventario_reemplazo='$this->idInventario'
		where id_garantia='$this->serialViejo' ";
		//echo "<BR>CAMBIAR STATUS: $conModificar<BR>";
		$result=mysql_query($conModificar);
		////echo "resultado: $result";
		$affected=mysql_affected_rows();
		if($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}

	}
	//FUNCION CAMBIAR STATUS EN GARANTIA
	function cambiarStatusActivo() {
		//echo "ingresarGarantia=$this->ingresarGarantia<br>";
		//echo "SERIAL VIEJO= $this->serialViejo<br>";
		conectarMysql();

		$conModificar="update garantia_prueba set status_activo='0'
		
		where id_garantia='$this->serialViejo' ";
		//echo "CAMBIAR STATUS: $conModificar";
		$result=mysql_query($conModificar);
		//echo "resultado: $result";
		$affected=mysql_affected_rows();
		if($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}

	}
	//FUNCION CAMBIAR STATUS EN GARANTIA ESTADO
	function cambiarStatusGarantiaPrueba() {
		//echo "ingresarGarantia=$this->ingresarGarantia<br>";
		//echo "SERIAL VIEJO= $this->serialViejo<br>";
		conectarMysql();
		$conModificar="insert into garantia_estado (id_garantia,id_estatus_garantia,fecha_asociacion,status_activo)
		values ('$this->serialViejo','STG0000004','$this->fechaAsociacion','1')";
		//echo "CAMBIAR STATUS PRUEBA: $conModificar";
		$result=mysql_query($conModificar);
		$conModificar2="update garantia_estado set status_activo='0'
		where id_garantia='$this->serialViejo' and id_estatus_garantia='STG0000003'";
		$result=mysql_query($conModificar2);
		//echo "CAMBIAR STATUS PRUEBA2: $conModificar2";
		//echo "resultado: $result";
		$affected=mysql_affected_rows();
		if($affected>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}

	}
	//CAMBIAR STATUS A DESINCORPORADO
	function cambiarStatusPropiedadPrueba() {
		$conUltimo="SELECT ID_INVENTARIO_PROPIEDAD FROM inventario_propiedad ORDER BY ID_INVENTARIO_PROPIEDAD DESC";
		$cons=new consecutivo("INP",$conUltimo);
		$this->idInventarioPropiedad=$cons->retornar();
		$ubi=new ubicacion("",$this->idGerencia,$this->idDivision,$this->idDepartamento,$this->idSitio);
		$this->idUbicacion=$ubi->ingresar();
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		conectarMysql();
		$conUbicacion="SELECT ID_UBICACION FROM INVENTARIO_UBICACION
						WHERE ID_INVENTARIO='$this->idInventarioViejo'";
		$result=mysql_query($conUbicacion);
		//echo "ID_UBICACION:: $conUbicacion";
		$conInsertar="INSERT INTO inventario_propiedad (ID_INVENTARIO_PROPIEDAD,ID_INVENTARIO,ID_ESTADO,ID_USS,ID_UBICACION,FICHA,FECHA_CAMBIO)
		VALUES ('$this->idInventarioPropiedad','$this->idInventarioViejo','EST0000005','$this->idUss','$this->idUbicacion','9999999','$this->fechaAsociacion')";
		//echo"<br>ver aquifff: $conInsertar<br>";
		$result=mysql_query($conInsertar);
		$conCambiar="update inventario_propiedad set status_actual='0'
					where id_estado!='EST0000005'
					and id_inventario='$this->idInventarioViejo' ";
		//echo"<br>OTTTTTTRaquifff: $conCambiar<br>";
		$result=mysql_query($conCambiar);
		if(result) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}
	}

	//FUNCION REINTEGRAR EN EL INVENTARIO

	function reintegroInventario(){
		$conUltimo="SELECT ID_INVENTARIO_PROPIEDAD FROM inventario_propiedad ORDER BY ID_INVENTARIO_PROPIEDAD DESC";
		$cons=new consecutivo("INP",$conUltimo);
		$this->idInventarioPropiedad=$cons->retornar();
		$ubi=new ubicacion("",$this->idGerencia,$this->idDivision,$this->idDepartamento,$this->idSitio);
		$this->idUbicacion=$ubi->ingresar();
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		conectarMysql();
		$conUbicacion="SELECT ID_UBICACION FROM INVENTARIO_UBICACION
						WHERE ID_INVENTARIO='$this->idInventarioViejo'";
		$result=mysql_query($conUbicacion);
		//echo "ID_UBICACION:: $conUbicacion";
		$conInsertar="INSERT INTO inventario_propiedad (ID_INVENTARIO_PROPIEDAD,ID_INVENTARIO,ID_ESTADO,ID_USS,ID_UBICACION,
		FICHA,FECHA_CAMBIO)
		VALUES ('$this->idInventarioPropiedad','$this->idInventarioViejo','EST0000001','$this->idUss','$this->idUbicacion',
		'9999999','$this->fechaAsociacion')";
		//echo"<br>ver aquifff: $conInsertar<br>";
		$result=mysql_query($conInsertar);
		$conCambiar="update inventario_propiedad set status_actual='0'
					where id_estado='EST0000002'
					and id_inventario='$this->idInventarioViejo' ";
		//echo"<br>OTTTTTTRaquifff: $conCambiar<br>";
		$result=mysql_query($conCambiar);
		$conEstatus="update inventario set disponible='1'
					where id_inventario='$this->idInventarioViejo' ";
		//echo"<br>ID_INVENTARIO ESTATUS DISPONIBLE: $conCambiar<br>";
		$result=mysql_query($conCambiar);
		if(result) {
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
	function asociarComponente() {
		conectarMysql();
		$conUltimo="SELECT ID_EQUIPO_COMPONENTE_CAMPO FROM equipo_componente_campo ORDER BY ID_EQUIPO_COMPONENTE_CAMPO DESC";
		$cons=new consecutivo("INV",$conUltimo);
		$this->idEquipoComponenteCampo=$cons->retornar();
		//$this->configuracion=$this->retornaConfiguracion();
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
	function noDisponible() {
		conectarMysql();
		//0 Es no Disponible 1 es Disponible
		$consultaDisponible="update inventario_proiedad set
					DISPONIBLE=0
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
	$idInventarioEntrante,
	$idInventarioSaliente,
	$fechaAsignacion,
	$observacion,
	$idUssAdmin,
	$idDetalleAsignacion,
	$idGerencia,
	$idDivision,
	$idDepartamento,
	$configuracion,
	$idUbicacion,
	$idinventarioUbicacion,
	$idSitio;

	/*	function asignacion($idInventario="",$serial="",$descripcion="",$marca="",$modelo="",$fru="",$productNumber="",$spareNumber="",
	$ct="",$fechaAsociacion="",$idEstado="",$fechaIngreso="",$fechaFinal="",$idPedido="",$disponible="",$idUbicacion="",$idGerencia="",$idDivision="",
	$idDepartamento="",$idSitio="",$idUss="",$inventarioEquipo="",$ficha="99999999",$garantia="",$serialViejo="",$idAsignacion="",$fechaasignacion="",$observacion="",$idUssAdmin="",$idDetalleAsignacion="") {
	parent::__construct($idInventario="",$serial="",$descripcion="",$marca="",$modelo="",$fru="",$productNumber="",$spareNumber="",
	$ct="",$fechaAsociacion="",$idEstado="",$fechaIngreso="",$fechaFinal="",$idPedido="",$disponible="",$idUbicacion="",$idGerencia="",$idDivision="",
	$idDepartamento="",$idSitio="",$idUss="",$inventarioEquipo="",$ficha="99999999",$garantia="",$serialViejo="");
	$this->idAsignacion=$idAsignacion;
	$this->fechaAsignacion=$fecha_asignacion;
	$this->ficha=$ficha;
	$this->observacion=$observacion;
	$this->idUssAdmin=$idUssAdmin;
	$this->idDetalleAsignacion=$idDetalleAsignacion;
	}
	*/

	function asignacion($idAsignacion="",$idInventarioEntrante="",$idInventarioSaliente="",$fechaAsignacion="",$observacion="",$idUssAdmin="",$idDetalleAsignacion="",$idGerencia="",$idDivision="",$idDepartamento="",$idSitio="",$configuracion="",$ficha="",$idUss="") {
		$this->idAsignacion=$idAsignacion;
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
	}

	function ingresar() {
		$this->ingresarAsignacion();
		$this->ingresarDetalleAsignacionEntrantes();
		$this->ingresarDetalleAsignacionSalientes();
	}
	function ingresarAsignacion() {
		$this->fechaAsignacion=getdate();
		$this->fechaAsignacion=$this->fechaAsignacion[year]."-".$this->fechaAsignacion[mon]."-".$this->fechaAsignacion[mday]." "
		.$this->fechaAsignacion[hours].":".$this->fechaAsignacion[minutes].":".$this->fechaAsignacion[seconds];
		//echo "<br>IngresarAsignacion<br>";
		$conUltimo="select id_asignacion from asignacion order by id_asignacion desc";
		$cons=new consecutivo("ASG",$conUltimo);
		$this->idAsignacion=$cons->retornar();
		$ubi=new ubicacion("",$this->idGerencia,$this->idDivision,$this->idDepartamento,$this->idSitio);
		$this->idUbicacion=$ubi->ingresar();
		$conInsertar="insert into asignacion(id_asignacion,fecha_asignacion,ficha,id_uss,configuracion,id_ubicacion,observacion,id_uss_admin)
			values ('$this->idAsignacion','$this->fechaAsignacion','$this->ficha','$this->idUss','$this->configuracion','$this->idUbicacion','$this->observacion','$this->idUssAdmin')";
		//echo "<br>$conInsertar<br>";
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
		//echo "<br>IngresarDetalleAsignacionEntrantes<br>";
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
			//echo "<br>$conInsertar<br>";
			conectarMysql();
			$result=mysql_query($conInsertar);
			$affected=mysql_affected_rows();
			mysql_close();
		}
	}
	function ingresarDetalleAsignacionSalientes() {
		//echo "<br>IngresarDetalleAsignacionSalientes<br>";
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
			//echo "<br>$conInsertar<br>";
			conectarMysql();
			$result=mysql_query($conInsertar);
			$affected=mysql_affected_rows();
			mysql_close();
		}
	}

	function retornaridInventarioDespacho($idDespacho) {
		$consulta="select id_inventario from despacho where id_despacho='$idDespacho'";
		conectarMysql();
		//echo "<br>$consulta<br>";
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
	function actualizarEquipoComponente() {
		$consulta="";
	}
	function actualizarUbicacionEquipo($idInventario) {
		$idInventario=$this->retonaridInventarioConfiguracion();
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
				$conInsertar="insert into equipo_componente_campo(id_equipo_componente_campo,configuracion,id_inventario,fecha_asociacion,status_actual)
				values ('$this->idEquipoComponenteCampo','$this->configuracion','$row[0]','$this->fechaAsignacion',1)";
				$result2=mysql_query($conInsertar);
			}
		}
	}
	function actualizarComponentesReemplazados() {

	}


}
?>