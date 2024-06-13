<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

<table class="table table-bordered">
    <thead style="font-weight: bold">
        <tr>
        	<td>STT</td>
        	<td>Mã cây nhôm</td>
        	<td>Tên cây nhôm</td>
        	<td>Chiều dài</td>
        	<td>Số thanh cắt</td>
        	<td>Còn lại</td>
        	<td>Còn lại thực tế</td>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($model->dsNhomSuDung as $indexNsd=>$nsd){
            if($nsd->chieu_dai_con_lai > 0){
        ?>
        <tr>
        	<td style="text-align:center;vertical-align:middle"><?= $indexNsd+1 ?></td>
        	<td style="text-align:center;vertical-align:middle"><?= $nsd->khoNhom->cayNhom->code ?></td>
        	<td style="vertical-align:middle"><?= $nsd->khoNhom->cayNhom->ten_cay_nhom ?></td>
        	<td style="text-align:right;vertical-align:middle"><?= number_format($nsd->chieu_dai_ban_dau) ?></td>
        	<td style="text-align:right;vertical-align:middle"><?= count($nsd->chiTiet) ?></td>
        	<td style="text-align:right;vertical-align:middle"><?= $nsd->chieu_dai_con_lai ?></td>
        	<td style="vertical-align:middle"><?= $form->field($model, 'nhomDu['.$nsd->id.']')->textInput(['value'=>$nsd->chieu_dai_con_lai, 'disabled'=>($model->trang_thai=="DA_XUAT_KHO"?false:true), 'style'=>'width:80px'])->label(false) ?></td>
        </tr>
        	<?php } ?>
        <?php } ?>
    </tbody>
</table>
<?php ActiveForm::end(); ?>