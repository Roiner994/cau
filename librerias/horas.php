<?php 
	function entrada_salida($hora1,$hora2)
	{
		if($hora1<hora2)
			return true;
		else
			return false;
	}

	function redondearsalida($hora){  
    list($h,$m,$s) = explode(":",$hora); 
    if($m > 50) { 
        $m = 0; 
        $h += 1;  
    } else { 
        $m = 0; 
    } 
    $horaIni = "$h:$m:$s"; 
    return (date("H:i:s",strtotime($horaIni)));  
	}

	function redondearentrada($hora){  
    list($h,$m,$s) = explode(":",$hora); 
    if($m > 30) { 
        $m = 0; 
        $h += 1;  
    } else { 
        $m = 0; 
    }
    $s=0; 
    $horaFin = "$h:$m:$s"; 
    return (date("H:i:s",strtotime($horaFin)));  
	}

	function restaHoras($horaIni, $horaFin){ 
        return (date("H", strtotime("00") + strtotime($horaFin) - strtotime($horaIni) )); 
	}

    function multiSort() { 
    //get args of the function 
    $args = func_get_args(); 
    $c = count($args); 
    if ($c < 2) { 
        return false; 
    } 
    //get the array to sort 
    $array = array_splice($args, 0, 1); 
    $array = $array[0]; 
    //sort with an anoymous function using args 
    usort($array, function($a, $b) use($args) { 

        $i = 0; 
        $c = count($args); 
        $cmp = 0; 
        while($cmp == 0 && $i < $c) 
        { 
            $cmp = strcmp($a[ $args[ $i ] ], $b[ $args[ $i ] ]); 
            $i++; 
        } 

        return $cmp; 

    }); 

    return $array; 

    }

    function fecha($fecha)
    {
        $resultado="";
        for ($i=0; $i <strlen($fecha) ; $i++) { 
            if ($fecha[$i]!='-')
                $resultado.=$fecha[$i];
            else
                $resultado.='/';
        }
        return $resultado;
    }

?>