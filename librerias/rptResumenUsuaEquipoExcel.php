<?php
	require_once("conexionsql.php");
	
	if ($_GET[Sitio]==100)
		$_GET[Sitio]="";
		
	if ($_GET[Gerencia]==100)
		$_GET[Gerencia]="";
				
	if ($_GET[Departamento]==100) 	
		$_GET[Departamento]="";
		
	if ($_GET[Division]==100)
		$_GET[Division]="";

	if ($_GET[idCargo]==100) 	
		$_GET[idCargo]="";	

	if (isset($_GET[ordenado]) && !empty($_GET[ordenado])) {
		$orden= " ORDER BY $_GET[ordenado] $_GET[ordentipo]";
	} else {
		$orden="";
	}
	
	//consulto en la base de datos para imprimir en la pantalla de Excel
	$consulta="SELECT gerencia,division,departamento,sitio,cargo,nombre_usuario,apellido_usuario,ficha,cedula,extension
	FROM vistausuario
	WHERE	
		vistausuario .ID_GERENCIA like '%$_GET[Gerencia]' and
		vistausuario .ID_DIVISION like '%$_GET[Division]' and
		vistausuario .ID_DEPARTAMENTO like '%$_GET[Departamento]' and
		vistausuario .ID_SITIO like '%$_GET[Sitio]' and
		vistausuario .ID_CARGO like '%$_GET[Cargo]' and
		vistausuario .NOMBRE_USUARIO like '%$_GET[Nombre]%' and
		vistausuario .APELLIDO_USUARIO like '%$_GET[Apellido]%' and
		vistausuario .FICHA like '%$_GET[Ficha]'  and
		vistausuario .CEDULA like '%$_GET[Cedula]'  and
		vistausuario .EXTENSION like '%$_GET[txtExtension]'
	$conFicha
	$orden";

	conectarMysql();
	$result = mysql_query($consulta);
	mysql_close();
	$count = mysql_num_fields($result);

	for ($i = 0; $i < $count; $i++){
    	$header .= mysql_field_name($result, $i)."\t";
	}

	while($row = mysql_fetch_row($result)){
  		$line = '';
  		foreach($row as $value){
    		if(!isset($value) || $value == ""){
      			$value = "\t";
    		}else{
				# important to escape any quotes to preserve them in the data.
      			$value = str_replace('"', '""', $value);
				# needed to encapsulate data in quotes because some data might be multi line.
				# the good news is that numbers remain numbers in Excel even though quoted.
      			$value = '"' . $value . '"' . "\t";
    		}
    		$line .= $value;
  		}
  		$data .= trim($line)."\n";
	}

	# this line is needed because returns embedded in the data have "\r"
	# and this looks like a "box character" in Excel
  	$data = str_replace("\r", "", $data);

	# Nice to let someone know that the search came up empty.
	# Otherwise only the column name headers will be output to Excel.
	if ($data == "") {
  		$data = "\nno matching records found\n";
	}

	# This line will stream the file to the user rather than spray it across the screen
	header("Content-type: application/octet-stream");

	# replace excelfile.xls with whatever you want the filename to default to
	header("Content-Disposition: attachment; filename=excelfile.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	//Imprimir en Excel
	echo $header."\n".$data;
?>