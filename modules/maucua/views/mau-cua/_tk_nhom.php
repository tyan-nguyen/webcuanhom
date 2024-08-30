<table class="table table-bordered">
<tr>
	<th>STT</th>
	<th>Mã cây nhôm <?= !$model->dangSanXuat ? '<i class="fa-regular fa-pen-to-square"></i>' : '' ?></th>
	<th>Màu</th>
	<th>Tên cây nhôm</th>
	<th>Hệ nhôm</th>
    <th>Độ dày</th>
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
<tr id="trTkNhom<?= $val->id ?>">
	<td><?= $stt ?></td>
	<?php if(!$model->dangSanXuat){?>
	<td><a class="a-edit-wrap" href="/maucua/mau-cua-nhom/sua-nhom-popup?id=<?= $val->id ?>" role="modal-remote-2"><?= $val->cayNhom->code ?></a></td>
	<?php } else {?>
	<td> <?= $val->cayNhom->code ?> </td>
	<?php } ?>
	<td><?= $val->cayNhom->heMau?'<span style="background-color:'.$val->cayNhom->heMau->ma_mau.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':''?></td>
	<td><?= $val->cayNhom->ten_cay_nhom . ($val->cayNhom->heMau?(' ('.$val->cayNhom->heMau->code.')'):'') ?></td>
	<td><?= $val->cayNhom->heNhom->code ?></td>
   	<td><?= $val->cayNhom->do_day ?></td>
	<td><?= $val->chieu_dai ?></td>
	<td><?= $val->so_luong  ?></td>
	<td><?= $val->kieu_cat  ?></td>
	<td><?= $val->khoi_luong  ?></td>
	<td><?= $val->cayNhom->checkTonKhoNhom($val->chieu_dai) ?></td>
</tr>
<?php endforeach; ?>
</table>

<script>
function runFunc4(id,val){
	$('#trTkNhom' + id).html(val);
}
</script>