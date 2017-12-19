<script language="javascript">
function setFoco() {
  document.frmAcceso.txtUsuario.focus()	
}
</script>

<html>
<head>
<title>SISTEMA DE CONTROL DE INVENTARIO DEL CENTRO ATENCIÓN A USUARIO</title>
<link rel="STYLESHEET" type="text/css" href="estilos.css">
</head>
<body onload="setFoco()">
<img src="../imagenes/encabezado.jpg" width="1000" height="80">
	<br><br><br><br><br>
	<form name="frmAcceso" method="post" action="control.php">
	<table class="formularioTabla"align=center width="200" border="0">
	<?php if ($_GET[errorUsuario]=="si")
		echo "	<tr>
			<td class=\"tituloPagina\">USUARIO INCORRECTO</td>
  		</tr>";
	?>
		<tr>
			<td class="tituloPagina">CAU - VALIDAR USUARIO</td>
  		</tr>
		<tr>
			<td class="formularioTablaTitulo">INGRESE SU NOMBRE DE USUARIO Y CLAVE</td>
  		</tr>
		<tr>
    		<td valign=top class="formularioCampoTitulo">
    		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    		USUARIO<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="txtUsuario" type="text" value=""><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			CLAVE<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="txtPassword" type="password" value=""><br></td>
		</tr>
	 	<tr>
			<td class="formularioTablaBotones" colspan="2">
			<input name="btn" type="submit" value="ACEPTAR"></td>
  		</tr>
	</table>				
	</form>
</body>
</html>