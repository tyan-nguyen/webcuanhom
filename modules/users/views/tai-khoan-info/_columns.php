<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\users\models\TaiKhoan;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_user',
        'label'=>'Tên tài khoản',
        'format'=>'raw',
        'value'=>function($model){
            return Html::a($model->taiKhoan?$model->taiKhoan->username:$model->id,
                [Yii::getAlias('@web/users/tai-khoan-info/update'), 'id'=>$model->id_user],
                ['role'=>'modal-remote', 'class'=>'aInGrid']);
        },
        'filter'=>Html::activeDropDownList($searchModel, 'id_user', TaiKhoan::getListTaiKhoan(), [
            'prompt'=>'-Tất cả-',
            'class'=>'form-control'
        ]),
        'contentOptions'=>['style'=>'vertical-align:middle;']
     ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'chuc_vu',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nhan_thong_bao',
        'value'=>function($model){
            return $model->nhan_thong_bao?'YES':'NO';
        },
        'filter'=>Html::activeDropDownList($searchModel, 'nhan_thong_bao', [
            0=>'Không nhận thông báo',
            1=>'Nhận thông báo'
        ], [
            'prompt'=>'-Tất cả-',
            'class'=>'form-control'
        ])
    ],
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