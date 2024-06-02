<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\kho\models\KhoVatTu */
?>

<link href="/js/datatables/datatables.min.css" rel="stylesheet">
<script src="/js/datatables/datatables.min.js"></script>

<div class="kho-vat-tu-view container">
 <div class="row">
    	<div class="col-md-12">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    'code',
                    'ten_vat_tu',
                    /* 'id_nhom_vat_tu'=>[
                        'attribute'=>'id_nhom_vat_tu',
                        'value'=>$model->getDmNhomVatTuLabel($model->id_nhom_vat_tu)
                    ], */
                    /* 'la_phu_kien'=>[
                        'attribute'=>'la_phu_kien',
                        'value'=>$model->la_phu_kien==1 ? 'Là phụ kiện' : 'Không'
                    ], */
                    'thuong_hieu'=>[
                        'attribute'=>'thuong_hieu',
                        'value'=>$model->thuongHieu->ten_thuong_hieu
                    ],
                    'model',
                    'xuat_xu'=>[
                        'attribute'=>'xuat_xu',
                        'value'=>$model->xuatXu->ten_xuat_xu
                    ],
                    'so_luong'=>[
                        'attribute'=>'so_luong',
                        'value'=>function($model){
                            if ((int) $model->so_luong == $model->so_luong) {
                                //is an integer
                                return number_format($model->so_luong);
                            } else {
                                return number_format($model->so_luong, 2);
                            }
                        }
                    ],
                    [
                        'attribute'=>'so_luong',
                        'label'=>'Số lượng trong dự án khởi tạo',
                        'value'=>$model->getSoLuongKetBatDau()
                    ],
                    [
                        'attribute'=>'so_luong',
                        'label'=>'Số lượng trong dự án đang thực hiện',
                        'value'=>$model->getSoLuongKetDangThucHien()
                    ],
                    'dvt'=>[
                        'attribute'=>'dvt',
                        'value'=>$model->donViTinh->ten_dvt
                    ],
                    'don_gia'=>[
                        'attribute'=>'don_gia',
                        'value'=>number_format($model->don_gia)
                    ],
                    'date_created',
                    //'user_created',
                ],
            ]) ?>
		</div>
		 <div class="col-md-12">
        	<?= $model->tonKho != null ? $this->render('_tonKho', ['model'=>$model->tonKho]) : 'Không có dữ liệu!' ?>
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