<?php 
/* foreach ($model->dsVach as $indexPk=>$pk){
    echo $pk->vach->ten_he_vach . '<br/>';
} */
?>

<table class="table table-bordered">
<tr>
	<th>STT</th>
	<th>Mã hệ vách</th>
	<th>Tên hệ vách</th>
	<th>Chiều rộng</th>
	<th>Chiều cao</th>
	<th>Số lượng</th>
	<th>Diện tích</th>
</tr>
<?php 
    $stt=0;
    foreach ($model->dsVach as $key=>$val):
        $stt++;
?>
<tr>
	<td><?= $stt ?></td>
	<td><?= $val->vach->code ?></td>
	<td><?= $val->vach->ten_he_vach ?></td>
	<td><?= $val->rong  ?></td>
	<td><?= $val->cao  ?></td>
	<td><?= $val->so_luong  ?></td>
	<td><?= $val->dien_tich  ?></td>
</tr>
<?php endforeach; ?>
</table>