<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use webvimark\modules\UserManagement\models\User;
use app\modules\kho\models\NhaCungCap;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\CayNhom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ton-kho-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($history) ?>

    <?= $form->field($history, 'so_luong')->textInput() ?>

    <?= $form->field($history, 'id_nha_cung_cap')->dropDownList((new NhaCungCap())->getList(), ['prompt'=>'-Chọn-'] ) ?>
    
    <?= $form->field($history, 'ghi_chu')->textarea(['id'=>'txtNoiDung', 'rows' => 6]) ?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Ghi dữ liệu' : 'Cập nhật dữ liệu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<script>

tinymce.remove();
//editor for content
tinymce.init({
	selector: "#txtNoiDung",
	branding: false,
	statusbar: false,
	plugins: "media,image,paste,table,code,link,lists,advlist,responsivefilemanager,hr",
	menubar: 'edit view insert format table',
	toolbar: 'autolink | undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist hr | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link unlink anchor codesample | ltr rtl | responsivefilemanager',
  	toolbar_sticky: true,
	paste_data_images: true,
	image_advtab: true,
	image_title: true,
	//images_upload_url: "<?= Yii::getAlias('@web') . '/js/editor/upload.php' ?>", //upload img tab
	//images_upload_credentials: true,
	relative_urls : false,
	remove_script_host : true,
	document_base_url : "/",
	convert_urls : true,
	height : "200",
	
	external_filemanager_path:"<?= Yii::getAlias('@web') ?>/filemanager/filemanager/",
	filemanager_title:"QUẢN LÝ FILE" ,
	external_plugins: { "filemanager" : "<?= Yii::getAlias('@web') ?>/filemanager/filemanager/plugin.min.js"},
	filemanager_access_key: "1fdb7184e697ab9355a3f1438ddc6ef9",

	language_url : '<?= Yii::getAlias('@web')?>/js/editor/tinymce/langs/vi.js',
		
	setup: function (editor) {
	    editor.on('change', function () {
	        tinymce.triggerSave();
	    });
	}
});

//prevent Bootstrap from hijacking TinyMCE modal focus
$(document).on('focusin', function(e) {
  if ($(e.target).closest(".mce-window").length) {
    e.stopImmediatePropagation();
  }
});

</script>
