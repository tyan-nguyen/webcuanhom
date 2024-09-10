<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\maucua\models\CayNhom;

/* @var $this yii\web\View */
/* @var $model app\modules\kho\models\DonViTinh */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- <script src="/js/vue.js"></script>-->
<link href="/js/select2/select2.min.css" rel="stylesheet" />
<script src="/js/select2/select2.min.js"></script>

<style>
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 22px!important;
}
</style>

<div class="don-vi-tinh-form container">

    <?php $form = ActiveForm::begin(); ?>

	<div class="row">
		<div class="col-md-12">
    		Thay đổi cây nhôm cho mẫu cửa: <strong><?= $model->mauCua->code ?></strong>
    		<br/>Công trình/Dự án: <?= $model->mauCua->congTrinh->ten_cong_trinh ?>
    		<br/>Khách hàng: <?= $model->mauCua->congTrinh->khachHang->ten_khach_hang ?>
		</div>
	</div>
	<div class="row">
		<div class="alert alert-warning g-2" role="alert">
          Yêu cầu: Chỉ sử dụng cho trường hợp thay đổi cây nhôm dùng chung cho nhiều hệ nhôm (ví dụ: nẹp...)
        </div>
	</div>
	
	<hr/>
	<div class="row">
		<div class="col-md-5">
			Từ cây nhôm: <strong><?= $oldModel->cayNhom->code ?></strong>
			<br/>Tên cây nhôm: <?= $oldModel->cayNhom->tenCayNhomByColor ?>
			<br/>Hệ nhôm: <strong><?= $oldModel->cayNhom->heNhom->code ?></strong> (<?= $model->cayNhom->heNhom->ten_he_nhom ?>)
			<br/>Độ dày: <?= $oldModel->cayNhom->do_day ?> (mm)
			<br/>Số lượng tồn kho:
			<ul>
			<?php 
			foreach ($oldModel->cayNhom->tonKho as $tkn){
			?>
			<li>Chiều dài <?= number_format($tkn->chieu_dai) ?> (mm) : <?= $tkn->so_luong ?> (cây)</li>
			<?php } ?>
			</ul>
			<div class="text-danger">
				<?= $form->field($model, 'xoaCayNhomNguon')->checkbox() ?>
			</div>
			<div class="text-danger">
				<?= $form->field($model, 'capNhatChoNhomCungMa')->checkbox() ?>
			</div>
		</div>
		<div class="col-md-2 text-center" style="padding-top:50px">
			<i class="fs-3 fa-solid fa-circle-arrow-right"></i>
		</div>
		<div class="col-md-5">
			<?= $form->field($model, 'id_cay_nhom')->dropDownList(CayNhom::getListForMulti(), ['prompt'=>'-Chọn-', 'id'=>'ddlCayNhom']) ?>
			<div id="dNhomTarget"></div>
			
		</div>
	</div>


    <?php ActiveForm::end(); ?>
    
</div>

<script>

function getNhomInfoAjax(id){
    $.ajax({
        type: 'post',
        url: '/maucua/cay-nhom/get-nhom-ajax?id=' + id,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#dNhomTarget').html(data.html);
            } else {
            	$('#dNhomTarget').html('Thông tin bạn chọn không tìm thấy hoặc có lỗi!');
            }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}
$('#ddlCayNhom').select2({
	dropdownParent: $('#ajaxCrudModal2'),
  	selectOnClose: true,
  	allowClear: true,
    placeholder: "Chọn cây nhôm",
  	width: '100%'
});
$('#ddlCayNhom').on("select2:select", function(e) { 
   if(this.value != ''){
   		getNhomInfoAjax(this.value);
   } else {
   		$('#dNhomTarget').html('');
   }
});
</script>
