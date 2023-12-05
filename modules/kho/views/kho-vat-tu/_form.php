<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\kho\models\DonViTinh;

/* @var $this yii\web\View */
/* @var $model app\modules\kho\models\KhoVatTu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kho-vat-tu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ten_vat_tu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_nhom_vat_tu')->dropDownList($model->getDmNhomVatTu(), ['prompt'=>'-Chọn-']) ?>

    <?= $form->field($model, 'la_phu_kien')->checkbox() ?>

    <?= $form->field($model, 'so_luong')->textInput() ?>
	
	<a href="/kho/dvt/create" role="modal-remote-2">Thêm DVT</a>
	<a href="#" onclick="runFunc()">refresh</a>

    <?= $form->field($model, 'dvt')->dropDownList((new DonViTinh())->getList(), ['prompt'=>'-Chọn-', 'id'=>'ddl_dvt']) ?>

    <?= $form->field($model, 'don_gia')->textInput() ?>

    <!--<?= $form->field($model, 'date_created')->textInput() ?>

    <?= $form->field($model, 'user_created')->textInput() ?>-->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Ghi dữ liệu' : 'Cập nhật dữ liệu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<script>
function runFunc(){
	$.ajax({
        url: '/kho/dvt/refresh-data?getLastItem=true',
        method: 'GET',
        //data: data,
        /* beforeSend: function () {
            beforeRemoteRequest.call(instance);
        }, */
        /* error: function (response) {
            errorRemoteResponse.call(instance, response);
        }, */
        success: function (response) {
            $('#ddl_dvt').html(response);
        },
        contentType: false,
        cache: false,
        processData: false
   });
}
</script>