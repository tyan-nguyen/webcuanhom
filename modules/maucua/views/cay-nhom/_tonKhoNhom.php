<table class="table table-striped table-hover">
<thead>
	<tr>
    	<th>STT</th>
    	<th>Chiều dài</th>
    	<th>Số lượng</th>
	</tr>
</thead>
<tbody>
<?php
foreach ($model as $indexNhom=>$nhom):
?>
<tr>
	<td><?= (++$indexNhom) ?></td>
	<td><?= $nhom->chieu_dai ?></td>
	<td><?= $nhom->so_luong ?></td>
</tr>

<?php endforeach; ?>
</tbody>
</table>