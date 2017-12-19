<script language="javascript">
function setFoco() {
  document.frmAcceso.txtUsuario.focus()	
}
</script>
    <?php 
		if(isset($_GET['errorUsuario'])){
			if ($_GET['errorUsuario']=="si")
			echo "	<tr>
				<td class=\"tituloPagina\">USUARIO INCORRECTO</td>
  			</tr>";
		}
	?>


<!DOCTYPE html>
<html lang="en">

    <head>

        <title>SISTEMA DE CONTROL DE INVENTARIO DEL CENTRO ATENCI�N A USUARIO</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="STYLESHEET" type="text/css" href="estilos.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>
    	<img class="imagenprincipal" src="img/banner05.png.gif">
        <!-- Top content -->
        <div class="top-content">
        	<?php 
        	if(isset($_GET['errorUsuario'])){
        		if ($_GET['errorUsuario']=="si")
        			echo "	<tr>
        		<td class=\"tituloPagina\">USUARIO INCORRECTO</td>
        		</tr>";
        	}
        	?>
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1> SISTEMA DE MANTENIMIENTO Y CONTROL DE INVENTARIO PARA CVG VENALUM</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Login</h3>
                            		<p>INGRESE SU USUARIO Y CLAVE</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-key"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" name="frmAcceso" method="post" action="control.php">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Usuario</label>
			                        	<input type="text" name="txtUsuario" placeholder="Usuario..." class="form-username form-control" id="form-username">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Contrase�a</label>
			                        	<input type="password" name="txtPassword" placeholder="********" class="form-password form-control" id="form-password">
			                        </div>
			                        <button type="submit" class="btn">Aceptar</button>
			                    </form>
		                    </div>
                        </div>
                    </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>
