<h1>Lịch sử tồn kho</h1>
<table class="table table-striped table-hover">
<thead>
	<tr>
    	<th>STT</th>
    	<th>Chiều dài</th>
    	<th>Số lượng</th>
    	<th>Nội dung</th>
    	<th>Thời gian</th>
	</tr>
</thead>
<tbody>
<?php
foreach ($model as $indexNhom=>$nhom):
?>
<tr>
	<td><?= (++$indexNhom) ?></td>
	<td><?= $nhom->khoNhom->chieu_dai ?></td>
	<td><?= $nhom->so_luong ?></td>
	<td><?= $nhom->noi_dung ?></td>
	<td><?= $nhom->tenMauCua ?></td>
	<td><?= $nhom->date_created ?></td>
</tr>

<?php endforeach; ?>
</tbody>
</table>