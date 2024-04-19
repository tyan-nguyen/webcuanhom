<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\LoaiBaoGia */
?>
<div class="loai-bao-gia-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'code',
            'ten_loai_bao_gia',
            'nhom_bao_gia',
            'ghi_chu:ntext',
        ],
    ]) ?>

</div>
