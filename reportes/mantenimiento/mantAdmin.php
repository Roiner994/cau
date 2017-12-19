<?php
function convertirMes($fecha) {
	switch ($fecha) {
		case '01':
			return "ENERO";
		break 1;
		case '02':
			return "FEBRERO";
		break 1;
		case '03':
			return "MARZO";
		break 1;
		case '04':
			return "ABRIL";
		break 1;
		case '05':
			return "MAYO";
		break 1;
		case '06':
			return "JUNIO";
		break 1;
		case '07':
			return "JULIO";
		break 1;
		case '08':
			return "AGOSTO";
		break 1;
		case '09':
			return "SEPTIEMBRE";
		break 1;
		case '10':
			return "OCTUBRE";
		break 1;
		case '11':
			return "NOVIEMBRE";
		break 1;
		case '12':
			return "DICIEMBRE";
		break 1;
	}
}
function tituloGerencia($gerencia) {
	if (substr($gerencia,0,4)=='GCIA') {
		return " LA $gerencia";
	} else {
		return " $gerencia";
	}
}
?>