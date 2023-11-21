<?php 
use app\modules\maucua\models\ToiUuNhom;

/* echo count($model->getCatMoiTatCa());
print_r($model->getCatMoiTatCa()); */


$newarray = array();
foreach($model->getCatMoiTatCa() as $key => $value){
    $newarray[$value['id_cay_nhom']][$key] = $value;
}

//var_dump($newarray);

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
foreach ($newarray as $v){
   // $ii++;
    
    $numbers = array_column($v, 'chieu_dai');
    //var_dump($numbers);
    $desiredSum = 5900;
    $result = ToiUu($numbers, $desiredSum, null);
    echo '\n----------------';
    echo implode(", ", $numbers);
    
    echo '\n';
    var_dump($result);
    
    foreach ($result as $i7=>$v7){
        echo '<div style="margin-top:20px;">';
        $i=0;
        foreach ($v7 as $v8){
            //echo '\n';
            //$width = round($v8/$desiredSum,2)*100;
            $width = $v8/10/2;
            echo '<div style="width:'.$width.'px;border-bottom:5px solid #212121;float:left;">'.$v8.'</div>';
            echo '<div style="width:5px;border-bottom:5px solid yellow;float:left;">&nbsp;</div>';
            $i++;
        }
       $widthConLai = 5900 - array_sum($v7) - count($v7)*5;
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