
<?php 
use app\custom\ThemeControl2;
/* use yii\bootstrap5\Html; */
use yii\bootstrap5\Modal;
/* use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset;
use cangak\ajaxcrud\BulkButtonWidget; */
use yii\widgets\Pjax;

//CrudAsset::register($this);

    $theme = new ThemeControl2();
    //$theme->mod = 'view';
    $theme->mod = 'edit';
?>
<!-- on your view layout file HEAD section -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

<style>
.mydivoutermulti{
position: relative;
/* background: #f90; */
/* width: 100%;
min-height: 200px;
float: left;
margin-right: 15px;
margin-bottom:50px; */
}
.buttonoverlapmulti{
position: absolute;
z-index: 2;
top: -35px;
display: none;
left: 0px;
width: auto;
font-size:30px;
color:red;
cursor:pointer;
}
.mydivoutermulti:hover .buttonoverlapmulti{ 
display:block;
}
</style>

<?php Pjax::begin([
    'id'=>'pjax',
    'timeout' => 10000
]); ?>

<?= $this->render($page->getFileRenderUrl(), compact('varibles', 'blocks', 'theme')) ?>

<?php Pjax::end(); ?>

<?php /*Modal::begin([
   'options' => [
        'id'=>'ajaxCrudModal',
        'tabindex' => false // important for Select2 to work properly
   ],
   'dialogOptions'=>['class'=>'modal-xl'],
   //'closeButton'=>['label'=>'<span aria-hidden=\'true\'>×</span>'],
   'id'=>'ajaxCrudModal',
    'footer'=>'',// always need it for jquery plugin
])*/ ?>

<?php Modal::begin([
   "options" => [
        "id"=>"ajaxCrudModal",
        "tabindex" => false // important for Select2 to work properly
    ],
   //'dialogOptions'=>['class'=>'modal-xl'],
   "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
