<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\LoaiCua */
?>
<div class="loai-cua-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'code',
            'ten_loai_cua',
            'ghi_chu:ntext',
            'date_created',
            //'user_created',
        ],
    ]) ?>

</div>
