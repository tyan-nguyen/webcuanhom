<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\banle\models\search\KhachHang $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="khach-hang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_loai_khach_hang') ?>

    <?= $form->field($model, 'ten_khach_hang') ?>

    <?= $form->field($model, 'dia_chi') ?>

    <?= $form->field($model, 'so_dien_thoai') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'ghi_chu') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'user_created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
