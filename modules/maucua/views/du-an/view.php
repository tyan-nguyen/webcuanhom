<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\DuAn */
?>
<div class="du-an-view container">
<div class="row">
	<div class="col-md-6">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                'ten_du_an',
                'ten_khach_hang',
                'dia_chi:ntext',
                'so_dien_thoai',
                'email:email',
                'trang_thai',
                'ngay_tao_du_an',
                'ngay_bat_dau_thuc_hien',
                'ngay_hoan_thanh_du_an',
                'code_mau_thiet_ke',
                [
                    'attribute'=>'ghi_chu',
                    'format'=>'html'
                ]
            ],
        ]) ?>
    </div>
    <div class="col-md-6">
        <div class="container indexPage">
        	<div class="row">
                <?php 
                    foreach ($model->mauCuas as $iMau => $mau){
                        echo $this->render('view_cua_item', ['model'=>$mau]);
                    }
                ?>
            </div>
        </div>
    </div>
</div>
</div>
