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

<div class="du-an-view container">
	
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Thông tin Kế hoạch/Dự án</button>
        </li>
        <?php if($model->toi_uu_tat_ca == 1) {?>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="toiuucat-tab" data-bs-toggle="tab" data-bs-target="#toiuucat" type="button" role="tab" aria-controls="toiuucat" aria-selected="false">Tối ưu cắt</button>
            </li>
        <?php } ?>
    </ul>

 	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                    ]) ?>
        
                    <?php 
                    if($model->trang_thai == 'KHOI_TAO' || $model->trang_thai == 'THUC_HIEN' || $model->trang_thai == 'TOI_UU'){ 
                        ?>
                        
                        <?php if($model->toi_uu_tat_ca == 0 || $model->toi_uu_tat_ca == NULL) { ?>
                        <strong>TỐI ƯU TỪNG MẪU CỬA RIÊNG</strong>
                        <br/>
                        <a href="#" onclick="ToiUuLeDuAnTonKho()" class="btn btn-primary btn-sm">Tối ưu tất cả mẫu cửa từ kho nhôm</a>
                        <a href="#" onclick="ToiUuLeDuAnNhomMoi()" class="btn btn-primary btn-sm">Tối ưu tất cả mẫu cửa từ nhôm mới</a>
                        
                        <?php } ?>
                        <?php if($model->toi_uu_tat_ca == 1) { ?>
                        
                        <strong>TỐI ƯU CHO TOÀN KẾ HOẠCH/DỰ ÁN</strong>
                        <br/>
                        <a href="#" onclick="ToiUuDuAnTonKho()" class="btn btn-primary btn-sm">Tối ưu tất cả mẫu cửa từ kho nhôm</a>
                        <a href="#" onclick="ToiUuDuAnNhomMoi()" class="btn btn-primary btn-sm">Tối ưu tất cả mẫu cửa từ nhôm mới</a>
                     	<?php } ?>   
                        <div>
                            <span class="loadingAjax" style="display:none"><img src="/images/loading.gif" width="50" alt="loading..." /></span>
                            <span class="completeAjax text-primary" style="display:none"></span>
                    	</div>
                    <?php } ?>
                    <br/>
                    
                    <?php if($model->toi_uu_tat_ca == 1) { ?>
                    
                     <strong>GIAI ĐOẠN XUẤT KHO</strong>
                     <br/>
                     <?php 
                        if($model->trang_thai == 'TOI_UU'){                      
                           echo Html::a('Xuất kho',['xuat-kho','id'=>$model->id],[
                               'role'=>'modal-remote',
                               'class'=>'btn btn-primary btn-sm'
                            ]);
                      } ?>
                      &nbsp;
                       <?php 
                       if($model->trang_thai == 'DA_XUAT_KHO' || $model->trang_thai == 'TOI_UU' || $model->trang_thai == 'DA_NHAP_KHO'){                      
                       ?>
                        <?= Html::a('<i class="fa-solid fa-file-import"></i> Nhập nhôm dư', Yii::getAlias('@web/maucua/nhap-nhom-du/nhap-kho-theo-du-an?id='.$model->id), [
                        'role'=>'modal-remote-2',
                        'class'=>'btn btn-primary btn-sm'
                    ]) ?>
                       <?php } ?>
                       
                      &nbsp;
                       <?php /* đang làm ?>
                       <a href="#" onClick="InPhieuThongTin()" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> In thông mẫu cửa</a>
                       <?php */ ?>
                   <a href="#" onClick="InPhieuXuatKho()" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> In Phiếu xuất kho</a>
                   
                   <?php } //end giai doan xuat kho ?>
                   
                   <!-- print phieu -->
                   <div style="display:none">
                        <div id="print">
                        	<?= $this->render('_print_phieu_xuat_kho', compact('model')) ?>
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
        <div class="tab-pane fade" id="toiuucat" role="tabpanel" aria-labelledby="toiuucat-tab">
        	<div id="cutImage" style="width:100%;overflow-x: scroll;overflow:scroll;height:600px;">
        		<?= $this->render('toiUuCatView', ['model'=>$model]) ?>
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
</script>
