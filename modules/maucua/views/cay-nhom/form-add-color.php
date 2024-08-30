<?php
use app\modules\maucua\models\HeNhomMau;
use yii\widgets\ActiveForm;
use app\modules\maucua\models\CayNhom;
?>
<div class="col-md-6">
<?php $form = ActiveForm::begin(); ?>
	<h5>Màu hiện tại đã có</h5>
	<hr/>
	<?php 
	   $nhomExcludeArr = array();
	  /*  if($model->heMau){
	       $nhomExcludeArr[] = $model->id_he_mau;
	   } */
	   $cayNhomExist = CayNhom::find()->where([
	       'code' => $model->code,
	       'id_he_nhom' => $model->id_he_nhom,
	       //'do_day' => $model->do_day
	   ])->andWhere('cast(do_day as decimal(5,2)) ='.$model->do_day)->all();
	   if($cayNhomExist != null){
	       foreach ($cayNhomExist as $cn){
	           $nhomExcludeArr[] = $cn->id_he_mau;
	    
	?>
    	<span style="background-color:<?= $cn->heMau?$cn->heMau->ma_mau:'' ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    	<?= $cn->heMau?$cn->heMau->ten_he_mau:'' ?>
    	
   <?php    
	       }//end foreach
	   }//end if
	   ?>
	<br/>
	<h5 style="margin-top:20px">Màu muốn thêm</h5>
	<hr/>
	
	<?php         	   
	   $dsMau = HeNhomMau::find()->where([
	       'id_he_nhom' => $model->id_he_nhom
	   ]);
	   if($nhomExcludeArr != null){
	       $nhomExclude = implode(',', $nhomExcludeArr);
	       $dsMau = $dsMau->andWhere('id_he_mau NOT IN ('.$nhomExclude.')');
	   }
	   $dsMau = $dsMau->all();
	   if($dsMau){
	   foreach ($dsMau as $indexMau=>$mau){
	?>
	
    	<?php // $form->field($model, 'mauNhom['.$mau->id.']')->checkbox([])->label(false) ?>
    	
    	<input type="checkbox" id="mauNhom" name="CayNhom[copyMauNhom][<?= $mau->id_he_mau ?>]" value="1">
    	<span style="background-color:<?= $mau->mau->ma_mau ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    	<?= $mau->mau->ten_he_mau ?>
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