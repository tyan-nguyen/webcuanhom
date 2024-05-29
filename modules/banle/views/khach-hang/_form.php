<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\banle\models\LoaiKhachHang;

/* @var $this yii\web\View */
/* @var $model app\modules\banle\models\KhachHang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="khach-hang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_loai_khach_hang')->dropDownList(LoaiKhachHang::getList(), ['prompt'=>'-Chọn-']) ?>

    <?= $form->field($model, 'ten_khach_hang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dia_chi')->textarea(['rows' => 2]) ?>

    <?= $form->field($model, 'so_dien_thoai')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Ghi dữ liệu' : 'Cập nhật dữ liệu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
