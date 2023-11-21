<table class="table table-bordered">
<tr>
	<th>STT</th>
	<th>Mã cây nhôm</th>
	<th>Tên cây nhôm</th>
	<th>Chiều dài</th>
	<th>Số lượng</th>
	<th>Kiểu cắt</th>
	<th>Khối lượng</th>
	<th>Tồn kho</th>
</tr>
<?php 
    $stt=0;
    foreach ($model->dsNhoms as $key=>$val):
        $stt++;
?>
<tr>
	<td><?= $stt ?></td>
	<td><?= $val->cayNhom->code ?></td>
	<td><?= $val->cayNhom->ten_cay_nhom ?></td>
	<td><?= $val->chieu_dai  ?></td>
	<td><?= $val->so_luong  ?></td>
	<td><?= $val->kieu_cat  ?></td>
	<td><?= $val->khoi_luong  ?></td>
	<td><?= $val->cayNhom->checkTonKhoNhom($val->chieu_dai) ?></td>
</tr>
<?php endforeach; ?>
</table>