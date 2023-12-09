<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\DuAn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="du-an-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-12">
                		<?= $form->field($model, 'ten_du_an')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-6">
                		<?= $form->field($model, 'trang_thai')->dropDownList($model->getDmTrangThai(), ['prompt' => '--Chọn--']) ?>
                    </div>
                    <div class="col-md-6">
                		<?= $form->field($model, 'code_mau_thiet_ke')->dropDownList($model->getDmThieKe()) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                		<?= $form->field($model, 'ngay_bat_dau_thuc_hien')->textInput() ?>
                    </div>
                    <div class="col-md-6">
                		<?= $form->field($model, 'ngay_hoan_thanh_du_an')->textInput() ?>
                    </div>
                    
                    <div class="col-md-12">
                    <?php 
                    	/* echo DatePicker::widget([
                            'model' => $model, 
                            'attribute' => 'date_1',
                            'options' => ['placeholder' => 'Enter birth date ...'],
                            'pluginOptions' => [
                                'autoclose' => true
                            ]
                        ]); */
                    	
                    	echo DatePicker::widget([
                    	    'model' => $model, 
                    	    'name' => 'ngay_bat_dau_thuc_hien',
                    	    'value' => '01-Feb-1996',
                    	    'type' => DatePicker::TYPE_RANGE,
                    	    'name2' => 'ngay_hoan_thanh_du_an',
                    	    'value2' => '27-Feb-1996',
                    	    'pluginOptions' => [
                    	        'autoclose' => true,
                    	        'format' => 'yyyy-mm-dd'
                    	    ]
                    	]);
                    ?>
                    </div>
                </div>
        	</div>
            
        </div>
        
        <div class="col-md-6">
        	<div class="container p-0">
            	<div class="row">
            		<div class="col-md-7">
            			<?= $form->field($model, 'ten_khach_hang')->textInput(['maxlength' => true]) ?>
            		</div>
            		<div class="col-md-5">
            			<?= $form->field($model, 'so_dien_thoai')->textInput(['maxlength' => true]) ?>
            		</div>
            	</div>
            </div>
            <div class="row">
        		<div class="col-md-12">
        			<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        		</div>
           	</div>
            <div class="row">
        		<div class="col-md-12">
        			<?= $form->field($model, 'dia_chi')->textarea(['rows' => 4]) ?>
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
