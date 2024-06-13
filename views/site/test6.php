<?php
use app\modules\maucua\models\MauCua;
use app\modules\maucua\models\DuAn;
use app\modules\maucua\models\ToiUu;
use app\modules\maucua\models\NhomSuDung;

//$mauCua = MauCua::findOne(55);

//$mauCua->cao = 1000;

//var_dump($mauCua);

//var_dump($mauCua->dsNhomSuDung);

$duAn = DuAn::findOne(23);
//var_dump($duAn->dsNhomSuDung);

$dsToiUu = ToiUu::find()->alias('t')->joinWith(['mauCua as mc'])->where([
    'mc.id_du_an'=>23,
])->all();

//var_dump($dsToiUu);

$dsSuDung = NhomSuDung::find()->alias('t')->where([
    'id_du_an'=>23
])->all();

//var_dump($dsSuDung);

//search lai de load model moi
$duAn = DuAn::findOne(31);
//xoa nhom su dung neu co ton tai
$duAn->deleteNhomSuDung();