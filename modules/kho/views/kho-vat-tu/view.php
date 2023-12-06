<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kho\models\KhoVatTu */
?>
<div class="kho-vat-tu-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'code',
            'ten_vat_tu',
            'id_nhom_vat_tu'=>[
                'attribute'=>'id_nhom_vat_tu',
                'value'=>$model->getDmNhomVatTuLabel($model->id_nhom_vat_tu)
            ],
            'la_phu_kien'=>[
                'attribute'=>'la_phu_kien',
                'value'=>$model->la_phu_kien==1 ? 'Là phụ kiện' : 'Không'
            ],
            'so_luong'=>[
                'attribute'=>'so_luong',
                'value'=>function($model){
                    if ((int) $model->so_luong == $model->so_luong) {
                        //is an integer
                        return number_format($model->so_luong);
                    } else {
                        return number_format($model->so_luong, 2);
                    }
                }
            ],
            'dvt'=>[
                'attribute'=>'dvt',
                'value'=>$model->donViTinh->ten_dvt
            ],
            'don_gia'=>[
                'attribute'=>'don_gia',
                'value'=>number_format($model->don_gia)
            ],
            'date_created',
            //'user_created',
        ],
    ]) ?>

</div>
