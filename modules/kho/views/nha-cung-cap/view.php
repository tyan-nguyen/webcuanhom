<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kho\models\NhaCungCap */
?>
<div class="nha-cung-cap-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'ten_nha_cung_cap',
            'dia_chi:ntext',
            'date_created',
            'user_created',
        ],
    ]) ?>

</div>
