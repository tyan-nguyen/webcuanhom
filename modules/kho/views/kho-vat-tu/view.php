<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kho\models\KhoVatTu */
?>
<div class="kho-vat-tu-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'ten_vat_tu',
            'id_nhom_vat_tu',
            'la_phu_kien',
            'so_luong',
            'dvt',
            'don_gia',
            'date_created',
            'user_created',
        ],
    ]) ?>

</div>
