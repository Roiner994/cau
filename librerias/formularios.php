<?php
//Llamadas a Librerias
require_once "conexionsql.php";
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
	$funcion,
	$checked,
	$id;
	function campo($name = "", $type = "", $class = "", $value = "", $size = "", $maxlength = "",$accion="",$funcion="",$checked="",$id=""){
	
		$this->nombre=$name;
		$this->tipo=$type;
		$this->clase=$class;
		$this->valor=$value;
		$this->tam=$size;
		$this->maxlongitud=$maxlength;
		$this->accion=$accion;
		$this->funcion=$funcion;
		$this->checked=$checked;
		$this->id=$id;
		
    }
	function retornar() {
		$temp= "<input name=\"$this->nombre\" 
		type=\"$this->tipo\" class=\"$this->clase\" 
		value=\"$this->valor\"
		size=\"$this->tam\"  
		maxlength=\"$this->maxlongitud\" 
		$this->accion=\"$this->funcion\"
		id=\"$this->id\"";		
		$temp.= $this->checked=="" ? "" : "checked=".$this->checked;
		$temp.=">";
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

function retornar_select_meses($nombre,$id,$clase,$accion="",$funcion=""){
	$rtr="<select name=\"$nombre\"  class=\"$clase\" >".
		"<option selected value=\"100\">--TODOS--</option>".
		"<option value=\"1\">ENERO</option>".
		"<option value=\"2\">FEBRERO</option>".
		"<option value=\"3\">MARZO</option>".
		"<option value=\"4\">ABRIL</option>".
		"<option value=\"5\">MAYO</option>".
		"<option value=\"6\">JUNIO</option>".
		"<option value=\"7\">JULIO</option>".
		"<option value=\"8\">AGOSTO</option>".
		"<option value=\"9\">SEPTIEMBRE</option>".
		"<option value=\"10\">OCTUBRE</option>".
		"<option value=\"11\">NOVIEMBRE</option>".
		"<option value=\"12\">DICIEMBRE</option>".
		"</select>";
	return $rtr;
	
}

function retornar_annos_preventivo($nombre,$id,$clase,$accion="",$funcion="",$flag=false){
	$query="SELECT MAX(YEAR(HORA_INICIO)) FROM mantenimiento_preventivo";
	conectarMysql();
	$rs=mysql_query($query);
	
	if($rs && mysql_num_rows($rs)>0){
		$rtr="<select name=\"$nombre\"  class=\"$clase\" >";
		$row=mysql_fetch_array($rs);
		$fechaf=$row[0]+0;		
		if(!$flag)
		$rtr.="<option selected value=\"100\">--TODOS--</option>";
		for($i=2006;$i<=$fechaf;$i++)
			$rtr.="<option ".(($flag&&($i)==$fechaf)? "selected " : "" )."value=\"$i\">$i</option>";
		$rtr.="</select>";
		return $rtr;
	}
	return -1;
}

function valor_mes($fecha){
	
				switch($fecha){
			case "1":
					return "ENERO";
					break 1;
				
			case "2":
					return "FEBRERO";
					break 1;
			case "3":
					return "MARZO";
					break 1;
			case "4":
					return "ABRIL";
					break 1;
			case "5":
					return "MAYO";
					break 1;
			case "6":
					return "JUNIO";
					break 1;
			case "7":
					return "JULIO";
					break 1;
			case "8":
					return "AGOSTO";
					break 1;
			case "9":
					return "SEPTIEMBRE";
					break 1;					
			case "10":
					return "OCTUBRE";
					break 1;
			case "11":
					return "NOVIEMBRE";
					break 1;					
			case "12":
					return "DICIEMBRE";
					break 1;					
		}
}

	
?>
