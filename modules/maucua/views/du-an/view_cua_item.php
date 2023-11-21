<?php
use yii\bootstrap5\Html;
use app\modules\maucua\models\DuAn;
?>
<div class="col-xl-6 col-md-12 col-sm-12 mb-4">
    <div class="card" style="max-width: 100%;">
      <div class="card-body p-0">
        <?= Html::img($model->imageUrl, ['width'=>'100%']) ?>
      </div>
      <div class="card-footer bg-transparent text-center">
      	<?= Html::a($model->ten_cua . ' ('. $model->so_luong .')  bộ', 
      	    [Yii::getAlias('@web/maucua/mau-cua/view'), 
      	        'id'=>$model->id,
      	        'back'=>DuAn::MODEL_ID,
      	        'backid'=>$model->id_du_an,
      	        //'dactid' => $model->id
      	    ],
      	    ['class'=>'card-link-custom card-link-custom-2', 
      	        'role'=>'modal-remote']
      	) ?>
      </div>
    </div>
</div>
