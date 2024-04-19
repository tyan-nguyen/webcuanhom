<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kho\models\ThuongHieu */
?>
<div class="thuong-hieu-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'code',
            'ten_thuong_hieu',
            'ghi_chu:ntext',
        ],
    ]) ?>

</div>
