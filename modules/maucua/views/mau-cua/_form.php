<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\widgets\forms\ImageWidget;
use app\modules\maucua\models\MauCua;
use app\modules\maucua\models\DuAn;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\MauCua */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mau-cua-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
    	<div class="col-md-6">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($model, 'ten_cua')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($model, 'kich_thuoc')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($model, 'id_he_nhom')->textInput() ?>
            
            <?= $form->field($model, 'id_loai_cua')->textInput() ?>
        
            <?= $form->field($model, 'id_parent')->textInput() ?>
            
            <?= $form->field($model, 'id_du_an')->dropDownList((new DuAn())->getList(), ['prompt'=>'--Select--']) ?>
            
            <?= $form->field($model, 'so_luong')->textInput() ?>
            
            <?= $form->field($model, 'status')->dropDownList((new MauCua())->getDmTrangThai(), ['prompt'=>'--Select--']) ?>
        </div>
        <div class="col-md-6">
            <p class="text-muted card-sub-title mt-1">
        		<?= $model->isNewRecord ? 'Vui lòng bấm lưu lại để tải ảnh lên' : 'Chọn file hình ảnh.' ?>
        	</p>
	
        	<?php if(!$model->isNewRecord): ?>
            
            <?= ImageWidget::widget([
                'loai' => MauCua::MODEL_ID,
                'id_tham_chieu' => $model->id
            ]) ?>
            
            <?php endif; ?>
       </div>
	</div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Ghi dữ liệu' : 'Cập nhật dữ liệu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
