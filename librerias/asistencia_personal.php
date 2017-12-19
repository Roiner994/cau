
<link rel="stylesheet" type="text/css" href="estilopasante.css">
<form name="importa" method="post" action="importar.php" enctype="multipart/form-data">
	<table class="formularioTabla" align="center" width="500" border="0">
	<tr>
		<td class="tituloPagina" colspan="2">ASISTENCIA DE PERSONAL</td>
	</tr>
	<tr>
		<td class="formularioTablaTitulo" colspan="2">CARGUE EL ARCHIVO DE EXCEL</td>
	</tr>
	<tr>
		<td class="formularioTablaTitulo" colspan="2">
				<input type="file" name="excel" value="Seleccione un archivo" />

				<input type="submit" name="enviar"  value="Importar"  />

				<input type="hidden" value="upload" name="action" />
		</td>
	</tr>
	</table>
</form>

<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
	/*include 'buscar_personal.php';*/
	include '../paginacion/PHPPaging.lib.php';
	include 'bd_personal.php';
	include 'horas.php';
	echo $variable;
	if(isset($_SESSION['excel'])){
		$objHoja=$_SESSION['excel']; //agrego el excel a esta variable
		$trabajadores=array();
		$bandera=FALSE;
		$usuario;
		for ($i=0; $i < count($objHoja) ; $i++) { 
			if ($objHoja[$i-1]['A']=='FECHA') { // Si el anterior es igual a fecha jago verdadero la bandera
			 	$bandera=TRUE;
			 }
			 if($bandera==TRUE){
			 	$id_fecha=$objHoja[$i]['A'];
				$id_fecha=fecha($id_fecha);
				$id_fecha=strtotime($id_fecha);
				$newformat = date("Y-m-d", $id_fecha);
			 	$trabajador= array('ficha' => $ficha,'id_usuario'=>$id_usuario,'nombre' =>$nombre,'apellido'=>$apellido ,'fecha' => $newformat, 'hora' => $objHoja[$i]['B'], 'tipo' =>$objHoja[$i]['C'],'dispositivo'=> $objHoja[$i]['D'], 'estado' => $objHoja[$i]['E'],'codigo' => $codigo); //agrego los datos del empleado
			 	array_push($trabajadores,$trabajador); //agrego aun arrglo 
			 }

			 if($objHoja[$i+2]['A']=='FECHA'){
			 	$usuario=$objHoja[$i+1]['A'];
			 	$num= strcspn($usuario,'('); //buscame la ocurrencia de este caracter
			 	$num2= strcspn($usuario,')');
			 	$ficha= substr($usuario,$num+1,($num2-$num)-1);
			 	$usuario = substr($usuario,0,$num); //agarro solo el nombre y lo demas lo descarto
			 	$id_usuario=buscar_personal($ficha);
			 	$codigo=codigo($ficha);
			 	$espacios= substr_count($usuario,' ');
			 	if($espacios<3){
			 		$num= strcspn($usuario,' ');
			 		$apellido= substr($usuario,0,$num); //agarrar el apellido
			 		$nombre= substr($usuario,$num+1); //agarrar el nombre
			 		/*echo $apellido;
			 		echo $nombre;*/
			 	}else{
			 		$contador=0;
			 		for ($j=0; $j < strlen($usuario) ; $j++) { 
			 			if($usuario[$j]==' '){
			 				$contador++;
			 			}
			 			if($contador==2){
			 				$num=$j;
			 			}
			 		}
			 		$apellido= substr($usuario,0,$num);
			 		$nombre= substr($usuario,$num+1);
			 	}
			 	$bandera=FALSE;
			 }
		}

		$tabla_trabajadores=array();
		$auxiliar=array('ficha' => $trabajadores[0]['ficha'],'id_usuario'=>$trabajadores[0]['id_usuario'],'nombre' =>$trabajadores[0]['nombre'],'apellido'=>$trabajadores[0]['apellido'],'fecha' => $trabajadores[0]['fecha'], 'hora' => $trabajadores[0]['hora'], 'tipo' =>$trabajadores[0]['tipo'],'dispositivo'=> $trabajadores[0]['dispositivo'], 'estado' => $trabajadores[0]['estado'],'codigo'=>$trabajadores[0]['codigo']);
		$entrada=array();
		$salida=array();
		for ($i=0; $i < count($trabajadores) ; $i++) {
			if(($trabajadores[$i]['ficha']==$auxiliar['ficha']) && ($trabajadores[$i]['fecha']==$auxiliar['fecha'])){
					if($trabajadores[$i]['tipo']=='ENT'){
						array_push($entrada,$trabajadores[$i]);
					}else{
						array_push($salida,$trabajadores[$i]);
					}
			}else{
				$primera_entrada=$entrada[0]['hora'];
				$ultima_salida=$salida[0]['hora'];
				foreach ($entrada as $key => $objEntrada) {
					if (entrada_salida($primera_entrada,$objEntrada['hora'])==true){
						$primera_entrada=$objEntrada['hora'];
					}
				}
				$entrada=array();
				foreach ($salida as $key => $objSalida) {
					if (entrada_salida($ultima_salida,$objSalida['hora'])==false){
						$ultima_salida=$objSalida['hora'];
						}
				}
				$salida=array();
				$primera_entrada=redondearentrada($primera_entrada);
				$ultima_salida=redondearsalida($ultima_salida);
				$horas_trabajadas=(restaHoras($primera_entrada,$ultima_salida)-1);
				$empleado = array('ficha'=>$auxiliar['ficha'],'id_usuario'=>$auxiliar['id_usuario'],'nombre' =>$auxiliar['nombre'],'apellido'=>$auxiliar['apellido'],'fecha' => $auxiliar['fecha'], 'hora_entrada' => $primera_entrada, 'hora_salida' => $ultima_salida, 'horas_trabajadas' => $horas_trabajadas,'codigo' => $auxiliar['codigo'] );
				array_push($tabla_trabajadores,$empleado);
				$auxiliar=$trabajadores[$i];
				$i--;
			}
		}
		$tabla_trabajadores=multiSort($tabla_trabajadores, 'fecha', 'codigo');
		$_SESSION['tabla']=$tabla_trabajadores;
		
	}
	
