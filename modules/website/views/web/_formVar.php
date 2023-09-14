<?php 
    use yii\bootstrap5\ActiveForm; 
?>

<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'options' => [
        'class' => 'form-horizontal'
    ],
    'fieldConfig' => [
        //'template' => '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}</div>',
        'template' => '<div class="col-sm-12">{input}{error}</div>',
        'labelOptions' => ['class' => 'col-md-12 control-label'],
    ],
]); ?>

<?php /* ?>
<?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'id_website')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'id_template_varible')->textInput(['maxlength' => true]) ?>
<?php */ ?>
<?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
    
<?php ActiveForm::end(); ?>