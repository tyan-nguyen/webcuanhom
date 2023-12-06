<?php

namespace app\modules\dungchung\models\imports;

use app\modules\bophan\models\BoPhan;
use app\modules\dungchung\models\CheckFile;
use app\modules\dungchung\models\Import;
use app\modules\kho\models\KhoVatTu;
use app\modules\kho\models\DonViTinh;

class ImportKhoVatTu
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
            if($index>=ImportKhoVatTu::START_ROW){
                //check B duplicate
                $mod = new CheckFile();
                $mod->isDuplicate = true;
                $mod->modelDuplicate = KhoVatTu::find()->where(['code'=>$row['B']]);
                $err = $mod->checkVal('B'.$index, $row['B']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                } else {
                    $bArr = Import::readExcelColsToArr($file, 'B'. ImportKhoVatTu::START_ROW .':B'.($index-1));
                    if(!empty($bArr)){
                        $bArrSimple = Import::convertColsToSimpleArr($bArr);
                        if(in_array($row['B'], $bArrSimple)){
                            array_push($errorByRow, 'B'.$index . ' đã tồn tại!');
                        }
                    }               
                }
                
                //check C
                $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('C'.$index, $row['C']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check D = 0,1,2,3 or null
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = [0, 1, 2, 3];
                $err = $mod->checkVal('D'.$index, $row['D']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }    
                
                //check E = x or X or null
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = ['x', 'X'];
                $err = $mod->checkVal('E'.$index, $row['E']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
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
        $errors = array();
        foreach ($xls_data as $index=>$row){
            if($index>=ImportKhoVatTu::START_ROW){
                $model = new KhoVatTu();
                $model->code = $row['B'];
                $model->ten_vat_tu = $row['C'];
                $model->id_nhom_vat_tu = $row['D'];                
                $model->la_phu_kien = strtolower($row['E'])=='x'?1:0;
                $model->so_luong = $row['F'];
                if($row['G'] == null){
                    $model->dvt = 1;//1 is chưa phân loại
                } else {
                    $donViTinh = DonViTinh::find()->where(['ten_dvt'=>$row['G']])->one();
                    if($donViTinh!=null){
                        $model->dvt = $donViTinh->id;
                    } else {
                        $dvtModel = new DonViTinh();
                        $dvtModel->ten_dvt = $row['G'];
                        $dvtModel->save();
                        $model->dvt = $dvtModel->id;
                    }
                }
                $model->don_gia = $row['H'];
                $model->ghi_chu = $row['I'];
                if($model->save()){
                    $successCount++;
                } else {
                    $errorCount++;
                    $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                    $errors[] = $model->errors();
                }
            }
        }
        return [
            'success'=>$successCount,
            'error'=>$errorCount,
            'errorArr'=>$errorByRow,
            'errors'=>$errors
        ];
    }
}