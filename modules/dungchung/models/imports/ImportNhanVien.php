<?php

namespace app\modules\dungchung\models\imports;

use app\modules\bophan\models\BoPhan;
use app\modules\bophan\models\NhanVien;
use app\modules\dungchung\models\CheckFile;
use app\modules\dungchung\models\CustomFunc;
use app\modules\dungchung\models\Import;

class ImportNhanVien
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
            if($index>=ImportNhanVien::START_ROW){
                //check B, check exist and not null
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = false;
                $mod->modelExist = BoPhan::find()->where(['ma_bo_phan'=>$row['B']]);
                $err = $mod->checkVal('B'.$index, $row['B']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                //check C, check duplicate and not null
                $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('C'.$index, $row['C']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                $mod = new CheckFile();
                $mod->isDuplicate = true;
                $mod->allowNull = true;
                $mod->modelDuplicate = NhanVien::find()->where(['ma_nhan_vien'=>$row['C']]);
                $err = $mod->checkVal('C'.$index, $row['C']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }else {
                    $cArr = Import::readExcelColsToArr($file, 'C'. ImportNhanVien::START_ROW .':C'.($index-1));
                    if(!empty($cArr)){
                        $cArrSimple = Import::convertColsToSimpleArr($cArr);
                        if(in_array($row['C'], $cArrSimple)){
                            array_push($errorByRow, 'C'.$index . ' đã tồn tại!');
                        }
                    }
                }
               //check D, not null
                $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('D'.$index, $row['D']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                //check F, not null
               /*  $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('F'.$index, $row['F']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                } */
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = [0, 1];
                $err = $mod->checkVal('F'.$index, $row['F']);
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
        foreach ($xls_data as $index=>$row){
            if($index>=ImportNhanVien::START_ROW){
                $model = new NhanVien();
                if($row['B']!=NULL){
                    $model->id_bo_phan = BoPhan::findOne(['ma_bo_phan'=>$row['B']])->id;
                }
                $model->ma_nhan_vien = $row['C'];
                $model->ten_nhan_vien = $row['D'];
                $model->gioi_tinh = $row['F'];
                $model->ngay_sinh = $row['E'];
                $model->chuc_vu = $row['G'];
                
                $cus = new CustomFunc();
                if($row['H'] != null)
                    $model->ngay_vao_lam = $cus->convertDMYToYMD($row['H']);
                
                $model->dien_thoai = $row['I'];
                $model->email = $row['J'];
                $model->dia_chi = $row['K'];
                
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