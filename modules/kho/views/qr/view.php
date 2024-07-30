<table class="table">
	<tr>
		<td>Mã cây nhôm: <strong><?= $model->cayNhom->code ?></strong></td>
	</tr>
	<tr>
		<td>Tên cây nhôm: <strong><?= $model->cayNhom->ten_cay_nhom ?></strong></td>
	</tr>
	<tr>
		<td>Chiều dài: <strong><?= number_format($model->chieu_dai) ?></strong> (mm)</td>
	</tr>
	<tr>
		<td>Số lượng tồn kho: <strong><?= number_format($model->so_luong) ?></strong> (cây)</td>
	</tr>
</table>