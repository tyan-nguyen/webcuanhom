<?php

namespace app\modules\dungchung\models\imports;

use app\modules\dungchung\models\CheckFile;
use app\modules\dungchung\models\Import;
use app\modules\kho\models\PhuKien;
use app\modules\kho\models\DonViTinh;
use app\modules\kho\models\KhoVatTu;
use app\modules\kho\models\NhaCungCap;
use app\modules\kho\models\KhoVatTuLichSu;
use app\modules\kho\models\VatTu;
use app\modules\maucua\models\HeMau;

class ImportVatTu
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
            if($index>=ImportVatTu::START_ROW){
                //check B (code) duplicate
                if($isOverwrite == false){
                    $mod = new CheckFile();
                    $mod->isDuplicate = true;
                    $mod->modelDuplicate = VatTu::find()->where(['code'=>$row['B']]);
                    $err = $mod->checkVal('B'.$index, $row['B']);
                    if(!empty($err)){
                        array_push($errorByRow, $err);
                    } else {
                        $bArr = Import::readExcelColsToArr($file, 'B'. ImportVatTu::START_ROW .':B'.($index-1));
                        if(!empty($bArr)){
                            $bArrSimple = Import::convertColsToSimpleArr($bArr);
                            if(in_array($row['B'], $bArrSimple)){
                                array_push($errorByRow, 'B'.$index . ' đã tồn tại!');
                            }
                        }               
                    }
                }else {
                    //cho null thi tu sinh code
                }
                
                //check C code hệ màu, hệ màu phải tồn tại
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = true;
                $mod->modelExist = HeMau::find()->where(['code'=>$row['C'], 'for_phu_kien'=>1]);
                $err = $mod->checkVal('C'.$index, $row['C']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check D
                $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('D'.$index, $row['D']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check F <nha_cung_cap> exist if not null
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = true;
                $mod->modelExist = NhaCungCap::find()->where(['code'=>$row['G']]);
                $err = $mod->checkVal('G'.$index, $row['G']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check I <don_gia> is not null
                $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('J'.$index, $row['J']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check L <dvt quy doi> exist if not null
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = true;
                $mod->modelExist = DonViTinh::find()->where(['ten_dvt'=>$row['L']]);
                $err = $mod->checkVal('L'.$index, $row['L']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check D = 0,1,2,3 or null
                /* $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = [0, 1, 2, 3];
                $err = $mod->checkVal('E'.$index, $row['E']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }   */  
                
                //check E = x or X or null
                /* $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = ['x', 'X'];
                $err = $mod->checkVal('F'.$index, $row['F']);
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
            if($index>=ImportVatTu::START_ROW){
                if(isset($row['C']) && $row['C'] != NULL){
                    $heMau = HeMau::find()->where(['code'=>$row['C'], 'for_phu_kien'=>1])->one();//sure exist
                }
                if($isOverwrite == true){
                    $model = KhoVatTu::findOne(['code'=>$row['B']]);
                    $oldModel = KhoVatTu::findOne(['code'=>$row['B']]);
                    if($model != null && $row['B'] != null){
                        //y chang ở dưới khác sau aftersave
                        //$model->code = $row['B'];
                        $model->ten_vat_tu = $row['D'];
                        if(isset($row['C']) && $row['C'] != NULL){
                            $model->id_he_mau = $heMau->id;
                        }
                        $model->id_nhom_vat_tu = 2; //1 is vat tu
                        $model->la_phu_kien = 0;
                        $model->thuong_hieu = $row['E'];
                        $model->model = $row['F'];
                        $model->xuat_xu = 1; //1 is khong biet
                        if($row['G'] != null){
                            $ncc = NhaCungCap::findOne(['code'=>$row['G']]);
                            if($ncc != null){
                                $model->nha_cung_cap = $ncc->id;
                            }
                        }
                        //$model->so_luong = (int)$row['H'];
                        $model->so_luong = $sheet->getCell('H'.$index)->getValue();
                        if($row['I'] == null){
                            $model->dvt = 1;//1 is chưa phân loại
                        } else {
                            $donViTinh = DonViTinh::find()->where(['ten_dvt'=>$row['I']])->one();
                            if($donViTinh!=null){
                                $model->dvt = $donViTinh->id;
                            } else {
                                $dvtModel = new DonViTinh();
                                $dvtModel->ten_dvt = $row['I'];
                                $dvtModel->save();
                                $model->dvt = $dvtModel->id;
                            }
                        }
                        //$model->don_gia = $xls_data[$row]['J'];
                        $model->don_gia = $sheet->getCell('J'.$index)->getValue();
                        $model->ghi_chu = $row['K'];
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
                    }else {
                        //y chang else ở dưới
                        $model = new KhoVatTu();
                        $model->code = $row['B'];
                        $model->ten_vat_tu = $row['D'];
                        if(isset($row['C']) && $row['C'] != NULL){
                            $model->id_he_mau = $heMau->id;
                        }
                        $model->id_nhom_vat_tu = 2; //1 is vat tu
                        $model->la_phu_kien = 0;
                        $model->thuong_hieu = $row['E'];
                        $model->model = $row['F'];
                        $model->xuat_xu = 1; //1 is khong biet
                        if($row['G'] != null){
                            $ncc = NhaCungCap::findOne(['code'=>$row['G']]);
                            if($ncc != null){
                                $model->nha_cung_cap = $ncc->id;
                            }
                        }
                        //$model->so_luong = (int)$row['H'];
                        $model->so_luong = $sheet->getCell('H'.$index)->getValue();
                        if($row['I'] == null){
                            $model->dvt = 1;//1 is chưa phân loại
                        } else {
                            $donViTinh = DonViTinh::find()->where(['ten_dvt'=>$row['I']])->one();
                            if($donViTinh!=null){
                                $model->dvt = $donViTinh->id;
                            } else {
                                $dvtModel = new DonViTinh();
                                $dvtModel->ten_dvt = $row['I'];
                                $dvtModel->save();
                                $model->dvt = $dvtModel->id;
                            }
                        }
                        //$model->don_gia = $xls_data[$row]['J'];
                        $model->don_gia = $sheet->getCell('J'.$index)->getValue();
                        $model->ghi_chu = $row['K'];
                        if($model->save()){
                            $successCount++;
                        } else {
                            $errorCount++;
                            $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                            $errors[] = $model->errors;
                        }
                    }
                } else {
                    //tao moi luon vi da check kho cho trung khi kiem tra
                    $model = new KhoVatTu();
                    $model->code = $row['B'];
                    $model->ten_vat_tu = $row['D'];
                    if(isset($row['C']) && $row['C'] != NULL){
                        $model->id_he_mau = $heMau->id;
                    }
                    $model->id_nhom_vat_tu = 2; //1 is vat tu               
                    $model->la_phu_kien = 0;
                    $model->thuong_hieu = $row['E'];
                    $model->model = $row['F'];
                    $model->xuat_xu = 1; //1 is khong biet
                    if($row['G'] != null){
                        $ncc = NhaCungCap::findOne(['code'=>$row['G']]);
                        if($ncc != null){
                            $model->nha_cung_cap = $ncc->id;
                        }
                    }
                    //$model->so_luong = (int)$row['H'];
                    $model->so_luong = $sheet->getCell('H'.$index)->getValue();
                    if($row['I'] == null){
                        $model->dvt = 1;//1 is chưa phân loại
                    } else {
                        $donViTinh = DonViTinh::find()->where(['ten_dvt'=>$row['I']])->one();
                        if($donViTinh!=null){
                            $model->dvt = $donViTinh->id;
                        } else {
                            $dvtModel = new DonViTinh();
                            $dvtModel->ten_dvt = $row['I'];
                            $dvtModel->save();
                            $model->dvt = $dvtModel->id;
                        }
                    }
                    //$model->don_gia = $xls_data[$row]['J'];
                    $model->don_gia = $sheet->getCell('J'.$index)->getValue();
                    $model->ghi_chu = $row['K'];
                    if($model->save()){
                        $successCount++;
                    } else {
                        $errorCount++;
                        $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                        $errors[] = $model->errors;
                    }
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