<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\HeMau */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="he-mau-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ten_he_mau')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'ma_mau')->textInput(['maxlength' => true]) ?>
    <label>Mã màu</label>
    <input type="color" id="favcolor" name="HeMau[ma_mau]" value="<?= $model->ma_mau ?>">

    <?= $form->field($model, 'for_nhom')->checkbox() ?>

    <?= $form->field($model, 'for_phu_kien')->checkbox() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Ghi dữ liệu' : 'Cập nhật dữ liệu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
