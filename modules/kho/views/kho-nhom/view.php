<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\KhoNhom */
?>

<link href="/js/datatables/datatables.min.css" rel="stylesheet">
<script src="/js/datatables/datatables.min.js"></script>

<div class="kho-nhom-view container">
	<div class="row">
    	<div class="col-md-12">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                'qr_code',
                'code'=>[
                    'attribute'=>'code',
                    'value'=>$model->scode
                ],
                'id_cay_nhom'=>[
                    'attribute'=>'id_cay_nhom',
                    'value'=>$model->cayNhom->ten_cay_nhom
                ],
                'chieu_dai'=>[
                    'attribute' => 'chieu_dai',
                    'value' => function($model){
                        return number_format($model->chieu_dai) . ' mm';
                    }
                ],
                'so_luong',
                'date_created',
                //'user_created',
            ],
        ]) ?>
		</div>
        <div class="col-md-12">
        	<?= $this->render('_lichSuTonKho', ['model'=>$model->history]) ?>
        </div>
    </div>
</div>

<script>
new DataTable('#tblLichSuTonKho',{
    pageLength: 5,
    "language": {
        "sLengthMenu":    "Hiển thị _MENU_ dòng dữ liệu trên trang",
        "sInfo":          "Hiển thị _START_ - _END_ của _TOTAL_ dữ liệu",
        "sSearch":        "Tìm kiếm:",
    }
});
</script>
