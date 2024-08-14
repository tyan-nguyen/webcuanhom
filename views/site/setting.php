<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
?>

<div class="setting-form">

	<?php 
	if(isset($message)){
	?>
	<div class="alert alert-primary d-flex align-items-center" role="alert">
      <i class="fa-solid fa-check"></i>
      <div>
        &nbsp;<?= $message ?>
      </div>
    </div>
	<?php } ?>
	
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cho_phep_nhap_kho_am')->checkbox() ?>
    <?= $form->field($model, 'an_kho_nhom_bang_khong')->checkbox() ?>
    
    <?= $form->field($model, 'vet_cat')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'chieu_dai_nhom_mac_dinh')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'so_ngay_canh_bao_giao_cua')->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
