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
			<h1 class="pageTitle">PHẦN MỀM QUẢN LÝ SẢN XUẤT CỬA (v0.3.1)</h1>
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
                      		<h5>Phiên bản 0.3.1</h5>
                      		<p>
                          		Ngày cập nhật:  10/09/2024
                          		<br/>
                          		Nội dung cập nhật:
                      		</p>
                      		<ul>
                      			<li>Thêm phiếu đánh giá cho mẫu cửa bao gồm các tiêu chí, 1 tiêu chí không đạt là mẫu cửa không đạt</li>
                      			<li>Cảnh báo qua Email khi có mẫu cửa không đạt yêu cầu</li>
                      			<li>Bổ sung cấu hình tài khoản nhận cảnh báo trong menu Tài Khoản</li>
                      			<li>Thêm cột chú thích cho mẫu cửa</li>
                      			<li>Thay đổi giao diện trang trạng thái cửa, thêm hình ảnh cửa, nhóm theo công trình, bổ sung thông tin và loại bỏ bớt thông tin loại cửa</li>
                      			<li>Sửa thông báo ngày giao hàng ưu tiên theo ngày khách hàng yêu cầu, tiếp theo đến ngày kết thúc dự án khi nhập thông tin</li>
                      			<li>Hiển thị màu cây nhôm trong chức năg thay đổi cây nhôm sử dụng cho nhiều hệ</li>
                      			
                      		</ul>
                      		<h5>Phiên bản 0.3.0</h5>
                      		<p>
                          		Ngày cập nhật:  29/08/2024
                          		<br/>
                          		Nội dung cập nhật:
                      		</p>
                      		<ul>
                      			<li>Thêm thay đổi nhôm cho mẫu cửa, thêm cây nhôm khác hệ nhôm vào mẫu cửa</li>
                      			<li>Thêm quản lý hệ màu cho hệ nhôm. Quản lý kho nhôm theo hệ màu, một mã nhôm có thể có nhiều màu</li>
                      			<li>Quản lý kho phụ kiện và vật tư theo hệ màu, cùng mã phụ kiện/vật tư có thể có nhiều màu khác nhau</li>
                      			<li>Thay đổi giao diện theo quản lý nhôm, phụ kiện, hiển thị tối ưu, nhôm sử dụng và phụ kiện</li>
                      			<li>Bổ sung các button để hạn chế đóng popup rồi tìm mở lại gây mất thời gian</li>
                      			<li>Cập nhật lại các mẫu file import theo quản lý kho theo màu của nhôm và phụ kiện</li>
                      		</ul>
                      		<h5>Phiên bản 0.2.3</h5>
                      		<p>
                          		Ngày cập nhật:  12/08/2024
                          		<br/>
                          		Nội dung cập nhật:
                      		</p>
                      		<ul>
                      			<li>Thêm Thông báo tồn kho và danh sách vật tư, phụ kiện sử dụng cho KHSX (chức năng thực thi sau khi thêm danh sách cửa vào KHSX)</li>
                      			<li>Thêm Thông báo tồn kho và danh sách nhôm sử dụng cho KHSX (chức năng sẽ thực thi sau khi tối ưu nhôm)</li>
                      			<li>Bổ sung chắc năng thêm danh sách cửa từ dự án/công trình vào KHSX trên giao diện xem KHSX. Từ kế hoạch chọn giao diện danh sách cửa để thêm vào kế hoạch. Trên giao diện thể hiện tên cửa, tên khách hàng, ngày thực hiện, ngày khách hàng yêu cầu cho từng bộ cửa (thêm cột dữ liệu). Có lọc dữ liệu theo ngày và hệ nhôm.</li>
                      			<li>Thêm giao diện hiển thị cho danh sách cửa dạng danh sách và dạng thumbnails, bổ sung tính năng tìm kiếm theo mẫu cửa, hệ nhôm... từ giao diện danh sách cửa quản lý công trình/dự án và quản lý KHSX</li>
                      			<li>Chỉnh lại giao diện mẫu cửa thuộc KHSX: thêm tên dự án.</li>
								<li>Sửa lỗi hiển thị nhiều cây nhôm trùng mã nhôm.</li>
                      		</ul>
                      		<h5>Phiên bản 0.2.2</h5>
                      		<p>
                          		Ngày cập nhật:  31/07/2024
                          		<br/>
                          		Nội dung cập nhật:
                      		</p>
                      		<ul>
                      			<li>Chỉnh sửa quy trình sản xuất cửa: nhập thông tin khách hàng -> tạo dự án của khách hàng -> import mẫu cửa -> thêm cửa vào kế hoạch sản xuất -> tối ưu -> xuất kho -> in phiếu sản xuất và tem nhãn</li>
                      			<li>Bổ sung chức năng in tem nhãn để dán vào nhôm dư sau khi cắt nhôm, tem hiển thị mã cây nhôm, hình ảnh Qr.</li>
                      			<li>Bổ sung chức năng quét mã QR qua camera điện thoại, sau khi quét hiển thị thông tin cây nhôm: mã nhôm, tên cây nhôm, số lượng tồn kho...</li>
                      			<li>In phiếu sản xuất hiển thị thông tin mẫu cửa trong Kế hoạch và bảng chi tiết nhôm đã tối ưu.</li>
                      		</ul>
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
                      		
                      		<h5>Yêu cầu ngày 15/08/2024</h5>
                      		<ul>
                      			<li>Quản lý nhôm: Sản xuất bộ cửa theo màu nhôm. Yêu cầu: Quản lý cây nhôm cùng hệ nhưng khác màu, tồn kho nhôm theo màu, tối ưu sản xuất cửa theo màu nhôm</li>
                      			<li>Quản lý màu phụ kiện: Sản xuất cửa theo màu phụ kiện. Yêu cầu: Thay đổi được bộ phụ kiện và màu sắc khi import mẫu cửa từ excel, quản lý tồn kho phụ kiện theo màu sắc</li>
                      			<li>Chỉnh sửa trường hợp cây nhôm (Ví dụ cây nẹp) sử dụng cho nhiều bộ cửa khác nhau, khác hệ nhôm và độ dày nhưng sử dụng chung cây nẹp.</li>
                      		</ul>
                      		<h5>Yêu cầu ngày 06/08/2024</h5>
                      		<ul>
                      			<li>Giao diện: Từ kế hoạch chọn giao diện danh sách cửa để thêm vào kế hoạch. Trên giao diện thể hiện tên cửa, tên khách hàng, ngày thực hiện, ngày khách hàng yêu cầu cho từng bộ cửa (thêm cột dữ liệu). Có lọc dữ liệu theo ngày và hệ nhôm.</li>
                      			<li>Độ dày nhôm: Xuất từ pm dowes không có độ dày, chỉ có độ dày của hệ nhôm. Mỗi cây nhôm có thể có độ dày khác, phương án là nhập độ dày của dowes là mặc định, còn lại cập nhật thêm cột độ dày thực tế.</li>
                      			<li>Chỉnh giao diện mẫu cửa thuộc KHSX: thêm tên dự án.</li>
								<li>Lỗi trùng cây nhôm cùng mã.</li>
                      		</ul>
                      		<h5>Yêu cầu của Duy ngày 10/7/2024</h5>
                      		<ul>
                      			<li>Tạo phiếu in Kế hoạch sản xuất cửa thể hiện chi tiết theo mẫu</li>
                      			<li>Quản lý được thời gian sản xuất và dự kiến thời gian giao cửa cho khách hàng</li>
                      		</ul>
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