<?php
use app\modules\kho\models\KhoVatTu;
?>
<h1>Tổng hợp vật tư</h1>
<?php //echo $model->vatTus ?>
<table id="tblDanhSachCua" class="table table-striped table-hover" style="width:100%">
	<thead>
    	<tr style="font-size:85%">
        	<th width="5%" class="text-center">STT</th>
        	<th width="10%">Mã</th>  
        	<th width="25%">Tên vật tư</th>        	
        	<th width="10%">Số lượng</th>
        	<th width="10%">DVT</th>
        	<th width="10%">Tồn kho TT</th>
        	<th width="10%">Đang trong KH khởi tạo</th>
        	<th width="10%">Đang trong KH đã tối ưu</th>
        	<th width="10%">Tồn kho dự kiến</th>
        	<th width="10%">Nhập cho KHSX</th>
        	
    	</tr>    	
	</thead>
	<tbody>
        <?php 
        /*foreach ($model->vatTus as $indexVT=>$vt){
        ?>
        	<tr>
        	<td><?= ($indexVT+1) ?></td>
        	<td><?= $vt->khoVatTu->ten_vat_tu ?></td>
        	<td><?= $vt->khoVatTu->donViTinh->ten_dvt ?></td>
        	<td><?= $vt->so_luong ?></td>
        	</tr>
        <?php }*/ ?>
        <?php 
        foreach ($model->vatTus as $indexVT=>$vt){
            $sluongVT = round($vt['sluong'], 2);
            $vatTu = KhoVatTu::findOne($vt['idkvt']);
            //chưa tính mốc kho min
            $sluongVTNhapThem = 0;
            if($vatTu->so_luong <= 0){
                $sluongVTNhapThem = $sluongVT;
            } else if($vatTu->so_luong - $sluongVT >= 0 ){
                $sluongVTNhapThem = 0;
            } else if($vatTu->so_luong - $sluongVT < 0){
                $sluongVTNhapThem = abs($vatTu->so_luong - $sluongVT);
            }
            
        ?>
        	<tr>
        	<td class="text-center"><?= ($indexVT+1) ?></td>
        	<td><?= $vt['maVT'] ?></td>
        	<td><?= $vt['ten_vat_tu'] ?></td>
        	<td><?= $sluongVT ?></td>
        	<td><?= $vt['ten_dvt'] ?></td>
        	<td <?= ($vatTu->so_luong<0?'style="color:red"':'') ?> > <?= $vatTu->so_luong ?></td>
        	<td><?= $vatTu->getSoLuongTrongKeHoachMoiKhoiTao() ?></td>
        	<td><?= $vatTu->getSoLuongTrongKeHoachDaToiUu() ?></td>
        	<td><?= $vatTu->getSoLuongTonKhoDuKien() ?></td>
        	<!-- chưa cài kho min -->
        	<td <?= ($sluongVTNhapThem?'style="color:red;font-weight:bold"':'') ?> ><?= $sluongVTNhapThem ?></td>
        	</tr>
        <?php } ?>
    </tbody>
</table>