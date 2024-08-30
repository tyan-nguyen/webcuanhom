<style>
.triangle{
    min-width: 100px;
}
.triangle-none {
    border-left: 0px solid transparent;
    border-right: 0px solid transparent;
    border-bottom: 50px solid green;
    border-top: 50px solid transparent;
    display: inline-block;
}
.triangle-both {
    border-left: 50px solid transparent;
    border-right: 50px solid transparent;
    border-bottom: 50px solid green;
    border-top: 50px solid transparent;
    display: inline-block;
}
.triangle-left {
    border-left: 50px solid transparent;
    border-right: 0 solid transparent;
    border-bottom: 50px solid green;
    border-top: 50px solid transparent;
    display: inline-block;
}
.triangle-right {
    border-left: 0px solid transparent;
    border-right: 50px solid transparent;
    border-bottom: 50px solid green;
    border-top: 50px solid transparent;
    display: inline-block;
}

#obj10{
    font-size: 12px;
}

</style>

<div id="objDuAnToiUu">
		
		<div v-for="(result, indexResult) in results" :key="result.id" >
			<!-- <p>{{ result.width }}</p> -->
			<h6 style="margin-top:20px"> [{{ result.stt }}] Cây nhôm {{ result.macaynhom }} ({{result.codeHeMau}}) ({{ result.chieudai }})</h6>
			<div style="margin-top:20px 0px;">
				<div v-for="result1 in result.soluong" :key="result1.id" :style="{
					width: (result1.width-result1.left-result1.right)/7 + 'px',
					//borderBottom: '10px solid black',
					float: 'left',
					marginRight: '1px',
					textAlign: 'center',
					borderLeft: result1.left + 'px solid transparent',
                    borderRight: result1.right + 'px solid transparent',
                    borderBottom: '10px solid #0d6efd',
                    //borderTop: '20px solid transparent',
                    display: 'inline-block'
				}">					
					{{ result1.width }}
				</div>
				
				<div :style="{
					width: ( result.chieudai - (result.soluong.reduce((total, obj) => obj.width + total,0) + result.soluong.length * result.vetcat  ) )/7 + 'px',
					borderBottom: '10px solid red',
					float: 'left',
					textAlign: 'center'
				}">
					
					{{ result.chieudai - (result.soluong.reduce((total, obj) => obj.width + total,0) + result.soluong.length * result.vetcat) }}
				</div>
				
				
				
				<!-- <div style="width:{{}}px;border-bottom:5px solid #212121;float:left;"></div>; -->
				<div style="clear:both"></div>
				
				<!-- for label -->
				<div v-for="result1 in result.soluong" :key="result1.id" :style="{
					width: (result1.width-result1.left-result1.right)/7 + 'px',
					//borderBottom: '10px solid black',
					float: 'left',
					marginRight: '1px',
					textAlign: 'center',
					//borderLeft: result1.left + 'px solid transparent',
                    //borderRight: result1.right + 'px solid transparent',
                   // borderBottom: '10px solid #0d6efd',
                    //borderTop: '20px solid transparent',
                    display: 'inline-block'
				}">					
					[{{ result1.mauCuaCode }}]
				</div>
				<div style="clear:both"></div>
				
			</div>
		</div>
</div>

<br/>

<!--  <a href="#" onclick="getDataa()" class="btn btn-primary btn-sm">Tạo tối ưu cắt</a> -->
	
<script type="text/javascript">
var vueDuAnToiUu = new Vue({
	el: '#objDuAnToiUu',
	data: {
		results: <?= json_encode($model->dsSuDung()) ?>  
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
    $.ajax({
      type: 'GET',
        dataType:"json",
      url: '/maucua/du-an/get-nhom-su-dung-toi-uu',//dang xu ly......................
      success: function (data, status, xhr) {
        	vueDuAnToiUu.results = data.result
      }
    });
}
</script>