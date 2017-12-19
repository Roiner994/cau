
<html>
<head>
<title>
SISTEMA AUTOMATIZADO DE GESTION DEL CENTRO ATENCI&Oacute;N A USUARIO CVG. VENALUM
</title>
<script language="JavaScript">
	
	function ShowHide(cuerpo) {
	 a=new Array('solicitudes','asignaciones','preventivo','inventario','garantia','pendiente');
	for(i=0;i<=a.length;i++)
        {
		 itm=document.getElementById(a[i]);
		 if (cuerpo == a[i])
		 {
		  itm.style.display = "block";
		  }else{
		  itm.style.display = "none";
		  }
		}
	}
	
	function expMenu(id) {
	  var itm = null;
	  if (document.getElementById) {
		itm = document.getElementById(id);
	  } else if (document.all){
		itm = document.all[id];
	  } else if (document.layers){
		itm = document.layers[id];
	  }
	
	  if (itm) {
	  if (itm.style) {
		if (itm.style.display == "none") { itm.style.display = "block"; }
		else { itm.style.display = "none"; }
	  }
	  else { itm.visibility = "show"; }
		}// end(!itm)
	}
    //-->
</script>
<link rel="STYLESHEET" type="text/css" href="estilos.css">
</head>
<body>
<div id="contenedor">
	<div id="cabecera">
		<?php require_once("../librerias/encabezado.php"); ?>
	</div>
	<div id="menuSuperior">
		<?php require_once("../librerias/menuSuperior.php"); ?>
	</div>
		<iframe  src="secciones.php" name="frame" id="principal" marginwidth="0"   
		marginheight="0" scrolling=auto" frameborder="0"  hspace="130" vspace="0"
		ALLOWTRANSPARENCY="true">
		</iframe>
</div>
</body>
</html>
