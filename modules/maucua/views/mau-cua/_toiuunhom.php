<div id="objToiUuNhom">
	<table class="table table-bordered">
        <tr>
        	<th>STT</th>
        	<th>Mã cây nhôm</th>
        	<th>Tên cây nhôm</th>
        	<th>Chiều dài</th>
        	<th>Số lượng</th>
        	<th>Kiểu cắt</th>
        	<th>Khối lượng</th>
        	<th>Tồn kho</th>
        </tr>
        <tr v-for="(result, index) in results" :key="result.id">
        	<td>{{ index + 1 }}</td>
        	<td>{{ result.maCayNhom }}</td>
        	<td>{{ result.tenCayNhom }}</td>
        	<td>{{ result.chieuDai }}</td>
        	<td>{{ result.soLuong }}</td>
        	<td>{{ result.kieuCat }}</td>
        	<td>{{ result.khoiLuong }}</td>
        	<td>{{ result.slTonKho }}</td>
        </tr>
    </table>
</div>

<a href="#" onclick="getData2()" class="btn btn-primary btn-sm">Tối ưu kho</a>
<a href="#" onclick="getData3()" class="btn btn-primary btn-sm">Tối ưu nhôm mới</a>

<script type="text/javascript">
var vue2 = new Vue({
	el: '#objToiUuNhom',
	data: {
		results: <?= json_encode($model->dsToiUu()) ?> /*[
			{
    			id: 11,
    			idMauCua: 11,
    			idCuaNhom: 22,
    			idTonKhoNhom: 33,
    			maCayNhom: 'ma0001',
    			tenCayNhom: 'Cây nhôm abc',
    			chieuDai: 550,
    			soLuong: 1,
    			kieuCat: '==\\',
    			khoiLuong: 2000,
    			chieuDaiCayNhom: 5900
			},
			{
    			id: 111,
    			idMauCua: 111,
    			idCuaNhom: 222,
    			idTonKhoNhom: 333,
    			maCayNhom: 'ma00011',
    			tenCayNhom: 'Cây nhôm abc2',
    			chieuDai: 600,
    			soLuong: 1,
    			kieuCat: '==\\',
    			khoiLuong: 2000,
    			chieuDaiCayNhom: 5900
			}, 
		]*/
	},
	methods: {
		/* changeValue: function(event){
			this.noidung = event.target.value;
		} */
	},
	computed: {
	}
});		

function getData2(){
    $.ajax({
        /* beforeSend: function() {
         alert('inside ajax');
       }, */
      type: 'GET',
        dataType:'json',
      url: '/maucua/mau-cua/get-data2?id=<?= $model->id ?>',
      success: function (data, status, xhr) {
      	vue2.results = data.result;
      }
    });
}

function getData3(){
    $.ajax({
      type: 'GET',
        dataType:"json",
      url: '/maucua/mau-cua/get-data2?id=<?= $model->id ?>&type=catmoi',
      success: function (data, status, xhr) {
        	vue2.results = data.result;
      }
    });
}
</script>