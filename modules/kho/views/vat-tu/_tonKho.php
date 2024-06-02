<h3>Lịch sử tồn kho</h3>
<table class="table table-striped table-hover">
<thead>
	<tr>
    	<th width="10%">STT</th>    	
    	<th width="15%">Số lượng thay đổi</th>
    	<th width="15%">Số lượng cũ</th>   	
    	<th width="15%">Số lượng mới</th>
    	<th width="30%">Ghi chú</th>
    	<th width="15%">Ngày thay đổi</th>
	</tr>
</thead>
<tbody>
<?php
foreach ($model as $index=>$history):
?>
<tr>
	<td><?= (++$index) ?></td>
	<td><?= showIconUpDown($history->so_luong) ?> <?= $history->so_luong ?></td>
	<td><?= $history->so_luong_cu ?></td>
	<td><?= $history->so_luong_moi ?></td>
	<td><?= $history->ghi_chu ?></td>
	<td><?= $history->date_created ?></td>
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