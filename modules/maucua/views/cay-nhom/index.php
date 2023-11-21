<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset; 
use cangak\ajaxcrud\BulkButtonWidget;
use app\widgets\CustomModal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\maucua\models\CayNhomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cây nhôm';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<!-- editor -->
<script src="<?= Yii::getAlias('@web') ?>/js/editor/tinymce/tinymce.min.js"></script>
<!-- <script src="<?= Yii::getAlias('@web') ?>/filemanager/responsivefilemanager.com_fancybox_jquery.fancybox-1.3.4.js" type="text/javascript" ></script> -->

<div id="dToolbar">
<?= 
BulkButtonWidget::widget([
    'buttons'=>
    Html::a('<i class="fas fa fa-plus" aria-hidden="true"></i> Thêm mới cây nhôm', ['create'],
        ['role'=>'modal-remote','title'=> 'Thêm mới cây nhôm','class'=>'btn btn-primary btn-sm btn-primary-custom']).
        '&nbsp;' .
    Html::a('<i class="fa-solid fa-triangle-exclamation"></i>&nbsp; Xóa cây nhôm',
        ["bulkdelete"] ,
        [
            "class"=>"btn btn-warning btn-sm btn-warning-custom",
            'role'=>'modal-remote-bulk',
            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            'data-request-method'=>'post',
            'data-confirm-title'=>'Xác nhận xóa thông tin?',
            'data-confirm-message'=>'Dữ liệu bị xóa sẽ thông thể phục hồi. Bạn có chắc chắn thực hiện hành động này?'
        ]),
]);
?>
</div>

<div class="cay-nhom-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
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
   'dialogOptions'=>['class'=>'modal-xl'],
   "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php CustomModal::end(); ?>

<?php CustomModal::begin([
   'options' => [
        'id'=>'ajaxCrudModal2',
        'tabindex' => false // important for Select2 to work properly
   ],
   'dialogOptions'=>['class'=>'modal-xl'],
   'closeButton'=>['label'=>'<span aria-hidden=\'true\'>×</span>'],
   'id'=>'ajaxCrudModal2',
   'footer'=>'',// always need it for jquery plugin
]) ?>

<?php CustomModal::end(); ?>
