<?php
use yii\bootstrap5\Html;
use app\modules\maucua\models\CongTrinh;
?>

<?php foreach ($model->mauCuas as $iMau => $mau){ ?>

<div class="col-xl-6 col-md-12 col-sm-12 mb-4">
    <div class="card" style="max-width: 100%;">
      <div class="card-body p-0">
        <?= Html::img($mau->imageUrl, ['width'=>'100%']) ?>
      </div>
      <div class="card-footer bg-transparent text-center">
      	<span style="color:white;">Tên cửa:</span> <?= Html::a($mau->ten_cua . ' ('. $mau->so_luong .')  bộ', 
      	    [Yii::getAlias('@web/maucua/mau-cua/view'), 
      	        'id'=>$mau->id,
      	        'back'=>CongTrinh::MODEL_ID,
      	        'backid'=>$mau->id_cong_trinh,
      	        //'dactid' => $model->id
      	    ],
      	    ['class'=>'card-link-custom card-link-custom-2', 
      	        'role'=>'modal-remote']
      	) ?>
      	<br/>
      	<span style="color:white">(<?= $mau->trangThaiCua ?>)</span>
      </div>
    </div>
</div>
<?php } ?>