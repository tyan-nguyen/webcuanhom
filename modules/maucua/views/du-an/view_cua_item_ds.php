<?php
use app\modules\maucua\models\DuAn;
use app\modules\maucua\models\HeNhom;
use yii\helpers\Html;
use app\custom\CustomFunc;

$custom = new CustomFunc();
?>

<link href="/js/datatables/datatables.min.css" rel="stylesheet">
<script src="/js/datatables/datatables.min.js"></script>

<div class="col-xl-12 col-md-12 col-sm-12 mb-4">
    <fieldset id="fs-search" class="fs-custom" <?= $cookieSearch!=null?'':'style="display:none"' ?>>
    	<legend>Tìm kiếm</legend>
        <div class="search">
        	<table>
        		<tr>
        			<th>Tên cửa</th>
        			<th>Tên công trình</th>
        			<th>Hệ nhôm</th>
        		</tr>
        		<tr>
        			<td>
        				<input id="txtTenCua" type="text" class="form-control-sm" placeholder="Tìm tên cửa" />
        			</td>
        			<td>
        				<input id="txtTenCongTrinh" type="text" class="form-control-sm" placeholder="Tìm tên công trình" />
        			</td>
        			<td>
        				<?= Html::dropDownList('MaHeNhom', null, (new HeNhom())->getListCode(), ['id'=>'txtMaHeNhom', 'class'=>'form-control-sm', 'prompt'=>'-Chọn-']) ?>
        			</td>
        		</tr>
        	</table>
        </div>
    </fieldset>
</div>

<div class="col-xl-12 col-md-12 col-sm-12 mb-4">
    <table id="tblDanhSachCua" class="table table-striped table-hover" style="width:100%">
    	<thead>
        	<tr style="font-size:85%">
            	<th width="3%" class="text-center">STT</th>
            	<th width="7%">Ảnh</th>
            	<th width="20%">Tên cửa</th>
            	<th width="20%">Tên C.Tr</th>
            	<th width="20%">Ngày YC</th>
            	<th width="20%">Hệ nhôm</th>
            	<th width="5%"><i class="fa-solid fa-star-half-stroke"></i></th>
            	<th width="5%"></th>
        	</tr>
        	
		</thead>
		<!-- <tfoot>
        	<tr>
                <th></th>
                <th></th>
                <th><input type="text" placeholder="Tìm tên cửa" /></th>
                <th><input type="text" placeholder="Tìm tên công trình" /></th>
                <th><input type="text" placeholder="Tìm ngày yêu cầu" /></th>
                <th><input type="text" placeholder="Tìm hệ nhôm" /></th>
        	</tr>
        </tfoot> -->
		<tbody>
        <?php foreach ($model->mauCuas as $iMau => $mau): ?>
        <tr>
        	<td class="text-center"><?= (++$iMau) ?></td>
        	<td><?= Html::a( Html::img($mau->imageUrl, ['width'=>'100%', 'class'=>'imgBig']), $mau->imageUrl, [
        	    'data-fancybox'=>'gallery',
        	    'data-caption'=>$mau->ten_cua
        	] ) ?></td>
        	<td><?= Html::a($mau->ten_cua . ' ('. $mau->so_luong .')  bộ', 
              	    [Yii::getAlias('@web/maucua/mau-cua/view'), 
              	        'id'=>$mau->id,
              	        'back'=>DuAn::MODEL_ID,
              	        'backid'=>$mau->id_du_an,
              	        //'dactid' => $model->id
              	    ],
              	    [/* 'class'=>'card-link-custom card-link-custom-2', */ 
              	        'style'=>'text-decoration:none',
              	        'role'=>'modal-remote']
      	         ) ?>
      	    </td>
        	<td><?= $mau->congTrinh->ten_cong_trinh ?></td>
        	<td <?= ($mau->ngay_yeu_cau!=null?'style="color:blue"':'') ?>><?= $custom->convertYMDToDMY($mau->ngayBanGiaoDuKien) ?></td>
        	<td><?= $mau->heNhom->code ?></td>
        	<td style="text-align: center"><?= $mau->danhGia==null?'':($mau->danhGia->trangThai?'<span class="text-success"><i class="fa-solid fa-calendar-check"></i></span>':'<span class="text-danger"><i class="fa-regular fa-circle-xmark"></i></span>') ?></td>
        	<td>
        	<a role="modal-remote" data-pjax="0" class="dropdown-item" href="/maucua/du-an/remove-mau-cua-ke-hoach?idkh=<?= $model->id ?>&idmc=<?= $mau->id ?>" data-request-method="post" data-toggle="tooltip" data-confirm-title="Xác nhận xóa mẫu cửa khỏi KHSX?" data-confirm-message="Bạn có chắc chắn muốn xóa mẫu cửa khỏi Kế hoạch sản xuất?"><i class="fa-solid fa-calendar-xmark"></i></a>        	
        	</td>
        </tr>
        
        <?php endforeach; ?>
        </tbody>
        <!-- <tfoot>
        	<tr>
                <th></th>
                <th></th>
                <th><input type="text" placeholder="Tìm tên cửa" /></th>
                <th><input type="text" placeholder="Tìm tên công trình" /></th>
                <th><input type="text" placeholder="Tìm ngày yêu cầu" /></th>
                <th><input type="text" placeholder="Tìm hệ nhôm" /></th>
        	</tr>
        </tfoot> -->
        
    </table>
</div>


<script>
var table = new DataTable('#tblDanhSachCua',{
    pageLength: 8,
    "language": {
        "sLengthMenu":    "Hiển thị _MENU_ dòng dữ liệu/trang",
        "sInfo":          "Hiển thị _START_ - _END_ của _TOTAL_ dữ liệu",
        "sSearch":        "<i class='fa-solid fa-magnifying-glass'></i>",
    }
});
$('#txtTenCua').on( 'keyup click', function () {
       table.columns(2).search(
       		$('#txtTenCua').val()
       ).draw();
});
$('#txtTenCongTrinh').on( 'keyup click', function () {
       table.columns(3).search(
       		$('#txtTenCongTrinh').val()
       ).draw();
}); 
$('#txtMaHeNhom').on( 'keyup click', function () {
       table.columns(5).search(
       		$('#txtMaHeNhom').val()
       ).draw();
});
</script>

