<?php
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use app\modules\kho\models\XuatXu;
use app\modules\maucua\models\HeMau;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\HeNhom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="he-nhom-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="row">	
    	<div class="col-md-6">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($model, 'ten_he_nhom')->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'do_day_mac_dinh')->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'xuat_xu')->dropDownList( (new XuatXu())->getList(), [
           	    'prompt'=>'-Chọn-'
           	] ) ?>
           	
           	<?= $form->field($model, 'hang_san_xuat')->textInput(['maxlength' => true]) ?>
           	
           	<?php // $form->field($model, 'nha_cung_cap')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($model, 'ghi_chu')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-6">
        	<h2>HỆ MÀU</h2> 
        	
        	<br/>
        	<h5>Đang cấu hình</h5>
        	<hr/>
        	
        	<?php $nhomExcludeArr = array(); ?>
        	<?php if($model->mauNhoms !=null){?>
        	<table>
        		<tr><td></td><td>Là mặc định</td></tr>
        		
        	<?php         	
        	foreach ($model->mauNhoms as $indexMauNhom=>$mauNhom){
        	    $nhomExcludeArr[] = $mauNhom->id_he_mau;
        	?>
        	<tr>
        	<td>
        	<input type="checkbox" id="mauNhom" name="HeNhom[mauNhom][<?= $mauNhom->id_he_mau ?>]" value="1" checked>
            	<span style="background-color:<?= $mauNhom->mau->ma_mau ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            	<?= $mauNhom->mau->ten_he_mau ?> (<?= $mauNhom->mau->code ?>)
            	
            </td>
            <td class="text-center">
            <input type="radio" id="html" name="HeNhom[mauMacDinhInput]" value="<?= $mauNhom->id_he_mau ?>" <?= ($model->mauMacDinh!=null && ($model->mauMacDinh->id == $mauNhom->id_he_mau)) ? 'checked' : ''?>>	
            </td>
        	</tr>
        	<?php // $form->field($model, 'mauNhom['.$mauNhom->id_he_mau.']')->checkbox(['checked'=>true, 'value'=>1]) ?>
        	
        	<?php } ?>
        		
        	</table>
        	<?php } //if($model->mauNhoms !=null)?>
        	<br/>
        	<h5 style="margin-top:20px">Màu khác</h5>
        	<hr/>
        	
        	<?php         	   
        	   $dsMau = HeMau::find()->where([
        	       'for_nhom' => 1
        	   ]);
        	   if($nhomExcludeArr != null){
        	       $nhomExclude = implode(',', $nhomExcludeArr);
        	       $dsMau = $dsMau->andWhere('id NOT IN ('.$nhomExclude.')');
        	   }
        	   $dsMau = $dsMau->all();
        	   if($dsMau){
        	   foreach ($dsMau as $indexMau=>$mau){
        	?>
        	
            	<?php // $form->field($model, 'mauNhom['.$mau->id.']')->checkbox([])->label(false) ?>
            	
            	<input type="checkbox" id="mauNhom" name="HeNhom[mauNhom][<?= $mau->id ?>]" value="1">
            	<span style="background-color:<?= $mau->ma_mau ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            	<?= $mau->ten_he_mau ?> (<?= $mau->code ?>)
            	<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
        	<?php 
            	   if(($indexMau+1)%3==0){
            	       echo '<br/>';
            	   } 
        	   }
        	   } else {//end if
        	 ?>
        	       <div class="alert alert-warning" role="alert">
        	       Không có hệ màu khác!
        	       </div>
        	<?php 
        	   }
        	?>
        	
        </div>
    </div>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Ghi dữ liệu' : 'Cập nhật dữ liệu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
