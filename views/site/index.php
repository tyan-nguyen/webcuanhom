<?php

use yii\bootstrap5\Html;
use app\modules\maucua\models\Import;
use app\widgets\CustomModal;
use cangak\ajaxcrud\CrudAsset;

/** @var yii\web\View $this */
CrudAsset::register($this);
$this->title = 'Phần mềm Quản lý cửa';
?>

<div class="container indexPage">
	<div class="row mx-auto">
		<div class="col-md-12" style="margin-bottom: 10px;">
			<h1 class="pageTitle">PHẦN MỀM QUẢN LÝ SẢN XUẤT CỬA (v0.2.1)</h1>
		</div>
	</div>
    <div class="row">
    	<!-- thông tin cập nhật -->
    	<div class="col-md-6">
        	   <div class="card" style="max-width: 100%;">
        	   		   <div class="card-header bg-transparent text-center card-title">
                      		THÔNG TIN BẢN CẬP NHẬT
                      </div>
                      <div class="card-body p-3" style="overflow-y: scroll; height:600px;">
                      		<h5>Phiên bản 0.2.1</h5>
                      		<p>
                          		Ngày cập nhật:  19/06/2024
                          		<br/>
                          		Nội dung cập nhật:
                      		</p>
                      		<ul>
                      			<li>Cập nhật lại chức năng import tồn kho nhôm từ file excel và từ form nhập liệu.</li>
                      			<li>Sửa mẫu excel nhập liệu.</li>
                      			<li>Thêm trường thông tin độ dày.</li>
                      			<li>Thêm trường thông tin nhà cung cấp (hãng).</li>
                      			<li>Cập nhật chức năng quản lý cây nhôm: Nhiều cây nhôm có chung mã, khác nhau về độ dày, hãng nhôm. </li>
                      		</ul>
                      		
                      		<h5>Phiên bản 0.2.0</h5>
                      		<p>
                          		Ngày cập nhật:  15/06/2024
                          		<br/>
                          		Nội dung cập nhật:
                      		</p>
                      		<ul>
                      			<li>Chỉnh sửa chức năng tối ưu cắt nhôm cho toàn dự án theo nhôm mới/tồn kho.</li>
                      			<li>Bổ sung trường thông tin tối ưu toàn dự án, nếu bật giá trị này lên thì dự án sẽ tối ưu nhôm cho toàn bộ dự án. Nếu không bật lên thì chức năng tối ưu nhôm sẽ thực hiện cho từng mẫu cửa riêng lẻ.</li>
                      		</ul>
                      		
                      		<h5>Phiên bản 0.1.2</h5>
                      		<p>Bổ sung chức năng bán lẻ cho nhôm và phụ kiện</p>
                      		<ul>
                      			<li>Bổ sung mục hóa đơn bán lẻ</li>
                      			<li>Bổ sung quản lý thông tin khách hàng</li>
                      			<li>In ấn hóa đơn</li>
                      			<li>Xuất kho nhôm nguyên cây, nhôm lẻ và vật tư, phụ kiện khi có lệnh xuất kho</li>
                      			<li>Tính giá nhôm: nhập số cây nhôm -> tự tính ra số (Kg x Đơn giá)</li>
                      		</ul>
                      		<h5>Phiên bản 0.1.1</h5>
                      		<p>...</p>
                      		<h5>Phiên bản 0.1.0</h5>
                      		<p>...</p>
                      </div>
                     
                    </div>
        </div><!-- col-md-6 -->
        
        <!-- tính năng đang phát triển -->
        <div class="col-md-6">
        	   <div class="card" style="max-width: 100%;">
        	   		   <div class="card-header bg-transparent text-center card-title">
                      		CÁC CHỨC NĂNG ĐANG PHÁT TRIỂN
                      </div>
                      <div class="card-body p-3" style="overflow-y: scroll; height:600px;">
                      		<h5>Yêu cầu của Duy ngày 16/6</h5>
                      		<ul>
                      			<li style="text-decoration: underline;">Mã nhôm: cùng mã, khác hãng (nhà cung cấp) và độ dầy (<span style="color:#3c8dbc">đã thực hiện</span>)</li>
                      			<li>Phần tối ưu cắt: cùng mã ở gần nhau, thể hiện ký hiệu cửa, và độ dày. Cài chặn trên và chặn dưới.</li>
                      			<li>Xuất vật tư theo bộ cửa, hoặc tạm thời nhập tạm theo dự án.</li>
                      		</ul>
                      		
                      		<h5>Các chức năng đang thực hiện</h5>
                      		<ul>
                      			<li>Phần vật tư: chuyển đổi vật tư theo đơn vị tính. Kg->số lượng</li>
                      			<li>Phần báo giá: Nhập cửa -> nhập kích thước -> in ra báo giá theo nhôm và vật tư, phụ kiện (có thể thay đổi theo nhóm phụ kiện khác nhau)</li>
                      			<li>In tem để dán vô cây nhôm dư</li>
                      			<li>Xuất/Nhập kho nhôm lẻ phải kèm theo mã để thủ kho dễ tìm kiếm trong kho</li>
                      		</ul>
                      		
                      		<h5>Chức năng định hướng phát triển tiếp theo</h5>
                      		<ul>
                      			<li>Quản lý toàn bộ quy trình</li>
                      		</ul>
                      		
                      </div>
                     
                    </div>
        </div><!-- col-md-6 -->
        
        <?php /* ?>
        <div class="col-md-6">
        	 <div class="card" style="max-width: 100%;">
        	 <div class="card-header bg-transparent text-center card-title">
              	MỤC QUẢN LÝ
              </div>
        	  <div class="card-body p-3">	
        	<div class="row">
                <div class="col-xl-4 col-md-4 col-sm-6 mb-4">
                    <div class="card" style="max-width: 100%;">
                      <div class="card-body p-0">
                        <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
                      </div>
                      <div class="card-footer bg-transparent text-center">
                      	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý dự án', Yii::getAlias('@web/maucua/du-an'), ['class'=>'card-link-custom']) ?>
                      </div>
                    </div>
                </div>
                
                <div class="col-xl-4 col-md-4 col-sm-6 mb-4">
                    <div class="card" style="max-width: 100%;">
                      <div class="card-body p-0">
                        <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
                      </div>
                      <div class="card-footer bg-transparent text-center">
                      	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý Mẫu cửa', Yii::getAlias('@web/maucua/mau-cua'), ['class'=>'card-link-custom']) ?>
                      </div>
                    </div>
                </div>
                
                <div class="col-xl-4 col-md-4 col-sm-6 mb-4">
                    <div class="card" style="max-width: 100%;">
                      <div class="card-body p-0">
                        <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
                      </div>
                      <div class="card-footer bg-transparent text-center">
                      	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý Loại cửa', Yii::getAlias('@web/maucua/loai-cua'), ['class'=>'card-link-custom']) ?>
                      </div>
                    </div>
                </div>
                
                <div class="col-xl-4 col-md-4 col-sm-6 mb-4">
                    <div class="card" style="max-width: 100%;">
                      <div class="card-body p-0">
                        <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
                      </div>
                      <div class="card-footer bg-transparent text-center">
                      	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý Loại nhôm', Yii::getAlias('@web/maucua/he-nhom'), ['class'=>'card-link-custom']) ?>
                      </div>
                    </div>
                </div>
                
                <div class="col-xl-4 col-md-4 col-sm-6 mb-4">
                    <div class="card" style="max-width: 100%;">
                      <div class="card-body p-0">
                        <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
                      </div>
                      <div class="card-footer bg-transparent text-center">
                      	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý Kho vật tư', Yii::getAlias('@web/kho/kho-vat-tu'), ['class'=>'card-link-custom']) ?>
                      </div>
                    </div>
                </div>
                
                <div class="col-xl-4 col-md-4 col-sm-6 mb-4">
                    <div class="card" style="max-width: 100%;">
                      <div class="card-body p-0">
                        <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
                      </div>
                      <div class="card-footer bg-transparent text-center">
                      	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý Kho nhôm', Yii::getAlias('@web/kho/kho-nhom'), ['class'=>'card-link-custom']) ?>
                      </div>
                    </div>
                </div>
                
                <div class="col-xl-4 col-md-4 col-sm-6 mb-4">
                    <div class="card" style="max-width: 100%;">
                      <div class="card-body p-0">
                        <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
                      </div>
                      <div class="card-footer bg-transparent text-center">
                      	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý Cây nhôm', Yii::getAlias('@web/mau-cua/cay-nhom'), ['class'=>'card-link-custom']) ?>
                      </div>
                    </div>
                </div>
                
                <div class="col-xl-4 col-md-4 col-sm-6 mb-4">
                    <div class="card" style="max-width: 100%;">
                      <div class="card-body p-0">
                        <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
                      </div>
                      <div class="card-footer bg-transparent text-center">
                      	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý Hệ nhôm', Yii::getAlias('@web/kho/he-nhom'), ['class'=>'card-link-custom']) ?>
                      </div>
                    </div>
                </div>
               
        	</div><!-- row -->
        	 </div><!-- card-body -->
        	</div><!-- card -->
        </div><!-- col-md-6 -->   <?php */ ?>     
        
    </div><!-- row -->
</div>

<?php CustomModal::begin([
   "options" => [
        "id"=>"ajaxCrudModal",
        "tabindex" => false // important for Select2 to work properly
    ],
   'dialogOptions'=>['class'=>'modal-xl modal-dialog-centered'],
   "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php CustomModal::end(); ?>