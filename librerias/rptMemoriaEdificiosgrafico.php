<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Grafico de Capacidad de Memoria por Edificio</title>

		<script src="highcharts/js/jquery.js"></script>
		
<?php
require_once("mantenimientoAdmin.php");
require_once("conexionsql.php");


	$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND sitio.ID_SITIO='".$_GET['sitio']."'" : "";
	conectarMysql();
	
			$query="SELECT CONCAT(modelo.CAP_VEL,modelo.UNIDAD), COUNT(modelo.CAP_VEL)".  
	"
	FROM 
inventario, modelo, sitio, inventario_ubicacion,equipo_componente_campo, inventario_propiedad, inventario_estado,usuario_sistema,componente_campo
WHERE modelo.ID_MODELO=inventario.ID_MODELO AND
inventario_ubicacion.ID_INVENTARIO=inventario.ID_INVENTARIO AND
componente_campo.ID_INVENTARIO=inventario.ID_INVENTARIO AND
inventario_ubicacion.ID_SITIO=sitio.ID_SITIO AND
equipo_componente_campo.ID_INVENTARIO=inventario.ID_INVENTARIO AND
inventario_propiedad.ID_INVENTARIO=inventario.ID_INVENTARIO AND
inventario_estado.ID_ESTADO=inventario_propiedad.ID_ESTADO AND
usuario_sistema.ID_USS=equipo_componente_campo.ID_USS AND
inventario_estado.ESTADO='OPERATIVO'  AND
inventario_ubicacion.STATUS_ACTUAL=1 AND
sitio.SITIO!='OTROS' AND
sitio.SITIO!='DEPOSITO' AND
modelo.ID_DESCRIPCION='DES0000010' $sitio  GROUP BY 	modelo.CAP_VEL";	




		
		
		$resultado = mysql_query($query);

mysql_close();
$count = mysql_num_fields($resultado);
	
	$local="data: [";
while($row=mysql_fetch_array($resultado)){	
		if(($row[$count-1]+0)>0)
		$local.="['$row[0]',".$row[$count-1]."],";
	
}
$local.="]";

	echo "<script type='text/javascript'>
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Grafico de Capacidad de Memoria por Edificio'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    percentageDecimals: 1,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.y +': '+Math.round(this.point.percentage*Math.pow(10,2))/Math.pow(10,2);
                            
                            
                        }
                    }
                }
            },
        series: [{   
			 type: 'pie',
                name: 'Porcentaje de Memorias',
		 $local	
		}]
        });
    });
    
});
		</script>";


?> 

</head>
	<body>
<script src="highcharts/js/highcharts.js"></script>
<script src="highcharts/js/modules/exporting.js"></script>

<div id="container" style="min-width: 400px; height: 900px; margin: 0 auto"></div>

	</body>
</html>
