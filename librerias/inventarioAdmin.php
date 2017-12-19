<?php
//Llamada a Administrador
//require_once("administracion.php");
require_once("conexionsql.php");
//Clases de toda la parte administrativa del inventario

//Clase Proveedor
class proveedor {
	/**
	 * Proveedor Almacena, Modificar, Elimina y hace Llamadas a Vistas
	 * a la base de Datos a la tabla Proveedor.
	 *
	 * 
	 */
	
	
	private $idProveedor,
	$proveedor,
	$contactos,
	$direccion,
	$telefono;
	
	function proveedor($idProveedor="",$proveedor="",$contactos="",$direccion="",$telefono="") {
		$this->idProveedor=$idProveedor;
		$this->proveedor=strtoupper($proveedor);
		$this->contactos=strtoupper($contactos);
		$this->direccion=strtoupper($direccion);
		$this->telefono=strtoupper($telefono);
	}
	function ingresar() {
		/**
		 * Guardar un Nuevo Proveedor a la Base de Datos
		 * $this->idProveedor: Obtiene un valor generado y único para guardar un Nuevo Proveedor
		 */
		
		switch($this->buscarDuplicado()) {
			case 0:
				return 1;
				break 1;
			case 1:
				conectarMysql();
				$conUltimo="SELECT ID_PROVEEDOR FROM PROVEEDOR ORDER BY ID_PROVEEDOR DESC";
				$cons=new consecutivo("PRO",$conUltimo);
				$this->idProveedor=$cons->retornar();
				$conInsertar="INSERT INTO PROVEEDOR (ID_PROVEEDOR,PROVEEDOR,CONTACTOS,DIRECCION,TELEFONO,STATUS_ACTIVO) 
				VALUES ('$this->idProveedor','$this->proveedor','$this->contactos','$this->direccion','$this->telefonoEmpresa',1)";
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
	}
	private function buscarDuplicado() {
		conectarMysql();
		$conBuscar="SELECT ID_PROVEEDOR, PROVEEDOR, STATUS_ACTIVO FROM PROVEEDOR WHERE PROVEEDOR='$this->proveedor' AND ID_PROVEEDOR<>'$this->idProveedor'";
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
				return 1;
				break 1;
			case 1:
				conectarMysql();
				$conModificar="UPDATE PROVEEDOR SET
				PROVEEDOR='$this->proveedor',
				CONTACTOS='$this->contactos',
				DIRECCION='$this->direccion',
				TELEFONO='$this->telefono' 
				WHERE ID_PROVEEDOR='$this->idProveedor'";
				$result=mysql_query($conModificar);
				$affected=mysql_affected_rows();
				if($affected>0) {
					mysql_close();
					return 0;
				}
				else {
					mysql_close();
					return 1;
				}
				break 1;
		}
	}
	function desactivar() {
		conectarMysql();
		$conModificar="UPDATE PROVEEDOR SET STATUS_ACTIVO=0 WHERE ID_PROVEEDOR='$this->idProveedor'";
		$result=mysql_query($conModificar);
		$affected=mysql_affected_rows();
		if($affected>0) {
			mysql_close();
			return 0;
		}
		else {
			mysql_close();
			return 1;
		}
	}

}

class inventario {
	//Tabla Inventario
	protected $idInventario, //Existe en Inventario,
	// Inventario_Propiedad, Inventario_Usuario,Inventario_Ubicacion, Equipo_Campo, 
	//Componente_Campo, Componente_garantia, Equipo_Componente_campo
	$serial,
	$idDescripcion,
	$idMarca,
	$idModelo,
	$fru,
	
//**************************************************************************
//**************************************************************************
	$ServiceTag,
	$ExpressService,
//**************************************************************************
//**************************************************************************
	$productNumber,
	$spareNumber,
	$ct,
	$idPedido,
	$fechaInicio,
	$fechaFinal,
	$disponible,
	
	//Tabla Inventario_Usuario
	$idInventarioUsuario,
	$ficha, //Existe en Inventario_Propiedad e Inventario_Usuario
	$statusActual,
	$fechaAsociacion,
	
	//Tabla Inventario_Propiedad
	$idInventarioPropiedad,
	$idUss, //Existe en Inventario_Usuario, Inventario_Propiedad, Inventario_Ubicacion
	$idEstado,
	
	//Tabla Inventario_Ubicacion
	$idInventarioUbicacion,
	$idDepartamento, //Existe en Inventario_Ubicacion, Inventario_Propiedad
	$idSitio, //Existe en Inventario_Ubicacion, Inventario_Propiedad
	$especifico,
	$codigoSap;

//Constructor de la Clase Inventario	
	function __construct($idInventario="",$serial="",$idDescripcion="",$idMarca="",$idModelo="",$fru="",$productNumber="",$spareNumber="",$ct="",$idPedido="",
	$fechaInicio="",$fechaFinal="",$disponible=0,$codigoSap="",$idInventarioUsuario="",$ficha="9999999",$statusActual="",$fechaAsociacion="",
	$idInventarioPropiedad="",$idUss="",$idEstado="",$idInventarioUbicacion="",$idDepartamento="",$idSitio="",$especifico="",$SeviceTag="",$ExpressService="") {
		$this->idInventario;
		$this->serial=strtoupper($serial);
		$this->idDescripcion=$idDescripcion;
		$this->idMarca=$idMarca;
		$this->idModelo=$idModelo;
		$this->fru=strtoupper($fru);
		//*********************************
		//*********************************
		$this->ServiceTag=strtoupper($SeviceTag);
		$this->ExpressService=strtoupper($ExpressService);
		//*********************************
		//*********************************
		$this->productNumber=strtoupper($productNumber);
		$this->spareNumber=strtoupper($spareNumber);
		$this->ct=strtoupper($ct);
		$this->idPedido=$idPedido;
		$this->fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
		$this->fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
		$this->disponible=$disponible;
		$this->codigoSap=$codigoSap;
		$this->idInventarioUsuario=$idInventarioUsuario;
		$this->ficha=$ficha;
		$this->statusActual=$statusActual;
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		
		$this->idInventarioPropiedad=$idInventarioPropiedad;
		$this->idUss=$idUss;
		$this->idEstado=$idEstado;
		$this->idInventarioUbicacion=$idInventarioUbicacion;
		$this->idDepartamento=$idDepartamento;
		$this->idSitio=$idSitio;
		$this->especifico=$especifico;
	}
//Destructor de la Clase
	function __destruct() {
		
	}
	
//---------------------------------- Inicio de Captura de Datos -----------------------------------------
	
	
//Obtiene los datos a ser almacenados en Inventario	
	function setInventario($idInventario="",$serial="",$idDescripcion="",$idMarca="",$idModelo="",$fru="",$productNumber="",$spareNumber="",$ct="",$idPedido="",$fechaInicio="",$fechaFinal="",$disponible=0,$codigoSap="",$idUss="",$SeviceTag="",$ExpressService="") {
		$this->idInventario=$idInventario;
		$this->serial=strtoupper($serial);
		$this->idDescripcion=$idDescripcion;
		$this->idMarca=$idMarca;
		$this->idModelo=$idModelo;
		$this->fru=strtoupper($fru);
		$this->productNumber=strtoupper($productNumber);
		$this->spareNumber=strtoupper($spareNumber);
		$this->ct=strtoupper($ct);
		$this->idPedido=$idPedido;
		$this->fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
		$this->fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
		$this->disponible=$disponible;
		$this->codigoSap=strtoupper($codigoSap);
		$this->idUss=$idUss;
		//**************************************
		//**************************************
		$this->ServiceTag=strtoupper($SeviceTag);
		$this->ExpressService=strtoupper($ExpressService);
		//**************************************
		//**************************************
	}
//Obtiene los datos del Estado del Equipo para almacenarlo en la tabla Inventario Propiedad	
	function setInventarioPropiedad($idEstado="",$idUss="") {
		$this->idEstado=$idEstado;
		$this->idUss=$idUss;
	}
	function setInventarioUbicacion($idDepartamento="",$idSitio="",$especifico="",$idUss="") {
		$this->idDepartamento=$idDepartamento;
		$this->idSitio=$idSitio;
		$this->especifico=strtoupper($especifico);
		$this->idUss=$idUss;
	}
	function setInventarioUsuario($ficha="9999999",$idUss="") {
		$this->ficha=$ficha;
		$this->idUss=$idUss;
	}

//---------------------------------- Fin de Captura de Datos -----------------------------------------




//---------------------------------- Inicio de Inventario -----------------------------------------

//*********************************************************************************************************************************************************
//*********************************************************************************************************************************************************
	function actualizarEspecifico() {
		$consulta="update inventario_ubicacion set especifico='$this->especifico' where id_inventario='$this->idInventario'";
		conectarMysql();
		$result=mysql_query($consulta);	
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}

//*********************************************************************************************************************************************************
//*********************************************************************************************************************************************************

	//Obtiene un Nuevo idInventario
	function nuevoIdInventario() {
		$conUltimo="select id_inventario from inventario order by id_inventario desc limit 1";
		$cons=new consecutivo("INV",$conUltimo);
		$this->idInventario=$cons->retornar();
	}
	

//Metodo que Ingresa una Activo a la Tabla Inventario
	function ingresarInventario() {
		if ($this->buscarSerialDuplicado()==0)
			return 2;
			
		$this->nuevoIdInventario();
		//Consulta para ingresar un activo al Inventario
		if($this->serial=="NOTIENESERIAL") {
			$this->serial=$this->idInventario;	
		}
		
		
		$conInsertar="insert into inventario (id_inventario,serial,id_modelo,fru,
		product_number,spare_number,ct,id_pedido,fecha_inicio,fecha_final,id_uss,fecha_asociacion,Service_Tag,Express_Service,codigo_sap)
		values ('$this->idInventario','$this->serial','$this->idModelo','$this->fru',
		'$this->productNumber','$this->spareNumber','$this->ct','$this->idPedido','$this->fechaInicio','$this->fechaFinal','$this->idUss',concat(curdate(),' ',curtime()),'$this->ServiceTag','$this->ExpressService','$this->codigoSap')";
		
		conectarMysql();		
		$result=mysql_query($conInsertar);
		mysql_close();
		if ($result) {
			return 0;
		} else {
			return 1;	
		}		
	}
//Busca un Serial Duplicado
	private function buscarSerialDuplicado() {
		conectarMysql();
		$conBuscar="SELECT ID_INVENTARIO STATUS_ACTIVO FROM inventario WHERE SERIAL='$this->serial'";
		$result=mysql_query($conBuscar);
		$num=mysql_numrows($result);
		if($result && $num>0) {
			mysql_close();
			return 0;
		} else {
			mysql_close();
			return 1;
		}
	}
	function buscarSerial() {
		$conBuscar="select id_inventario,inventario.serial from inventario where serial='$this->serial'";
		conectarMysql();
		$result=mysql_query($conBuscar);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return 0;
		} else {
			return 1;	
		}
	}
	function buscarInventario() {
		$conBuscar="select id_inventario,serial from inventario where id_inventario='$this->idInventario'";
		conectarMysql();
		$result=mysql_query($conBuscar);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			$this->serial=$row[1];
			return $this->serial;
		} else {
			return 1;	
		}	
	}
	function deshacer() {
		$conEliminar="delete from inventario where id_inventario='$this->idInventario'";
		conectarMysql();
		$result=mysql_query($conEliminar);
		mysql_close();
	}
	function actualizarInventario() {

		$conActualizar="update inventario set
		inventario.SERIAL='$this->serial',
		inventario.ID_MODELO='$this->idModelo',
		inventario.FRU='$this->fru',
		inventario.SERVICE_TAG='$this->ServiceTag',
		inventario.EXPRESS_SERVICE='$this->ExpressService',
		inventario.PRODUCT_NUMBER='$this->productNumber',
		inventario.SPARE_NUMBER='$this->spareNumber',
		inventario.CT='$this->ct',
		inventario.ID_PEDIDO='$this->idPedido',
		inventario.FECHA_INICIO='$this->fechaInicio',
		inventario.FECHA_FINAL='$this->fechaFinal'
		where inventario.id_inventario='$this->idInventario'";
		conectarMysql();
		$result=mysql_query($conActualizar);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	function actualizarInformacionGarantia() {
		$conActualizar="update inventario set
		inventario.ID_PEDIDO='$this->idPedido',
		inventario.FECHA_INICIO='$this->fechaInicio',
		inventario.FECHA_FINAL='$this->fechaFinal'
		where inventario.id_inventario='$this->idInventario'";
		conectarMysql();
		$result=mysql_query($conActualizar);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}	
//---------------------------------- Fin de Inventario -----------------------------------------



//---------------------------------- Inicio de Inventario_Propiedad -----------------------------------------



	//Nuevo idInventarioPropiedad
	function nuevoIdInventarioPropiedad() {
		$conUltimo="SELECT ID_INVENTARIO_PROPIEDAD FROM inventario_propiedad ORDER BY ID_INVENTARIO_PROPIEDAD DESC";
		$cons=new consecutivo("INP",$conUltimo);
		$this->idInventarioPropiedad=$cons->retornar();			
	}	
//Metodo que crea un Estado al Activo en y lo almacena en InventarioPropiedad
	function ingresarInventarioPropiedad() {
		switch ($this->idEstado) {
			case 'EST0000001':
				if ($this->retornarUltimoEstado()!='EST0000001' && $this->idSitio=="SIT0000057") {
					$this->ficha="9999999";
					$this->idDepartamento="ORG0000065";
					$this->idSitio="SIT0000057";
					$this->ingresarInventarioUsuario();
					$this->ingresarInventarioUbicacion();
				}
				break 1;
			case 'EST0000002':
				$this->ficha="9999999";
				$this->idDepartamento="ORG0000065";
				$this->idSitio="SIT0000057";
				$this->especifico;
				$this->ingresarInventarioUsuario();
				$this->ingresarInventarioUbicacion();
				$this->actualizarEquipoCampoRedUsuario();
				break 1;
			case 'EST0000003':
				$this->ficha="9999999";
				$this->idDepartamento="ORG0000065";
				$this->idSitio="SIT0000073";
				$this->especifico;
				$this->ingresarInventarioUsuario();
				$this->ingresarInventarioUbicacion();
				$this->actualizarEquipoCampoRedUsuario();
				break 1;
			case 'EST0000004':
				$this->ficha="9999999";
				$this->idDepartamento="ORG0000065";
				$this->idSitio="SIT0000073";
				$this->especifico;
				$this->ingresarInventarioUsuario();
				$this->ingresarInventarioUbicacion();			
				$this->actualizarEquipoCampoRedUsuario();
				break 1;
			case 'EST0000005':
				$this->ficha="9999999";
				$this->idDepartamento="ORG0000065";
				$this->idSitio="SIT0000073";
				$this->especifico;
				$this->ingresarInventarioUsuario();
				$this->ingresarInventarioUbicacion();				
				$this->actualizarEquipoCampoRedUsuario();
				break 1;
			case 'EST0000006':
				//$this->ficha="9999999";
				$this->idDepartamento="ORG0000065";
				$this->idSitio="SIT0000073";
				$this->especifico;
				//$this->ingresarInventarioUsuario();
				$this->ingresarInventarioUbicacion();				
				$this->actualizarEquipoCampoRedUsuario();
				break 1;
		}

		if ($this->retornarUltimoEstado()!=$this->idEstado || $this->retornarUltimoEstado()==1) { 
			$this->nuevoIdInventarioPropiedad();
			$conIngresar="insert into inventario_propiedad (id_inventario_propiedad,id_inventario,id_estado,id_uss,id_departamento,
			id_sitio,ficha,fecha_asociacion,status_actual) 
			values ('$this->idInventarioPropiedad','$this->idInventario','$this->idEstado','$this->idUss','$this->idDepartamento',
			'$this->idSitio','$this->ficha','$this->fechaAsociacion','1')";
			conectarMysql();
			$result=mysql_query($conIngresar);
			mysql_close();
			if ($result) {
				$this->actualizarInventarioPropiedad();
				$this->verificarGarantia();
				return 0;	
			} else {
				return 1;
			}
		} else {
			return 1;	
		}
	}

