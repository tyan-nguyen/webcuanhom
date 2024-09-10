<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\modules\users\models\TaiKhoan;
use app\widgets\views\ImageListWidget;
use app\modules\maucua\models\MauCua;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\DanhGia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="danh-gia-form">
	
    <?php $form = ActiveForm::begin(); ?>

	<div class="row">
		<div class="col-md-12">
			<?= $form->errorSummary($model) ?>
		</div>
		<div class="col-md-4">
			<h4>THÔNG TIN MẪU CỬA</h3>
			 <?= ImageListWidget::widget([
        	    'loai' => MauCua::MODEL_ID,
        	    'id_tham_chieu' => $modelMauCua->id
        	]) ?>		
    		<ul>
    			<li>Mã mẫu cửa: <strong><?= $modelMauCua->code ?></strong></li>
    			<li>Tên mẫu cửa: <strong><?= $modelMauCua->ten_cua ?></strong></li>
    			<li>Kích thước: <strong><?= $modelMauCua->kich_thuoc ?></strong></li>
    			<li>Hệ nhôm: <strong><?= $modelMauCua->heNhom?$modelMauCua->heNhom->ten_he_nhom:'' ?></strong></li>
    			<li>Kế hoạch sản xuất: <strong><?= $modelMauCua->duAn?$modelMauCua->duAn->ten_du_an:'' ?></strong></li>
    		</ul>
		</div>
		<div class="col-md-4">
			<h4>THÔNG TIN ĐÁNH GIÁ</h3>
            <?php /* $form->field($model, 'id_nguoi_danh_gia')->dropDownList(TaiKhoan::getListTaiKhoan(), [
                'prompt' => '-Chọn-'
            ])*/ ?>
        
            <?php 
            if($model->isNewRecord){
                echo $form->field($model, 'ten_nguoi_danh_gia')->textInput(['maxlength' => true, 'value' => ($nguoiDanhGia?$nguoiDanhGia->name:'')]);
            } else {
                echo $form->field($model, 'ten_nguoi_danh_gia')->textInput(['maxlength' => true]);
            }
            ?>
        
            <?php 
            if($model->isNewRecord){
                echo $form->field($model, 'lan_thu')->textInput(['value'=>$model->getLanDanhGiaTiepTheo($modelMauCua->id)]);
            } else {
                echo $form->field($model, 'lan_thu')->textInput([]);
            }
            ?>
        
             <label>Ngày đánh giá</label>
            <?php
                echo DatePicker::widget([
            	    'model' => $model, 
            	    'name' => 'DanhGia[ngay_danh_gia]',
                    'value' => $model->ngay_danh_gia,
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
            	    'pluginOptions' => [
            	        'autoclose' => true,
            	        'format' => 'dd/mm/yyyy'
            	    ],
                    'removeButton'=>false
            	]);
            ?>
        
             <?= $form->field($model, 'ghi_chu')->textarea(['id'=>'txtGhiChu', 'rows' => 6]) ?>
    	</div>
    	<div class="col-md-4">
    		<h4>CHECK LIST</h3>
    		
            <?= $form->field($model, 'check_he_nhom')->checkbox() ?>
        
            <?= $form->field($model, 'check_kich_thuoc_phu_bi')->checkbox() ?>
        
            <?= $form->field($model, 'check_kich_thuoc_thuc_te')->checkbox() ?>
        
            <?= $form->field($model, 'check_nhan_hieu')->checkbox() ?>
        
            <?= $form->field($model, 'check_chu_thich')->checkbox() ?>
        
            <?= $form->field($model, 'check_tham_my')->checkbox() ?>
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
