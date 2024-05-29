<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\banle\models\HoaDon */
?>
<div class="hoa-don-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ma_hoa_don',
            'so_vao_so',
            'nam',
            'ghi_chu:ntext',
            'id_nguoi_lap',
            'ngay_lap',
            'trang_thai',
            'date_created',
            'user_created',
        ],
    ]) ?>

</div>
