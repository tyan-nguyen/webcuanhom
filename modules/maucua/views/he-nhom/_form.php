<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\kho\models\XuatXu;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\HeNhom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="he-nhom-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ten_he_nhom')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'do_day_mac_dinh')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'xuat_xu')->dropDownList( (new XuatXu())->getList(), [
   	    'prompt'=>'-Chọn-'
   	] ) ?>
   	
   	<?= $form->field($model, 'hang_san_xuat')->textInput(['maxlength' => true]) ?>
   	
   	<?= $form->field($model, 'nha_cung_cap')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Ghi dữ liệu' : 'Cập nhật dữ liệu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
