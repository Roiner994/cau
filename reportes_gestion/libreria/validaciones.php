<?php

/************ FUNCIONES DE VALIDACIONES DE ENTRADA *************/

/*
Hecho por:  Zerberus (standby@ono.com), tomado de www.lawebdelprogramador.com
NumeroRomano: devuelve un n�mero decimal transformado a n�mero romano.
Par�metro $numero: n�mero decimal que se desea transformar a romano.
Par�metro $case: si se desea ma�uscula se utiliza "u" y para min�scula "l".
*/
function NumeroRomano ($numero,$case)
{
	$simbolos=array("I","V","X","L","C","D","M");
	$valores=array ("1","5","10","50","100","500","1000","5000");
	if ($numero<=3999) {
		while ($numero>0)
		{
			$i=0;
			while ($i<7)
			{
				while ($numero>=$valores[$i] && $numero<$valores[$i+1])
				{
					$par=$i%2;  // paridad
					if ($numero>=$valores[$i+1]-$valores[$i-$par])
					{
						$romano=$romano.$simbolos[$i-$par].$simbolos[$i+1];
						$numero=$numero-($valores[$i+1]-$valores[$i-$par]);
					}
					else
					{
						$romano=$romano.$simbolos[$i];
						$numero=$numero-$valores[$i];
					}
				}
				$i++;
			}
		}
		if ($case=="l") $romano=strtolower ($romano);
	}
	else $romano="overflow";
	return $romano;
}

/*
StatusPunto: muestra en letras el status de un punto de cuenta a partir del c�digo del status del punto definido en un 
vector asociativo del archivo de configuraci�n de esta aplicaci�n.
Par�metro $x: n�mero que representa al estado del punto de cuenta, definidos en el archivo de configuraci�n.
Par�metro $ESTADO_PTO: array de configuraci�n que contiene los estados del Punto de Cuenta.
*/
function StatusPunto($x,$ESTADO_PTO)
{
	foreach($ESTADO_PTO as $indice=>$valor){
		if ($valor==$x){
		$status=$indice;
		}
	}
	return $status;
}

/*
StatusCuenta: muestra en letras el status de una cuenta a partir del c�digo del status de la cuenta definida en un 
vector asociativo del archivo de configuraci�n de esta aplicaci�n.
Par�metro $x: n�mero que representa al estado de la cuenta, definidos en el archivo de configuraci�n.
Par�metro $ESTADO_CTA: array de configuraci�n que contiene los estados de la Cuenta.
*/
function StatusCuenta($x,$ESTADO_CTA)
{
	foreach($ESTADO_CTA as $indice=>$valor){
		if ($valor==$x){
		$status=$indice;
		}
	}
	return $status;
}

