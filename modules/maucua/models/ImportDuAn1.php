<?php

namespace app\modules\maucua\models;

use app\modules\dungchung\models\CheckFile;
use app\modules\dungchung\models\Import;
use app\modules\dungchung\models\HinhAnh;

class ImportDuAn1
{    
    CONST START_ROW = 3;
    CONST START_COL = 'B';
    
    /**
     * kiem tra file upload
     * @param string $type
     * @param string $file : filename
     * @return array[]
     */
    public static function checkFile($model, $type, $file){
        $xls_data = Import::readExcelToArr($file);
        
        $errors = array();
        $errorByRow = array();
        
        foreach ($xls_data as $index=>$row){
            $errorByRow = array();
            if($index>=ImportDuAn1::START_ROW){
                
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
    public static function importFile($duAnModel, $file){
        $xls_data = Import::readExcelToArr($file);
        $errorByRow = array();
        $successCount = 0;
        $errorCount = 0;
        
        /*************/
        /* thêm mẫu cửa */
        $model = new MauCua();
        $model->ten_cua = $xls_data[7]['A'];//
        $model->kich_thuoc = $xls_data[9]['A'];//
        
        //get id he nhom
        //tìm xem đã có hệ nhôm này chưa
        $heNhomModel = HeNhom::findOne(['ten_he_nhom'=>$xls_data[13]['A']]);
        if($heNhomModel == null){
            //nếu chưa có thì thêm trước sau đó lấy id gán cho id he nhom
            //1.thêm mới hệ nhôm
            $heNhomModel = new HeNhom();
            $heNhomModel->ten_he_nhom = $xls_data[13]['A'];
            $heNhomModel->save();
        }
        //nếu có thì gán id cho id he nhom
        //**make sure $heNhomModel is exist
        $model->id_he_nhom = $heNhomModel->id;
        
        //get id loai cua
        //tim xem da co loai cua nay chua
        $loaiCuaModel = LoaiCua::findOne(['ten_loai_cua'=>$xls_data[7]['A']]);
        //neu chua thi them moi loai cua
        if($loaiCuaModel == null){
            //them moi loai cua
            $loaiCuaModel = new LoaiCua();
            $loaiCuaModel->ten_loai_cua = $xls_data[7]['A'];
            $loaiCuaModel->save();
        }
        
        //gan id loai cua
        $model->id_loai_cua = $loaiCuaModel->id;//
        
        $model->id_du_an = $duAnModel->id;
        $model->so_luong = str_replace(' BỘ', '', $xls_data[11]['A']);
        
        //save model
        if($model->save()){
            $successCount++;
        } else {
            $errorCount++;
            $errorByRow['maucua'] = 'Thông tin mẫu cửa lỗi (Dòng A7, A9, A11, A13)';
            $errorByRow['maucua1'] = print_r($model->errors);
        }
        
        /* $chiTietModel = new DuAnChiTiet();
        $chiTietModel->id_du_an = $duAnModel->id;
        $chiTietModel->id_mau_cua = $model->id;
        $chiTietModel->so_luong = str_replace(' BỘ', '', $xls_data[11]['A']);
        $chiTietModel->save(); */
        
        
        /*save image*/
        $xls_images = Import::readImageArr($file);
        foreach ($xls_images as $index=>$img){
            $hinhAnhModel = new HinhAnh();
            $hinhAnhModel->id_tham_chieu = $model->id;
            $hinhAnhModel->loai = 'mau-cua';
            $hinhAnhModel->duong_dan = $img['fileName'];
            $hinhAnhModel->ten_file_luu = $img['fileName'];
            $hinhAnhModel->img_extension = $img['ext'];
            $hinhAnhModel->save();
        }
        
        
        foreach ($xls_data as $index=>$row){
            /**
             * them cua-nhom
             */
            if($index>=18 && $index<=28){
                $nhomCua = new MauCuaNhom();
                $nhomCua->id_mau_cua = $model->id;
                
                //check cay nhom
                $cayNhomModel = CayNhom::findOne(['code'=>$row['B']]);
                if($cayNhomModel == null){
                    $cayNhomModel = new CayNhom();
                    $cayNhomModel->id_he_nhom = $model->id_he_nhom;
                    $cayNhomModel->code = $row['B'];
                    $cayNhomModel->ten_cay_nhom = $row['C'];
                    //other***
                    $cayNhomModel->save();
                }
                
                $nhomCua->id_cay_nhom = $cayNhomModel->id;
                $nhomCua->chieu_dai = $row['F'];
                $nhomCua->so_luong = $row['H'];
                $nhomCua->kieu_cat = $row['G'];
                $nhomCua->khoi_luong = $row['I'];
                $nhomCua->don_gia = 0;
                $nhomCua->save();
            }
        }
        
        
        /* foreach ($xls_data as $index=>$row){
            
            if($index>=ImportDuAn1::START_ROW){
                $model = new MauCua();
                //$model->code = ;
                $model->ten_cua = $row['B'];
                
                
                
                $model->ma_bo_phan = $row['B'];
                $model->ten_bo_phan = $row['C'];
                if($row['E']!=NULL){
                    $model->truc_thuoc = BoPhan::findOne(['ma_bo_phan'=>$row['E']])->id;
                }
                $model->la_dv_quan_ly = strtolower($row['F'])=='x'?1:0;
                $model->la_dv_su_dung = strtolower($row['G'])=='x'?1:0;
                $model->la_dv_bao_tri = strtolower($row['H'])=='x'?1:0;
                $model->la_dv_van_tai = strtolower($row['I'])=='x'?1:0;
                $model->la_dv_mua_hang = strtolower($row['J'])=='x'?1:0;
                $model->la_dv_quan_ly_kho = strtolower($row['K'])=='x'?1:0;
                $model->la_trung_tam_chi_phi = strtolower($row['L'])=='x'?1:0;
                
                
                
                
                if($model->save()){
                    $successCount++;
                } else {
                    $errorCount++;
                    $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi!';
                }
            }
        } */
        
        
        
        
        
        return [
            'success'=>$successCount,
            'error'=>$errorCount,
            'errorArr'=>$errorByRow,
        ];
    }
}