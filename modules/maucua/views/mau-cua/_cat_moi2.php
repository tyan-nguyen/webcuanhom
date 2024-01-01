<div id="obj10">
		
		<div v-for="result in results" :key="result.id" >
			<!-- <p>{{ result.width }}</p> -->
			<div style="margin-top:20px;">
				<div v-for="result1 in result.soluong" :key="result1.id" :style="{
					width: result1.width/10 + 'px',
					borderBottom: '5px solid black',
					float: 'left',
					marginRight: '2px',
					textAlign: 'center'
				}">
					
					{{ result1.width }}
				</div>
				<div :style="{
					width: ( result.chieudai - (result.soluong.reduce((total, obj) => obj.width + total,0) + result.soluong.length * 2  ) )/10 + 'px',
					borderBottom: '5px solid red',
					float: 'left',
					textAlign: 'center'
				}">
					
					{{ result.chieudai - (result.soluong.reduce((total, obj) => obj.width + total,0) + result.soluong.length * 2) }}
				</div>
				<!-- <div style="width:{{}}px;border-bottom:5px solid #212121;float:left;"></div>; -->
				<div style="clear:both"></div>
			</div>
		</div>
</div>

<br/>

<!--  <a href="#" onclick="getDataa()" class="btn btn-primary btn-sm">Tạo tối ưu cắt</a> -->
	
<script type="text/javascript">
var vue10 = new Vue({
	el: '#obj10',
	data: {
		results: <?= json_encode($model->dsSuDung()) ?>  /*[
			{
    			id: 11,
    			soluong: [
        			{
        				id: 1,
        				width: 200
        			},
        			{
        				id: 2,
        				width: 300
        			},
        			{
        				id: 3,
        				width: 500
        			}
    			],
    			chieudai: 5900
			},
			{
    			id: 22,
    			soluong:[
        			{
        				id: 4,
        				width: 2000
        			}
    			],
    			chieudai: 3000
			}
		] */
	},
	methods: {
	},
	computed: {
		/* randomColor(){
			var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
            	color += letters[Math.floor(Math.random() * 16)];
            }
			return color;
		} */
	}
});		

/* function generateRandomInteger(min, max) {
  return Math.floor(min + Math.random()*(max - min + 1))
} */

function getDataa(){
	//alert('11111111!!');
	/* vue1.results = [
			{
    			id: 11,
    			soluong: [
        			{
        				id: 1,
        				width: generateRandomInteger(100,3000)
        			},
        			{
        				id: 2,
        				width: generateRandomInteger(100,3000)
        			}
    			],
    			chieudai: 5900
			},
			{
    			id: 22,
    			soluong:[
        			{
        				id: 4,
        				width: generateRandomInteger(100,3000)
        			},
        			{
        				id: 4,
        				width: generateRandomInteger(100,3000)
        			}
    			],
    			chieudai: 5900
			}
		]; */
    $.ajax({
      type: 'GET',
        dataType:"json",
      url: '/maucua/mau-cua/get-data',
      success: function (data, status, xhr) {
        	vue10.results = data.result /* [
			{
    			id: 11,
    			soluong: [
        			{
        				id: 1,
        				width: generateRandomInteger(100,3000)
        			},
        			{
        				id: 2,
        				width: generateRandomInteger(100,3000)
        			}
    			],
    			chieudai: 5900,
    			vetcat : 2,
    			mincut: 500
			},
			{
    			id: 22,
    			soluong:[
        			{
        				id: 4,
        				width: generateRandomInteger(100,3000)
        			},
        			{
        				id: 5,
        				width: generateRandomInteger(100,3000)
        			}
    			],
    			chieudai: 5900,
    			vetcat : 2,
    			mincut: 500
			}
		]; */
      }
    });
}
</script>