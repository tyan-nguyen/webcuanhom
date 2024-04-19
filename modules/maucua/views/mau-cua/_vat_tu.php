<?php /* ?>
<h2>Phụ kiện</h2>
<table class="table table-bordered">
<tr>
	<th>STT</th>
	<th>Mã phụ kiện <i class="fa-regular fa-pen-to-square"></i></th>
	<th>Tên phụ kiện</th>
	<th>Đơn vị tính</th>
	<th>Số lượng <i class="fa-regular fa-pen-to-square"></i></th>
	<th>Tồn kho</th>
</tr>
<?php 
    $stt=0;
    foreach ($model->dsPhuKien as $key=>$val):
        $stt++;
?>
<tr>
	<td style="text-align: center"><?= $stt ?></td>
	<td style="text-align: center"><a class="a-edit-wrap" href="/maucua/mau-cua/sua-vat-tu-popup?id=<?= $val->id ?>" role="modal-remote-2"><?= $val->khoVatTu->code ?></a></td>
	<td><?= $val->khoVatTu->ten_vat_tu ?></td>
	<td style="text-align: center"><?= $val->dvt  ?></td>
	<td style="text-align: center"><a class="a-edit-wrap" href="/maucua/mau-cua/sua-vat-tu-popup?id=<?= $val->id ?>" role="modal-remote-2"><span id="<?= $val->id ?>"><?= $val->so_luong  ?></span></a></td>
	<td style="text-align: center;color:<?= ($val->khoVatTu->so_luong > $val->so_luong ? 'green' : 'red') ?>"><?= $val->khoVatTu->so_luong ?></td>
</tr>
<?php endforeach; ?>
</table>

<h2>Vật tư</h2>

<table class="table table-bordered">
<tr>
	<th>STT</th>
	<th>Mã vật tư <i class="fa-regular fa-pen-to-square"></i></th>
	<th>Tên vật tư</th>
	<th>Đơn vị tính</th>
	<th>Số lượng <i class="fa-regular fa-pen-to-square"></i></th>
	<th>Tồn kho</th>
</tr>
<?php 
    $stt=0;
    foreach ($model->dsVatTu as $key=>$val):
        $stt++;
?>
<tr>
	<td style="text-align: center"><?= $stt ?></td>
	<td style="text-align: center"><a class="a-edit-wrap" href="/maucua/mau-cua/sua-vat-tu-popup?id=<?= $val->id ?>" role="modal-remote-2"><?= $val->khoVatTu->code ?></a></td>
	<td><?= $val->khoVatTu->ten_vat_tu ?></td>
	<td style="text-align: center"><?= $val->dvt  ?></td>
	<td style="text-align: center"><a class="a-edit-wrap" href="/maucua/mau-cua/sua-vat-tu-popup?id=<?= $val->id ?>" role="modal-remote-2"><span id="<?= $val->id ?>"><?= $val->so_luong  ?></span></a></td>
	<td style="text-align: center;color:<?= ($val->khoVatTu->so_luong > $val->so_luong ? 'green' : 'red') ?>"><?= $val->khoVatTu->so_luong ?></td>
</tr>
<?php endforeach; ?>
</table>


<?php */ ?>

<div id="objPhuKienVatTu">

<h2>Phụ kiện</h2>
<table class="table table-bordered">
<tr>
	<th>STT</th>
	<th>Mã phụ kiện <i class="fa-regular fa-pen-to-square"></i></th>
	<th>Tên phụ kiện</th>
	<th>Đơn vị tính</th>
	<th>Số lượng <i class="fa-regular fa-pen-to-square"></i></th>
	<th>Tồn kho</th>
	<th></th>
</tr>
<tr v-for="(phuKien, index) in phuKiens" :key="phuKien.id">
	<td>{{ index + 1 }}</td>
	<td><a class="a-edit-wrap" :href="`/maucua/mau-cua-vat-tu/sua-vat-tu-popup?id=${phuKien.id}`" role="modal-remote-2">{{ phuKien.maPhuKien }}</a></td>
	<td>{{ phuKien.tenPhuKien }}</td>
	<td>{{ phuKien.dvt }}</td>
	<td><a class="a-edit-wrap" :href="`/maucua/mau-cua-vat-tu/sua-vat-tu-popup?id=${phuKien.id}`" role="modal-remote-2"><span :id="`${phuKien.id}`">{{ phuKien.soLuong }}</span></a></td>
	<td>{{ phuKien.tonKho }}</td>
	<td><a :href="`/maucua/mau-cua-vat-tu/delete?id=${phuKien.id}`" role="modal-remote-2" data-confirm="false" data-method="false" data-confirm-title="Xác nhận xóa thông tin?" data-confirm-message="Dữ liệu bị xóa sẽ thông thể phục hồi. Bạn có chắc chắn thực hiện hành động này?"><i class="fa-solid fa-trash"></i></a></td>