function actualizarEquipoCampoRedUsuario() {
	$consulta="update equipo_campo set red=0,critico=0,usuario_especializado=0,SP=0 where id_inventario='$this->idInventario'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
	}


	//Coloca como Estado no Actual a todos los registro que coincidan con el IdInventario menos el último ingresado
	function actualizarInventarioPropiedad() {
		$conActualizar="update inventario_propiedad set status_actual=0 
		where id_inventario_propiedad<>'$this->idInventarioPropiedad' and id_inventario='$this->idInventario'";
		conectarMysql();
		$result=mysql_query($conActualizar);
		mysql_close();
	}
	
	//Retorna el último Usuario que tenía el equipo antes de que Estuviera Operativo
	function quienInoperativo() {
		$conBuscar="select ficha from inventario_usuario where id_inventario='$this->idInventario' order by fecha_asociacion desc";
		conectarMysql();
		$result=mysql_query($conBuscar);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[0];
		} else {
			return 1;	
		}
	}
	
	//Retorna la última Ubicación de Equipo antes de que estuviera Operativo
	function dondeInoperativo() {
		$conBuscar="select id_departamento,id_sitio from inventario_ubicacion where id_inventario='$this->idInventario' order by fecha_asociacion desc";
		conectarMysql();
		$result=mysql_query($conBuscar);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}	
	}
	
	//Retorna el último estado del Equipo
	function retornarUltimoEstado() {
		$consulta="select id_estado from inventario_propiedad where id_inventario='$this->idInventario' order by fecha_asociacion desc limit 1";
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
	
	//Verifica si el Equipo está o no en Garantia
	function verificarGarantia($garantia=1) {
		$conGarantia="Select
			inventario_propiedad.ID_INVENTARIO_PROPIEDAD,
			inventario_propiedad.ID_INVENTARIO,
			inventario_propiedad.ID_ESTADO,
			inventario.ID_PEDIDO,
			date_format(inventario.FECHA_INICIO,'%d/%m/%Y') as fecha_inicio,
			date_format(inventario.FECHA_FINAL,'%d/%m/%Y') as fecha_final,
			datediff(inventario.FECHA_FINAL,curdate()) as dias
			From
			inventario_propiedad
			Inner Join inventario ON inventario_propiedad.ID_INVENTARIO = inventario.ID_INVENTARIO
			Where
			inventario_propiedad.ID_INVENTARIO = '$this->idInventario'
			Order By
			inventario_propiedad.FECHA_ASOCIACION Desc
			Limit 1";
		conectarMysql();
		$result=mysql_query($conGarantia);
		mysql_close();
		switch ($garantia) {
			case 1:
				if ($result && mysql_numrows($result)>0) {
					$row=mysql_fetch_array($result);
					if ($row[2]=='EST0000005' && $row[6]>0) {
						require_once("garantiaAdmin.php");
						$garantia= new garantia("",$this->idInventario);
						$resultado=$garantia->insertarGarantia();
						$this->cambiarUbicacionReportadoGarantia();
					}	
				}
			break 1;
			case 0:
				if ($result && mysql_numrows($result)>0) {
					$row=mysql_fetch_array($result);
					if ($row[6]>0) {
						return 1;
					} else {
						return 0;	
					}
					break 1;
				}
		
		}
	}
	
	function verificarTiempoGarantia() {
		$conGarantia="Select
			inventario_propiedad.ID_INVENTARIO_PROPIEDAD,
			inventario_propiedad.ID_INVENTARIO,
			inventario_propiedad.ID_ESTADO,
			inventario.ID_PEDIDO,
			date_format(inventario.FECHA_INICIO,'%d/%m/%Y') as fecha_inicio,
			date_format(inventario.FECHA_FINAL,'%d/%m/%Y') as fecha_final,
			datediff(inventario.FECHA_FINAL,curdate()) as dias
			From
			inventario_propiedad
			Inner Join inventario ON inventario_propiedad.ID_INVENTARIO = inventario.ID_INVENTARIO
			Where
			inventario_propiedad.ID_INVENTARIO = '$this->idInventario'
			Order By
			inventario_propiedad.FECHA_ASOCIACION Desc
			Limit 1";
		conectarMysql();
		$result=mysql_query($conGarantia);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			if ($row[6]>0) {
				//Si está en Garantía
				return 0;	
			} else {
				//Si no está en garantía
				return 1;
			}
		}
	}

	
	
//---------------------------------- Fin de Inventario_Propiedad -----------------------------------------
	

//---------------------------------- Inicio de Inventario_Usuario -----------------------------------------


	//Obtiene un Nuevo IdInventarioUsuario
	function nuevoIdInventarioUsuario() {
		$conUltimo="select id_inventario_usuario from inventario_usuario order by id_inventario_usuario desc limit 1";
		$cons=new consecutivo("IIU",$conUltimo);
		$this->idInventarioUsuario=$cons->retornar();		
	}
	
	//Asocia un Nuevo Usuario al Activo
	function ingresarInventarioUsuario() {
		if ($this->retornarUltimoUsuario()!=$this->ficha || $this->retornarUltimoUsuario()==1) { 
			$this->nuevoIdInventarioUsuario();
			$conIngresar="insert into inventario_usuario (inventario_usuario.ID_INVENTARIO_USUARIO,
				inventario_usuario.ID_INVENTARIO,
				inventario_usuario.FICHA,
				inventario_usuario.ID_USS,
				inventario_usuario.FECHA_ASOCIACION,
				inventario_usuario.STATUS_ACTUAL) 
				values
				('$this->idInventarioUsuario','$this->idInventario','$this->ficha','$this->idUss','$this->fechaAsociacion',1)";
			conectarMysql();
			$result=mysql_query($conIngresar);
			mysql_close();
			if ($result) {
				$this->actualizarInventarioUsuario();
				return 0;
			} else {
				return 1;
			}
		} else {
			return 0;	
		}
	}
	function actualizarInventarioUsuario() {
		$conActualizar="update inventario_usuario set status_actual=0 
		where id_inventario_usuario<>'$this->idInventarioUsuario' and id_inventario='$this->idInventario'";
		conectarMysql();
		$result=mysql_query($conActualizar);
		mysql_close();
	}
	//Retorna el Ultimo Usuario que tiene registrado el Equipo
	function retornarUltimoUsuario($buscar='f') {
		$consulta="Select inventario_usuario.FICHA,
		 usuario.CEDULA,
		 usuario.NOMBRE_USUARIO,
		 usuario.APELLIDO_USUARIO,
		 usuario.ID_CARGO,
		 usuario.EXTENSION 
		From inventario_usuario 
		Inner Join usuario ON inventario_usuario.FICHA = usuario.FICHA 
		Where inventario_usuario.ID_INVENTARIO = '$this->idInventario' 
		 Order By inventario_usuario.FECHA_ASOCIACION Desc Limit 1";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			switch($buscar) {
				case 'f':
					return $row[0];	
					break 1;
				case 'c':
					return $row[1];	
					break 1;
				case 'n':
					return $row[2];	
					break 1;
				case 'a':
					return $row[3];	
					break 1;
				case 'C':
					return $row[4];	
					break 1;
				case 'e':
					return $row[5];	
					break 1;

			}
		} else {
			return 1;
		}
	}
	function buscarUsuario($statusActual="") {
		$consulta="select * from vistainventariousuario where id_inventario='$this->idInventario' and status_actual like '%$statusActual'
		order by fecha_asociacion desc";

		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
	}
	

//---------------------------------- Fin de Inventario_Usuario -----------------------------------------


//---------------------------------- Inicio de Inventario_Ubicacion -----------------------------------------
	//Nuevo InventarioUbicacion
	function nuevoIdInventarioUbicacion() {
		$conUltimo="select id_inventario_ubicacion from inventario_ubicacion order by id_inventario_ubicacion desc";
		$cons=new consecutivo("EUB",$conUltimo);
		$this->idInventarioUbicacion=$cons->retornar();
	}
	
	function ingresarInventarioUbicacion() {
		if (($this->retornarUltimaUbicacion('d')!=$this->idDepartamento || $this->retornarUltimaUbicacion('u')!=$this->idSitio || $this->retornarUltimaUbicacion('e')!=$this->especifico ) || $this->retornarUltimaUbicacion()==1) {
			$this->nuevoIdInventarioUbicacion();
			$conIngresar="insert into inventario_ubicacion (inventario_ubicacion.ID_INVENTARIO_UBICACION,
			inventario_ubicacion.ID_INVENTARIO,
			inventario_ubicacion.ID_DEPARTAMENTO,
			inventario_ubicacion.ID_SITIO,
			inventario_ubicacion.ESPECIFICO,
			inventario_ubicacion.ID_USS,
			inventario_ubicacion.STATUS_ACTUAL,
			inventario_ubicacion.FECHA_ASOCIACION)
			values ('$this->idInventarioUbicacion','$this->idInventario','$this->idDepartamento','$this->idSitio','$this->especifico',
			'$this->idUss',1,'$this->fechaAsociacion')";
			conectarMysql();
			$result=mysql_query($conIngresar);
			mysql_close();
			if ($result) {
				$this->actualizarInventarioUbicacion();
				$this->quitarUsuario();
				return 0;
			} else {
				return 1;	
			}
		} else {
			return 1;
		}
	}
	
	function quitarUsuario() {
		
		if ($this->retornarUltimaUbicacion('u')=='SIT0000057') {
			$this->ficha='9999999';
			$this->ingresarInventarioUsuario();
		}
		
	}
	function actualizarInventarioUbicacion() {
		$conActualizar="update inventario_ubicacion set status_actual=0 
		where id_inventario_ubicacion<>'$this->idInventarioUbicacion' and id_inventario='$this->idInventario'";
		conectarMysql();
		$result=mysql_query($conActualizar);
		mysql_close();
	}	
	//Retorna el Ultimo Usuario que tiene registrado el Equipo
	function retornarUltimaUbicacion($buscar='d') {
		$consulta="Select
			inventario_ubicacion.ID_DEPARTAMENTO,
			departamento.DEPARTAMENTO,
			division.ID_DIVISION,
			division.DIVISION,
			gerencia.ID_GERENCIA,
			gerencia.GERENCIA,
			inventario_ubicacion.ID_SITIO,
			sitio.SITIO,
			inventario_ubicacion.ESPECIFICO
			From
			inventario_ubicacion
			Inner Join departamento ON inventario_ubicacion.ID_DEPARTAMENTO = departamento.ID_DEPARTAMENTO
			Inner Join division ON division.ID_DIVISION = departamento.ID_DIVISION
			Inner Join gerencia ON division.ID_GERENCIA = gerencia.ID_GERENCIA
			Inner Join sitio ON inventario_ubicacion.ID_SITIO = sitio.ID_SITIO
			Where
			inventario_ubicacion.ID_INVENTARIO = '$this->idInventario' and inventario_ubicacion.status_actual='1' 
			Order By
			inventario_ubicacion.FECHA_ASOCIACION Desc
			Limit 1";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			switch($buscar) {
				case 'd': //RETORNA ID_DEPARTAMENTO
					return $row[0];
					break 1;
				case 'dn': //RETORNAR DEPARTAMENTO
					return $row[1];
					break 1;
				case 's': // RETORNA ID_DIVISION
					return $row[2];
					break 1;
				case 'sn': //RETORNA DIVISION
					return $row[3];
					break 1;
				case 'g': //RETORNA ID_GERENCIA
					return $row[4];
					break 1;
				case 'gn': //RETORNA GERENCIA
					return $row[5];
					break 1;
				case 'u': // RETORNA ID_SIITO
					return $row[6];
					break 1;
				case 'un': //RETORNA SITIO
					return $row[7];
					break 1;
				case 'e': //RETORNA UBICACION ESPECÍFICA
					return $row[8];
					break 1;	
			}
		} else {
			return 1;
		}
	}
		
	function cambiarUbicacionReportadoGarantia() {
		$this->idDepartamento="ORG0000065";
		$this->idSitio="SIT0000057";
		$this->especifico="Esperando para Ejecución de Garantía";
		$this->ingresarInventarioUbicacion();
	}
	function cambiarUbicacionDeposito() {
		$this->idDepartamento="ORG0000065";
		$this->idSitio="SIT0000057";
		$this->especifico="Disponible para ser Asignado";
		$this->ingresarInventarioUbicacion();
	}
	
	function cambiarUbicacionOtros() {
		$this->idDepartamento="ORG0000065";
		$this->idSitio="ORG0000020";
		$this->especifico="EQUIPO DESINCORPORADO O POR ROBO/HURTO";
		$this->ingresarInventarioUbicacion();		
	}
	
	function buscarUbicacion($statusActual="") {
		$consulta="select * from vistainventarioubicacion where id_inventario='$this->idInventario' and status_actual='$statusActual' order by fecha_asociacion desc";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();

		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
	}

	

	

//---------------------------------- Fin de Inventario_Ubicacion -----------------------------------------

}

