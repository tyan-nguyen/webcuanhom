<?php

use yii\bootstrap5\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\DanhGia */

?>
<div class="danh-gia-create">
    <?= $this->render('_form', [
        'model' => $model,
        'modelMauCua' => $modelMauCua,
        'nguoiDanhGia'=>$nguoiDanhGia
    ]) ?>
</div>
