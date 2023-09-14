<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\template\models\Template */
?>
<div class="template-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'name',
            'summary:ntext',
            'user_created',
            'datetime_created',
        ],
    ]) ?>

</div>
