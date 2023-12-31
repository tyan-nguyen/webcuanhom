<div style="width:100%,height:400px;overflow-y:auto">
<h2 class="text-warning">Lỗi file dữ liệu!</h2>
<p class="text-muted card-sub-title mt-1">Vui lòng chỉnh sửa các lỗi dữ liệu sau:</p>
<div data-bs-spy="scroll" data-bs-target="#navbar-example3" class="scrollspy-example-2" style="height:400px" data-bs-offset="0" tabindex="0">
<?php 
foreach ($rt as $index=>$item){
?>
<div>
		<h4 class="fs-8 fw-semibold">Dòng <?= $index ?></h4>
		<p class="fs-14">
		<?php 
		foreach ($item as $index2=>$item2){
    		echo $item2 . '<br/>';
		}
		?>
		</p>
	</div>
<?php 
}
?>

</div>
</div>