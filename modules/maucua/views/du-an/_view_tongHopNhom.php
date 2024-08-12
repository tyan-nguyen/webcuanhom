<?php
use app\modules\kho\models\KhoVatTu;
use app\modules\maucua\models\KhoNhom;
?>
<h1>Tổng hợp nhôm</h1>
<?php //echo $model->vatTus ?>
<table id="tblDanhSachNhomSuDung" class="table table-striped table-hover" style="width:100%">
	<thead>
    	<tr style="font-size:85%">
        	<th width="5%" class="text-center">STT</th>
        	<th width="10%">Mã QR</th>  
        	<th width="10%">Mã cây nhôm</th>  
        	<th width="25%">Tên cây nhôm</th>
        	<th width="25%">Chiều dài</th>
        	<th width="25%">Hệ nhôm</th>      	
        	<th width="10%">Số lượng sử dụng</th>
        	<th width="10%">Tồn kho TT</th>
        	<th width="10%">Đang trong KH đã tối ưu</th>
        	<th width="10%">Tồn kho dự kiến</th>
        	<th width="10%">Nhập cho KHSX</th>
        	
    	</tr>    	
	</thead>
	<tbody>
        <?php 
        foreach ($model->nhomSuDungs as $indexNhom=>$nhom){
            $sluongNhom = round($nhom['sluong'], 2);
            $khoNhom = KhoNhom::findOne($nhom['idKhoNhom']);
            //chưa tính mốc kho min
            $sluongNhomNhapThem = 0;
            if($khoNhom->so_luong <= 0){
                $sluongNhomNhapThem = $sluongNhom;
            } else if($khoNhom->so_luong - $sluongNhom >= 0 ){
                $sluongNhomNhapThem = 0;
            } else if($khoNhom->so_luong - $sluongNhom < 0){
                $sluongNhomNhapThem = abs($khoNhom->so_luong - $sluongNhom);
            }
            
        ?>
        	<tr>
        	<td class="text-center"><?= ($indexNhom+1) ?></td>
        	<td><?= $nhom['knQrCode'] ?></td>
        	<td><?= $nhom['cnCode'] ?></td>
        	<td><?= $nhom['cnTenCayNhom'] ?></td>
        	<td><?= $nhom['kncd'] ?></td>
        	<td><?= $nhom['hnCode'] ?></td>
        	<td><?= $sluongNhom ?></td>
        	<td <?= ($khoNhom->so_luong<0?'style="color:red"':'') ?> > <?= $khoNhom->so_luong ?></td>
        	<td><?= $khoNhom->getSoLuongTrongKeHoachDaToiUu() ?></td>
        	<td><?= $khoNhom->getSoLuongTonKhoDuKien() ?></td>
        	<!-- chưa cài kho min -->
        	<td <?= ($sluongNhomNhapThem?'style="color:red;font-weight:bold"':'') ?> ><?= $sluongNhomNhapThem ?></td>
        	</tr>
        <?php } ?>
    </tbody>
</table>