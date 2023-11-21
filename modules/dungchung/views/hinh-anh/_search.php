<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\dungchung\models\HinhAnh */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hinh-anh-search">

    <?php $form = ActiveForm::begin([
        	'id'=>'myFilterForm',
            'method' => 'post',
            'options' => [
                'class' => 'myFilterForm'
            ]
      	]); ?>

    <?= $form->field($model, 'loai')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_tham_chieu')->textInput() ?>

    <?= $form->field($model, 'ten_hien_thi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'duong_dan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ten_file_luu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img_extension')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img_size')->textInput() ?>

    <?= $form->field($model, 'img_wh')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'thoi_gian_tao')->textInput() ?>

    <?= $form->field($model, 'nguoi_tao')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton('Xóa tìm kiếm', ['class' => 'btn btn-outline-secondary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
