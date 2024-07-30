<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\banle\models\KhachHang;

/* @var $this yii\web\View */
/* @var $model app\modules\banle\models\HoaDon */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- <script src="/js/vue.js"></script>-->
<link href="/js/select2/select2.min.css" rel="stylesheet" />
<script src="/js/select2/select2.min.js"></script>

<style>
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 22px!important;
}
.hoa-don-form .btn{
    padding:2px 5px;
    font-size:12px;
}
#idTr input, #idTrUpdate input{
   width: 100px;
}
</style>

<div class="wrap-status">
	<span>
		<?= $model->getDmTrangThaiLabel($model->trang_thai) ?>
	</span>
</div>

<div class="hoa-don-form" style="margin-top:10px;">

<!-- <a href="/banle/hoa-don/xuat-khong-thanh-toan?id=<?= $model->id ?>" role="modal-remote">Xuất không thanh toán</a>  -->

    <?php $form = ActiveForm::begin([
        'action' => '/banle/hoa-don/update?id=' . $model->id,
    ]); ?>
    
    <div class="row">
    	<div class="col-md-6">
        	<?php 
        	   $khLabel = $model->getAttributeLabel('id_khach_hang') . ' <a href="/banle/khach-hang/create-popup" role="modal-remote-2" style="padding-left:10px;" title="Thêm khách hàng"><i class="fa-solid fa-square-plus"></i></a> <a href="#" onclick="runFunc('.$model->id_khach_hang.')" style="padding-left:10px;" title="Thêm đơn vị tính"><i class="fa-solid fa-retweet"></i></a>';
        	?>
	
    		<?= $form->field($model, 'id_khach_hang')->dropDownList(KhachHang::getList(), ['prompt'=>'-Chọn-', 'id'=>'ddlKhachHang'])->label($khLabel) ?>
    	</div>
    	<div class="col-md-6">
    		 <?= $form->field($model, 'diaChiKhachHang')->textInput(['id'=>'txtDiaChiKhachHang', 'disabled'=>'disabled'])->label('Địa chỉ') ?>
    	</div>
    	<div class="col-md-6">
    		 <?= $form->field($model, 'sdtKhachHang')->textInput(['id'=>'txtSdtKhachHang', 'disabled'=>'disabled'])->label('Số điện thoại') ?>
    	</div>
    	<div class="col-md-6">
    		 <?= $form->field($model, 'emailKhachHang')->textInput(['id'=>'txtEmailKhachHang', 'disabled'=>'disabled'])->label('Email') ?>
    	</div>
    </div>
    
    <?= $form->field($model, 'edit_mode')->checkbox() ?>
    
    <?php //$form->field($model, 'id_khach_hang')->dropDownList(KhachHang::getListKhachHang(), ['prompt'=>'-Chọn-']) ?>
	
	<!-- 
    <?= $form->field($model, 'ma_hoa_don')->textInput() ?>

    <?= $form->field($model, 'so_vao_so')->textInput() ?>

    <?= $form->field($model, 'nam')->textInput() ?>

    <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'id_nguoi_lap')->textInput() ?>

    <?= $form->field($model, 'ngay_lap')->textInput() ?>

    <?= $form->field($model, 'trang_thai')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_created')->textInput() ?>

    <?= $form->field($model, 'user_created')->textInput() ?>
    -->
   
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Ghi dữ liệu' : 'Cập nhật dữ liệu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
    <div id="objDanhSachVatTu" style="margin-top:10px;">
    <div class="row">
    	<div class="col-xs-12 table-responsive">
        	<div class="box">
        		<div class="box-header">
        			<h3 class="box-title">CHI TIẾT VẬT TƯ</h3>
        		</div>
        		<div class="box-body no-padding">
        			<!-- <button type="button" onClick="AddVatTu()">Thêm vật tư</button> -->
        			<form id="idForm" method="post" action="/banle/hoa-don-chi-tiet/save-vat-tu?id=<?= $model->id ?>">
                		<table id="vtTable" class="table table-striped">
                			<thead>
                				<tr>
                					<th style="width:5%">STT</th>
                					<th style="width:15%">Loại vật tư</th>
                					<th style="width:20%">Vật tư</th>
                					<th style="width:10%">ĐVT</th>			
                					<th style="width:10%">Số lượng</th>
                					<th style="width:10%">Đơn giá(VND)</th>
                					<th style="width:10%">Thành tiền(VND)</th>
                					<!-- <th style="width:10%">Ghi chú</th>-->
                					<th style="width:20%"></th>
                				</tr>
                			</thead>
                    		<tbody>
                    			<tr :id="'tr' + result.id" v-for="(result, indexResult) in results.dsVatTu" :key="result.id">
                    				<td :id="'td' + indexResult">{{ (indexResult + 1) }}</td>
                    				<td>{{ result.loaiVatTu }}</td>
                    				<td>{{ result.tenVatTu }}</td>
                    				<td>{{ result.dvt }}</td>
                    				<td>{{ result.soLuong.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                    				<td>{{ result.donGia.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                    				<td>{{ result.thanhTien!=null?result.thanhTien.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0 }}</td>
                    				<!-- <td>{{ result.ghiChu }}</td> -->
								
									<td>
                    				<?php if($model->trang_thai=='BAN_NHAP' || $model->edit_mode){ ?>
                    					<span class="lbtn-remove btn btn-primary btn-sm" v-on:click="editVT(indexResult, 0)"><i class="fa fa-edit"></i> Sửa</span>
                    					<span class="lbtn-remove btn btn-danger btn-sm" v-on:click="deleteVT(result.id)"><i class="fa fa-trash"></i> Xóa</span>
                    					<?php } ?> 
                    					
                    			<?php /*if($model->trang_thai!='BAN_NHAP' && $model->edit_mode==1){ ?>
                    					<span class="lbtn-remove btn btn-default btn-xs" v-on:click="editVT(indexResult, 1)"><i class="fa fa-edit"></i> Sửa</span>
                    					<?php }*/ ?>                        					
                    					
                    				</td>
                    			</tr>
                    		</tbody>
                    		 <tfoot>
                				<tr>
                                  	<th colspan="6" style="text-align: right">Tổng cộng</th>
                					<th colspan="2"><span style="font-weight:bold">{{ results.tongTien!=null?results.tongTien.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0 }} (VND)</span></th>
                					<!-- <th style="width:10%">Ghi chú</th>-->
                                </tr>

                              </tfoot>
                		</table>
                    	
                    	</form>
                </div>
            </div>
    	</div>
    </div>
</div><!-- end #obj -->

    
</div>

<?php if($model->trang_thai=='BAN_NHAP' || $model->edit_mode){ ?>
<a href="#" onClick="AddVatTu()" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Thêm VT/PK</a>
<a href="#" onClick="AddNhom()" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Thêm nhôm</a>
<?php } ?>
<a href="#" onClick="InHoaDon()" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> In Hóa đơn</a>

<?php if($model->trang_thai == 'BAN_NHAP') { ?>
<a class="btn btn-primary btn-sm" href="/banle/hoa-don/xuat-va-thanh-toan?id=<?= $model->id ?>" role="modal-remote"><i class="fa-solid fa-file-export"></i> Xuất và thanh toán</a>
<?php } ?>

<div style="display:none">
<div id="print">
<?= $this->render('_print_phieu', compact('model')) ?>
</div>
</div>


<script type="text/javascript">
var vue10 = new Vue({
	el: '#objDanhSachVatTu',
	data: {
		results: <?= json_encode($model->dsVatTuYeuCau()) ?>
	},
	methods: {
		editVT: function (indexResult) {
          editVatTu(this.results.dsVatTu[indexResult]);
        },
        deleteVT: function (id) {
            var result = confirm("Xác nhận xóa vật tư đề nghị khỏi phiếu yêu cầu?");
            if (result) {
                deleteVatTu(id);
            }          
        }
	},
	computed: {
	}
});

/* function getDataa(){
    $.ajax({
      type: 'GET',
      dataType:"json",
      url: '/maucua/mau-cua/get-data',
      success: function (data, status, xhr) {
        	vue10.results = data.result;
      }
    });
} */

function deleteVatTu(id){
	$.ajax({
        type: 'post',
        url: '/banle/hoa-don-chi-tiet/delete-vat-tu?id=' + id,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	vue10.results = data.results;
            } else if(data.status == 'error'){
            	alert(data.message);
            }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}

function AddVatTu(){
	var formRow = '<tr id="idTr">';
	formRow += '<td>STT</td>';
	formRow += '<td><div style="display:none"><input type="text" name="loaiVatTu" id="lvtNew" value="VAT-TU" /></div><span id="loaiVatTuNew">Loại vật tư</span></td>';
	formRow += '<td><select id="idVatTuAdd" name="idVatTu" required></select></td>';
	formRow += '<td><span id="donViTinhNew">Đơn vị tính</span></td>';
	formRow += '<td><input type="text" name="soLuong" id="soLuongNew" required/></td>';	
	formRow += '<td><input type="text" name="donGia" id="donGiaNew" required/></td>';
	formRow += '<td><span id="thanhTienNew">Thành tiền</span></td>';
	//formRow += '<td><input type="text" name="ghiChu" /></td>';
	formRow += '<td><button type="submit" form="idForm" value="Submit" class="lbtn-remove btn btn-warning btn-sm"><i class="fa-solid fa-database"></i> Lưu</button> <span class="lbtn-remove btn btn-secondary btn-sm" onClick="remove()"><i class="fa-solid fa-xmark"></i> Bỏ qua</span></td>';
	formRow += '</tr>';
    
    if($('#idTr').length <= 0){
    	$('#vtTable tbody').append(formRow);
    	
    	//fill dropdown vat tu
    	fillVatTuDropDown('#idVatTuAdd', '');
    	
    	$('#idVatTuAdd').select2({
    		dropdownParent: $('#ajaxCrudModal'),
          	selectOnClose: true,
          	width: '100%'
        });
        $('#idVatTuAdd').on("select2:select", function(e) { 
           //alert(this.value);
           getVatTuAjax(this.value);
        });
        //focus and open select 2
       // $('#idVatTuAdd').select2('focus');
       // $('#idVatTuAdd').select2('open');
        
        
        $("#soLuongNew").on("input", function() {
          // alert($(this).val()); 
           $('#thanhTienNew').text(($(this).val()*$('#donGiaNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        });
        $("#donGiaNew").on("input", function() {
           //alert($(this).val()); 
           $('#thanhTienNew').text(($(this).val()*$('#soLuongNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        });
    } else {
    	alert('Vui lòng lưu dữ liệu đang nhập trước!');
    }
}

function AddNhom(){
	var formRow = '<tr id="idTr">';
	formRow += '<td>STT</td>';
	formRow += '<td><div style="display:none"><input type="text" name="loaiVatTu" id="lvtNew" value="NHOM" /></div><span id="loaiVatTuNew">Loại vật tư</span></td>';
	formRow += '<td><select id="idVatTuAdd" name="idVatTu" required></select></td>';
	formRow += '<td><span id="donViTinhNew">Đơn vị tính</span></td>';
	formRow += '<td><input type="text" name="soLuong" id="soLuongNew" required/></td>';	
	formRow += '<td><input type="text" name="donGia" id="donGiaNew" required/></td>';
	formRow += '<td><span id="thanhTienNew">Thành tiền</span></td>';
	//formRow += '<td><input type="text" name="ghiChu" /></td>';
	formRow += '<td><button type="submit" form="idForm" value="Submit" class="lbtn-remove btn btn-warning btn-sm"><i class="fa-solid fa-database"></i> Lưu</button> <span class="lbtn-remove btn btn-secondary btn-sm" onClick="remove()"><i class="fa-solid fa-xmark"></i> Bỏ qua</span></td>';
	formRow += '</tr>';
    
    if($('#idTr').length <= 0){
    	$('#vtTable tbody').append(formRow);
    	
    	//fill dropdown vat tu
    	fillNhomDropDown('#idVatTuAdd', '');
    	
    	$('#idVatTuAdd').select2({
    		dropdownParent: $('#ajaxCrudModal'),
          	selectOnClose: true,
          	width: '100%'
        });
        $('#idVatTuAdd').on("select2:select", function(e) { 
           //alert(this.value);
           getNhomAjax(this.value);
        });
        //focus and open select 2
       // $('#idVatTuAdd').select2('focus');
       // $('#idVatTuAdd').select2('open');
        
        
        $("#soLuongNew").on("input", function() {
          // alert($(this).val()); 
           $('#thanhTienNew').text(($(this).val()*$('#donGiaNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        });
        $("#donGiaNew").on("input", function() {
           //alert($(this).val()); 
           $('#thanhTienNew').text(($(this).val()*$('#soLuongNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        });
    } else {
    	alert('Vui lòng lưu dữ liệu đang nhập trước!');
    }
}

function editVatTu(arr){
	if ($("#idTrUpdate").length > 0){
		alert('Bạn đang chỉnh sửa vật tư yêu cầu, vui lòng lưu dữ liệu hoặc hủy bỏ để tránh mất dữ liệu!');
	} else {
    	//alert(arr['slyc']);
    	var formRow = '<tr id="idTrUpdate">';
    	formRow += '<td><input type="text" name="id" value="' + arr['id'] + '" style="display:none" />'+ arr['id'] +'</td>';
    	formRow += '<td>'+ arr['loaiVatTu'] +'</td>';
    	formRow += '<td>'+ arr['tenVatTu'] +'</td>';
    	//formRow += '<td><select id="idVatTuEdit" name="idVatTu"></select></td>';
    	formRow += '<td>'+ (arr['loaiVatTu']=='NHOM' ? arr['dvtCayNhom'] : arr['dvt']) +'</td>';
    	formRow += '<td><input type="text" name="soLuong" value="' + (arr['loaiVatTu']=='NHOM' ? arr['soLuongCayNhom'] : arr['soLuong'] ) + '" id="soLuongEdit" required /></td>';    		
    	formRow += '<td><input type="text" name="donGia" value="' + arr['donGia'] + '" id="donGiaEdit" required /></td>';
    	formRow += '<td><span id="thanhTienEdit">'+ arr['thanhTien'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +' </span></td>';
    	//formRow += '<td><input type="text" name="ghiChu" value="' + arr['ghiChu'] + '" /></td>';
    	formRow += '<td><button type="submit" form="idForm" value="Submit" class="lbtn-remove btn btn-warning btn-sm"><i class="fa-solid fa-database"></i> Lưu</button> <span class="lbtn-remove btn btn-secondary btn-sm" onClick="removeEdit()"><i class="fa-solid fa-xmark"></i> Bỏ qua</span> </td>';
    	formRow += '</tr>';
    	
    	$('#tr' + arr['id']).hide();
    	$('#tr' + arr['id']).after(formRow);
    	
    	$('#idTrUpdate input[name="slyc"]').focus();
    	$('#idTrUpdate input[name="slyc"]').select();
    	
    	//fill dropdown vat tu
    	//fillVatTuDropDown('#idVatTuEdit', arr['idVatTu']);
    	/* $('#idVatTuEdit').select2({
          placeholder: 'Select an option',
           width: '100%'
        }); */

        $("#soLuongEdit").on("input", function() {
           $('#thanhTienEdit').text(($(this).val()*$('#donGiaEdit').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
       $("#donGiaEdit").on("input", function() {
           //alert($(this).val()); 
           $('#thanhTienEdit').text(($(this).val()*$('#soLuongEdit').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
});
        });
        
        
	}
}

function removeEdit(){
	if ($("#idTrUpdate").length > 0){
		$('#idTrUpdate').prev("tr").show();
		$('#idTrUpdate').remove();
	}
}

function remove(){
	if ($("#idTr").length > 0){
		$('#idTr').remove();
	}
}

var frm = $('#idForm');

frm.submit(function (e) {

    e.preventDefault();
    $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);
            if(data.status == 'success'){
                if(data.type=='create'){
                	$('#idTr').remove();
                } else if(data.type == 'update'){
                	$('#idTrUpdate').remove();
                	$('#tr' + data.vatTuXuat['id']).show();
                }
                vue10.results = data.results
            } else if(data.status == 'error'){
            	alert(data.message);
            }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
});

function fillVatTuDropDown(dropdownId, selected){

    $.ajax({
        type: 'post',
        url: '/banle/hoa-don-chi-tiet/get-list-vat-tu?selected=' + selected,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            $(dropdownId).html(data.options);
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}

function getVatTuAjax(idvt){
    $.ajax({
        type: 'post',
        url: '/banle/hoa-don-chi-tiet/get-vat-tu-ajax?idvt=' + idvt,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#idTr #donGiaNew').val(data.donGia);
            	$('#idTr #loaiVatTuNew').text(data.loaiVatTu);
            	$('#idTr #donViTinhNew').text(data.dvt);
            	$('#idTr #soLuongNew').val(1);
            	//set thanh tien
            	$('#thanhTienNew').text(($('#soLuongNew').val()*$('#donGiaNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
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

function fillNhomDropDown(dropdownId, selected){

    $.ajax({
        type: 'post',
        url: '/banle/hoa-don-chi-tiet/get-list-nhom?selected=' + selected,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            $(dropdownId).html(data.options);
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}

function getNhomAjax(idvt){
    $.ajax({
        type: 'post',
        url: '/banle/hoa-don-chi-tiet/get-nhom-ajax?idvt=' + idvt,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#idTr #donGiaNew').val(data.donGia);
            	$('#idTr #loaiVatTuNew').text(data.loaiVatTu);
            	$('#idTr #donViTinhNew').text(data.dvt);
            	$('#idTr #soLuongNew').val(1);
            	//set thanh tien
            	$('#thanhTienNew').text(($('#soLuongNew').val()*$('#donGiaNew').val()).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
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

function InHoaDon(){
	//load lai phieu in (tranh bi loi khi chinh sua du lieu chua update noi dung in)
	$.ajax({
        type: 'post',
        url: '/banle/hoa-don/get-phieu-xuat-kho-in-ajax?idHoaDon=' + <?= $model->id ?>,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#print').html(data.content);
            	printHoaDon();//call from script.js
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

function getKhachHangAjax(idkh){
    $.ajax({
        type: 'post',
        url: '/banle/hoa-don-chi-tiet/get-khach-hang-ajax?idkh=' + idkh,
        //data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);            
            if(data.status == 'success'){
            	$('#txtDiaChiKhachHang').val(data.diaChiKhachHang);
            	$('#txtSdtKhachHang').val(data.sdtKhachHang);
            	$('#txtEmailKhachHang').val(data.emailKhachHang);
            } else {
            	alert('Thông tin Khách hàng không còn tồn tại trên hệ thống!');
            }
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
}
$('#ddlKhachHang').select2({
	dropdownParent: $('#ajaxCrudModal'),
  	selectOnClose: true,
  	width: '100%'
});
$('#ddlKhachHang').on("select2:select", function(e) { 
   if(this.value != ''){
   		getKhachHangAjax(this.value);
   } else {
   		$('#txtDiaChiKhachHang').val('');
    	$('#txtSdtKhachHang').val('');
    	$('#txtEmailKhachHang').val('');
   }
});


function runFunc(sendVal){
	var url = '/banle/khach-hang/refresh-data?selected=' + sendVal;
	$.ajax({
        url: url,
        method: 'GET',
        //data: data,
        /* beforeSend: function () {
            beforeRemoteRequest.call(instance);
        }, */
        /* error: function (response) {
            errorRemoteResponse.call(instance, response);
        }, */
        success: function (response) {
            $('#ddlKhachHang').html(response.options);
        },
        contentType: false,
        cache: false,
        processData: false
   });
}


$.fn.modal.Constructor.prototype.enforceFocus = function() {};

</script>