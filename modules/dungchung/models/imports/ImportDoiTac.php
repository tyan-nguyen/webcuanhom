<?php

namespace app\modules\dungchung\models\imports;

use app\modules\bophan\models\DoiTac;
use app\modules\bophan\models\NhomDoiTac;
use app\modules\dungchung\models\CheckFile;
use app\modules\dungchung\models\Import;

class ImportDoiTac
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
            if($index>=ImportDoiTac::START_ROW){
                
                //check B <id_nhom_doi_tac> exist and not null
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = false;
                $mod->modelExist = NhomDoiTac::find()->where(['ma_nhom'=>$row['B']]);
                $err = $mod->checkVal('B'.$index, $row['B']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check C <ma_thiet_bi> is not null and not duplicate
                $mod = new CheckFile();
                $mod->isDuplicate = true;
                $mod->allowNull = false;
                $mod->modelDuplicate = DoiTac::find()->where(['ma_doi_tac'=>$row['C']]);
                $err = $mod->checkVal('C'.$index, $row['C']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                } else {
                    $bArr = Import::readExcelColsToArr($file, 'C'. ImportDoiTac::START_ROW .':C'.($index-1));
                    if(!empty($bArr)){
                        $bArrSimple = Import::convertColsToSimpleArr($bArr);
                        if(in_array($row['C'], $bArrSimple)){
                            array_push($errorByRow, 'C'.$index . ' đã tồn tại!');
                        }
                    }
                }
                
                //check D <ten_doi_tac> is not null
                $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('D'.$index, $row['D']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check E <dia_chi>
                //check F <dien_thoai>
                //check G <email>
                //check H <tai_khoan_ngan_hang>
                //check I <ma_so_thue>
                //check J <la_nha_cung_cap> = x or X or null
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = ['x', 'X'];
                $err = $mod->checkVal('J'.$index, $row['J']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                //check K <la_khach_hang> = x or X or null
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = ['x', 'X'];
                $err = $mod->checkVal('K'.$index, $row['K']);
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
            if($index>=ImportDoiTac::START_ROW){
                $model = new DoiTac();
                if($row['B']!=NULL){
                    $model->id_nhom_doi_tac = NhomDoiTac::findOne(['ma_nhom'=>$row['B']])!=null?NhomDoiTac::findOne(['ma_nhom'=>$row['B']])->id:'';
                }
                $model->ma_doi_tac = $row['C'];
                $model->ten_doi_tac = $row['D'];
                $model->dia_chi = $row['E'];
                $model->dien_thoai = $row['F'];
                $model->email = $row['G'];
                $model->tai_khoan_ngan_hang = $row['H'];
                $model->ma_so_thue = $row['I'];
                $model->la_nha_cung_cap = strtolower($row['J'])=='x'?1:0;
                $model->la_khach_hang = strtolower($row['K'])=='x'?1:0;
                
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