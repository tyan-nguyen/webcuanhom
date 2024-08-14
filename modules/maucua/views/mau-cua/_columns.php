<?php
use yii\helpers\Url;
use app\custom\CustomFunc;

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
        'format' => 'raw',
        'value'=>function($model){
        return '<div class="btn-group dropend">
                  <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="font-size:12px;padding:3px 5px;background-color:#48728c;">
                    <i class="fa-solid fa-gear"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li style="border-bottom:1px solid black;"><a class="dropdown-item" href="#"><strong>Chọn chức năng</strong></a></li>
                    <li><a data-pjax="0" class="dropdown-item" href="/maucua/bao-gia/index?id='.$model->id.'"><i class="fa-solid fa-square-up-right"></i> Báo giá</a></li>

                  </ul>
                </div>';
        }
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
        'attribute'=>'ten_cua',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'congTrinh.ten_cong_trinh',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'duAn.ten_du_an',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'kich_thuoc',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_he_nhom',
        'value'=>function($model){
            return $model->heNhom->ten_he_nhom;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_loai_cua',
        'value'=>function($model){
            return $model->loaiCua->ten_loai_cua;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngay_yeu_cau',
        'label'=>'Ngày yêu cầu',
        'format'=>'html',
        'value'=>function($model){
            //$custom = new CustomFunc();
            //return $custom->convertYMDToDMY($model->ngay_yeu_cau);
            return '<span '. ($model->ngay_yeu_cau!=null?'style="color:blue"':'') .'>' . $model->getNgayBanGiaoDuKienDMY() . '</span>';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'trangThai',
        'label'=>'Trạng thái sản xuất',
        'format'=>'html',
        'value'=>function($model){
            return $model->trangThaiCua;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thoiHan',
        'label'=>'Thời hạn',
        'format'=>'html',
        'value'=>function($model){
            return $model->trangThaiThoiHan;
        }
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id_parent',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'date_created',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'user_created',
    // ],
   /*  [
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