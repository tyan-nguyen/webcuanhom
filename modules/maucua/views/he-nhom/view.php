<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\HeNhom */
?>
<div class="he-nhom-view">
    <?php if(!$model->mauNhoms){?>
    <div class="alert alert-danger" role="alert">
      <i class="fa-solid fa-triangle-exclamation"></i> Hệ nhôm chưa được cấu hình hệ màu.
    </div>
    <?php }?>
    <?php if(!$model->mauMacDinh){?>
    <div class="alert alert-danger" role="alert">
      <i class="fa-solid fa-triangle-exclamation"></i> Hệ nhôm chưa được cấu hình hệ màu mặc định.
    </div>
    <?php }?>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'code',
            'ten_he_nhom',
            [
                'attribute' => 'xuat_xu',
                'value' => $model->xuatXu->ten_xuat_xu
            ],
            'hang_san_xuat',
           // 'nha_cung_cap',
            'do_day_mac_dinh',
            
            [
                'attribute'=>'mauNhom',
                'format'=>'html',
                'value'=>function($model){
                    $html='';
                    foreach ($model->mauNhoms as $mauNhom){
                        $html .= '<span style="background-color:'.$mauNhom->mau->ma_mau.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        	'. $mauNhom->mau->ten_he_mau .' ('. $mauNhom->mau->code .')
                        	<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>';
                    }
                    return $html;
                }
            ],
            [
                'attribute'=>'mauMacDinhInput',
                'format'=>'html',
                'value'=>function($model){
                    $html='';
                    if($model->mauMacDinh != null){
                        $html .= '<span style="background-color:'.$model->mauMacDinh->ma_mau.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            	'. $model->mauMacDinh->ten_he_mau .'
                            	<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>';
                    }
                    return $html;
                }
            ],
            'ghi_chu:ntext',
            'date_created',
            //'user_created',
        ],
    ]) ?>

</div>
