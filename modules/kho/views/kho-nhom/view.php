<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

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
                'qr_code'=>[
                    'attribute'=>'qr_code',
                    'format'=>'raw',
                    'value'=>($model->qr_code . '<br/>' . Html::img($model->qrImage, ['width'=>50]) . ($model->checkHasQr?'<div style="margin-top:10px">
                        	<button type="button" onClick="printQr()" class="btn ripple btn-primary btn-sm btn-block">In Mã QR</button></div>':''))
                ],
                'code'=>[
                    'attribute'=>'code',
                    'value'=>$model->scode
                ],
                'id_cay_nhom'=>[
                    'attribute'=>'id_cay_nhom',
                    'format'=>'raw',
                    'value'=>Html::a($model->cayNhom->ten_cay_nhom, ['/maucua/cay-nhom/view', 'id'=>$model->id_cay_nhom], ['role'=>'modal-remote'])
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

<div style="display:none">
<div id="print">
<?= $this->render('../qr/_print_qr', compact('model')) ?>
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
