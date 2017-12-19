<?php
require_once("seguridad.php");
?>
<script language="JavaScript" type="text/javascript" src="date-picker.js"></script>
 <script>
         function buscarFichaEntrega() {
                  if (document.frmPlanilla.txtFichaEntrega.value!="") {
                      document.frmPlanilla.funcion.value=3;
                      document.frmPlanilla.submit();
                  }
        }
       function buscarFichaRecibo() {
             if (document.frmPlanilla.txtFichaRecibo.value!="") {
                 document.frmPlanilla.funcion.value=3;
                 document.frmPlanilla.submit();
             }
        }
       function quitarDespacho() {
                document.frmPlanilla.funcion.value=6;
                document.frmPlanilla.submit();
        }
       function asociar() {
                        document.frmPlanilla.funcion.value=5;
                        document.frmPlanilla.submit();
        }
        function cambiarSeleccion() {
                document.frmPlanilla.funcion.value=4;
                document.frmPlanilla.submit();
        }

</script>

<?php

switch ($funcion) {
        case 1:
                break 1;
        case 2:
                  if (isset($_POST[txtFichaEntrega]) && empty($_POST[txtFichaEntrega])) {
                        if ($sw==1) {
                                $mensaje=$mensaje."<b>,</b>";
                        }
                        $mensaje=$mensaje." <b>FICHA ENTREGA</b>";
                        $i++;
                        $sw=1;
                }
                if (isset($_POST[txtFichaRecibo]) && empty($_POST[txtFichaRecibo])) {
                        if ($sw==1) {
                                $mensaje=$mensaje."<b>,</b>";
                        }
                        $mensaje=$mensaje." <b>FICHA RECIBO</b>";
                        $i++;
                        $sw=1;
                }
                if (isset($_POST[txtRuta]) && empty($_POST[txtRuta])) {
                        if ($sw==1) {
                                $mensaje=$mensaje."<b>,</b>";
                        }
                        $mensaje=$mensaje." <b>RUTA</b>";
                        $i++;
                        $sw=1;
                }
                if (isset($_POST[txtFecha]) && empty($_POST[txtFecha])) {
                        if ($sw==1) {
                                $mensaje=$mensaje."<b>,</b>";
                        }
                        $mensaje=$mensaje." <b>FECHA</b>";
                        $i++;
                        $sw=1;
                }
                switch($i) {
                        case 0:
                                require_once "administracion.php";
                                require_once "usuarioSistemaAdmin.php";
                                require_once("inventarioAdmin.php");
                                $tmp="'".$_POST[despachar]."'";
                                $tmp=str_replace("',","'",$tmp);
                                $tmp=str_replace(",","','",$tmp);
                                $login=$_SESSION["login"];
                                $nuevaPlanilla=new planilla();
                                $nuevaPlanilla->setPlanilla($_POST[txtFichaRecibo],$_POST[txtFichaEntrega],$_POST[txtRuta],$_POST[txtFecha],$tmp,$_POST[seltipo],$_POST[selSitio]);
                                $resultado=$nuevaPlanilla->nuevaPlanilla();
                                switch($resultado) {
                                        case 0:
                                                echo "<br><br><br><br>";
                                                echo "<table class=\"mensajeTitulo\" align=center width=\"500\" border=\"0\">";
                                                echo "<tr>";
                                                echo "<td align=center>MENSAJE: NUEVA PLANILLA</td>
                                                </tr>";
                                                echo "<tr>";
                                                echo "<td valign=top class=\"mensaje\" align=center>SE GUARDO LA NUEVA PLANILLA</td>";
                                                echo "</tr>";
                                                echo "<tr>";
                                                echo "<td valign=top class=\"mensaje\" align=center>
                                                <input name=\"btnAceptar\" type=\"button\" value=\"ACEPTAR\" onclick=\"location.href='index2.php?item=100'\">
                                                      </td>";
                                                echo "</tr>";
                                                echo "</table>";
                                        break 1;
                                }
                             break 1;
                }
                break 1;
              case 3:
                     formularioPlanilla();
                     break 1;
              case 4:
                $tmp="'".$_POST[despachar]."'";
                $tmp=str_replace("',","'",$tmp);
                $tmp=str_replace(",","','",$tmp);
                formularioPlanilla($tmp);
                break 1;
              case 5:
                if (!empty($_POST[optInventario]))
                        $_POST[despachar]=$_POST[despachar].",".$_POST[optInventario];
                        $tmp="'".$_POST[despachar]."'";
                        $tmp=str_replace("',","'",$tmp);
                        $tmp=str_replace(",","','",$tmp);
                        formularioPlanilla($tmp);
                break 1;
              case 6:
                unset($_POST[despachar]);
                formularioPlanilla($tmp);
                break 1;
             default:
                    formularioPlanilla();
}

