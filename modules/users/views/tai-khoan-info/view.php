<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\users\models\TaiKhoanInfo */
?>
<div class="tai-khoan-info-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_user',
            'name',
            'chuc_vu',
        ],
    ]) ?>

</div>
