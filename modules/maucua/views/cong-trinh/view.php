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

<?php if(isset($showFlash)){ ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= $showFlash ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php } ?>

<div class="du-an-view container">
	
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Thông tin Công trình</button>
        </li>

    </ul>

 	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
			<div class="row">
				<div class="col-md-4">
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
                        'template' => "<tr><th style='width: 40%;'>{label}</th><td class='align-middle'>{value}.</td></tr>"
                    ]) ?>
        
                   
                   <!-- print phieu -->
                   <div style="display:none">
                        <div id="print">
                        	<?php // $this->render('_print_phieu_thong_tin', compact('model')) ?>
                        </div>
                   </div>
        
        
    			</div>
                <div class="col-md-8">
                    <div class="container indexPage" style="overflow:scroll;height:600px;">
                    	
                    	<div class="row" style="padding:5px;position:absolute;margin-top:-45px;right:20px;z-index: 99999">
                        	<div class="col-md-12">
                        		<?php
                                $session = Yii::$app->session;
                                $cookieValue = isset($_SESSION['default-view-list']) ? $_SESSION['default-view-list'] : 'anhLon';
                                $cookieSearch = isset($_SESSION['search-dsCua-enable']) ? $_SESSION['search-dsCua-enable'] : '';
                                ?>
                            	<div class="btn-group float-end">
                                      <a href="#" onClick="setHienThiDanhSachCua('danhSach')" class="cls-view-group danhSach btn btn-sm btn-primary <?= $cookieValue=='danhSach'?'active':'' ?>" aria-current="page"><i class="fa-solid fa-list-ol"></i></a>
                                      <a href="#" onClick="setHienThiDanhSachCua('anhLon')" class="cls-view-group anhLon btn btn-sm btn-primary <?= $cookieValue=='anhLon'?'active':'' ?>"><i class="fa-solid fa-images"></i></a>
                                      
                                       <a href="#" onClick="setHienThiKhungSearch()" class="btnSearch btn btn-sm btn-primary <?= $cookieSearch!=null?'active':'' ?>"><i class="fa-solid fa-magnifying-glass"></i></a>
                                       
                                </div>
                            </div>
                        </div>
                        
                    	<div class="row" id="div-ds-cua">
                            <?php 
                                /* foreach ($model->mauCuas as $iMau => $mau){
                                    echo $this->render('view_cua_item', ['model'=>$mau]);
                                } */
                            if($cookieValue == 'danhSach'){
                                echo $this->render('view_cua_item_ds', ['model'=>$model, 'cookieSearch'=>$cookieSearch]);
                            } else {
                                echo $this->render('view_cua_item_anh_lon', ['model'=>$model]);
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

function setHienThiDanhSachCua(type){
	$.ajax({
        type: 'post',
        url: '/maucua/cong-trinh/get-view-hien-thi-cua?idCongTrinh=' + <?= $model->id ?> + '&type='+type,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#div-ds-cua').html(data.content);
            	$('.cls-view-group').removeClass('active');
            	$('.' + type).addClass('active');
            } else {
            	alert('Kế hoạch không tồn tại trên hệ thống!');
            }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });	
}

function setHienThiKhungSearch(){
	if(!$('.btnSearch').hasClass('active')){
    	$.ajax({
            type: 'post',
            url: '/maucua/cong-trinh/set-show-search?type=dsCua',
            //data: frm.serialize(),
            success: function (data) {
                console.log('Submission was successful.');
                console.log(data);            
                if(data.status == 'success'){
                	$('#fs-search').toggle();
                	$('.btnSearch').addClass('active');
                } else {
                	alert('Lỗi!');
                }
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });	
    } else {
    	$.ajax({
            type: 'post',
            url: '/maucua/cong-trinh/set-show-search?type=none',
            //data: frm.serialize(),
            success: function (data) {
                console.log('Submission was successful.');
                console.log(data);            
                if(data.status == 'success'){
                	$('#fs-search').toggle();
                	$('.btnSearch').removeClass('active');
                } else {
                	alert('Lỗi!');
                }
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });	
    }
	
}

</script>
