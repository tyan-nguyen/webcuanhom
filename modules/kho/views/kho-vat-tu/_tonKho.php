<table class="table table-striped table-hover">
<thead>
	<tr>
    	<th>STT</th>
    	<th>Ngày thay đổi</th>
    	<th>Số lượng cũ</th>
    	<!-- <th>Số lượng mới</th> -->
    	<th>Số lượng thay đổi</th>
    	<th>Ghi chú</th>
	</tr>
</thead>
<tbody>
<?php
foreach ($model as $index=>$history):
?>
<tr>
	<td><?= (++$index) ?></td>
	<td><?= $history->date_created ?></td>
	<td><?= $history->so_luong_cu ?></td>
	<!-- <td><?= $history->so_luong_moi ?></td>-->
	<td><?= showIconUpDown($history->so_luong) ?> <?= $history->so_luong ?></td>
	<td><?= $history->ghi_chu ?></td>
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