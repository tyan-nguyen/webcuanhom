<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kho\models\HeVach */
?>
<div class="he-vach-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'code',
            'ten_he_vach',
            'ghi_chu:ntext',
            'date_created',
            //'user_created',
        ],
    ]) ?>

</div>
