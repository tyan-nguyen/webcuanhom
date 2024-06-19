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
        'attribute'=>'ten_he_nhom',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'do_day_mac_dinh',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'xuat_xu',
        'value'=>function($model){
            return $model->xuatXu->ten_xuat_xu;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'hang_san_xuat',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nha_cung_cap',
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ghi_chu',
    ], */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_created',
        'value'=>'thoiGianLuu'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_created',
        'value'=>'nguoiLuu'
    ],
    /* [
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
    ], */

];   