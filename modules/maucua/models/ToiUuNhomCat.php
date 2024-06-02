<?php
namespace app\modules\maucua\models;

class ToiUuNhomCat {
    /**
     * duyet qua mang number tao mang ket qua
     * @param unknown $numbers
     * @param unknown $desiredSum
     * @param unknown $result
     * @return array|unknown[][]|array|unknown[][]
     */
    public function ToiUu2($numbers, $desiredSum, $result){
        if($result == null){
            $result = array();
        }
        if($numbers == null){
            return $result;
        } else {
            
            $chosen = $this->ToiUuAlg($numbers, $desiredSum);
            
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
                return $this->ToiUu2($aZero, $desiredSum, $result);
            }
        }
        
        /*  if($chosen == null){
         return $result;
         } else {
         ToiUu($numbers, $desiredSum, $result);
         } */
    }
    
    public function ToiUuAlg($numbers, $desiredSum){
        sort($numbers);
        
        $set = [];
        $set[0] = [];
        
        for($i = $numbers[0];$i <= $desiredSum;++$i){
            foreach($numbers as $index => $current_number){
                if($i >= $current_number && isset($set[$i - $current_number])){
                    if(isset($set[$i - $current_number][$index])) continue;
                    $set[$i] = $set[$i - $current_number];
                    $set[$i][$index] = true;
                    break;
                }
            }
        }
        
        if(count($set) === 0){
            return [0,[]];
        }
        
        if(isset($set[$desiredSum])){
            //có sẵn tổng return luôn
            return $this->formatResult($numbers,array_keys($set[$desiredSum]));
        }else{
            $keys = array_keys($set);
            $nearestSum = end($keys);
            
            $sum = 0;
            $rev_numbers = array_reverse($numbers);
            
            $result = [];
            foreach($rev_numbers as $number){
                $sumTam = $sum + $number;
                if($sumTam <= $desiredSum) {
                    $sum += $number;
                    $result[] = $number;
                    if($sum > $nearestSum && abs($nearestSum - $desiredSum) > abs($sum - $desiredSum)){
                        $nearestSum = $sum;
                        break;
                    }else if($sum > $nearestSum && abs($nearestSum - $desiredSum) < abs($sum - $desiredSum)){
                        $result = $this->formatResult($numbers,array_keys($set[$nearestSum]));
                        break;
                    }
                }
            }
            
            return $result;
        }
        
    }
    
    public function formatResult($numbers,$keys){
        $result = [];
        foreach($keys as $key) $result[] = $numbers[$key];
        return $result;
    }
    
    public static function getKey($arr, $field, $value)
    {
        foreach($arr as $key => $ar)
        {
            if ( $ar[$field] === $value )
                return $key;
        }
        return false;
    }
    
}