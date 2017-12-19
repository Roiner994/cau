<link rel="STYLESHEET" type="text/css" href="estilos.css">
<?php
			$item=$_GET['item'];
	//	if(isset($item) && !empty($item)) {
			switch($item) {
				case "3":
					include ("../librerias/cerrarSession.php");
					break 1;
				case "8":
					include ("../librerias/nuevaSolicitud.php");
					break 1;
				case "9":
					require_once("../librerias/rptPuntosPendientes.php");
					break 1;
				case "10":
					require_once("../librerias/puntoPendienteCerrar.php");
					break 1;			
				case "130":
					require_once("../librerias/equipoNuevo.php");
					break 1;
				case "131":
					include ("../librerias/componenteNuevo.php");
					break 1;
				case "132":
					include ("../librerias/informacionEquipo.php");
					break 1;
				case "133":
					include ("../librerias/componenteAsignacion.php");
					break 1;
				case "134":
					include ("../librerias/controlInventario.php");
					break 1;
				case "135":
					include ("../librerias/componentesAsociar.php");
					break 1;
				case "136":
					include ("../librerias/buscarComponentes.php");
					break 1;		
				case "137":
					include ("../librerias/suministroNuevo.php");
					break 1;
				case "138":
					include ("../librerias/despachar.php");
					break 1;	
				case "139":
					include ("../librerias/equiposComponentesDanados.php");
					break 1;
				case "141":
					include ("../librerias/equipoComponenteGarantiaDanados.php");
					break 1;	
				case "140":
					require_once("../librerias/equipoAsignacion.php");
					break 1;					
				case "150":
					require_once("../librerias/devolucionComponentes.php");
					break 1;
				case "151":
					require_once("../librerias/inventarioEquipo.php");
					break 1;
				case "152":
					require_once("../librerias/inventarioComponente.php");
					break 1;
				case "153":
					require_once("../librerias/generarPlanillaAsignacion.php");
					break 1;
				case "154":
					require_once("../librerias/componenteBuscar.php");
					break 1;
				case "155":
					require_once("../librerias/componenteMostrar.php");
					break 1;
				case "156":
					require_once("../librerias/rptEquipos.php");
					break 1;
				case "160":
					require_once("../librerias/componenteModificar.php");
					break 1;
				case "161":
					require_once("../librerias/equipoModificar.php");
					break 1;
				case "200":
					include "../librerias/requerimientoNuevo.php";
					break 1;
				case "201":
					include "../librerias/reporteRequerimientoEquipos.php";
					break 1;	
				case "202":
					include "../librerias/requerimientoModificar.php";
					break 1;
				case "204":
					include "../librerias/requerimientoEliminar.php";
					break 1;									

				case "300":
					include ("../librerias/mantenimientoVerificar.php");
					break 1;
				case "301":
					include ("../librerias/rptManttoPersonas.php");
					break 1;
				case "302":
					include ("../librerias/PreventivoReportes.php");
					break 1;
				case "303":
					include ("../librerias/equipoNuevoMantenimiento.php");
					break 1;
				case "304":
					require_once ("../librerias/mantenimientoReactivar.php");
					break 1;
				case "305":
					require_once ("../librerias/rptEquiposPorEdificios.php");
					break 1;
				case "306":
					require_once ("../librerias/rptMantenimientosPreventivos.php");
					break 1;
				case "307":
					require_once ("../librerias/mantenimientoVerificar.php");
					break 1;
				case "308":
					require_once ("../librerias/mantenimientoPreventivoNuevo.php");
					break 1;
				case "309":
					require_once ("../librerias/mantenimientoRadar.php");
					break 1;
				case "500":
					include ("../librerias/garantia.php");
					break 1;
				/*case "501":
					include ("../librerias/garantiaReporte.php");
					break 1;*/
				case "502":
					include ("../librerias/garantiaReportar.php");
					break 1;
				case "503":
					include ("../librerias/garantiaReemplazo.php");
					break 1;
				case "504":
					include ("../librerias/componenteNuevoGarantia.php");
					break 1;
				case "505":
					include ("../librerias/equipoNuevoGarantia.php");
					break 1;
				case "506":
					require_once ("../librerias/garantiaReporte.php");
					break 1;	
				case "507":
					include ("../librerias/componenteNuevoGarantia.php");
					break 1;
				case "600":
					include ("../librerias/requerimientoHardware.php");
					break 1;
				case "601":
					include ("../librerias/requerimientoSoftware.php");
					break 1;
				case "602":
					include ("../librerias/reporteReqHardware.php");
					break 1;														
				case "603":
					include ("../librerias/reporteReqSoftware.php");
					break 1;	
				case "607":
					include ("../librerias/requerimientoSistemaInformacion.php");
					break 1;		
				case "611":
					include ("../librerias/reporteReqSistemaInformacion.php");
					break 1;																
				case "605":
					include ("../librerias/requerimientoOrganizacionProcedimiento.php");
					break 1;		
				case "609":
					include ("../librerias/reporteReqOrganizacionProcedimiento.php");
					break 1;	
				case "604":
					include ("../librerias/requerimientoAplicaciones.php");
					break 1;	
				case "608":
					include ("../librerias/reporteReqAplicaciones.php");
					break 1;	
				case "606":
					include ("../librerias/requerimientoRedes.php");
					break 1;	
				case "610":
					include ("../librerias/reporteReqRedes.php");
					break 1;	
				case "612":
					include ("../librerias/observacion_requerimiento.php");
					break 1;
				case "613":
					require_once("../librerias/despachoEquipos.php");
					break 1;
				case "614":
					require_once("../librerias/despachoComponentesEquipo.php");
					break 1;		
				case "615":
					require_once ("../librerias/despachoComponentesImpresora.php");
					break 1;
				case "616":
					require_once("../librerias/despachosuministros.php");
					break 1;
				case "617":
					include ("../librerias/reporteDespachos.php");
					break 1;
				case "618":
					include ("../librerias/despachoComponentesActualizar.php");
					break 1;
				case "619":
					require_once ("../librerias/usuarioSistemaCambiar.php");
					break 1;
				case "620":
					require_once ("../librerias/despachoSuministrosActualizar.php");
					break 1;
				case "621":
					require_once ("../librerias/despachoEquipos.php");
					break 1;
				case "622":
					require_once ("../librerias/reporteDespachoEquipos.php");
					break 1;													
				case "623":
					require_once ("../librerias/despachoEquiposActualizar.php");
					break 1;
				case "624":
					echo "<script type=\"text/javascript\">
					window.open('../librerias/migracionsoftwareusuario.php')
					</script>";
					break 1;	
				case "625":
					require_once ("../librerias/rptEquiposUsuario.php");
					break 1;					
				case "627":
					require_once ("../librerias/rptDefinirHistorialPedidos.php");
					break 1;
				case "628":
					require_once ("../librerias/rptEquiposPlanta.php");
					break 1;	
				case "629":
					require_once ("../librerias/rptEquiposHistorialPedidos.php");
					break 1;	
				case "630":
					require_once ("../librerias/rptHistorialPedidos.php");
					break 1;		
				case "631":
					require_once ("../librerias/rptComponenteFaltanteporEquipoComp.php");
					break 1;	
				case "632":
					require_once ("../librerias/rptDefinirComponenteEquipo.php");
					break 1;	
				case "633":
					require_once ("../librerias/rptComponenteporEquipoComp.php");
					break 1;	
				case "634":
					require_once ("../librerias/rptResumenComponenteporEquipoComp11.php");
					break 1;	
				case "636":
					require_once ("../librerias/rptHojasImpresas.php");
					break 1;					
				case "420":
					require_once ("../librerias/rptEjecucionEdificios.php");
					break 1;					
				case "421":
					require_once ("../librerias/mantenimientoEliminar.php");
					break 1;					
				case "422":
					require_once ("../librerias/rptPreventivoGlobal.php");
					break 1;
				case "423":
					require_once("../librerias/rptPreventivoDetallado.php");
					break 1;
					
				case "424":
					require_once("../librerias/rptMemoriaEdificios.php");
					break 1;
				case "425":
					require_once("../librerias/rptMantenimientoCantidad.php");
					break 1;
					
				case "426":
					require_once("../librerias/rptEquiposFaltantesPorEdificio.php");
					break 1;
					
				case "427":
					require_once("../librerias/rptEquiposFaltantes.php");
					break 1;
					
				case "428":
					require_once("../librerias/rptInventarioInicial.php");
					break 1;
				
				case "429":
					require_once("../librerias/rptVidaUtilComponente.php");
					break 1;
					
					
				case "430":
					require_once("../librerias/rptInventarioEquiposUsuario.php");
					break 1;
					
				case "431":
					require_once("../librerias/rptVidaUtilEquipo.php");
					break 1;
					
				
					
				case "433":
					require_once("../librerias/rptVidaUtilEquipo.php");
					break 1;
					
				case "704":
					require_once("../librerias/rptDespachosComp-Eq.php");
					break 1;
				
				
				case "434":
					require_once("../librerias/rptEquiposyComponentesDescontinuados.php");
					break 1;
					
					
				case "435":
					require_once("../librerias/rptPuntosPendiente.php");
					break 1;	


				case "700":
					require_once("../librerias/asistencia_personal.php");
					break 1;			
				
				case "701":
					require_once("../librerias/asistencia_pdf.php");
					break 1;
				
				default:
					include ("principal.php");
					
			}
//		}
		?>