</tr>

</table>


<h2>Vật tư</h2>
<table class="table table-bordered">
<tr>
	<th>STT</th>
	<th>Mã vật tư <i class="fa-regular fa-pen-to-square"></i></th>
	<th>Tên vật tư</th>
	<th>Đơn vị tính</th>
	<th>Số lượng <i class="fa-regular fa-pen-to-square"></i></th>
	<th>Tồn kho</th>
</tr>
<tr v-for="(vatTu, index) in vatTus" :key="vatTu.id">
	<td>{{ index + 1 }}</td>
	<td><a class="a-edit-wrap" :href="`/maucua/mau-cua-vat-tu/sua-vat-tu-popup?id=${vatTu.id}`" role="modal-remote-2">{{ vatTu.maVatTu }}</a></td>
	<td>{{ vatTu.tenVatTu }}</td>
	<td>{{ vatTu.dvt }}</td>
	<td><a class="a-edit-wrap" :href="`/maucua/mau-cua-vat-tu/sua-vat-tu-popup?id=${vatTu.id}`" role="modal-remote-2"><span :id="`${vatTu.id}`">{{ vatTu.soLuong }}</span></a></td>
	<td>{{ vatTu.tonKho }}</td>
</tr>

</table>

</div>


<a href="#" onclick="getDsPhuKien()" class="btn btn-primary btn-sm">Refresh Phụ kiện</a>
<a href="#" onclick="getDsVatTu()" class="btn btn-primary btn-sm">Refresh Vật tư</a>



<a href="/maucua/mau-cua-vat-tu/delete?id=1" role="modal-remote-2" data-confirm="false" data-method="false" data-request-method="post" data-confirm-title="Xác nhận xóa thông tin?" data-confirm-message="Dữ liệu bị xóa sẽ thông thể phục hồi. Bạn có chắc chắn thực hiện hành động này?"><i class="fa-solid fa-trash"></i></a>

<a class="btn btn-warning btn-sm btn-default-custom" href="/maucua/mau-cua/bulkdelete" accesskey="t" role="modal-remote-2" data-request-method="post" data-confirm-title="Xác nhận xóa thông tin?" data-confirm-message="Dữ liệu bị xóa sẽ thông thể phục hồi. Bạn có chắc chắn thực hiện hành động này?"><i class="fa-solid fa-trash"></i> Xóa (T)</a>

<?=  \yii\helpers\Html::a('<i class="fa-solid fa-trash"></i> Xóa (T)',
    ["bulkdelete"] ,
    [
        'accesskey'=>'t',
        "class"=>"btn btn-warning btn-sm btn-default-custom",
        'role'=>'modal-remote-2',
        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
        'data-request-method'=>'post',
        'data-confirm-title'=>'Xác nhận xóa thông tin?',
        'data-confirm-message'=>'Dữ liệu bị xóa sẽ thông thể phục hồi. Bạn có chắc chắn thực hiện hành động này?'
    ]) ?>


<script>
function runFunc(id,val){
	$('#' + id).text(val);
}
function runFunc3(id,val){
	if(id=='phukien'){
		vue3.phuKiens = val;
	} else if(id=='vattu'){
		vue3.vatTus = val;
	}
}

function getDsPhuKien(){
    $.ajax({
        /* beforeSend: function() {
         alert('inside ajax');
       }, */
      type: 'GET',
        dataType:'json',
      url: '/maucua/mau-cua/get-ds-vat-tu?id=<?= $model->id ?>&type=phukien',
      success: function (data, status, xhr) {
      	vue3.phuKiens = data.result;
      }
    });
}

function getDsVatTu(){
    $.ajax({
        /* beforeSend: function() {
         alert('inside ajax');
       }, */
      type: 'GET',
        dataType:'json',
      url: '/maucua/mau-cua/get-ds-vat-tu?id=<?= $model->id ?>&type=vattu',
      success: function (data, status, xhr) {
      	vue3.vatTus = data.result;
      }
    });
}

</script>

<script type="text/javascript">
var vue3 = new Vue({
	el: '#objPhuKienVatTu',
	data: {
		phuKiens: <?= json_encode($model->dsPhuKienJson()) ?>,
		vatTus: <?= json_encode($model->dsVatTuJson()) ?>
	},
	methods: {
	},
	computed: {
	}
});		
</script>