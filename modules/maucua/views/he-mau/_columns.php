<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'code',
        'format'=>'raw',
        'value'=>'showAction'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ten_he_mau',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ma_mau',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ma_mau',
        'format'=>'html',
        'value'=>function($model){
            return '<span style="background-color:'.$model->ma_mau.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
        },
        'contentOptions'=>['style'=>'text-align:center']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'for_nhom',
        'value'=>function($model){
            return $model->for_nhom==true ? 'YES' : '';
        },
        'contentOptions'=>['style'=>'text-align:center']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'for_phu_kien',
        'value'=>function($model){
            return $model->for_phu_kien==true ? 'YES' : '';
        },
        'contentOptions'=>['style'=>'text-align:center']
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'date_created',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'user_created',
    // ],
    /*[
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Comfirm Delete?',
                          'data-confirm-message'=>'Are you sure to delete this data?'], 
    ],*/

];   