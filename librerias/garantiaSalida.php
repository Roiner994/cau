<?php

$valores=str_replace("\\","",$valores);
//echo "ID _GARANTIA:$valores ";
?>
<?PHP
require_once "formularios.php";

switch($funcion) {
		case 1:
			formularioComponente($valores);
		break 1;
			   
		case 2:
			formularioComponente($valores);
		break 1;
		default:
			formularioComponente($valores);
	}  			
?>
<?php

function formularioComponente($Valores="") {
	require_once "formularios.php";
	require_once "administracion.php";
					
	require_once "conexionsql.php";
	require_once "garantiaAdminYosmar.php";
	//Consultas para los Campos de Selección
	$conDescripcion="SELECT distinct descripcion.ID_DESCRIPCION,DESCRIPCION FROM descripcion
					inner join inventario on inventario.id_descripcion=descripcion.id_descripcion
					WHERE ID_DESCRIPCION_PROPIEDAD<>'DSP0000004' and inventario.serial='$Serial' ";
	
	$conMarca="SELECT descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA
				WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY marca";
	
	$conModelo="SELECT ID_MODELO, concat(MODELO,' ',cap_vel,' ',unidad) as MODELO FROM modelo WHERE ID_MARCA='$_POST[selMarca]' AND ID_DESCRIPCION='$_POST[selDescripcion]' ORDER BY modelo";
    
	$conSitio="SELECT ID_SITIO,SITIO FROM sitio WHERE ID_UBICACION_PROPIEDAD='UBP0000003' ORDER BY SITIO";
	
	
	$conEstado="SELECT ID_ESTADO, ESTADO FROM inventario_estado ORDER BY ID_ESTADO";	
	//Llamadas a las clases para generar el formulario con los Campos de Texto y Selección

	$conSitio="SELECT ID_SITIO,SITIO FROM sitio ORDER BY SITIO";
	
	$conGerencia="SELECT ID_GERENCIA, GERENCIA FROM gerencia ORDER BY GERENCIA";
	
	$conDivision="SELECT ID_DIVISION, DIVISION FROM division WHERE ID_GERENCIA='$_POST[selGerencia]' ORDER BY DIVISION";
	
	$conDepartamento="SELECT ID_DEPARTAMENTO,DEPARTAMENTO FROM departamento WHERE ID_DIVISION='$_POST[selDivision]' ORDER BY DEPARTAMENTO";


	$descripcion= new campoSeleccion("selDescripcion","formularioCampoSeleccion","$_POST[selDescripcion]","onChange","cambiarSeleccion()",$conDescripcion,"--DESCRIPCION--","");
	$selDescripcion=$descripcion->retornar();
		
	$marca= new campoSeleccion("selMarca","formularioCampoSeleccion","$_POST[selMarca]","onchange","cambiarSeleccion()",$conMarca,"--MARCA--","");
	$selMarca=$marca->retornar();

	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion","$_POST[selModelo]","onchange","cambiarSeleccion()",$conModelo,"--MODELO--","");
	$selModelo=$modelo->retornar();	
	
		
	$serial= new campo("txtSerial","text","formularioCampoTexto","$_POST[txtSerial]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtSerial=$serial->retornar();

	
	$ct= new campo("txtCt","text","formularioCampoTexto","$_POST[txtCt]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtCt=$ct->retornar();

	$fru= new campo("txtFru","text","formularioCampoTexto","$_POST[txtFru]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtFru=$fru->retornar();

	$productNumber= new campo("txtProductNumber","text","formularioCampoTexto","$_POST[txtProductNumber]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtProductNumber=$productNumber->retornar();
	
	$spareNumber= new campo("txtSpareNumber","text","formularioCampoTexto","$_POST[txtSpareNumber]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtSpareNumber=$spareNumber->retornar();

	//Campo del Sitio
	$sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--SITIO--","");
	$selSitio=$sitio->retornar();
	
	//Campo de la Gerencia		
	$gerencia= new campoSeleccion("selGerencia","formularioCampoSeleccion","$_POST[selGerencia]","onChange","cambiarSeleccion()",$conGerencia,"--GERENCIA--","");
	$selGerencia=$gerencia->retornar();
	
	//Campo de la Division
	$division= new campoSeleccion("selDivision","formularioCampoSeleccion","$_POST[selDivision]","onChange","cambiarSeleccion()",$conDivision,"--DIVISION--","");
	$selDivision=$division->retornar();
	//Campo Departamento	
	$departamento= new campoSeleccion("selDepartamento","formularioCampoSeleccion","$_POST[selDepartamento]","","",$conDepartamento,"--DEPARTAMENTO--","");
	$selDepartamento=$departamento->retornar();	
	
	//Campo Estado
	$estado= new campoSeleccion("selEstado","formularioCampoSeleccion","$_POST[selEstado]","","",$conEstado,"--ESTADO--","");
	$selEstado=$estado->retornar();
	//echo "SERIAL: SERIAL: $Serial";
	if (isset($Valores) && !empty($Valores)) {
		$componenteViejo= new garantia($Valores,"","","","","","","","",$Serial);
		$resultado=$componenteViejo->equipoSalida();

		//echo"resultado $resultado";
		$_POST[txtFechaInicio]=$row[9];
		$_POST[txtFechaFinal]=$row[10];
		$_POST[selDescripcion]=$row[15];
		$_POST[txtDescripcion]=$row[7];
		$_POST[selPedido]=$row[3];
		$_POST[txtConfiguracion]=$row[12];
		$_POST[txtSerialViejo]=$row[14];
		$_POST[txtActivoFijo]=$row[13];
		$_POST[txtIdInventarioViejo]=$row[1];
		
	
	}

	
	$conMarca="SELECT descripcion_marca.ID_MARCA, MARCA FROM descripcion_marca INNER JOIN marca ON descripcion_marca.ID_MARCA=marca.ID_MARCA
				WHERE descripcion_marca.ID_DESCRIPCION ='$_POST[selDescripcion]' ORDER BY marca";
	
	$conModelo="SELECT ID_MODELO, concat(MODELO,' ',cap_vel,' ',unidad) as MODELO FROM modelo WHERE ID_MARCA='$_POST[selMarca]' AND ID_DESCRIPCION='$_POST[selDescripcion]' ORDER BY modelo";
  
	
	$marca= new campoSeleccion("selMarca","formularioCampoSeleccion","$_POST[selMarca]","onchange","cambiarSeleccion()",$conMarca,"--MARCA--","");
	$selMarca=$marca->retornar();

	$modelo= new campoSeleccion("selModelo","formularioCampoSeleccion","$_POST[selModelo]","onchange","cambiarSeleccion()",$conModelo,"--MODELO--","");
	$selModelo=$modelo->retornar();
	
	$descripcion= new campo("txtDescripcion","text","formularioCampoTexto","$_POST[txtDescripcion]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
	$txtDescripcion=$descripcion->retornar();
	//REEMPLAZO POR GARANTIA
	

//DATOS DEL COMPONENTE A SER REEMPLAZADO
				echo "<table class=\"formularioTabla\"align=center width=\"700\" border=\"0\">";
			echo "<tr>
			<td class=\"formularioTablaTitulo\" align=\"center\" colspan=\"5\">SALIDA</td>
			</tr>";	
	
	
echo "<table width=\"700\" border=\"1\" align=\"center\">
		   <tr>
		  <td valign=top class=\"tablaTitulo\"><b>RENGL&Oacute;N</b></td>
		   <td valign=top class=\"tablaTitulo\"><b>SERIAL</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>C&Oacute;DIGO</b></td>	
		  <td valign=top class=\"tablaTitulo\"><b>DESCRIPCI&Oacute;N</b></td>		  
		  <td valign=top class=\"tablaTitulo\"><b>CANTIDAD</b></td>
		 
		  
		  
		  </tr>";
if ($resultado && $resultado!=1) {
		while($row=mysql_fetch_array($resultado)) {
			 	   
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			
			
		echo "<tr class=\"$clase\">
			<td></td>		    
			<td>$row[2]</td>
			<td>-</td>
			<td>$row[7], $row[6], $row[8] </td>				
			<td>01</td>
			
							
				</tr>";
		$i++;
		$garantiaProv="'$_POST[selProveedor]','$row[2]','$_POST[txtFechaInicio]','$_POST[txtFechaFinal]'";
			
	}
}	

		echo "</table>";
		echo "<table class=\"\"align=center width=\"700\" border=\"1\">";
			
		
		echo "</table>";
	echo "</form>";
}
?>