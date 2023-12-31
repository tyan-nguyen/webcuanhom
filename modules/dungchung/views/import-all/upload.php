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
            'template' => '<div class="col-sm-2">{label}</div><div class="col-sm-10">{input}{error}</div>',
            'labelOptions' => ['class' => 'col-md-12 control-label'],
        ],
    ]); ?>
    
    <?= $form->field($model, 'file')->fileInput() ?>
	
	<?php 
	if($showOverwrite == true){
	    echo $form->field($model, 'isOverwrite')->checkbox();
	}
	?>

    <?php ActiveForm::end(); ?>
    
</div>
