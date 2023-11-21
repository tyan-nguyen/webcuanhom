<?php
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\dungchung\models\HinhAnh */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hinh-anh-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal',
        'id' => 'img-form', 
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
    
    <?= $model->isNewRecord ? $form->field($model, 'file')->fileInput() : '' ?>

    <?= $form->field($model, 'ten_hien_thi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
