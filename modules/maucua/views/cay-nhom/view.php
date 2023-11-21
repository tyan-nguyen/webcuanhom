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
                'id',
                'id_he_nhom',
                'code',
                'ten_cay_nhom',
                'so_luong',
                'don_gia',
                'khoi_luong',
                'chieu_dai',
                'for_cua_so',
                'for_cua_di',
                'min_allow_cut',
                'date_created',
                'user_created',
            ],
        ]) ?>
    	</div>
        <div class="col-md-6">
        	<?= $this->render('_tonKhoNhom', ['model'=>$model->tonKho]) ?>
        </div>        
    </div>
</div>
