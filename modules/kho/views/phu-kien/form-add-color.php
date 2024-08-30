<?php
use app\modules\maucua\models\HeNhomMau;
use yii\widgets\ActiveForm;
use app\modules\maucua\models\CayNhom;
use app\modules\kho\models\PhuKien;
use app\modules\maucua\models\HeMau;
?>
<div class="col-md-6">
<?php $form = ActiveForm::begin(); ?>
	<h5>Màu hiện tại đã có</h5>
	<hr/>
	<?php 
	   $idMauExcludeArr = array();

	   $phuKienExist = PhuKien::find()->where([
	       'code' => $model->code,
	       'id_nhom_vat_tu' => 1,//1 la phu kien
	   ])->all();
	   
	   //$hasMauNull = false;
	   if($phuKienExist != null){
	       foreach ($phuKienExist as $pk){
	           //if($pk->id_he_mau == null)
	           //    $hasMauNull = true;
	           if($pk->id_he_mau != null)
	               $idMauExcludeArr[] = $pk->id_he_mau;
	    
	?>
    	<span style="background-color:<?= $pk->heMau?$pk->heMau->ma_mau:'white;border:1px solid #212121' ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    	<?= $pk->heMau?$pk->heMau->ten_he_mau:'Không màu' ?>
    	
   <?php    
	       }//end foreach
	   }//end if
	   ?>
	<br/>
	<h5 style="margin-top:20px">Màu muốn thêm</h5>
	<hr/>
	
	<?php         	   
	   $dsMau = HeMau::find()->where([
	       'for_phu_kien' => 1
	   ]);
	   //if($idMauExcludeArr != null && !($hasMauNull==true && count($idMauExcludeArr)==1) ){
	   if($idMauExcludeArr != null){
	       $mauExclude = implode(',', $idMauExcludeArr);
	       $dsMau = $dsMau->andWhere('id NOT IN ('.$mauExclude.')');
	   }
	   $dsMau = $dsMau->all();
	   if($dsMau){
	   foreach ($dsMau as $indexMau=>$mau){
	?>
	
    	<?php // $form->field($model, 'mauNhom['.$mau->id.']')->checkbox([])->label(false) ?>
    	
    	<input type="checkbox" name="PhuKien[copyMau][<?= $mau->id ?>]" value="1">
    	<span style="background-color:<?= $mau->ma_mau ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    	<?= $mau->ten_he_mau ?>
    	<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
	<?php 
    	   if(($indexMau+1)%3==0){
    	       echo '<br/>';
    	   } 
	   }//end foreach
	   } else{//end if
	 ?>
	 <div class="alert alert-warning" role="alert">
      	Không có hệ màu khác!
    </div>
	 <?php       
	   }
	?>
	<?php ActiveForm::end(); ?>
</div>