<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Grafico Equipos Faltantes por Edificio</title>

		<script src="highcharts/js/jquery.js"></script>
		
<?php
require_once("mantenimientoAdmin.php");
require_once("conexionsql.php");

	$sitio=isset($_GET['sitio'])&&$_GET['sitio']!=100  ? " AND ID_SITIO='".$_GET['sitio']."'" : "";
	
	$mes=isset($_GET['mes'])&&$_GET['mes']!=100 ? " AND MONTH(fecha_inicio)=".$_GET['mes'] : "";	
	
	$anno=isset($_GET['anno'])&&$_GET['anno']!=100 ? "AND YEAR(fecha_inicio)=".$_GET['anno'] : "";
	
	conectarMysql();
	
	$query="SELECT descripcion ,COUNT(descripcion)".  
	"
	FROM vistainventarioequipos
	WHERE (descripcion = 'MICROCOMPUTADOR' or descripcion = 'IMPRESORA' or descripcion = 'LAPTOP' or descripcion = 'PLOTTER' ) 	
	 $sitio
	GROUP BY descripcion";
	
	


		
		
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
                text: 'Inventario Inicial por Edificio'
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
                            return '<b>'+ this.point.name +'</b>: '+ this.y +': '+Math.round(this.point.percentage*Math.pow(10,2))/Math.pow(10,2)+ '%';
                            
                            
                        }
                    }
                }
            },
        series: [{   
			 type: 'pie',
                name: 'Equipos',
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
