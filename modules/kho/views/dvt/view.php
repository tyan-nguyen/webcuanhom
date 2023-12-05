<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kho\models\DonViTinh */
?>
<div class="don-vi-tinh-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'ten_dvt',
            'date_created',
            'user_created',
        ],
    ]) ?>

</div>
