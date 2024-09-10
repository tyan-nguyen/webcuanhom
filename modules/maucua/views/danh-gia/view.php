<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\DanhGia */
?>
<div class="danh-gia-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_mau_cua',
            'id_nguoi_danh_gia',
            'ten_nguoi_danh_gia',
            'lan_thu',
            'ngay_danh_gia',
            'ghi_chu:ntext',
            'date_created',
            'user_created',
            'check_he_nhom',
            'check_kich_thuoc_phu_bi',
            'check_kich_thuoc_thuc_te',
            'check_nhan_hieu',
            'check_chu_thich',
            'check_tham_my',
        ],
    ]) ?>

</div>
