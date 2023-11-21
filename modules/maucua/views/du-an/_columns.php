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
        'format' => 'raw',
        'value'=>function($model){
                return '<div class="btn-group dropend">
                  <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="font-size:12px;padding:3px 5px;background-color:#48728c;">
                    <i class="fa-solid fa-gear"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li style="border-bottom:1px solid black;"><a class="dropdown-item" href="#"><strong>Cấu hình dự án</strong></a></li>
                   
                    <li><a role="modal-remote" class="dropdown-item" href="/maucua/du-an/view?id='.$model->id.'"><i class="fa-solid fa-square-up-right"></i> Mở dự án</a></li>
                    <li><a role="modal-remote" class="dropdown-item" href="/maucua/du-an/update?id='.$model->id.'"><i class="fa-solid fa-file-pen"></i> Chỉnh sửa dự án</a></li>
                    <li><a role="modal-remote" data-pjax="0" class="dropdown-item" href="/maucua/du-an/delete?id='.$model->id.'" data-request-method="post" data-toggle="tooltip" data-confirm-title="Comfirm Delete?" data-confirm-message="Are you sure to delete this data?" ><i class="fa-solid fa-delete-left" style="color:red"></i> Xóa dự án</a></li>

                     <li><a class="dropdown-item" href="#"><i class="fa-solid fa-gears"></i> Thay đổi thông số</a></li>
                  </ul>
                </div>';
            }
        ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'code',
        'format'=>'raw',
        'value'=>'showAction',
        'width'=> '100px',
        'contentOptions'=>['style'=>'text-align:center;']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ten_du_an',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ten_khach_hang',
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
        // 'attribute'=>'trang_thai',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ngay_tao_du_an',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ngay_bat_dau_thuc_hien',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ngay_hoan_thanh_du_an',
    // ],
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