<?php
namespace app\modules\banle\models;
use Yii;
use app\modules\banle\models\base\HoaDonChiTietBase;
use app\modules\kho\models\KhoVatTu;
use app\modules\kho\models\HeVach;
use app\modules\maucua\models\KhoNhom;
/**
 * HoaDonChiTiet class
 * @author admin
 *
 */
class HoaDonChiTiet extends HoaDonChiTietBase
{
    /**
     * Gets query for [[HoaDon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHoaDon()
    {
        return $this->hasOne(HoaDon::class, ['id' => 'id_hoa_don']);
    }
    
    public function danhSachJson(){        
        return [
            'id'=>$this->id,
            'idHoaDon'=>$this->id_hoa_don,
            'idVatTu'=>$this->id_vat_tu,
            'loaiVatTu'=>$this->loai_vat_tu,
            'soLuong'=>$this->so_luong,
            'donGia'=>$this->don_gia,
            'ghiChu'=>$this->ghi_chu,
        ];
        
    }
    
    /**
     * Gets query for [[HoaDon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVatTu()
    {
        if($this->loai_vat_tu == 'NHOM'){
            return $this->hasOne(KhoNhom::class, ['id' => 'id_vat_tu']);
        //} else if($this->loai_vat_tu == 'PHU_KIEN' || $this->loai_vat_tu == 'VAT_TU' || $this->loai_vat_tu == 'THIET_BI'){
        }else{
            return $this->hasOne(KhoVatTu::class, ['id' => 'id_vat_tu']);
        }
    }
    //lấy tên vật tư theo loại vật tư
    public function getTenVatTu()
    {
        if($this->loai_vat_tu == 'NHOM'){
            return $this->vatTu!=NULL ? ( $this->vatTu->cayNhom->ten_cay_nhom . ' ('. $this->vatTu->cayNhom->code .') ' . $this->vatTu->chieu_dai . 'm x ' . $this->so_luong . ' Cây x '. $this->vatTu->cayNhom->khoi_luong .' Kg)' ) : '';
       // } else if($this->loai_vat_tu == 'PHU_KIEN' || $this->loai_vat_tu == 'VAT_TU' || $this->loai_vat_tu == 'THIET_BI'){
        }else{
            return $this->vatTu!=NULL ? ( $this->vatTu->ten_vat_tu . '(' .$this->vatTu->code .')' ) : '';
        }
    }
    //lấy mã vật tư theo loại vật tư
    public function getMaVatTu()
    {
        if($this->loai_vat_tu == 'NHOM'){
            return $this->vatTu!=NULL ? $this->vatTu->cayNhom->code : '';
            // } else if($this->loai_vat_tu == 'PHU_KIEN' || $this->loai_vat_tu == 'VAT_TU' || $this->loai_vat_tu == 'THIET_BI'){
        }else{
            return $this->vatTu!=NULL ? $this->vatTu->code : '';
        }
    }
    //lấy đơn giá vật tư theo loại vật tư
    public function getDonGiaVatTu()
    {
        if($this->loai_vat_tu == 'NHOM'){
            return $this->vatTu!=NULL ? $this->vatTu->cayNhom->don_gia : 0;
       // } else if($this->loai_vat_tu == 'PHU_KIEN' || $this->loai_vat_tu == 'VAT_TU' || $this->loai_vat_tu == 'THIET_BI'){
        }else{
            return $this->vatTu!=NULL ? $this->vatTu->don_gia : 0;
        }
    }
    //lấy số lượng vật tư theo loại vật tư
    public function getSoLuongVatTu()
    {
        if($this->loai_vat_tu == 'NHOM'){
            return $this->vatTu!=NULL ? $this->vatTu->so_luong : 0;
        //} else if($this->loai_vat_tu == 'PHU_KIEN' || $this->loai_vat_tu == 'VAT_TU' || $this->loai_vat_tu == 'THIET_BI'){
        }else{
            return $this->vatTu!=NULL ? $this->vatTu->so_luong : 0;
        }
    }
    //lấy đơn vị tính theo loại vật tư
    public function getDvtVatTu()
    {
        if($this->loai_vat_tu == 'NHOM'){
            return 'Kg';
        //} else if($this->loai_vat_tu == 'PHU_KIEN' || $this->loai_vat_tu == 'VAT_TU' || $this->loai_vat_tu == 'THIET_BI'){
        }else{
            return $this->vatTu!=NULL ? $this->vatTu->donViTinh->ten_dvt : '';
        }
    }
    
    /**
     * for hoa don chi tiet
     */
    public function getDonGia(){
        if($this->loai_vat_tu == 'NHOM'){
           // return ($this->so_luong * $this->vatTu->khoiLuong) * $this->don_gia;
            return $this->don_gia;
        }else{
            return $this->don_gia;
        }
        
    }
    public function getSoLuong(){
        if($this->loai_vat_tu == 'NHOM'){
            return round($this->so_luong * $this->vatTu->khoiLuong, 2);
        }else{
            return $this->so_luong;
        }
        
    }
    public function getSoLuongCayNhom(){
        if($this->loai_vat_tu == 'NHOM'){
            return $this->so_luong;
        }else{
            return 0;
        }
        
    }
    public function getGhiChu(){
        if($this->loai_vat_tu == 'NHOM'){
            return 'Nhôm';
        }else{
            return $this->ghi_chu;
        }
    }
    /**
     * tính tổng tiền của 1 sản phẩm trong hóa đơn (lấy số lượng * đơn giá)
     * @return number
     */
    public function getThanhTien(){
        if($this->loai_vat_tu == 'NHOM'){
            return round( ($this->so_luong * $this->vatTu->khoiLuong) * $this->donGia , 0 );
            //} else if($this->loai_vat_tu == 'PHU_KIEN' || $this->loai_vat_tu == 'VAT_TU' || $this->loai_vat_tu == 'THIET_BI'){
        }else{
            return $this->so_luong * $this->donGia;
        }
        
    }
    
}