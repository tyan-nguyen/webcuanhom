<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset; 
use cangak\ajaxcrud\BulkButtonWidget;
use app\widgets\CustomModal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\maucua\models\search\MauCuaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mẫu cửa';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<style>
#ajaxCrudModal2{
    margin-top:50px;
}
#ajaxCrudModal2 .modal-content{
    border-top:2px solid blue;
}
</style>

<!-- CSS -->
<!-- <link rel="stylesheet" type="text/css" href="<?= Yii::getAlias('@web') ?>/js/fancybox-master/dist/jquery.fancybox.min.css">-->

<div id="dToolbar">
<?= 
BulkButtonWidget::widget([
    'buttons'=>
    Html::a('<i class="fa-solid fa-square-plus"></i> Thêm mới (A)', ['create'],
        ['role'=>'modal-remote','title'=> 'Thêm mới dự án','class'=>'btn btn-primary btn-sm btn-default-custom', 'accesskey'=>'a']).
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

<div class="mau-cua-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'filterRowOptions' => ['class' => 'custom-filters'],
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true, 
            'summary'=>'<i class="fa-solid fa-chart-simple"></i>&nbsp; TS: <strong>{totalCount}</strong> dữ liệu',
            'panel' => [
                //'type' => 'primary', 
                'heading' => '<i class="fa-brands fa-windows"></i> Danh sách mẫu cửa',
                //'before'=>'<em>* Danh sách.</em>',
                'after'=>/* BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="fas fa fa-trash" aria-hidden="true"></i>&nbsp; Delete',
                                ["bulkdelete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Confirm Delete?',
                                    'data-confirm-message'=>'Are you sure delete this data?'
                                ]),
                        ]).   */                      
                        '<div class="clearfix"></div>',
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
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
   "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php CustomModal::end(); ?>

<?php CustomModal::begin([
   'options' => [
        'id'=>'ajaxCrudModal2',
        'tabindex' => false // important for Select2 to work properly
   ],
   'dialogOptions'=>['class'=>'modal-lg'],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
   'closeButton'=>['label'=>'<span aria-hidden=\'true\'>×</span>'],
   'id'=>'ajaxCrudModal2',
   'footer'=>'',// always need it for jquery plugin
]) ?>

<?php CustomModal::end(); ?>

<?php 
//docs: https://obu.edu/_resources/ldp/galleries/fancybox/#setup
/* $this->registerJsFile("@web/js/fancybox-master/dist/jquery.fancybox.min.js",[
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]); */

?>

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
