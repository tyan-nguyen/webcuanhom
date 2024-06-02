<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\CayNhom */
?>
<div class="cay-nhom-view container">
     <div class="row">
    	<div class="col-md-6">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                'heNhom.ten_he_nhom',
                'code',
                'ten_cay_nhom',
                //'so_luong',
                'don_gia'=>[
                    'attribute'=>'don_gia',
                    'value'=> number_format($model->don_gia) . ' VND'
                ],
                'khoi_luong'=>[
                    'attribute'=>'khoi_luong',
                    'value'=>$model->khoi_luong . ' kg'
                ],
                'chieu_dai'=>[
                    'attribute'=>'chieu_dai',
                    'value'=> number_format($model->chieu_dai) . ' mm'
                ],
                'for_cua_so'=>[
                    'attribute'=>'for_cua_so',
                    'value'=>$model->for_cua_so==true ? 'YES' : ''
                ],
                'for_cua_di'=>[
                    'attribute'=>'for_cua_di',
                    'value'=>$model->for_cua_di==true ? 'YES' : ''
                ],
                'min_allow_cut',
                'date_created',
                //'user_created',
            ],
        ]) ?>
    	</div>
        <div class="col-md-6">
        	<h3>Tồn kho</h3>
        	<?= $this->render('_tonKhoNhom', ['model'=>$model->tonKho]) ?>
        </div>        
    </div>
</div>
