<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\custom\CustomFunc;
use app\modules\maucua\models\HeNhom;

$custom = new CustomFunc();
?>

<link href="/js/datatables/datatables.min.css" rel="stylesheet">
<script src="/js/datatables/datatables.min.js"></script>

<div class="col-xl-12 col-md-12 col-sm-12 mb-4">
    <fieldset id="fs-search" class="fs-custom">
    	<legend>Tìm kiếm</legend>
        <div class="search">
        	<table>
        		<tr>
        			<th>Tên cửa</th>
        			<th>Tên công trình</th>
        			<th>Tên khách hàng</th>
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
        				<input id="txtTenKhachHang" type="text" class="form-control-sm" placeholder="Tìm tên khách hàng" />
        			</td>
        			<td>
        				<?= Html::dropDownList('MaHeNhom', null, (new HeNhom())->getListCode(), ['id'=>'txtMaHeNhom', 'class'=>'form-control-sm', 'prompt'=>'-Chọn-']) ?>
        			</td>
        		</tr>
        	</table>
        </div>
    </fieldset>
</div>

<?php $form = ActiveForm::begin(); ?>

<table id="tblDanhSachCua" class="table table-striped table-hover">
    <thead style="font-weight: bold">
        <tr>
        	<td><span id="s-all" style="cursor:pointer" >All</span></td>
        	<td>STT</td>
        	<td>Hình ảnh</td>
        	<td>Mã mẫu cửa</td>
        	<td>Tên mẫu cửa</td>
        	<td>Tên công trình</td>
        	<td>Tên khách hàng</td>
        	<td>Ngày yêu cầu</td>
        	<td>Hệ nhôm</td>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($mauCuas as $indexMc=>$mc){
        ?>
        <tr>
        	<td><?= Html::checkbox('DuAn[vMauCua]['.$mc->id.']', false, ['class'=>'chk','value'=>1, 'disabled'=>$mc->id_du_an != null]) ?></td>
        	<td style="text-align:center;vertical-align:middle"><?= $indexMc+1 ?></td>
        	<td><?= Html::a( Html::img($mc->imageUrl, ['width'=>'50', 'class'=>'imgBig']), $mc->imageUrl, [
        	    'data-fancybox'=>'gallery',
        	    'data-caption'=>$mc->ten_cua
        	] ) ?></td>
        	<td style="text-align:center;vertical-align:middle"><?= $mc->code ?></td>
        	<td style="vertical-align:middle"><?= $mc->ten_cua ?></td>
        	<td style="vertical-align:middle"><?= $mc->congTrinh!=null ? $mc->congTrinh->ten_cong_trinh : ''  ?></td>
        	<td style="vertical-align:middle"><?= $mc->congTrinh->khachHang->ten_khach_hang ?></td>
        	<td style="vertical-align:middle;<?= ($mc->ngay_yeu_cau!=null?'color:blue;':'') ?>"><?= $custom->convertYMDToDMY($mc->ngayBanGiaoDuKien)  ?></td>
        	<td style="vertical-align:middle"><?= $mc->heNhom->code ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php ActiveForm::end(); ?>

<script>
$('#s-all').on('click', function(){
	 $('.chk').not(":disabled").attr('checked','checked');

});
</script>

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
       table.columns(4).search(
       		$('#txtTenCua').val()
       ).draw();
});
$('#txtTenCongTrinh').on( 'keyup click', function () {
       table.columns(5).search(
       		$('#txtTenCongTrinh').val()
       ).draw();
}); 
$('#txtTenKhachHang').on( 'keyup click', function () {
       table.columns(6).search(
       		$('#txtTenKhachHang').val()
       ).draw();
});
$('#txtMaHeNhom').on( 'keyup click', function () {
       table.columns(8).search(
       		$('#txtMaHeNhom').val()
       ).draw();
});
</script>