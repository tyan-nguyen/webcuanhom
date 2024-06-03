<?php

namespace app\modules\maucua\models;

use app\modules\dungchung\models\CheckFile;
use app\modules\dungchung\models\HinhAnh;
use app\modules\kho\models\HeVach;
use app\modules\kho\models\KhoVatTu;
use app\modules\kho\models\DonViTinh;

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
        //$xls_data = Import::readExcelToArr($file);
        $spreadsheet = Import::readExcel($file);
        $sheetCount = $spreadsheet->getSheetCount();
        for ($i = 0; $i < $sheetCount; $i++) {
            $sheet = $spreadsheet->getSheet($i);
            $xls_data = $sheet->toArray(null, true, true, true);
        
            $errorByRow = array();
            $successCount = 0;
            $errorCount = 0;
        
            $arrr = array();//luu dong co chu STT, se tra ve $arrr($rowNhom, $rowKinh, $rowPhuKien, $rowVatTu)
            foreach ($xls_data as $index=>$row){
                if($row['A'] == 'STT'){
                    array_push($arrr, $index);
                }
            }
            if(count($arrr) != 4){
                $errorByRow['maucua'] = 'Định dạng file không đúng!';
                return [
                    'success'=>0,
                    'error'=>1,
                    'errorArr'=>$errorByRow,
                ];
            }
            
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
            $xls_images = Import::readImageArr($file, $i); //$i is index of sheet
            foreach ($xls_images as $index=>$img){
                $hinhAnhModel = new HinhAnh();
                $hinhAnhModel->id_tham_chieu = $model->id;
                $hinhAnhModel->loai = 'mau-cua';
                $hinhAnhModel->duong_dan = $img['fileName'];
                $hinhAnhModel->ten_file_luu = $img['fileName'];
                $hinhAnhModel->img_extension = $img['ext'];
                $hinhAnhModel->save();
            }
            
            /*save data*/
            foreach ($xls_data as $index=>$row){
                /**
                 * them cua-nhom
                 */
                $startRow = $arrr[0] + 1;
                $endRow = $arrr[1] - 3;
                if($index>=$startRow && $index<=$endRow){
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
                /**
                 * them cua-vach
                 */
                $startRow = $arrr[1] + 1;
                $endRow = $arrr[2] - 3;
                if($index>=$startRow && $index<=$endRow){
                    $kinhCua = new MauCuaVach();
                    $kinhCua->id_mau_cua = $model->id;
                    
                    //check kinh
                    $kinhModel = HeVach::findOne(['code'=>$row['B']]);
                    if($kinhModel==null){
                        $kinhModel = new HeVach();
                        $kinhModel->code = $row['B'];//**
                        $kinhModel->ten_he_vach = $row['C'];
                        $kinhModel->ghi_chu = 'Thêm từ import file #mau ' . $model->code;
                        $kinhModel->save();//**
                    }
                    
                    $kinhCua->id_vach = $kinhModel->id;
                    $kinhCua->rong = $row['F'];
                    $kinhCua->cao = $row['G'];
                    $kinhCua->so_luong = $row['H'];
                    $kinhCua->dien_tich = $row['I'];
                    $kinhCua->don_gia = 0;
                    $kinhCua->so_luong_xuat = 0;
                    $kinhCua->ghi_chu_xuat = '';
                    $kinhCua->so_luong_nhap_lai = 0;
                    $kinhCua->ghi_chu_nhap_lai = '';
                    $kinhCua->save();//**
                    
                }
                /**
                 * them cua-phukien
                 */
                $startRow = $arrr[2] + 1;
                $endRow = $arrr[3] - 2;
                if($index>=$startRow && $index<=$endRow){
                    $phuKienCua = new MauCuaVatTu();
                    $phuKienCua->id_mau_cua = $model->id;
                    
                    //check vat tu
                    if($row['H']==null){
                        //neu khong co ma vat tu thi kiem tra theo don_vi_tinh va ten_vat_tu
                        $dvtModel = DonViTinh::findOne(['ten_dvt'=>$row['G']]);
                        if($dvtModel==null){
                            $dvtModel = new DonViTinh();
                            $dvtModel->ten_dvt = $row['G'];
                            $dvtModel->save();//**
                        }
                        $phuKienModel = KhoVatTu::findOne([
                            'ten_vat_tu'=>$row['C'],
                            'dvt'=>$dvtModel->id
                        ]);
                        if($phuKienModel==null){
                            $phuKienModel = new KhoVatTu();
                            $phuKienModel->ten_vat_tu = $row['C'];
                            $phuKienModel->id_nhom_vat_tu = 1;//1 la phu kien, xem KhoVatBase.
                            $phuKienModel->la_phu_kien = 1;
                            //$phuKienModel->so_luong = $row['I'];
                            $phuKienModel->so_luong = 0;
                            $phuKienModel->dvt = $dvtModel->id;
                            $phuKienModel->don_gia = 0;
                            $phuKienModel->save(); //**
                        }
                    } else {
                        //neu co ma vat tu thi kiem tra theo ma_vat_tu
                        $phuKienModel = KhoVatTu::findOne(['code'=>$row['H']]);
                        if($phuKienModel==null){
                            $phuKienModel = new KhoVatTu();
                            $phuKienModel->code = $row['H'];//****this line different from below condition.
                            $phuKienModel->ten_vat_tu = $row['C'];
                            $phuKienModel->id_nhom_vat_tu = 1;//1 la phu kien, xem KhoVatBase.
                            $phuKienModel->la_phu_kien = 1;
                            //$phuKienModel->so_luong = $row['I'];
                            $phuKienModel->so_luong = 0;
                            $phuKienModel->dvt = $dvtModel->id;
                            $phuKienModel->don_gia = 0;
                            $phuKienModel->save(); //**
                        }
                    }
                    //continue code for $phuKienCua
                    $phuKienCua->id_kho_vat_tu = $phuKienModel->id;
                    $phuKienCua->so_luong = $row['I'];
                    $phuKienCua->dvt = $row['G'];
                    $phuKienCua->don_gia = $phuKienModel->don_gia;//**
                    $phuKienCua->la_phu_kien = 1;
                    $phuKienCua->so_luong_xuat = $row['I'];//**
                    $phuKienCua->ghi_chu_xuat = '';
                    $phuKienCua->so_luong_nhap_lai = 0;
                    $phuKienCua->ghi_chu_nhap_lai = '';
                    $phuKienCua->save();//**
                }
                /**
                 * them cua-vat tu
                 */
                $startRow = $arrr[3] + 1;
                if($index>=$startRow){
                    $phuKienCua = new MauCuaVatTu();
                    $phuKienCua->id_mau_cua = $model->id;
                    
                    //check vat tu
                    if($row['H']==null){
                        $dvtModel = DonViTinh::findOne(['ten_dvt'=>$row['G']]);
                        if($dvtModel==null){
                            $dvtModel = new DonViTinh();
                            $dvtModel->ten_dvt = $row['G'];
                            $dvtModel->save();//**
                        }
                        $phuKienModel = KhoVatTu::findOne([
                            'ten_vat_tu'=>$row['C'],
                            'dvt'=>$dvtModel->id
                        ]);
                        if($phuKienModel==null){
                            $phuKienModel = new KhoVatTu();
                            $phuKienModel->ten_vat_tu = $row['C'];
                            $phuKienModel->id_nhom_vat_tu = 2;//2 la vat tu, xem KhoVatBase.
                            $phuKienModel->la_phu_kien = 0;
                            //$phuKienModel->so_luong = $row['I'];
                            $phuKienModel->so_luong = 0;
                            $phuKienModel->dvt = $dvtModel->id;
                            $phuKienModel->don_gia = 0;
                            $phuKienModel->save(); //**
                        }
                    } else {
                        $phuKienModel = KhoVatTu::findOne(['code'=>$row['H']]);
                        if($phuKienModel==null){
                            $phuKienModel = new KhoVatTu();
                            $phuKienModel->code = $row['H'];//****this line different from below condition.
                            $phuKienModel->ten_vat_tu = $row['C'];
                            $phuKienModel->id_nhom_vat_tu = 2;//2 la vat tu, xem KhoVatBase.
                            $phuKienModel->la_phu_kien = 0;
                            //$phuKienModel->so_luong = $row['I'];
                            $phuKienModel->so_luong = 0;
                            $phuKienModel->dvt = $dvtModel->id;
                            $phuKienModel->don_gia = 0;
                            $phuKienModel->save(); //**
                        }
                    }
                    //continue code for $phuKienCua
                    $phuKienCua->id_kho_vat_tu = $phuKienModel->id;
                    $phuKienCua->so_luong = $row['I'];
                    $phuKienCua->dvt = $row['G'];
                    $phuKienCua->don_gia = $phuKienModel->don_gia;//**
                    $phuKienCua->la_phu_kien = 0;//** this is important diffrent for phuKien
                    $phuKienCua->so_luong_xuat = $row['I'];//**
                    $phuKienCua->ghi_chu_xuat = '';
                    $phuKienCua->so_luong_nhap_lai = 0;
                    $phuKienCua->ghi_chu_nhap_lai = '';
                    $phuKienCua->save();//**
                }
            }//end foreach $xls_data
        
        }

        return [
            'success'=>$successCount,
            'error'=>$errorCount,
            'errorArr'=>$errorByRow,
        ];
    }
}