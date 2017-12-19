<link rel="STYLESHEET" type="text/css" href="../site/estilos.css">
<title>BUSCADOR DE USUARIOS</title>
<?php
require_once "conexionsql.php";
conectarMysql();
$consulta="SELECT DISTINCT USUARIO.FICHA,concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO)as MOSTRAR, DEPARTAMENTO.DEPARTAMENTO,
                  USUARIO.ID_DEPARTAMENTO,SITIO.SITIO,USUARIO.ID_SITIO, USUARIO.EXTENSION,CARGO.CARGO from USUARIO
           INNER JOIN SITIO ON USUARIO.ID_SITIO=SITIO.ID_SITIO
           INNER JOIN CARGO ON USUARIO.ID_CARGO=CARGO.ID_CARGO
		   INNER JOIN DEPARTAMENTO ON USUARIO.ID_DEPARTAMENTO=DEPARTAMENTO.ID_DEPARTAMENTO
		   INNER JOIN DIVISION ON DEPARTAMENTO.ID_DIVISION=DIVISION.ID_DIVISION
		   INNER JOIN GERENCIA ON DIVISION.ID_GERENCIA=GERENCIA.ID_GERENCIA
		   WHERE USUARIO.FICHA LIKE '%$ficha%' OR USUARIO.NOMBRE_USUARIO LIKE '%$ficha%' OR USUARIO.APELLIDO_USUARIO LIKE '%$ficha%' OR
		   concat(NOMBRE_USUARIO,' ',APELLIDO_USUARIO)LIKE '%$ficha%'
		   ORDER BY USUARIO.FICHA";
$result=mysql_query($consulta);
$registro=mysql_num_rows($result);
if ($registro>0){
   echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
   echo "<tr valign=top class=\"tablaTitulo\">
         <td align=\"left\" class=\"tablaTitulo\">FICHA</td>
	     <td valign=top class=\"tablaTitulo\">USUARIO</td>
	      <td valign=top class=\"tablaTitulo\">CARGO</td>
	     <td valign=top class=\"tablaTitulo\">DEPARTAMENTO</td>
	     <td valign=top class=\"tablaTitulo\">SITIO</td>
	     <td valign=top class=\"tablaTitulo\">EXTENSION</td>
	     </tr>";
	  while ($row = mysql_fetch_array($result)) {
			if ($i%2==0) {
				$clase="tablaFilaPar";
			} else {
				$clase="tablaFilaNone";
			}
			echo "<tr class=\"$clase\">
		    <td align=\"left\">$row[0]</td>
			<td>$row[1]</td>	
			<td>$row[7]</td>	
			<td>$row[2]</td>
			<td>$row[4]</td>
			<td>$row[6]</td>
			</tr>";
			$i++;
       }
}
else{
	 echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";			    			    
			    echo "<tr>";
		     	echo "<td align=center>MENSAJE - BUSCAR - USUARIO</td>
				</tr>";
			    echo "<tr>";
		     	echo "<td valign=top class=\"mensaje\" align=center>OPERACIÓN FALLIDA NO EXISTEN REGISTROS CON ESTOS VALORES</td>";
			    echo "</tr>";
			    echo "<tr>";
			    echo "<td valign=top class=\"mensaje\" align=center><input name=\"txtBoton\" type=\"button\" value=\"ACEPTAR\" onClick=\"window.close()\"></td>";
			    echo "</tr>";
			    echo "</table>";			
}       
?>