
<!-- on your view layout file HEAD section -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

<?php 
    use app\custom\ThemeControl;

    $theme = new ThemeControl();
    $theme->mod = 'edit';
?>
<?= $this->render($page->getFileRenderUrl(), compact('varibles', 'blocks', 'theme')) ?>

<?php 
$js = <<< JS

    function setNote(){
    	$('.abc').summernote({
            tabsize: 2,
            height: 200,
            toolbar: [
              //['style', ['style']],
              ['font', ['bold', 'underline', 'clear']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              //['table', ['table']],
              ['insert', ['link', 'picture', 'video']],
              //['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks : {
                onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);
                } 
            }  
        });
    }

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
            $('.abc').summernote("insertNode", image[0]);
          }
        });
      }
    

JS;
$this->registerJs($js);
?>