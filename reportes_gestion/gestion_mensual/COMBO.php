<?php
require_once "formularios.php";
require_once("../conexionsql.php");
$conDescripcion="SELECT ID_DESCRIPCION, DESCRIPCION FROM descripcion ORDER BY descripcion";
	$conMarca="SELECT descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA
	WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY marca";
	$conModelo="SELECT ID_MODELO, concat(MODELO,' ',cap_vel,' ',unidad) as MODELO FROM modelo WHERE ID_MARCA='$_POST[selMarca]' AND ID_DESCRIPCION='$_POST[selDescripcion]' ORDER BY modelo";
	$conSitio="SELECT ID_SITIO,SITIO FROM sitio ORDER BY SITIO";
	$conGerencia="SELECT ID_GERENCIA, GERENCIA FROM gerencia ORDER BY GERENCIA";
$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion200","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--TODOS--","");
	$selDescripcion=$descripcion->retornar();
		
	$marca= new campoSeleccion("selMarca","formularioCampoSeleccion200","$_POST[selMarca]","onchange","cambiarSeleccion()",$conMarca,"--TODOS--","");
	$selMarca=$marca->retornar();

	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion200","$_POST[selModelo]","onchange","cambiarSeleccion()",$conModelo,"--TODOS--","");
	$selModelo=$modelo->retornar();
	//Campo del Sitio
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion200","$_POST[selSitio]","","",$conSitio,"--TODOS--","");
	$selSitio=$sitio->retornar();
	//Campo de la Gerencia		
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion200","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--TODOS--","");
	$selGerencia=$gerencia->retornar();

echo $selModelo;
echo $selGerencia;
echo $selSitio;
echo $selDescripcion;
						
	?>