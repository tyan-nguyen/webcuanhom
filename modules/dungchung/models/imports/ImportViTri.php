<?php

namespace app\modules\dungchung\models\imports;

use app\modules\dungchung\models\CheckFile;
use app\modules\dungchung\models\CustomFunc;
use app\modules\dungchung\models\Import;
use app\modules\taisan\models\ViTri;

class ImportViTri
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
            if($index>=ImportViTri::START_ROW){
                
                //check B <ma_vi_tri> not null and not duplicate
                $mod = new CheckFile();
                $mod->isDuplicate = true;
                $mod->allowNull = false;
                $mod->modelDuplicate = ViTri::find()->where(['ma_vi_tri'=>$row['B']]);
                $err = $mod->checkVal('B'.$index, $row['B']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                } else {
                    $bArr = Import::readExcelColsToArr($file, 'B'. ImportViTri::START_ROW .':B'.($index-1));
                    if(!empty($bArr)){
                        $bArrSimple = Import::convertColsToSimpleArr($bArr);
                        if(in_array($row['B'], $bArrSimple)){
                            array_push($errorByRow, 'B'.$index . ' đã tồn tại!');
                        }
                    }
                }
                //check C <ten_vi_tri> not null
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
                    $iArr = Import::readExcelColsToArr($file, 'B'. ImportViTri::START_ROW .':B'.($index-1));
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
                    $mod->modelExist = ViTri::find()->where(['ma_vi_tri'=>$row['E']]);
                    $err = $mod->checkVal('E'.$index, $row['E']);
                    if(!empty($err)){
                        array_push($errorByRow, $err);
                    }
                }
                //check F x or X or NULL
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = ['x', 'X'];
                $err = $mod->checkVal('F'.$index, $row['F']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                //check G <ngay_ngung_hoat_dong>
                //chek H <toa_do_X>
                //check I <toa_do_Y>
                //check J <ghi_chu>
                
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
            if($index>=ImportViTri::START_ROW){
                $model = new ViTri();
                $model->ma_vi_tri = $row['B'];
                $model->ten_vi_tri = $row['C'];
                if($row['E']!=NULL){
                    $model->truc_thuoc = ViTri::findOne(['ma_vi_tri'=>$row['E']])!=null?ViTri::findOne(['ma_vi_tri'=>$row['E']])->id:'';
                }
                $model->da_ngung_hoat_dong = strtolower($row['F'])=='x'?1:0;
                $cus = new CustomFunc();
                if($row['G'] != null)
                    $model->ngay_ngung_hoat_dong = $cus->convertDMYToYMD($row['G']);
                
                $model->mo_ta = $row['J'];
                
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