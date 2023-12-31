<?php

namespace app\modules\dungchung\models\imports;

use app\modules\dungchung\models\CheckFile;
use app\modules\dungchung\models\Import;
use app\modules\kho\models\PhuKien;
use app\modules\kho\models\DonViTinh;
use app\modules\kho\models\KhoVatTu;
use app\modules\kho\models\NhaCungCap;
use app\modules\maucua\models\HeNhom;
use app\modules\maucua\models\CayNhom;
use app\modules\maucua\models\KhoNhom;
use app\modules\maucua\models\KhoNhomLichSu;

class ImportKhoNhom
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
            if($index>=ImportPhuKien::START_ROW){
                //check B (code) duplicate
               /*  $mod = new CheckFile();
                $mod->isDuplicate = true;
                $mod->modelDuplicate = PhuKien::find()->where(['code'=>$row['B']]);
                $err = $mod->checkVal('B'.$index, $row['B']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                } else {
                    $bArr = Import::readExcelColsToArr($file, 'B'. ImportKhoNhom::START_ROW .':B'.($index-1));
                    if(!empty($bArr)){
                        $bArrSimple = Import::convertColsToSimpleArr($bArr);
                        if(in_array($row['B'], $bArrSimple)){
                            array_push($errorByRow, 'B'.$index . ' đã tồn tại!');
                        }
                    }
                } */
                
                //check B <la cay nhom moi>, x or X or null
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = ['x', 'X'];
                $err = $mod->checkVal('B'.$index, $row['B']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                } 
                
                //check C, <ma_cay_nhom> not null
                $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('C'.$index, $row['C']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check D <he_nhom>, check exist in db and not null
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = false;
                $mod->modelExist = HeNhom::find()->where(['ten_he_nhom'=>$row['D']]);
                $err = $mod->checkVal('D'.$index, $row['D']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check E, <ten_cay_nhom> not null
                $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('E'.$index, $row['E']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check F, <chieu_dai> >= 0
               $mod = new CheckFile();
               $mod->isGreaterThan = 0;
               $err = $mod->checkVal('F'.$index, $row['F']);
               if(!empty($err)){
                   array_push($errorByRow, $err);
               }
               
               //check G <khoi_luong> >= 0
               $mod = new CheckFile();
               $mod->isGreaterThan = 0;
               $err = $mod->checkVal('G'.$index, $row['G']);
               if(!empty($err)){
                   array_push($errorByRow, $err);
               }
               
               //check H, <ton_kho> >= 0
               $mod = new CheckFile();
               $mod->isGreaterThan = 0;
               $err = $mod->checkVal('H'.$index, $row['H']);
               if(!empty($err)){
                   array_push($errorByRow, $err);
               }
                
                //check J <don_gia> is not null
                $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('J'.$index, $row['J']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check K <dung_cho_cua_so>, x or X or null
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = ['x', 'X'];
                $err = $mod->checkVal('K'.$index, $row['K']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                } 
                //check L <dung_cho_cua_di>, x or X or null
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = ['x', 'X'];
                $err = $mod->checkVal('L'.$index, $row['L']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                } 
                
                //check M <chieu_dai_toi_thieu_cat>, >= 0
                $mod = new CheckFile();
                $mod->allowNull = false;
                $mod->isGreaterThan = 0;
                $err = $mod->checkVal('M'.$index, $row['M']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check D = 0,1,2,3 or null
                /* $mod = new CheckFile();
                 $mod->isCompare = true;
                 $mod->valueCompare = [0, 1, 2, 3];
                 $err = $mod->checkVal('D'.$index, $row['D']);
                 if(!empty($err)){
                 array_push($errorByRow, $err);
                 }   */
                
                //check E = x or X or null
                /* $mod = new CheckFile();
                 $mod->isCompare = true;
                 $mod->valueCompare = ['x', 'X'];
                 $err = $mod->checkVal('E'.$index, $row['E']);
                 if(!empty($err)){
                 array_push($errorByRow, $err);
                 } */
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
    public static function importFile($file, $isOverwrite=false){
        $excel = Import::readExcel($file);
        $sheet = $excel->getActiveSheet();
        $xls_data = Import::readExcelToArr($file);
        $errorByRow = array();
        $successCount = 0;
        $errorCount = 0;
        $errors = array();
        /* return [
            'success'=>'',
            'error'=>'',
            'errorArr'=>'',
            'errors'=>$isOverwrite
        ]; */
        
        foreach ($xls_data as $index=>$row){
            if($index>=ImportKhoNhom::START_ROW){
                //check cay nhom co chua
                //co thi lay id cay nhom
                //khong co thi them moi cay nhom va lay id
                $cayNhom = CayNhom::findOne(['code'=>$row['C']]);
                if($cayNhom == null){
                    if($row['B'] == 'x' || $row['B']=='X'){
                        //xu ly khi la cay nhom chinh
                        $cayNhom = new CayNhom();
                        $heNhom = HeNhom::findOne(['ten_he_nhom'=>$row['D']]);
                        if($heNhom !=null){
                            $cayNhom->id_he_nhom = $heNhom->id;
                        } else {
                            //xu ly, đã bắt lỗi khi check file rồi
                        }                        
                        $cayNhom->code = $row['C'];
                        $cayNhom->ten_cay_nhom = $row['E'];
                        $cayNhom->so_luong = $sheet->getCell('H'.$index)->getValue();
                        $cayNhom->don_gia = $sheet->getCell('J'.$index)->getValue();
                        $cayNhom->khoi_luong = $sheet->getCell('G'.$index)->getValue();
                        $cayNhom->chieu_dai = $sheet->getCell('F'.$index)->getValue();
                        if($row['K'] == 'x' || $row['K']=='X'){
                            $cayNhom->for_cua_so = 1;
                        }
                        if($row['L'] == 'x' || $row['L']=='X'){
                            $cayNhom->for_cua_di = 1;
                        }
                        $cayNhom->min_allow_cut = $sheet->getCell('M'.$index)->getValue();
                        if($cayNhom->save()){
                            $successCount++;
                        } else {
                            $errorCount++;
                            $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                            $errors[] = $cayNhom->errors;
                        }
                        //sau khi them cay nhom thi aftersave se them ton kho cay nhom moi
                        
                    } else {
                        //xu ly khi KHONG la cay nhom chinh
                        $errorCount++;
                        $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi! - mã cây nhôm không tồn tại';
                        /* tiep tuc xu ly check trong file check de tranh trương hop nay ............. */
                    }
                } else { // co cay nhom roi
                    if($row['B'] == 'x' || $row['B']=='X'){
                        //xu ly khi la cay nhom chinh
                        if($sheet->getCell('F'.$index)->getValue() == $cayNhom->chieu_dai){
                            $khoNhom = KhoNhom::findOne([
                                'id_cay_nhom'=>$cayNhom->id,
                                'chieu_dai'=>$cayNhom->chieu_dai
                            ]);
                            $khoNhomOld = KhoNhom::findOne([
                                'id_cay_nhom'=>$cayNhom->id,
                                'chieu_dai'=>$cayNhom->chieu_dai
                            ]);
                            if($khoNhom ==null){
                                //ko co thi cu them moi la xong
                                $khoNhom = new KhoNhom();
                                $khoNhom->id_cay_nhom = $cayNhom->id;
                                $khoNhom->chieu_dai = $cayNhom->chieu_dai;
                                $khoNhom->so_luong = $sheet->getCell('H'.$index)->getValue();
                                if($khoNhom->save()){
                                    $successCount++;
                                } else {
                                    $errorCount++;
                                    $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                                    $errors[] = $khoNhom->errors;
                                }
                                /* tiep theo xu ly luu lich su, xem chinh sưa phần add tồn kho cây nhôm lại cho hợp lý */
                            }else {
                                //co roi thi xy ly
                                //neu ko co overwrite thì cộng số lượng vô
                                if($isOverwrite ==false){
                                    //add so luong vao ton kho
                                    $khoNhom->so_luong = $khoNhom->so_luong + $sheet->getCell('H'.$index)->getValue();
                                    if($khoNhom->save()){
                                        
                                        $successCount++;
                                        
                                        if($khoNhom->so_luong != $khoNhomOld->so_luong){
                                            $history = new KhoNhomLichSu();
                                            $history->id_kho_nhom = $khoNhom->id;
                                            $history->so_luong = $sheet->getCell('H'.$index)->getValue();
                                            $history->so_luong_cu = $khoNhomOld->so_luong;
                                            $history->so_luong_moi = $khoNhom->so_luong;
                                            $history->noi_dung = 'Cập nhật tồn kho do cập nhật dữ liệu kho nhôm #'.$khoNhom->cayNhom->code . ' (' . $khoNhom->chieu_dai . ') từ file exel';
                                            $history->save();
                                        }
                                    }
                                    
                                } else {
                                    //set lại tồn kho
                                    $khoNhom->so_luong = $sheet->getCell('H'.$index)->getValue();
                                    if($khoNhom->save()){
                                        
                                        $successCount++;
                                        
                                        if($khoNhom->so_luong != $khoNhomOld->so_luong){
                                            $history = new KhoNhomLichSu();
                                            $history->id_kho_nhom = $khoNhom->id;
                                            $history->so_luong = $khoNhomOld->so_luong - $sheet->getCell('H'.$index)->getValue();
                                            $history->so_luong_cu = $khoNhomOld->so_luong;
                                            $history->so_luong_moi = $khoNhom->so_luong;
                                            $history->noi_dung = 'Cập nhật tồn kho do cập nhật đè dữ liệu kho nhôm #'.$khoNhom->cayNhom->code . ' (' . $khoNhom->chieu_dai . ') từ file excel';
                                            $history->save();
                                        }
                                    }
                                }//end if $isOverwrite
                            }
                        } else {
                            $errorCount++;
                            $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi! Chiều dài cây nhôm không khớp với dữ liệu tồn kho!';
                            $errors[] = [];
                        }
                        //neu option overwrite thì ghi đè lại số lượng (khong can de so luong cay nhom, chi de so luong kho nhom thoi)
                        //neu ko co overwrite thì cộng số lượng vô
                    } else {
                        //xu ly khi la cay nhom ton kho
                        //neu option overwrite thì ghi đè lại số lượng
                        $khoNhom = KhoNhom::findOne([
                            'id_cay_nhom'=>$cayNhom->id,
                            'chieu_dai'=>$sheet->getCell('F'.$index)->getValue()
                        ]);
                        $khoNhomOld = KhoNhom::findOne([
                            'id_cay_nhom'=>$cayNhom->id,
                            'chieu_dai'=>$sheet->getCell('F'.$index)->getValue()
                        ]);
                        if($khoNhom ==null){
                            //ko co thi cu them moi la xong
                            $khoNhom = new KhoNhom();
                            $khoNhom->id_cay_nhom = $cayNhom->id;
                            $khoNhom->chieu_dai = $sheet->getCell('F'.$index)->getValue();
                            $khoNhom->so_luong = $sheet->getCell('H'.$index)->getValue();
                            if($khoNhom->save()){
                                $successCount++;
                            } else {
                                $errorCount++;
                                $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                                $errors[] = $khoNhom->errors;
                            }
                            /* tiep theo xu ly luu lich su, xem chinh sưa phần add tồn kho cây nhôm lại cho hợp lý */
                        } else {
                            //co roi thi xy ly
                            //neu ko co overwrite thì cộng số lượng vô
                            if($isOverwrite ==false){
                                //add so luong vao ton kho
                                $khoNhom->so_luong = $khoNhom->so_luong + $sheet->getCell('H'.$index)->getValue();
                                if($khoNhom->save()){
                                    
                                    $successCount++;
                                    
                                    if($khoNhom->so_luong != $khoNhomOld->so_luong){
                                        $history = new KhoNhomLichSu();
                                        $history->id_kho_nhom = $khoNhom->id;
                                        $history->so_luong = $sheet->getCell('H'.$index)->getValue();
                                        $history->so_luong_cu = $khoNhomOld->so_luong;
                                        $history->so_luong_moi = $khoNhom->so_luong;
                                        $history->noi_dung = 'Cập nhật tồn kho do cập nhật dữ liệu kho nhôm #'.$khoNhom->cayNhom->code . ' (' . $khoNhom->chieu_dai . ') từ file exel';
                                        $history->save();
                                    }
                                }
                                
                            } else {
                                //set lại tồn kho
                                $khoNhom->so_luong = $sheet->getCell('H'.$index)->getValue();
                                if($khoNhom->save()){
                                    
                                    $successCount++;
                                    
                                    if($khoNhom->so_luong != $khoNhomOld->so_luong){
                                        $history = new KhoNhomLichSu();
                                        $history->id_kho_nhom = $khoNhom->id;
                                        $history->so_luong = $khoNhomOld->so_luong - $sheet->getCell('H'.$index)->getValue();
                                        $history->so_luong_cu = $khoNhomOld->so_luong;
                                        $history->so_luong_moi = $khoNhom->so_luong;
                                        $history->noi_dung = 'Cập nhật tồn kho do cập nhật đè dữ liệu kho nhôm #'.$khoNhom->cayNhom->code . ' (' . $khoNhom->chieu_dai . ') từ file excel';
                                        $history->save();
                                    }
                                }
                            }//end if $isOverwrite
                        }
                        
                    }
                    // da toi day ***************************** tiep tuc xu ly return error count!!!!!!!!!!!!!!
                }
                
                
                
                
                
                /* $model = new KhoVatTu();
                $model->code = $row['B'];
                $model->ten_vat_tu = $row['C'];
                $model->id_nhom_vat_tu = 1; //1 is phu kien
                $model->la_phu_kien = 1;
                $model->thuong_hieu = $row['D'];
                $model->model = $row['E'];
                $model->xuat_xu = 1; //1 is khong biet
                if($row['F'] != null){
                    $ncc = NhaCungCap::findOne(['code'=>$row['F']]);
                    if($ncc != null){
                        $model->nha_cung_cap = $ncc->id;
                    }
                }
                //$model->so_luong = (int)$row['G'];
                $model->so_luong = $sheet->getCell('G'.$index)->getValue();
                if($row['H'] == null){
                    $model->dvt = 1;//1 is chưa phân loại
                } else {
                    $donViTinh = DonViTinh::find()->where(['ten_dvt'=>$row['H']])->one();
                    if($donViTinh!=null){
                        $model->dvt = $donViTinh->id;
                    } else {
                        $dvtModel = new DonViTinh();
                        $dvtModel->ten_dvt = $row['H'];
                        $dvtModel->save();
                        $model->dvt = $dvtModel->id;
                    }
                }
                //$model->don_gia = $xls_data[$row]['I'];
                $model->don_gia = $sheet->getCell('I'.$index)->getValue();
                $model->ghi_chu = $row['J']; */
                
                
                /* if($model->save()){
                    $successCount++;
                } else {
                    $errorCount++;
                    $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                    $errors[] = $model->errors;
                } */
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