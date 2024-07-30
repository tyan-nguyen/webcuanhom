<?php

use yii\widgets\DetailView;
use app\custom\CustomFunc;
use yii\helpers\Html;

$custom = new CustomFunc();
$model->ngay_bat_dau = $custom->convertYMDToDMY($model->ngay_bat_dau);
$model->ngay_hoan_thanh = $custom->convertYMDToDMY($model->ngay_hoan_thanh);

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\CongTrinh */
?>
<script src="/js/vue.js"></script>

<div class="du-an-view container">
	
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Thông tin Công trình</button>
        </li>

    </ul>

 	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
			<div class="row">
				<div class="col-md-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            'ten_cong_trinh',
                            'dia_diem',
                            'tenKhachHang',
                            'diaChiKhachHang:ntext',
                            'sdtKhachHang',
                            'emailKhachHang:email',
                            //'trang_thai',
                            'ngay_bat_dau',
                            'ngay_hoan_thanh',
                            'code_mau_thiet_ke',
                            [
                                'attribute'=>'ghi_chu',
                                'format'=>'html'
                            ]
                        ],
                    ]) ?>
        
                   
                   <!-- print phieu -->
                   <div style="display:none">
                        <div id="print">
                        	<?php // $this->render('_print_phieu_thong_tin', compact('model')) ?>
                        </div>
                   </div>
        
        
    			</div>
                <div class="col-md-6">
                    <div class="container indexPage" style="overflow:scroll;height:600px;">
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
		</div><!-- tab pane -->

	</div><!-- tab content -->

</div><!-- container -->


<script>
//in phieu thong tin
function InPhieuThongTin(){
	//load lai phieu in (tranh bi loi khi chinh sua du lieu chua update noi dung in)
	$.ajax({
        type: 'post',
        url: '/maucua/du-an/get-phieu-in-ajax?idCongTrinh=' + <?= $model->id ?> + '&type=phieuthongtin',
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#print').html(data.content);
            	printPhieuXuat();//call from script.js
            } else {
            	alert('Vật tư không còn tồn tại trên hệ thống!');
            }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });	
}

</script>
