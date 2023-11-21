<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset; 
use cangak\ajaxcrud\BulkButtonWidget;
use app\modules\dungchung\models\Import;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\maucua\models\DuAnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý dự án';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<script src="<?= Yii::getAlias('@web') ?>/js/tinymce/tinymce_5.10.7.min.js"></script>

<div id="dToolbar">
<?= 
BulkButtonWidget::widget([
    'buttons'=>
    Html::a('<i class="fas fa fa-plus" aria-hidden="true"></i> Thêm mới dự án', ['create'],
        ['role'=>'modal-remote','title'=> 'Thêm mới dự án','class'=>'btn btn-primary btn-sm btn-primary-custom']).
        '&nbsp;' .
    Html::a('<i class="fa-solid fa-triangle-exclamation"></i>&nbsp; Xóa dự án',
        ["bulkdelete"] ,
        [
            "class"=>"btn btn-warning btn-sm btn-warning-custom",
            'role'=>'modal-remote-bulk',
            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            'data-request-method'=>'post',
            'data-confirm-title'=>'Confirm Delete?',
            'data-confirm-message'=>'Are you sure delete this data?'
        ]),
]);
?>
</div>

<div class="du-an-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>''
                   /*  Html::a('<i class="fas fa fa-plus" aria-hidden="true"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Create Du Ans','class'=>'btn btn-default']).
                    Html::a('<i class="fas fa fa-sync" aria-hidden="true"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}' */
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            //'panelHeadingTemplate'=>'{title}',
            //'panelFooterTemplate'=>'<div class="row"><div class="col-md-8">{pager}</div><div class="col-md-4">{summary}</div></div>',
            'summary'=>'<i class="fa-solid fa-chart-simple"></i>&nbsp; TS: <strong>{totalCount}</strong> dữ liệu',
            'panel' => [
                //'type' => 'primary', 
                'heading' => '<i class="fa-brands fa-windows"></i> Danh sách dự án',
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
                        ]).    */                     
                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
   "options" => [
        "id"=>"ajaxCrudModal",
        "tabindex" => false // important for Select2 to work properly
    ],
   'dialogOptions'=>['class'=>'modal-xl'],
   "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>


<?php 

/* $xls_data = Import::readExcelToArr('e30e52f918e75554a747de05814c4621.xlsx');

echo $xls_data[9]['A'];

$excelFilePath = Yii::getAlias('@webroot') . '/uploads/excel/up/' . 'e30e52f918e75554a747de05814c4621.xlsx';
$outputImagePath = 'C:\wamp64\www\webcuanhom\web\uploads\images\test';

$imp = new Import();
$imp->extractAndSaveImages($excelFilePath, $outputImagePath);
 */

?>


