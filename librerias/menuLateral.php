<script>
function buscarUsuario() {
	var buscar;
	buscar=document.frmBuscar.txtBuscar.value;
	if (buscar!="")
		window.open('../librerias/usuarioBuscar.php?buscar='+buscar);
}

</script>
<?php 
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start(); 
?>
<table class=\"tablaMenu\"border="1" cellpadding="0" cellspacing="0">    
<tr><td class="menuBloque">USUARIO</td></tr>
<tr align="center" ><td class="tablaLateral">
<form name="frmBuscar" method="post" action="">
<input name="txtBuscar" type="text" value="" onKeyPress="if (event.keyCode==13) buscarUsuario();"><input name="btnBuscar" type="button" value="BUSCAR" onclick="buscarUsuario()">                           
</form>
</td></tr>

<tr><td class="menuBloque">MIGRACION</td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" title="Se asigna una nueva solicitud" href="index2.php?item=624">NUEVA ENTREVISTA</a></td></tr> 

<tr><td class="menuBloque">SOLICITUDES</td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" title="Se asigna una nueva solicitud" href="index2.php?item=200">NUEVA SOLICITUD</a></td></tr>           
<tr><td class="tablaLateral"><a class="botonLateral" title="Se muestran todos los tipos de reportes" href="index2.php?item=201">REPORTES DE SOLICITUDES</a></td></tr>

<tr><td class="menuBloque">PREVENTIVO</td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=307">NUEVO</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=304">REACTIVAR MANTENIMIENTO</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=421">ELIMINAR MANTENIMIENTO</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=305">REPORTE DE EQUIPOS POR EDIFICIOS</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=306">REPORTE DE MANTENIMIENTOS PREVENTIVO</a></td></tr>      
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=301">MANTENIMIENTOS POR PERSONA</a></td></tr>

<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=420">REPORTE EJECUCION POR EDIFICIOS</a></td></tr>                      
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=422">REPORTE GLOBAL DE MANTENIMIENTOS</a></td></tr>                      

<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=424">REPORTE DE CAPACIDAD DE MEMORIA POR EDIF</a></td></tr>                      
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=426">REPORTE DE EQUIPOS FALTANTES POR EDIFICIO</a></td></tr>                      
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=427">REPORTE DE EQUIPOS FALTANTES</a></td></tr>                      
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=428">REPORTE DE INVENTARIO INICIAL</a></td></tr>                      
  

<tr><td class="menuBloque">INVENTARIO</td></tr> 
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=130">NUEVO EQUIPO</a></td></tr>                           
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=131">NUEVO COMPONENTE</a></td></tr> 
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=160">MODIFICAR COMPONENTE</a></td></tr>   
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=137">NUEVO SUMINISTRO</a></td></tr>                        
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=151">INVENTARIO DE EQUIPO</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=156">BUSCAR EQUIPO</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=154">BUSCAR COMPONENTE</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=9">PUNTOS PENDIENTES</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=429">REPORTE VIDA UTIL COMPONENTES</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=431">REPORTE VIDA UTIL EQUIPOS</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=430">INVENTARIO DE EQUIPOS Y COMPONENTES POR USUARIO</a></td></tr>


<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=434">REPORTE EQUIPOS Y COMPONENTES DESINCORPORADOS</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=435">REPORTE DE PUNTOS PENDIENTES</a></td></tr>

<tr><td class="menuBloque">DESPACHOS</td></tr> 
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=621">EQUIPOS</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=614">COMPONENTES DE MICRO</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=615">COMPONENTES DE IMPRESORAS</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=616">SUMINISTROS</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=622">REPORTE EQUIPOS</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=617">REPORTES COMPONENTES</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=704">REPORTE DE DESPACHO  DE EQUIPOS Y COMPONENTES</a></td></tr>


<tr><td class="menuBloque">GARANTIA</td></tr>  
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=506">GARANTIA</a></td></tr>                                      


<tr><td class="menuBloque">REPORTES</td></tr> 
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=625">REPORTE USUARIO</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=628">REPORTE EQUIPOS DE PLANTA</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=627">HISTORIAL DE PEDIDOS</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=632">REPORTE COMPONENTE POR EQUIPO</a></td></tr>
<tr><td class="tablaLateral"><a class="botonLateral" href="index2.php?item=636">REPORTE HOJAS IMPRESAS</a></td></tr>

<tr><td class="menuBloque">COMUNICACION INTERNA</td></tr> 
<tr><td class="menuBloque"><a class="botonLateral" href="../../comunicacion/standar.php">COMUNICACION INTERNA</a></td></tr>

<tr><td class="menuBloque">PERSONAL</td></tr>
<tr><td class="menuBloque"><a class="botonLateral" href="index2.php?item=700">CARGAR ASISTENCIAS</a></td></tr>
<tr><td class="menuBloque"><a class="botonLateral" href="index2.php?item=701">VER ASISTENCIAS</a></td></tr>

<tr><td class="menuBloque">&nbsp;</td></tr> 
<tr><td class="menuBloque"><a class="botonLateral" href="../admincau/index2.php">ADMINCAU</a></td></tr> 
 </table>	
