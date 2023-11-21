<?php
namespace app\modules\maucua\models;

class ToiUuNhom {
    public static function ToiUuCatMoi($numbers, $desiredSum){
        $minDist = null;
        $minDist_I = null;
        // Iterate on every possible combination
        $maxI = pow(2,sizeof($numbers));
        for($i=0;$i<$maxI;$i++) {
            if(!(($i+1) % 1000)) echo ".";
            
            // Figure out which numbers to select in this
            $sum = 0;
            for($j=0;$j<sizeof($numbers);$j++) {
                if($i & (1 << $j)) {
                    if( ($sum+$numbers[$j]) <= $desiredSum){
                        $sum += $numbers[$j];
                    } else {
                        continue;
                    }
                }
            }
            
            $diff = abs($sum - $desiredSum);
            if($minDist_I === null || $diff < $minDist) {
                $minDist_I = $i;
                $minDist = $diff;
            }
            
            if($diff == 0) break;
        }
        $chosen = array();
        for($j=0;$j<sizeof($numbers);$j++) {
            if($minDist_I & (1 << $j)) $chosen[] = $numbers[$j];
        }
        
        return $chosen;

    }

}