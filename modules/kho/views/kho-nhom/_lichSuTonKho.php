<h2>Lịch sử tồn kho</h2>
<table id="tblLichSuTonKho" class="table table-striped table-hover" style="width:100%">
<thead>
	<tr>
    	<th width="10%">STT</th>
    	<th width="10%">Chiều dài</th>
    	<th width="10%">SL thay đổi</th>
    	<th width="10%">SL cũ</th>
    	<th width="10%">SL mới</th>
    	<th width="30%">Nội dung</th>
    	<!-- <th>Mẫu cửa</th> -->
    	<th width="20%">Thời gian</th>
	</tr>
</thead>
<tbody>
<?php
foreach ($model as $indexNhom=>$nhom):
?>
<tr>
	<td><?= (++$indexNhom) ?></td>
	<td><?= number_format($nhom->khoNhom->chieu_dai) ?></td>
	<td><?= showIconUpDown($nhom->so_luong) ?> <?= $nhom->so_luong ?></td>
	<td><?= $nhom->so_luong_cu ?></td>
	<td><?= $nhom->so_luong_moi ?></td>
	<td><?= $nhom->noi_dung ?></td>
	<!-- <td><?= $nhom->tenMauCua ?></td>-->
	<td><?= $nhom->date_created ?></td>
</tr>

<?php endforeach; ?>
</tbody>
</table>

<?php 

function showIconUpDown($number){
    if($number < 0){
        return '<i class="fa-solid fa-down-long" style="color:red"></i>';
    } else {
        return '<i class="fa-solid fa-up-long" style="color:green"></i>';
    }
}

?>