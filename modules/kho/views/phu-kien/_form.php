<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\kho\models\DonViTinh;
use app\modules\kho\models\XuatXu;
use app\modules\kho\models\ThuongHieu;
use app\modules\maucua\models\HeMau;

/* @var $this yii\web\View */
/* @var $model app\modules\kho\models\KhoVatTu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kho-vat-tu-form container">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ten_vat_tu')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'id_he_mau')->dropDownList((new HeMau())->getListByPhuKien(), ['prompt'=>'--Chọn--']) ?>

    <?= $form->field($model, 'id_nhom_vat_tu')->dropDownList($model->getDmNhomVatTu(), ['prompt'=>'-Chọn-']) ?>

    <?= $form->field($model, 'la_phu_kien')->checkbox() ?>
    
 	<?= $form->field($model, 'thuong_hieu')->dropDownList((new ThuongHieu())->getList(), ['prompt'=>'-Chọn-']) ?>
 
  	<?= $form->field($model, 'model')->textInput() ?>
  
   	<?= $form->field($model, 'xuat_xu')->dropDownList( (new XuatXu())->getList(), [
   	    'prompt'=>'-Chọn-'
   	] ) ?>

    <?= $form->field($model, 'so_luong')->textInput() ?>
	
	<?php 
	   $dvtLabel = $model->getAttributeLabel('dvt') . ' <a href="/kho/dvt/create-popup" role="modal-remote-2" style="padding-left:10px;" title="Thêm đơn vị tính"><i class="fa-solid fa-square-plus"></i></a> <a href="#" onclick="runFunc(0)" style="padding-left:10px;" title="Thêm đơn vị tính"><i class="fa-solid fa-retweet"></i></a>';
	?>
    <?= $form->field($model, 'dvt')->dropDownList((new DonViTinh())->getList(), ['prompt'=>'-Chọn-', 'id'=>'ddl_dvt'])->label($dvtLabel) ?>

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
function runFunc(sendVal){
	var url = '/kho/dvt/refresh-data';
	if(sendVal==null){
		url = url + '?getLastItem=true';
	}
	$.ajax({
        url: url,
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
