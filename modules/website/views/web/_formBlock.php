<?php 
    use yii\bootstrap5\ActiveForm; 
?>

<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'options' => [
        'class' => 'form-horizontal'
    ],
    'fieldConfig' => [
        //'template' => '<div class="col-sm-4">{label}</div><div class="col-sm-8">{input}{error}</div>',
        'template' => '<div class="col-sm-12">{input}{error}</div>',
        'labelOptions' => ['class' => 'col-md-12 control-label'],
    ],
]); ?>
<?php /* ?>
<?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'id_website')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'id_template_block')->textInput(['maxlength' => true]) ?>
<?php */ ?>
<?= $form->field($model, 'content')->textarea(['id' => 'txtContent', 'rows'=>10]) ?>
    
<?php ActiveForm::end(); ?>


<script>
	$('#txtContent').summernote({
        //tabsize: 2,
        //height: 200,
        /* toolbar: [
          //['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          //['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          //['view', ['fullscreen', 'codeview', 'help']]
        ], */
        callbacks : {
            onImageUpload: function(files, editor, welEditable) {
            	sendFile(files[0], editor, welEditable);
            },
            onMediaDelete : function(target) {
                // alert(target[0].src) 
                deleteFile(target[0].src);
            }
        }  
    });
</script>

<?php 
$js = <<< JS
    function sendFile(file, editor, welEditable) {
        data = new FormData();
        data.append("file", file);
        $.ajax({
          data: data,
          type: "POST",
          url: "/website/default/upload",
          cache: false,
          contentType: false,
          processData: false,
          success: function(url) {
            //editor.insertImage(welEditable, url);
            var image = $('<img>').attr('src', url);
            $('#txtContent').summernote("insertNode", image[0]);
          }
        });
      }

    function deleteFile(src) {
    
        $.ajax({
            data: {src : src},
            type: "POST",
            url: "/website/web/delete-file", // replace with your url
            cache: false,
            success: function(resp) {
                if(resp==null){
                    alert('Xóa file bị lỗi!');
                }
            }
        });
    }
    

JS;
$this->registerJs($js);
?>