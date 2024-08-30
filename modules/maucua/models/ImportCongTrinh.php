<?php

namespace app\modules\maucua\models;

use app\modules\dungchung\models\CheckFile;
use app\modules\dungchung\models\HinhAnh;
use app\modules\kho\models\HeVach;
use app\modules\kho\models\KhoVatTu;
use app\modules\kho\models\DonViTinh;

class ImportCongTrinh
{    
    CONST START_ROW = 3;
    CONST START_COL = 'B';
    
    /**
     * kiem tra file upload
     * @param string $type
     * @param string $file : filename
     * @return array[]
     */
    public static function checkFile_old($model, $type, $file){
        $xls_data = Import::readExcelToArr($file);
        
        $errors = array();
        $errorByRow = array();
        
        foreach ($xls_data as $index=>$row){
            $errorByRow = array();
            if($index>=ImportCongTrinh::START_ROW){
                //check mã nhôm ko được trống
                //check mã nhôm bổ sung phải tồn tại
                //check hệ nhôm có tồn tại và có độ dày mặc định chưa
            }
            if($errorByRow != null){
                //array_push($errors, $errorByRow);
                $errors[$index] = $errorByRow;
            }
        }        
        return $errors;
    }
    
    /**
     * kiem tra file upload
     * @param string $type
     * @param string $file : filename
     * @return array[]
     */
    public static function checkFile($model, $type, $file){
        //$xls_data = Import::readExcelToArr($file);
        $spreadsheet = Import::readExcel($file);
        $sheetCount = $spreadsheet->getSheetCount();
        
        $errors = array();
        $errorByRow = array();
        
        $errCount = 0;
        
        for ($i = 0; $i < $sheetCount; $i++) {
            $sheet = $spreadsheet->getSheet($i);
            $xls_data = $sheet->toArray(null, true, true, true);
            
            $errors[$sheet->getTitle()] = array();///******************
            $errorByRow = array();
            
            $arrr = array();//luu dong co chu STT, se tra ve $arrr($rowNhom, $rowKinh, $rowPhuKien, $rowVatTu)
            foreach ($xls_data as $index=>$row){
                if($row['A'] == 'STT'){
                    array_push($arrr, $index);
                }
            }
            //kiem ra dinh dang file
            if(count($arrr) != 4){
                $errCount++;//tang error len
                
                array_push($errorByRow, 'Định dạng file không đúng!');
                
                if($errorByRow != null){
                    //array_push($errors, $errorByRow);
                    $errors[$sheet->getTitle()][$index] = $errorByRow;
                }
                return $errors;
            }
            
            $heNhomModel = HeNhom::findOne(['ten_he_nhom'=>$xls_data[13]['A']]);
            if($heNhomModel == null){
                $errCount++;//tang error len
                array_push($errorByRow, 'Hệ nhôm ' . $xls_data[13]['A'] . ' không tồn tại!');
                $errors[$sheet->getTitle()][$index] = $errorByRow;
            } else {
                if($heNhomModel->code == null){
                    $errCount++;//tang error len
                    array_push($errorByRow, 'Hệ nhôm ' . $xls_data[13]['A'] . ' chưa được nhập mã hệ nhôm!');
                    $errors[$sheet->getTitle()][$index] = $errorByRow;
                }
                if($heNhomModel->do_day_mac_dinh == null || $heNhomModel->do_day_mac_dinh == 0){
                    $errCount++;//tang error len
                    array_push($errorByRow, 'Hệ nhôm ' . $xls_data[13]['A'] . ' chưa được nhập độ dày mặc định!');
                    $errors[$sheet->getTitle()][$index] = $errorByRow;
                }
                if($heNhomModel->mauNhoms == null){
                    $errCount++;//tang error len
                    array_push($errorByRow, 'Hệ nhôm ' . $xls_data[13]['A'] . ' chưa cấu hình màu nhôm!');
                    $errors[$sheet->getTitle()][$index] = $errorByRow;
                } else if($heNhomModel->mauMacDinh == null){
                    $errCount++;//tang error len
                    array_push($errorByRow, 'Hệ nhôm ' . $xls_data[13]['A'] . ' chưa cấu hình màu nhôm mặc định!');
                    $errors[$sheet->getTitle()][$index] = $errorByRow;
                }
            }
            
            //check nội dung dữ liệu
            foreach ($xls_data as $index=>$row){
                //****check data nhôm****
                $startRow = $arrr[0] + 1;
                $endRow = $arrr[1] - 3;
                $errorByRow = array();//important
                if($index>=$startRow && $index<=$endRow){
                    //*****check cột màu bổ sung thêm
                    if(isset($row['N']) && $row['N']){
                        $checkHeMau = HeMau::findOne(['code'=>$row['N']]);
                        if(!$checkHeMau){
                            $errCount++;//tang error len
                            array_push($errorByRow, 'Mã màu ' . $xls_data[$index]['N'] . ' không tìm thấy!');
                            $errors[$sheet->getTitle()][$index] = $errorByRow;
                        } else {
                            //check hệ nhôm có màu này ko
                            if($heNhomModel!=null && $heNhomModel->mauNhoms!=null){
                                $checkHeNhomMau = HeNhomMau::findOne([
                                    'id_he_nhom' => $heNhomModel->id,
                                    'id_he_mau' => $checkHeMau->id
                                ]);
                                if(!$checkHeNhomMau){
                                    $errCount++;//tang error len
                                    array_push($errorByRow, 'Mã màu ' . $xls_data[$index]['N'] . ' tìm thấy nhưng không được cấu hình cho hệ nhôm này! Vui lòng kiểm tra lại.');
                                    $errors[$sheet->getTitle()][$index] = $errorByRow;
                                }
                                
                            }
                        }
                    }
                    //*****check cột hệ nhôm bổ sung thêm
                    if(isset($row['M']) && $row['M']){
                        $heNhomCheck = HeNhom::findOne(['code'=>$row['M']]);
                        if(!$heNhomCheck){
                            $errCount++;//tang error len
                            array_push($errorByRow, 'Mã hệ nhôm ' . $xls_data[$index]['M'] . ' không tìm thấy! Vui lòng kiểm tra lại.');
                            $errors[$sheet->getTitle()][$index] = $errorByRow;
                        }
                        
                    }
                    
                }
                //****check data kính****
                $startRow = $arrr[1] + 1;
                $endRow = $arrr[2] - 3;
                
                //****check data phụ kiện****
                $startRow = $arrr[2] + 1;
                $endRow = $arrr[3] - 2;
                if($index>=$startRow && $index<=$endRow){
                    //** check hệ màu xem có tồn tại không
                    if(isset($row['K']) && $row['K']){
                        $heMauCheck = HeMau::findOne(['code'=>$row['K'], 'for_phu_kien'=>1]);
                        if(!$heMauCheck){
                            $errCount++;//tang error len
                            array_push($errorByRow, 'Mã hệ màu ' . $xls_data[$index]['K'] . ' cho phụ kiện không tồn tại! Vui lòng kiểm tra lại.');
                            $errors[$sheet->getTitle()][$index] = $errorByRow;
                        }
                        
                    }
                }
                
                //****check data vật tư****
                $startRow = $arrr[3] + 1;
                if($index>=$startRow){
                    //** check hệ màu xem có tồn tại không
                    if(isset($row['K']) && $row['K']){
                        $heMauCheck = HeMau::findOne(['code'=>$row['K'], 'for_phu_kien'=>1]);
                        if(!$heMauCheck){
                            $errCount++;//tang error len
                            array_push($errorByRow, 'Mã hệ màu ' . $xls_data[$index]['K'] . ' cho vật tư không tồn tại! Vui lòng kiểm tra lại.');
                            $errors[$sheet->getTitle()][$index] = $errorByRow;
                        }
                        
                    }
                }
                
                
                
            }
            
            /* foreach ($xls_data as $index=>$row){
                $errorByRow[$i] = array();
                if($index>=ImportDuAn1::START_ROW){
                    //check mã nhôm ko được trống
                    //check mã nhôm bổ sung phải tồn tại
                    //check hệ nhôm có tồn tại và có độ dày mặc định chưa
                }
                if($errorByRow[$i] != null){
                    //array_push($errors, $errorByRow);
                    $errors[$i][$index] = $errorByRow[$i];
                }
            } */
        }
        if($errCount == 0){
            return array();
        } else {
            return $errors;
        }
    }
    
