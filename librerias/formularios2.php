<?php
//Llamadas a Librerias
//include "conexionsql.php";
//Clase para crear un campo de texto
class campoTexto {
	//atributos
	private $nombre, $tipo, $clase,	$valor,	$tam, $maxlongitud;
	
	function campoTexto($name = "", $type = "", $class = "", $value = "", $size = "", $maxlength = ""){
	
		$this->nombre=$name;
		$this->tipo=$type;
		$this->clase=$class;
		$this->valor=$value;
		$this->tam=$size;
		$this->maxlongitud=$maxlength;
    }
	function crear($name,$type,$class,$value,$size,$maxlength) {
	
		$this->nombre=$name;
		$this->tipo=$type;
		$this->clase=$class;
		$this->valor=$value;
		 $this->tam=$size;
		$this->maxlongitud=$maxlength;
	}
	function mostrar($valor) {    	
		echo "<input name=\"".$this->nombre."\"".
		"type=\"".$this->tipo."\"".
		"class=\"".$this->clase."\"".
		"value=\"".$valor."\"".
		"size=\"".$this->tam."\"".
    	"maxlength=\"".$this->maxlongitud."\">";
	}
	function mostrarBoton($valor) {    	
		echo "<input name=\"".$this->nombre."\"".
		"type=\"".$this->tipo."\"".
		"class=\"".$this->clase."\"".
		"value=\"".$this->valor."\"".
		"size=\"".$this->tam."\"".
    	"maxlength=\"".$this->maxlongitud."\">";
	}
	function retornaCampo($valor,$func) {    	
		$temp= "<input name=\"".$this->nombre."\"".
		"type=\"".$this->tipo."\"".
		"class=\"".$this->clase."\"".
		"value=\"".$valor."\"".
		"size=\"".$this->tam."\"".
    	"maxlength=\"".$this->maxlongitud."\"".
		"onchange=\"".$func."\">";
		return $temp;
	}
	
}
// Clase que genera una Selección a travez de una consulta
class campoSeleccion {
	private $nombre, $tipo,	$clase,	$valor,	$tam, $maxlongitud,	$sql, $result;
	
	function campoSeleccion($name="",$type="",$class="",$value="",$size="",$maxlength="",$consulta="") {
		
		$this->nombre=$name;
		$this->tipo=$type;
		$this->clase=$class;
		$this->valor=$value;
		$this->tam=$size;
		$this->maxlongitud=$maxlength;
		$this->sql=$consulta;
				
	}
	function crear($name,$consulta) {
		$this->nombre=$name;
		$this->sql=$consulta;
	}
	function mostrar() {
		conectarMysql();
		$this->result=mysql_query($this->sql);
		echo "<select name=\"".$this->nombre."\">";
		echo "<option selected value=\"1\"></option>";
		while ($row=mysql_fetch_array($this->result)) {
			if($row[0]==$valor) {
				echo "<option selected value=\"$row[0]\">".$row[1]."</option>";
			}
			else {
				echo "<option value=\"$row[0]\">".$row[1]."</option>";
			}
		}
		echo "</select>";
		mysql_close();
	}
	function mostrarSubmit($valor) {
		conectarMysql();
		$this->result=mysql_query($this->sql);
		echo "<select name=\"".$this->nombre."\"". " onchange=submit()>";
		echo "<option selected value=\"1\">SELECCIONE</option>";
		while ($row=mysql_fetch_array($this->result)) {
			if($row[0]==$valor) {
				echo "<option selected value=\"$row[0]\">".$row[1]."</option>";
			}
			else {
				echo "<option value=\"$row[0]\">".$row[1]."</option>";
			}
		}
		echo "</select>";
		mysql_close();
	}
	function mostraronchange($valor,$funcion) {
		conectarMysql();
		$this->result=mysql_query($this->sql);
		echo "<select name=\"".$this->nombre."\"". " onchange=$funcion>";
		echo "<option selected value=\"1\">SELECCIONE</option>";
		while ($row=mysql_fetch_array($this->result)) {
			if($row[0]==$valor) {
				echo "<option selected value=\"$row[0]\">".$row[1]."</option>";
			}
			else {
				echo "<option value=\"$row[0]\">".$row[1]."</option>";
			}
		}
		echo "</select>";
		mysql_close();
	}
	function retornaSubmit($valor,$funcion) {
		conectarMysql();
		$this->result=mysql_query($this->sql);
		$temp= "<select name=\"".$this->nombre."\"". " onchange=$funcion>";
		$temp=$temp."<option selected value=\"100\">Seleccione</option>";
		while ($row=mysql_fetch_array($this->result)) {
			if($row[0]==$valor) {
				$temp=$temp."<option selected value=\"$row[0]\">".$row[1]."</option>";
			}
			else {
				$temp=$temp."<option value=\"$row[0]\">".$row[1]."</option>";
			}
		}
		$temp=$temp."</select>";
		mysql_close();
		return $temp;
	}
	function retornarValor() {
		return $this->valor=$value;
	}
		
}
// Clase que genera una formulario a travez de una consulta
class formulario {
	private $nombre, $accion, $metodo;
	
	function formulario($name="",$action="",$method="") {
		$this->nombre=$name;
		$this->accion=$action;
		$this->metodo=$method;
	}
	function crear($name,$action,$method) {
		$this->nombre=$name;
		$this->accion=$action;
		$this->metodo=$method;
	}
	function mostrar() {
		echo "<form name=\"". $this->nombre."\"".
		"method=\"".$this->metodo."\"".
		" action=\"".$this->accion."\"".">";
	}
	function finFormulario() {
		echo "</form>";
	}
}	
?>
