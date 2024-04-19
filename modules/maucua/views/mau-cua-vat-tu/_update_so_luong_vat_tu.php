<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\kho\models\DonViTinh */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="don-vi-tinh-form container">

    <?php $form = ActiveForm::begin(); ?>

	<div class="row">
		<div class="col-md-4"><?= $model->khoVatTu->ten_vat_tu ?></div>
		<div class="col-md-4">
    		<?= $form->field($model, 'so_luong')->textInput(['maxlength' => true])->label(false) ?>
    	</div>
    	<div class="col-md-4">(ĐVT: <?= $model->dvt  ?>)</div>
	</div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Ghi dữ liệu' : 'Cập nhật dữ liệu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
