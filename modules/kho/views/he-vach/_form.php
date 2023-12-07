<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\kho\models\HeVach */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="he-vach-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ten_he_vach')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

    <!--<?= $form->field($model, 'date_created')->textInput() ?>

    <?= $form->field($model, 'user_created')->textInput() ?>-->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Ghi dữ liệu' : 'Cập nhật dữ liệu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
