<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset; 
use cangak\ajaxcrud\BulkButtonWidget;
use app\widgets\CustomModal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\maucua\models\MauCuaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mẫu cửa';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<!-- CSS -->
<!-- <link rel="stylesheet" type="text/css" href="<?= Yii::getAlias('@web') ?>/js/fancybox-master/dist/jquery.fancybox.min.css">-->

<div id="dToolbar">
<?= 
BulkButtonWidget::widget([
    'buttons'=>
    Html::a('<i class="fas fa fa-plus" aria-hidden="true"></i> Thêm mới mẫu cửa', ['create'],
        ['role'=>'modal-remote','title'=> 'Thêm mới dự án','class'=>'btn btn-primary btn-sm btn-primary-custom']).
        '&nbsp;' .
    Html::a('<i class="fa-solid fa-triangle-exclamation"></i>&nbsp; Xóa mẫu cửa',
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

<div class="mau-cua-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                /* ['content'=>
                    Html::a('<i class="fas fa fa-plus" aria-hidden="true"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Create Mau Cuas','class'=>'btn btn-default']).
                    Html::a('<i class="fas fa fa-sync" aria-hidden="true"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ], */
            ],          
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
    'dialogOptions'=>['class'=>'modal-xl modal-fullscreen'],
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

<?php 
//docs: https://obu.edu/_resources/ldp/galleries/fancybox/#setup
/* $this->registerJsFile("@web/js/fancybox-master/dist/jquery.fancybox.min.js",[
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]); */

?>
