<?php 
/**
 * tinh nhom su dung theo mang toi uu
 */
?>
<?php
use app\modules\maucua\models\MauCua;
use app\modules\maucua\models\ToiUuNhom;
use app\modules\maucua\models\KhoNhom;
use app\modules\maucua\models\NhomSuDung;
use app\modules\maucua\models\NhomSuDungChiTiet;

$mauCuaModel = MauCua::findOne(44);

$mauCuaModel->deleteNhomSuDung();

$dsSuDung = $mauCuaModel->dsSuDung();
$dsToiUu = $mauCuaModel->dsToiUu();


$newarray = array();
foreach($dsToiUu as $key => $value){
    $newarray[$value['idTonKhoNhom']][$key] = $value;
}

//var_dump($newarray);

foreach ($newarray as $vI => $v){
    //if($vI == 189){
        echo '<br/>Cây nhôm:' . $vI;
        echo '<br/>Số lượng:' . sizeof($v);
        
        $vCopy = $v;
        $numbersss = array_column($v, 'chieuDai');
        
        $tonKhoNhom = KhoNhom::findOne($vI);
        $desiredSum = $tonKhoNhom->chieu_dai;
        $numberss = array_chunk($numbersss, 20);
        foreach ($numberss as $numbers){
        //
            $result = ToiUu($numbers, $desiredSum, null);
            
            foreach ($result as $i7=>$v7){
                $nhomsdSaveSuccess = false;
                $nhomsd = new NhomSuDung();
                $nhomsd->id_mau_cua = 44;
                $nhomsd->id_kho_nhom = $tonKhoNhom->id;
                $nhomsd->chieu_dai_ban_dau = $tonKhoNhom->chieu_dai;
                $nhomsd->chieu_dai_con_lai = $tonKhoNhom->chieu_dai - array_sum($v7);
                if($nhomsd->save()){
                    $nhomsdSaveSuccess = true;
                }else {
                    var_dump($nhomsd->errors);
                }
                
                $i=0;
                foreach ($v7 as $v8){
                    
                    if($nhomsdSaveSuccess == true ){
                        $nhomct = new NhomSuDungChiTiet();
                        $nhomct->id_nhom_su_dung = $nhomsd->id;
                        $tKey = ToiUuNhom::getKey($vCopy, 'chieuDai', $v8);
                        $nhomct->id_nhom_toi_uu = $vCopy[$tKey]['id'];//khong lay $v de su dung loop
                        if($nhomct->save()){
                            //remove key
                            unset($vCopy[$tKey]);
                        } else {
                            var_dump($nhomct->errors);
                        }
                    }
                    $i++;
                }
            }
        //
        }
        
    //}if $vI=189
}



//$mauCuaModel1->taoNhomSuDung();

//var_dump($dsSuDung);
//var_dump($dsToiUu);




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