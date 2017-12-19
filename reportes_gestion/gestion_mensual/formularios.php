<?php
//Llamadas a Librerias
require_once("../conexionsql.php");
//Clase para crear un campo de texto
class campo {
	//atributos
	private $nombre,
	$tipo,
	$clase,
	$valor,
	$tam,
	$maxlongitud,
	$accion,
	$funcion;
	function campo($name = "", $type = "", $class = "", $value = "", $size = "", $maxlength = "",$accion="",$funcion=""){
	
		$this->nombre=$name;
		$this->tipo=$type;
		$this->clase=$class;
		$this->valor=$value;
		$this->tam=$size;
		$this->maxlongitud=$maxlength;
		$this->accion=$accion;
		$this->funcion=$funcion;
    }
	function retornar() {
		$temp= "<input name=\"$this->nombre\" 
		type=\"$this->tipo\" class=\"$this->clase\" 
		value=\"$this->valor\" 
		size=\"$this->tam\"  
		maxlength=\"$this->maxlongitud\" 
		$this->accion=\"$this->funcion\">";
		return $temp;
	}			
}
// Clase que genera una Selección a travez de una consulta
class campoSeleccion {
	private $name,
	$clase,
	$value,
	$accion,
	$funcion,
	$sql,
	$result,
	$size,
	$predeterminado;
	function campoSeleccion($name="",$clase="",$value="",$accion="",$funcion="",$sql="",$predeterminado="",$size="") {
		
		$this->name=$name;
		$this->clase=$clase;
		$this->value=$value;
		$this->accion=$accion;
		$this->funcion=$funcion;
		$this->sql=$sql;
		$this->predeterminado=$predeterminado;
		$this->size=$size;		
	}
	function actualizarValue($value) {
		$this->value=$value;
	}
	function retornar() {
		conectarMysql();
		$this->result=mysql_query($this->sql);
		mysql_close();
		if ($this->result) {
		$temp= "<select name=\"$this->name\"  $this->accion=\"$this->funcion\" class=\"$this->clase\" size=\"$this->size\">";
		$temp=$temp."<option selected value=\"100\">$this->predeterminado</option>";
		while ($row=mysql_fetch_array($this->result)) {
			if($row[0]==$this->value) {
				$temp=$temp."<option selected value=\"$row[0]\">".$row[1]."</option>";
			}
			else {
				$temp=$temp."<option value=\"$row[0]\">".$row[1]."</option>";
			}
		}
		$temp=$temp."</select>";
		return $temp;
		} else {
			$error="error en ".$this->name;
			return $error;
		}
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

class listaCampo {
	//atributos
	private $nombre,
	$clase,
	$valor,
	$style,	
	$accion,
	$funcion;
	function listaCampo($name = "", $wrap= "", $class = "", $style = "", $accion= "",$funcion= ""){
	
		$this->nombre=$name;
		$this->wrap=$wrap;		
		$this->clase=$class;				
		$this->estilo=$style;		
		$this->accion=$accion;
		$this->funcion=$funcion;
    }
	function retornar() {    	
		$temp= "<textarea name=\"$this->nombre\ 
		wrap=\"$this->wrap\" 
		class=\"$this->clase\" 		
		style=\"$this->estilo\" 		
		$this->accion=\"$this->funcion\"></textarea>";
		return $temp;
	}			
}	
?>
