<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Grafico preventido Detallado</title>

		<script src="highcharts/js/jquery.js"></script>
		
<?php
require_once("mantenimientoAdmin.php");
require_once("conexionsql.php");


	$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND mantenimiento_preventivo.ID_SITIO='".$_GET['sitio']."'" : "";
	
	$mes=isset($_GET['mes'])&&$_GET['mes']!=100 ? " AND MONTH(mantenimiento_preventivo.HORA_INICIO)=".$_GET['mes'] : "";	
	
	$anno=isset($_GET['anno'])&&$_GET['anno']!=100 ? "AND YEAR(mantenimiento_preventivo.HORA_INICIO)=".$_GET['anno'] : "";
	
	
conectarMysql();


	$query="SELECT usuario_sistema.NOMBRE, COUNT(usuario_sistema.ID_USS) AS 'CANTIDAD DE MANTENIMIENTOS'".
	"
		FROM usuario_sistema,mantenimiento_preventivo
		WHERE usuario_sistema.ID_USS=mantenimiento_preventivo.ID_USS
		 $sitio $mes $anno
		GROUP BY usuario_sistema.ID_USS";	
		
		
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
                text: 'Grafico de Mantenimientos Detallado '
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
                name: 'Porcentaje de Mantenimientos',
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