    /**
     * import file đã kiểm tra vào csdl
     * @param string $file: ten file
     * @return number[]|string[][]
     */
    public static function importFile($congTrinhModel, $file){
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
            $heNhomExist = true;//use to check cay nhom
            $heNhomModel = HeNhom::findOne(['ten_he_nhom'=>$xls_data[13]['A']]);
            if($heNhomModel == null){
                $heNhomExist = false;
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
            
            $model->id_cong_trinh = $congTrinhModel->id;
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
                //**** them cua-nhom
                $startRow = $arrr[0] + 1;
                $endRow = $arrr[1] - 3;
                if($index>=$startRow && $index<=$endRow){
                    $nhomCua = new MauCuaNhom();
                    $nhomCua->id_mau_cua = $model->id;
                    
                    //check cay nhom
                    $cayNhomModel = CayNhom::findOne(['code'=>$row['B']]);
                    if(isset($row['K']) || isset($row['M'])){
                        if($cayNhomModel != null && ($row['K']!= NULL || $row['M']!=NULL)){
                            //xu ly cay nhom khac do day, ma nhom
                            if( isset($row['K']) && $row['K']!= NULL && isset($row['M']) && $row['M']!=NULL){
                                /* if($cayNhomModel->do_day != $sheet->getCell('K'.$index)->getValue() && $cayNhomModel->heNhom->code != $sheet->getCell('M'.$index)->getValue()){
                                    $cayNhomModel = null;
                                } */
                                $cayNhomModel = CayNhom::findOne([
                                    'code' => $row['B'],
                                    'do_day' => $sheet->getCell('K'.$index)->getValue(),
                                    'id_he_nhom' => HeNhom::findOne(['code'=>$sheet->getCell('M'.$index)->getValue()])->id,
                                ]);
                            } else if(isset($row['K']) && $row['K']!= NULL && (!isset($row['M']) || $row['M']==NULL)){
                                /* if($cayNhomModel->do_day != $sheet->getCell('K'.$index)->getValue()){
                                    $cayNhomModel = null;
                                } */
                                $cayNhomModel = CayNhom::findOne([
                                    'code' => $row['B'],
                                    'do_day' => $sheet->getCell('K'.$index)->getValue(),
                                ]);
                            } else if((!isset($row['K']) || $row['K']== NULL) && isset($row['M']) && $row['M']!=NULL){
                                /* if($cayNhomModel->do_day != $sheet->getCell('M'.$index)->getValue()){
                                    $cayNhomModel = null;
                                } */
                                $cayNhomModel = CayNhom::findOne([
                                    'code' => $row['B'],
                                    //'do_day' => $sheet->getCell('K'.$index)->getValue(),
                                    'id_he_nhom' => HeNhom::findOne(['code'=>$sheet->getCell('M'.$index)->getValue()])->id,
                                ]);
                            }
                        }
                    }
                    //check mau nhom neu co
                    if(isset($row['N']) && $row['N']){
                        $heMau = HeMau::findOne(['code'=>$row['N']]);
                        if(isset($row['M']) && $row['M']){                            
                            $cayNhomModel = CayNhom::find()->where([
                                'code' => $row['B'],
                                'id_he_mau' => $heMau->id,
                                'id_he_nhom' => HeNhom::findOne(['code'=>$sheet->getCell('M'.$index)->getValue()])->id
                            ])->one();
                        } else {
                            $cayNhomModel = CayNhom::find()->where([
                                'code' => $row['B'],
                                'id_he_mau' => $heMau->id,
                                
                            ])->one();
                        }
                    }
                    if($cayNhomModel == null){
                        $cayNhomModel = new CayNhom();
                        //set he nhom
                        $heNhomCuaCayNhom = $model->id_he_nhom;
                        $heNhomCuaCayNhomTuyChinh = $sheet->getCell('M'.$index)->getValue();
                        if( $heNhomCuaCayNhomTuyChinh != NULL){
                            $heNhomCuaCayNhomTuyChinhModel = HeNhom::findOne(['code'=>$heNhomCuaCayNhomTuyChinh]);
                            if( $heNhomCuaCayNhomTuyChinhModel != null){
                                $heNhomCuaCayNhom = $heNhomCuaCayNhomTuyChinhModel->id;
                            }
                        }                        
                        $cayNhomModel->id_he_nhom = $heNhomCuaCayNhom;
                        $cayNhomModel->code = $row['B'];
                        $cayNhomModel->ten_cay_nhom = $row['C'];
                        //tinh do day
                        $doDay = $sheet->getCell('K'.$index)->getValue();
                        if($doDay == NULL || $doDay == 0){
                            $doDay = $heNhomModel->do_day_mac_dinh;
                        }
                        $cayNhomModel->do_day = $doDay;
                        //set khoi luong
                        $khoiLuongCuaCayNhom = $sheet->getCell('L'.$index)->getValue();
                        if($khoiLuongCuaCayNhom > 0){
                            $cayNhomModel->khoi_luong = $khoiLuongCuaCayNhom;
                        }
                        //bo sung 28/8 (hệ màu)
                        if(isset($row['N']) && $row['N']){
                            $cayNhomModel->id_he_mau = $heMau->id;
                        } else {
                            $heNhomMau = HeNhomMau::find()->where([
                                'id_he_nhom'=>$heNhomModel->id,
                                'is_mac_dinh' => 1
                            ])->one();//chắc chắn có vì đã check trước khi import nên ko cần check lại
                            $cayNhomModel->id_he_mau = $heNhomMau->id_he_mau;
                        }
                        
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
                        $phuKienModel = KhoVatTu::find()->where([
                            'ten_vat_tu'=>$row['C'],
                            'dvt'=>$dvtModel->id,
                            'id_nhom_vat_tu'=>1//1 is phu kien
                        ]);
                        //thêm màu
                        if(isset($row['K']) && $row['K']){
                            $heMau = HeMau::findOne(['code'=>$row['K'], 'for_phu_kien'=>1]);//da kiem tra khi import nên chắc chắn có
                            $phuKienModel = $phuKienModel->andWhere(['id_he_mau'=>$heMau->id]);
                        }else{
                            $phuKienModel = $phuKienModel->andWhere('id_he_mau IS NULL');
                        }
                        $phuKienModel = $phuKienModel->one();
                        if($phuKienModel==null){
                            $phuKienModel = new KhoVatTu();
                            $phuKienModel->ten_vat_tu = $row['C'];
                            $phuKienModel->id_nhom_vat_tu = 1;//1 la phu kien, xem KhoVatBase.
                            if(isset($row['K']) && $row['K']){//set hệ màu
                                $phuKienModel->id_he_mau = $heMau->id;
                            }else{
                                $phuKienModel->id_he_mau = NULL;
                            }
                            $phuKienModel->la_phu_kien = 1;
                            //$phuKienModel->so_luong = $row['I'];
                            $phuKienModel->so_luong = 0;
                            $phuKienModel->dvt = $dvtModel->id;
                            $phuKienModel->don_gia = 0;
                            $phuKienModel->save(); //**
                        }
                    } else {
                        //neu co ma vat tu thi kiem tra theo ma_vat_tu
                        $phuKienModel = KhoVatTu::find()->where(['code'=>$row['H']]);
                        //thêm màu
                        if(isset($row['K']) && $row['K']){
                            $heMau = HeMau::findOne(['code'=>$row['K'], 'for_phu_kien'=>1]);//da kiem tra khi import nên chắc chắn có
                            $phuKienModel = $phuKienModel->andWhere(['id_he_mau'=>$heMau->id]);
                        }else{
                            $phuKienModel = $phuKienModel->andWhere('id_he_mau IS NULL');
                        }
                        $phuKienModel = $phuKienModel->one();
                        if($phuKienModel==null){
                            $phuKienModel = new KhoVatTu();
                            $phuKienModel->code = $row['H'];//****this line different from below condition.
                            $phuKienModel->ten_vat_tu = $row['C'];
                            if(isset($row['K']) && $row['K']){//set hệ màu
                                $phuKienModel->id_he_mau = $heMau->id;
                            }else{
                                $phuKienModel->id_he_mau = NULL;
                            }
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
                        
                        $phuKienModel = KhoVatTu::find()->where([
                            'ten_vat_tu'=>$row['C'],
                            'dvt'=>$dvtModel->id,
                            'id_nhom_vat_tu'=>2//2 is vat tu
                        ]);
                        //thêm màu
                        if(isset($row['K']) && $row['K']){
                            $heMau = HeMau::findOne(['code'=>$row['K'], 'for_phu_kien'=>1]);//da kiem tra khi import nên chắc chắn có
                            $phuKienModel = $phuKienModel->andWhere(['id_he_mau'=>$heMau->id]);
                        }else{
                            $phuKienModel = $phuKienModel->andWhere('id_he_mau IS NULL');
                        }
                        $phuKienModel = $phuKienModel->one();
                        
                        if($phuKienModel==null){
                            $phuKienModel = new KhoVatTu();
                            $phuKienModel->ten_vat_tu = $row['C'];
                            if(isset($row['K']) && $row['K']){//set hệ màu
                                $phuKienModel->id_he_mau = $heMau->id;
                            }else{
                                $phuKienModel->id_he_mau = NULL;
                            }
                            $phuKienModel->id_nhom_vat_tu = 2;//2 la vat tu, xem KhoVatBase.
                            $phuKienModel->la_phu_kien = 0;
                            //$phuKienModel->so_luong = $row['I'];
                            $phuKienModel->so_luong = 0;
                            $phuKienModel->dvt = $dvtModel->id;
                            $phuKienModel->don_gia = 0;
                            $phuKienModel->save(); //**
                        }
                    } else {
                        //neu co ma vat tu thi kiem tra theo ma_vat_tu
                        $phuKienModel = KhoVatTu::find()->where(['code'=>$row['H']]);
                        //thêm màu
                        if(isset($row['K']) && $row['K']){
                            $heMau = HeMau::findOne(['code'=>$row['K'], 'for_phu_kien'=>1]);//da kiem tra khi import nên chắc chắn có
                            $phuKienModel = $phuKienModel->andWhere(['id_he_mau'=>$heMau->id]);
                        }else{
                            $phuKienModel = $phuKienModel->andWhere('id_he_mau IS NULL');
                        }
                        $phuKienModel = $phuKienModel->one();
                        if($phuKienModel==null){
                            $phuKienModel = new KhoVatTu();
                            $phuKienModel->code = $row['H'];//****this line different from below condition.
                            $phuKienModel->ten_vat_tu = $row['C'];
                            if(isset($row['K']) && $row['K']){//set hệ màu
                                $phuKienModel->id_he_mau = $heMau->id;
                            }else{
                                $phuKienModel->id_he_mau = NULL;
                            }
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