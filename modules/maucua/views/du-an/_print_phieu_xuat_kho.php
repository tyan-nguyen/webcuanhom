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
			<td width="100px">
				<div style="margin-top: 10px;">Ngày:<?= date('d/m/Y') ?></div>
				<div style="margin-top: 10px;">
					<span class="span-status"><?= $model->getDmTrangThaiLabel($model->trang_thai) ?></span> 
				</div>
			</td>
		</tr>
    </table>
    
    <table style="width: 100%">
		<tr>
			<td style="text-align: center"><span class="phieu-h1">PHIẾU XUẤT KHO</span></td>
		</tr>
		<tr>
			<td style="text-align: center"><span>Mã dự án: <?= $model->code ?></span></td>
		</tr>
    </table>
    
    <table style="width: 100%">
    		<tr>
    			<td style="text-align: left">Tên dự án: <?= $model->ten_du_an ?><td>
    		</tr>
    		<tr>
    			<td style="text-align: left">Tên khách hàng: <?= $model->ten_khach_hang ?></td>
    		</tr>
    		<tr>
    			<td style="text-align: left">Địa chỉ: <?= $model->dia_chi ?></td>
    		</tr>
    		<tr>
    			<td style="text-align: left">Số điện thoại: <?= $model->so_dien_thoai ?></td>
    		</tr>
    		<tr>
    			<td style="text-align: left">Email: <?= $model->email ?></td>
    		</tr>
    </table>
    
    <?php foreach ($model->mauCuas as $iMauCua=>$mauCua){?>
    <table style="width: 100%">
    		<tr>
    			<td style="text-align: left; width:30%">Tên cửa:<br/> <?= $mauCua->ten_cua ?></td>
    			<td rowspan="5" style="text-align: left">
    				<?php 
    				    $hinhAnhCua = HinhAnh::getHinhAnhThamChieuOne(MauCua::MODEL_ID, $mauCua->id);
    				    if($hinhAnhCua != null){
    				        echo Html::img($hinhAnhCua->hinhAnhUrl, ['style'=>'max-width:100%']);
    				    }
    				?>
    			</td>
    		</tr>
    		<tr>
    			<td style="text-align: left; width:30%">Kích thước:<br/> <?= $mauCua->kich_thuoc ?></td>
    		</tr>
    		<tr>
    			<td style="text-align: left; width:30%">Số lượng:<br/> <?= $mauCua->so_luong ?></td>
    		</tr>
    		<tr>
    			<td style="text-align: left; width:30%">Hệ nhôm:<br/> <?= $mauCua->heNhom->ten_he_nhom ?></td>
    		</tr>
    		<tr>
    			<td style="text-align: left; width:30%">Loại cửa:<br/> <?= $mauCua->loaiCua->ten_loai_cua ?></td>
    		</tr>
    </table>
    <?php }?>
    
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
        			<td>Số đoạn cắt</td>
        			<td>Chiều dài còn lại</td>
        		</tr>   
    		</thead> 
    		<tbody>
    		<?php // duyet so luong cay  nhom su dung ?>
    		<?php 
        		foreach ($model->dsNhomSuDung as $indexNhom => $nhom){
            ?>
            <tr>
            	<td style="text-align:center"><?= ($indexNhom+1) ?></td>
            	<td style="text-align:center"><?= $nhom->khoNhom->cayNhom->code ?></td>
            	<td><?= $nhom->khoNhom->cayNhom->ten_cay_nhom ?></td>
            	<td style="text-align:right"><?= number_format($nhom->chieu_dai_ban_dau) ?></td>
            	<td style="text-align:right"><?= count($nhom->chiTiet) ?></td>
            	<td style="text-align:right"><?= number_format($nhom->chieu_dai_con_lai) ?></td>
            </tr>
            <?php } ?>	
            </tbody>
    </table>    
    
    <table  class="tbl-header" style="width: 100%">
    		<tr>
    			<td style="text-align: center"><span class="phieu-h1">CHI TIẾT CẮT NHÔM</span></td>
    		</tr>    		
    </table>
    
    <div id="divCutImage"></div>
    
    </div>
</div> <!-- row -->