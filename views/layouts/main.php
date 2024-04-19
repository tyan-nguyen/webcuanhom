<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

use cangak\ajaxcrud\CrudAsset; 

AppAsset::register($this);
CrudAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
    <style>
        /*for loading*/
        #overlay{
          position:fixed;
          z-index:99999;
          top:0;
          left:0;
          bottom:0;
          right:0;
          background:rgba(0,0,0,0.5);
          transition: 1s 0.4s;
        }
        #loading{
          font-size:1em;
          letter-spacing: 3px;
          position:absolute;
          top:35%;
          margin-top:0px;
          width:100%;
          text-align:center;
          color:green;
        }
        #progress{
          height:3px;
          background:#fff;
          position:absolute;
          width:0;
          top:50%;
        }
        #progstat{
          font-size:1em;
          letter-spacing: 3px;
          position:absolute;
          top:50%;
          margin-top:-40px;
          width:100%;
          text-align:center;
          color:#fff;
        }
    </style>
    
    <script>
    ;(function(){
      function id(v){return document.getElementById(v); }
      function loadbar() {
        var ovrl = id("overlay"),
            prog = id("progress"),
            stat = id("progstat"),
            img = document.images,
            c = 0;
            tot = img.length;
    
        function imgLoaded(){
          c += 1;
          var perc = ((100/tot*c) << 0) +"%";
          prog.style.width = perc;
          stat.innerHTML = "Loading "+ perc;
          if(c===tot) return doneLoading();
        }
        function doneLoading(){
          ovrl.style.opacity = 0;
          setTimeout(function(){ 
            ovrl.style.display = "none";
          }, 1);
        }
        for(var i=0; i<tot; i++) {
          var tImg     = new Image();
          tImg.onload  = imgLoaded;
          tImg.onerror = imgLoaded;
          tImg.src     = img[i].src;
        }    
      }
      document.addEventListener('DOMContentLoaded', loadbar, false);
    }());
    </script>
    
</head>
<body class="d-flex flex-column h-100" onload="startTime()">

<style>
        .main-nav-pills{
            --bs-nav-pills-border-radius:0;
            margin-bottom: 0 !important;
        }
        
        .main-nav-pills li button{
            text-transform: uppercase;
        }
        
       .main-nav-link.active{
            color: #0d6efd;
            background-color: #f7f7f7f !important;
            /* text-decoration: underline; */
        }
        .ul-ribbon{
            padding-left:0px;
        }
       .ul-ribbon li{
            display: inline;
            padding-right:10px;
       }
        .ul-ribbon li a{
            color: white;
            text-decoration: none;
       }
        .ul-ribbon li a:hover{
            color:yellow;
       }
       
    </style>
    
<?php $this->beginBody() ?>


<div id="overlay">
	<div id="loading"><img src="/images/loading.gif" width="100" alt="loading..." /></div>
    <div id="progstat"></div>
    <div id="progress"></div>
</div>
      
<header id="header" class="" style="margin:0 auto;background: #f7f7f7;width:100%;">
    <?php
    /*NavBar::begin([
        //'brandLabel' => Yii::$app->name,
        'brandLabel' => Html::img(Yii::getAlias('@web/uploads/images/logo_white.png'), ['width'=>50]),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'items' => [
            ['label' => 'Loại cửa', 'url' => ['/maucua/loai-cua']],
            ['label' => 'Hệ nhôm', 'url' => ['/maucua/he-nhom']],
            ['label' => 'Cây nhôm', 'url' => ['/maucua/cay-nhom']],
            ['label' => 'Mẫu cửa', 'url' => ['/maucua/mau-cua']],
            ['label' => 'Dự án', 'url' => ['/maucua/du-an']],
            
            Yii::$app->user->isGuest
                ? ['label' => 'Login', 'url' => ['/user-management/auth/login']]
                : '<li class="nav-item">'
                    . Html::beginForm(['/user-management/auth/logout'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
        ]
    ]);
    NavBar::end(); */
    ?>
