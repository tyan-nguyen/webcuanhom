<?php
use yii\helpers\Html;
?>

<div class="wrap">
    <div class="div-left">
        <table>
        <tr>
        	<td><?= Html::img($model->qrImage, ['class'=>'img']) ?></td>
        	<td class="title"><?= $model->cayNhom->ten_cay_nhom ?></td>
        </tr>
        <tr>
        <td colspan="2" align="center" class="title-2">DNTN SX-TM Nguyễn Trình</td>
        </tr>
        </table>
    </div>
</div>