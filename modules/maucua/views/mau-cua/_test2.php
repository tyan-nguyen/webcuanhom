<?php
use app\modules\maucua\models\ToiUuNhom;
use app\modules\maucua\models\KhoNhom;
use app\modules\maucua\models\NhomSuDung;
use app\modules\maucua\models\NhomSuDungChiTiet;

function getKey($arr, $field, $value)
{
    foreach($arr as $key => $ar)
    {
        if ( $ar[$field] === $value )
            return $key;
    }
    return false;
}

//ham nay ok lay duoc nhung da ko can thiet nua da comment ko su dung
/* function getIdTonKhoInArray($arr, $key){
    $rt = false;
    foreach ($arr as $iAr => $ar){
        if($iAr == $key){
            
            $rt = $ar['idTonKhoNhom'];
        }
    }
    return $rt;
} */

/* echo count($model->getCatMoiTatCa());
 print_r($model->getCatMoiTatCa()); */


$newarray = array();
foreach($model->dsToiUu() as $key => $value){
    $newarray[$value['idTonKhoNhom']][$key] = $value;
}

$isAddNew = false;
$testnhomsd = NhomSuDung::findOne([
    'id_mau_cua'=>$model->id
]);
if($testnhomsd == null){
    $isAddNew = true;    
} else {
    echo $this->render('_test2_draw', ['model'=>$model]);
}
/* $newarray = array();
foreach($model->getCatMoiTatCa() as $key => $value){
    $newarray[$value['id_cay_nhom']][$key] = $value;
}
 */

var_dump($newarray);

/* foreach ($newarray as $v){

echo "\n------------";
var_dump( array_column($v, 'chieu_dai') );
$numbers = array_column($v, 'chieu_dai');
$desiredSum = 5900;
$chosen = ToiUuNhom::ToiUuCatMoi($numbers, $desiredSum);
echo "\nThese numbers sum to " . array_sum($chosen)  . " (closest to $desiredSum): ";
echo implode(", ", $chosen);
echo "\n";

var_dump($numbers);
foreach ($chosen as $i3=>$v3){
foreach ($numbers as $i4=>$v4) {
if($v4 == $v3){
unset($numbers[$i4]);
break;
}
}
}
var_dump($numbers);
} */
//$ii = 0;
foreach ($newarray as $vI => $v){
    // $ii++;
    
    $vCopy = $v;
    echo '---nhom list----';
    var_dump($vCopy);
    echo '---nhom list column----';
    var_dump(array_column($vCopy, 'idTonKhoNhom'));
    /////////////echo $arrayNhomList[10]['chieuDai'];
    
    $numbers = array_column($v, 'chieuDai');
    //var_dump($numbers);
    //$desiredSum = 5900;
    $tonKhoNhom = KhoNhom::findOne($vI);
    $desiredSum = $tonKhoNhom->chieu_dai;
    
    
    
    //echo '--chieudaitonkho:' . $desiredSum;
    /** da check toi day *********************/   
    /* break;
    return; */
    
    
    $result = ToiUu($numbers, $desiredSum, null);
    echo '\n----------------';
    echo implode(", ", $numbers);
    
    echo '\n result:';
    var_dump($result);
    
    foreach ($result as $i7=>$v7){
        $nhomsdSaveSuccess = false;
        if($isAddNew==true){
            $nhomsd = new NhomSuDung();
            $nhomsd->id_mau_cua = $model->id;
            $nhomsd->id_kho_nhom = $tonKhoNhom->id;
            $nhomsd->chieu_dai_ban_dau = $tonKhoNhom->chieu_dai;
            $nhomsd->chieu_dai_con_lai = $tonKhoNhom->chieu_dai - array_sum($v7);
            if($nhomsd->save()){
                $nhomsdSaveSuccess = true;
            }else {
                var_dump($nhomsd->errors);
            }
        }
        
        echo '<div style="margin-top:20px;">';
        $i=0;
        foreach ($v7 as $v8){
            
             if($nhomsdSaveSuccess == true ){
                $nhomct = new NhomSuDungChiTiet();
                $nhomct->id_nhom_su_dung = $nhomsd->id;
                
                $tKey = getKey($vCopy, 'chieuDai', $v8);
                $nhomct->id_nhom_toi_uu = $vCopy[$tKey]['id'];//khong lay $v de su dung loop
                
              //$nhomct->id_nhom_toi_uu = $v[$tKey]['idTonKhoNhom']; //cach nay ok
              //  $nhomct->id_nhom_toi_uu = getIdTonKhoInArray($v, $tKey); //cach nay ok
             // $nhomct->id_nhom_toi_uu = 715;
                if($nhomct->save()){
                    //remove key
                    unset($vCopy[$tKey]);
                } else {
                    var_dump($nhomct->errors);
                   ///// echo '----------key--'.$tKey;
                   // echo '-------valllll:'.$v[$tKey]['idTonKhoNhom'];
                }
            }
            
            
            //echo '\n';
            //$width = round($v8/$desiredSum,2)*100;
            $width = $v8/10/2;
            echo '<div style="width:'.$width.'px;border-bottom:5px solid #212121;float:left;">'.$v8.'</div>';
            echo '<div style="width:5px;border-bottom:5px solid yellow;float:left;">&nbsp;</div>';
            $i++;
        }
        $widthConLai = $desiredSum - array_sum($v7) - count($v7)*5;
        $widthConLaiPercent = $widthConLai/10/2;
        echo '<div style="width:'. $widthConLaiPercent .'px;border-bottom:5px solid #ff0000;float:left;">'.$widthConLai.'</div>';
        echo '</div><div style="clear:both"></div>';
    }
    
    
    
    /*     if($ii == 1){
     //break;
     } */
}

/*
 foreach ($model->getCatMoiTatCa() as $iCatMoi => $item){
 ?>
 <?=$iCatMoi ?>
 <?php
 }
 */

//$tuNhom = new ToiUuNhom();

function ToiUu($numbers, $desiredSum, $result){
    if($result == null){
        $result = array();
    }
    if($numbers == null){
        return $result;
    } else {
        
        $chosen = ToiUuNhom::ToiUuCatMoi($numbers, $desiredSum);
        
        //var_dump($numbers);
        $result[] = $chosen;
        foreach ($numbers as $i6=>$v6) {
            foreach ($chosen as $i5=>$v5){
                if($v5 == $v6){
                    //check lai logic that ky
                    unset($numbers[$i6]);
                    unset($chosen[$i5]);
                    break;
                }
            }
        }
        
        
        //var_dump($numbers);
        //return $result;
        if(empty($numbers)){
            return $result;
        } else {
            $aZero = array_values($numbers);
            // return $result;
            return ToiUu($aZero, $desiredSum, $result);
        }
    }
    
    /*  if($chosen == null){
     return $result;
     } else {
     ToiUu($numbers, $desiredSum, $result);
     } */
}



function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

?>