?>

<?php if (isset($tabla_trabajadores)): ?>
	<?php if ($tabla_trabajadores!=NULL): ?>
		<table border="1px" class="formularioTabla" align="center" width="800">
	<tr>
		<td colspan="7" align="center"><strong>TABLA DE EXCEL</strong></td>
	</tr>
	<tr>
		<td>FECHA</td>
		<td>NOMBRE</td>
		<td>APELLIDO</td>
		<td>HORA DE ENTRADA</td>
		<td>HORA DE SALIDA</td>
		<td>HORAS TRABAJADAS</td>
		<td>codigo</td>
	</tr>
	<?php
		$pagina= new PHPPaging;
		$pagina->agregarArray($tabla_trabajadores);
		$pagina->ejecutar();
		while ($res=$pagina->fetchResultado()) { 
	?>
	<tr>
		<td><?php echo $res['fecha']; ?></td>
		<td><?php echo $res['nombre']; ?></td>
		<td><?php echo $res['apellido']; ?></td>
		<td><?php echo $res['hora_entrada']; ?></td>
		<td><?php echo $res['hora_salida']; ?></td>
		<td><?php echo $res['horas_trabajadas']; ?></td>
		<td><?php echo $res['codigo']; ?></td>
	</tr>
	<?php } ?>
	<tr><td colspan="7" align="center"><?php echo "Paginas".$pagina->fetchNavegacion(); ?></td></tr>
	<tr><td colspan="7" align="center" class="tablebtn"><a href="../librerias/importar.php">IMPORTAR A BD</a></td></tr>
</table>
	<?php endif ?>
<?php endif?>

<?php unset($_SESSION["excel"]); ?>
	




