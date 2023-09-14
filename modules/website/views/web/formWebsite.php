<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\template\models\Template;

/** @var yii\web\View $this */
/** @var app\modules\template\models\TemplatePages $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="template-pages-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id_template')->dropDownList(
         Template::getList(),
        ['prompt'=>'-Chọn-']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>