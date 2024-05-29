<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\banle\models\KhachHang;

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
        'attribute'=>'ma_hoa_don',
        'format'=>'raw',
        'value'=>function($model){
            return Html::a($model->soHoaDon, ['/banle/hoa-don/update', 'id'=>$model->id], [
                'role'=>'modal-remote',
                'title'=>Yii::t('app', 'Update'),
                'data-toggle'=>'tooltip',
                //'class'=>'btn btn-primary btn-xs'
            ]);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'trang_thai',
        'format'=>'raw',
        'value'=>function($model){
            return '<span class="badge bg-'. ($model->trang_thai=="BAN_NHAP"?'secondary':'primary') .'">' . $model->getDmTrangThaiLabel($model->trang_thai) . '</span>';
        },
        'filter'=>Html::activeDropDownList($searchModel, 'trang_thai', $searchModel->getDmTrangThai(), ['prompt'=>'-Chọn-', 'class'=>'form-control'])
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_khach_hang',
        'value'=>function($model){
            return $model->khachHang != null ? $model->khachHang->ten_khach_hang : '';
        },
        'filter'=>Html::activeDropDownList($searchModel, 'id_khach_hang', KhachHang::getList(), ['prompt'=>'-Chọn-', 'class'=>'form-control'])
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Tổng tiền',
        'value'=>function($model){
            return number_format ( $model->tongTien );
        },
        'contentOptions'=>['style'=>'text-align:right'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_vao_so',
        'contentOptions'=>['style'=>'text-align:center'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nam',
        'contentOptions'=>['style'=>'text-align:center'],
    ],
   /*  [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ghi_chu',
    ], */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_nguoi_lap',
        'value'=>function($model){
            return $model->nguoiTao();
        }
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ngay_lap',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'trang_thai',
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