<?php
session_start();
$Acceso=array ("PRV0000001");
switch ($_SESSION[authUser]) {
	case '0':
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
		exit();
		break 1;
	case '1':
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";
		exit();
		break 1;
	default:
	require_once  "../librerias/usuarioSistemaAdmin.php";
	require_once "../librerias/conexionsql.php";
	$acceso= new usuarioSistema("",$_SESSION['userName'],$_SESSION['userPass']);
	$resultado= $acceso->validar();
	switch ($resultado) {
		case 1:
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";		
			exit();
			break 1;
		case 2:
			echo "<br><br><br><br>";
			echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			echo "<tr>";
			echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
			</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
			echo "</tr>";
			echo "</table>";	
			exit();
			break 1;
		default:
			foreach($Acceso as $valor) {
				if ($_SESSION['authUser']!=$valor) {
					$sw=1;
				} else {
					$sw=0;
					break 1;
				}
			}
			if ($sw==1) {
				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: SISTEMA - CAU</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>USTED NO EST&Aacute; REGISTRADO EN EL SISTEMA</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";	
				exit();
			}
	}
}

?>

<script language="javascript">
function ChequearTodos(chkbox){
for (var i=0;i < document. forms[0].elements.length;i++){
var elemento = document.forms[0].elements[i];
if (elemento.type == "checkbox"){
elemento.checked = chkbox.checked
}
}
}

function actualizar(){
document.frmGarantia.funcion.value=3;
document.frmGarantia.submit();	
}

function buscar(){
document.frmGarantia.funcion.value=1;
document.frmGarantia.submit();	
}

function A(ff)
{
var data, err=0, num="", inum="", errTx="Fechas no validas.",errL;
errL=errTx.length;
var f=new Array;
var g=new Array;
f[0]=ff.txtFechaInicial.value;f[1]=ff.txtFechaFinal.value;
for(var i=0;i<f.length;i++)
 {
 data=f[i];
 for(var k=0;k<=data.length;k++)
  {
  if(data.substring(k,k+1)*1 == data.substring(k,k+1))
   {
   inum+=data.substring(k,k+1);
   }
  else
   {
   num=inum+num;
   inum="";
   }
  }
 num=inum+num;
 g[i]=num;
 num="";inum="";
 }
for(i=0;i<g.length;i++)
 {
 if(g[i+1] && (g[i] > g[i+1]))
  {
  errTx+=f[i]+" mayor que "+f[i+1]+".";
  }
 }
if(errTx.length > errL)
 {alert(errTx);}
else
 {alert("Fechas Validas");}
}

function cambiarSeleccion() {
	document.frmGarantia.funcion.value=2;
	document.frmGarantia.selStatus.value="";	
	document.frmGarantia.submit();
	
}
function llamarImpresion() {
	document.frmGarantia.funcion.value=0;
	document.frmGarantia.submit(); 		
}    
</script>

<?php
//MODULO GARANTIA
require_once "administracion.php";
require_once "garantiaAdmin.php";
require_once "conexionsql.php";
require_once "formularios.php";




