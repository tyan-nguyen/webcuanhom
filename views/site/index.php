<?php

use yii\bootstrap5\Html;

/** @var yii\web\View $this */

$this->title = 'Phần mềm Quản lý cửa';
?>
<div class="container indexPage">
	<div class="row mx-auto">
		<div class="col-md-12 my-3">
			<h1 class="pageTitle">PHẦN MỀM QUẢN LÝ CỬA</h1>
		</div>
	</div>
    <div class="row">
        
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card" style="max-width: 100%;">
              <div class="card-body p-0">
                <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
              </div>
              <div class="card-footer bg-transparent text-center">
              	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý dự án', Yii::getAlias('@web/maucua/du-an'), ['class'=>'card-link-custom']) ?>
              </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card" style="max-width: 100%;">
              <div class="card-body p-0">
                <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
              </div>
              <div class="card-footer bg-transparent text-center">
              	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý Mẫu cửa', Yii::getAlias('@web/maucua/mau-cua'), ['class'=>'card-link-custom']) ?>
              </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card" style="max-width: 100%;">
              <div class="card-body p-0">
                <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
              </div>
              <div class="card-footer bg-transparent text-center">
              	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý Loại cửa', Yii::getAlias('@web/maucua/loai-cua'), ['class'=>'card-link-custom']) ?>
              </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card" style="max-width: 100%;">
              <div class="card-body p-0">
                <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
              </div>
              <div class="card-footer bg-transparent text-center">
              	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý Loại nhôm', Yii::getAlias('@web/maucua/he-nhom'), ['class'=>'card-link-custom']) ?>
              </div>
            </div>
        </div>
        
    </div>
</div>