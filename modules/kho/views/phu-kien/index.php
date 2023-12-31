<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\widgets\CustomModal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset; 
use cangak\ajaxcrud\BulkButtonWidget;
use app\modules\kho\models\KhoVatTu;
use app\modules\kho\models\PhuKien;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\kho\models\search\KhoVatTuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kho phụ kiện';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<div id="dToolbar">
<?= 
BulkButtonWidget::widget([
    'buttons'=>
    Html::a('<i class="fa-solid fa-square-plus"></i> Thêm mới (A)', ['create'],
        ['role'=>'modal-remote','title'=> 'Thêm mới phụ kiện','class'=>'btn btn-primary btn-sm btn-default-custom', 'accesskey'=>'a']).
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
        ]) .  '&nbsp;' .
    Html::a('<i class="fa-solid fa-magnifying-glass-arrow-right"></i> Tìm kiếm (K)', '#', ['id'=>'btnEnableSearch', 'class'=>'btn btn-primary btn-sm btn-default-custom', 'accesskey'=>'k']) . '&nbsp;||&nbsp;'.
    Html::a('<i class="fa-solid fa-upload"></i> Upload', Yii::getAlias('@web/dungchung/import-all/upload?type=').PhuKien::MODEL_ID. '&showOverwrite=1', [ 'class'=>'btn btn-primary btn-sm btn-default-custom', 'role'=>'modal-remote']) . '&nbsp;' .
    
    Html::a('<i class="fa-solid fa-cloud-arrow-down"></i> Tải mẫu', Yii::getAlias('@web/files/excel/import-phu-kien.xlsx'), ['class'=>'btn btn-primary btn-sm btn-default-custom'])
]);
?>
</div>

<div class="kho-vat-tu-index">
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
                'heading' => '<i class="fa-brands fa-windows"></i> Danh sách kho phụ kiện'
            ]
        ])?>
    </div>
</div>
<?php CustomModal::begin([
   "options" => [
        "id"=>"ajaxCrudModal",
        "tabindex" => false // important for Select2 to work properly
    ],
   "dialogOptions"=>["class"=>"modal-xl modal-dialog-centered"],
   "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php CustomModal::end(); ?>

<?php CustomModal::begin([
   'options' => [
        'id'=>'ajaxCrudModal2',
        'tabindex' => false // important for Select2 to work properly
   ],
   'dialogOptions'=>['class'=>'modal-xs modal-dialog-centered'],
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

