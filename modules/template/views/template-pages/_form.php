<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\template\models\TemplatePages $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="template-pages-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id_template')->textInput() ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'file')->textInput(['maxlength' => true]) ?>
    
    <?= $model->isNewRecord ? $form->field($model, 'fileInput')->fileInput() : '' ?>

    <?= $form->field($model, 'is_dynamic')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
