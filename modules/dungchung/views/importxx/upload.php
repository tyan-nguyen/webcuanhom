<?php
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\dungchung\models\HinhAnh */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="import-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal',
        'id' => 'file-form', 
        'options' => [
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data',
            //'data-pjax' => 1
        ],
        'fieldConfig' => [
            'template' => '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}</div>',
            'labelOptions' => ['class' => 'col-md-12 control-label'],
        ],
    ]); ?>
    
    <?= $form->field($model, 'file')->fileInput() ?>


    <?php ActiveForm::end(); ?>
    
</div>
