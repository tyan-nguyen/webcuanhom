<?php 
use app\custom\CustomFunc;

$custom = new CustomFunc();
?>
<?php if ($model==null){?>

<div class="alert alert-primary mt-2" role="alert">
  Chưa có đánh giá!
</div>

<?php }?>
<div class="accordion accordion-flush" id="accordionFlushExample">
<?php 
$isLast = false;
$total = count($model);
foreach ($model as $indexDanhGia=>$danhGia){ 
    if(($indexDanhGia+1)==$total){
        $isLast = true;
    }
?>
<div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $indexDanhGia ?>" aria-expanded="false" aria-controls="flush-collapse<?= $indexDanhGia ?>" style="background-color:#48728c;color:white;">
       	Đánh giá ngày <?= $custom->convertYMDToDMY($danhGia->ngay_danh_gia) ?>
      </button>
    </h2>
    <div id="flush-collapse<?= $indexDanhGia ?>" class="accordion-collapse collapse <?= $isLast?'show':'' ?>" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">      		
  		<div class="row">
  			<div class="col-md-12">
  				<div class="alert alert-primary" role="alert">
  					Kết quả đánh giá ngày <?= $custom->convertYMDToDMY($danhGia->ngay_danh_gia) ?>: <strong><?= '<span class="badge ' . ($danhGia->trangThai?'text-bg-success':'text-bg-danger') . '">' .$danhGia->trangThaiText . '</span>' ?></strong>
  				</div>
  			</div>
  			<div class="col-md-6">
  				<h4>Thông tin đánh giá</h4>
  				Người đánh giá: <strong><?= $danhGia->ten_nguoi_danh_gia ?></strong>
  				<br/>
  				Tài khoản nhập đánh giá: <strong><?= $danhGia->taiKhoan?$danhGia->taiKhoan->username:'' ?></strong>
  				<br/>
  				Đánh giá lần thứ: <strong><?= $danhGia->lan_thu ?></strong>
  				<br/>
  				Ngày đánh giá: <strong><?= $custom->convertYMDToDMY($danhGia->ngay_danh_gia) ?></strong>
  				<br/>
  				Chú thích: <?= $danhGia->ghi_chu ?>
  				
  			</div>
  			<div class="col-md-6">
  				<h4>Check list</h4>
  				<ul>
  					<li><?= $danhGia->getAttributeLabel('check_he_nhom') ?> : <?= $danhGia->check_he_nhom?'<span class="text-success">Đạt</span>':'<span class="text-danger">Không đạt</span>'  ?></li>
  					<li><?= $danhGia->getAttributeLabel('check_kich_thuoc_phu_bi') ?> : <?= $danhGia->check_kich_thuoc_phu_bi?'<span class="text-success">Đạt</span>':'<span class="text-danger">Không đạt</span>'  ?></li>
  					<li><?= $danhGia->getAttributeLabel('check_kich_thuoc_thuc_te') ?> : <?= $danhGia->check_kich_thuoc_thuc_te?'<span class="text-success">Đạt</span>':'<span class="text-danger">Không đạt</span>'  ?></li>
  					<li><?= $danhGia->getAttributeLabel('check_nhan_hieu') ?> : <?= $danhGia->check_nhan_hieu?'<span class="text-success">Đạt</span>':'<span class="text-danger">Không đạt</span>'  ?></li>
  					<li><?= $danhGia->getAttributeLabel('check_chu_thich') ?> : <?= $danhGia->check_chu_thich?'<span class="text-success">Đạt</span>':'<span class="text-danger">Không đạt</span>'  ?></li>
  					<li><?= $danhGia->getAttributeLabel('check_tham_my') ?> : <?= $danhGia->check_tham_my?'<span class="text-success">Đạt</span>':'<span class="text-danger">Không đạt</span>' ?></li>
  				</ul>
  			</div>
  		</div>
      </div>
    </div>
  </div>
<?php }//end foreach?>
</div>


<?php /* ?>
<div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        Accordion Item #1
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
        Accordion Item #2
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
        Accordion Item #3
      </button>
    </h2>
    <div id="flush-collapseThree" class="accordion-collapse collapse show" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
    </div>
  </div>
</div>
<?php */ ?>