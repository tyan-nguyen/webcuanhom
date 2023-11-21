<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\CayNhom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cay-nhom-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_he_nhom')->textInput() ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ten_cay_nhom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'so_luong')->textInput() ?>

    <?= $form->field($model, 'don_gia')->textInput() ?>

    <?= $form->field($model, 'khoi_luong')->textInput() ?>

    <?= $form->field($model, 'chieu_dai')->textInput() ?>

    <?= $form->field($model, 'for_cua_so')->textInput() ?>

    <?= $form->field($model, 'for_cua_di')->textInput() ?>

    <?= $form->field($model, 'min_allow_cut')->textInput() ?>

    <?= $form->field($model, 'date_created')->textInput() ?>

    <?= $form->field($model, 'user_created')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Ghi dữ liệu' : 'Cập nhật dữ liệu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
