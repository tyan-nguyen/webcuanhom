<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\KhoNhom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kho-nhom-form">

    <?php $form = ActiveForm::begin(); ?>
    
     <?= $form->errorSummary($model) ?>

    <?php // $form->field($model, 'id_cay_nhom')->textInput() ?>

    <?= $form->field($model, 'chieu_dai')->textInput() ?>

    <?= $form->field($model, 'so_luong')->textInput() ?>
    
    <?= $form->field($model, 'noiDung')->textInput() ?>

    <!--<?= $form->field($model, 'date_created')->textInput() ?>

    <?= $form->field($model, 'user_created')->textInput() ?>-->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Ghi dữ liệu' : 'Cập nhật dữ liệu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
