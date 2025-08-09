<?php
use yii\helpers\Html;
use app\custom\CustomFunc;
$custom = new CustomFunc();
?>
<!-- <link href="/css/print-hoa-don.css" rel="stylesheet"> -->
<div class="row text-center" style="width: 100%">
    <div class="col-md-12" style="width: 100%"> 
    	<table id="table-top" style="width: 100%">
    		<tr>
    			<td width="100px">
    				<img src="/images/logo_500.png" width="100px" />
    			</td>
    			<td>
    				<span style="font-weight: bold; font-size:14pt">DNTN SX-TM NGUYỄN TRÌNH</span>
    				<br/>
    				<span style="font-size:10pt">ĐC: Nguyễn Đáng, Khóm 10, P.9, TP.TV</span>
    				<br/>
    				<span style="font-size:10pt">ĐT: 0903.794.530 - 0903.794.531 - 0903.794.532</span>
    				<br/>
    				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:10pt">0903.794.533 - 0903.794.534 - 0903.794.535</span> 				
    			</td>
    			<td width="100px">
    				<div><?= $model->soHoaDon ?> </div>
    				<div style="margin-top: 10px;">
    					<span class="span-status"><?= $model->getDmTrangThaiLabel($model->trang_thai) ?></span> 					</div>
    			</td>
    		</tr>
    	</table>
    	
    	<table style="width: 100%">
    		<tr>
    			<td style="text-align: center"><span class="phieu-h1">HÓA ĐƠN BÁN HÀNG</span></td>
    		</tr>
    	</table>
    	
    	<table id="table-info" style="width: 100%; margin-top:10px;">
    		<tr>
    			<td colspan="2">
    				- Khách hàng: <?= $model->tenKhachHang ?>			
    			</td>
    		</tr>
    		<tr>
    			<td colspan="2">
    				- Địa chỉ: <?= $model->diaChiKhachHang ?>	
    			</td>
    		</tr>
    		<tr>
    			<td>
    				- Số điện thoại: <?= $model->sdtKhachHang ?>	
    			</td>

    			<td>
    				- Email: <?= $model->emailKhachHang ?>
    			</td>
    		</tr>
    		
    	</table>
    	
    	<table id="table-content" style="width: 100%; margin-top:10px;">
    		<thead>
    			<tr style="font-weight:bold">
        			<td style="width:5%">Số TT</td>
        			<td style="width:30%">Tên hàng</td>
        			<td style="width:10%">Mã số</td>
        			<td style="width:10%">Đơn vị tính</td>
        			<td style="width:10%">Số lượng</td>
        			<td style="width:15%">Đơn giá<br/>(VND)</td>
        			<td style="width:15%">Thành tiền<br/>(VND)</td>
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
        			<td><?= $vt->tenVatTu . ($vt->vatTu->heMau?(' - ' . $vt->vatTu->heMau->code):'') ?></td>
        			<td style="text-align:center"><?= $vt->maVatTu ?></td>
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
        			<td colspan="6">Tổng cộng:</td>
        			<td><?= number_format($model->tongTien) ?></td>
    			</tr>
    			
    		</tbody>
    	</table>
    	
    	<p style="margin-top:6pt">Tổng số tiền bằng chữ: <strong><?= $custom->chuyenSoTienThanhChu($model->tongTien) ?> đồng.</strong></p>
    	
    	<table id="table-ky-ten" style="width: 100%; margin-top:10px;">
    		<tr>
    			<td style="text-align:right;font-weight:normal;font-style:italic">Trà Vinh, ngày <?= date('d') ?> tháng <?= date('m') ?> năm <?= date('Y') ?></td>
    		</tr>
    	</table>
    	
    	<table id="table-ky-ten" style="width: 100%; margin-top:10px;">
    		<tr>
    			<td style="text-align:center;font-weight:bold;">KHÁCH HÀNG</td>
    			<td style="text-align:right;font-weight:bold;">NHÂN VIÊN BÁN HÀNG</td>
    		</tr>
    	</table>
    	
    	
    	
    	
    	
    	   
    </div>
</div> <!-- row -->