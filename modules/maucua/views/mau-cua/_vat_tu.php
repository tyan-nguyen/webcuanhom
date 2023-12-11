<h2>Phụ kiện</h2>
<?php 
/* foreach ($model->dsPhuKien as $indexPk=>$pk){
    echo $pk->khoVatTu->ten_vat_tu . '<br/>';
} */
?>
<table class="table table-bordered">
<tr>
	<th>STT</th>
	<th>Mã phụ kiện</th>
	<th>Tên phụ kiện</th>
	<th>Đơn vị tính</th>
	<th>Số lượng</th>
	<th>Tồn kho</th>
</tr>
<?php 
    $stt=0;
    foreach ($model->dsPhuKien as $key=>$val):
        $stt++;
?>
<tr>
	<td style="text-align: center"><?= $stt ?></td>
	<td style="text-align: center"><?= $val->khoVatTu->code ?></td>
	<td><?= $val->khoVatTu->ten_vat_tu ?></td>
	<td style="text-align: center"><?= $val->dvt  ?></td>
	<td style="text-align: center"><?= $val->so_luong  ?></td>
	<td style="text-align: center;color:<?= ($val->khoVatTu->so_luong > $val->so_luong ? 'green' : 'red') ?>"><?= $val->khoVatTu->so_luong ?></td>
</tr>
<?php endforeach; ?>
</table>

<h2>Vật tư</h2>
<?php 
/* foreach ($model->dsVatTu as $indexPk=>$pk){
    echo $pk->khoVatTu->ten_vat_tu . '<br/>';
} */
?>
<table class="table table-bordered">
<tr>
	<th>STT</th>
	<th>Mã vật tư</th>
	<th>Tên vật tư</th>
	<th>Đơn vị tính</th>
	<th>Số lượng</th>
	<th>Tồn kho</th>
</tr>
<?php 
    $stt=0;
    foreach ($model->dsVatTu as $key=>$val):
        $stt++;
?>
<tr>
	<td style="text-align: center"><?= $stt ?></td>
	<td style="text-align: center"><?= $val->khoVatTu->code ?></td>
	<td><?= $val->khoVatTu->ten_vat_tu ?></td>
	<td style="text-align: center"><?= $val->dvt  ?></td>
	<td style="text-align: center"><?= $val->so_luong  ?></td>
	<td style="text-align: center;color:<?= ($val->khoVatTu->so_luong > $val->so_luong ? 'green' : 'red') ?>"><?= $val->khoVatTu->so_luong ?></td>
</tr>
<?php endforeach; ?>
</table>