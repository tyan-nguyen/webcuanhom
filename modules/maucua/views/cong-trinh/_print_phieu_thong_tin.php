<?php
use yii\helpers\Html;
use app\custom\CustomFunc;
use app\modules\dungchung\models\HinhAnh;
use app\modules\maucua\models\MauCua;
$custom = new CustomFunc();
?>

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
			<!-- <td width="100px">
				<div style="margin-top: 10px;">Ngày:<?= date('d/m/Y') ?></div>
				<div style="margin-top: 10px;">
					<span class="span-status"><?php // $model->getDmTrangThaiLabel($model->status) ?></span> 
				</div>
			</td>-->
		</tr>
    </table>
    
    <table style="width: 100%">
    		<tr>
    			<td style="text-align: center"><span class="phieu-h1">HỒ SƠ MẪU CỬA</span></td>
    		</tr>
    		<tr>
    			<td style="text-align: center"><span>Mã cửa: <?= $model->code ?></span></td>
    		</tr>
    </table>
    
    <table style="width: 100%">
    		<tr>
    			<td style="text-align: left">Tên công trình: <?= $model->congTrinh->ten_cong_trinh ?><td>
    		</tr>
    		<tr>
    			<td style="text-align: left">Tên khách hàng: <?= $model->khachHang->ten_khach_hang ?></td>
    		</tr>
    		<tr>
    			<td style="text-align: left">Địa chỉ: <?= $model->khachHang->dia_chi ?></td>
    		</tr>
    		<tr>
    			<td style="text-align: left">Số điện thoại: <?= $model->khachHang->so_dien_thoai ?></td>
    		</tr>
    		<tr>
    			<td style="text-align: left">Email: <?= $model->khachHang->email ?></td>
    		</tr>
    </table>
    
    <table style="width: 100%">
    		<tr>
    			<td style="text-align: left; width:30%">Tên cửa:<br/> <?= $model->ten_cua ?></td>
    			<td rowspan="5" style="text-align: left">
    				<?php 
    				    $hinhAnhCua = HinhAnh::getHinhAnhThamChieuOne(MauCua::MODEL_ID, $model->id);
    				    if($hinhAnhCua != null){
    				        echo Html::img($hinhAnhCua->hinhAnhUrl, ['style'=>'max-width:100%']);
    				    }
    				?>
    			</td>
    		</tr>
    		<tr>
    			<td style="text-align: left; width:30%">Kích thước:<br/> <?= $model->kich_thuoc ?></td>
    		</tr>
    		<tr>
    			<td style="text-align: left; width:30%">Số lượng:<br/> <?= $model->so_luong ?></td>
    		</tr>
    		<tr>
    			<td style="text-align: left; width:30%">Hệ nhôm:<br/> <?= $model->heNhom->ten_he_nhom ?></td>
    		</tr>
    		<tr>
    			<td style="text-align: left; width:30%">Loại cửa:<br/> <?= $model->loaiCua->ten_loai_cua ?></td>
    		</tr>
    </table>
    
    <table  class="tbl-header" style="width: 100%">
    		<tr>
    			<td style="text-align: center"><span class="phieu-h1">DANH SÁCH NHÔM SỬ DỤNG</span></td>
    		</tr>    		
    </table>
    
    <table class="table-content" style="width: 100%">
    		<thead>
        		<tr>
        			<td>STT</td>
        			<td>Mã cây nhôm</td>
        			<td>Tên cây nhôm</td>
        			<td>Chiều dài (mm)</td>
        			<td>Kiểu cắt</td>
        			<td>Số lượng (Cây)</td>
        			<td>Khối lượng (Kg)</td>
        		</tr>   
    		</thead> 
    		<tbody>
    		<?php // duyet so luong cay  nhom su dung ?>
    		<?php 
        		foreach ($model->dsNhoms as $indexNhom => $nhom){
            ?>
            <tr>
            	<td style="text-align:center"><?= ($indexNhom+1) ?></td>
            	<td style="text-align:center"><?= $nhom->cayNhom->code ?></td>
            	<td><?= $nhom->cayNhom->ten_cay_nhom ?></td>
            	<td style="text-align:right"><?= number_format($nhom->chieu_dai) ?></td>
            	<td style="text-align:center"><?= $nhom->kieu_cat ?></td>
            	<td style="text-align:right"><?= $nhom->so_luong ?></td>
            	<td style="text-align:right"><?= $nhom->khoi_luong ?></td>
            </tr>
            <?php } ?>	
            </tbody>
    </table>
    
    <table class="tbl-header" style="width: 100%">
    		<tr>
    			<td style="text-align: center"><span class="phieu-h1">DANH SÁCH KÍNH</span></td>
    		</tr>
    		
    </table>
    
    <table class="table-content" style="width: 100%">
    		<thead>
        		<tr>
        			<td>STT</td>
        			<td>Mã hệ vách</td>
        			<td>Tên hệ vách</td>
        			<td>Chiều rộng (mm)</td>
        			<td>Chiều cao</td>
        			<td>Số lượng</td>
        			<td>Diện tích (m2)</td>
        		</tr>   
    		</thead> 
    		<tbody>
    		<?php // duyet so luong kinh su dung ?>
    		<?php 
        		foreach ($model->dsVach as $indexVach => $vach){
            ?>
            <tr>
            	<td style="text-align:center"><?= ($indexVach+1) ?></td>
            	<td style="text-align:center"><?= $vach->vach->code ?></td>
            	<td><?= $vach->vach->ten_he_vach ?></td>
            	<td style="text-align:right"><?= number_format($vach->rong) ?></td>
            	<td style="text-align:right"><?= number_format($vach->cao) ?></td>
            	<td style="text-align:right"><?= $vach->so_luong ?></td>
            	<td style="text-align:right"><?= $vach->dien_tich ?></td>
            </tr>
            <?php } ?>	
            </tbody>
    </table>
    
    
    <table class="tbl-header" style="width: 100%">
    		<tr>
    			<td style="text-align: center"><span class="phieu-h1">DANH SÁCH PHỤ KIỆN</span></td>
    		</tr>
    		
    </table>
    
    <table class="table-content" style="width: 100%">
    		<thead>
        		<tr>
        			<td>STT</td>
        			<td>Mã phụ kiện</td>
        			<td>Nhà sản xuất</td>
        			<td>Tên phụ kiện</td>
        			<td>Đơn vị tính</td>
        			<td>Số lượng</td>
        		</tr>   
    		</thead> 
    		<tbody>
    		<?php // duyet so luong phu kien su dung ?>
    		<?php 
        		foreach ($model->dsPhuKien as $indexPhuKien => $phuKien){
            ?>
            <tr>
            	<td style="text-align:center"><?= ($indexPhuKien+1) ?></td>
            	<td style="text-align:center"><?= $phuKien->khoVatTu->code ?></td>
            	<td><?= $phuKien->khoVatTu->thuongHieu->ten_thuong_hieu ?></td>
            	<td><?= $phuKien->khoVatTu->ten_vat_tu ?></td>
            	<td style="text-align:center"><?= $phuKien->khoVatTu->donViTinh->ten_dvt ?></td>
            	<td style="text-align:right"><?= $phuKien->so_luong ?></td>
            </tr>
            <?php } ?>	
            </tbody>
    </table>
    
    <table class="tbl-header" style="width: 100%">
    		<tr>
    			<td style="text-align: center"><span class="phieu-h1">DANH SÁCH VẬT TƯ</span></td>
    		</tr>    		
    </table>
    
    <table class="table-content" style="width: 100%">
    		<thead>
        		<tr>
        			<td>STT</td>
        			<td>Mã vật tư</td>
        			<td>Nhà sản xuất</td>
        			<td>Tên vật tư</td>
        			<td>Đơn vị tính</td>
        			<td>Số lượng</td>
        		</tr>   
    		</thead> 
    		<tbody>
    		<?php // duyet so luong phu kien su dung ?>
    		<?php 
        		foreach ($model->dsVatTu as $indexVatTu => $vatTu){
            ?>
            <tr>
            	<td style="text-align:center"><?= ($indexVatTu+1) ?></td>
            	<td style="text-align:center"><?= $vatTu->khoVatTu->code ?></td>
            	<td><?= $vatTu->khoVatTu->thuongHieu->ten_thuong_hieu ?></td>
            	<td><?= $vatTu->khoVatTu->ten_vat_tu ?></td>
            	<td style="text-align:center"><?= $vatTu->khoVatTu->donViTinh->ten_dvt ?></td>
            	<td style="text-align:right"><?= $vatTu->so_luong ?></td>
            </tr>
            <?php } ?>	
            </tbody>
    </table>
    
    
    
    </div>
</div> <!-- row -->