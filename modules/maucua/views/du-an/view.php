<?php

use yii\widgets\DetailView;
use app\custom\CustomFunc;
use yii\helpers\Html;

$custom = new CustomFunc();
$model->ngay_bat_dau_thuc_hien = $custom->convertYMDToDMY($model->ngay_bat_dau_thuc_hien);
$model->ngay_hoan_thanh_du_an = $custom->convertYMDToDMY($model->ngay_hoan_thanh_du_an);

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\DuAn */
?>
<script src="/js/vue.js"></script>

<?php if(isset($showFlash)){ ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= $showFlash ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php } ?>

<?php if($model->trang_thai == 'TOI_UU' && $model->getTrangThaiKhoNhomOk() == false){?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  Thiếu nhôm để sản xuất cho KHSX này, vui lòng xem tại tab <strong>Tổng hợp nhôm</strong>.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?>
<?php if( ($model->trang_thai == 'TOI_UU' || $model->trang_thai == 'KHOI_TAO') && $model->getTrangThaiVatTuOk() == false){?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  Vật tư đang thiếu để sản xuất cho KHSX này, vui lòng xem tại tab <strong>Tổng hợp vật tư</strong>.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?>
<div class="du-an-view container">
	
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Thông tin Kế hoạch/Dự án</button>
        </li>
        <?php if($model->toi_uu_tat_ca == 1) {?>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="toiuucat-tab" data-bs-toggle="tab" data-bs-target="#toiuucat" type="button" role="tab" aria-controls="toiuucat" aria-selected="false">Tối ưu cắt</button>
            </li>
            
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="tonghopnhom-tab" data-bs-toggle="tab" data-bs-target="#tonghopnhom" type="button" role="tab" aria-controls="tonghopnhom" aria-selected="false">Tổng hợp nhôm</button>
            </li>
            
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="tonghopvattu-tab" data-bs-toggle="tab" data-bs-target="#tonghopvattu" type="button" role="tab" aria-controls="tonghopvattu" aria-selected="false">Tổng hợp vật tư</button>
            </li>
            
        <?php } ?>
    </ul>

 	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
			<div class="row">
				<div class="col-md-4">
					 <fieldset class="fs-custom">
						<legend>Kế hoạch: #<?= $model->code ?></legend>
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                //'id',
                                'ten_du_an',
                                [
                                    'label' => 'Tổng diện tích',
                                    'format' => 'html',
                                    'value'=>round($model->tongDienTichThiCong/1000000,2) . ' m <sup>2</sup>'
                                ],
                                [
                                    'label' => 'Tổng diện tích nghiệm thu',
                                    'format' => 'html',
                                    'value'=>round($model->tongDienTichDatChatLuong/1000000,2) . '/' . round($model->tongDienTichThiCong/1000000,2) . ' m <sup>2</sup>'
                                ],
                                /* 'ten_khach_hang',
                                'dia_chi:ntext',
                                'so_dien_thoai',
                                'email:email', */
                                'trang_thai',
                                'ngay_bat_dau_thuc_hien',
                                'ngay_hoan_thanh_du_an',
                                'code_mau_thiet_ke',
                                [
                                    'attribute'=>'toi_uu_tat_ca',
                                    'value'=>function($model){
                                        return $model->toi_uu_tat_ca==1?"YES":'NO';
                                    }
                                ],
                                [
                                    'attribute'=>'ghi_chu',
                                    'format'=>'html'
                                ]
                            ],
                            'template' => "<tr><th style='width: 40%;'>{label}</th><td class='align-middle'>{value}</td></tr>"
                        ]) ?>
                    </fieldset>
        			
        			<?php if(count($model->mauCuas) > 0) {?>
        			
                    <?php 
                    if($model->trang_thai == 'KHOI_TAO' || $model->trang_thai == 'THUC_HIEN' || $model->trang_thai == 'TOI_UU'){ 
                        ?>
                        
                        <?php if($model->toi_uu_tat_ca == 0 || $model->toi_uu_tat_ca == NULL) { ?>
                        <fieldset class="fs-custom">
                        <legend>TỐI ƯU TỪNG MẪU CỬA RIÊNG</legend>
                        <a href="#" onclick="ToiUuLeDuAnTonKho()" class="btn btn-primary btn-sm">Tối ưu từ kho nhôm</a> &nbsp;
                        <a href="#" onclick="ToiUuLeDuAnNhomMoi()" class="btn btn-primary btn-sm">Tối ưu từ nhôm mới</a> &nbsp;
                        </fieldset>
                        <?php } ?>
                        <?php if($model->toi_uu_tat_ca == 1) { ?>
                        
                         <fieldset class="fs-custom">                        
                            <legend>TỐI ƯU CHO TOÀN KHSX</legend>
                            <a href="#" onclick="ToiUuDuAnTonKho()" class="btn btn-primary btn-sm">Tối ưu kho nhôm</a>
                            <a href="#" onclick="ToiUuDuAnNhomMoi()" class="btn btn-primary btn-sm">Tối ưu nhôm mới</a>	
                        </fieldset>
                     	<?php } ?>   
                        <div>
                            <span class="loadingAjax" style="display:none"><img src="/images/loading.gif" width="50" alt="loading..." /></span>
                            <span class="completeAjax text-primary" style="display:none"></span>
                    	</div>
                    <?php } ?>
                   
                    
                    <?php if($model->toi_uu_tat_ca == 1) { ?>
                     <fieldset class="fs-custom">    
                     <legend>GIAI ĐOẠN XUẤT KHO</legend>
                     <?php 
                        if($model->trang_thai == 'TOI_UU'){                      
                           echo Html::a('<i class="fa-solid fa-truck-fast"></i> Xuất kho',['xuat-kho','id'=>$model->id],[
                               'role'=>'modal-remote',
                               'class'=>'btn btn-primary btn-sm'
                            ]);
                           
                          
                          
                      } ?>
                      
                      <a href="#" onClick="InPhieuXuatKho2()" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> In Phiếu xuất kho</a>
                     
                     <p style="margin-top:5px">
                       <?php 
                       if($model->trang_thai == 'DA_XUAT_KHO' || $model->trang_thai == 'TOI_UU' || $model->trang_thai == 'DA_NHAP_KHO'){                      
                       ?>
                        <?= Html::a('<i class="fa-solid fa-file-import"></i> Nhập nhôm dư', Yii::getAlias('@web/maucua/nhap-nhom-du/nhap-kho-theo-du-an?id='.$model->id), [
                        'role'=>'modal-remote-2',
                        'class'=>'btn btn-primary btn-sm'
                    ]) ?>
                    
                    		
                       <?php } ?>
                       
                      
                       <?php /* đang làm ?>
                       <a href="#" onClick="InPhieuThongTin()" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> In thông mẫu cửa</a>
                       <?php */ ?>
                       
                       <?php 
                       if($model->trang_thai != 'KHOI_TAO'){
                            //in qr code, dang thuc hien.....
                           echo Html::a('<i class="fa-solid fa-qrcode"></i> In QR Code',['/kho/qr/in-qrs-du-an','idDuAn'=>$model->id],[
                               'role'=>'modal-remote',
                               'class'=>'btn btn-primary btn-sm'
                           ]);
                       }
                       ?>
                           
                    <!-- tạm tắt bản in cũ -->   
                    <!-- 
                   <a href="#" onClick="InPhieuXuatKho()" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> In Phiếu xuất kho</a>
                    -->
                    
                    </p>
                   
                   
                   </fieldset>
                   <?php } //end giai doan xuat kho ?>
                   
                   
                   <?php } //end if has mauCua?>
                   
                   <!-- print phieu -->
                   <div style="display:none">
                        <div id="print">
                        	<?= $this->render('_print_phieu_xuat_kho', compact('model')) ?>
                        </div>
                   </div>
        
        
    			</div>
                <div class="col-md-8">
                    <div class="container indexPage" style="overflow:scroll;height:600px; font-size:95%;">
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
                            	
                                    if($cookieValue == 'danhSach'){
                                        echo $this->render('view_cua_item_ds', ['model'=>$model, 'cookieSearch'=>$cookieSearch]);
                                    } else {
                                        echo $this->render('view_cua_item_anh_lon', ['model'=>$model]);
                                    }
                        	?>
        						
                                <?php 
                                    /* foreach ($model->mauCuas as $iMau => $mau){
                                        echo $this->render('view_cua_item', ['model'=>$mau]);
                                    } */
                                ?>
                                
                        </div>
                    </div>
                </div>
			</div>
		</div><!-- tab pane -->
        <div class="tab-pane fade" id="toiuucat" role="tabpanel" aria-labelledby="toiuucat-tab">
        	<div id="cutImage" style="width:100%;overflow-x: scroll;overflow:scroll;height:600px;">
        		<?= $this->render('toiUuCatView', ['model'=>$model]) ?>
        	</div>
        </div><!-- tab pane -->
        
         <div class="tab-pane fade" id="tonghopnhom" role="tabpanel" aria-labelledby="tonghopnhom-tab">
        	<div id="tonghopnhom" style="width:100%;overflow-x: scroll;overflow:scroll;height:600px;">
        		<?= $this->render('_view_tongHopNhom', ['model'=>$model]) ?>
        	</div>
        </div><!-- tab pane -->
        
        <div class="tab-pane fade" id="tonghopvattu" role="tabpanel" aria-labelledby="tonghopvattu-tab">
        	<div id="tonghopvattu" style="width:100%;overflow-x: scroll;overflow:scroll;height:600px;">
        		<?= $this->render('_view_tongHopVatTu', ['model'=>$model]) ?>
        	</div>
        </div><!-- tab pane -->
        
	</div><!-- tab content -->

