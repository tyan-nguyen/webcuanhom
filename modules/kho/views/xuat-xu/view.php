<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kho\models\XuatXu */
?>
<div class="xuat-xu-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'code',
            'ten_xuat_xu',
            'ghi_chu:ntext',
        ],
    ]) ?>

</div>