class equipo extends inventario {
	private $configuracion,
	$activoFijo,
	$critico,
	$usuarioEspecializado,
	$SP,
	$red,
	$textoRed,
	$correctivo,
	$textoCorrectivo,
	$encontrado,
	$textoEncontrado,
	$uso,
	$textoUso,
	$fechaActualizacion,
	$textocritico,
	$equipodisponible,
	$textoequipodisponible,
	$SO,
	$txtSO,
	$Antivirus,
	$txtAntivirus,
	$DD,
	$txtDD,
	$txtUbicacionEspecifica,
	$IpImpresora,
	$ColaImpresora,
	$MacImpresora,
	$TonerNegroImpresora,
	$TonerMagentaImpresora,
	$TonerAmarilloImpresora,
	$TonerCyanImpresora,
	$TamborImagenImpresora,
	$CantidadUsuarios,
	$DistanciaMaxima,
	$Conectividad;
	
	function __construct($idInventario="",$serial="",$idDescripcion="",$idMarca="",$idModelo="",$fru="",$productNumber="",$spareNumber="",$ct="",$idPedido="",
	$fechaInicio="",$fechaFinal="",$disponible=0,$idInventarioUsuario="",$ficha="9999999",$statusActual="",$fechaAsociacion="",
	$idInventarioPropiedad="",$idUss="",$idEstado="",$idInventarioUbicacion="",$idDepartamento="",$idSitio="",$especifico="",$configuracion="",$activoFijo="",$critico="",$red="",$usuarioEspecializado="",$SP="",$textoRed="",$correctivo="",$textoCorrectivo="",$encontrado="",$textoEncontrado="",$uso="",$textoUso="",$fechaActualizacion="",$textocritico="",$equipodisponible="",$textoequipodisponible="",$SO="",$txtSO="",$Antivirus="",$txtAntivirus="",$DD="",$txtDD="",$txtUbicacionEspecifica="",$IpImpresora="",$ColaImpresora="",$MacImpresora="",$TonerNegroImpresora="",$TonerMagentaImpresora="",$TonerAmarilloImpresora="",$TonerCyanImpresora="",$TamborImagenImpresora="",$CantidadUsuarios=0,$DistanciaMaxima=0,$Conectividad=0) {
		parent::__construct($idInventario="",$serial="",$idDescripcion="",$idMarca="",$idModelo="",$fru="",$productNumber="",$spareNumber="",$ct="",$idPedido="",
		$fechaInicio="",$fechaFinal="",$disponible=0,$idInventarioUsuario="",$ficha="9999999",$statusActual="",$fechaAsociacion="",
		$idInventarioPropiedad="",$idUss="",$idEstado="",$idInventarioUbicacion="",$idDepartamento="",$idSitio="",$especifico="");
		
		$this->configuracion=$configuracion;
		$this->activoFijo=$activoFijo;
		$this->critico=$critco;
		$this->red=$red;
//*****20-04-09*********************************************************************************************
		$this->textoRed=$textoRed;
		$this->correctivo=$correctivo;
		$this->textocorrectivo=$textocorrectivo;
		$this->encontrado=$encontrado;
		$this->textoencontrado=$textoencontrado;
		$this->uso=$uso;
		$this->textouso=$textouso;
		$this->textocritico=$textocritico;
		$this->DD=$DD;
		$this->txtDD=$txtDD;
		$this->equipodisponible=$equipodisponible;
		$this->textoequipodisponible=$textoequipodisponible;
		$this->fechaActualizacion=substr($fechaActualizacion,6,6)."-".substr($fechaActualizacion,3,2)."-".substr($fechaActualizacion,0,2);
//*****20-04-09*********************************************************************************************
		$this->SO=$SO;
		$this->txtSO=$txtSO;
		$this->Antivirus=$Antivirus;
		$this->txtAntivirus=$txtAntivirus;		
		$this->usuarioEspecializado=$usuarioEspecializado;
		$this->SP=$SP;
		$this->txtUbicacionEspecifica=$txtUbicacionEspecifica;
		$this->IpImpresora=strtoupper($IpImpresora);
		$this->ColaImpresora=strtoupper($ColaImpresora);
		$this->MacImpresora=strtoupper($MacImpresora);
		$this->TonerNegroImpresora=strtoupper($TonerNegroImpresora);
		$this->TonerMagentaImpresora=strtoupper($TonerMagentaImpresora);
		$this->TonerAmarilloImpresora=strtoupper($TonerAmarilloImpresora);
		$this->TonerCyanImpresora=strtoupper($TonerCyanImpresora);
		$this->TamborImagenImpresora=strtoupper($TamborImagenImpresora);
		$this->CantidadUsuarios=$CantidadUsuarios;
		$this->DistanciaMaxima=$DistanciaMaxima;
		$this->Conectividad=$Conectividad;
	}
	
	function setEquipo($configuracion="",$activoFijo="",$critico=0,$red=0,$usuarioEspecializado=0,$SP=0,$textoRed="",$correctivo=0,$textocorrectivo="",$encontrado=0,$textoencontrado="",$uso=0,$textouso="",$FechaActualizacion="",$textocritico="",$equipodisponible=0,$textoequipodisponible="",$SO=0,$txtSO="",$Antivirus=0,$txtAntivirus="",$DD=0,$txtDD="",$txtUbicacionEspecifica="",$IpImpresora="",$ColaImpresora="",$MacImpresora="",$TonerNegroImpresora="",$TonerMagentaImpresora="",$TonerAmarilloImpresora="",$TonerCyanImpresora="",$TamborImagenImpresora="",$CantidadUsuarios=0,$DistanciaMaxima=0,$Conectividad=0) {
		$this->configuracion=strtoupper($configuracion);
		$this->activoFijo=strtoupper($activoFijo);
		$this->fechaActualizacion=substr($FechaActualizacion,6,6)."-".substr($FechaActualizacion,3,2)."-".substr($FechaActualizacion,0,2);
		if (empty($critico)) 
			$this->critico=0;
		else	
			$this->critico=$critico;
		if (empty($red))	
			$this->red=0;
		else
			$this->red=$red;
		if (empty($usuarioEspecializado))
			$this->usuarioEspecializado=0;
		else
			$this->usuarioEspecializado=$usuarioEspecializado;
		if (empty($SP))
			$this->SP=0;
		else
			$this->SP=$SP;
		if (empty($textocritico))
			$this->textocritico="";
		else
			$this->textocritico=$textocritico;
//****20-04-09**********************************************************************
//****20-04-09**********************************************************************
		if (empty($SO))
			$this->SO=0;
		else
			$this->SO=$SO;
		if (empty($txtSO))
			$this->txtSO="";
		else
			$this->txtSO=$txtSO;
		if (empty($Antivirus))
			$this->Antivirus=0;
		else
			$this->Antivirus=$Antivirus;
		if (empty($Conectividad))
			$this->Conectividad=0;
		else
			$this->Conectividad=$Conectividad;
		if (empty($txtAntivirus))
			$this->txtAntivirus="";
		else
			$this->txtAntivirus=$txtAntivirus;
		if (empty($DD))
			$this->DD=0;
		else
			$this->DD=$DD;
		if (empty($txtDD))
			$this->txtDD="";
		else
			$this->txtDD=$txtDD;
		if (empty($textoRed))
			$this->textoRed="";
		else
			$this->textoRed=$textoRed;
		if (empty($correctivo))
			$this->correctivo=0;
		else
			$this->correctivo=$correctivo;
		if (empty($textocorrectivo))
			$this->textocorrectivo="";
		else
			$this->textocorrectivo=$textocorrectivo;
		if (empty($encontrado))
			$this->encontrado=0;
		else
			$this->encontrado=$encontrado;
		if (empty($textoencontrado))
			$this->textoencontrado="";
		else
			$this->textoencontrado=$textoencontrado;	
		if (empty($uso))
			$this->uso=0;
		else
			$this->uso=$uso;
		if (empty($textouso))
			$this->textouso="";
		else
			$this->textouso=$textouso;	
		if (empty($equipodisponible))
			$this->equipodisponible=0;
		else
			$this->equipodisponible=$equipodisponible;
		if (empty($textoequipodisponible))
			$this->textoequipodisponible="";
		else
			$this->textoequipodisponible=$textoequipodisponible;			
		if (empty($txtUbicacionEspecifica))
			$this->txtUbicacionEspecifica="";
		else
			$this->txtUbicacionEspecifica=$txtUbicacionEspecifica;
		if (empty($IpImpresora))
			$this->IpImpresora="";
		else
			$this->IpImpresora=$IpImpresora;
		if (empty($ColaImpresora))
			$this->ColaImpresora="";
		else
			$this->ColaImpresora=$ColaImpresora;
		if (empty($MacImpresora))
			$this->MacImpresora="";
		else
			$this->MacImpresora=$MacImpresora;
		if (empty($TonerNegroImpresora))
			$this->TonerNegroImpresora="";
		else
			$this->TonerNegroImpresora=$TonerNegroImpresora;
		if (empty($TonerMagentaImpresora))
			$this->TonerMagentaImpresora="";
		else
			$this->TonerMagentaImpresora=$TonerMagentaImpresora;
		if (empty($TonerAmarilloImpresora))
			$this->TonerAmarilloImpresora="";
		else
			$this->TonerAmarilloImpresora=$TonerAmarilloImpresora;
		if (empty($TonerCyanImpresora))
			$this->TonerCyanImpresora="";
		else
			$this->TonerCyanImpresora=$TonerCyanImpresora;
		if (empty($TamborImagenImpresora))
			$this->TamborImagenImpresora="";
		else
			$this->TamborImagenImpresora=$TamborImagenImpresora;			
		if (empty($CantidadUsuarios))
			$this->CantidadUsuarios=0;
		else
			$this->CantidadUsuarios=$CantidadUsuarios;	
		if (empty($DistanciaMaxima))
			$this->DistanciaMaxima=0;
		else
			$this->DistanciaMaxima=$DistanciaMaxima;			
			
//****20-04-09**********************************************************************
//****20-04-09**********************************************************************
	}
	