</div><!-- container -->


<script>
/** toi uu le */
function ToiUuLeDuAnTonKho(){
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

function ToiUuLeDuAnNhomMoi(){
    $.ajax({
      type: 'GET',
        dataType:"json",
      url: '/maucua/du-an/toi-uu-du-an-cho-tung-bo-cua?idDuAn=<?= $model->id ?>&type=catmoi',
      success: function (data, status, xhr) {
        	$('.completeAjax').html('<i class="fa-solid fa-thumbs-up"></i> ' + data.result);
      }
    });
}

/** toi uu chung cho toan du an */
function ToiUuDuAnTonKho(){
	$('.completeAjax').html('Đang xử lý...');
	
    $.ajax({
      type: 'GET',
      dataType:'json',
      url: '/maucua/du-an/toi-uu-toan-du-an?idDuAn=<?= $model->id ?>',
      success: function (data, status, xhr) {
      	$('.completeAjax').html('<i class="fa-solid fa-thumbs-up"></i> ' + data.result);
      	vueDuAnToiUu.results = data.nhomSuDung;
      }
    });
}

function ToiUuDuAnNhomMoi(){
    $.ajax({
      type: 'GET',
        dataType:"json",
      url: '/maucua/du-an/toi-uu-toan-du-an?idDuAn=<?= $model->id ?>&type=catmoi',
      success: function (data, status, xhr) {
        	$('.completeAjax').html('<i class="fa-solid fa-thumbs-up"></i> ' + data.result);
        	vueDuAnToiUu.results = data.nhomSuDung;
      }
    });
}

//in phieu thong tin
function InPhieuThongTin(){
	//load lai phieu in (tranh bi loi khi chinh sua du lieu chua update noi dung in)
	$.ajax({
        type: 'post',
        url: '/maucua/du-an/get-phieu-in-ajax?idDuAn=' + <?= $model->id ?> + '&type=phieuthongtin',
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

//in phieu xuat kho
function InPhieuXuatKho(){
	//load lai phieu in (tranh bi loi khi chinh sua du lieu chua update noi dung in)
	$.ajax({
        type: 'post',
        url: '/maucua/du-an/get-phieu-in-ajax?idDuAn=' + <?= $model->id ?> + '&type=phieuxuatkho',
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#print').html(data.content);
            	$('#divCutImage').html($('#cutImage').html());
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

//in phieu xuat kho
function InPhieuXuatKho2(){
	//load lai phieu in (tranh bi loi khi chinh sua du lieu chua update noi dung in)
	$.ajax({
        type: 'post',
        url: '/maucua/du-an/get-phieu-in-ajax2?idDuAn=' + <?= $model->id ?> + '&type=phieuxuatkho',
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#print').html(data.content);
            	$('#divCutImage').html($('#cutImage').html());
            	printPhieuXuat2();//call from script.js
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
        url: '/maucua/du-an/get-view-hien-thi-cua?idKeHoach=' + <?= $model->id ?> + '&type='+type,
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
            url: '/maucua/du-an/set-show-search?type=dsCua',
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
            url: '/maucua/du-an/set-show-search?type=none',
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
