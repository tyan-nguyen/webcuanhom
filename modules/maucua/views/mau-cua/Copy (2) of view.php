

<?php

use yii\widgets\DetailView;
use app\widgets\views\ImageListWidget;
use app\modules\maucua\models\MauCua;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\MauCua */
?>
<div class="mau-cua-view container">
 	<div class="row">
    	<div class="col-md-6">
    	
    	<ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Thông tin mẫu</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Thống kê nhôm</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="toi-uu-tab" data-bs-toggle="tab" data-bs-target="#toiuu" type="button" role="tab" aria-controls="contact" aria-selected="false">Tối ưu cắt</button>
          </li>
           <li class="nav-item" role="presentation">
            <button class="nav-link" id="cat-moi-tab" data-bs-toggle="tab" data-bs-target="#catmoi" type="button" role="tab" aria-controls="catmoi" aria-selected="false">Cắt mới</button>
          </li>
        </ul>
        
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
				<?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'id',
                        'code',
                        'ten_cua',
                        'kich_thuoc',
                        'id_he_nhom',
                        'id_loai_cua',
                        'id_parent',
                        'id_du_an'=>[
                            'attribute'=>'status',
                            'value'=>$model->duAn->ten_du_an
                        ],
                        'so_luong',
                        'status'=>[
                            'attribute'=>'status',
                            'value'=>$model->getDmTrangThaiLabel($model->status)
                        ]
                        //'date_created',
                        //'user_created',
                    ],
                ]) ?>
			</div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          		<?= $this->render('_tk_nhom', [
          		    'model'=>$model,
          		    'dactModel'=>isset($dactModel) ? $dactModel : ''
          		]) ?>
          </div>
          <div class="tab-pane fade" id="toiuu" role="tabpanel" aria-labelledby="contact-tab">Tối ưu nhôm</div>
          
           <div class="tab-pane fade" id="catmoi" role="tabpanel" aria-labelledby="catmoi-tab">
        <?= $this->render('_cat_moi', [
          		    'model'=>$model,
          		]) ?>
           
     	</div>
           
           
        </div>

       </div> 
        <div class="col-md-6">
        <?= ImageListWidget::widget([
        	    'loai' => MauCua::MODEL_ID,
        	    'id_tham_chieu' => $model->id
        	]) ?>
    	</div>
    	
    	
	</div>
</div>




<?php
$script = <<< JS
    $(document).ready(function() {

	/* This is basic - uses default settings */
	
	$("a.imgBig").fancybox();
	
	/* Using custom settings */
	
	/* $("a#inline").fancybox({
		'hideOnContentClick': true
	}); */

	/* Apply fancybox to multiple items */
	
	/* $("a.group").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	}); */
	
});
JS;
$this->registerJs($script);
?>