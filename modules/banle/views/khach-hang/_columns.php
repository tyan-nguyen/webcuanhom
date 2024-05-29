<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\banle\models\LoaiKhachHang;

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
        'attribute'=>'id_loai_khach_hang',
        'value'=>function($model){
            return $model->loaiKhachHang->ten_loai_khach_hang;
        },
        'filter'=>Html::activeDropDownList($searchModel, 'id_loai_khach_hang', LoaiKhachHang::getList(), ['prompt'=>'-Chọn-', 'class'=>'form-control'])
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ten_khach_hang',
        'format'=>'raw',
        'value'=>function($model){
            return Html::a($model->ten_khach_hang, ['/banle/khach-hang/update', 'id'=>$model->id], [
                'role'=>'modal-remote',
                'title'=>Yii::t('app', 'Update'),
                'data-toggle'=>'tooltip',
                //'class'=>'btn btn-primary btn-xs'
            ]);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'dia_chi',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_dien_thoai',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ghi_chu',
    // ],
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