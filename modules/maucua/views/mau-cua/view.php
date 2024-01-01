<script src="/js/vue.js"></script>

<?php

use yii\widgets\DetailView;
use app\widgets\views\ImageListWidget;
use app\modules\maucua\models\MauCua;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\MauCua */
?>
<div class="mau-cua-view container">
 	<div class="row">
    	<div class="col-md-12">
    	
    	<ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Thông tin mẫu</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Thống kê nhôm</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="toi-uu-tab" data-bs-toggle="tab" data-bs-target="#toiuu" type="button" role="tab" aria-controls="contact" aria-selected="false">Tối ưu nhôm</button>
          </li>
          <!-- 
           <li class="nav-item" role="presentation">
            <button class="nav-link" id="cat-moi-tab" data-bs-toggle="tab" data-bs-target="#catmoi" type="button" role="tab" aria-controls="catmoi" aria-selected="false">Tối ưu cắt</button>
          </li>
           -->
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="cat-moi-tab" data-bs-toggle="tab" data-bs-target="#vattu" type="button" role="tab" aria-controls="vattu" aria-selected="false">Phụ kiện - Vật tư</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="vach-tab" data-bs-toggle="tab" data-bs-target="#vach" type="button" role="tab" aria-controls="vach" aria-selected="false">Vách</button>
          </li>
          
          <!-- 
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="test-tab" data-bs-toggle="tab" data-bs-target="#test" type="button" role="tab" aria-controls="vach" aria-selected="false">Test</button>
          </li>
          
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="test2-tab" data-bs-toggle="tab" data-bs-target="#test2" type="button" role="tab" aria-controls="vach" aria-selected="false">Test 2 edit</button>
          </li>
          
           -->
          
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="test3-tab" data-bs-toggle="tab" data-bs-target="#test3" type="button" role="tab" aria-controls="vach" aria-selected="false">Tối ưu cắt</button>
          </li>
           
          
        </ul>
        
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          	<div class="row">
          		<div class="col-md-6">
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
                <div class="col-md-6">
                	 <?= ImageListWidget::widget([
                	    'loai' => MauCua::MODEL_ID,
                	    'id_tham_chieu' => $model->id
                	]) ?>
                </div>
              </div><!-- row -->
			</div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          		<?= $this->render('_tk_nhom', [
          		    'model'=>$model,
          		    'dactModel'=>isset($dactModel) ? $dactModel : ''
          		]) ?>
          </div>
          <div class="tab-pane fade" id="toiuu" role="tabpanel" aria-labelledby="contact-tab">
				<?= $this->render('_toiuunhom', [
          		    'model'=>$model,
          		]) ?>
	
			</div>
          
          <!-- 
           <div class="tab-pane fade" id="catmoi" role="tabpanel" aria-labelledby="catmoi-tab">
        		<?php /* $this->render('_cat_moi', [
          		    'model'=>$model,
          		]) */ ?>           
     		</div>
     		 -->
     		 
     		<div class="tab-pane fade" id="vattu" role="tabpanel" aria-labelledby="vattu-tab">
        		<?= $this->render('_vat_tu', [
          		    'model'=>$model,
          		]) ?>           
     		</div>
     		
     		<div class="tab-pane fade" id="vach" role="tabpanel" aria-labelledby="vach-tab">
        		<?= $this->render('_vach', [
          		    'model'=>$model,
          		]) ?>           
     		</div>
     		
     		<!--
     		<div class="tab-pane fade" id="test" role="tabpanel" aria-labelledby="test-tab">
        		<?php /* $this->render('_test', [
          		    'model'=>$model,
          		])*/ ?>           
     		</div>
     		
     		<div class="tab-pane fade" id="test2" role="tabpanel" aria-labelledby="test2-tab">
        		<?php /* $this->render('_test2', [
          		    'model'=>$model,
          		])*/ ?>           
     		</div>
     		 -->
     		 
     		<div class="tab-pane fade" id="test3" role="tabpanel" aria-labelledby="test3-tab">
        		<?php /* $this->render('_test3', [
          		    'model'=>$model,
          		]) */ ?>
          		<?= $this->render('_cat_moi2', [
          		    'model'=>$model,
          		]) ?>            
     		</div>
            
           
        </div>

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