<div class="container-fluid" style="background-color: #0d6efd">   
	<div class="row" style="background-color: #f7f7f7">
		<!-- <div class="col-md-2">
			<?= Html::img(Yii::getAlias('@web/uploads/images/logo_white.png'), ['height'=>'70px']) ?>
		</div> -->
		<div class="col-md-12">
		
			<div class="container">
			<ul class="nav nav-pills main-nav-pills mb-3" id="pills-tab" role="tablist">
				<li class="nav-item" role="homeicon" style="padding-right:30px">
                	<a href="/"><?= Html::img(Yii::getAlias('@web/uploads/images/logo_white.png'), ['height'=>'40px']) ?></a>
                </li>
                <li class="nav-item" role="presentation">
                	<button class="nav-link main-nav-link" id="bctk-tab" data-bs-toggle="pill" data-bs-target="#bctk" type="button" role="tab" aria-controls="bctk" aria-selected="true"><i class="fa-solid fa-chart-simple"></i> Báo cáo</button>
                </li>
                <li class="nav-item" role="presentation">
                	<button class="nav-link main-nav-link" id="maucua-tab" data-bs-toggle="pill" data-bs-target="#maucua" type="button" role="tab" aria-controls="maucua" aria-selected="true"><i class="fa-brands fa-windows"></i> Mẫu cửa</button>
                </li>
                
                <li class="nav-item" role="presentation">
                	<button class="nav-link main-nav-link" id="kho-tab" data-bs-toggle="pill" data-bs-target="#kho" type="button" role="tab" aria-controls="kho" aria-selected="false"><i class="fa-regular fa-folder"></i> Kho lưu trữ</button>
                </li>
                
                <li class="nav-item" role="presentation">
                	<button class="nav-link main-nav-link" id="khsx-tab" data-bs-toggle="pill" data-bs-target="#khsx" type="button" role="tab" aria-controls="khsx" aria-selected="false"><i class="fa-regular fa-calendar-plus"></i> KH sản xuất</button>
                </li>                
                <li class="nav-item" role="presentation">
                	<button class="nav-link main-nav-link" id="tkmc-tab" data-bs-toggle="pill" data-bs-target="#tkmc" type="button" role="tab" aria-controls="tkmc" aria-selected="false"><i class="fa-solid fa-object-ungroup"></i> Thiết kế mẫu</button>
                </li>
                
                <li class="nav-item" role="presentation">
                	<button class="nav-link main-nav-link" id="taikhoan-tab" data-bs-toggle="pill" data-bs-target="#taikhoan" type="button" role="tab" aria-controls="taikhoan" aria-selected="false"><i class="fa-solid fa-users"></i> Tài khoản</button>
                </li>
                
            </ul>
            </div>
            
		</div><!-- col-md-9 -->
	
	</div> <!-- row -->
	
	<div class="row">
		<div class="col-md-12">
			<div class="container">
            <div class="tab-content" id="pills-tabContent" style="background-color: #0d6efd;min-height:40px;padding-top:7px;color:white;">
            
            <div class="tab-pane fade" id="bctk" role="tabpanel" aria-labelledby="bctk-tab">
              		Coming soon...
              </div>
            
              <div class="tab-pane fade" id="maucua" role="tabpanel" aria-labelledby="maucua-tab">
              <ul class="ul-ribbon">
              	<li><a href="/maucua/du-an"><i class="fa-regular fa-file"></i> Dự án</a></li>
              	<li>|</li>
              	<li><a href="/maucua/mau-cua"><i class="fa-regular fa-file"></i> Mẫu cửa</a></li>
              	<li>|</li>
              	<li><a href="/maucua/loai-cua"><i class="fa-regular fa-file"></i> Loại cửa</a></li>
              	<li>|</li>
              	<li><a href="/maucua/cay-nhom"><i class="fa-regular fa-file"></i> Cây nhôm</a></li>
              	<li>|</li>
              	<li><a href="/maucua/he-nhom"><i class="fa-regular fa-file"></i> Hệ nhôm</a></li>
              	<li>|</li>
                <li><a href="/maucua/bao-gia"><i class="fa-regular fa-file"></i> Báo giá</a></li>
              	<li>|</li>
                <li><a href="/maucua/loai-bao-gia"><i class="fa-regular fa-file"></i> Loại báo giá</a></li>
              </ul>
              </div>
              <div class="tab-pane fade" id="kho" role="tabpanel" aria-labelledby="kho-tab">
					
					<ul class="ul-ribbon">                  	
                  	<!-- <li><a href="/kho/kho-vat-tu"><i class="fa-regular fa-file"></i> Kho vật tư</a></li> -->
                  	<li><a href="/kho/phu-kien"><i class="fa-regular fa-file"></i> Kho phụ kiện</a></li>
                  	<li>|</li>
                  	<li><a href="/kho/vat-tu"><i class="fa-regular fa-file"></i> Kho vật tư</a></li>
                  	<li>|</li>
                  	<li><a href="/kho/thiet-bi"><i class="fa-regular fa-file"></i> Kho thiết bị</a></li>
                  	<li>|</li>
                  	<li><a href="/kho/kho-nhom"><i class="fa-regular fa-file"></i> Kho nhôm</a></li>
                  	<li>|</li>
                  	<li><a href="/kho/he-vach"><i class="fa-regular fa-file"></i> Hệ vách</a></li>
                  	<li>|</li>
                  	<li><a href="/kho/nha-cung-cap"><i class="fa-regular fa-file"></i> Nhà cung cấp</a></li>
                  	<li>|</li>
                  	<li><a href="/kho/dvt"><i class="fa-regular fa-file"></i> Đơn vị tính</a></li>
                  	<li>|</li>
                  	<li><a href="/kho/xuat-xu"><i class="fa-regular fa-file"></i> Xuất xứ</a></li>
                  	<li>|</li>
                  	<li><a href="/kho/thuong-hieu"><i class="fa-regular fa-file"></i> Thương hiệu</a></li>
                  	
                  </ul>
              
			</div>
              <div class="tab-pane fade" id="khsx" role="tabpanel" aria-labelledby="khsx-tab">
              		Coming soon...
              </div>
              
              <div class="tab-pane fade" id="tkmc" role="tabpanel" aria-labelledby="tkmc-tab">
              		Coming soon...
              </div>
              
              
              
              <div class="tab-pane fade" id="taikhoan" role="tabpanel" aria-labelledby="taikhoan-tab">
              	<ul class="ul-ribbon">
              		<li><a href="/user-management/user"><i class="fa-regular fa-file"></i> Tài khoản</a></li>
              		<li>|</li>
              		<li><a role="modal-remote" href="/site/setting"><i class="fa-regular fa-file"></i> Cấu hình</a></li>
              		<li>|</li>
              		<?php if(Yii::$app->user->isGuest){ ?>
              		<li><a href="/user-management/auth/login"><i class="fa-regular fa-file"></i> Đăng nhập</a></li>
              		<?php } else {?>
              		<li><a href="/user-management/auth/logout"><i class="fa-regular fa-file"></i> Đăng xuất</a></li>
              		<?php } ?>
              	</ul>
              </div>
              
            
 			</div>
 			
 			</div><!-- container -->
		</div>
	</div>
	
