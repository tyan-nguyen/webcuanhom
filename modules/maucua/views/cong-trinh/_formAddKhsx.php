<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

<table class="table table-bordered">
    <thead style="font-weight: bold">
        <tr>
        	<td><span id="s-all" style="cursor:pointer" >All</span></td>
        	<td>STT</td>
        	<td>Mã mẫu cửa</td>
        	<td>Tên mẫu cửa</td>
        	<td>Kế hoạch sản xuất</td>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($model->mauCuas as $indexNsd=>$nsd){
        ?>
        <tr>
        	<td><?= Html::checkbox('CongTrinh[khsx]['.$nsd->id.']', false, ['class'=>'chk','value'=>1, 'disabled'=>$nsd->id_du_an != null]) ?></td>
        	<td style="text-align:center;vertical-align:middle"><?= $indexNsd+1 ?></td>
        	<td style="text-align:center;vertical-align:middle"><?= $nsd->code ?></td>
        	<td style="vertical-align:middle"><?= $nsd->ten_cua ?></td>
        	<td style="vertical-align:middle"><?= $nsd->duAn!=null ? $nsd->duAn->ten_du_an : ''  ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?= $form->field($model, 'idKeHoach')->dropDownList($model->getDmKeHoach(), ['prompt'=>'-Chọn kế hoạch-']) ?>

<?php ActiveForm::end(); ?>

<script>
$('#s-all').on('click', function(){
	 $('.chk').not(":disabled").attr('checked','checked');

});
</script>