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
            'ghi_chu:ntext',
            'date_created',
            //'user_created',
        ],
    ]) ?>

</div>
