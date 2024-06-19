<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\HeNhom */
?>
<div class="he-nhom-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'code',
            'ten_he_nhom',
            [
                'attribute' => 'xuat_xu',
                'value' => $model->xuatXu->ten_xuat_xu
            ],
            'hang_san_xuat',
            'nha_cung_cap',
            'do_day_mac_dinh',
            'ghi_chu:ntext',
            'date_created',
            //'user_created',
        ],
    ]) ?>

</div>
