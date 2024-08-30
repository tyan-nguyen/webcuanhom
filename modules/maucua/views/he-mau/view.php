<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\HeMau */
?>
<div class="he-mau-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'code',
            'ten_he_mau',
            'ma_mau',
            [
                'attribute'=>'ma_mau',
                'format'=>'html',
                'value'=>'<span style="background-color:'.$model->ma_mau.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'
            ],
            'for_nhom'=>[
                'attribute'=>'for_nhom',
                'value'=>$model->for_nhom==true ? 'YES' : ''
            ],
            'for_phu_kien'=>[
                'attribute'=>'for_phu_kien',
                'value'=>$model->for_phu_kien==true ? 'YES' : ''
            ],
            //'date_created',
            //'user_created',
        ],
        'template' => "<tr><th style='width: 40%;'>{label}</th><td class='align-middle'>{value}</td></tr>"
    ]) ?>

</div>
