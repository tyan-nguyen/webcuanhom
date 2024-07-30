<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\custom\CustomFunc;
use app\modules\banle\models\KhachHang;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\DuAn */
/* @var $form yii\widgets\ActiveForm */
$custom = new CustomFunc();
$model->ngay_bat_dau = $custom->convertYMDToDMY($model->ngay_bat_dau);
$model->ngay_hoan_thanh = $custom->convertYMDToDMY($model->ngay_hoan_thanh);
?>

<link href="/js/select2/select2.min.css" rel="stylesheet" />
<script src="/js/select2/select2.min.js"></script>

<style>
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 22px!important;
}
.cong-trinh-form .btn{
    padding:2px 5px;
    font-size:12px;
}
</style>

<div class="cong-trinh-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-12">
                		<?= $form->field($model, 'ten_cong_trinh')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-12">
                		<?= $form->field($model, 'dia_diem')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
               
                <div class="col-md-6">
            		<?= $form->field($model, 'code_mau_thiet_ke')->dropDownList($model->getDmThieKe()) ?>
                </div>
                <div class="row">
                    <!-- <div class="col-md-6">
                		<?= $form->field($model, 'ngay_bat_dau')->textInput() ?>
                    </div>
                    <div class="col-md-6">
                		<?= $form->field($model, 'ngay_hoan_thanh')->textInput() ?>
                    </div> -->
                    
                    <div class="col-md-12">
                    <label>Ngày bắt đầu - Ngày hoàn thành</label>
                    <?php                     	
                    	echo DatePicker::widget([
                    	    'model' => $model, 
                    	    'name' => 'CongTrinh[ngay_bat_dau]',
                    	    'value' => $model->ngay_bat_dau,
                    	    'type' => DatePicker::TYPE_RANGE,
                    	    'name2' => 'CongTrinh[ngay_hoan_thanh]',
                    	    'value2' => $model->ngay_hoan_thanh,
                    	    'separator' => 'đến',
                    	    'pluginOptions' => [
                    	        'autoclose' => true,
                    	        'format' => 'dd/mm/yyyy'
                    	    ]
                    	]);
                    ?>
                    </div>
                </div>
        	</div>
            
        </div>
        
		
    	
    	<div class="col-md-6">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-12">
                    	<?php 
                    	   $khLabel = $model->getAttributeLabel('id_khach_hang') . ' <a href="/banle/khach-hang/create-popup" role="modal-remote-2" style="padding-left:10px;" title="Thêm khách hàng"><i class="fa-solid fa-square-plus"></i></a> <a href="#" onclick="runFunc('.$model->id_khach_hang.')" style="padding-left:10px;" title="Thêm Khách hàng"><i class="fa-solid fa-retweet"></i></a>';
                    	?>
            	
                		<?= $form->field($model, 'id_khach_hang')->dropDownList(KhachHang::getList(), ['prompt'=>'-Chọn-', 'id'=>'ddlKhachHang'])->label($khLabel) ?>
                	</div>
                	<div class="col-md-12">
                		 <?= $form->field($model, 'diaChiKhachHang')->textInput(['id'=>'txtDiaChiKhachHang', 'disabled'=>'disabled'])->label('Địa chỉ') ?>
                	</div>
                	<div class="col-md-12">
                		 <?= $form->field($model, 'sdtKhachHang')->textInput(['id'=>'txtSdtKhachHang', 'disabled'=>'disabled'])->label('Số điện thoại') ?>
                	</div>
                	<div class="col-md-12">
                		 <?= $form->field($model, 'emailKhachHang')->textInput(['id'=>'txtEmailKhachHang', 'disabled'=>'disabled'])->label('Email') ?>
                	</div>
                </div>
              </div>
        </div>

        
        <div class="col-md-12">
        	<?= $form->field($model, 'ghi_chu')->textarea(['id'=>'txtGhiChu', 'rows' => 6]) ?>
        </div>
    </div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Ghi dữ liệu' : 'Cập nhật dữ liệu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<script>
tinyMCE.remove();
tinymce.init({
	branding: false,
  selector: 'textarea#txtGhiChu',
  height: 200,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount'
  ],
  toolbar: 'undo redo | formatselect | ' +
  'bold italic backcolor | alignleft aligncenter ' +
  'alignright alignjustify | bullist numlist outdent indent | ' +
  'removeformat | help',
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
  setup: function (editor) {
	    editor.on('change', function () {
	        tinymce.triggerSave();
	    });
	}
});
//tinyMCE.triggerSave();
</script>

<script>
function getKhachHangAjax(idkh){
    $.ajax({
        type: 'post',
        url: '/banle/hoa-don-chi-tiet/get-khach-hang-ajax?idkh=' + idkh,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#txtDiaChiKhachHang').val(data.diaChiKhachHang);
            	$('#txtSdtKhachHang').val(data.sdtKhachHang);
            	$('#txtEmailKhachHang').val(data.emailKhachHang);
            } else {
            	alert('Thông tin Khách hàng không còn tồn tại trên hệ thống!');
            }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}
$('#ddlKhachHang').select2({
	dropdownParent: $('#ajaxCrudModal'),
  	selectOnClose: true,
  	width: '100%'
});
$('#ddlKhachHang').on("select2:select", function(e) { 
   if(this.value != ''){
   		getKhachHangAjax(this.value);
   } else {
   		$('#txtDiaChiKhachHang').val('');
    	$('#txtSdtKhachHang').val('');
    	$('#txtEmailKhachHang').val('');
   }
});


function runFunc(sendVal){
	var url = '/banle/khach-hang/refresh-data?selected=' + sendVal;
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
            $('#ddlKhachHang').html(response.options);
        },
        contentType: false,
        cache: false,
        processData: false
   });
}
</script>