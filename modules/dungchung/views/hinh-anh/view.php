<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\dungchung\models\HinhAnh */
?>
<div class="hinh-anh-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'loai',
            'id_tham_chieu',
            'ten_hien_thi',
            'duong_dan',
            'ten_file_luu',
            'img_extension',
            'img_size',
            'img_wh',
            'ghi_chu:ntext',
            'thoi_gian_tao',
            'nguoi_tao',
        ],
    ]) ?>

</div>
