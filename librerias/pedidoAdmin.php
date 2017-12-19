<?php
//CLASE PEDIDO

class pedido {
	private $idPedido,
		$idProveedor,
		$fechaInicio,
		$fechaFinal,
		$pedidonew;
	
	function pedido ($idPedido="",$idProveedor="",$fechaInicio="",$pedidoNew="",$fechaFinal=""){
		$this->idPedido=$idPedido;
		$this->idProveedor=$idProveedor;
		$this->fechaInicio=$fechaInicio;
		$this->fechaFinal=$fechaFinal;
		$this->pedidoNew=strtoupper($pedidoNew);
		
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

	
	}
	//FUNCION INGRESAR PEDIDO
	function ingresarPedido() {
	if ($this->buscarDuplicadoPedido('id_pedido')!=0) {
			return 1;
		}
		else {
			$conUltimo="select id_pedido from pedido order by id_pedido DESC";
			$conIngresarPedido="insert into pedido(id_pedido,id_proveedor,fechai_garantia,fechaf_garantia)
			VALUES('$this->idPedido','$this->idProveedor','$this->fechaInicio','$this->fechaFinal')";
			conectarMysql();
			$result=mysql_query($conIngresarPedido);
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
	//FUNCION BUSCAR DUPLICADO DE PEDIDO
	
	private function buscarDuplicadoPedido() {
	conectarMysql();
				$conBuscarPedido= "select id_pedido from pedido where id_pedido='$this->idPedido'";
				$result=mysql_query($conBuscarPedido);
				$num=mysql_num_rows($result);
				if($num>0) {
					mysql_close();
					return 2;
				} else {
					mysql_close();
					return 0;
				}
				    
	}
	//FUNCION ELIMINAR PEDIDO

	function eliminarPedido() {
			conectarMysql();
		$conEliminar="update pedido set
			id_pedido='$this->idPedido' 
			where id_pedido='$_POST[selPedido]'";
		//echo"$conEliminar";
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
	
	
	
//FUNCION MODIFICAR PEDIDO

	function modificarPedido() {
		$conModificarPedido="update pedido set
		 id_pedido='$this->pedidoNew',
		 id_proveedor='$this->idProveedor',
		 fechai_garantia='$this->fechaInicio',
		 fechaf_garantia='$this->fechaFinal'
		 where id_pedido='$this->idPedido'";
			conectarMysql();
			$result=mysql_query($conModificarPedido);
			$affected=mysql_affected_rows();
			if ($affected>0) {
				mysql_close();
				return 0;
			} else {
				mysql_close();
				return 1;
			  }
	}
	function retornarPedido() {
		$consulta="select id_pedido,id_proveedor,fechai_garantia,fechaf_garantia from pedido where id_pedido='$this->idPedido'";
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

}	


?>