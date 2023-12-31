<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use app\widgets\CustomModal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset; 
use cangak\ajaxcrud\BulkButtonWidget;
use app\modules\maucua\models\KhoNhom;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\maucua\models\search\KhoNhomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kho nhôm';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<style>
/*table group*/
td.kv-grid-group {
    background-color: white !important;
}
</style>
<div id="dToolbar">
	<?=		BulkButtonWidget::widget([
            'buttons'=>
           /*  Html::a('<i class="fa-solid fa-square-plus"></i> Thêm mới (A)', ['create'],
                ['role'=>'modal-remote','title'=> 'Thêm mới kho nhôm','class'=>'btn btn-primary btn-sm btn-default-custom', 'accesskey'=>'a']).
                '&nbsp;' . */
            /* Html::a('<i class="fa-solid fa-trash"></i> Xóa (T)',
                ["bulkdelete"] ,
                [
                    'accesskey'=>'t',
                    "class"=>"btn btn-warning btn-sm btn-default-custom",
                    'role'=>'modal-remote-bulk',
                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                    'data-request-method'=>'post',
                    'data-confirm-title'=>'Xác nhận xóa thông tin?',
                    'data-confirm-message'=>'Dữ liệu bị xóa sẽ thông thể phục hồi. Bạn có chắc chắn thực hiện hành động này?'
                ]) .  '&nbsp;' . */
	Html::a('<i class="fa-solid fa-magnifying-glass-arrow-right"></i> Tìm kiếm (K)', '#', ['id'=>'btnEnableSearch', 'class'=>'btn btn-primary btn-sm btn-default-custom', 'accesskey'=>'k']) . '&nbsp;' .
	
	Html::a('<i class="fas fa fa-sync"></i> Refresh', [''],
	    ['title'=> 'Tải lại danh sách','class'=>'btn btn-primary btn-sm btn-default-custom', 'accesskey'=>'a']).
	    '&nbsp;' .Html::a('<i class="fa-solid fa-upload"></i> Upload', Yii::getAlias('@web/dungchung/import-all/upload?type=').KhoNhom::MODEL_ID . '&showOverwrite=1', [ 'class'=>'btn btn-primary btn-sm btn-default-custom', 'role'=>'modal-remote']) . '&nbsp;' .
	
	Html::a('<i class="fa-solid fa-cloud-arrow-down"></i> Tải mẫu', Yii::getAlias('@web/files/excel/import-kho-nhom.xlsx'), ['class'=>'btn btn-primary btn-sm btn-default-custom'])
	
       ]) 
	?>
</div>

<div class="kho-nhom-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'filterRowOptions' => ['class' => 'custom-filters'],
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [],          
            'striped' => false,
            'condensed' => true,
            'responsive' => true,          
            'summary'=>'<i class="fa-solid fa-chart-simple"></i>&nbsp; TS: <strong>{totalCount}</strong> dữ liệu',
            'panel' => [
                'heading' => '<i class="fa-brands fa-windows"></i> Danh sách kho nhôm'
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

<?php 
$script1 = <<< JS
    $("#btnEnableSearch").on("click", function(){
        if($("#crud-datatable-filters").hasClass("custom-filters"))
            $("#crud-datatable-filters").removeClass("custom-filters");
        else 
            $("#crud-datatable-filters").addClass("custom-filters")
    });
JS;
$this->registerJs($script1);
?>