<?php
switch($funcion) {	
	case 1:	
	echo "<p>";
	// Primero revisamos que las variables que vienen de los formularios no se encuentren vacías
	if (empty($_POST['sug_nombre']))
		echo "<b>No se especifico nombre</b><br>";
	if (empty($_POST['sug_email']))
		echo "<b>No se especifico E - mail</b><br>";
	if (empty($_POST['sug_asunto']))
		echo "<b>No se especifico asunto</b><br>";
	if (empty($_POST['sug_mensaje'])){
		echo "<b>Por favor, no envie un mensaje en blanco</b><br>";		
	}
	else{echo "capture el valor:$_POST[sug_mensaje]";}	
	// Luego validamos con strchr la primera ocurrencia de la arroba y el punto, es decir, validamos
	// que sea un email lo que se escribe en el campo correspondiente
	if ((!strchr($_POST['sug_email'],"@")) || (!strchr($_POST['sug_email'],".")))
	{	
		echo "<b>No es un correo válido</b><br>";
		// Esta bandera se activa en false si no es un email válido
		$valida = false;
	}
	
	// Si todo sale bien	
	/*if ((empty($_POST['sug_nombre'])) && (empty($_POST['sug_email'])) && (empty($_POST['sug_asunto'])) && (empty($_POST['sug_mensaje'])) && (valida!= false))
	{
		// Creamos el header para el mensaje
		// Sección Para:
		$to = $_POST['sug_para'];
		// Asunto
		$subject = $_POST['sug_asunto'];
		// El content-Type y demás información para el mailer
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
		// El De: en la forma Nombre elcorreo@servidor.com, esto garantiza que
		// en el cliente de correo del receptor se vea sólo el nombre de quien envia
		// en su bandeja de entrada
		$headers .= "From: $_POST[sug_nombre]  <$_POST[sug_email]> \r\n";
		// Opcional: Resopnder a:
		$headers .= "Reply-To: " . $_POST['sug_email']; 
		// El mensaje
		$message = $_POST['sug_mensaje'];
		// Abrimos un pipe Unix para ejecutar sendmail en el servidor, el "w" es porque se abre para escritura
		$fd = popen("/usr/sbin/sendmail -t", 'w');
		// Metes las cabeceras del mensaje en el pipe
		fputs($fd, "To: $to\n");
		fputs($fd, "Subject: $subject\n");
		fputs($fd, "X-Mailer: PHP4\n");
		if ($headers) {
			fputs($fd, "$headers\n");
		}
		// Dejas un espacio en blanco
		fputs($fd, "\n");
		// Metes el mensaje en el pipe
		fputs($fd, $message);
		//Cierras el pipe y con ello se envia el mensaje
		pclose($fd);
		echo "<b>Mensaje enviado, Gracias por sus sugerencias.</b><br>";
	}*/
}		
?>

    <form name="sugerencia" action="" method="POST">
    <input name="funcion" tipe"hidden" value="1">
	Nombre: <input type="text" name="sug_nombre" size=40><br />
	Email: <input type="text" name="sug_email" size=40><br />

	Asunto: <input type="text" name="sug_asunto" size=40><br />
	Para: <select name="sug_para">
	<option value="veracruz@cg.edu.mx">Dirección</option>
	<option value="israelgl@cg.edu.mx">Webmaster del sitio</option>

    </select>
	Mensaje: 
	<textarea name="sug_mensaje" cols=40 rows=6 ><?echo $_POST[sug_mensaje]?></textarea>
	<input type="submit" value="Enviar"> <input type="reset" value="Limpiar"> 
	</form>	
