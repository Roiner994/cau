<?php 
	$con =mysql_connect('localhost','root');
	if (!$con) {
		die('No es posible conectar con la base de datos'.mysql_error());
	}else{
		$db_selected = mysql_select_db('cau',$con);
	}

?>