switch($funcion) {
	case 0:
	formularioSeleccionarProveedor();
		break 1;
	case 1:			
		require_once "administracion.php";
		if ((isset($_POST[txtFechaInicio]) && !empty($_POST[txtFechaInicio])) && (isset($_POST[txtFechaFinal]) && !empty($_POST[txtFechaFinal]))) {
			$fechaInicio= new fecha($_POST[txtFechaInicio]);
			$fechaFinal= new fecha ($_POST[txtFechaFinal]);
			$fechaI=$fechaInicio->validar();
			$fechaF=$fechaFinal->validar();
			if ($fechaI!=0 && $fechaF!=0) {
				echo "<form name=\"frmGarantia\" method=\"post\" action=\"\">";
				echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";

				echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
				

				echo "<br><br><br><br>";
				echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
				echo "<tr>";
				echo "<td align=center>MENSAJE: GARANTIA</td>
				</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center>UNO O LOS DOS CAMPOS DE FECHA SON INVALIDOS</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";	
				break 1;
			} else {
				if (compara_fechas($_POST[txtFechaFinal],$_POST[txtFechaInicio]) <0) {
					echo "<form name=\"frmGarantia\" method=\"post\" action=\"\">";
					echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";

					echo "<input name=\"txtConfiguracion\" type=\"hidden\" value=\"$_POST[selProveedor]\">";
					

					echo "<br><br><br><br>";
					echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
					echo "<tr>";
					echo "<td align=center>MENSAJE: GARANTIA</td>
					</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center>LA FECHA FINAL NO PUEDE SER MENOR QUE LA FECHA INICIAL</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";	
					break 1;
				}
			}
		}
		if (isset($_POST[selProveedor]) && $_POST[selProveedor]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>PROVEEDOR</b>";
			$i++;
			$sw=1;
		}
		if (isset($_POST[selStatus]) && $_POST[selStatus]==100) {
			if ($sw==1) {
				$mensaje=$mensaje."<b>,</b>";
			}
			$mensaje=$mensaje." <b>STATUS</b>";
			$i++;
			$sw=1;
		}
		echo "</form>";							
	case 2:
	formularioSeleccionarProveedor();
    break 1;
    case 3:       
      if(!empty($_POST['campo'])) { 
    	 $aLista=$_POST['campo'];
		 $valores="'".implode(',',$aLista)."'";
		 $valores=str_replace(',','\',\'',$valores);		 
		 $fechaReportado=getdate();
		 conectarMysql();
		 $fechaReportado=$fechaReportado[year]."-".$fechaReportado[mon]."-".$fechaReportado[mday]." ".$fechaReportado[hours].":".$fechaReportado[minutes].":".$fechaReportado[seconds];
		 $consulta1= "select garantia.ID_GARANTIA, garantia.ID_INVENTARIO, garantia.ID_ESTATUS_GARANTIA, garantia.FECHA_REPORTADO, garantia.FECHA_SALIDA, 
		              garantia.FECHA_FUERA_PLANTA from garantia
		              inner join inventario on garantia.id_inventario=inventario.id_inventario where inventario.serial IN ($valores)";			 	 
		 $result4=mysql_query($consulta1);   	
		 echo "<table class=\"formularioTabla\"align=center width=\"800\" border=\"0\">";
		      echo "<tr>
		      <td valign=top align=left class=\"formularioTablaTitulo\" colspan=\"10\">MATERIALES CON SALIDA - TOTAL: $renglon </td>			
			  </tr>";	
		      echo "<td valign=top class=\"tablaTituloIzquierda\"><b></td>
		      <td valign=top class=\"tablaTitulo\"><b>RENGLON</b></td>
		      <td valign=top class=\"tablaTitulo\"><b>SERIAL</b></td>
		      <td valign=top class=\"tablaTitulo\"><b>CÓDIGO</b></td>
		      <td valign=top class=\"tablaTitulo\"><b>DESCRIPCIÓN</b></td>
		      <td valign=top class=\"tablaTitulo\"><b>CANTIDAD</b></td>		  
		      </tr>"; 
		  $consulta3="SELECT distinct equipo_garantia.configuracion,marca.marca,modelo.modelo,inventario_equipo.serial,
                          descripcion_componente.descripcion,marca_componente.marca,modelo_componente.modelo,inventario.serial
						  from equipo_garantia inner join componente_garantia on equipo_garantia.configuracion=componente_garantia.configuracion
						  inner join inventario on componente_garantia.id_inventario=inventario.id_inventario
						  inner join inventario as inventario_equipo on equipo_garantia.id_inventario=inventario_equipo.id_inventario
						  inner join marca on inventario_equipo.id_marca=marca.id_marca
						  inner join modelo on inventario_equipo.id_modelo=modelo.id_modelo
						  inner join descripcion on inventario_equipo.id_descripcion=descripcion.id_descripcion
						  inner join descripcion as descripcion_componente on inventario.id_descripcion=descripcion_componente.id_descripcion
						  inner join marca as marca_componente on inventario.id_marca=marca_componente.id_marca
						  inner join modelo as modelo_componente on inventario.id_modelo=modelo_componente.id_modelo
						  where inventario.serial IN ($valores)";
		  $result6=mysql_query($consulta3);		 	   	 		 
		 while($row4=mysql_fetch_array($result4)){
		 	
		 	if($_POST[selStatus]=='STG0000001'){		 		 
		 	$fechaReportado=getdate();		 
		    $fechaReportado=$fechaReportado[year]."-".$fechaReportado[mon]."-".$fechaReportado[mday]." ".$fechaReportado[hours].":".$fechaReportado[minutes].":".$fechaReportado[seconds];	
		    $consulta2= "update garantia set ID_INVENTARIO='$row4[1]',ID_ESTATUS_GARANTIA='STG0000002',FECHA_REPORTADO='$row4[3]',FECHA_SALIDA='$fechaReportado' where garantia.ID_GARANTIA='$row4[0]'"; 		             
		    $result5=mysql_query($consulta2);   	     		 		 		      		      		     													         	     		 		 		      		 	
		 	} 
		 	if($_POST[selStatus]=='STG0000002'){		 		 
		 	  $fechaFueraPlanta=getdate();		 
		      $fechaFueraPlanta=$fechaFueraPlanta[year]."-".$fechaFueraPlanta[mon]."-".$fechaFueraPlanta[mday]." ".$fechaFueraPlanta[hours].":".$fechaFueraPlanta[minutes].":".$fechaFueraPlanta[seconds];	
		      $consulta2= "update garantia set ID_GARANTIA='$row4[0]',ID_INVENTARIO='$row4[1]',ID_ESTATUS_GARANTIA='STG0000003',FECHA_REPORTADO='$row4[3]',FECHA_SALIDA='$row4[4]',FECHA_FUERA_PLANTA='$fechaFueraPlanta' where garantia.ID_GARANTIA='$row4[0]'"; 
		      $result5=mysql_query($consulta2);
		 	}
		 	//if($_POST[selStatus]=='STG0000003'){
		 	   //$fechaFueraPlanta=getdate();
		       //$fechaFueraPlanta=$fechaFueraPlanta[year]."-".$fechaFueraPlanta[mon]."-".$fechaFueraPlanta[mday]." ".$fechaFueraPlanta[hours].":".$fechaFueraPlanta[minutes].":".$fechaFueraPlanta[seconds];		 		 
		       //$consulta2= "update garantia set ID_GARANTIA='$row4[0]',ID_INVENTARIO='$row4[1]',ID_ESTATUS_GARANTIA='STG0000004',FECHA_REPORTADO='$row4[3]',FECHA_SALIDA='$fechaReportado',FECHA_FUERA_PLANTA='$fechaFueraPlanta' where garantia.ID_GARANTIA='$row4[0]'"; 
		       //$result5=mysql_query($consulta2);
		 	//}    		 
		 }
		  while($row=mysql_fetch_array($result6)) {						
			       if ($i%2==0) {
				      $clase="tablaFilaPar";
			       } else {
				   $clase="tablaFilaNone";
			    }  			
			    $renglon++;
			    $cantidad=1;
			    echo "<tr align=\"left\" class=\"$clase\">			    			    			    
			    <td></td>
			    <td>$renglon</td>								
				<td>$row[7]</td>
				<td></td>
				<td>$row[4] $row[5] $row[6] $row[0] $row[1] $row[2] $row[3]</td>				
				<td>$cantidad</td>
				</tr>";			    
			$i++;
			}
			echo"</table>";		 		 
		 echo "<form name=\"frmGarantia\" method=\"post\" action=\"\"><br><br>";    	 		 
		 echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
			  echo "<tr>";
			  echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
			  echo "<td align=center>MENSAJE: GARANTIA</td></tr>";
			  echo "<tr>";
			  echo "<td valign=top class=\"mensaje\" align=center>OPERACIÓN ÉXITOSA</td>";
			  echo "</tr>";
			  echo "<tr>";
			  echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\"></td>";
			  echo "</tr>";
			  echo "</table></form>";		 	  
      }	
      else {
      	 echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\"><tr>
		       <td align=center>MENSAJE: GARANTIA</td></tr><tr>
		       <td valign=top class=\"mensaje\" align=center>DEBE SELECCIONAR POR LO MENOS UN CAMPO</td></tr><tr>
		       <td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"submit\" value=\"Aceptar\" onClick=\"history.go(-2)\"></td></tr>
		       </table>";
     }	  
     break 1;      	 
	default:
	formularioSeleccionarProveedor();
}
?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
<?php
//FUNCION MOSTRAR PROVEEDOR
function formularioSeleccionarProveedor() {
require_once "conexionsql.php";
require_once "formularios.php";

$conProveedor= "SELECT distinct proveedor.id_proveedor,proveedor.proveedor from proveedor
				inner join pedido on pedido.id_proveedor=proveedor.id_proveedor
				inner join inventario on inventario.id_pedido=pedido.id_pedido
				inner join garantia_prueba on inventario.id_inventario=garantia_prueba.id_inventario order by proveedor desc";
	//Campo Proveedor			
	$proveedor= new campoSeleccion("selProveedor","formularioCampoSeleccion","$_POST[selProveedor]","onChange","cambiarSeleccion()",$conProveedor,"--TODOS--","");
	$selProveedor=$proveedor->retornar();
	//CAMPO FECHA INICIO
	$fechaiGarantia= new campo("txtFechaInicial","text","formularioCampoTexto","$_POST[txtFechaInicial]","30","30","","");
	$txtFechaInicial=$fechaiGarantia->retornar();	
	//CAMPO FECHA FINAL
	$fechafGarantia= new campo("txtFechaFinal","text","formularioCampoTexto","$_POST[txtFechaFinal]","30","30","","");
	$txtFechaFinal=$fechafGarantia->retornar();
	//CAMPO STATUS
	if ($_POST[selProveedor]==100){		
		$_POST[selProveedor]='';
	}	
	    $conEstatusGarantia= "select distinct garantia_status.ID_ESTATUS_GARANTIA,garantia_status.ESTATUS_GARANTIA from garantia_status
							  inner join garantia_estado on garantia_status.id_estatus_garantia=garantia_estado.id_estatus_garantia
							  inner join garantia_prueba on garantia_estado.id_garantia=garantia_prueba.id_garantia
							  inner join inventario on garantia_prueba.id_inventario=inventario.id_inventario							  
							  inner join pedido on inventario.id_pedido=pedido.id_pedido
							  inner join proveedor on pedido.id_proveedor=proveedor.id_proveedor
							  where proveedor.id_proveedor like '%$_POST[selProveedor]' order by estatus_garantia desc";	   		   		    		    	
	$status= new campoSeleccion("selStatus","formularioCampoSeleccion","$_POST[selStatus]","","",$conEstatusGarantia,"--TODOS--","");
	$selStatus=$status->retornar();
	
echo "<form name=\"frmGarantia\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"\">";
	echo "<input name=\"seleccion\" type=\"hidden\" value=\"\">";
	echo "<table class=\"formularioTabla\"align=center width=\"580\" border=\"0\">";
	echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">GARANTIA</td>
  				</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">EQUIPOS Y COMPONENTES</td>
  				</tr>";
	    echo "<tr>";
			echo "<tr align=center></tr>
  				</tr>
<td valign=top class=\"formularioCampoTitulo\" >PROVEEDOR<br>$selProveedor<br>
STATUS DE GARANTIA<br>$selStatus<br>
</tr>";
//<td valign=top class=\"formularioCampoTitulo\">FECHA INICIAL<br>$txtFechaInicial<a href=\"javascript:show_calendar('frmGarantia.txtFechaInicial');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br>
//                                               FECHA FINAL<br>$txtFechaFinal<a href=\"javascript:show_calendar('frmGarantia.txtFechaFinal');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\"></a><br>
//</td>
echo "<tr></table>";
	 	echo "<table class=\"formularioTabla\"align=center width=\"300\" border=\"0\">";
			echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"BUSCAR\" onClick=\"buscar();\">
			</td>
  		</tr>";
echo "</table>";
if ($_POST[selProveedor]==100) {
			$_POST[selProveedor]="";
}
if ($_POST[selStatus]==100) {
			$_POST[selStatus]="";			
}
	$garantiaI=$_POST[selProveedor];	
	$status=$_POST[selStatus];	
		$despacho=new garantiaPrueba("",$_POST[selProveedor],"",$_POST[selStatus]);
		$resultado=$despacho->buscar();
		$total=$despacho->total();
	echo "$_POST[selProveedor]<br>$_POST[selStatus]";
	if ((isset($_POST[selProveedor]) && $_POST[selProveedor]!='') || (isset($_POST[selStatus]) && $_POST[selStatus]!='')) {
		echo "entre aqui"; 
		if ($total>0) {

			/*echo "<table class=\"formularioTabla\"align=center width=\"800\" border=\"0\">";
			echo "<tr>
			<td class=\"formularioTablaTitulo\" colspan=\"5\">EQUIPOS REPORTADOS - TOTAL: $total </td>			
			</tr>";		*/
		
echo "<table width=\"800\" border=\"0\" align=\"center\"><tr>";
	  if($_POST[selStatus]=='STG0000001'){
	  	echo "entre aqui";
	  	 echo "<table class=\"formularioTabla\"align=center width=\"800\" border=\"0\">";
		 echo "<tr>
		       <td class=\"formularioTablaTitulo\" colspan=\"10\">EQUIPOS REPORTADOS - TOTAL: $total </td>			
			   </tr>";	
		  echo "<td valign=top align=left class=\"tablaTituloIzquierda\"><b><input type=\"checkbox\" align =\"right\" name=\"campo1[]\" value=\"\" onClick=\"ChequearTodos(this);\">SERIAL</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>CONFIGURACION</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>DESCRIPCION</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>MARCA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>MODELO</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>FECHA REPORTADO</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>PROVEEDOR</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>ESTATUS</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>FECHA FINAL GARANTIA</b></td>
		  </tr>";
		while($row=mysql_fetch_array($resultado)) {
			$fecha=substr($row[13],8,2).'/'.substr($row[13],5,2).'/'.substr($row[13],0,4); 	  	   
			$fecha1=substr($row[11],8,2).'/'.substr($row[11],5,2).'/'.substr($row[11],0,4); 	  	   
			//$fecha2=substr($row[12],8,2).'/'.substr($row[12],5,2).'/'.substr($row[12],0,4); 	  	   
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}			
			echo "<tr class=\"$clase\" title=\"PROVEEDOR: $row[4] \">			    
				<td align=\"left\"><input name=\"campo[]\" type=\"checkbox\" value=\"$row[2]\">$row[2]</td>
				<td>$row[16]$row[17]</td>				
				<td>$row[6]</td>
				<td>$row[8]</td>
				<td>$row[10]</td>
				<td>$fecha1</td>
				<td>$row[4]</td>
				<td>$row[15]</td> 
				<td>$fecha</td>
				</tr>";
			$i++;
			}									
		}
	  if($_POST[selStatus]=='STG0000002'){
	  	  echo "<table class=\"formularioTabla\"align=center width=\"800\" border=\"0\">";
		  echo "<tr>
		        <td class=\"formularioTablaTitulo\" colspan=\"10\">EQUIPOS CON SALIDA - TOTAL: $total </td>			
			    </tr>";	
		  echo "<td valign=top align=left class=\"tablaTituloIzquierda\"><b><input type=\"checkbox\" align =\"right\" name=\"campo1[]\" value=\"\" onClick=\"ChequearTodos(this);\">SERIAL</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>CONFIGURACION</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>DESCRIPCION</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>MARCA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>MODELO</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>FECHA SALIDA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>PROVEEDOR</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>ESTATUS</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>FECHA FINAL GARANTIA</b></td>
		  </tr>";
		while($row=mysql_fetch_array($resultado)) {
			$fecha=substr($row[13],8,2).'/'.substr($row[13],5,2).'/'.substr($row[13],0,4); 	  	   
			$fecha1=substr($row[18],8,2).'/'.substr($row[18],5,2).'/'.substr($row[18],0,4); 	  	   
			//$fecha2=substr($row[12],8,2).'/'.substr($row[12],5,2).'/'.substr($row[12],0,4); 	  	   
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}			
			echo "<tr class=\"$clase\" title=\"PROVEEDOR: $row[4] \">			    
				<td align=\"left\"><input name=\"campo[]\" type=\"checkbox\" value=\"$row[2]\">$row[2]</td>
				<td>$row[16]$row[17]</td>				
				<td>$row[6]</td>
				<td>$row[8]</td>
				<td>$row[10]</td>
				<td>$fecha1</td>
				<td>$row[4]</td>
				<td>$row[15]</td> 
				<td>$fecha</td>
				</tr>";
			$i++;
		 }		 
	  }
		if($_POST[selStatus]=='STG0000003'){
		  echo "<table class=\"formularioTabla\"align=center width=\"800\" border=\"0\">";
		  echo "<tr>
			    <td class=\"formularioTablaTitulo\" colspan=\"10\">EQUIPOS FUERA DE PLANTA - TOTAL: $total </td>			
			    </tr>";	
		  echo "<td valign=top align=left class=\"tablaTituloIzquierda\"><b><input type=\"checkbox\" align =\"right\" name=\"campo1[]\" value=\"\" onClick=\"ChequearTodos(this);\">SERIAL</b></td>
		   <td valign=top class=\"tablaTitulo\"><b>CONFIGURACION</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>DESCRIPCION</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>MARCA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>MODELO</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>FECHA FUERA DE PLANTA</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>PROVEEDOR</b></td>
		   <td valign=top class=\"tablaTitulo\"><b>ESTATUS</b></td>
		  <td valign=top class=\"tablaTitulo\"><b>FECHA FINAL GARANTIA</b></td>
		  </tr>";		  		     
		while($row=mysql_fetch_array($resultado)) {
			$fecha=substr($row[13],8,2).'/'.substr($row[13],5,2).'/'.substr($row[13],0,4); 	  	   
			$fecha1=substr($row[19],8,2).'/'.substr($row[19],5,2).'/'.substr($row[19],0,4); 	  	   
			//$fecha2=substr($row[12],8,2).'/'.substr($row[12],5,2).'/'.substr($row[12],0,4); 	  	   
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}			
			echo "<tr class=\"$clase\" title=\"PROVEEDOR: $row[4] \">			    
				<td align=\"left\"><input name=\"campo[]\" type=\"checkbox\" value=\"$row[2]\">$row[2]</td>
				<td>$row[16]$row[17]</td>				
				<td>$row[6]</td>
				<td>$row[8]</td>
				<td>$row[10]</td>
				<td>$fecha1</td>
				<td>$row[4]</td>
				<td>$row[15]</td> 
				<td>$fecha</td>
				</tr>";
		 $i++;				
	 }
	 if(!empty($_POST['campo'])) {
     	conectarMysql(); 
    	    $aLista=$_POST['campo'];
		    $valores="'".implode(',',$aLista)."'";		    
		    $valores=str_replace(',','\',\'',$valores);
		   // echo "valores: $valores<br>";
		   //$consulta1= "select garantia.ID_GARANTIA, garantia.ID_INVENTARIO, garantia.ID_ESTATUS_GARANTIA, garantia.FECHA_REPORTADO, garantia.FECHA_SALIDA, 
		   //garantia.FECHA_FUERA_PLANTA from garantia
		   // inner join inventario on garantia.id_inventario=inventario.id_inventario where inventario.serial IN ($valores)";			 	 		   
		   $result4=mysql_query($consulta1);
		   //$_SESSION[metete]=$valores;		    
		   //echo "metete valor:$_SESSION[metete]";
		   //$_SESSION[consulta1]=$consulta1;		
		     echo "<SCRIPT LANGUAGE=\"JavaScript\">
		           window.open(\"../librerias/pdfImprimirSalidaGarantia.php?valores=$valores\")</SCRIPT>";		    
		    //echo "<a href=\"../librerias/pdfImprimirSalidaGarantia.php?valores=$valores\">";		    
     }      
		 echo "<table class=\"formularioTabla\"align=center width=\"300\" border=\"0\">";
	     echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"aceptar\"  type=\"button\" value=\"Imprimir\" onClick=\"llamarImpresion();\"><input name=\"cancelar\"  type=\"button\" value=\"Cancelar\" onClick=\"history.go(-1)\"></td>";			
	echo "</table>";		
  }
 }
}
echo "<table class=\"formularioTabla\"align=center width=\"300\" border=\"0\">";
if ($_POST[selStatus]=='STG0000001') {	
	echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"entrar\"  type=\"button\" value=\"Reportar Salida\" onClick=\"actualizar();\"></td>";
}	
if ($_POST[selStatus]=='STG0000002') {		
	echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"entrar\"  type=\"button\" value=\"Reportar Fuera de Planta\" onClick=\"actualizar();\"></td>";
}	
/*if ($_POST[selStatus]=='STG0000003') {		
	echo "<td class=\"formularioTablaBotones\" colspan=\"2\"><input name=\"entrar\"  type=\"button\" value=\"Imprimir\"><input name=\"entrar\"  type=\"button\" value=\"Cancelar\"></td>";
}*/
echo "</table>";	
echo "</form>";
}
?>
