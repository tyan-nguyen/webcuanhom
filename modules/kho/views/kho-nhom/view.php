<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\KhoNhom */
?>
<div class="kho-nhom-view container">
	<div class="row">
    	<div class="col-md-6">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                'code'=>[
                    'attribute'=>'code',
                    'value'=>$model->scode
                ],
                'id_cay_nhom'=>[
                    'attribute'=>'id_cay_nhom',
                    'value'=>$model->cayNhom->ten_cay_nhom
                ],
                'chieu_dai',
                'so_luong',
                'date_created',
                //'user_created',
            ],
        ]) ?>
		</div>
        <div class="col-md-6">
        	<?= $this->render('_lichSuTonKho', ['model'=>$model->history]) ?>
        </div>
    </div>
</div>
