<?php 

$array[] = array('x' => "puta", 'code'=>1); 
$array[] = array('x' => 2, 'code'=>1); 
$array[] = array('x' => 1, 'code'=>1); 
$array[] = array('x' => "puta", 'code'=>1); 
$array[] = array('x' => 2, 'code'=>5); 
$array[] = array('x' => 1, 'code'=>2); 
$array[] = array('x' => 3, 'code'=>2); 

//usage 
print_r(multiSort($array, 'x', 'code')); 

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
?> 