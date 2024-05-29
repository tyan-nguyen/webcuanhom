<?php
use app\modules\maucua\models\MauCua;
use app\modules\maucua\models\ToiUuNhom;
use app\modules\maucua\models\KhoNhom;
use app\modules\maucua\models\NhomSuDung;
use app\modules\maucua\models\NhomSuDungChiTiet;

$mauCuaModel = MauCua::findOne(44);

//$mauCuaModel->deleteNhomSuDung();

$dsSuDung = $mauCuaModel->dsSuDung();
$dsToiUu = $mauCuaModel->dsToiUu();


var_dump($dsSuDung);

//var_dump($dsToiUu);
$newarray = array();
foreach($dsToiUu as $key => $value){
    $newarray[$value['idTonKhoNhom']][$key] = $value;
}

foreach ($newarray as $vI => $v){
    echo '<br/>Cây nhôm:' . $vI;
    echo '<br/>Số lượng:' . sizeof($v);
}