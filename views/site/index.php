<?php

use yii\bootstrap5\Html;
use app\modules\maucua\models\Import;
use app\widgets\CustomModal;
use cangak\ajaxcrud\CrudAsset;

/** @var yii\web\View $this */
CrudAsset::register($this);
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
        
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card" style="max-width: 100%;">
              <div class="card-body p-0">
                <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
              </div>
              <div class="card-footer bg-transparent text-center">
              	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý Kho vật tư', Yii::getAlias('@web/kho/kho-vat-tu'), ['class'=>'card-link-custom']) ?>
              </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card" style="max-width: 100%;">
              <div class="card-body p-0">
                <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
              </div>
              <div class="card-footer bg-transparent text-center">
              	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý Kho nhôm', Yii::getAlias('@web/kho/kho-nhom'), ['class'=>'card-link-custom']) ?>
              </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card" style="max-width: 100%;">
              <div class="card-body p-0">
                <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
              </div>
              <div class="card-footer bg-transparent text-center">
              	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý Cây nhôm', Yii::getAlias('@web/mau-cua/cay-nhom'), ['class'=>'card-link-custom']) ?>
              </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card" style="max-width: 100%;">
              <div class="card-body p-0">
                <?= Html::img(Yii::getAlias('@web/uploads/images/door-icon.png'), ['width'=>'100%']) ?>
              </div>
              <div class="card-footer bg-transparent text-center">
              	<?= Html::a('<i class="fa-solid fa-bars"></i> Quản lý Hệ nhôm', Yii::getAlias('@web/kho/he-nhom'), ['class'=>'card-link-custom']) ?>
              </div>
            </div>
        </div>
        
    </div>
</div>

<?php CustomModal::begin([
   "options" => [
        "id"=>"ajaxCrudModal",
        "tabindex" => false // important for Select2 to work properly
    ],
   'dialogOptions'=>['class'=>'modal-xl modal-dialog-centered'],
   "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php CustomModal::end(); ?>