function formularioPlanilla($elementos="") {
        require_once "formularios.php";
        require_once "conexionsql.php";
        require_once "inventarioAdmin.php";
        require_once "usuarioAdmin.php";
        require_once "pedidoAdmin.php";


       if (isset($_POST[txtFichaEntrega]) && !empty($_POST[txtFichaEntrega])){
            $usuarioAsignacion= new usuario($_POST[txtFichaEntrega]);
            $resultado5= $usuarioAsignacion->retornaUsuario();
            if ($resultado5 && $resultado5!=1) {
               $row5=mysql_fetch_array($resultado5);
               $_POST[txtNombreEntrega]=$row5[2];
               }
        }
        if (isset($_POST[txtFichaRecibo]) && !empty($_POST[txtFichaRecibo])){
            $usuarioAsignacion= new usuario($_POST[txtFichaRecibo]);
            $resultado5= $usuarioAsignacion->retornaUsuario();
            if ($resultado5 && $resultado5!=1) {
               $row5=mysql_fetch_array($resultado5);
               $_POST[txtNombreRecibo]=$row5[2];
               }
        }

        $contipo="Select ID_TIPO_PLANILLA,DESCRIPCION From tipo_planilla Order By DESCRIPCION Asc";
        $conSitio="select id_sitio,sitio from sitio where status_activo=1 order by sitio";

		//Campo Sitio
        $sitio= new campoSeleccion("selSitio","formularioCampoSeleccion","$_POST[selSitio]","","",$conSitio,"--UBICACION--","");
        $selSitio=$sitio->retornar();

        //Campo Ficha Entrega
        $FichaEntrega= new campo("txtFichaEntrega","text","formularioCampoTexto","$_POST[txtFichaEntrega]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
        $txtFichaEntrega=$FichaEntrega->retornar();

        //Campo Ficha Recibo
        $FichaRecibo= new campo("txtFichaRecibo","text","formularioCampoTexto","$_POST[txtFichaRecibo]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
        $txtFichaRecibo=$FichaRecibo->retornar();

        //Campo Nombre Recibo
        $NombreRecibo= new campo("txtNombreRecibo","text","formularioCampoTexto","$_POST[txtNombreRecibo]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
        $txtNombreRecibo=$NombreRecibo->retornar();

        //Campo Nombre Entrega
        $NombreEntrega= new campo("txtNombreEntrega","text","formularioCampoTexto","$_POST[txtNombreEntrega]","30","30","onKeyPress","if (event.keyCode == 13) event.returnValue = false;");
        $txtNombreEntrega=$NombreEntrega->retornar();

        //Campo Fecha
        $Fecha= new campo("txtFecha","text","formularioCampoTexto","$_POST[txtFecha]","10","10","","");
        $txtFecha=$Fecha->retornar();

        $tipo= new campoSeleccion("seltipo","formularioCampoSeleccion","$_POST[seltipo]","","",$contipo,"--SELECCIONE--","");
        $seltipo=$tipo->retornar();

        echo "<form name=\"frmPlanilla\" method=\"post\" action=\"\">";
        echo "<input name=\"funcion\" type=\"hidden\" value=\"2\">";
        echo "<input name=\"despachar\" type=\"hidden\" value=\"$_POST[despachar]\">";

        echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
                echo "<tr>";
                        echo "<td class=\"tituloPagina\" colspan=\"2\">NUEVA PLANILLA</td>
                                  </tr>";
                echo "<tr>";
                        echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">DATOS DE LA PLANILLA</td>
                                  </tr>
                <tr>
                    <td valign=top class=\"formularioCampoTitulo\">
                        FICHA ENTREGA<br><input class=\"formularioCampoTexto\" name=\"txtFichaEntrega\" type=\"text\" value=\"$_POST[txtFichaEntrega]\" onKeyPress=\"if (event.keyCode==13) buscarFichaEntrega();\">
                        <input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarFichaEntrega()\"><br>
                        FICHA RECIBO<br><input class=\"formularioCampoTexto\" name=\"txtFichaRecibo\" type=\"text\" value=\"$_POST[txtFichaRecibo]\" onKeyPress=\"if (event.keyCode==13) buscarFichaRecibo();\">
                        <input name=\"btnChequear\" title=\"Comprobar\" type=\"button\" value=\"C\" onclick=\"buscarFichaRecibo()\"><br>
                        RUTA<br><input name=\"txtRuta\" type=\"file\" value=\"$_POST[txtRuta]\"><br>
                        FECHA <br> $txtFecha <a href=\"javascript:show_calendar('frmPlanilla.txtFecha');\" onmouseover=\"window.status='Date Picker';return true;\" onmouseout=\"window.status='';return true;\"> <img src=\"../imagenes/calendario.gif\" width=\"23\" height=\"15\" border=0></a><br><br>
                        </td>
                        <td valign=top class=\"formularioCampoTitulo\">
                         NOMBRE<br>$txtNombreEntrega<br>
                         NOMBRE<br>$txtNombreRecibo<br>
                         TIPO<br>$seltipo<br>
                         SITIO<br>$selSitio<br>
                        </td>
                </tr>";
        echo "</table>";

//COMPONENTES ASOCIADOS A LA PLANILLA
        echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
        echo "<tr>
                        <td class=\"formularioTablaTitulo\" colspan=\"4\">LISTA DE COMPONENTES ASOCIADOS</td>
                </tr>";

        $despacho=new despacho();
        $resultadoComponentesADespachar=$despacho->mostrarComponentesADespachar($elementos);
        if ($resultadoComponentesADespachar && $resultadoComponentesADespachar!=1) {
                echo "<tr valign=top class=\"tablaTitulo\">
                        <td align=\"left\" class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
                        <td valign=top class=\"tablaTitulo\">MARCA</td>
                        <td valign=top class=\"tablaTitulo\">MODELO</td>
                        <td valign=top class=\"tablaTitulo\">SERIAL</td>
                        </tr>";
                $i=0;
                        while ($row=mysql_fetch_array($resultadoComponentesADespachar)) {
                                if ($i%2==0) {
                                        $clase="tablaFilaPar";
                                } else {
                                        $clase="tablaFilaNone";
                                }
                                echo "<tr class=\"$clase\">
                                        <td align=\"left\">$row[3]</td>
                                        <td>$row[5]</td>
                                        <td>$row[7] $row[8] $row[9]</td>
                                        <td>$row[1]</td>
                                </tr>";
                                $i++;
                        }
                echo "<tr>
                        <td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\">";
                                echo "<a class=\"botonEnlace\" href=\"#\" onClick=\"quitarDespacho()\">LIMPIAR</a>
                        </td>
                </tr>";
           } else {
                echo "<tr class=\"$clase\">
                                        <td align=\"center\" colspan=\"5\">LISTA NO DISPONIBLE</td>";
                echo "</tr>";
        }

        echo "</table>";
echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
                echo "<tr>";
                        echo "<td class=\"formularioTablaTitulo\" colspan=\"2\">ASOCIAR COMPONENTE</td>
                        </tr> <br>";

                        echo "<tr>
                                <td valign=top class=\"formularioCampoTitulo\">SERIAL<br>
                                <input class=\"formularioCampoTexto\" name=\"txtSerialDisponible\" type=\"text\" value=\"$_POST[txtSerialDisponible]\" onKeyPress=\"if (event.keyCode==13) cambiarSeleccion();\"><input name=\"button\" type=\"button\" value=\"B\" onclick=\"cambiarSeleccion()\"><br><br>
                        </td>
                        </tr>";

        echo "</table>";

                        echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
                        echo "<tr>
                        <td class=\"formularioTablaTitulo\" colspan=\"5\">INVENTARIO - TOTAL: $total </td>
                        </tr>";
                        echo "<tr valign=top class=\"tablaTitulo\">
                                <td align=\"left\" class=\"tablaTitulo\">SERIAL</td>
                                <td valign=top class=\"tablaTitulo\">DESCRIPCI&Oacute;N</td>
                                <td valign=top class=\"tablaTitulo\">MARCA</td>
                                <td valign=top class=\"tablaTitulo\">MODELO</td>
                                </tr>";
                        $componente = new componente();
                        $componente->setInventario("",$_POST[txtSerialDisponible],"","","");
                        $resultadoBuscar=$componente->buscarComponentesDisponibles();
//                        $despachado= new despacho();
                        if ($resultadoBuscar && $resultadoBuscar!=1) {
                                        while ($row=mysql_fetch_array($resultadoBuscar)) {
                                                if ($i%2==0) {
                                                        $clase="tablaFilaPar";
                                                } else {
                                                        $clase="tablaFilaNone";
                                                }
                                                echo "<tr class=\"$clase\">
                                                <td align=\"left\"><input name=\"optInventario\" type=\"radio\" value=\"$row[0]\">$row[1]</td>
                                                <td>$row[3]</td>
                                                <td>$row[5]</td>
                                                <td>$row[7] $row[8] $row[9]</td>
                                                </tr>";
                                                $i++;
                                        }
                        }
                echo "<tr>
                        <td class=\"formularioTablaBotones\" align=\"center\" colspan=\"5\">";
                                echo "<a class=\"botonEnlace\" href=\"#\" onClick=\"asociar()\">ASOCIAR</a>
                        </td>
                </tr>";
                echo "</table>";
        echo "<table class=\"formularioTabla\"align=center width=\"600\" border=\"0\">";
        echo "<tr>
             <td class=\"formularioTablaBotones\" align=\"center\" colspan=\"2\"><input name=\"btnLimpiar\" type=\"button\" value=\"LIMPIAR\" onclick=\"location.href='index2.php?item=100'\"><input name=\"Limpiar\" type=\"submit\" value=\"GUARDAR\"></td>
     </tr>";
        echo "</table>";
        echo "</form>";
}
?>