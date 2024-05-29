<?php
namespace app\modules\banle\models;
use Yii;
use app\modules\banle\models\base\HoaDonBase;
use webvimark\modules\UserManagement\models\User;
use app\modules\kho\models\KhoVatTuLichSu;
use app\modules\kho\models\VatTu;
use app\modules\kho\models\KhoVatTu;
use app\modules\maucua\models\KhoNhom;
use app\modules\maucua\models\KhoNhomLichSu;
/**
 * HoaDon class
 * @author annvt
 */
class HoaDon extends HoaDonBase
{
   /*  public $diaChiKhachHang;
    public $sdtKhachHang;
    public $emailKhachHang; */
    /**
     * Gets query for [[HoaDonChiTiets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHoaDonChiTiets()
    {
        return $this->hasMany(HoaDonChiTiet::class, ['id_hoa_don' => 'id']);
    }
    
    /**
     * Gets query for [[KhachHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhachHang()
    {
        return $this->hasOne(KhachHang::class, ['id' => 'id_khach_hang']);
    }
    
    public function getTongTien(){
        $sum = 0;
        foreach ($this->hoaDonChiTiets as $hdct){
            $sum += $hdct->thanhTien;
        }
        return $sum;
    }
    
    public function dsVatTuYeuCau(){
        $result = array();
        foreach ($this->hoaDonChiTiets as $iVt=>$vatTu){
            $result[] = [
                'id'=>$vatTu->id,
                'idPhieu'=>$vatTu->id_hoa_don,
                'idVatTu'=>$vatTu->id_vat_tu,
                'tenVatTu'=>$vatTu->tenVatTu,
                'loaiVatTu'=>$vatTu->loai_vat_tu,
                'dvt'=>$vatTu->dvtVatTu,
                'dvtCayNhom'=>'Cây',
                'soLuong'=>$vatTu->soLuong,
                'soLuongCayNhom'=>$vatTu->soLuongCayNhom,//danh cho cay nhom
                'donGia'=>$vatTu->donGia,
                'ghiChu'=>$vatTu->ghiChu,
                'thanhTien'=>$vatTu->thanhTien
            ];
        }
        return [
            'tongTien' => $this->getTongTien(),
            'dsVatTu' => $result
        ];
    }
    
    public function nguoiTao(){
        $model = User::findOne($this->user_created);
        return $model!=null ? $model->username : '';
    }
    
    /**
     * xuất hàng khi chuyển trạng thái hóa đơn từ bản nháp -> đã xuất
     */
    public function xuatHang(){
        foreach ($this->hoaDonChiTiets as $iVt=>$chiTiet){
            
           /*  if($chiTiet->so_luong > 0){
                if($chiTiet->loai_vat_tu != 'NHOM'){
                    $lichSuTonKho = new KhoVatTuLichSu();
                    $lichSuTonKho->id_kho_vat_tu = $chiTiet->id_vat_tu;
                    $lichSuTonKho->id_nha_cung_cap = 1; //1 la chua phan loai, khong duoc xoa danh muc id 1
                    $lichSuTonKho->ghi_chu = 'Xuất kho theo đơn hàng bán lẻ ' . $this->soHoaDon;
                    $lichSuTonKho->so_luong = -($chiTiet->so_luong);
                    $lichSuTonKho->so_luong_cu = $chiTiet->soLuongVatTu;
                    $lichSuTonKho->so_luong_moi = $chiTiet->soLuongVatTu - $chiTiet->so_luong;
                    $lichSuTonKho->id_mau_cua = null;//*********
                    $lichSuTonKho->save();
                } else {
                    
                }
            } */
            
            //sua so luong
            if($chiTiet->loai_vat_tu != 'NHOM'){
                $vatTuModel = KhoVatTu::findOne($chiTiet->id_vat_tu);
                $vatTuModel->so_luong = $chiTiet->soLuongVatTu - $chiTiet->so_luong;
                if($vatTuModel->save()){
                    //luu lich su
                     if($chiTiet->so_luong > 0){
                            $lichSuTonKho = new KhoVatTuLichSu();
                            $lichSuTonKho->id_kho_vat_tu = $chiTiet->id_vat_tu;
                            $lichSuTonKho->id_nha_cung_cap = 1; //1 la chua phan loai, khong duoc xoa danh muc id 1
                            $lichSuTonKho->ghi_chu = 'Xuất kho theo đơn hàng bán lẻ ' . $this->soHoaDon;
                            $lichSuTonKho->so_luong = -($chiTiet->so_luong);
                            $lichSuTonKho->so_luong_cu = $chiTiet->soLuongVatTu;
                            $lichSuTonKho->so_luong_moi = $chiTiet->soLuongVatTu - $chiTiet->so_luong;
                            $lichSuTonKho->id_mau_cua = null;//*********
                            $lichSuTonKho->save();
    
                    }
                }
            } else {
                $nhomModel = KhoNhom::findOne($chiTiet->id_vat_tu);
                $nhomModel->so_luong = $chiTiet->soLuongVatTu - $chiTiet->so_luong;
                if($nhomModel->save()){
                    //luu lich su
                    if($chiTiet->so_luong > 0){
                        $history = new KhoNhomLichSu();
                        $history->id_kho_nhom = $chiTiet->id_vat_tu;
                        $history->so_luong = -$chiTiet->so_luong;
                        $history->so_luong_cu = $chiTiet->soLuongVatTu;
                        $history->so_luong_moi = $chiTiet->soLuongVatTu - $chiTiet->so_luong;
                        $history->noi_dung = 'Xuất kho theo đơn hàng bán lẻ ' . $this->soHoaDon;
                        $history->save();
                    }
                }
            }
            
        }
    }
    
    /**
     * get thong tin khach hang
     */
    public function getTenKhachHang(){
        return $this->khachHang!=null ? $this->khachHang->ten_khach_hang : '';
    }
    public function getDiaChiKhachHang(){
        return $this->khachHang!=null ? $this->khachHang->dia_chi : '';
    }
    public function getSdtKhachHang(){
        return $this->khachHang!=null ? $this->khachHang->so_dien_thoai : '';
    }
    public function getEmailKhachHang(){
        return $this->khachHang!=null ? $this->khachHang->email : '';
    }
    
}