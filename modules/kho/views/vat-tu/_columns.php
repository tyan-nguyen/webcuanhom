<?php
use yii\helpers\Url;
use yii\helpers\Html;
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
        'attribute'=>'code',
        'group'=>true,
        'contentOptions'=>['style'=>'vertical-align:middle;']
    ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'code',
        'format'=>'raw',
        'value'=>'showAction'
    ], */
    [
        'class'=>'\kartik\grid\DataColumn',
        //'attribute'=>'code',
        'label'=>'Màu',
        'format'=>'raw',
        //'value'=>'showColor'
        'value'=>function($model){
            return $model->id_he_mau ? Html::a($model->showColor,
                [Yii::getAlias('@web/maucua/he-mau/view'), 'id'=>$model->id_he_mau],
                ['role'=>'modal-remote', 'class'=>'aInGrid']) : $model->showColor;
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ten_vat_tu',
        'format'=>'raw',
        'value'=>function($model){
            return Html::a($model->ten_vat_tu . ($model->heMau?(' <span style="color:'.$model->heMau->ma_mau.'">('.$model->heMau->code.')</span>'):''),
                [Yii::getAlias('@web/kho/vat-tu/view'), 'id'=>$model->id],
                ['role'=>'modal-remote', 'class'=>'aInGrid']);
        },
        ],
    /* [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_nhom_vat_tu',
        'filter'=>Html::activeDropDownList($searchModel, 'id_nhom_vat_tu', $searchModel->getDmNhomVatTu(), ['prompt'=>'--Chọn--', 'class'=>'form-control']),
        'value'=>function($model){
            return $model->getDmNhomVatTuLabel($model->id_nhom_vat_tu);
        }
    ], */
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
                    'text'=>'Thêm vật tư cùng mã khác màu',
                    'url' => Yii::getAlias('@web/kho/vat-tu/add-color?id='.$model->id)
                ]
            ]
        ]);
        }
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