<?php
function Insertar()
{
	$BaseDato=new BaseDeDato(SERVIDOR,PUERTO,BD,USUARIO,CLAVE);

	$consulta="INSER INTO cuentausuario VALUES ('$this->login','$this->contraseña','$this->cedula','$this->tipo','$this->inactivo',)";

	$ExisteCedula=$this-> Existencia('cedula');
	$ExisteLogin=$this-> Existencia('login');
	$ExisteContraseña=$this-> Existencia('contraseña');
	if (!$ExisteCedula&&!$ExisteLogin&&!$ExisteContraseña) 
{
	$Resultado=$BaseDato->consultas($consulta);
	if(pg_affected_rows($resultado)>=0)
	return 1;
	else
	return 0;
}
if($ExisteCedula&&$ExisteLogin)
return -1;
else
if($ExisteCedula&&$ExisteLogin)
return -2;
elseif($ExisteCedula&&$ExisteLogin)
return -3;
	}
function Modificar()
{
	include_once('../php/conexion.php');
	$resultado=pg_query($conexion,"UPDATE cuentausuario='$this->contraseña',tipo='$this->tipo' WHERE login='$this->login'");
	if(pg_affected_rows($resultado)>=0)
	return 1;
	else
	return 0;
}
function eliminar()
{
	include_once('../php/conexion.php');
	$resultado=pg_query($conexion,"DELETE FROM cuentausuario WHERE login='$this->login'");
	if(pg_affected_rows($resultado)>=0)
	return 1;
	else
	return 0;
}
function Buscar()
{
	$BaseDato=new BaseDeDato(SERVIDOR,PUERTO,BD,USUARIO,CLAVE);//declarar el objeto de la base de datos
	$Consulta="SELECT * FROM cuentausuario AS a,privilegio AS b,personal AS c where (a.login='$this->login') and (a.contraseña='this->contraseña') and (a.cedula=c.cedula)";//declarar cnsulta
	$Resultado=$BaseDato->consultas($consulta); //llamar a la funcion de la base de datos que realiza la consulta 

	$Datos=@pg_fetch_all($Resultado); // devuelve los datos en forma de arreglo

	if($Datos[0]['login']) //verifica si arrojo algun resultado 
       return $Datos;
    else 
       return 0;     
}

function BuscarUsuario()
{
	$BaseDato=new BaseDeDato(SERVIDOR,PUERTO,BD,USUARIO,CLAVE); //declarar el objeto de la clase de la base de datos

	if($this->login!="")
	{

	  $condicion=$condicion."a.login LIKE"."'$this->login%'";
	  $Operador="AND";
}

if($this->nombre!="")
	{

	  $condicion=$condicion."a.nombre LIKE"."'$this->nombre%'";
	  $Operador="AND";
	}
	  
if($this->Cedula!="")
{
	$Condicion=$Condicion." ".$Operador." a.cedula="."'$this->cedula'";
    $Operador="AND";
}

if($this->tipo!="")
{
	$Condicion=$Condicion." ".$Operador." a.tipo="."'$this->tipo'";
    $Operador="AND";
}

$consulta="SELECT * FROM cuentausuario AS a,privilegio AS b WHERE ".$condicion."AND (a.login=b.login)"; //declarar consulta
$Resultado=$BaseDato->consultas($consulta); //llamar a la funcion de la base de datos que realiza la consulta 

	$Datos=@pg_fetch_all($Resultado); // devuelve los datos en forma de arreglo

	if($Datos[0]['login']) //verifica si arrojo algun resultado 
       return $Datos;
    else 
       return 0;  
}
function Existencia($condicion)
{
	$BaseDato=new BaseDeDato(SERVIDOR,PUERTO,BD,USUARIO,CLAVE);

	if($Condicion=='login')
	$Condicion="login="."'$this->login'";

else
	if($Condicion=='cedula')
	$Condicion="cedula="."'$this->cedula'";

else
	$Condicion="contraseña="."'$this->contraseña'";

$consulta=" SELECT * FROM cuentausuario WHERE".$condicion;

$Resultado=$BaseDato->consultas($consulta); //llamar a la funcion de la base de datos que realiza la consulta 
$Datos=@pg_fetch_all($Resultado); // devuelve los datos en forma de arreglo


	if($Datos[0]['login']) 
       return 1;
    else 
       return 0;  
}

function BuscarTodo()
{
	$BaseDato=new BaseDeDato(SERVIDOR,PUERTO,BD,USUARIO,CLAVE);
	$consulta="SELECT * FROM privilegio";
	$Resultado=$BaseDato->consultas($consulta); //llamar a la funcion de la base de datos que realiza la consulta

	$Datos=@pg_fetch_all($Resultado); // devuelve los datos en forma de arreglo


	if($Datos[0]['login']) 
       return $datos;
    else 
       return 0;  
    } 

?>