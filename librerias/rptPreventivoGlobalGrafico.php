<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Grafico  de Manenimientos Global </title>

		<script src="highcharts/js/jquery.js"></script>
		
<?php
require_once("mantenimientoAdmin.php");
require_once("conexionsql.php");
require_once "formularios.php";
//	$mantenimiento= new mantenimiento();
	$campos="SITIO";
	$suma="";
	
		
	$anno=isset($_GET['anno'])&&$_GET['anno']!=100 ? " WHERE ANNO=".$_GET['anno'] : "";
	
		
		
	if ($_GET['mes']==100){
		$campos.=", ENERO,FEBRERO,MARZO,ABRIL,MAYO,JUNIO,JULIO,AGOSTO,SEPTIEMBRE,OCTUBRE,NOVIEMBRE,DICIEMBRE ";
		$suma.=", ENERO+FEBRERO+MARZO+ABRIL+MAYO+JUNIO+JULIO+AGOSTO+SEPTIEMBRE+OCTUBRE+NOVIEMBRE+DICIEMBRE AS TOTAL";
	}else{
				switch($_GET['mes']){
			case "1":
					$campos.=", ENERO ";
					break 1;
			case "2":
					$campos.=", FEBRERO ";
					break 1;
			case "3":
					$campos.=", MARZO ";
					break 1;
			case "4":
					$campos.=", ABRIL ";
					break 1;
			case "5":
					$campos.=", MAYO ";
					break 1;
			case "6":
					$campos.=", JUNIO ";
					break 1;
			case "7":
					$campos.=", JULIO ";
					break 1;
			case "8":
					$campos.=", AGOSTO ";
					break 1;
			case "9":
					$campos.=", SEPTIEMBRE ";
					break 1;					
			case "10":
					$campos.=", OCTUBRE ";
					break 1;
			case "11":
					$campos.=", NOVIEMBRE ";
					break 1;					
			case "12":
					$campos.=", DICIEMBRE ";
					break 1;					
		}
	}
		
		
		
	
	$vistaNOINTRUSIVA="(SELECT  sitio.SITIO,    
        
        COUNT(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 1 THEN 1                           
            END        
        )AS ENERO,
        
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 2 THEN 1           
                ELSE 0
            END        
        )AS FEBRERO,
        
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 3 THEN 1           
                ELSE 0
            END        
        )AS MARZO,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 4 THEN 1           
                ELSE 0
            END        
        )AS ABRIL,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 5 THEN 1           
                ELSE 0
            END        
        )AS MAYO,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 6 THEN 1           
                ELSE 0
            END        
        )AS JUNIO,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 7 THEN 1           
                ELSE 0
            END        
        )AS JULIO,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 8 THEN 1           
                ELSE 0
            END        
        )AS AGOSTO,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 9 THEN 1           
                ELSE 0
            END        
        )AS SEPTIEMBRE,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 10 THEN 1           
                ELSE 0
            END        
        )AS OCTUBRE,
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 11 THEN 1           
                ELSE 0
            END        
        )AS NOVIEMBRE,
        
        SUM(
            CASE (MONTH(DATE(mantenimiento_preventivo.HORA_INICIO)))
                WHEN 12 THEN 1           
                ELSE 0
            END        
        )AS DICIEMBRE,
        YEAR(DATE(mantenimiento_preventivo.HORA_INICIO)) AS ANNO
        
        




FROM sitio, mantenimiento_preventivo
WHERE sitio.ID_SITIO=mantenimiento_preventivo.ID_SITIO
GROUP BY sitio.SITIO".(empty($anno)? "": ",YEAR(DATE(mantenimiento_preventivo.HORA_INICIO))").
	
	
	"
	) temporal ";

$query="SELECT $campos $suma FROM $vistaNOINTRUSIVA $anno";
	
conectarMysql();
$resultado = mysql_query($query);
mysql_close();
$count = mysql_num_fields($resultado);
$cantidado=$count;
$count=($count<3) ? $count : $count-1;
if($cantidado<3){
	
	$local="data: [";
while($row=mysql_fetch_array($resultado)){	
		if(($row[1]+0)>0)
		$local.="['$row[0]',$row[1]],";
	
}
$local.="]";
	/*
	    series: [{
                type: 'pie',
                name: 'Browser share',
                data: [
                    ['Firefox',   45.0],
                    ['IE',       26.8],
                    {
                        name: 'Chrome',
                        y: 12.8,
                        sliced: true,
                        selected: true
                    },
                    ['Safari',    8.5],
                    ['Opera',     6.2],
                    ['Others',   0.7]
                ]
            }]
	*/
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
                text: 'Grafico de Mantenimientos del Mes ".ucfirst(strtolower(valor_mes($_GET['mes'])))."".($_GET[anno]==100 ? "" : " del Año ".$_GET['anno'])."'
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
	
}else{
	
	$local="data: [";
while($row=mysql_fetch_array($resultado)){	
		if(($row[$count]+0)>0)
		$local.="['$row[0]',".$row[$count]."],";
	
}
$local.="]";
	/*
	    series: [{
                type: 'pie',
                name: 'Browser share',
                data: [
                    ['Firefox',   45.0],
                    ['IE',       26.8],
                    {
                        name: 'Chrome',
                        y: 12.8,
                        sliced: true,
                        selected: true
                    },
                    ['Safari',    8.5],
                    ['Opera',     6.2],
                    ['Others',   0.7]
                ]
            }]
	*/
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
                text: '".($_GET[anno]==100 ? "Historico de Mantenimientos Preventivos" : "Mantenimientos Preventivos del Año ".$_GET['anno'])."'
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

}
?> 

</head>
	<body>
<script src="highcharts/js/highcharts.js"></script>
<script src="highcharts/js/modules/exporting.js"></script>

<div id="container" style="min-width: 400px; height: 900px; margin: 0 auto"></div>

	</body>
</html>

