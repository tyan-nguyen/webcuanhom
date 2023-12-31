<?php
use yii\helpers\Url;
use yii\helpers\Html;

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
        'attribute'=>'ten_vat_tu',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_nhom_vat_tu',
        'filter'=>Html::activeDropDownList($searchModel, 'id_nhom_vat_tu', $searchModel->getDmNhomVatTu(), ['prompt'=>'--Chọn--', 'class'=>'form-control']),
        'value'=>function($model){
            return $model->getDmNhomVatTuLabel($model->id_nhom_vat_tu);
        }
    ],
/*     [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'la_phu_kien',
    ], */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_luong',
        'value'=>function($model){
            //if we already know $number is numeric
            if ((int) $model->so_luong == $model->so_luong) {
                //is an integer
                return number_format($model->so_luong);
            } else {
                return number_format($model->so_luong, 2);
            }
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'dvt',
        'value'=>function($model){
            return $model->donViTinh->ten_dvt;
        }
    ],
    [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'don_gia',
         'value'=>function($model){
            return number_format($model->don_gia);
         }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_created',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'user_created',
    // ],
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