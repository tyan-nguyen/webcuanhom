<?php
use yii\helpers\Html;
?>
<link href="/css/print-display.css" rel="stylesheet">
<div class="row text-center">
    <div class="col-md-12">    
    <h3 class="text-primary">DANH SÁCH IN TEM</h3>
    <h4>(<?= $tieuDe ?>)</h4>
        <div id="print">        
            <?php 
            $count = count($models);
            //echo $count . '.....................';
            $stt = 0;
            foreach ($models as $index=>$model){
                //chỉ in qr của nhôm sử dụng nào có chiều dài >= chiều dài chặn dưới
                if($model->chieu_dai_con_lai >= $model->khoNhom->cayNhom->min_allow_cut_under){
                    $stt++;
                    
                        if($index == 0){
                            echo '<div class="wrap">';
                        } else {
                            echo $index%2==0?'<div class="wrap wrap2">':'';
                        }
               ?>
                    <div class="div-<?= $index%2==0?'left':'right' ?>">
                    <table>
                    <tr>
                    	<td><?= Html::img($model->qrImage, ['class'=>'img']) ?></td>
                    	<td class="title">
                        	#<?= $model->duAn->code?>-<?= $stt ?>                        	
                        	<br/>
                        	CD: <?= number_format($model->chieu_dai_con_lai) ?>
                        	<br/>
                        	TT:________
                    	</td>
                    </tr>
                    <tr>
                    <!-- <td colspan="2" align="center" class="title-2">DNTN SX-TM Nguyễn Trình</td> -->
                    <td colspan="2" align="center" class="title-2"><?= $model->khoNhom->cayNhom->ten_cay_nhom ?></td>
                    </tr>
                    </table>
                    </div>
              <?php  
                    if($index%2==1 || ($index+1)==$count){
                        echo '</div>';
                    }
                     if($index%2==1){
                        echo '<div class="clearfix"></div>';
                    }       
                }
            }
            ?> 
        
        </div><!-- print  -->
    </div>
</div> <!-- row -->