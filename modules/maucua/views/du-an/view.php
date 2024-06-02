<?php

use yii\widgets\DetailView;
use app\custom\CustomFunc;

$custom = new CustomFunc();
$model->ngay_bat_dau_thuc_hien = $custom->convertYMDToDMY($model->ngay_bat_dau_thuc_hien);
$model->ngay_hoan_thanh_du_an = $custom->convertYMDToDMY($model->ngay_hoan_thanh_du_an);

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\DuAn */
?>

<div class="du-an-view container">
<div class="row">
	<div class="col-md-6">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                'ten_du_an',
                'ten_khach_hang',
                'dia_chi:ntext',
                'so_dien_thoai',
                'email:email',
                'trang_thai',
                'ngay_bat_dau_thuc_hien',
                'ngay_hoan_thanh_du_an',
                'code_mau_thiet_ke',
                [
                    'attribute'=>'ghi_chu',
                    'format'=>'html'
                ]
            ],
        ]) ?>
        
        <?php 
        if($model->trang_thai == 'KHOI_TAO' || $model->trang_thai == 'THUC_HIEN'){ 
            ?>
            <a href="#" onclick="ToiUuDuAnTonKho()" class="btn btn-primary btn-sm">Tối ưu tất cả mẫu cửa từ kho nhôm</a>
            <a href="#" onclick="ToiUuDuAnNhomMoi()" class="btn btn-primary btn-sm">Tối ưu tất cả mẫu cửa từ nhôm mới</a>
            <div>
                <span class="loadingAjax" style="display:none"><img src="/images/loading.gif" width="50" alt="loading..." /></span>
                <span class="completeAjax text-primary" style="display:none"></span>
        	</div>
        <?php } ?>
        
        
    </div>
    <div class="col-md-6">
        <div class="container indexPage">
        	<div class="row">
                <?php 
                    foreach ($model->mauCuas as $iMau => $mau){
                        echo $this->render('view_cua_item', ['model'=>$mau]);
                    }
                ?>
            </div>
        </div>
    </div>
</div>
</div>

<script>
function ToiUuDuAnTonKho(){
	$('.completeAjax').html('Đang xử lý...');
	
    $.ajax({
        /* beforeSend: function() {
         alert('inside ajax');
       }, */
      type: 'GET',
      dataType:'json',
      url: '/maucua/du-an/toi-uu-du-an-cho-tung-bo-cua?idDuAn=<?= $model->id ?>',
      success: function (data, status, xhr) {
      	$('.completeAjax').html('<i class="fa-solid fa-thumbs-up"></i> ' + data.result);
      }
    });
}

function ToiUuDuAnNhomMoi(){
    $.ajax({
      type: 'GET',
        dataType:"json",
      url: '/maucua/du-an/toi-uu-du-an-cho-tung-bo-cua?idDuAn=<?= $model->id ?>&type=catmoi',
      success: function (data, status, xhr) {
        	$('.completeAjax').html('<i class="fa-solid fa-thumbs-up"></i> ' + data.result);
      }
    });
}
</script>
