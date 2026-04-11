<?php
use yii\helpers\Html;
use app\custom\CustomFunc;
use app\modules\users\models\TaiKhoan;

$custom = new CustomFunc();
?>
<!-- <link href="/css/print-hoa-don.css" rel="stylesheet"> -->
<div class="row text-center" style="width: 100%">
    <div class="col-md-12" style="width: 100%"> 
    	<table id="table-top" style="width: 100%">
    		<tr>
    			<td width="80px">
    				<img src="/images/logo_500.png" width="75px" />
    			</td>
    			<td>
    				<span style="font-weight: bold; font-size:12pt">CÔNG TY TNHH MỘT THÀNH VIÊN NGUYỄN TRÌNH</span>
    				<br/>
    				<span style="font-size:10pt">Lô E, Khu Công Nghiệp Long Đức, xã Long Đức, tỉnh Vĩnh Long</span>
    				<br/>
    				<span style="font-size:10pt">ĐT: 0903 794 553</span>			
    			</td>
    			<td width="100px">
    				<div style="font-size:12px"><?= $model->soHoaDon ?> </div>
    				<div style="margin-top: 10px;font-size:11px">
    					<span class="span-status"><?= $model->getDmTrangThaiLabel($model->trang_thai) ?></span> 					</div>
    			</td>
    		</tr>
    	</table>
    	
    	<table style="width: 100%">
    		<tr>
    			<td style="text-align: center"><span class="phieu-h1">PHIẾU XUẤT KHO</span></td>
    		</tr>
    	</table>
    	
    	<table id="table-info" style="width: 100%; margin-top:10px;">
    		<tr>
    			<td>
    				Khách hàng: <?= $model->tenKhachHang ?>			
    			</td>
				<td>
    				Số điện thoại: <?= $model->sdtKhachHang ?>	
    			</td>
    		</tr>
    		<tr>
    			<td colspan="2">
    				Địa chỉ: <?= $model->diaChiKhachHang ?>	
    			</td>
    		</tr>
    		<!-- <tr>
    			<td>
    				- Số điện thoại: <?= $model->sdtKhachHang ?>	
    			</td>

    			<td>
    				- Email: <?= $model->emailKhachHang ?>
    			</td>
    		</tr>-->
    		
    	</table>
    	
    	<table id="table-content" style="width: 100%; margin-top:10px;">
    		<thead>
    			<tr style="font-weight:bold">
        			<td style="width:5%">STT</td>
					<td style="width:15%">Mã hàng</td>
        			<td style="width:27%">Tên hàng</td>
        			<td style="width:10%">Màu</td>
        			<td style="width:8%">ĐVT</td>
        			<td style="width:8%">SL</td>
        			<td style="width:12%">Đơn giá</td>
        			<td style="width: 18%">Thành tiền</td>
    			</tr>
    		</thead>
    		<tbody>
    			<?php 
    			$stt = 0;
    			foreach ($model->hoaDonChiTiets as $iVT=>$vt){
    			    $stt++;
    			?>
    			<tr>
        			<td style="text-align:center"><?= $stt ?></td>
					<td style="text-align:center"><?= $vt->maVatTu ?></td>
					<td><?= $vt->tenVatTu ?></td>
        			<?php /* $vt->tenVatTu . ($vt->vatTu->heMau?(' - ' . $vt->vatTu->heMau->code):'')*/ ?></td>
					<td style="text-align:center"><?= $vt->maMau ?></td>
        			<td style="text-align:center"><?= $vt->dvtVatTu ?></td>
        			<td style="text-align:right"><?= $vt->soLuong ?></td>
        			<td style="text-align:right"><?= number_format($vt->donGia) ?></td>
        			<td style="text-align:right;font-weight: bold"><?= number_format($vt->thanhTien) ?></td>
        			<!-- <td style="text-align:center"><?= $vt->ghiChu ?></td>-->
    			</tr>
    			<?php 
    			}
    			?>
    			
    			<tr style="text-align:right;font-weight: bold">
        			<td colspan="7">Tổng cộng:</td>
        			<td><?= number_format($model->tongTien) ?></td>
    			</tr>
    			
    		</tbody>
    	</table>
    	
    	<p style="margin-top:6pt">Tổng số tiền bằng chữ: <strong><?= $custom->chuyenSoTienThanhChu($model->tongTien) ?> đồng.</strong></p>
    	
    	<table id="table-ky-ten" style="width: 100%; margin-top:10px;">
    		<tr>
				<td style="width: 50%;"></td>
    			<td style="width: 50%;text-align:center;font-weight:normal;font-style:italic">Vĩnh Long, ngày <?= date('d') ?> tháng <?= date('m') ?> năm <?= date('Y') ?></td>
    		</tr>
    	</table>
    	
    	<table id="table-ky-ten" style="width: 100%; margin-top:10px;">
    		<tr>
    			<td style="text-align:center;font-weight:bold;">KHÁCH HÀNG</td>
    			<td style="text-align:center;font-weight:bold;">NHÂN VIÊN</td>
    		</tr>
			<tr>
    			<td style="text-align:center;font-weight:bold;"></td>
    			<td style="text-align:center;font-weight:bold;font-style:normal"><br/><br/><br/><?= TaiKhoan::getNameById($model->user_created) ?></td>
    		</tr>
    	</table>
    	
    	
    	
    	
    	
    	   
    </div>
</div> <!-- row -->