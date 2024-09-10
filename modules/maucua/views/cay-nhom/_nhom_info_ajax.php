Cây nhôm: <strong><?= $model->code ?></strong>
<br/>Tên cây nhôm: <?= $model->tenCayNhomByColor ?>
<br/>Hệ nhôm: <strong><?= $model->heNhom->code ?></strong> (<?= $model->heNhom->ten_he_nhom ?>)
<br/>Độ dày: <?= $model->do_day ?> (mm)
<br/>Số lượng tồn kho:
<ul>
<?php 
foreach ($model->tonKho as $tkn){
?>
<li>Chiều dài <?= number_format($tkn->chieu_dai) ?> (mm) : <?= $tkn->so_luong ?> (cây)</li>
<?php } ?>
</ul>