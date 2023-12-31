<div style="width:100%,height:500px;overflow-y:auto">
<h3>Kết quả nhập dữ liệu</h3>

<?php if($error == 0): ?>
<div class="alert alert-success">
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button>
	<span><svg xmlns="http://www.w3.org/2000/svg" height="40" width="40" viewBox="0 0 24 24">
			<path fill="#28a745" d="M10.3125,16.09375a.99676.99676,0,0,1-.707-.293L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328l-6.1875,6.1875A.99676.99676,0,0,1,10.3125,16.09375Z" opacity=".99"></path>
			<path fill="#95dea5" d="M12,2A10,10,0,1,0,22,12,10.01146,10.01146,0,0,0,12,2Zm5.207,7.61328-6.1875,6.1875a.99963.99963,0,0,1-1.41406,0L6.793,12.98828A.99989.99989,0,0,1,8.207,11.57422l2.10547,2.10547L15.793,8.19922A.99989.99989,0,0,1,17.207,9.61328Z"></path>
		</svg></span>
	<strong>Import thành công</strong>
	<hr class="message-inner-separator">
	<p>Bạn đã import thành công <?= $success ?> dòng dữ liệu!</p>
</div>
<?php endif; ?>

<?php if ($error>0): ?>

<div class="alert alert-warning">
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button>
	<span><svg xmlns="http://www.w3.org/2000/svg" height="40" width="40" viewBox="0 0 24 24">
			<path fill="#fad383" d="M15.728,22H8.272a1.00014,1.00014,0,0,1-.707-.293l-5.272-5.272A1.00014,1.00014,0,0,1,2,15.728V8.272a1.00014,1.00014,0,0,1,.293-.707l5.272-5.272A1.00014,1.00014,0,0,1,8.272,2H15.728a1.00014,1.00014,0,0,1,.707.293l5.272,5.272A1.00014,1.00014,0,0,1,22,8.272V15.728a1.00014,1.00014,0,0,1-.293.707l-5.272,5.272A1.00014,1.00014,0,0,1,15.728,22Z"></path>
			<circle cx="12" cy="16" r="1" fill="#f7b731"></circle>
			<path fill="#f7b731" d="M12,13a1,1,0,0,1-1-1V8a1,1,0,0,1,2,0v4A1,1,0,0,1,12,13Z"></path>
		</svg></span>
	<strong>Import có lỗi xảy ra</strong>
	<hr class="message-inner-separator">
	<p>Import thành công <?= $success ?> dòng dữ liệu</p>
	<p>Import thất bại <?= $error ?> dòng dữ liệu</p>
	<h5>Chi tiết lỗi:</h5>
	<?php foreach ($errorArr as $val):?>
    <p><?= $val ?></p>
    <?php endforeach;?>
</div>

<?php endif; ?>
</div>