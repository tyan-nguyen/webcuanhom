<?php
use app\modules\maucua\models\NhomSuDung;

$nhomsds = NhomSuDung::find([
    'id_mau_cua'=>$model->id
])->all();

foreach($nhomsds as $i=>$nhomsd){
    echo '<br/>----cay nhom 1: con lai '.$nhomsd->chieu_dai_con_lai ;
    foreach($nhomsd->chiTiet as $ict=>$nhomct){
        echo '+'. $nhomct->nhomToiUu->mauCuaNhom->chieu_dai;
    }
}

?>