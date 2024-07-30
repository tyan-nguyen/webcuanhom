<?php
use app\modules\maucua\models\KhoNhom;
?>
<table class="table">
	<tr>
		<td><span style="font-style: italic"><span style="color:red">Lưu ý:</span> Nhôm dư chưa nhập kho, chiều dài có thể thay đổi sau khi sản xuất</span></td>
	</tr>
	<tr>
		<td>Mã cây nhôm: <strong><?= $model->khoNhom->cayNhom->code ?></strong></td>
	</tr>
	<tr>
		<td>Tên cây nhôm: <strong><?= $model->khoNhom->cayNhom->ten_cay_nhom ?></strong></td>
	</tr>
	<tr>
		<td>Chiều dài: <strong><?= number_format($model->chieu_dai_con_lai) ?></strong> (mm)</td>
	</tr>
	<tr>
		<?php 
		$khoNhom = KhoNhom::find()->where(['id_cay_nhom'=>$model->khoNhom->id_cay_nhom,'chieu_dai'=>$model->chieu_dai_con_lai])->one();
		  $soLuong = 0;
		  if($khoNhom != null){
		      $soLuong = $khoNhom->so_luong;
		  }
		?>
		<td>Số lượng tồn kho: <strong><?= number_format($soLuong) ?></strong> (cây)</td>
	</tr>
</table>