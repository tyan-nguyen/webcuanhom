<div style="max-height:500px;overflow-y: scroll;">
<?php
if($history == null){
    echo 'Không có lịch sử thay đổi.';
} else {
foreach ($history as $indexHis=>$his){
?>

<?= $his->noi_dung ?> <br/>

<?php } ?>
<?php } ?>
</div>