	function nuevoEquipo() {
		$IngresarenInventario=$this->ingresarInventario();
		$IngresarenInventarioUbicacion=$this->ingresarInventarioUbicacion();
		$IngresarInventarioPropiedad=$this->ingresarInventarioPropiedad();
		$IngresarEquipo=$this->ingresarEquipo();
			
		$total=$IngresarenInventario+$IngresarenInventarioUbicacion+$IngresarInventarioPropiedad+$IngresarEquipo;
		if ($total==0) {
			return 0;
		} else {
			$this->deshacer();
			return 1;	
		}
	}
	function ingresarEquipo() {
		if ($this->buscarConfiguracion()==0) {
			return 2;
		}
		if ($this->buscarActivoFijo()==0) {
			return 3;	
		}
		$conIngresar="insert into equipo_campo(configuracion,activo_fijo,id_inventario,fecha_asociacion) 
		values ('$this->configuracion','$this->activoFijo','$this->idInventario','$this->fechaAsociacion')";
		//$conIngresar="insert into equipo_campo(configuracion,activo_fijo,id_inventario,fecha_asociacion,critico,usuario_especializado,mantenimiento,sp,red,texto_red,correctivo,texto_correctivo,encontrado,texto_encontrado,uso,texto_uso,fecha_actualizacion,texto_critico,disponible,texto_disponible,sistema_operativo,texto_so,antivirus,texto_antivirus) 
		//values ('$this->configuracion','$this->activoFijo','$this->idInventario','$this->fechaAsociacion','$this->critico','$this->usuarioEspecializado',0,'$this->SP','$this->red','$this->texto_red','$this->correctivo','$this->texto_correctivo',0,"",0,"","","",0,"",0,"",0,"")";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
		if ($result) {
			return 0;
		} else {
			return 1;
		}	
	}
	//Verifica si existe un Equipo con el numero de Configuracion Dado
	function buscarConfiguracion() {
		$consulta="select configuracion from equipo_campo where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return 0;
		} else {
			return 1;
		}	
		
	}
	//Verifica si existe un Equipo con El activo Fijo
	function buscarActivoFijo() {
		if ($this->activoFijo!="") {
			$consulta="select activo_fijo from equipo_campo where activo_fijo='$this->activoFijo' and configuracion<>'$this->configuracion'";
			conectarMysql();
			$result=mysql_query($consulta);
			mysql_close();
			if ($result && mysql_numrows($result)>0) {
				return 0;	
			} else {
				return 1;
			}
		}else {
			return 1;	
		}
	}


	//Busca un Equipo por medio de la Configuracion
	function buscarEquipo() {
		$conBuscar="Select
			equipo_campo.CONFIGURACION,	
			equipo_campo.ACTIVO_FIJO,
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
			modelo.STATUS_ACTIVO,
			inventario.FRU,
			inventario.PRODUCT_NUMBER,
			inventario.SPARE_NUMBER,
			inventario.CT,
			inventario.ID_PEDIDO,
			pedido.ID_PROVEEDOR,
			proveedor.PROVEEDOR,
			inventario.FECHA_INICIO,
			inventario.FECHA_FINAL,
			equipo_campo.critico,
			equipo_campo.red,
			equipo_campo.usuario_especializado,
			equipo_campo.SP,
			inventario.Service_Tag,
			inventario.Express_Service,
			equipo_campo.correctivo,
			equipo_campo.texto_correctivo,
			equipo_campo.encontrado,
			equipo_campo.texto_encontrado,
			equipo_campo.texto_red,
			equipo_campo.uso,
			equipo_campo.texto_uso,
			equipo_campo.fecha_actualizacion,
			equipo_campo.texto_critico,
			equipo_campo.disponible,
			equipo_campo.texto_disponible,
			equipo_campo.sistema_operativo,
			equipo_campo.texto_so,
			equipo_campo.antivirus,
			equipo_campo.texto_antivirus,
			equipo_campo.ubicacion_especifica,
			equipo_campo.ip_impresora,
			equipo_campo.cola_impresora,
			equipo_campo.mac_impresora,
			equipo_campo.toner_negro_impresora,
			equipo_campo.toner_magenta_impresora,
			equipo_campo.toner_amarillo_impresora,
			equipo_campo.toner_cyan_impresora,
			equipo_campo.tambor_imagen_impresora,
			equipo_campo.cantidad_usuarios,
			equipo_campo.distancia_maxima,
			equipo_campo.conectividad_red
			
			From
			equipo_campo
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Inner Join descripcion_marca ON marca.ID_MARCA = descripcion_marca.ID_MARCA
			Inner Join descripcion ON descripcion_marca.ID_DESCRIPCION = descripcion.ID_DESCRIPCION AND modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join pedido ON inventario.ID_PEDIDO = pedido.ID_PEDIDO
			Inner Join proveedor ON pedido.ID_PROVEEDOR = proveedor.ID_PROVEEDOR
			Where
			equipo_campo.CONFIGURACION = '$this->configuracion' or inventario.id_inventario='$this->idInventario'";
		
		conectarMysql();
		$result=mysql_query($conBuscar);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			$this->idInventario=$row[2];
				conectarMysql();
				$result=mysql_query($conBuscar);
				mysql_close();
			return $result;	
		} else {
			return 1;
		}
	}	
	
	//********************************************************************************************************************
	//********************************************************************************************************************
	function eliminarInventario() {
		$equipoBuscar=new equipo();
		$equipoBuscar->setEquipo($this->configuracion);
		$resultadoEquipo=$equipoBuscar->buscarEquipo();
		if ($resultadoEquipo && $resultadoEquipo != 1){
			$row=mysql_fetch_array($resultadoEquipo);
			$serialInventario=$row[3];
			$consulta="delete from inventario where serial='$serialInventario'";
			conectarMysql();
			$result=mysql_query($consulta);
			mysql_close();	
			if ($result>0) {
				return 0;
			} else {
				return 1;
			}
		}
	}	
	
	function validarMantenimientoEquipo() {
		$consulta="delete from mantenimiento_preventivo where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		$affected=mysql_affected_rows();
		mysql_close();	
		if ($result>0) {
			return 0;
		} else {
			return 1;
		}
	}
	
	function validarMigracionEquipo() {
		$consulta="delete from migracion_equipo where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		$affected=mysql_affected_rows();
		mysql_close();	
		if ($affected>0) {
			return 0;
		} else {
			return 1;
		}
	}
	
	function eliminarEquipo() {
		$mantenimientoPreventivo=$this->validarMantenimientoEquipo();
		$migracionEquipo=$this->validarMigracionEquipo();
		if (($mantenimientoPreventivo==1 && $migracionEquipo==1) || ($mantenimientoPreventivo==0 && $migracionEquipo==1) || ($mantenimientoPreventivo==1 && $migracionEquipo==0) || ($mantenimientoPreventivo==0 && $migracionEquipo==0)){
			$consulta="delete from equipo_campo where configuracion='$this->configuracion'";
			conectarMysql();
			$result=mysql_query($consulta);
			$affected=mysql_affected_rows();
			mysql_close();	
			if ($affected>0) {
				return 0;
			} else {
				return 1;
			}
		}
	}
	//********************************************************************************************************************
	//********************************************************************************************************************	

	//Busca los Componentes que están disponibles y que se le pueden asignar el Equipo
	function buscarComponentesDisponibles() {
			$conBuscar="Select
				componente_campo.ID_INVENTARIO,
				inventario.SERIAL,
				descripcion.ID_DESCRIPCION,
				descripcion.DESCRIPCION,
				marca.ID_MARCA,
				marca.MARCA,
				modelo.ID_MODELO,
				modelo.MODELO,
				modelo.CAP_VEL,
				modelo.UNIDAD,
				inventario.FRU,
				inventario.PRODUCT_NUMBER,
				inventario.SPARE_NUMBER,
				inventario.CT,
				inventario.ID_PEDIDO,
				inventario.FECHA_INICIO,
				inventario.FECHA_FINAL
				From
				componente_campo
				Inner Join inventario ON componente_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
				Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
				Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
				Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
		Where componente_campo.ID_INVENTARIO not in 
		(Select inventario_propiedad.ID_INVENTARIO From inventario_propiedad Where inventario_propiedad.STATUS_ACTUAL = '1' AND inventario_propiedad.ID_ESTADO <> 'EST0000001')
		 and componente_campo.id_inventario not in (Select equipo_componente_campo.ID_INVENTARIO From equipo_componente_campo Where equipo_componente_campo.CONFIGURACION = '$this->configuracion' AND equipo_componente_campo.STATUS_ACTUAL = '1')
		and inventario.serial like '%$this->serial' and descripcion.id_descripcion like '%$this->idDescripcion' and marca.id_marca like '%$this->idMarca' and inventario.id_modelo like '%$this->idModelo' order by inventario.serial limit 5";
	
	conectarMysql();
	 $result=mysql_query($conBuscar);
	 mysql_close();
	 if ($result && mysql_numrows($result)>0) {
	 	return $result;	
	 } else {
	 	return 1;	
	 }
	}
	
	function buscarSuministrosDisponibles() {
			$conBuscar="Select
			inventario.ID_INVENTARIO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			descripcion.ID_DESCRIPCION_PROPIEDAD,
			descripcion.SUMINISTRO,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			sitio.ID_SITIO,
			sitio.SITIO,
			gerencia.ID_GERENCIA,
			gerencia.GERENCIA,
			division.ID_DIVISION,
			division.DIVISION,
			departamento.ID_DEPARTAMENTO,
			departamento.DEPARTAMENTO
			From
			inventario
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Inner Join inventario_ubicacion ON inventario.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO
			Inner Join departamento ON inventario_ubicacion.ID_DEPARTAMENTO = departamento.ID_DEPARTAMENTO
			Inner Join division ON departamento.ID_DIVISION = division.ID_DIVISION
			Inner Join gerencia ON division.ID_GERENCIA = gerencia.ID_GERENCIA
			Inner Join sitio ON inventario_ubicacion.ID_SITIO = sitio.ID_SITIO
			Inner Join inventario_propiedad ON inventario.ID_INVENTARIO = inventario_propiedad.ID_INVENTARIO
			Where
			inventario_ubicacion.STATUS_ACTUAL = '1' AND
			inventario_propiedad.STATUS_ACTUAL = '1' AND
			inventario_propiedad.ID_ESTADO='EST0000001' AND
			descripcion.SUMINISTRO = '1' AND
			inventario_ubicacion.ID_SITIO = 'SIT0000057' AND
			descripcion.ID_DESCRIPCION Like '%$idDescripcion' AND
			marca.ID_MARCA Like '%$idMarca' AND
			modelo.ID_MODELO Like '%$idModelo' order by inventario.serial limit 5";
	conectarMysql();
	 $result=mysql_query($conBuscar);
	 mysql_close();
	 if ($result && mysql_numrows($result)>0) {
	 	return $result;	
	 } else {
	 	return 1;	
	 }
	}	
	
	//Buscar los Componentes del Equipo relacionados en el Campo de Produccion
	function buscarComponentesAsociados($buscar='a') {
		switch($buscar) {
			//actuales
			case 'a':
				$buscar=1;
				break 1;
			//Pasados
			case 'p':
				$buscar=0;
				break 1;
			//Todos
			case 't':
				$buscar="";
				break 1;
		}
		
		if (isset($this->configuracion) && !empty($this->configuracion)) {
			$idInventario="";
		} else {
			$idInventario=$this->idInventario;
		}
		
	
		$conBuscar="Select
			equipo_componente_campo.ID_EQUIPO_COMPONENTE_CAMPO,
			equipo_componente_campo.CONFIGURACION,
			equipo_componente_campo.ID_INVENTARIO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			inventario.FRU,
			inventario.PRODUCT_NUMBER,
			inventario.SPARE_NUMBER,
			inventario.CT,
			inventario.ID_PEDIDO,
			inventario.FECHA_INICIO,
			inventario.FECHA_FINAL,
			equipo_componente_campo.FECHA_ASOCIACION,
			pedido.ID_PROVEEDOR,
			proveedor.PROVEEDOR
			From
			equipo_componente_campo
			Inner Join inventario ON equipo_componente_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON marca.ID_MARCA = modelo.ID_MARCA
			Inner Join pedido ON inventario.ID_PEDIDO = pedido.ID_PEDIDO
			Inner Join proveedor ON proveedor.ID_PROVEEDOR = pedido.ID_PROVEEDOR
			Where
			equipo_componente_campo.CONFIGURACION Like '%$this->configuracion' and equipo_componente_campo.id_inventario like '%$idInventario' and
			equipo_componente_campo.STATUS_ACTUAL Like '%$buscar' order by descripcion.descripcion";

		conectarMysql();
		$result=mysql_query($conBuscar);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;	
		}
	}
	
	//Muestra los Componentes del Equipo relacionados por Garantia
	function buscarComponentesAsociadosEnGarantia() {
		$consulta="Select
			componente_garantia.ID_INVENTARIO,
			equipo_campo.CONFIGURACION,
			equipo_campo.ACTIVO_FIJO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			inventario.FRU,
			inventario.PRODUCT_NUMBER,
			inventario.SPARE_NUMBER,
			inventario.CT,
			inventario.ID_PEDIDO,
			inventario.FECHA_INICIO,
			inventario.FECHA_FINAL
			From
			equipo_campo
			Inner Join componente_garantia ON componente_garantia.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join inventario ON componente_garantia.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON modelo.ID_MODELO = inventario.ID_MODELO
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			where equipo_campo.configuracion='$this->configuracion' order by descripcion.descripcion";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)) {
			return $result;	
		} else {
			return 1;
		}
	}
	function actualizarEquipo() {
		$this->actualizarInventario();	
	}
	function actualizarActivoFijo() {
		if ($this->buscarActivoFijo()==0) {
			return 1;
		}
		$consulta="update equipo_campo set activo_fijo='$this->activoFijo' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);	
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	function actualizarCritico() {
		$consulta="update equipo_campo set critico='$this->critico' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);	
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	function actualizarRed() {
		$consulta="update equipo_campo set red='$this->red' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);	
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	function actualizarUsuarioEspecializado() {
		$consulta="update equipo_campo set usuario_especializado='$this->usuarioEspecializado' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	

//*******************************************************************************************************************
//*******************************************************************************************************************
//*******************************************************************************************************************
function actualizarSP() {
		$consulta="update equipo_campo set SP='$this->SP' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}

function actualizarTextoRed() {
		$consulta="update equipo_campo set Texto_Red='$this->textoRed' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}

function actualizarCorrectivo() {
		$consulta="update equipo_campo set Correctivo='$this->correctivo' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}

function actualizarTextoCorrectivo() {
		$consulta="update equipo_campo set Texto_Correctivo='$this->textocorrectivo' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}

function actualizarEncontrado() {
		$consulta="update equipo_campo set Encontrado='$this->encontrado' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}

function actualizarTextoEncontrado() {
		$consulta="update equipo_campo set Texto_Encontrado='$this->textoencontrado' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}

function actualizarUso() {
		$consulta="update equipo_campo set Uso='$this->uso' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}

function actualizarTextoUso() {
		$consulta="update equipo_campo set Texto_Uso='$this->textouso' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	
function actualizarTextoCritico() {
		$consulta="update equipo_campo set Texto_Critico='$this->textocritico' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}

function actualizarFechaActualizacion() {
		$consulta="update equipo_campo set fecha_actualizacion='$this->fechaActualizacion' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}

function actualizarDisponible() {
		$consulta="update equipo_campo set Disponible='$this->equipodisponible' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	
function actualizarTextoDisponible() {
		$consulta="update equipo_campo set Texto_Disponible='$this->textoequipodisponible' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	
function actualizarUbicacionEspecifica() {
		$consulta="update equipo_campo set Ubicacion_Especifica ='$this->txtUbicacionEspecifica' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}

function actualizarSistemaOperativo() {
		$consulta="update equipo_campo set Sistema_Operativo='$this->SO' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	
function actualizarTextoSistemaOperativo() {
		$consulta="update equipo_campo set Texto_SO='$this->txtSO' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}

function actualizarAntivirus() {
		$consulta="update equipo_campo set Antivirus='$this->Antivirus' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	
function actualizarConectividad() {
		$consulta="update equipo_campo set conectividad_red='$this->Conectividad' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	
function actualizarTextoAntivirus() {
		$consulta="update equipo_campo set Texto_Antivirus='$this->txtAntivirus' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	
function actualizarDD() {
		$consulta="update equipo_campo set DD='$this->DD' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	
function actualizarTextoDD() {
		$consulta="update equipo_campo set Texto_DD='$this->txtDD' where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;
		}
	}
	
//*******************************************************************************************************************
//*******************************************************************************************************************
//*******************************************************************************************************************

function actualizarPedido() {
		$this->actualizarInformacionGarantia();
		$resultado=$this->buscarComponentesAsociadosEnGarantia();
		if ($resultado && $resultado!=1) {
			while ($row=mysql_fetch_array($resultado)) {
				$componente= new componente();
				$fechaI=substr($this->fechaInicio,8,2).'/'.substr($this->fechaInicio,5,2).'/'.substr($this->fechaInicio,0,4); 
				$fechaF=substr($this->fechaFinal,8,2).'/'.substr($this->fechaFinal,5,2).'/'.substr($this->fechaFinal,0,4);
				$componente->setInventario($row[0],"","","","","","","","",$this->idPedido,$fechaI,$fechaF,"",$this->idUss);
				$componente->actualizarInformacionGarantia();
			}	
		}
	}
	function actualizarComponentesAsociados() {
		$result=$this->ingresarInventarioUbicacion();
		$result=$this->ingresarInventarioUsuario();
		
		$componentesAsociados=$this->buscarComponentesAsociados();
		$componente=new componente();
			$componente->setComponente($this->configuracion);
			if ($componentesAsociados && $componentesAsociados!=1) {
				while ($row=mysql_fetch_array($componentesAsociados)) {
					$componente->setInventario($row[2]);
					
					$componente->setInventarioUbicacion($this->idDepartamento,$this->idSitio,$this->especifico,$this->idUss);
					$componente->setInventarioPropiedad($this->idEstado);
					$componente->setInventarioUsuario($this->ficha,$this->idUss);
					$componente->ingresarInventarioUsuario();
					$componente->ingresarInventarioPropiedad();
					$componente->ingresarInventarioUbicacion();
				}
			}
				
		$componentesAsociados=$this->buscarComponentesAsociados();

		switch ($this->idEstado) {
			case 'EST0000001':
				break 1;
			case 'EST0000005':
				$this->actualizarInformacionGarantia();
				break 1;
		}
		
		$result=$this->ingresarInventarioPropiedad();
		if ($result!=1) {
			$componentesAsociados=$this->buscarComponentesAsociados();
			$componente=new componente();
			$componente->setComponente($this->configuracion);
			if ($componentesAsociados && $componentesAsociados!=1) {
				while ($row=mysql_fetch_array($componentesAsociados)) {
					$componente->setInventario($row[2]);
					$componente->setInventarioPropiedad($this->idEstado);
					$componente->setInventarioUbicacion($this->idDepartamento,$this->idSitio,$this->especifico,$this->idUss);
					$componente->setInventarioUsuario($this->ficha,$this->idUss);
					$componente->ingresarInventarioUsuario();
					$componente->ingresarInventarioPropiedad();
					$componente->ingresarInventarioUbicacion();
				}
			}
		}	
	}
	
	
// --------------------------------- SOFTWARE ASOCIADO AL EQUIPO ------------------------------	
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
	function retornarReporteEjecucionEquipoEdificios($fecha1="", $fecha2=""){	
			if(!empty($fecha1)){
				$fecha1=split("/",$fecha1);
				$fecha1=$fecha1[2]."-".$fecha1[1]."-".$fecha1[0];
				$fecha1=" AND DATE(mantenimiento_preventivo.HORA_INICIO) >= '$fecha1'";
			}
			if(!empty($fecha2)){
				$fecha2=split("/",$fecha2);
				$fecha2=$fecha2[2]."-".$fecha2[1]."-".$fecha2[0];
				$fecha2=" AND DATE(mantenimiento_preventivo.HORA_INICIO) <= '$fecha2'";
			}
		
			$consulta="Select			
			equipo_campo.CONFIGURACION,
			equipo_campo.ACTIVO_FIJO,
			equipo_campo.ID_INVENTARIO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			sitio.ID_SITIO,
			sitio.SITIO,
			mantenimiento_preventivo.ID_MANTENIMIENTO AS ID,
			mantenimiento_preventivo.HORA_INICIO,
			mantenimiento_preventivo.HORA_FINAL,
			(SELECT COUNT(ID_MANTENIMIENTO_PREVENTIVO) from detalle_mantenimiento_preventivo WHERE ID_MANTENIMIENTO_PREVENTIVO=ID) AS CT
			

			From
			equipo_campo		
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Inner Join inventario_ubicacion ON inventario_ubicacion.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join sitio ON inventario_ubicacion.ID_SITIO = sitio.ID_SITIO
			Inner Join mantenimiento_preventivo ON (equipo_campo.CONFIGURACION=mantenimiento_preventivo.CONFIGURACION AND mantenimiento_preventivo.ID_SITIO=sitio.ID_SITIO)						
			Where
			inventario_ubicacion.STATUS_ACTUAL = '1' ".$fecha1."".$fecha2.
			"
			 AND sitio.ID_SITIO='$this->idSitio'
			
			and descripcion.id_descripcion in ('DES0000001','DES0000008','DES0000042') 	
			
			
			order by  equipo_campo.configuracion,descripcion.descripcion";
			$consulta="SELECT * FROM ($consulta) as temporal WHERE CT=0";
			//echo $consulta;
			conectarMysql();
			$result=mysql_query($consulta);
			mysql_close();
			if ($result && mysql_numrows($result)>0) {
				return $result;	
			} else {
				return 1;	
			}
	}
	function retornarReporteEquipoEdificios() {
		$consulta="Select
			equipo_campo.CONFIGURACION,
			equipo_campo.ACTIVO_FIJO,
			equipo_campo.ID_INVENTARIO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			sitio.ID_SITIO,
			sitio.SITIO,		
			cantidad_mantenimientos(equipo_campo.configuracion) AS 'CANTIDAD',
			CONCAT(vistainventarioequipos.NOMBRE_USUARIO,' ',vistainventarioequipos.APELLIDO_USUARIO) AS USUARIO,
			vistainventarioequipos.FICHA,
			vistainventarioequipos.GERENCIA,
			vistainventarioequipos.SITIO
			From
			equipo_campo
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Inner Join inventario_ubicacion ON inventario_ubicacion.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join sitio ON inventario_ubicacion.ID_SITIO = sitio.ID_SITIO
			INNER JOIN vistainventarioequipos ON equipo_campo.CONFIGURACION=vistainventarioequipos.CONFIGURACION
			Where
			inventario_ubicacion.STATUS_ACTUAL = '1' AND
			sitio.ID_SITIO Like '%$this->idSitio' and descripcion.id_descripcion in ('DES0000001','DES0000008','DES0000042') 
			order by descripcion.descripcion, equipo_campo.configuracion";
			
		
		
		
		
		
		
		conectarMysql();
			$result=mysql_query($consulta);
			mysql_close();
			if ($result && mysql_numrows($result)>0) {
				return $result;	
			} else {
				return 1;	
			}
	}
	function retornarCantidadPorSitio($idDescripcion="") {
		$consulta="Select
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			sitio.ID_SITIO,
			sitio.SITIO,
			Count(equipo_campo.CONFIGURACION)
			From
			equipo_campo
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join inventario_ubicacion ON inventario.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join sitio ON inventario_ubicacion.ID_SITIO = sitio.ID_SITIO
			Where
			inventario_ubicacion.STATUS_ACTUAL = '1' and sitio.ID_SITIO Like '%$this->idSitio' and descripcion.id_descripcion='$idDescripcion'
			Group By
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			sitio.ID_SITIO,
			sitio.SITIO
			Order By
			descripcion.DESCRIPCION Asc";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[4];
		} else {
			return 0;	
		}
	}
	function retornarCantidadMantenimientos($configuracion) {
		$consulta="Select
			equipo_campo.CONFIGURACION,
			Count(mantenimiento_preventivo.CONFIGURACION)
			From
			mantenimiento_preventivo
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Where
			mantenimiento_preventivo.STATUS_MANTENIMIENTO = '2' AND
			mantenimiento_preventivo.CONFIGURACION = '$configuracion'
			Group By
			equipo_campo.CONFIGURACION";
		conectarMysql();
		$result=mysql_query($consulta);
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[1];
		} else {
			return 0;	
		}
	}
	
	function retornarMantenimientosCompletos($status) {
	$consulta="Select
			mantenimiento_preventivo.ID_MANTENIMIENTO,
			mantenimiento_preventivo.CONFIGURACION,
			usuario_sistema.NOMBRE,
			usuario_sistema.APELLIDO,
			mantenimiento_preventivo.FICHA,
			usuario.NOMBRE_USUARIO,
			usuario.APELLIDO_USUARIO,
			usuario.EXTENSION,
			mantenimiento_preventivo.HORA_INICIO,
			mantenimiento_preventivo.HORA_FINAL,
			mantenimiento_preventivo.STATUS_MANTENIMIENTO,
			mantenimiento_preventivo.SISTEMA_OPERATIVO,
			mantenimiento_preventivo.ANTIVIRUS,
			mantenimiento_preventivo.RED,
			mantenimiento_preventivo.TRABAJO_REALIZADO,
			mantenimiento_preventivo.OBSERVACION,
			mantenimiento_preventivo.PENDIENTE,
			mantenimiento_preventivo.PUNTO_PENDIENTE,
			mantenimiento_preventivo.CORRECTIVO,
			mantenimiento_preventivo.TRABAJO_CORRECTIVO,
			mantenimiento_preventivo.FECHA_CIERRE,
			gerencia.GERENCIA,
			division.DIVISION,
			departamento.DEPARTAMENTO,
			sitio.SITIO
			From
			mantenimiento_preventivo
			Inner Join equipo_campo ON mantenimiento_preventivo.CONFIGURACION = equipo_campo.CONFIGURACION
			Inner Join usuario_sistema ON mantenimiento_preventivo.ID_USS = usuario_sistema.ID_USS
			Left Join usuario ON mantenimiento_preventivo.FICHA = usuario.FICHA
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join ubicacion ON mantenimiento_preventivo.ID_UBICACION = ubicacion.ID_UBICACION
			Inner Join gerencia ON ubicacion.ID_GERENCIA = gerencia.ID_GERENCIA
			Inner Join division ON ubicacion.ID_DIVISION = division.ID_DIVISION
			Inner Join departamento ON departamento.ID_DEPARTAMENTO = ubicacion.ID_DEPARTAMENTO
			Inner Join sitio ON ubicacion.ID_SITIO = sitio.ID_SITIO
			Where
			mantenimiento_preventivo.CONFIGURACION Like '%$this->configuracion' AND
			mantenimiento_preventivo.ID_USS Like '%$this->idUss' AND
			ubicacion.ID_GERENCIA Like '%$this->idGerencia' AND
			ubicacion.ID_SITIO Like '%$this->idSitio' AND
			mantenimiento_preventivo.STATUS_MANTENIMIENTO Like '%$status'
			Order By
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

	function retornarEquiposPorEdificios() {
		$consulta="Select
			sitio.ID_SITIO,
			sitio.SITIO,
			descripcion.DESCRIPCION,
			Count(equipo_campo.CONFIGURACION)
			From
			equipo_campo
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join inventario_ubicacion ON inventario.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO
			Inner Join sitio ON sitio.ID_SITIO = inventario_ubicacion.ID_SITIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Group By
			sitio.ID_SITIO,
			sitio.SITIO,
			descripcion.DESCRIPCION
			Order By
			sitio.SITIO Asc,
			descripcion.DESCRIPCION Asc";
		conectarMysql();
		$result=mysql_query($consulta); {
				
		}
	}

	function ingresarHojas($cantidad) {
		
		if ($cantidad==0 || empty($cantidad)) {
			return 2;
		}
		$conIngresar="insert into impresora_hoja 
		(configuracion,cantidad,fecha_asociacion,id_uss) 
		values ('$this->configuracion','$cantidad','$this->fechaAsociacion','$this->idUss')";
		
		conectarMysql();
		$result=mysql_query($conIngresar);
		$affected=mysql_affected_rows();
		mysql_close();
		
		if ($result && $affected>0) {
			return 0;
		} else {
			return 1;
		}
	}
	
	function ActualizarHojasMantenimiento($cantidad,$idMantenimiento) {
		
		if ($cantidad==0 || empty($cantidad)) {
			return 2;
		}
		
		$conIngresar="update mantenimiento_preventivo set 
		cant_hojas_impresas='$cantidad'
		where id_mantenimiento='$idMantenimiento'";
		
		conectarMysql();
		$result=mysql_query($conIngresar);
		$affected=mysql_affected_rows();
		mysql_close();
		
		if ($result && $affected>0) {
			return 0;
		} else {
			return 1;
		}
	}
	
	function modificarEquipo($configuracion) {
		$resultadoEquipo=$this->modificarEquipoCampo($configuracion);
		$resultadoInventario=$this->modificarInventario();
		if ($resultadoEquipo==0 || $resultadoInventario==0) {
			return 0;
		} else {
			return 1;
		}
	}
	
	function modificarEquipoCampo($configuracion) {
		if ($this->buscarActivoFijo()==0) {
			return 3;
		}
		
		$consulta="update equipo_campo set 
		configuracion='$configuracion',
		activo_fijo='$this->activoFijo'
		where id_inventario='$this->idInventario'";
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
	function modificarInventario() {	
		$consulta="update inventario set inventario.serial='$this->serial', inventario.id_modelo='$this->idModelo', inventario.fru='$this->fru', inventario.product_number='$this->productNumber', inventario.spare_number='$this->spareNumber', inventario.ct='$this->ct', inventario.fecha_asociacion='$this->fechaAsociacion', inventario.id_uss='$this->idUss', inventario.SERVICE_TAG='$this->ServiceTag', inventario.EXPRESS_SERVICE='$this->ExpressService' where id_inventario='$this->idInventario'";
		$consulta2="update equipo_campo set equipo_campo.IP_IMPRESORA='$this->IpImpresora', equipo_campo.COLA_IMPRESORA='$this->ColaImpresora', equipo_campo.MAC_IMPRESORA='$this->MacImpresora', equipo_campo.TONER_NEGRO_IMPRESORA='$this->TonerNegroImpresora', equipo_campo.TONER_MAGENTA_IMPRESORA='$this->TonerMagentaImpresora', equipo_campo.TONER_AMARILLO_IMPRESORA='$this->TonerAmarilloImpresora', equipo_campo.TONER_CYAN_IMPRESORA='$this->TonerCyanImpresora', equipo_campo.TAMBOR_IMAGEN_IMPRESORA='$this->TamborImagenImpresora', equipo_campo.CANTIDAD_USUARIOS=$this->CantidadUsuarios, equipo_campo.DISTANCIA_MAXIMA=$this->DistanciaMaxima where id_inventario='$this->idInventario'";
		//Actualiza el Estado del Componente
		if ($this->verificarCambioInventario()==1) {
			conectarMysql();
			$result=mysql_query($consulta);
			$affected=mysql_affected_rows();
			$result2=mysql_query($consulta2);
			$affected2=mysql_affected_rows();
			mysql_close();
		}
			if ($result && $affected>0) {
				return 0;
			} else {
				return 1;
			}		
	}
	
	function verificarCambioInventario() {
		$consulta="select * from vistainventarioequipos 
		where id_inventario like '%$this->idInventario'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			
			$conseguido=0;		 
			if ($row[7]!=$this->serial) {
				$conseguido=1;
			}
				
			if ($row[13]!=$this->idModelo) {
				$conseguido=1;
			}
				
			if ($row[17]!=$this->fru){
				$conseguido=1;
			}
			if ($row[18]!=$this->productNumber) {
				$conseguido=1;
			}
			if ($row[19]!=$this->spareNumber) {
				$conseguido=1;
			}
			if ($row[20]!=$this->ct) {
				$conseguido=1;
			}
/*
			if ($row[25]!=$this->idPedido) {
				$conseguido=1;
			}
			if (substr($row[32],0,10)!=$this->fechaInicio) {
				$conseguido=1;
			}
			if (substr($row[33],0,10)!=$this->fechaFinal) {
				$conseguido=1;
			}
				
 */				
 			//Verificar si hubo cambio: 1= hubo cambio 0= no hubo cambio
 			if ($conseguido==1) {
 				return 1;
 			} else {
 				return 0;
 			}
		}
	}

	
}
class componente extends inventario {
	private $configuracion,
	$idEquipoComponenteCampo;

	function __construct($idInventario="",$serial="",$idDescripcion="",$idMarca="",$idModelo="",$fru="",$productNumber="",$spareNumber="",$ct="",$idPedido="",
	$fechaInicio="",$fechaFinal="",$disponible=0,$idInventarioUsuario="",$ficha="9999999",$statusActual="",$fechaAsociacion="",
	$idInventarioPropiedad="",$idUss="",$idEstado="",$idInventarioUbicacion="",$idDepartamento="",$idSitio="",$especifico="",$configuracion="",$idEquipoComponenteCampo="") {
		parent::__construct($idInventario="",$serial="",$idDescripcion="",$idMarca="",$idModelo="",$fru="",$productNumber="",$spareNumber="",$ct="",$idPedido="",
		$fechaInicio="",$fechaFinal="",$disponible=0,$idInventarioUsuario="",$ficha="9999999",$statusActual="",$fechaAsociacion="",
		$idInventarioPropiedad="",$idUss="",$idEstado="",$idInventarioUbicacion="",$idDepartamento="",$idSitio="",$especifico="");	
	
		$this->configuracion=$configuracion;
		$this->idEquipoComponenteCampo=$idEquipoComponenteCampo;	
	}
	function setComponente($configuracion="") {
		$this->configuracion=$configuracion;
	
	}
	function NuevoComponente() {
		$IngresarenInventario=$this->ingresarInventario();
		$IngresarenInventarioUbicacion=$this->ingresarInventarioUbicacion();
		$IngresarInventarioPropiedad=$this->ingresarInventarioPropiedad();
		$IngresarComponenteCampo=$this->ingresarComponenteCampo();
		$total=$IngresarenInventario+$IngresarenInventarioUbicacion+$IngresarInventarioPropiedad+$IngresarEquipo;
		
		if ($total==0) {
			return 0;
		} else {
			if ($IngresarenInventario==1)
			return 2; 
			$this->deshacer();
			return 1;	
		}
	}
	function nuevoIdEquipoComponenteCampo() {
		$conUltimo="SELECT ID_EQUIPO_COMPONENTE_CAMPO FROM equipo_componente_campo ORDER BY ID_EQUIPO_COMPONENTE_CAMPO DESC limit 1";
		$cons=new consecutivo("INV",$conUltimo);
		$this->idEquipoComponenteCampo=$cons->retornar();	
	}
	function asociarNuevoComponenteEquipo($garantia=0) {

		if ($garantia!=0) {
			$this->obtenerDatosGarantiaEquipo();
		}
		$this->obtenerUbicacionEquipo();
		$this->obtenerUsuarioEquipo();
		$IngresarenInventario=$this->ingresarInventario();
		$IngresarenInventarioUbicacion=$this->ingresarInventarioUbicacion();
		if (!empty($this->ficha)) {
			$IngresarenInventarioUsuario=$this->ingresarInventarioUsuario();
		}
		$IngresarInventarioPropiedad=$this->ingresarInventarioPropiedad();
		$IngresarComponenteCampo=$this->ingresarComponenteCampo();
		
		$total=$IngresarenInventario+$IngresarenInventarioUbicacion+$IngresarInventarioPropiedad;
		if ($garantia!=0) {
			$this->ingresarComponenteGarantia();				
		}
		$this->nuevoIdEquipoComponenteCampo();
		$conIngresar="insert into equipo_componente_campo (ID_EQUIPO_COMPONENTE_CAMPO,
			CONFIGURACION,
			ID_INVENTARIO,
			ID_USS,
			ID_USS_ADMIN,
			FECHA_ASOCIACION,
			STATUS_ACTUAL)
		values ('$this->idEquipoComponenteCampo','$this->configuracion',
		'$this->idInventario','$this->idUss','$this->idUss','$this->fechaAsociacion',1)";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
		if ($result) {
			return 0;
		} else {
			$this->deshacer();
			return 1;	
		}
	}
	function ingresarComponenteGarantia() {
		$conIngresar="insert into componente_garantia (id_inventario,configuracion,fecha_asociacion,status_actual)
		values ('$this->idInventario','$this->configuracion','$this->fechaAsociacion',1)";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
	}
	function obtenerDatosGarantiaEquipo() {
		$consulta="Select
		equipo_campo.CONFIGURACION,
		equipo_campo.ID_INVENTARIO,
		inventario.ID_PEDIDO,
		inventario.FECHA_INICIO,
		inventario.FECHA_FINAL
		From
		equipo_campo
		Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
		Where
		equipo_campo.CONFIGURACION = '$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			$this->idPedido=$row[2];
			$this->fechaInicio=$row[3];
			$this->fechaFinal=$row[4];	
		}	
	}
	function obtenerUbicacionEquipo() {
		$consulta="Select
			equipo_campo.CONFIGURACION,
			equipo_campo.ID_INVENTARIO,
			inventario_ubicacion.ID_DEPARTAMENTO,
			inventario_ubicacion.ID_SITIO,
			inventario_ubicacion.ESPECIFICO
			From
			equipo_campo
			Inner Join inventario ON equipo_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join inventario_ubicacion ON inventario.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO
			Where
			equipo_campo.CONFIGURACION = '$this->configuracion'
			Order By
			inventario_ubicacion.FECHA_ASOCIACION Desc
			Limit 1";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			$this->idDepartamento=$row[2];
			$this->idSitio=$row[3];
			$this->especifico=$row[4];	
		}	
	}
	//Asociar Componente Existente al Equipo
	function asociarComponenteEquipo() {
		$consulta="select equipo_componente_campo.ID_EQUIPO_COMPONENTE_CAMPO from equipo_componente_campo where id_inventario='$this->idInventario' and configuracion='$this->configuracion' and status_actual=1";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return 0;	
		}
		$this->nuevoIdEquipoComponenteCampo();
		$this->obtenerUbicacionEquipo();
		$this->obtenerUsuarioEquipo();
		$IngresarenInventarioUbicacion=$this->ingresarInventarioUbicacion();
		if (!empty($this->ficha)) {
			$IngresarenInventarioUsuario=$this->ingresarInventarioUsuario();
		}
		$conIngresar="insert into equipo_componente_campo (ID_EQUIPO_COMPONENTE_CAMPO,
			CONFIGURACION,
			ID_INVENTARIO,
			ID_USS,
			ID_USS_ADMIN,
			FECHA_ASOCIACION,
			STATUS_ACTUAL)
		values ('$this->idEquipoComponenteCampo','$this->configuracion',
		'$this->idInventario','$this->idUss','$this->idUss','$this->fechaAsociacion',1)";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
		if ($result) {
			$this->actualizarComponenteEquipo();
			return 0;
		} else {
			$this->deshacer();
			return 1;	
		}
	}

	function obtenerUsuarioEquipo() {
		$consulta="Select
			equipo_campo.CONFIGURACION,
			equipo_campo.ID_INVENTARIO,
			inventario_usuario.FICHA
			From
			equipo_campo
			Inner Join inventario_usuario ON equipo_campo.ID_INVENTARIO = inventario_usuario.ID_INVENTARIO
			Where
			equipo_campo.CONFIGURACION = '$this->configuracion'
			Order By
			inventario_usuario.FECHA_ASOCIACION Desc
			Limit 1";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0){
			$row=mysql_fetch_array($result);
			$this->ficha=$row[2];
		}
	}
	function actualizarComponenteEquipo() {
		$conActualizar="update equipo_componente_campo set status_actual=0 where id_inventario='$this->idInventario' and ID_EQUIPO_COMPONENTE_CAMPO<>'$this->idEquipoComponenteCampo'";
		conectarMysql();
		$result=mysql_query($conActualizar);
		mysql_close();		
	}
	function ingresarComponenteCampo() {
		$conIngresar="insert into componente_campo (id_inventario,fecha_asociacion)
		values ('$this->idInventario','$this->fechaAsociacion')";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;	
		}
	}
	
	//Verifica si el componente está asociado a un Equipo Si la Respuesta es SI retorna el Equipo si no retorna 1
	function buscarEquipoAsociado() {
		$consulta="Select
			equipo_componente_campo.ID_EQUIPO_COMPONENTE_CAMPO,
			equipo_componente_campo.CONFIGURACION,
			equipo_componente_campo.ID_INVENTARIO,
			equipo_componente_campo.FECHA_ASOCIACION,
			equipo_componente_campo.STATUS_ACTUAL
			From
			equipo_componente_campo
			Where
			equipo_componente_campo.ID_INVENTARIO = '$this->idInventario' and equipo_componente_campo.STATUS_ACTUAL=1";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			return $row[1];
		} else {
			return 1;
		}
	}
	
	//Retorna el Componente con el Dato de entra ID_inventario y desvuelve la configuracion del Equipo al cual Esta Asociado
	function retornarComponenteAsociado($statusActual=1) {
		$consulta="Select
			equipo_componente_campo.ID_INVENTARIO,
			equipo_componente_campo.CONFIGURACION,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			inventario.FRU,
			inventario.PRODUCT_NUMBER,
			inventario.SPARE_NUMBER,
			inventario.CT,
			inventario.ID_PEDIDO,
			inventario.FECHA_INICIO,
			inventario.FECHA_FINAL,
			pedido.ID_PROVEEDOR,
			proveedor.PROVEEDOR
			From
			equipo_componente_campo
			Inner Join inventario ON equipo_componente_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON marca.ID_MARCA = modelo.ID_MARCA
			Inner Join pedido ON pedido.ID_PEDIDO = inventario.ID_PEDIDO
			Inner Join proveedor ON pedido.ID_PROVEEDOR = proveedor.ID_PROVEEDOR
			Where
			equipo_componente_campo.ID_INVENTARIO = '$this->idInventario' and status_actual like '%$statusActual'";
		
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;	
		}
	}
	

	function buscarComponentesGarantia() {
		/**
		 * Retorna El equipo y los componentes asociados en Garantia. Los valores de Entrada son la Configuracion del Equipo
		 * y el id_inventario del Componente ($this->configuracion,$this->idInventario).
		 */
		$consulta="select * from vistacomponentesasociadosequiposgarantia 
		where configuracion like '%$this->configuracion' and componente_id_inventario like '%$this->idInventario'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;
		} else {
			return 1;
		}
	}
	
	function retornarComponente() {
		$consulta="Select
			componente_campo.ID_INVENTARIO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			inventario.FRU,
			inventario.PRODUCT_NUMBER,
			inventario.SPARE_NUMBER,
			inventario.CT,
			inventario.ID_PEDIDO,
			inventario.FECHA_INICIO,
			inventario.FECHA_FINAL
			From
			componente_campo
			Inner Join inventario ON componente_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Where
			componente_campo.ID_INVENTARIO = '$this->idInventario'";
		
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;	
		}
	}
	
	function actualizarComponenteAsociado() {
			$resultado=$this->ingresarInventarioPropiedad();
			$resultado=$this->actualizarInformacionGarantia();
			if (($this->retornarUltimoEstado()=="EST0000005") || ($this->retornarUltimoEstado()=="EST0000004") || ($this->retornarUltimoEstado()=="EST0000006")) {
				$result=$this->desvincularComponente();
			}
	}

	function desvincularComponente() {
			switch ($this->idEstado) {
				case 'EST0000001':
					$this->cambiarUbicacionDeposito();
					break 1;
				case 'EST0000004':
					$this->cambiarUbicacionOtros();
					break 1;
				case 'EST0000005':
					$this->actualizarInformacionGarantia();
					break 1;
				case 'EST0000006':
					$this->cambiarUbicacionOtros();
					break 1;

			}
		$consulta="update equipo_componente_campo set status_actual=0 where configuracion='$this->configuracion'
		and id_inventario='$this->idInventario' and status_actual=1";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result) {
			return 0;	
		} else {
			return 1;	
		}
		
	}
	function buscarComponentes($statusActual="") {
	$consulta="select * from vistacomponentes 
	where id_inventario like '%$this->idInventario' and 
	serial like '%$this->serial'
	";
	conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;	
		}
	}
	function buscarComponentesModificar($statusActual="") {
	$consulta="SELECT *,MODELO.ID_TIPO FROM vistacomponentes  INNER JOIN modelo  ON modelo.ID_MODELO=vistacomponentes.ID_MODELO WHERE vistacomponentes.SERIAL='$this->serial'";
	
	
	conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;	
		}
	}
	
	function buscarComponentesDisponibles() {
		$consulta="Select
			componente_campo.ID_INVENTARIO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			inventario_propiedad.ID_ESTADO
			From
			componente_campo
			Inner Join inventario ON componente_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Inner Join inventario_propiedad ON inventario.ID_INVENTARIO = inventario_propiedad.ID_INVENTARIO
			Inner Join inventario_ubicacion ON inventario.ID_INVENTARIO=inventario_ubicacion.ID_INVENTARIO
			Where
			inventario_propiedad.ID_ESTADO = 'EST0000001' AND
			inventario_propiedad.STATUS_ACTUAL = '1' AND
			inventario_ubicacion.id_sitio = 'SIT0000057' AND
			inventario_ubicacion.STATUS_ACTUAL='1' AND
			descripcion.id_descripcion like '%$this->idDescripcion' AND
			marca.id_marca like '%$this->idMarca' AND
			modelo.id_modelo like '%$this->idModelo' and
			inventario.serial like '%$this->serial' AND (descripcion.id_descripcion_propiedad='DSP0000001') and componente_campo.id_inventario not in (select id_inventario from equipo_componente_campo where status_actual=1) limit 10";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;
		}
	}
	
	function buscarComponentesDisponiblesImpresoras() {
		$consulta="Select
			componente_campo.ID_INVENTARIO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			inventario_propiedad.ID_ESTADO,
			inventario_estado.ESTADO
			From
			componente_campo
			Inner Join inventario ON componente_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON descripcion.ID_DESCRIPCION = modelo.ID_DESCRIPCION
			Inner Join marca ON marca.ID_MARCA = modelo.ID_MARCA
			Inner Join inventario_propiedad ON inventario_propiedad.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join inventario_estado ON inventario_estado.ID_ESTADO = inventario_propiedad.ID_ESTADO
			Where
			inventario.SERIAL LIKE '%$this->serial' and descripcion.id_descripcion LIKE '%$this->idDescripcion' and marca.id_marca LIKE '%$this->idMarca' and modelo.id_modelo LIKE '%$this->idModelo'  
			and componente_campo.id_inventario not in (select id_inventario from equipo_componente_campo where status_actual=1) and (descripcion.id_descripcion_propiedad='DSP0000008' OR descripcion.ID_DESCRIPCION='DES0000022') limit 10";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;
		}
	}
	function retornarTipoComponente($tipoComponente) {
		$consulta="Select
			inventario.ID_INVENTARIO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD
			From
			inventario
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Where
			inventario.ID_INVENTARIO = '$this->idInventario' descripcion.ID_DESCRIPCION_PROPIEDAD='$tipoComponente'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return 0;
		} else {
			return 1;	
		}
	}
	function retornarSuministrosDisponibles($cantidad=0,$limit="") {
		switch ($cantidad) {
			case 0:
				$contar="";
				$agrupar="";
				break 1;
			case 1:
				$contar=", count(inventario.ID_INVENTARIO) as CANTIDAD ";
				$agrupar="GROUP BY modelo.ID_MODELO";
				break 1;
		}
		
		if (!empty($limit)) {
			$limite=" LIMIT $limit";	
		} else {
			$limite="";	
		}
		$consulta="Select
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
			gerencia.ID_GERENCIA,
			gerencia.GERENCIA,
			division.ID_DIVISION,
			division.DIVISION,
			departamento.ID_DEPARTAMENTO,
			departamento.DEPARTAMENTO,
			sitio.ID_SITIO,
			sitio.SITIO,
			inventario_propiedad.ID_ESTADO,
			inventario_estado.ESTADO $contar
			From
			inventario
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Inner Join inventario_ubicacion ON inventario.ID_INVENTARIO = inventario_ubicacion.ID_INVENTARIO
			Inner Join departamento ON inventario_ubicacion.ID_DEPARTAMENTO = departamento.ID_DEPARTAMENTO
			Inner Join division ON departamento.ID_DIVISION = division.ID_DIVISION
			Inner Join gerencia ON division.ID_GERENCIA = gerencia.ID_GERENCIA
			Inner Join sitio ON inventario_ubicacion.ID_SITIO = sitio.ID_SITIO
			Inner Join inventario_propiedad ON inventario.ID_INVENTARIO = inventario_propiedad.ID_INVENTARIO
			Inner Join inventario_estado ON inventario_propiedad.ID_ESTADO = inventario_estado.ID_ESTADO
			Where
			inventario_propiedad.ID_ESTADO = 'EST0000001' AND
			inventario_propiedad.STATUS_ACTUAL = '1' AND
			inventario.ID_INVENTARIO = inventario.SERIAL AND inventario.serial like '%$this->serial' and
			sitio.ID_SITIO = 'SIT0000057' AND
			inventario_ubicacion.STATUS_ACTUAL = '1' AND modelo.ID_MODELO like '%$this->idModelo' and descripcion.id_descripcion like '%$this->idDescripcion' and marca.id_marca like '%$this->idMarca' $agrupar order by inventario_estado.ESTADO asc $limite ";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;	
		}
	}
	
	function eliminarComponente() {
		$consulta="delete from inventario where id_inventario='$this->idInventario'";
		conectarMysql();
		$result=mysql_query($consulta);
		$affected=mysql_affected_rows();
		mysql_close();
		
		if ($affected>0) {
			return 0;
		} else {
			return 1;
		}
	}	
	
	function modificarComponente() {
		
		if ($this->buscarComponentesGarantia()==1) {
			$pedido="id_pedido='$this->idPedido',
			fecha_inicio='$this->fechaInicio',
			fecha_final='$this->fechaFinal',
			";
		} else {
			unset($pedido);
		}
		
		$consulta="update inventario set 
		serial='$this->serial', 
		id_modelo='$this->idModelo',
		fru='$this->fru',
		product_number='$this->productNumber',
		spare_number='$this->spareNumber',
		ct='$this->ct',
		id_pedido='$this->idPedido',
		fecha_inicio='$this->fechaInicio',
		fecha_final='$this->fechaFinal',
		fecha_asociacion='$this->fechaAsociacion',
		id_uss='$this->idUss'
		where id_inventario='$this->idInventario'";

		//Actualiza el Estado del Componente
		if ($this->verificarCambioInventario()==1) {
			conectarMysql();
			$result=mysql_query($consulta);
			$affected=mysql_affected_rows();
			mysql_close();
		}
			if ($result && $affected>0) {
				return 0;
			} else {
				return 1;
			}
	}
	
	function validarModificarComponente() {
		//Verificar si Hubo Cambio en la tabla Inventario
		if ($this->verificarCambioInventario()==1) {
			$cambioInventario=$this->modificarComponente();
		}
		//Hacer Cambio en Inventario Propiedad
			$IngresarInventarioPropiedad=$this->ingresarInventarioPropiedad();
		
	}
	
	function validarCambioPedido() {
		/**
		 * Verifica si el componente está asociado o no a un equipo en Garantía.
		 * Si es Si enviar un mensaje de que no se puede hacer el cambio directamente en el componente, sino que se debe hacer en el equipo o sino desvincular componente del equipo en garantía
		 */
		$consulta="select configuracion, from componente_garantia where id_inventario='$this->idInventario'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return 0;
		} else {
			return 1;
		}
	}
	
	function modificarEquipoGarantia($configuracion) {
		
		$consultaBuscar="select id_inventario,configuracion from componente_garantia where id_inventario='$this->idInventario'";
		
		$consultaActualizar="update componente_garantia set configuracion='$configuracion' where id_inventario='$this->idInventario'";
		conectarMysql();
		$resultadoBuscar=mysql_query($consultaBuscar);
		if ($resultadoBuscar && mysql_numrows($resultadoBuscar)>0) {
			$result=mysql_query($consultaActualizar);
			$affected=mysql_affected_rows();
			mysql_close();
		}
		else { 
			$result=$this->ingresarComponenteGarantia();
		}
				

		if ($result==0 || $affected>0) {
			$this->heredarPedido();
			return 0;
		} else {
			return 1;
		}
		
		
	}
	function desvincularComponenteEquipoGarantia($configuracion) {
		$consulta="delete from componente_garantia where id_inventario='$this->idInventario' and configuracion='$configuracion'";
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
	function heredarPedido() {
		$equipo=new equipo();
		$equipo->setEquipo($this->configuracion);
		$resultadoEquipo=$equipo->buscarEquipo();
		if ($resultadoEquipo!=1) {
			$row=mysql_fetch_array($resultadoEquipo);
			if ($this->idPedido!=$row[17])
				$this->idPedido=$row[17];
			if ($this->fechaInicio!=$row[20])
				$this->fechaInicio=$row[20];
			if ($this->fechaFinal!=$row[21])
				$this->fechaFinal=$row[21];
		}
	}

	function verificarCambioInventario() {
		$consulta="select * from vistacomponentes 
		where id_inventario like '%$this->idInventario'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			
			$conseguido=0;		 
			if ($row[1]!=$this->serial) {
				$conseguido=1;
			}
				
			if ($row[6]!=$this->idModelo) {
				$conseguido=1;
			}
				
			if ($row[10]!=$this->fru){
				$conseguido=1;
			}
			if ($row[11]!=$this->productNumber) {
				$conseguido=1;
			}
			if ($row[12]!=$this->spareNumber) {
				$conseguido=1;
			}
			if ($row[13]!=$this->ct) {
				$conseguido=1;
			}
/*
			if ($row[25]!=$this->idPedido) {
				$conseguido=1;
			}
			if (substr($row[32],0,10)!=$this->fechaInicio) {
				$conseguido=1;
			}
			if (substr($row[33],0,10)!=$this->fechaFinal) {
				$conseguido=1;
			}
				
 */				
 			//Verificar si hubo cambio: 1= hubo cambio 0= no hubo cambio
 			if ($conseguido==1) {
 				return 1;
 			} else {
 				return 0;
 			}
		}
	}
	

}

class despacho {
	private $idDespacho,
	$idDetalleDespacho,
	$fechaAsociacion,
	$idUss,
	$casoHelpDesk,
	$tipoDespacho,
	$idInventario,
	$idUssAdmin,
	$serial,
	$ficha,
	$idDepartamento,
	$idSitio,
	$especifico,
	$configuracion,
	$observacion;
	function __construct($idDespacho="",$idDetalleDespacho="",$idInventario="",$idUss="",$casoHelpDesk="",$tipoDespacho="",$idUssAdmin="",$observacion="",$serial="",$ficha="",$configuracion="") {
		$this->idDespacho=$idDespacho;
		$this->idDetalleDespacho=$idDetalleDespacho;
		$this->idInventario=$idInventario;
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$this->idUss=$idUss;
		$this->serial=strtoupper($serial);
		$this->ficha=strtoupper($ficha);
		$this->casoHelpDesk=$casoHelpDesk;
		$this->tipoDespacho=$tipoDespacho;
		$this->idUssAdmin=$idUssAdmin;
		$this->observacion=$observacion;
		$this->configuracion=$configuracion;
		
	}
	
	function setDespacho($idDespacho="",$idDetalleDespacho="",$idInventario="",$idUss="",$idUssAdmin="",$casoHelpDesk="",$observacion="",$serial="",$ficha="",$configuracion="") {
		$this->idDespacho=$idDespacho;
		$this->idDetalleDespacho=$idDetalleDespacho;
		$this->idInventario=$idInventario;
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$this->idUss=$idUss;
		$this->serial=strtoupper($serial);
		$this->ficha=strtoupper($ficha);		
		$this->casoHelpDesk=$casoHelpDesk;
		$this->tipoDespacho=$tipoDespacho;
		$this->idUssAdmin=$idUssAdmin;
		$this->observacion=$observacion;
		$this->configuracion=$configuracion;
	}
	function mostrarComponentesADespachar($idInventario) {
		$consulta="Select
			componente_campo.ID_INVENTARIO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD
			From
			componente_campo
			Inner Join inventario ON componente_campo.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON modelo.ID_MARCA = marca.ID_MARCA
			Where
			componente_campo.ID_INVENTARIO in ($idInventario)";

		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;
		}
	}
	
	function nuevoIdDespacho() {
		$conUltimo="select id_despacho from despacho order by id_despacho desc limit 1";
		$cons=new consecutivo("DSP",$conUltimo);
		$this->idDespacho=$cons->retornar();
	}	
	
	function ingresarDespacho() {
		
		if (isset($this->ficha) && !empty($this->ficha)) {
			$this->buscarUbicacionporUsuario();
		}
		
		if (isset($this->configuracion) && !empty($this->configuracion)) {
			$this->buscarUbicacionporEquipo();
		}
		
		$this->nuevoIdDespacho();
		$conIngresar="insert into despacho (id_despacho,help_desk,configuracion,ficha,id_uss,status_despacho,fecha_asociacion,observacion,id_departamento,id_sitio,especifico)
		values ('$this->idDespacho','$this->casoHelpDesk','$this->configuracion','$this->ficha','$this->idUssAdmin',0,'$this->fechaAsociacion','$this->observacion','$this->idDepartamento','$this->idSitio','$this->especifico')";

		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();

		if ($result) {
			$this->ingresarDetalleDespacho();
			return 0;	
		} else {
			return 1;	
		}
	}
	
	function buscarUbicacionporUsuario() {
		$consulta="select id_departamento,id_sitio from vistausuario where ficha='$this->ficha'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			$this->idDepartamento=$row[0];
			$this->idSitio=$row[1];
			$this->especifico="";
		}
	}
	function buscarUbicacionporEquipo() {
		$consulta="select id_departamento,id_sitio,especifico from vistainventarioequipos where configuracion='$this->configuracion'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			$this->idDepartamento=$row[0];
			$this->idSitio=$row[1];
			$this->especifico=$row[2];
		}
	}

	function nuevoIdDetalleDespacho() {
		$conUltimo="select id_detalle_despacho from detalle_despacho order by id_detalle_despacho desc limit 1";
		$cons=new consecutivo("DET",$conUltimo);
		$this->idDetalleDespacho=$cons->retornar();
	}
	function retornarIdDespacho() {
		return $this->idDespacho;	
	}	
	function ingresarDetalleDespacho() {
			
		$consulta="select id_inventario from inventario where id_inventario in ($this->idInventario)";
		conectarMysql();
		$resultInventario=mysql_query($consulta);
		mysql_close();
		if ($resultInventario && mysql_numrows($resultInventario)>0) {
			conectarMysql();
			while ($row=mysql_fetch_array($resultInventario)) {
				$this->nuevoIdDetalleDespacho();
				$conIngresar="insert into detalle_despacho (detalle_despacho.ID_DETALLE_DESPACHO,
				detalle_despacho.ID_DESPACHO,
				detalle_despacho.ID_INVENTARIO,
				detalle_despacho.FECHA_ASOCIACION,
				detalle_despacho.ID_USS,
				detalle_despacho.ID_DESPACHO_ESTADO,
				detalle_despacho.STATUS_ACTUAL) 
				values ('$this->idDetalleDespacho','$this->idDespacho','$row[0]','$this->fechaAsociacion','$this->idUss','DEE0000001',1)";
				$result=mysql_query($conIngresar);
				$this->cambiarStatus($row[0]);
			}
			mysql_close();
		}
	}
	function cambiarStatus($idInventario) {
		$consulta="update detalle_despacho set status_actual=0 where id_detalle_despacho<>'$this->idDetalleDespacho' and id_inventario='$idInventario'";
		$resultInventario=mysql_query($consulta);
	}
	function statusDespacho($idInventario) {
		$consulta="Select
			detalle_despacho.ID_DETALLE_DESPACHO,
			detalle_despacho.ID_INVENTARIO,
			detalle_despacho.ID_USS,
			usuario_sistema.NOMBRE,
			usuario_sistema.APELLIDO,
			detalle_despacho.ID_DESPACHO_ESTADO,
			despacho_estado.DESPACHO_ESTADO
			From
			detalle_despacho
			Inner Join despacho_estado ON detalle_despacho.ID_DESPACHO_ESTADO = despacho_estado.ID_DESPACHO_ESTADO
			Inner Join usuario_sistema ON detalle_despacho.ID_USS = usuario_sistema.ID_USS
			Where
			detalle_despacho.ID_DESPACHO_ESTADO = 'DEE0000001' AND
			detalle_despacho.STATUS_ACTUAL = '1' and detalle_despacho.ID_INVENTARIO='$idInventario'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		
		if ($result && mysql_numrows($result)>0) {
			return "DESPACHADO";
		} else {
			return "DISPONIBLE";	
		}
	}
	function reporteDespacho($idGerencia="",$idSitio="",$idDescripcion="",$idDespachoEstado="",$idFicha="",$fechaInicio="",$fechaFinal="") {
		
		if ((isset($fechaInicio) && !empty($fechaInicio)) || (isset($fechaFinal) && !empty($fechaFinal))) {
			$fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
			$fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
			$rangoFecha=" vistadespachocomponentes.FECHA_ASOCIACION Between '$fechaInicio' AND '$fechaFinal' AND ";
		}
		
		if ($idGerencia==100)
			$idGerencia="";
		if ($idSitio==100)
			$idSitio="";
		if ($idDescripcion==100)
			$idDescripcion="";
		if ($idDespachoEstado==100)
			$idDespachoEstado="";
		if ($this->idUss==100)
			$this->idUss="";
		if ($this->idUssAdmin==100) {
			$this->idUssAdmin="";
		}
		
		$consulta="select * from vistadespachocomponentes 
		where 
		$rangoFecha
		id_gerencia like '%$idGerencia%' 
		and id_sitio like '%$idSitio%' 
		and id_uss like '%$this->idUssAdmin%' 
		and detalle_id_uss like '%$this->idUss%' 
		and id_descripcion like '%$idDescripcion%' 
		and ficha like '%$idFicha' 
		and serial like '%$this->serial%' 
		and id_despacho_estado like '%$idDespachoEstado%'
		";

		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;	
		}
	}
	function retornarDetalleDespacho($idDetalleDespacho) {
		$consulta="Select
			despacho.ID_DESPACHO,
			detalle_despacho.ID_DETALLE_DESPACHO,
			detalle_despacho.ID_INVENTARIO,
			inventario.SERIAL,
			descripcion.ID_DESCRIPCION,
			descripcion.DESCRIPCION,
			marca.ID_MARCA,
			marca.MARCA,
			modelo.ID_MODELO,
			modelo.MODELO,
			modelo.CAP_VEL,
			modelo.UNIDAD,
			detalle_despacho.ID_DESPACHO_ESTADO,
			despacho_estado.DESPACHO_ESTADO,
			detalle_despacho.ID_USS,
			usuario_sistema.NOMBRE,
			usuario_sistema.APELLIDO,
			descripcion.ID_DESCRIPCION_PROPIEDAD
			From
			despacho
			Inner Join detalle_despacho ON despacho.ID_DESPACHO = detalle_despacho.ID_DESPACHO
			Inner Join inventario ON detalle_despacho.ID_INVENTARIO = inventario.ID_INVENTARIO
			Inner Join modelo ON inventario.ID_MODELO = modelo.ID_MODELO
			Inner Join descripcion ON modelo.ID_DESCRIPCION = descripcion.ID_DESCRIPCION
			Inner Join marca ON marca.ID_MARCA = modelo.ID_MARCA
			Inner Join despacho_estado ON detalle_despacho.ID_DESPACHO_ESTADO = despacho_estado.ID_DESPACHO_ESTADO
			Inner Join usuario_sistema ON detalle_despacho.ID_USS = usuario_sistema.ID_USS
			Where
			detalle_despacho.id_detalle_despacho='$idDetalleDespacho'";
		
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			return $result;	
		} else {
			return 1;	
		}		
	}
	
	function devuelveIdDespacho() {
		$consulta="select id_despacho from detalle_despacho where id_detalle_despacho='$this->idDetalleDespacho'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			$this->idDespacho=$row[0];
		}
	}
		
	function eliminarDespacho() {
		$this->devuelveIdDespacho();
		$consulta="delete from despacho where id_despacho='$this->idDespacho'";
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
		
	function actualizarDespacho($idDespachoEstado) {
		
		$consulta="select id_despacho from detalle_despacho where id_detalle_despacho='$this->idDetalleDespacho'";
		conectarMysql();
		$resultadoIdDespacho=mysql_query($consulta);
		mysql_close();
		
		
		if ($resultadoIdDespacho && mysql_numrows($resultadoIdDespacho)) {
			$row=mysql_fetch_array($resultadoIdDespacho);
			$this->idDespacho=$row[0];
			
			if (isset($this->ficha) && !empty($this->ficha)) {
				$consultaActualizarDespacho="update despacho set ficha='$this->ficha' where id_despacho='$this->idDespacho'";
				conectarMysql();
				$result=mysql_query($consultaActualizarDespacho);
				mysql_close();
			}
			if (isset($this->configuracion) && !empty($this->configuracion)) {
				$consultaActualizarDespacho="update despacho set configuracion='$this->configuracion' where id_despacho='$this->idDespacho'";
				conectarMysql();
				$result=mysql_query($consultaActualizarDespacho);
				mysql_close();
			}
		
			$this->nuevoIdDetalleDespacho();
			$conIngresar="insert into detalle_despacho (detalle_despacho.ID_DETALLE_DESPACHO,
			detalle_despacho.ID_DESPACHO,
			detalle_despacho.ID_INVENTARIO,
			detalle_despacho.FECHA_ASOCIACION,
			detalle_despacho.ID_USS,
			detalle_despacho.ID_DESPACHO_ESTADO,
			detalle_despacho.STATUS_ACTUAL) 
			values ('$this->idDetalleDespacho','$this->idDespacho','$this->idInventario','$this->fechaAsociacion','$this->idUss','$idDespachoEstado',1)";
			conectarMysql();
			$result=mysql_query($conIngresar);
			
			if ($result) {
				$this->cambiarStatus($this->idInventario);
				mysql_close();
				return 0;
			} else {
				return 1;
				mysql_close();
			}
		}
	}
	function verificarInventarioDespachados($idInventario,$idEstado="%") {
		$consulta="Select
			despacho.ID_DESPACHO,
			detalle_despacho.ID_DETALLE_DESPACHO,
			detalle_despacho.ID_DESPACHO,
			detalle_despacho.ID_INVENTARIO,
			detalle_despacho.ID_DESPACHO_ESTADO,
			despacho_estado.DESPACHO_ESTADO,
			detalle_despacho.STATUS_ACTUAL
			From
			despacho
			Inner Join detalle_despacho ON despacho.ID_DESPACHO = detalle_despacho.ID_DESPACHO
			Inner Join despacho_estado ON detalle_despacho.ID_DESPACHO_ESTADO = despacho_estado.ID_DESPACHO_ESTADO 
			Where id_inventario='$this->idInventario' and detalle_despacho.id_despacho_estado like '$idEstado' and detalle_despachado.status_actual=1";
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

class despachoEquipo {
	private $idDespacho,
	$idUss,
	$helpDesk,
	$statusDespacho,
	$fechaAsociacion,
	$observacion,
	$ficha,
	$idSitio,
	$idGerencia,
	$idDivision,
	$idDepartamento,
	$especifico,
	$idDetalleDespacho,
	$configuracionNueva,
	$configuracionAnterior,
	$idUssDetalle,
	$idDespachoEstado,
	$idDescripcion,
	$statusActual;
	
	function __construct($idDespacho="",$idUss="",$helpDesk="",$statusDespacho="",$fechaAsociacion="",$observacion="",$idDetalleDespacho="",$configuracionNueva="",
	$configuracionAnterior="",$idUssDetalle="",$idDespachoEstado="",$statusActual="",$idSitio="",$idDepartamento="",$especifico="",$ficha="",$idGerencia="",$idDivision="",$idDescripcion="") {
		$this->idDespacho=$idDespacho;
		$this->idUss=$idUss;
		$this->helpDesk=$helpDesk;
		$this->statusDespacho=$statusDespacho;
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$this->observacion=$observacion;
		$this->idDetalleDespacho=$idDetalleDespacho;
		$this->configuracionNueva=$configuracionNueva;
		$this->configuracionAnterior=$configuracionAnterior;
		$this->idUssDetalle=$idUssDetalle;
		$this->idDespachoEstado=$idDespachoEstado;
		$this->idGerencia=$idGerencia;
		$this->idDivision=$idDivision;
		$this->idDepartamento=$idDepartamento;
		$this->idSitio=$idSitio;
		$this->especifico=$especifico;
		$this->ficha=$ficha;
		$this->idDescripcion=$idDescripcion;
		$this->statusActual=$statusActual;
	}
	
	function setDespacho($idDespacho="",$idUss="",$helpDesk="",$statusDespacho="",$fechaAsociacion="",$observacion="",$idSitio="",$idDepartamento="",$especifico="",$ficha="",$idGerencia="",$idDivision="") {
		$this->idDespacho=$idDespacho;
		$this->idUss=$idUss;
		$this->helpDesk=$helpDesk;
		$this->statusDespacho=$statusDespacho;
		$this->fechaAsociacion=getdate();
		$this->fechaAsociacion=$this->fechaAsociacion[year]."-".$this->fechaAsociacion[mon]."-".$this->fechaAsociacion[mday]." "
		.$this->fechaAsociacion[hours].":".$this->fechaAsociacion[minutes].":".$this->fechaAsociacion[seconds];
		$this->observacion=$observacion;
		$this->idSitio=$idSitio;
		$this->idGerencia=$idGerencia;
		$this->idDivision=$idDivision;
		$this->idDepartamento=$idDepartamento;
		$this->especifico=$especifico;
		$this->ficha=$ficha;
	}
	function setDetalleDespacho($idDetalleDespacho="",$configuracionNueva="",$configuracionAnterior="",$idUssDetalle="",$idDespachoEstado="") {
		$this->idDetalleDespacho=$idDetalleDespacho;
		$this->configuracionNueva=$configuracionNueva;
		$this->configuracionAnterior=$configuracionAnterior;
		$this->idUssDetalle=$idUssDetalle;
		$this->idDespachoEstado=$idDespachoEstado;
		$this->statusActual=1;
	}
	function retornarIdDespacho() {
		return $this->idDespacho;
	}

	function nuevoIdDespacho() {
		$conUltimo="select id_despacho from despacho_equipo order by id_despacho desc limit 1";
		$cons=new consecutivo("DSP",$conUltimo);
		$this->idDespacho=$cons->retornar();
	}	
	
	function ingresarDespacho() {
		if ($this->buscarDespachoEquipos()!=1) {
			return 0;
		}
		$this->nuevoIdDespacho();
		$conIngresar="insert into despacho_equipo 
		(ID_DESPACHO,
		ID_USS,
		HELP_DESK,
		STATUS_DESPACHO,
		FECHA_ASOCIACION,
		OBSERVACION,ID_SITIO,ID_DEPARTAMENTO,ESPECIFICO,FICHA)
		values 
		('$this->idDespacho',
		'$this->idUss',
		'$this->helpDesk',
		'$this->statusDespacho',
		'$this->fechaAsociacion',
		'$this->observacion',
		'$this->idSitio',
		'$this->idDepartamento',
		'$this->especifico',
		'$this->ficha')";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
		
		if ($result) {
			$resultado=$this->ingresarDetalleDespacho();
			if ($resultado==0)
				return 0;
			else
				$this->deshacerDespacho(); 
				return 1;
		} else {
			return 1;
		}
	}
	function deshacerDespacho() {
		$conDeshacer="delete from despacho_equipo where id_despacho='$this->idDespacho'";
		conectarMysql();
		$result=mysql_query($conDeshacer);
		mysql_close();
	}
	function nuevoIdDetalleDespacho() {
		$conUltimo="select id_detalle_despacho from detalle_despacho_equipo order by id_detalle_despacho desc limit 1";
		$cons=new consecutivo("DET",$conUltimo);
		$this->idDetalleDespacho=$cons->retornar();
	}
	function buscarDespachoEquipos($fechaInicio="",$fechaFinal="",$idDescripcion="") {
		$rangoFecha="";
		if ((isset($fechaInicio) && !empty($fechaInicio)) || (isset($fechaFinal) && !empty($fechaFinal))) {
			$fechaInicio=substr($fechaInicio,6,6)."-".substr($fechaInicio,3,2)."-".substr($fechaInicio,0,2);
			$fechaFinal=substr($fechaFinal,6,6)."-".substr($fechaFinal,3,2)."-".substr($fechaFinal,0,2);
			$rangoFecha=" vistadespachoequipos.fecha_asociacion Between '$fechaInicio' AND '$fechaFinal' AND ";
		}
		if (isset($this->ficha) && !empty($this->ficha)) {
			$conFicha=" and (ficha like '%$this->ficha' or nombre_usuario like '%$this->ficha%' or apellido_usuario like '%$this->ficha%')  ";
		}			
		
		$consulta="select * 
		from 
		vistadespachoequipos 
		where $rangoFecha 
		id_despacho like '%$this->idDespacho' and 
		id_uss like '%$this->idUss' and
		id_uss_detalle like '%$this->idUssDetalle' and
		help_desk like '%$this->helpDesk' and
		configuracion_nueva like '%$this->configuracionNueva' and
		configuracion_anterior like '%$this->configuracionAnterior' and
		id_gerencia like '%$this->idGerencia' and 
		id_sitio like '%$this->idSitio' and 
		id_gerencia like '%$this->idGerencia' and 
		id_descripcion like '%$idDescripcion' and
		id_despacho_estado like '%$this->idDespachoEstado' and 
		status_despacho like '%$this->statusDespacho' and 
		configuracion_nueva like '%$this->configuracionNueva' 
		$conFicha order by configuracion_nueva";

		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();
		if ($result && mysql_numrows($result)>0) {
			$row=mysql_fetch_array($result);
			$this->idDespacho=$row[0];
			conectarMysql();
			$result=mysql_query($consulta);
			mysql_close();
			return $result;
		} else {
			return 1;
		}
	}
	
	function ingresarDetalleDespacho() {
		$this->nuevoIdDetalleDespacho();
		$conIngresar="insert into detalle_despacho_equipo (
		ID_DETALLE_DESPACHO,
		ID_DESPACHO,
		CONFIGURACION_NUEVA,
		CONFIGURACION_ANTERIOR,
		FECHA_ASOCIACION,
		ID_USS,
		ID_DESPACHO_ESTADO,
		STATUS_ACTUAL) values 
		('$this->idDetalleDespacho',
		'$this->idDespacho',
		'$this->configuracionNueva',
		'$this->configuracionAnterior',
		'$this->fechaAsociacion',
		'$this->idUssDetalle',
		'$this->idDespachoEstado',
		'$this->statusActual')";
		conectarMysql();
		$result=mysql_query($conIngresar);
		mysql_close();
		if ($result) {
			return 0;
		} else {
			return 1;
		}
	}
	
	function actualizarDespacho() {
		$conActualizar="update despacho_equipo set 
		status_despacho=2,
		ficha='$this->ficha',
		id_sitio='$this->idSitio',
		id_departamento='$this->idDepartamento',
		especifico='$this->especifico',
		help_desk='$this->helpDesk',
		observacion='$this->observacion',
		id_uss='$this->idUss'
		where id_despacho='$this->idDespacho'";
		
		conectarMysql();
		$result=mysql_query($conActualizar);
		mysql_close();
		if ($result) {
			$resultado=$this->actualizarDetalleDespacho();
			if ($resultado==0)
				return 0;
			else
				return 1;
		} else {
			return 1;
		}
		
	}
	
	function actualizarDetalleDespacho() {
		$conActualizar="update detalle_despacho_equipo  set 
		configuracion_nueva='$this->configuracionNueva',
		configuracion_anterior='$this->configuracionAnterior',
		id_uss='$this->idUssDetalle',id_despacho_estado='$this->idDespachoEstado' where id_despacho='$this->idDespacho'";
		conectarMysql();
		$result=mysql_query($conActualizar);
		mysql_close();
		
		if ($result) {
			return 0;
		} else {
			return 1;
		}
	}
	function deshacerAsignacion() {
		$consulta="delete from despacho_equipo where id_despacho='$this->idDespacho'";
		conectarMysql();
		$result=mysql_query($consulta);
		mysql_close();

		if ($result) {
				return 0;
			} else {
				return 1;
			}
	}
	
}
							
?>
