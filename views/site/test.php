<?php

function getKey($arr, $field, $value)
{
    foreach($arr as $key => $ar)
    {
        if ( $ar[$field] === $value )
            return $key;
    }
    return false;
}

$array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');

$key = array_search('green', $array); // $key = 2;
//echo $key;

//echo '-';
$key = array_search('red', $array);   // $key = 1;

//echo $key;


$arr = array(
    1 => [
        'id-cua-nhom' => 1,
        'id-cay-nhom'=>123,
        'chieu-dai'=>5.5,
        'kieu-cat'=>'//===\\',
        'id_kho'=>'',
        'group'=>'g1'
        
    ],
    2 => [
        'id-cua-nhom' => 2,
        'id-cay-nhom'=>123,
        'chieu-dai'=>5.91,
        'kieu-cat'=>'/|===\\',
        'id_kho'=>'',
        'group'=>'g2'
        
    ],
    3 => [
        'id-cua-nhom' => 2,
        'id-cay-nhom'=>123,
        'chieu-dai'=>5.9,
        'kieu-cat'=>'/|===\\',
        'id_kho'=>'',
        'group'=>'g1'
        
    ]
);
//echo '-';
//$key = array_search(5.5, array_column($arr, 'chieu-dai'));   // $key = 1;
echo getKey($arr, 'chieu-dai', 5.9);
?>