<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\LoaiBaoGia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loai-bao-gia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $model->id>3 ? $form->field($model, 'code')->textInput(['maxlength' => true]) : '' ?>

    <?= $form->field($model, 'ten_loai_bao_gia')->textInput(['maxlength' => true]) ?>

     <?= $model->isNewRecord ? 
         $form->field($model, 'nhom_bao_gia')->dropDownList($model->dsNhomBaoGia(), ['prompt'=>'--Chọn--']) 
         : '' ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Ghi dữ liệu' : 'Cập nhật dữ liệu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
