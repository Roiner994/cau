<?php
//Generar Tablas
class tabla {
	private $consulta,
	$result,
	$columnas,
	$numCols,
	$estiloTabla,
	$titulo,
	$num,
	$orden;

	function tabla ($consulta="",$columnas="",$estiloTabla="",$titulo="") {
		$this->consulta=$consulta;
		$this->columnas=$columnas;
		$this->estiloTabla=$estiloTabla;
		$this->titulo=$titulo;
		$this->orden=$orden;
		$this->numCols=sizeof($columnas);
	}
	function retornarTabla() {
	$tmp="<table border=1 align=center class=$this->estiloTabla>
	<tr>
		<td colspan=$this->numCols>$this->titulo</td>
	</tr>
	<tr>";
	foreach ($this->columnas as $salida) {
	 $tmp=$tmp."<td>$salida</td>";
	}
	$tmp=$tmp."</tr>";
		$this->generarResult();
		if ($this->num>0) {
			while ($row=mysql_fetch_array($this->result)) {
				$tmp=$tmp."<tr>";
				for($i=0;$i<$this->numCols;$i++) {
					$tmp=$tmp."<td>$row[$i]</td>";
				}
				$tmp=$tmp."</tr>";
			}
			$tmp=$tmp."</table>";
		}
	return $tmp;
	}
	function generarResult() {
		conectarMysql();
		$this->result=mysql_query($this->consulta);
		$this->num=mysql_num_rows($this->result);
		mysql_close();
	}
}
?>