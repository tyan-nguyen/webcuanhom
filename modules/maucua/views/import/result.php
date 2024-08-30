<?php use yii\helpers\Html; ?>

<?php if($error == 0): ?>
<div class="alert alert-success">
	<strong>Import thành công</strong>
	<hr class="message-inner-separator">
	<p>Bạn đã import thành công <?= $success ?> dòng dữ liệu!</p>
</div>

<?php 
echo Html::a('Xem dữ liệu',['/maucua/cong-trinh/view', 'id'=>$model->id],[
    'role'=>'modal-remote',
    'class'=>'btn btn-sm btn-primary'
]);
?>

<?php endif; ?>

<?php if ($error>0): ?>

<div class="alert alert-warning">
	
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