</div><!-- container -->   

</header>

<main id="main" class="flex-shrink-0" role="main">

    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; DNTN SX-TM Nguyễn Trình <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end">Ngày: <?= date('d/m/Y') ?>, Giờ hệ thống: <span id="clock"></span></div>
        </div>
    </div>
</footer>

<script>
function startTime() {
  const today = new Date();
  let h = today.getHours();
  let m = today.getMinutes();
  let s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('clock').innerHTML =  h + ":" + m + ":" + s;
  setTimeout(startTime, 1000);
}
function checkTime(i) {
      if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
      return i;
}
</script>

<?php 
$moduleName = Yii::$app->controller->module->id;
$script = <<< JS
    
    
    function setActiveMenu(moduleName){
    	if(moduleName == 'kho'){
            $('#kho-tab').addClass('active');
            $('#kho').addClass('show active');
    	}else if(moduleName == 'maucua'){
            $('#maucua-tab').addClass('active');
            $('#maucua').addClass('show active');
    	}else if(moduleName == 'user-management'){
            $('#taikhoan-tab').addClass('active');
            $('#taikhoan').addClass('show active');
    	}
    	
    }
    setActiveMenu('$moduleName');

    $(document).ajaxStart(function() {
      $(".loadingAjax").show();
      $(".completeAjax").hide();
    });
    
    $(document).ajaxStop(function() {
      $(".loadingAjax").hide();
      $(".completeAjax").show();
      setTimeout(function(){
        $(".completeAjax").hide();
      },2000); 
    });

JS;
$this->registerJs($script);
?>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
