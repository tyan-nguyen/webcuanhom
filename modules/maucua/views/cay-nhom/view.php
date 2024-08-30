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
                'heNhom.code',
                [
                    'attribute'=>'id',
                    'label'=>'Mã Màu',
                    'format'=>'html',
                    'value'=>$model->heMau?$model->heMau->code:''
                ],
                [
                    'attribute'=>'id',
                    'label'=>'Màu',
                    'format'=>'html',
                    'value'=>$model->heMau?'<span style="background-color:'.$model->heMau->ma_mau.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>':''
                ],
                'heNhom.ten_he_nhom',
                'heNhom.xuatXu.ten_xuat_xu',
                'heNhom.hang_san_xuat',
               // 'heNhom.nha_cung_cap',
                'code',
                'ten_cay_nhom',
                'so_luong'=>[
                    'attribute'=>'so_luong',
                    'value'=>$model->soLuongNhomMoi
                ],
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
                'do_day'=>[
                    'attribute'=>'do_day',
                    'value'=> number_format($model->do_day) . ' mm'
                ],
                'for_cua_so'=>[
                    'attribute'=>'for_cua_so',
                    'value'=>$model->for_cua_so==true ? 'YES' : ''
                ],
                'for_cua_di'=>[
                    'attribute'=>'for_cua_di',
                    'value'=>$model->for_cua_di==true ? 'YES' : ''
                ],
                'dung_cho_nhieu_he_nhom'=>[
                    'attribute'=>'dung_cho_nhieu_he_nhom',
                    'value'=>$model->dung_cho_nhieu_he_nhom==true ? 'YES' : ''
                ],
                'min_allow_cut'=>[
                    'attribute'=>'min_allow_cut',
                    'value'=> $model->min_allow_cut>0 ? (number_format($model->min_allow_cut) . ' mm') : 'Không giới hạn'
                ],
                'min_allow_cut_under'=>[
                    'attribute'=>'min_allow_cut_under',
                    'value'=> $model->min_allow_cut_under>0 ? (number_format($model->min_allow_cut_under) . ' mm') : 'Không giới hạn'
                ],
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
