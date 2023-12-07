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
        'attribute'=>'id_cay_nhom',
        'value'=>function($model){
            return $model->cayNhom->ten_cay_nhom;
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'chieu_dai',
        'contentOptions'=>['class'=>'text-center']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_luong',
        'contentOptions'=>['class'=>'text-center']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_created',
        'contentOptions'=>['class'=>'text-center']
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_created',
    ], */
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