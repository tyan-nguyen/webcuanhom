<?php

namespace app\modules\kho\models;

use Yii;
use app\modules\kho\models\base\KhoVatTuBase;
use yii\helpers\Html;
use app\modules\maucua\models\MauCuaVatTu;

class KhoVatTu extends KhoVatTuBase
{
    /***** relation *****/
    
    /**
     * Gets query for [[CuaKhoVatTuLichSus]]
     * @return \yii\db\ActiveQuery
     */
    public function getCuaKhoVatTuLichSus()
    {
        return $this->hasMany(KhoVatTuLichSu::class, ['id_kho_vat_tu' => 'id']);
    }
    /**
     * Gets query for [[CuaKhoNhoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTonKho()
    {
        return $this->hasMany(KhoVatTuLichSu::class, ['id_kho_vat_tu' => 'id'])->orderBy(['date_created' => SORT_DESC]);
    }
    
    /**
     * Gets query for [[KhoVatTu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDonViTinh()
    {
        return $this->hasOne(DonViTinh::class, ['id' => 'dvt']);
    }
    /**
     * Gets query for [[XuatXu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getXuatXu()
    {
        if($this->xuat_xu == null){
            $this->xuat_xu = 1;//1 is chua-phan-loai
            if($this->save()){
                $this->refresh();
            }
        }
        return $this->hasOne(XuatXu::class, ['id' => 'xuat_xu']);
    }
    
    public function getThuongHieu()
    {
        if($this->thuong_hieu == null){
            $this->thuong_hieu = 1;//1 is chua-phan-loai
            if($this->save()){
                $this->refresh();
            }
        }
        return $this->hasOne(ThuongHieu::class, ['id' => 'thuong_hieu']);
    }
    /***** /relation *****/    
    /***** custom function *****/
    /***** /custom function *****/
    /***** virtual attributes *****/
    public function getShowAction(){
        return Html::a($this->code,
            [Yii::getAlias('@web/kho/kho-vat-tu/view'), 'id'=>$this->id],
            ['role'=>'modal-remote', 'class'=>'aInGrid']
            );
    }
    //Tinh toan so luong ton kho dang bi ket trong du an dang bat dau
    public function getSoLuongKetBatDau(){
        // 1- tim kiem bang cua-vat-tu, cua-phu-kien
        // 2- select bang mau cua - trang thai dang khoi tao
        // 3 - sum so luong
        // return
        $slKhoiTaoModel = MauCuaVatTu::find()->alias('t')->joinWith([
            'mauCua as mc', 'mauCua.duAn as da'
        ])->where([
            'id_kho_vat_tu' => $this->id,
            'da.trang_thai'=>'KHOI_TAO',
        ])->sum('t.so_luong');
        return $slKhoiTaoModel == null ? 0 : $slKhoiTaoModel;
    }
    //Tinh toan so luong ton kho dang bị ket trong du an dang thuc hien
    public function getSoLuongKetDangThucHien()
    {
        // 1- tim kiem bang cua-vat-tu, cua-phu-kien
        // 2- select bang mau cua - trang thai dang thuc hien
        // 3 - sum so luong
        // return
        $slDangThucHienModel = MauCuaVatTu::find()->alias('t')->joinWith([
            'mauCua as mc', 'mauCua.duAn as da'
        ])->where([
            'id_kho_vat_tu' => $this->id,
            'da.trang_thai'=>'THUC_HIEN',
        ])->sum('t.so_luong');
        return $slDangThucHienModel == null ? 0 : $slDangThucHienModel;
    }
    //Tinh toan so luong ton kho dang available (ton kho - so luong ngam bat dau - so luong ngam trong du an)
    public function getSoLuongTonKhoAvailable()
    {
        //lay so luong ton kho thuc te bang khovattu - virtual attribute getSoLuongKetDangThucHien
        return $this->so_luong - $this->getSoLuongKetDangThucHien();
    }
    //tinh toan so sluong ton kho de xua (tinh luon so luong ton kho dang trong du an moi khoi tao)
    public function getSoLuongTonKhoDeXuat(){
        //lay so luong ton kho thuc te bang khovattu - virtual so luong ton kho dang trong du an moi khoi tao - virtual so luong ton kho dang bat dau
        return $this->so_luong - $this->getSoLuongKetBatDau() - $this->getSoLuongKetDangThucHien();
    }
    /***** /virtual attributes *****/
}
