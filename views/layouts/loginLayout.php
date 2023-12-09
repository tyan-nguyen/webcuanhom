<?php
use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap5\BootstrapAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->title = UserManagementModule::t('front', 'Đăng nhập');
BootstrapAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>"/>
	<meta name="robots" content="noindex, nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
	<link href="<?= Yii::getAlias('@web') ?>/css/fontawesome-free-6.4.0-web/css/all.min.css" rel="stylesheet">
	
	<style>
	body{
background: #c9ccd1; 
}
.form-style input{
	border:0;
	height:50px;
	border-radius:0;
border-bottom:1px solid #3f4599;	
color: #02587b;
}
.form-style input:focus{
border-bottom:3px solid #3f4599;	
box-shadow:none;
outline:0;
background-color:#d0d2e5;	
color:white;
}
.sideline {
    display: flex;
    width: 100%;
    justify-content: center;
    align-items: center;
    text-align: center;
	color:#ccc;
}
button{
height:50px;	
}
.sideline:before,
.sideline:after {
    content: '';
    border-top: 1px solid #ebebeb;
    margin: 0 20px 0 0;
    flex: 1 0 20px;
}

.sideline:after {
    margin: 0 0 0 20px;
}

/*==================================================
 * Effect 6
 * ===============================================*/
.effect6
{
    position:relative;
    -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
       -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
            box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
}
.effect6:before, .effect6:after
{
  content:"";
    position:absolute;
    z-index:-1;
    -webkit-box-shadow:0 0 20px rgba(0,0,0,0.8);
    -moz-box-shadow:0 0 20px rgba(0,0,0,0.8);
    box-shadow:0 0 20px rgba(0,0,0,0.8);
    top:50%;
    bottom:0;
    left:10px;
    right:10px;
    -moz-border-radius:100px / 10px;
    border-radius:100px / 10px;
}
.effect6:after
{
  right:10px;
    left:auto;
    -webkit-transform:skew(8deg) rotate(3deg);
       -moz-transform:skew(8deg) rotate(3deg);
        -ms-transform:skew(8deg) rotate(3deg);
         -o-transform:skew(8deg) rotate(3deg);
            transform:skew(8deg) rotate(3deg);
}

.effect1{
-webkit-box-shadow: 0 10px 6px -6px #777;
     -moz-box-shadow: 0 10px 6px -6px #777;
          box-shadow: 0 10px 6px -6px #777;
          }
	</style>
</head>
<body>

<?php $this->beginBody() ?>

<div class="container mt-5 effect1" style="border-radius:20px;border:1px solid #6282b9;">
    <div class="row no-gutters shadow-lg" style="border-radius:20px">
        <div class="col-md-6 d-none d-md-block" style="padding:0px;">
        	<img src="/images/anh_nen2.png" class="img-fluid" style="min-height:100%;width:100%;border-top-left-radius:20px;border-bottom-left-radius:20px;" />
        </div>
        <div class="col-md-6 bg-white p-5 text-center"  style="border-top-right-radius: 20px;border-bottom-right-radius: 20px;">
            <img src="<?= Yii::getAlias('@web/images/logo.png') ?>" width="200px" />
            <h3 class="pb-3" style="/* color: #02587b; */ color: red; font-weight: bold;">PHẦN MỀM <br/> QUẢN LÝ CỬA NHÔM</h3>
            <div class="form-style">
            
            	<?= $content ?>
            
            </div>
        
        </div>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>