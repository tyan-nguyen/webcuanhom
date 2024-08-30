<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\maucua\models\HeNhom;
use app\widgets\BtnBackWidget;

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
        'attribute'=>'id_he_nhom',
        'format'=>'raw',
        //'value'=>'heNhom.code',
        'value'=>function($model){
            return Html::a($model->heNhom->code,
                [Yii::getAlias('@web/maucua/he-nhom/view'), 'id'=>$model->id_he_nhom],
                ['role'=>'modal-remote', 'class'=>'aInGrid']);
        },
        'filter'=>Html::activeDropDownList($searchModel, 'id_he_nhom', HeNhom::getList(), [
            'prompt'=>'-Tất cả-',
            'class'=>'form-control'
        ]),
        'group'=>true,
        //'width'=> '100px',
        'contentOptions'=>['style'=>'vertical-align:middle;']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'code',
        //'format'=>'raw',
        //'value'=>'showAction',
        'group'=>true,
        //'width'=> '100px',
        'contentOptions'=>['style'=>'vertical-align:middle;']
    ],
   
    /*[
        'class'=>'\kartik\grid\DataColumn',
        //'attribute'=>'code',
        'label'=>'Mã nhôm',
        'format'=>'raw',
        //'value'=>'showAction',
        'value'=>function($model){
            return $model->heMau->code;
            //return Html::a($model->heMau->code,
            //    [Yii::getAlias('@web/maucua/cay-nhom/view'), 'id'=>$model->id],
            //    ['role'=>'modal-remote', 'class'=>'aInGrid']);
        },
        //'width'=> '200px',
        'contentOptions'=>['style'=>'vertical-align:middle;']
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        //'attribute'=>'code',
        'label'=>'Màu',
        'format'=>'raw',
        //'value'=>'showColor'
        'value'=>function($model){
            return $model->id_he_mau ? Html::a($model->showColor,
                [Yii::getAlias('@web/maucua/he-mau/view'), 'id'=>$model->id_he_mau],
                ['role'=>'modal-remote', 'class'=>'aInGrid']) : '';
        },
    ],    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ten_cay_nhom',
        'format'=>'raw',
        'value'=>function($model){
        return Html::a($model->ten_cay_nhom . ($model->heMau?(' <span style="color:'.$model->heMau->ma_mau.'">('.$model->heMau->code.')</span>'):''),
                [Yii::getAlias('@web/maucua/cay-nhom/view'), 'id'=>$model->id],
                ['role'=>'modal-remote', 'class'=>'aInGrid']);
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'do_day',
        'value'=>function($model){
            return $model->do_day . ' mm';
        },
        'contentOptions'=>['style'=>'text-align:center']
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
         
     /* [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'heNhom.hang_san_xuat',
         'value'=>'heNhom.hang_san_xuat'
     ], */
     
         
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'date_created',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'user_created',
    // ],
    
       [
           'class'=>'\kartik\grid\DataColumn',
           'attribute'=>'id',
           'label'=>'',
           'format'=>'raw',
           'filter'=>false,
           'value'=>function($model){
               return BtnBackWidget::widget([
                   'linkList'=>[
                       [
                           'icon'=>'<i class="fa-solid fa-circle-plus"></i>',
                           'text'=>'Thêm cây nhôm cùng mã khác màu',
                           'url' => Yii::getAlias('@web/maucua/cay-nhom/add-color?id='.$model->id)
                       ]
                   ]
               ]);
           }
       ],
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