/*
Autor: Mar�a Aguilera.
ValidarLetras: valida que una cadena de caracteres est� compuesta �nicamente por letras, 
indistintamente si son may�sculas, min�sculas o acentuadas.
Par�metro $x: cadena que se desea validar.
*/
function ValidarLetras($x)
{
  $i=0;
  $v=0;
  for ($i=0;$i<=strlen($x)-1;$i++)
  {
     if ((($x[$i]>='a')and($x[$i]<='z'))or(($x[$i]>='A')and($x[$i]<='Z')) or ($x[$i] ==' ') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�'))
       $v=1;
     else
       {$v=0;
       break;}
  }
  return $v;
}

/*
Autor:Mar�a Aguilera
ValidarLetrasPuntosComasGuionesNumeros: valida que una cadena de caracteres est� compuesta
por letras, indistintamente si son may�sculas, min�sculas o acentuadas, n�meros y los caracteres: puntos, comas y guiones.
Par�metro $x: cadena que se desea validar.
*/
function ValidarLetrasPuntosComasGuionesNumeros($x)
{
  $i=0;
  $v=0;
  for ($i=0;$i<=strlen($x)-1;$i++)
  {
     if ((($x[$i]>='a')and($x[$i]<='z'))or(($x[$i]>='A')and($x[$i]<='Z')) or(($x[$i]>='0')and($x[$i]<='9')) or ($x[$i] ==' ') or ($x[$i] ==',') or ($x[$i] =='.') or ($x[$i] =='-') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�'))
       $v=1;
     else
       {$v=0;
       break;}
  }
  return $v;
}

/*
Autor: Mar�a Aguilera.
ValidarGuionesNumeros: valida que una cadena de caracteres est� compuesta n�meros y guiones.
Par�metro $x: cadena que se desea validar.
*/
function ValidarGuionesNumeros($x)
{
  $i=0;
  $v=0;
  for ($i=0;$i<=strlen($x)-1;$i++)
  {
     if ((($x[$i]>='0')and($x[$i]<='9')) or ($x[$i] =='-'))
       $v=1;
     else
       {$v=0;
       break;}
  }
  return $v;
}

/*
Autor: Mar�a Aguilera.
ValidarGuionesNumerosPuntos: valida que una cadena de caracteres est� compuesta por n�meros y guiones.
Par�metro $x: cadena que se desea validar.
*/
function ValidarGuionesNumerosPuntos($x)
{
  $i=0;
  $v=0;
  for ($i=0;$i<=strlen($x)-1;$i++)
  {
     if ((($x[$i]>='0')and($x[$i]<='9')) or ($x[$i] =='-') or ($x[$i] =='.'))
       $v=1;
     else
       {$v=0;
       break;}
  }
  return $v;
}

/*
Autor: Mar�a  Aguilera.
ValidarNumeros: valida que una cadena de caracteres est� compuesta �nicamente por n�meros
Par�metro $x: cadena que se desea validar.
*/
function ValidarNumeros($x)
{
  $i=0;
  $v=0;
  for ($i=0;$i<=strlen($x)-1;$i++)
  {
     if ((($x[$i]>='0')and($x[$i]<='9')))
       $v=1;
     else
       {$v=0;
       break;}
  }
  return $v;
}

/*
Autor: Mar�a Aguilera.
Funci�n que valida que una cadena de caracteres est� compuesta por letras, indistintamente si son may�sculas, 
min�sculas o acentuadas, n�meros y los caracteres: puntos y comas.
Par�metro $x: cadena que se desea validar.
*/
function ValidarLetrasYNumeros($x)
{
  $i=0;
  $v=0;
  for ($i=0;$i<=strlen($x)-1;$i++)
  {
     if ((($x[$i]>='a')and($x[$i]<='z'))or(($x[$i]>='A')and($x[$i]<='Z')) or(($x[$i]>='0')and($x[$i]<='9')) or ($x[$i] ==' ') or ($x[$i] =='.') or ($x[$i] ==',') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�'))
       $v=1;
     else
       {$v=0;
       break;}
  }
  return $v;
}

/*
Autor: Mar�a Aguilera.
ValidarLetrasNumerosGuionesSla: valida que una cadena de caracteres est� compuesta por letras, indistintamente 
si son may�sculas, min�sculas o acentuadas, n�meros y los caracteres: sla y guiones.
Par�metro $x: cadena que se desea validar.
*/
function ValidarLetrasNumerosGuionesSla($x)
{
  $i=0;
  $v=0;
  for ($i=0;$i<=strlen($x)-1;$i++)
  {
     if ((($x[$i]>='a')and($x[$i]<='z'))or(($x[$i]>='A')and($x[$i]<='Z')) or(($x[$i]>='0')and($x[$i]<='9')) or ($x[$i] ==' ') or ($x[$i] =='-') or ($x[$i] =='/') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�') or ($x[$i] =='�'))
       $v=1;
     else
       {$v=0;
       break;}
  }
  return $v;
}

/*
Autor: Mar�a Aguilera.
ValidarFecha: devuelve 1 si una fecha es mayor o igual que la fecha de hoy y devuelve 0 si una fecha es menor al d�a de hoy.
Par�metro $txt_fecha: fecha que se desea validar en formato dia-mes-a�o.
*/
function ValidarFecha($txt_fecha){
	if (!$txt_fecha)
		return 0;
	else{	
		$hoy=date("d-m-Y");
		$array_fecha=explode("-",$txt_fecha);
		$ao=$array_fecha[2];
		$mes=$array_fecha[1];
		$dia=$array_fecha[0];
		$array_fecha_hoy=explode("-",$hoy);
		$ao_hoy=$array_fecha_hoy[2];
		$mes_hoy=$array_fecha_hoy[1];
		$dia_hoy=$array_fecha_hoy[0];
		if ($ao>=$ao_hoy){
			if (($ao==$ao_hoy) and ($mes>=$mes_hoy)){
					if (($ao==$ao_hoy) and ($mes>$mes_hoy))
						return 1;
					if (($ao==$ao_hoy) and ($mes==$mes_hoy) and ($dia>=$dia_hoy))
						return 1;
					else
						return 0;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
}

/*
Autor: Mar�a Aguilera.
ValidaFecha: devuelve 1 si una fecha es mayor o igual que la fecha de hoy y devuelve 0 si una fecha es menor al d�a de hoy.
Par�metro $txt_fecha: fecha que se desea validar en formato dia-mes-a�o.
*/
function ValidaFecha($txt_fecha){
	if (!$txt_fecha)
		return 0;
	else{	
		$hoy=date("d-m-Y");
		$array_fecha=explode("-",$txt_fecha);
		$ao=$array_fecha[2];
		$mes=$array_fecha[1];
		$dia=$array_fecha[0];
		$array_fecha_hoy=explode("-",$hoy);
		$ao_hoy=$array_fecha_hoy[2];
		$mes_hoy=$array_fecha_hoy[1];
		$dia_hoy=$array_fecha_hoy[0];
		if ($ao>=$ao_hoy){
			if (($ao==$ao_hoy) and ($mes>=$mes_hoy)){
					if (($ao==$ao_hoy) and ($mes>$mes_hoy))
						return 1;
					if (($ao==$ao_hoy) and ($mes==$mes_hoy) and (($dia<$dia_hoy) or ($dia==$dia_hoy)))
						return 1;
					else
						return 0;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
}

/*
Autor: Diego Collas.
ShortenText: trunca un campo tipo Text, colocando al final tres puntos suspensivos '...'
Par�metro $text: cadena de texto que se desea truncar.
Par�metro $chars: n�mero de caracteres a tomar en cuenta.
*/
function ShortenText($text,$chars) {        
	if(strlen($text)>$chars)
		$ptos = true;
	$text = $text." ";
	$text = substr($text,0,$chars);
	$text = substr($text,0,strrpos($text,' '));
	if($ptos)
		$text = $text."...";
	return $text;
}

/*
Autor:Diego Collas.
Existe: determina si un elemento existe en una tabla.
Par�metro $con: identificador de la conexi�n al servidor.
Par�metro $tabla: nombre de la tabla a consultar.
Par�metro $campo: nombre del campo a consultar en la tabla.
Par�metro $elem: elemento a buscar en la tabla.
*/
function Existe($con,$tabla,$campo,$elem){
	$sql = "select count(*) from ".$tabla." where ".$campo." = '".$elem."'";
	$query = mysql_query($sql,$con);
	$row = @mysql_fetch_array($query);
	if($row[0] > 0)
		return 1;
	return 0;
}

/*
Autor: Diego Collas.
PuntosPlanificados: determina si una cuenta tiene todos sus puntos planificados.
Par�metro $con: identificador de la conexi�n al servidor.
Par�metro $idnumerocuenta: id del n�mero de cuenta de la cual se desea saber si tiene puntos de cuenta asignados.
*/
function PuntosPlanificados($con,$idnumerocuenta){
	$sql = "select * from jd_punto_cuenta where Id_Numero_Cuenta = ".$idnumerocuenta." and Hora_Inicio_Punto = '00:00' and Hora_Fin_Punto = '00:00'";
	$query = mysql_query($sql,$con);
	if (mysql_fetch_array($query))
		return 0;
	return 1;
}

/*
Autor:
FechaCompleta: devuelve una fecha en el formato usado en la emisi�n impresa de la agenda.
Par�metro $date: fecha que se desea transformar.
*/
function FechaCompleta($date){
	$texto = "";
	$dia = date('d', strtotime($date));
	$mes = date('m', strtotime($date));
	$anio = date('Y', strtotime($date));
	switch ($mes){
		case '01': $texto.= $dia.' de Enero del '.$anio; break;
		case '02': $texto.= $dia.' de Febrero del '.$anio; break;
		case '03': $texto.= $dia.' de Marzo del '.$anio; break;
		case '04': $texto.= $dia.' de Abril del '.$anio; break;
		case '05': $texto.= $dia.' de Mayo del '.$anio; break;
		case '06': $texto.= $dia.' de Junio del '.$anio; break;
		case '07': $texto.= $dia.' de Julio del '.$anio; break;
		case '08': $texto.= $dia.' de Agosto del '.$anio; break;
		case '09': $texto.= $dia.' de Septiembre del '.$anio; break;
		case '10': $texto.= $dia.' de Octubre del '.$anio; break;
		case '11': $texto.= $dia.' de Noviembre del '.$anio; break;
		case '12': $texto.= $dia.' de Diciembre del '.$anio; break;
	}
	return $texto;
}

/*
Autor: 
HoraCompleta: devuelve una hora en el formato usado en la emisi�n impresa de la agenda.
Par�metro $date: fecha que se desea transformar.
*/
function HoraCompleta($date){
	if($date)
		return date("h:i a",strtotime($date));
	return "";
}

/*
Autor: Diego Collas.
CalcularOrden: calcula el orden de los puntos pertenecientes a una cuenta, y actualiza el horario general de la ultima.
Par�metro $con: identificador de la conexi�n al servidor.
Par�metro $idnumerocuenta: id del n�mero de cuenta de la cual se desean ordenar los puntos de cuenta.
*/
function CalcularOrden($con,$idnumerocuenta){
	$fecha=date("Y-m-d");
	$sql = "select pc.Id_Punto_Cuenta, pc.N_Decimal from $NOMBRE_BD_JD.jd_punto_cuenta pc where pc.Id_Numero_Cuenta = ".$idnumerocuenta." order by Hora_Inicio_Punto";
	$query = mysql_query($sql,$con);
	$i = 0;
	//Establece el nuevo orden en los puntos
	while($row = @mysql_fetch_array($query))
	{
		++$i;
		$sql = "update $NOMBRE_BD_JD.jd_punto_cuenta set N_Decimal = ".$i." where Id_Punto_Cuenta = ".$row['Id_Punto_Cuenta'];
		@mysql_query($sql,$con);
	}
	//Actualiza las horas de la cuenta
	$sql = "select min(Hora_Inicio_Punto) as Hora_Inicio, max(Hora_Fin_Punto) as Hora_Fin from $NOMBRE_BD_JD.jd_punto_cuenta pc where pc.Hora_Inicio_Punto <> '00:00' and pc.Hora_Inicio_Punto <> '00:00' and pc.Id_Numero_Cuenta = ".$idnumerocuenta;
	$query = @mysql_query($sql,$con);
	$row = @mysql_fetch_array($query);
	$sql = "update $NOMBRE_BD_JD.jd_cuenta set Hora_Inicio = '".$row['Hora_Inicio']."', Hora_Fin = '".$row['Hora_Fin']."' where Id_Numero_Cuenta = ".$idnumerocuenta;
	@mysql_query($sql,$con);
}

/*
Autor: Diego Collas.
ParticipantesCuenta: asocia todos los participantes externos a las dietas de una cuenta.
Par�metro $con: identificador de la conexi�n al servidor.
Par�metro $idnumerocuenta: id del n�mero de cuenta de la cual se desean asociar los directores de la Junta.
*/
function ParticipantesCuenta($con,$cuenta){
	$comisario = 3;
	$sql = "select Id_Participante from juntadirectiva.jd_participante p where p.Id_Empresa <> '0' and p.Activo = 1 and p.Id_Rol <> ".$comisario;
	$query = mysql_query($sql,$con);
	while($row = mysql_fetch_array($query)){
		$sql = "insert into juntadirectiva.jd_dieta (Id_Participante, Id_Numero_Cuenta) values ($row[0],$cuenta)";
		mysql_query($sql,$con);
	}
}

/*
Autor: Diego Collas.
CalcularMontoTotal: calcula el monto total de la cuenta segun las dietas canceladas.
Par�metro $con: identificador de la conexi�n al servidor.
Par�metro $idnumerocuenta: id del n�mero de cuenta de la cual se desea calcular el monto total cancelado por concepto de dietas.
*/
function CalculoMontoTotal($con,$cuenta){
	$sql = "select * from juntadirectiva.jd_dieta d where d.Id_Numero_Cuenta = $cuenta and d.N_Deposito <> 0";
	$query = mysql_query($sql,$con);
	$numdietas = @mysql_num_rows($query);
	$sql = "select Monto_Por_Participante from juntadirectiva.jd_cuenta where Id_Numero_Cuenta = $cuenta";
	$query = mysql_query($sql,$con);
	$row = @mysql_fetch_array($query);
	$monto = $row['Monto_Por_Participante'];
	$montototal = $numdietas * $monto;
	$sql = "update juntadirectiva.jd_cuenta set Monto_Total_Cuenta = $montototal where Id_Numero_Cuenta = $cuenta";
	mysql_query($sql,$con);
}

/*
Autor: Mar�a Aguilera.
CrearReplicaPuntoCuenta: crea una r�plica de un punto de cuenta (Hijo) y lo conecta a su predecesor (Padre).
Par�metro $con: identificador de la conexi�n al servidor.
Par�metro $id_punto: id del punto de cuenta que se desea copiar.
Par�metro $usuario: usuario que realiza la r�plica del punto de cuenta.
*/ 
function CrearReplicaPuntoCuenta($con,$id_punto,$usuario){
	$sql="SELECT * FROM juntadirectiva.jd_punto_cuenta WHERE Id_Punto_Cuenta=".$id_punto;
	$resultado=mysql_query($sql);
	while($row=mysql_fetch_array($resultado)){
		$titulo=$row["Titulo"];
		$objetivo=$row["Objetivo"];
		$id_unidad_solicitante=$row["Id_Unidad_Solicitante"];
		$n_contrato=$row["N_Contrato"];
		$contratista=$row["Contratista"];
		$tipo=$row["Tipo"];
		$presentador=$row["Presentador"];
	}
	$fecha=date("Y-m-d");
	$consulta="INSERT INTO juntadirectiva.jd_punto_cuenta (Cod_Punto_Pred,Titulo,Objetivo,Id_Unidad_Solicitante,N_Contrato,Contratista,Tipo,Presentador,Fecha_Ingreso_Datos,Usuario)  VALUES ('$id_punto','$titulo','$objetivo','$id_unidad_solicitante','$n_contrato','$contratista','$tipo','$presentador','$fecha','$usuario')"; 
	mysql_query($consulta);
}

/*
Autor: Mar�a Aguilera.
BuscarPuntoAsociado: busca un punto de cuenta (Hijo) que est� asociado a un punto de cuenta (Padre o Predecesor). Si encuentra el punto (Hijo) y �ste 
no est� asociado a ninguna cuenta, se elimina y la fuci�n devuelve un 1; en caso contrario, devuelve 0.
Par�metro $con: identificador de la conexi�n al servidor.
Par�metro $id_punto: id del punto de cuenta del que se desea saber si tiene alg�n punto asociado.
*/
function BuscarPuntoAsociado($con,$id_punto){
	$sql="SELECT Id_Punto_Cuenta, Id_Numero_Cuenta FROM jd_punto_cuenta where Cod_Punto_Pred=".$id_punto;
	$resultado=mysql_query($sql);
	$numero_puntos=mysql_num_rows($resultado);
	if ($numero_puntos >0){
		while ($row=mysql_fetch_array($resultado)){
			$id_punto_cuenta=$row["Id_Punto_Cuenta"];
			$numero_cuenta=$row["Id_Numero_Cuenta"];
		}
			if (!$numero_cuenta){
				EliminarPunto($con,$id_punto_cuenta);
				return 1;
			}else{
				return 0;
			}
	}else{
		return 1;
	}
}

/*
Autor: Mar�a Aguilera.
EliminarPunto: elimina un punto de cuenta.
Par�metro $con: identificador de conexi�n al servidor.
Par�metro $id_punto: id del punto de cuenta que se desea eliminar.
*/
function EliminarPunto($con,$id_punto){
	$sql="DELETE FROM juntadirectiva.jd_punto_cuenta WHERE Id_Punto_Cuenta=".$id_punto;
	mysql_query($sql);
}

/*
Autor: Diego Collas.
ObtenerCorreos: retorna todos los correos pertenecientes a un participante.
Par�metro $con: identificador de la conexi�n  al servidor.
Par�metro $idparticipante: id del participante.
*/
function ObtenerCorreos($con,$idparticipante){
	$sql = "select Correo_E from jd_correo_participante where Id_Participante = ".$idparticipante;
	$query = mysql_query($sql,$con);
	if(mysql_num_rows($query)>0)
		while ($row=mysql_fetch_array($query)){
			$mails.= $row["Correo_E"]." ";
		}
	else
		return "";
	return $mails;
}

/* Funci�n que registra en la base de datos los logs de envios de notificaciones por la aplicaci�n*/
function RegistroLogCorreo($con,$idtiponotificacion,$comentario,$status,$participantes,$idnumerocuenta){
	$sql = "insert into jd_notificacion (Id_Tipo_Notificacion, Fecha_Envio, Comentario, Status) values ('".$idtiponotificacion."','".date("Y-m-j H:i:s")."','".$comentario."','".$status."')";
	mysql_query($sql,$con);
	$sql = "select max(Id_Notificacion) as Id_Notificacion from jd_notificacion";
	$query = mysql_query($sql,$con);
	$row = mysql_fetch_array($query);
	$idnotificacion = $row["Id_Notificacion"];
	$sql = "insert into jd_notificacion_cuenta (Id_Notificacion, Id_Numero_Cuenta) values ('".$idnotificacion."','".$idnumerocuenta."')";
	mysql_query($sql,$con);
	$sql = "select max(Id_Notificacion_Cuenta) as Id_Notificacion_Cuenta from jd_notificacion_cuenta";
	$query = mysql_query($sql,$con);
	$row = mysql_fetch_array($query);
	$idnotificacioncuenta = $row["Id_Notificacion_Cuenta"];
	$i = 0;
	while($participantes[$i]){
		$sql = "insert into jd_notificacion_cuenta_participante (Id_Notificacion_Cuenta, Id_Participante) values ('".$idnotificacioncuenta."','".$participantes[$i]."')";
		$query = mysql_query($sql,$con);
		++$i;
	}
}

/*
Autor: Mar�a Aguilera.
EliminarCuenta: elimina una cuenta.
Par�metro $con: identificador de la conexi�n al servidor.
Par�metro $idnumerocuenta: id de la Cuenta a eliminar.
*/	  
function EliminarCuenta($con,$idnumerocuenta){
	$sql="delete from juntadirectiva.jd_cuenta where Id_Numero_Cuenta=".$idnumerocuenta;
	mysql_query($sql);
}
		
/*
Autor: Mar�a Aguilera.
MostrarBanco: muestra el nombre del banco a partir del id del banco.
Par�metro $con: identificador de la conexi�n al servidor.
Par�metro $idbanco: id del banco.
*/
function MostrarBanco($con,$idbanco){
	$sql="select Nombre_Banco from juntadirectiva.jd_banco where Id_Banco='$idbanco'";
	$resultado=mysql_query($sql);
	while ($row=mysql_fetch_array($resultado)){
		$Nombre_Banco=$row["Nombre_Banco"];
	}
	return $Nombre_Banco;
}
		
		
/*
Autor: Paco, tomado de www.elguruprogramador.com.ar
centimos: funci�n utilizada por la funci�n ConvertirALetras.
*/		
function centimos()
{
	global $importe_parcial;

	$importe_parcial = number_format($importe_parcial, 2, ".", "") * 100;

	if ($importe_parcial > 0)
		$num_letra = " con ".decena_centimos($importe_parcial);
	else
		$num_letra = "";

	return $num_letra;
}

/*
Autor: Paco, tomado de www.elguruprogramador.com.ar
unidad_centimos: funci�n utilizada por la funci�n ConvertirALetras.
*/		
function unidad_centimos($numero)
{
	switch ($numero)
	{
		case 9:
		{
			$num_letra = "nueve c�ntimos";
			break;
		}
		case 8:
		{
			$num_letra = "ocho c�ntimos";
			break;
		}
		case 7:
		{
			$num_letra = "siete c�ntimos";
			break;
		}
		case 6:
		{
			$num_letra = "seis c�ntimos";
			break;
		}
		case 5:
		{
			$num_letra = "cinco c�ntimos";
			break;
		}
		case 4:
		{
			$num_letra = "cuatro c�ntimos";
			break;
		}
		case 3:
		{
			$num_letra = "tres c�ntimos";
			break;
		}
		case 2:
		{
			$num_letra = "dos c�ntimos";
			break;
		}
		case 1:
		{
			$num_letra = "un c�ntimo";
			break;
		}
	}
	return $num_letra;
}

/*
Autor: Paco, tomado de www.elguruprogramador.com.ar
decena_centimos: funci�n utilizada por la funci�n ConvertirALetras.
*/		
function decena_centimos($numero)
{
	if ($numero >= 10)
	{
		if ($numero >= 90 && $numero <= 99)
		{
			  if ($numero == 90)
				  return "noventa c�ntimos";
			  else if ($numero == 91)
				  return "noventa y un c�ntimos";
			  else
				  return "noventa y ".unidad_centimos($numero - 90);
		}
		if ($numero >= 80 && $numero <= 89)
		{
			if ($numero == 80)
				return "ochenta c�ntimos";
			else if ($numero == 81)
				return "ochenta y un c�ntimos";
			else
				return "ochenta y ".unidad_centimos($numero - 80);
		}
		if ($numero >= 70 && $numero <= 79)
		{
			if ($numero == 70)
				return "setenta c�ntimos";
			else if ($numero == 71)
				return "setenta y un c�ntimos";
			else
				return "setenta y ".unidad_centimos($numero - 70);
		}
		if ($numero >= 60 && $numero <= 69)
		{
			if ($numero == 60)
				return "sesenta c�ntimos";
			else if ($numero == 61)
				return "sesenta y un c�ntimos";
			else
				return "sesenta y ".unidad_centimos($numero - 60);
		}
		if ($numero >= 50 && $numero <= 59)
		{
			if ($numero == 50)
				return "cincuenta c�ntimos";
			else if ($numero == 51)
				return "cincuenta y un c�ntimos";
			else
				return "cincuenta y ".unidad_centimos($numero - 50);
		}
		if ($numero >= 40 && $numero <= 49)
		{
			if ($numero == 40)
				return "cuarenta c�ntimos";
			else if ($numero == 41)
				return "cuarenta y un c�ntimos";
			else
				return "cuarenta y ".unidad_centimos($numero - 40);
		}
		if ($numero >= 30 && $numero <= 39)
		{
			if ($numero == 30)
				return "treinta c�ntimos";
			else if ($numero == 91)
				return "treinta y un c�ntimos";
			else
				return "treinta y ".unidad_centimos($numero - 30);
		}
		if ($numero >= 20 && $numero <= 29)
		{
			if ($numero == 20)
				return "veinte c�ntimos";
			else if ($numero == 21)
				return "veintiun c�ntimos";
			else
				return "veinti".unidad_centimos($numero - 20);
		}
		if ($numero >= 10 && $numero <= 19)
		{
			if ($numero == 10)
				return "diez c�ntimos";
			else if ($numero == 11)
				return "once c�ntimos";
			else if ($numero == 11)
				return "doce c�ntimos";
			else if ($numero == 11)
				return "trece c�ntimos";
			else if ($numero == 11)
				return "catorce c�ntimos";
			else if ($numero == 11)
				return "quince c�ntimos";
			else if ($numero == 11)
				return "dieciseis c�ntimos";
			else if ($numero == 11)
				return "diecisiete c�ntimos";
			else if ($numero == 11)
				return "dieciocho c�ntimos";
			else if ($numero == 11)
				return "diecinueve c�ntimos";
		}
	}
	else
		return unidad_centimos($numero);
}

/*
Autor: Paco, tomado de www.elguruprogramador.com.ar
unidad: funci�n utilizada por la funci�n ConvertirALetras.
*/		
function unidad($numero)
{
	switch ($numero)
	{
		case 9:
		{
			$num = "nueve";
			break;
		}
		case 8:
		{
			$num = "ocho";
			break;
		}
		case 7:
		{
			$num = "siete";
			break;
		}
		case 6:
		{
			$num = "seis";
			break;
		}
		case 5:
		{
			$num = "cinco";
			break;
		}
		case 4:
		{
			$num = "cuatro";
			break;
		}
		case 3:
		{
			$num = "tres";
			break;
		}
		case 2:
		{
			$num = "dos";
			break;
		}
		case 1:
		{
			$num = "uno";
			break;
		}
	}
	return $num;
}

/*
Autor: Paco, tomado de www.elguruprogramador.com.ar
decena: funci�n utilizada por la funci�n ConvertirALetras.
*/		

function decena($numero)
{
	if ($numero >= 90 && $numero <= 99)
	{
		$num_letra = "noventa ";
		
		if ($numero > 90)
			$num_letra = $num_letra."y ".unidad($numero - 90);
	}
	else if ($numero >= 80 && $numero <= 89)
	{
		$num_letra = "ochenta ";
		
		if ($numero > 80)
			$num_letra = $num_letra."y ".unidad($numero - 80);
	}
	else if ($numero >= 70 && $numero <= 79)
	{
			$num_letra = "setenta ";
		
		if ($numero > 70)
			$num_letra = $num_letra."y ".unidad($numero - 70);
	}
	else if ($numero >= 60 && $numero <= 69)
	{
		$num_letra = "sesenta ";
		
		if ($numero > 60)
			$num_letra = $num_letra."y ".unidad($numero - 60);
	}
	else if ($numero >= 50 && $numero <= 59)
	{
		$num_letra = "cincuenta ";
		
		if ($numero > 50)
			$num_letra = $num_letra."y ".unidad($numero - 50);
	}
	else if ($numero >= 40 && $numero <= 49)
	{
		$num_letra = "cuarenta ";
		
		if ($numero > 40)
			$num_letra = $num_letra."y ".unidad($numero - 40);
	}
	else if ($numero >= 30 && $numero <= 39)
	{
		$num_letra = "treinta ";
		
		if ($numero > 30)
			$num_letra = $num_letra."y ".unidad($numero - 30);
	}
	else if ($numero >= 20 && $numero <= 29)
	{
		if ($numero == 20)
			$num_letra = "veinte ";
		else
			$num_letra = "veinti".unidad($numero - 20);
	}
	else if ($numero >= 10 && $numero <= 19)
	{
		switch ($numero)
		{
			case 10:
			{
				$num_letra = "diez ";
				break;
			}
			case 11:
			{
				$num_letra = "once ";
				break;
			}
			case 12:
			{
				$num_letra = "doce ";
				break;
			}
			case 13:
			{
				$num_letra = "trece ";
				break;
			}
			case 14:
			{
				$num_letra = "catorce ";
				break;
			}
			case 15:
			{
				$num_letra = "quince ";
				break;
			}
			case 16:
			{
				$num_letra = "dieciseis ";
				break;
			}
			case 17:
			{
				$num_letra = "diecisiete ";
				break;
			}
			case 18:
			{
				$num_letra = "dieciocho ";
				break;
			}
			case 19:
			{
				$num_letra = "diecinueve ";
				break;
			}
		}
	}
	else
		$num_letra = unidad($numero);

	return $num_letra;
}

/*
Autor: Paco, tomado de www.elguruprogramador.com.ar
centena: funci�n utilizada por la funci�n ConvertirALetras.
*/		
function centena($numero)
{
	if ($numero >= 100)
	{
		if ($numero >= 900 & $numero <= 999)
		{
			$num_letra = "novecientos ";
			
			if ($numero > 900)
				$num_letra = $num_letra.decena($numero - 900);
		}
		else if ($numero >= 800 && $numero <= 899)
		{
			$num_letra = "ochocientos ";
			
			if ($numero > 800)
				$num_letra = $num_letra.decena($numero - 800);
		}
		else if ($numero >= 700 && $numero <= 799)
		{
			$num_letra = "setecientos ";
			
			if ($numero > 700)
				$num_letra = $num_letra.decena($numero - 700);
		}
		else if ($numero >= 600 && $numero <= 699)
		{
			$num_letra = "seiscientos ";
			
			if ($numero > 600)
				$num_letra = $num_letra.decena($numero - 600);
		}
		else if ($numero >= 500 && $numero <= 599)
		{
			$num_letra = "quinientos ";
			
			if ($numero > 500)
				$num_letra = $num_letra.decena($numero - 500);
		}
		else if ($numero >= 400 && $numero <= 499)
		{
			$num_letra = "cuatrocientos ";
			
			if ($numero > 400)
				$num_letra = $num_letra.decena($numero - 400);
		}
		else if ($numero >= 300 && $numero <= 399)
		{
			$num_letra = "trescientos ";
			
			if ($numero > 300)
				$num_letra = $num_letra.decena($numero - 300);
		}
		else if ($numero >= 200 && $numero <= 299)
		{
			$num_letra = "doscientos ";
			
			if ($numero > 200)
				$num_letra = $num_letra.decena($numero - 200);
		}
		else if ($numero >= 100 && $numero <= 199)
		{
			if ($numero == 100)
				$num_letra = "cien ";
			else
				$num_letra = "ciento ".decena($numero - 100);
		}
	}
	else
		$num_letra = decena($numero);
	
	return $num_letra;
}

/*
Autor: Paco, tomado de www.elguruprogramador.com.ar
cien: funci�n utilizada por la funci�n ConvertirALetras.
*/		
function cien()
{
	global $importe_parcial;
	
	$parcial = 0; $car = 0;
	
	if ($importe_parcial!='000')
		while (substr($importe_parcial,0,1) == 0)
			$importe_parcial = substr($importe_parcial, 1, (strlen($importe_parcial) - 1));
	if ($importe_parcial >= 1 && $importe_parcial <= 9.99)
		$car = 1;
	else if ($importe_parcial >= 10 && $importe_parcial <= 99.99)
		$car = 2;
	else if ($importe_parcial >= 100 && $importe_parcial <= 999.99)
		$car = 3;
	
	$parcial = substr($importe_parcial, 0, $car);
	$importe_parcial = substr($importe_parcial, $car);
	
	$num_letra = centena($parcial).centimos();
	
	return $num_letra;
}

/*
Autor: Paco, tomado de www.elguruprogramador.com.ar
cien_mil: funci�n utilizada por la funci�n ConvertirALetras.
*/		
function cien_mil()
{
	global $importe_parcial;
	//echo "el importe parcial vale: ".$importe_parcial;

	
	$parcial = 0; $car = 0;
	
	if ($importe_parcial!='000000')
		while (substr($importe_parcial, 0, 1) == 0)
			$importe_parcial = substr($importe_parcial, 1, strlen($importe_parcial) - 1);
	
	if ($importe_parcial >= 1000 && $importe_parcial <= 9999.99)
		$car = 1;
	else if ($importe_parcial >= 10000 && $importe_parcial <= 99999.99)
		$car = 2;
	else if ($importe_parcial >= 100000 && $importe_parcial <= 999999.99)
		$car = 3;
	
	$parcial = substr($importe_parcial, 0, $car);
	$importe_parcial = substr($importe_parcial, $car);
	
	if ($parcial > 0)
	{
		if ($parcial == 1)
			$num_letra = "mil ";
		else
			$num_letra = centena($parcial)." mil ";
	}
	
	return $num_letra;
}


/*
Autor: Paco, tomado de www.elguruprogramador.com.ar
millon: funci�n utilizada por la funci�n ConvertirALetras.
*/		
function millon()
{
	global $importe_parcial;
	
	$parcial = 0; $car = 0;
	
	while (substr($importe_parcial, 0, 1) == 0)
		$importe_parcial = substr($importe_parcial, 1, strlen($importe_parcial) - 1);
	
	if ($importe_parcial >= 1000000 && $importe_parcial <= 9999999.99)
		$car = 1;
	else if ($importe_parcial >= 10000000 && $importe_parcial <= 99999999.99)
		$car = 2;
	else if ($importe_parcial >= 100000000 && $importe_parcial <= 999999999.99)
		$car = 3;
	
	$parcial = substr($importe_parcial, 0, $car);
	$importe_parcial = substr($importe_parcial, $car);
	
	if ($parcial == 1)
		$num_letras = "un mill�n ";
	else
		$num_letras = centena($parcial)." millones ";
	
	return $num_letras;
}


/*
Autor: Paco, tomado de www.elguruprogramador.com.ar
ConvertirALetras: convierte una cifra en su equivalente en letras.
Par�metro $numero: cifra (en n�meros) que se desea expresar en letras.
*/		
function ConvertirALetras($numero)
{
	global $importe_parcial;
	
	$importe_parcial = $numero;
	
	if ($numero < 1000000000)
	{
		if ($numero >= 1000000 && $numero <= 999999999.99)
			$num_letras = millon().cien_mil().cien();
		else if ($numero >= 1000 && $numero <= 999999.99)
			$num_letras = cien_mil().cien();
		else if ($numero >= 1 && $numero <= 999.99)
			$num_letras = cien();
		else if ($numero >= 0.01 && $numero <= 0.99)
		{
			if ($numero == 0.01)
				$num_letras = "un c�ntimo";
			else
				$num_letras = ConvertirALetras(($numero * 100)."/100")." c�ntimos";
		}
	}
	return $num_letras;
}
		
?>