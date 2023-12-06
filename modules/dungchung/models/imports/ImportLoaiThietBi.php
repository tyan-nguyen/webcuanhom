<?php

namespace app\modules\dungchung\models\imports;

use app\modules\dungchung\models\CheckFile;
use app\modules\dungchung\models\Import;
use app\modules\taisan\models\LoaiThietBi;

class ImportLoaiThietBi
{    
    CONST START_ROW = 3;
    CONST START_COL = 'B';
    
    /**
     * kiem tra file upload
     * @param string $type
     * @param string $file : filename
     * @return array[]
     */
    public static function checkFile($type, $file){
        $xls_data = Import::readExcelToArr($file);
        
        $errors = array();
        $errorByRow = array();
        
        foreach ($xls_data as $index=>$row){
            $errorByRow = array();
            if($index>=ImportLoaiThietBi::START_ROW){
                
                //check B <ma_loai> not null and not duplicate
                $mod = new CheckFile();
                $mod->isDuplicate = true;
                $mod->allowNull = false;
                $mod->modelDuplicate = LoaiThietBi::find()->where(['ma_loai'=>$row['B']]);
                $err = $mod->checkVal('B'.$index, $row['B']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                } else {
                    $bArr = Import::readExcelColsToArr($file, 'B'. ImportLoaiThietBi::START_ROW .':B'.($index-1));
                    if(!empty($bArr)){
                        $bArrSimple = Import::convertColsToSimpleArr($bArr);
                        if(in_array($row['B'], $bArrSimple)){
                            array_push($errorByRow, 'B'.$index . ' đã tồn tại!');
                        }
                    }
                }
                //check C <ten_loai> not null
                $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('C'.$index, $row['C']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                //check D x or X or NULL
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = ['x', 'X'];
                $err = $mod->checkVal('D'.$index, $row['D']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                //check E <truc_thuoc> exist or NULL
                $doCheckE = true;
                if($row['E'] != null){
                    $iArr = Import::readExcelColsToArr($file, 'B'. ImportLoaiThietBi::START_ROW .':B'.($index-1));
                    if(!empty($iArr)){
                        $iArrSimple = Import::convertColsToSimpleArr($iArr);
                        if(in_array($row['E'], $iArrSimple)){
                            $doCheckE = false;
                        }
                    }
                }
                if($doCheckE == true){
                    $mod = new CheckFile();
                    $mod->isExist = true;
                    $mod->allowNull = true;
                    $mod->modelExist = LoaiThietBi::find()->where(['ma_loai'=>$row['E']]);
                    $err = $mod->checkVal('E'.$index, $row['E']);
                    if(!empty($err)){
                        array_push($errorByRow, $err);
                    }
                }
                //check F <loai_thiet_bi> not null and in list
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = array_keys(LoaiThietBi::getDmLoaiThietBi());
                $err = $mod->checkVal('F'.$index, $row['F']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                //check G <ghi_chu>

            }
            if($errorByRow != null){
                //array_push($errors, $errorByRow);
                $errors[$index] = $errorByRow;
            }
        }        
        return $errors;
    }
    
    /**
     * import file đã kiểm tra vào csdl
     * @param string $file: ten file
     * @return number[]|string[][]
     */
    public static function importFile($file){
        $xls_data = Import::readExcelToArr($file);
        $errorByRow = array();
        $successCount = 0;
        $errorCount = 0;
        foreach ($xls_data as $index=>$row){
            if($index>=ImportLoaiThietBi::START_ROW){
                $model = new LoaiThietBi();
                $model->ma_loai = $row['B'];
                $model->ten_loai = $row['C'];
                if($row['E']!=NULL){
                    $model->truc_thuoc = LoaiThietBi::findOne(['ma_loai'=>$row['E']])!=null?LoaiThietBi::findOne(['ma_loai'=>$row['E']])->id:'';
                }
                $model->loai_thiet_bi = $row['F'];
                $model->ghi_chu = $row['G'];
                
                if($model->save()){
                    $successCount++;
                } else {
                    $errorCount++;
                    $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                }
            }
        }
        return [
            'success'=>$successCount,
            'error'=>$errorCount,
            'errorArr'=>$errorByRow,
        ];
    }
}