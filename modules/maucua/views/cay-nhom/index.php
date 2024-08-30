<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset; 
use cangak\ajaxcrud\BulkButtonWidget;
use app\widgets\CustomModal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\maucua\models\search\CayNhomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cây nhôm';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<!-- editor -->
<script src="<?= Yii::getAlias('@web') ?>/js/editor/tinymce/tinymce.min.js"></script>
<!-- <script src="<?= Yii::getAlias('@web') ?>/filemanager/responsivefilemanager.com_fancybox_jquery.fancybox-1.3.4.js" type="text/javascript" ></script> -->
<style>
/*table group*/
td.kv-grid-group {
    background-color: white !important;
}
</style>

<div id="dToolbar">
<?= 
BulkButtonWidget::widget([
    'buttons'=>
    Html::a('<i class="fa-solid fa-square-plus"></i> Thêm mới (A)', ['create'],
        ['role'=>'modal-remote','title'=> 'Thêm mới cây nhôm','class'=>'btn btn-primary btn-sm btn-default-custom', 'accesskey'=>'a']).
        '&nbsp;' .
    Html::a('<i class="fa-solid fa-trash"></i> Xóa (T)',
        ["bulkdelete"] ,
        [
            'accesskey'=>'t',
            "class"=>"btn btn-warning btn-sm btn-default-custom",
            'role'=>'modal-remote-bulk',
            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            'data-request-method'=>'post',
            'data-confirm-title'=>'Xác nhận xóa thông tin?',
            'data-confirm-message'=>'Dữ liệu bị xóa sẽ thông thể phục hồi. Bạn có chắc chắn thực hiện hành động này?'
        ]).  '&nbsp;' .
        Html::a('<i class="fa-solid fa-magnifying-glass-arrow-right"></i> Tìm kiếm (K)', '#', ['id'=>'btnEnableSearch', 'class'=>'btn btn-primary btn-sm btn-default-custom', 'accesskey'=>'k'])
]);
?>
</div>

<div class="cay-nhom-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'filterRowOptions' => ['class' => 'custom-filters'],
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>''],
            ],   
            'striped' => true,
            'condensed' => true,
            'responsive' => true,    
            'summary'=>'<i class="fa-solid fa-chart-simple"></i>&nbsp; TS: <strong>{totalCount}</strong> dữ liệu',
            'panel' => [
                'heading' => '<i class="fas fa fa-list" aria-hidden="true"></i> Cây nhôm',
                //'before'=>'<em>* Danh sách.</em>',
                'after'=>'<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php CustomModal::begin([
   "options" => [
        "id"=>"ajaxCrudModal",
        "tabindex" => false // important for Select2 to work properly
    ],
   'dialogOptions'=>['class'=>'modal-xl modal-dialog-centered'],
   "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php CustomModal::end(); ?>

<?php CustomModal::begin([
   'options' => [
        'id'=>'ajaxCrudModal2',
        'tabindex' => false // important for Select2 to work properly
   ],
   'dialogOptions'=>['class'=>'modal-xl modal-dialog-centered'],
   'closeButton'=>['label'=>'<span aria-hidden=\'true\'>×</span>'],
   'id'=>'ajaxCrudModal2',
   'footer'=>'',// always need it for jquery plugin
]) ?>

<?php CustomModal::end(); ?>

<?php 
$script1 = <<< JS
    //$('#crud-datatable-filters').hide();
    $('#btnEnableSearch').on('click', function(){
        if($('#crud-datatable-filters').hasClass('custom-filters'))
            $('#crud-datatable-filters').removeClass('custom-filters');
        else 
            $('#crud-datatable-filters').addClass('custom-filters')
    });
JS;
$this->registerJs($script1);
?>
