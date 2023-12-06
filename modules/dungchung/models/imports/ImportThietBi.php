<?php

namespace app\modules\dungchung\models\imports;

use app\modules\bophan\models\BoPhan;
use app\modules\dungchung\models\CheckFile;
use app\modules\dungchung\models\Import;
use app\modules\taisan\models\ThietBi;
use app\modules\taisan\models\ViTri;
use app\modules\taisan\models\HeThong;
use app\modules\taisan\models\LoaiThietBi;
use app\modules\bophan\models\NhanVien;
use app\modules\bophan\models\DoiTac;
use app\modules\dungchung\models\CustomFunc;

class ImportThietBi
{    
    CONST START_ROW = 4;
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
            if($index>=ImportThietBi::START_ROW){
                
                //check B <ma_thiet_bi> is not null and not duplicate                
                $mod = new CheckFile();
                $mod->isDuplicate = true;
                $mod->allowNull = false;
                $mod->modelDuplicate = ThietBi::find()->where(['ma_thiet_bi'=>$row['B']]);
                $err = $mod->checkVal('B'.$index, $row['B']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                } else {
                    $bArr = Import::readExcelColsToArr($file, 'B'. ImportThietBi::START_ROW .':B'.($index-1));
                    if(!empty($bArr)){
                        $bArrSimple = Import::convertColsToSimpleArr($bArr);
                        if(in_array($row['B'], $bArrSimple)){
                            array_push($errorByRow, 'B'.$index . ' đã tồn tại!');
                        }
                    }               
                }
                
                //check C <id_vi_tri> exist if not null
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = true;
                $mod->modelExist = ViTri::find()->where(['ma_vi_tri'=>$row['C']]);
                $err = $mod->checkVal('C'.$index, $row['C']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check D <id_he_thong> exist if not null
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = true;
                $mod->modelExist = HeThong::find()->where(['ma_he_thong'=>$row['D']]);
                $err = $mod->checkVal('D'.$index, $row['D']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check E <id_loai_thiet_bi> exist if not null
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = false;
                $mod->modelExist = LoaiThietBi::find()->where(['ma_loai'=>$row['E']]);
                $err = $mod->checkVal('E'.$index, $row['E']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check F <id_bo_phan_quan_ly> exist if not null
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = false;
                $mod->modelExist = BoPhan::find()->where(['ma_bo_phan'=>$row['F']]);
                $err = $mod->checkVal('F'.$index, $row['F']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check G <ten_thiet_bi>, not null
                $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('G'.$index, $row['G']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check H = x or X
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = ['x', 'X'];
                $err = $mod->checkVal('H'.$index, $row['H']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                } 
                
                //check I <id_thiet_bi_cha>, exist in db or in list above, allow null.
                $doCheckI = true;
                if($row['I'] != null){
                    $iArr = Import::readExcelColsToArr($file, 'B'. ImportThietBi::START_ROW .':B'.($index-1));
                    if(!empty($iArr)){
                        $iArrSimple = Import::convertColsToSimpleArr($iArr);
                        if(in_array($row['I'], $iArrSimple)){
                            $doCheckI = false;
                        }
                    }
                }
                if($doCheckI == true){
                    $mod = new CheckFile();
                    $mod->isExist = true;
                    $mod->allowNull = true;
                    $mod->modelExist = ThietBi::find()->where(['ma_thiet_bi'=>$row['I']]);
                    $err = $mod->checkVal('I'.$index, $row['I']);
                    if(!empty($err)){
                        array_push($errorByRow, $err);
                    }
                }
                
                //check J <nam_san_xuat>
                //check K <serial>
                //check L <model>
                //check M <xuat_xu>
                //chek N <hang_bao_hanh>, exist in db and allow null
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = true;
                $mod->modelExist = DoiTac::find()->where(['ma_doi_tac'=>$row['N']]);
                $err = $mod->checkVal('N'.$index, $row['N']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check O <dac_tinh_ky_thuat>
                //check P <don_vi_bao_tri>, exist in db and allow null
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = true;
                $mod->modelExist = BoPhan::find()->where(['ma_bo_phan'=>$row['P']]);
                $err = $mod->checkVal('P'.$index, $row['P']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check Q <nguoi_quan_ly>, exist in db and allow null
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = false;
                $mod->modelExist = NhanVien::find()->where(['ma_nhan_vien'=>$row['Q']]);
                $err = $mod->checkVal('Q'.$index, $row['Q']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check R <ngay_mua>
                //check S <han_bao_hanh>
                //check T <ngay_dua_vao_su_dung>
                //chek U <trang_thai> IN (1,2,3,4)
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = [1, 2, 3, 4];
                $err = $mod->checkVal('U'.$index, $row['U']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                } 
                
                //check V <ngay_ngung_hoat_dong>
                //check W <ghi_chu>                
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
        $cus = new CustomFunc();
        foreach ($xls_data as $index=>$row){
            if($index>=ImportThietBi::START_ROW){
                $model = new ThietBi();
                //ma_thiet_bi row B
                $model->ma_thiet_bi = $row['B'];
                //id_vi_tri row C
                if($row['C']!=NULL){
                    $model->id_vi_tri = ViTri::findOne(['ma_vi_tri'=>$row['C']])->id;
                }
                //id_he_thong row D
                if($row['D']!=NULL){
                    $model->id_he_thong = HeThong::findOne(['ma_he_thong'=>$row['D']])->id;
                }
                //id_loai_thiet_bi row E
                if($row['E']!=NULL){
                    $model->id_loai_thiet_bi = LoaiThietBi::findOne(['ma_loai'=>$row['E']])->id;
                }
                //id_bo_phan_quan_ly row F
                if($row['F']!=NULL){
                    $model->id_bo_phan_quan_ly = BoPhan::findOne(['ma_bo_phan'=>$row['F']])->id;
                }
                //ten_thiet_bi row G
                $model->ten_thiet_bi = $row['G'];
                //id_thiet_bi_cha row H&I
                if(strtolower($row['H'])=='x' && $row['I']!=NULL){
                    $model->id_thiet_bi_cha = ThietBi::findOne(['ma_thiet_bi'=>$row['I']])!=null?ThietBi::findOne(['ma_thiet_bi'=>$row['I']])->id:'';
                }
                //nam_san_xuat row J
                $model->nam_san_xuat = $row['J'];
                //serial row K
                $model->serial = $row['K'];
                //model row L
                $model->model = $row['L'];
                //xuat_xu row M
                $model->xuat_xu = $row['M'];
                //id_hang_bao_hanh row N
                if($row['N']!=NULL){
                    $model->id_hang_bao_hanh = DoiTac::findOne(['ma_doi_tac'=>$row['N']])->id;
                }
                //dac_tinh_ky_thuat row O
                $model->dac_tinh_ky_thuat = $row['O'];
                //id_don_vi_bao_tri row P
                if($row['P']!=NULL){
                    $model->id_don_vi_bao_tri = BoPhan::findOne(['ma_bo_phan'=>$row['P']])->id;
                }
                //id_nguoi_quan_ly row Q
                if($row['Q']!=NULL){
                    $model->id_nguoi_quan_ly = NhanVien::findOne(['ma_nhan_vien'=>$row['Q']])->id;
                }
                //ngay_mua row R
                if($row['R'] != null)
                    $model->ngay_mua = $cus->convertDMYToYMD($row['R']);
                //han_bao_hanh row S
                if($row['S'] != null)
                    $model->han_bao_hanh = $cus->convertDMYToYMD($row['S']);
                //ngay_dua_vao_su_dung row T
                if($row['T'] != null)
                    $model->ngay_dua_vao_su_dung = $cus->convertDMYToYMD($row['T']);
                //trang_thai row U
                if($row['U'] != null){
                    $model->trang_thai = $row['U'];
                } else {
                    $model->trang_thai = ThietBi::STATUS_HOATDONG;
                }
                //ngay_ngung_hoat_dong row V
                if($row['V'] != null)
                    $model->ngay_ngung_hoat_dong = $cus->convertDMYToYMD($row['V']);
                //ghi_chu row W
                $model->ghi_chu = $row['W'];
                
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