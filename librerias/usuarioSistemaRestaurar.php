

<script language="JavaScript">
     function premibottone() {
        //alert("Seguro desea eliminar al usuario: ");
	    if (confirm('Seguro que desea RESTAURAR al usuario que seleccionó?')){
	   		document.frmEliminarUsuario.submit();
		}else{ 		
			return false;
		}	
     }
 </script>

<?php
//Usuario del Sistema Eliminar

switch ($funcion) {
	case 1:
		RestaurarUsu();
		break 1;
	default:
		formularioBuscar();
}

function formularioBuscar() {
	require_once("conexionsql.php");
	require_once("usuarioSistemaAdmin.php");
	require_once("formularios.php");
	
	$conBuscar="SELECT ID_USS, CONCAT(NOMBRE,', ',APELLIDO) AS NOMBRES FROM USUARIO_SISTEMA WHERE STATUS_ACTIVO='0' ORDER BY NOMBRES";
	$usuario= new campoSeleccion("selUsuario","formularioCampoSeleccion","$_POST[selUsuario]","","",$conBuscar,"Seleccione un Usuario","","localhost","sacca","123456");
	$selUsuario=$usuario->retornar();
	
	echo "<form name=\"frmUsuarioSistema\" method=\"post\" action=\"\">";
	echo "<input name=\"funcion\" type=\"hidden\" value=\"1\">";
	echo "<table class=\"formularioTabla\"align=center width=\"350\" border=\"0\">";
		echo "<tr>";
			echo "<td class=\"tituloPagina\" colspan=\"2\">ADMINCAU - RESTAURAR USUARIO SISTEMA</td>
		</tr>";
		echo "<tr>";
			echo "<td class=\"formularioTablaTitulo\">DATOS DEL USUARIO</td>
		</tr>
		<tr>
    		<td valign=top class=\"formularioCampoTitulo\">
    		SELECCIONE UN USUARIO<br>$selUsuario</td>
		</tr>";
  	 	echo "<tr>";
	 	echo "<td class=\"formularioTablaBotones\">
	 	<input name=\"btnModificar\" type=\"submit\" value=\"RESTAURAR\"></td>
		</tr>"; 	 		
	echo "</table>";
	echo "</form>";
}

// FUNCION PARA RESTAURAR AL USUARIO 
function RestaurarUsu(){
    require_once("conexionsql.php");
	require_once("usuarioSistemaAdmin.php");
	require_once("formularios.php");
    
	conectarMysql();	
	$consql= "select id_uss from usuario_sistema where id_uss='$_POST[selUsuario]'";
	$result = mysql_query($consql);
	if($result) {
	    $row = mysql_fetch_array($result);
	    if ($row[0] == $_POST[selUsuario]){
	        //Eliminamos logicamente de la BD
	        $elim= "update usuario_sistema set status_activo='1' where id_uss='$_POST[selUsuario]'";
	        $resultado = mysql_query($elim);
	        $affected=mysql_affected_rows();
	        if ($resultado && $affected > 0){
	            //Se ha desabilitado el usuario
	            echo "<form name=\"Eliminar\" method=\"post\" action=\"\">
	            	<div style=\"padding-left:0px; padding-top:0px;\" align=\"center\" >";
				echo "<p class=\"tituloPagina\">ADMINCAU - RESTAURAR USUARIO SISTEMA</p>";
	            echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";	          
	            echo "<table class=\"mensajeTitulo\" align=center width=\"300\" border=\"0\">";
	            echo "<tr><td valign=top class=\"mensaje\" align=center>USUARIO RESTAURADO.</td></tr>";
				echo "<tr><td valign=top class=\"mensaje\" align=center><input name=\"btnAceptar\" type=\"submit\" value=\"ACEPTAR\"></td>";
				echo "</tr>";
				echo "</table>";
				echo "</div></form>";
	        }
	    }else {
	        echo "<form name=\"Eliminar\" method=\"post\" action=\"\">
	        	<div style=\"padding-left:0px; padding-top:0px;\" align=\"center\" >";
			echo "<p class=\"tituloPagina\">ADMINCAU - RESTAURAR USUARIO SISTEMA</p>";
	        echo "<input name=\"funcion\" type=\"hidden\" value=\"0\">";	
	        echo "<table class=\"mensajeTitulo\" align=center width=\"300\" border=\"0\">";
	        echo "<tr><td valign=top class=\"mensaje\" align=center>NO SE PUDO RESTAURAR AL USUARIO.</td></tr>";
			echo "<tr><td valign=top class=\"mensaje\" align=center><input name=\"btnCancelar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=45'\"></td>";
			echo "</tr>";
			echo "</table>";
			echo "</div></form>";	      
	    }
	}
	mysql_close();    
}

?>