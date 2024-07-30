<?php
use yii\helpers\Html;
use app\custom\CustomFunc;
use app\modules\dungchung\models\HinhAnh;
use app\modules\maucua\models\MauCua;
$custom = new CustomFunc();
?>

<div class="row text-center" style="width: 100%">
    <div class="col-md-12" style="width: 100%"> 
    
    <table id="table-top" style="width: 100%">
		<tr>
			<td style="width:10px;text-align: right">
				<img src="/images/logo_500.png" width="60px" />
			</td>
			<td style="text-align: left;padding-left:20px">
				<span style="font-weight: bold; font-size:14pt">DNTN SX-TM NGUYỄN TRÌNH</span>
				<br/>
				<span style="font-size:10pt">ĐC: Nguyễn Đáng, Khóm 10, P.9, TP.TV</span>
				<br/>
				<span style="font-size:10pt">ĐT: 090.333.6470</span>				
			</td>
			<td>
				<div style="margin-top: 10px;">Ngày:<?= date('d/m/Y') ?></div>
				<div style="margin-top: 10px;">
					<span class="span-status"><?= $model->getDmTrangThaiLabel($model->trang_thai) ?></span> 
				</div>
			</td>
		</tr>
    </table>
    
    <table style="width: 100%">
		<tr>
			<td style="text-align: center"><span class="phieu-h1">PHIẾU XUẤT KHO SẢN XUẤT CỬA</span></td>
		</tr>
		<tr>
			<td style="text-align: center">
				<span>Ngày thực hiện: <?= $custom->convertYMDToDMY($model->ngay_bat_dau_thuc_hien) ?></span>
			</td>
		</tr>
    </table>
    
    <table style="width: 100%">
    		<tr>
    			<td style="text-align: left">Mã kế hoạch: <?= $model->code ?><td>
    		</tr>
    		<tr>
    			<td style="text-align: left">Tên kế hoạch: <?= $model->ten_du_an ?><td>
    		</tr>
    		<!-- <tr>
    			<td style="text-align: left">Nội dung: <?= $model->ghi_chu ?><td>
    		</tr> -->
    		
    </table>
    
    
    <?php /*foreach ($model->mauCuas as $iMauCua=>$mauCua){?>
    <table style="width: 100%">
    		<tr>
    			<td style="text-align: left; width:30%">Tên cửa:<br/> <?= $mauCua->ten_cua ?></td>
    			<td rowspan="5" style="text-align: left">
    				<?php 
    				    $hinhAnhCua = HinhAnh::getHinhAnhThamChieuOne(MauCua::MODEL_ID, $mauCua->id);
    				    if($hinhAnhCua != null){
    				        echo Html::img($hinhAnhCua->hinhAnhUrl, ['style'=>'max-width:100%']);
    				    }
    				?>
    			</td>
    		</tr>
    		<tr>
    			<td style="text-align: left; width:30%">Kích thước:<br/> <?= $mauCua->kich_thuoc ?></td>
    		</tr>
    		<tr>
    			<td style="text-align: left; width:30%">Số lượng:<br/> <?= $mauCua->so_luong ?></td>
    		</tr>
    		<tr>
    			<td style="text-align: left; width:30%">Hệ nhôm:<br/> <?= $mauCua->heNhom->ten_he_nhom ?></td>
    		</tr>
    		<tr>
    			<td style="text-align: left; width:30%">Loại cửa:<br/> <?= $mauCua->loaiCua->ten_loai_cua ?></td>
    		</tr>
    </table>
    <?php }*/?>
    
    <table class="table-content" style="width: 100%">
    <?php 
        $sl = count($model->mauCuas);
        $imc = 1;
    ?>
    <tr>
    	<td colspan="3" style="text-align: center"><span class="phieu-h1">CHI TIẾT CỬA</span></td>
    </tr>
    
    <?php    
    foreach ($model->mauCuas as $iMauCua=>$mauCua){
        
        $divMauCua = '<div style="width:100%;">';//div wrap
        $divMauCua .= '<div style="width:29%;float:left;">';
        $divMauCua .= '<p>Mã: ' . $mauCua->code .'</p>';
        $divMauCua .= '<p>Số lượng: ' . $mauCua->so_luong . ' (bộ)</p>';
        $divMauCua .= '</div>';
        $divMauCua .= '<div style="width:59%;float:left;border-left:1px solid #212121; padding-left:20px">';
        $divMauCua .= '<p>Tên cửa: '. $mauCua->ten_cua . '</p>';
        $divMauCua .= '<p>Kích thước: '. $mauCua->kich_thuoc . '</p>';
        $divMauCua .= '<p>Hệ nhôm'. $mauCua->heNhom->ten_he_nhom . '</p>';
        //$divMauCua .= '<p>Tên công trình: '. $mauCua->congTrinh->ten_cong_trinh . '</p>';
        $divMauCua .= '<p>Chủ đầu tư: '. $mauCua->congTrinh->khachHang->ten_khach_hang . '</p>';
        $divMauCua .= '</div>';
        $divMauCua .= '<div style="width:100%;clear:both">';
        $hinhAnhCua = HinhAnh::getHinhAnhThamChieuOne(MauCua::MODEL_ID, $mauCua->id);
        if($hinhAnhCua != null){
            $divMauCua .= Html::img($hinhAnhCua->hinhAnhUrl, ['style'=>'max-width:100%;']);
        }
        $divMauCua .= '</div>';
        $divMauCua .= '</div>';//end div wrap
        if($imc %3 == 1){
            echo '<tr>';
            echo '<tr><td style="width:33%">' . $divMauCua . '</td>';
        } else if($imc % 3 == 2){
            echo '<td style="width:33%">' . $divMauCua . '</td>';
        } else if($imc % 3 == 0){
            echo '<td>' . $divMauCua . '</td></tr>';
            echo '</tr>';
        }
        
        if($sl==$imc){
            if($imc%3==1){
                echo '<td></td><td></td></tr>';
            }
            if($imc%3==2){
                echo '<td></td></tr>';
            }
        }
        $imc ++;
     }?>
     
    </table>
    
    
    <table  class="tbl-header" style="width: 100%">
    		<tr>
    			<td style="text-align: center"><span class="phieu-h1">DANH SÁCH NHÔM SỬ DỤNG</span></td>
    		</tr>    		
    </table>
    
    <table class="table-content" style="width: 100%">
    		<thead>
        		<tr>
        			<td>STT</td>
        			<td>Mã cây nhôm</td>
        			<td>Tên cây nhôm</td>
        			<td>Chiều dài (mm)</td>
        			<td>Số đoạn cắt</td>
        			<td>Chi tiết cắt</td>
        			<td>Chiều dài còn lại</td>
        			<td>Mã QR</td>
        			<td>Chiều dài thực tế<br/>còn lại</td>
        		</tr>   
    		</thead> 
    		<tbody>
    		<?php // duyet so luong cay  nhom su dung ?>
    		<?php 
    		    $stt = 0;
        		foreach ($model->dsNhomSuDung as $indexNhom => $nhom){
        		    $maQR = '';
        		    if($nhom->chieu_dai_con_lai >= $nhom->khoNhom->cayNhom->min_allow_cut_under){
        		        $stt++;
        		        //$maQR = '#' . $nhom->duAn->code . '-'. $stt;
        		        $maQR = '#'.$stt;
        		    }
        		    $chiTietCat = '';
        		    $lk='';
        		    foreach ($nhom->chiTiet as $indexChiTiet=>$chiTiet){
        		        if($indexChiTiet>0){
        		            $lk = '<br/>';
        		        }
        		        $chiTietCat .= $lk . $chiTiet->nhomToiUu->mauCua->ten_cua . '(' . $chiTiet->nhomToiUu->mauCua->code . ')';
        		        $chiTietCat .= ' - Chiều dài: ' . number_format($chiTiet->nhomToiUu->mauCuaNhom->chieu_dai);
        		        $chiTietCat .= ' - Kiểu cắt: ' . $chiTiet->nhomToiUu->mauCuaNhom->kieu_cat;
        		    }
            ?>
            <tr>
            	<td style="text-align:center"><?= ($indexNhom+1) ?></td>
            	<td style="text-align:center"><?= $nhom->khoNhom->cayNhom->code ?></td>
            	<td><?= $nhom->khoNhom->cayNhom->ten_cay_nhom ?></td>
            	<td style="text-align:right"><?= number_format($nhom->chieu_dai_ban_dau) ?></td>
            	<td style="text-align:right"><?= count($nhom->chiTiet) ?></td>
            	<td style="text-align:left"><?= $chiTietCat ?></td>
            	<td style="text-align:right"><?= number_format($nhom->chieu_dai_con_lai) ?></td>
            	<td style="text-align:center"><?= $maQR ?><br/><?= Html::img($nhom->qrImage, ['class'=>'img']) ?></td>
            	<td style="text-align:right"></td>
            </tr>
            <?php } ?>	
            </tbody>
    </table>    
    
    <table  class="tbl-header" style="width: 100%">
    		<tr>
    			<td style="text-align: center"><span class="phieu-h1">CHI TIẾT CẮT NHÔM</span></td>
    		</tr>    		
    </table>
    
    <div id="divCutImage"></div>
    
    </div>
</div> <!-- row -->