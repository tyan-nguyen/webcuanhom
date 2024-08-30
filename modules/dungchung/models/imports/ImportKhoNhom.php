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
use app\modules\dungchung\models\Setting;
use app\modules\maucua\models\HeMau;

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
        $excel = Import::readExcel($file);
        $sheet = $excel->getActiveSheet();
        $xls_data = Import::readExcelToArr($file);
        
        $errors = array();
        $errorByRow = array();
        
        $currentCodeNhomMoi = '';//dung de check ton kho nhom ton tai ngoai tru truong hop cay nhom moi có ở trên nhưng chưa thêm vào db
        foreach ($xls_data as $index=>$row){
            $errorByRow = array();            
            
            if($index>=ImportPhuKien::START_ROW){    
                $heNhom = HeNhom::findOne(['code'=>$row['C']]);
                $cayNhomDoDay = $sheet->getCell('I'.$index)->getValue();
                $codeHeMau = $row['E'];
                
                //check B <la cay nhom moi>, x or X or null
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->allowNull = true;
                $mod->valueCompare = ['x', 'X'];
                $err = $mod->checkVal('B'.$index, $row['B']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                } 
                
                //check C <he_nhom>, check exist in db and not null
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = false;
                $mod->modelExist = HeNhom::find()->where(['code'=>$row['C']]);
                $err = $mod->checkVal('C'.$index, $row['C']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check D, <ma_cay_nhom> not null
                $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('D'.$index, $row['D']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check D, <ma_cay_nhom> tồn kho phải có mã nhôm tồn tại
                if($row['B'] == 'x' || $row['B'] == 'X'){
                    $currentCodeNhomMoi = $row['D'];
                    $currentHeNhomMoi = $row['C'];
                    $currentDoDayMoi = $row['I'];
                }
                if($row['B'] == null && ($row['D'] != $currentCodeNhomMoi || $row['C'] != $currentHeNhomMoi || $row['I'] != $currentDoDayMoi ) && $heNhom != null){
                    $mod = new CheckFile();
                    $mod->isExist = true;
                    $mod->allowNull = false;
                    $mod->modelExist = CayNhom::find()->where([
                        'code'=>$row['D'],
                        'id_he_nhom' => $heNhom->id,
                        'do_day' => $cayNhomDoDay>0 ? $cayNhomDoDay : $heNhom->do_day_mac_dinh,
                    ]);
                    $err = $mod->checkVal('D'.$index, $row['D']);
                    if(!empty($err)){
                        array_push($errorByRow, $err);
                    }
                }
                //check E code hệ màu, hệ màu phải tồn tại
                $mod = new CheckFile();
                $mod->isExist = true;
                $mod->allowNull = false;
                $mod->modelExist = HeMau::find()->where(['code'=>$row['E'], 'for_nhom'=>1]);
                $err = $mod->checkVal('E'.$index, $row['E']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check F, <ten_cay_nhom> not null
                $mod = new CheckFile();
                $mod->allowNull = false;
                $err = $mod->checkVal('F'.$index, $row['F']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check G, <chieu_dai> >= 0
               $mod = new CheckFile();
               $mod->isGreaterThan = 0; //>=0
               //$mod->allowNull = false;
               $err = $mod->checkVal('G'.$index, $sheet->getCell('G'.$index)->getValue());
               if(!empty($err)){
                   array_push($errorByRow, $err);
               }
               
               //check H <khoi_luong> >= 0
               $mod = new CheckFile();
               $mod->isGreaterThan = 0;
               $err = $mod->checkVal('H'.$index, $row['H']);
               if(!empty($err)){
                   array_push($errorByRow, $err);
               }
               
               //check I <do_day> >= 0
               $mod = new CheckFile();
               $mod->isGreaterThan = 0;
               $err = $mod->checkVal('I'.$index, $row['I']);
               if(!empty($err)){
                   array_push($errorByRow, $err);
               }
               
               //check J, <ton_kho> >= 0
               $mod = new CheckFile();
               $mod->isGreaterThan = 0;
               $err = $mod->checkVal('J'.$index, $row['J']);
               if(!empty($err)){
                   array_push($errorByRow, $err);
               }
                
                //check K <don_gia> is not null (chỉ cho nhôm chính)
               if($row['B'] == 'x' || $row['B'] == 'X'){
                    $mod = new CheckFile();
                    $mod->allowNull = false;
                    $err = $mod->checkVal('K'.$index, $row['K']);
                    if(!empty($err)){
                        array_push($errorByRow, $err);
                    }
               }
                
                //check L <dung_cho_cua_so>, x or X or null
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = ['x', 'X'];
                $err = $mod->checkVal('L'.$index, $row['L']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                } 
                //check M <dung_cho_cua_di>, x or X or null
                $mod = new CheckFile();
                $mod->isCompare = true;
                $mod->valueCompare = ['x', 'X'];
                $err = $mod->checkVal('M'.$index, $row['M']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                } 
                
                //check N <chieu_dai_toi_thieu_cat>, >= 0
                $mod = new CheckFile();
                $mod->allowNull = false;
                $mod->isGreaterThan = 0;
                $err = $mod->checkVal('N'.$index, $row['N']);
                if(!empty($err)){
                    array_push($errorByRow, $err);
                }
                
                //check O <chieu_dai_toi_thieu_cat>, >= 0
                $mod = new CheckFile();
                $mod->allowNull = false;
                $mod->isGreaterThan = 0;
                $err = $mod->checkVal('O'.$index, $row['O']);
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
        $setting = Setting::find()->one();        
        
        foreach ($xls_data as $index=>$row){
            if($index>=ImportKhoNhom::START_ROW){
                //check cay nhom co chua
                //co thi lay id cay nhom
                //khong co thi them moi cay nhom va lay id
                          
                //kiem tra cay nhom co phai la cay nhom dang thao tac khong
                $heNhom = HeNhom::findOne(['code'=>$row['C']]); //chac chan ko bang null vi da co buoc checkfile truoc do
                $cayNhomDoDay = $sheet->getCell('I'.$index)->getValue();
                
                $doDay = $cayNhomDoDay>0 ? $cayNhomDoDay : $heNhom->do_day_mac_dinh;
                $heMau = HeMau::find()->where(['code'=>$row['E'], 'for_nhom'=>1])->one();//chac chan ko bang null
                $cayNhom = CayNhom::find()->where([
                    'code' => $row['D'],
                    'id_he_nhom' => $heNhom->id,
                    'ten_cay_nhom' => $row['F'],
                    'id_he_mau' => $heMau->id
                ])->andWhere('cast(do_day as decimal(5,2)) ='.$doDay)->one();
                if($cayNhom == null){
                    if($row['B'] == 'x' || $row['B']=='X'){
                        //xu ly khi la cay nhom chinh
                        $cayNhom = new CayNhom();
                        $cayNhom->id_he_nhom = $heNhom->id;                                            
                        $cayNhom->code = $row['D'];
                        $cayNhom->id_he_mau = $heMau->id;
                        $cayNhom->ten_cay_nhom = $row['F'];
                        $cayNhom->chieu_dai = $sheet->getCell('G'.$index)->getValue();
                        $cayNhom->khoi_luong = $sheet->getCell('H'.$index)->getValue();
                        $cayNhom->do_day = $sheet->getCell('I'.$index)->getValue();
                        $cayNhom->so_luong = $sheet->getCell('J'.$index)->getValue();
                        $cayNhom->don_gia = $sheet->getCell('K'.$index)->getValue();
                        if($row['L'] == 'x' || $row['L']=='X'){
                            $cayNhom->for_cua_so = 1;
                        }
                        if($row['M'] == 'x' || $row['M']=='X'){
                            $cayNhom->for_cua_di = 1;
                        }
                        $cayNhom->min_allow_cut = $sheet->getCell('N'.$index)->getValue();
                        $cayNhom->min_allow_cut_under = $sheet->getCell('O'.$index)->getValue();
                        if($cayNhom->save()){
                            $successCount++;
                        } else {
                            $errorCount++;
                            $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi (Thêm mới cây nhôm)';
                            $errors[] = $cayNhom->errors;
                        }
                        //sau khi them cay nhom thi aftersave se them ton kho cay nhom moi
                        
                    } else {
                        //xu ly khi KHONG la cay nhom chinh
                        $errorCount++;
                        $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi (Mã cây nhôm không tồn tại)';
                        /* tiep tuc xu ly check trong file check de tranh trương hop nay ............. */
                    }
                } else { // co cay nhom roi
                    if($row['B'] == 'x' || $row['B']=='X'){
                        //xu ly khi la cay nhom chinh
                        //set chieu dai cay nhom neu = 0 hoac null
                        $chieuDaiTemp = $sheet->getCell('G'.$index)->getValue();
                        //$chieuDaiTemp = (int) $row['G'];
                        $chieuDaiTemp = $chieuDaiTemp == null ? $setting->chieu_dai_nhom_mac_dinh : 0;
                        if($chieuDaiTemp == $cayNhom->chieu_dai){
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
                                $khoNhom->so_luong = $sheet->getCell('J'.$index)->getValue();
                                if($khoNhom->save()){
                                    $successCount++;
                                } else {
                                    $errorCount++;
                                    $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi (Thêm mới kho nhôm cho cây nhôm mới)';
                                    $errors[] = $khoNhom->errors;
                                }
                                /* tiep theo xu ly luu lich su, xem chinh sưa phần add tồn kho cây nhôm lại cho hợp lý */
                            }else {
                                //co roi thi xy ly
                                //neu ko co overwrite thì cộng số lượng vô
                                if($isOverwrite ==false){
                                    //add so luong vao ton kho
                                    $khoNhom->so_luong = $khoNhom->so_luong + $sheet->getCell('J'.$index)->getValue();
                                    if($khoNhom->save()){
                                        
                                        $successCount++;
                                        
                                        if($khoNhom->so_luong != $khoNhomOld->so_luong){
                                            $history = new KhoNhomLichSu();
                                            $history->id_kho_nhom = $khoNhom->id;
                                            $history->so_luong = $sheet->getCell('J'.$index)->getValue();
                                            $history->so_luong_cu = $khoNhomOld->so_luong;
                                            $history->so_luong_moi = $khoNhom->so_luong;
                                            $history->noi_dung = 'Cập nhật tồn kho do cập nhật dữ liệu kho nhôm #'.$khoNhom->cayNhom->code . ' (' . $khoNhom->chieu_dai . ') từ file exel';
                                            $history->save();
                                        }
                                    }
                                    
                                } else {
                                    //set lại tồn kho
                                    $khoNhom->so_luong = $sheet->getCell('J'.$index)->getValue();
                                    if($khoNhom->save()){
                                        
                                        $successCount++;
                                        
                                        if($khoNhom->so_luong != $khoNhomOld->so_luong){
                                            $history = new KhoNhomLichSu();
                                            $history->id_kho_nhom = $khoNhom->id;
                                            $history->so_luong = $khoNhomOld->so_luong - $sheet->getCell('J'.$index)->getValue();
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
                            $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi (Chiều dài cây nhôm không khớp với dữ liệu tồn kho)!' . 'temp: ' . $chieuDaiTemp . '--thuc te:' . $cayNhom->chieu_dai . '--doday:' . $doDay;
                            $errors[] = [];
                        }
                        //neu option overwrite thì ghi đè lại số lượng (khong can de so luong cay nhom, chi de so luong kho nhom thoi)
                        //neu ko co overwrite thì cộng số lượng vô
                    } else {
                        //xu ly khi la cay nhom ton kho
                        //neu option overwrite thì ghi đè lại số lượng
                        $khoNhom = KhoNhom::findOne([
                            'id_cay_nhom'=>$cayNhom->id,
                            'chieu_dai'=>$sheet->getCell('G'.$index)->getValue()
                        ]);
                        $khoNhomOld = KhoNhom::findOne([
                            'id_cay_nhom'=>$cayNhom->id,
                            'chieu_dai'=>$sheet->getCell('G'.$index)->getValue()
                        ]);
                        if($khoNhom ==null){
                            //ko co thi cu them moi la xong
                            $khoNhom = new KhoNhom();
                            $khoNhom->id_cay_nhom = $cayNhom->id;
                            $khoNhom->chieu_dai = $sheet->getCell('G'.$index)->getValue();
                            $khoNhom->so_luong = $sheet->getCell('J'.$index)->getValue();
                            $khoNhom->noiDung = 'Tạo mới kho nhôm khi import kho nhôm từ file excel';
                            if($khoNhom->save()){
                                $successCount++;
                            } else {
                                $errorCount++;
                                $errorByRow[$index] = 'Dòng '. $index . ' bị lỗi (Lỗi tạo mới tồn kho nhôm lẻ)';
                                $errors[] = $khoNhom->errors;
                            }
                            /* tiep theo xu ly luu lich su, xem chinh sưa phần add tồn kho cây nhôm lại cho hợp lý */
                        } else {
                            //co roi thi xy ly
                            //neu ko co overwrite thì cộng số lượng vô
                            if($isOverwrite ==false){
                                //add so luong vao ton kho
                                $khoNhom->so_luong = $khoNhom->so_luong + $sheet->getCell('J'.$index)->getValue();
                                if($khoNhom->save()){
                                    
                                    $successCount++;
                                    
                                    if($khoNhom->so_luong != $khoNhomOld->so_luong){
                                        $history = new KhoNhomLichSu();
                                        $history->id_kho_nhom = $khoNhom->id;
                                        $history->so_luong = $sheet->getCell('J'.$index)->getValue();
                                        $history->so_luong_cu = $khoNhomOld->so_luong;
                                        $history->so_luong_moi = $khoNhom->so_luong;
                                        $history->noi_dung = 'Cập nhật tồn kho do cập nhật dữ liệu kho nhôm #'.$khoNhom->cayNhom->code . ' (' . $khoNhom->chieu_dai . ') từ file exel';
                                        $history->save();
                                    }
                                }
                                
                            } else {
                                //set lại tồn kho
                                $khoNhom->so_luong = $sheet->getCell('J'.$index)->getValue();
                                if($khoNhom->save()){
                                    
                                    $successCount++;
                                    
                                    if($khoNhom->so_luong != $khoNhomOld->so_luong){
                                        $history = new KhoNhomLichSu();
                                        $history->id_kho_nhom = $khoNhom->id;
                                        $history->so_luong = $khoNhomOld->so_luong - $sheet->getCell('J'.$index)->getValue();
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