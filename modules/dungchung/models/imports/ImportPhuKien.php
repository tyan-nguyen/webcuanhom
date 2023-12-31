<?php

namespace app\modules\dungchung\models\imports;

use app\modules\dungchung\models\CheckFile;
use app\modules\dungchung\models\Import;
use app\modules\kho\models\PhuKien;
use app\modules\kho\models\DonViTinh;
use app\modules\kho\models\KhoVatTu;
use app\modules\kho\models\NhaCungCap;
use app\modules\kho\models\KhoVatTuLichSu;

class ImportPhuKien
{    
    CONST START_ROW = 3;
    CONST START_COL = 'B';
    
    /**
     * kiem tra file upload
     * @param string $type
     * @param string $file : filename
     * @return array[]
     */
    public static function checkFile($type, $file, $isOverwrite=false){
        $xls_data = Import::readExcelToArr($file);
        
        $errors = array();
        $errorByRow = array();
        
        foreach ($xls_data as $index=>$row){
            $errorByRow = array();
            if($index>=ImportPhuKien::START_ROW){
                //check B (code) duplicate
                if($isOverwrite == false){
                    $mod = new CheckFile();
                    $mod->isDuplicate = true;
                    $mod->modelDuplicate = PhuKien::find()->where(['code'=>$row['B']]);
                    $err = $mod->checkVal('B'.$index, $row['B']);
                    if(!empty($err)){
                        array_push($errorByRow, $err);
                    } else {
                        $bArr = Import::readExcelColsToArr($file, 'B'. ImportPhuKien::START_ROW .':B'.($index-1));
                        if(!empty($bArr)){
                            $bArrSimple = Import::convertColsToSimpleArr($bArr);
                            if(in_array($row['B'], $bArrSimple)){
                                array_push($errorByRow, 'B'.$index . ' đã tồn tại!');
                            }
                        }               
                    }
                } else {
                    //null thì sinh code
                }
                
                //check C
                $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('C'.$index, $row['C']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check F <nha_cung_cap> exist if not null
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = true;
                $mod->modelExist = NhaCungCap::find()->where(['code'=>$row['F']]);
                $err = $mod->checkVal('F'.$index, $row['F']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check I <don_gia> is not null
                $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('I'.$index, $row['I']);
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
        foreach ($xls_data as $index=>$row){
            if($index>=ImportPhuKien::START_ROW){
                if($isOverwrite == true){
                    $model = KhoVatTu::findOne(['code'=>$row['B']]);
                    $oldModel = KhoVatTu::findOne(['code'=>$row['B']]);
                    if($model != null && $row['B'] != null){
                        //y chang ở dưới khác không tạo mới và sinh lịch sử bằng tay
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
                        $model->ghi_chu = $row['J'];
                        if($model->save()){
                            $successCount++;
                            if($model->so_luong != $oldModel->so_luong){
                                $lichSuTonKho = new KhoVatTuLichSu();
                                $lichSuTonKho->id_kho_vat_tu = $model->id;
                                $lichSuTonKho->id_nha_cung_cap = $model->nha_cung_cap; //1 la chua phan loai, khong duoc xoa danh muc id 1
                                $lichSuTonKho->ghi_chu = 'Ghi đè tồn kho khi nhập excel';
                                $lichSuTonKho->so_luong = $model->so_luong - $oldModel->so_luong;
                                $lichSuTonKho->so_luong_cu = $oldModel->so_luong;
                                $lichSuTonKho->so_luong_moi = $model->so_luong;
                                $lichSuTonKho->id_mau_cua = null;//*********
                                $lichSuTonKho->save();
                            }
                        } else {
                            $errorCount++;
                            $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                            $errors[] = $model->errors;
                        }
                        
                    } else {
                        //y chang ở dưới
                        $model = new KhoVatTu();
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
                        $model->ghi_chu = $row['J'];
                        if($model->save()){
                            $successCount++;
                        } else {
                            $errorCount++;
                            $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                            $errors[] = $model->errors;
                        }
                    }
                }else {
                    $model = new KhoVatTu();
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
                    $model->ghi_chu = $row['J'];
                    if($model->save()){
                        $successCount++;
                    } else {
                        $errorCount++;
                        $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                        $errors[] = $model->errors;
                    }
                }
                //
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