<?php
use yii\helpers\Html;
?>
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
	<!-- <td><?= $nhom->chieu_dai ?></td> -->
	<td><?= Html::a(number_format($nhom->chieu_dai), ['/kho/kho-nhom/view', 'id'=>$nhom->id], ['role'=>'modal-remote']) ?></td>
	<td><?= $nhom->so_luong ?></td>
</tr>

<?php endforeach; ?>
</tbody>
</table>