<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\banle\models\KhachHang */
?>
<div class="khach-hang-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_loai_khach_hang',
            'ten_khach_hang',
            'dia_chi:ntext',
            'so_dien_thoai',
            'email:email',
            'ghi_chu:ntext',
            'date_created',
            'user_created',
        ],
    ]) ?>

</div>
