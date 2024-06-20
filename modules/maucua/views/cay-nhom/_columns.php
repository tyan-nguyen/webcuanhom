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
        'attribute'=>'id_he_nhom',
        'value'=>'heNhom.code'
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ten_cay_nhom',
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'so_luong',
        'value'=>function($model){
            return number_format($model->soLuongNhomMoi);
        },
        'contentOptions'=>['style'=>'text-align:center']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'chieu_dai',
        'contentOptions'=>['style'=>'text-align:center']
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
         'attribute'=>'khoi_luong',
     ],
     
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'do_day',
     ],

     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'for_cua_so',
         'label'=>'Cửa sổ',
         'value'=>function($model){
            return $model->for_cua_so==true ? 'YES' : '';
         },
         'contentOptions'=>['style'=>'text-align:center']
     ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'for_cua_di',
         'label'=>'Cửa đi',
         'value'=>function($model){
            return $model->for_cua_di==true ? 'YES' : '';
         },
         'contentOptions'=>['style'=>'text-align:center']
     ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'min_allow_cut',
         'label'=>'Chặn trên',
         'contentOptions'=>['style'=>'text-align:center']
     ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'min_allow_cut_under',
         'label'=>'Chặn dưới',
         'contentOptions'=>['style'=>'text-align:center']
     ],
     
     /* [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'heNhom.xuatXu.ten_xuat_xu',
      'value'=>'heNhom.xuatXu.ten_xuat_xu'
      ], */
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'heNhom.hang_san_xuat',
         'value'=>'heNhom.hang_san_xuat'
     ],
         
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