<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\KhoNhomBase;
use Yii;
use yii\helpers\Html;

class KhoNhom extends KhoNhomBase
{
    const MODEL_ID = 'kho-nhom';
    /**
     * Gets query for [[CayNhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCayNhom()
    {
        return $this->hasOne(CayNhom::class, ['id' => 'id_cay_nhom']);
    }
    
    /**
     * get khoi luong cua cay nhom
     */
    public function getKhoiLuong(){
        return round( ($this->cayNhom->khoi_luong/$this->cayNhom->chieu_dai)*$this->chieu_dai , 2);
    }
    /**
     * Gets query for [[CuaKhoNhomLichSus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistory()
    {
        return $this->hasMany(KhoNhomLichSu::class, ['id_kho_nhom' => 'id'])->orderBy([
            'date_created' => SORT_DESC
        ]);;
    }
    
    public function getShowAction(){
        return Html::a($this->scode,
                [Yii::getAlias('@web/maucua/cay-nhom/view'), 'id'=>$this->id_cay_nhom],
                ['role'=>'modal-remote', 'class'=>'aInGrid']
            );
    }
    
    public function getShowChieuDaiAction(){
        return Html::a(number_format($this->chieu_dai) . ' mm',
            [Yii::getAlias('@web/kho/kho-nhom/view'), 'id'=>$this->id],
            ['role'=>'modal-remote', 'class'=>'aInGrid']
            );
    }
    /***** virtual attribute *****/
    public function getScode(){
        return $this->cayNhom->code;
    }
    //get qrcode
    public function getQrImage(){
        $qrPath = Yii::getAlias('@web/images/qr/') .$this->qr_code . '.png';
        return $qrPath;
    }
    //check qr image exist
    public function getCheckHasQr(){
        $qrPath = Yii::getAlias('@webroot/images/qr/') .$this->qr_code . '.png';
        return file_exists($qrPath);
    }
    
    /**
     * phien bản mới tính theo kế hoạch
     */
    //Tinh toan so luong ton kho dang bị ket trong du an da toi uu
    public function getSoLuongTrongKeHoachDaToiUu()
    {
        // 1- tim kiem bang nhom-su-dung
        // 2- select bang id du an - trang thai cua bang DuAn là TOI_UU
        // 3 - sum so luong
        // return
        $slDangThucHienModel = NhomSuDung::find()->alias('t')->joinWith([
            'mauCua.duAn as da'
        ])->where([
            'id_kho_nhom' => $this->id,
            'da.trang_thai'=>'TOI_UU',
        ])->count();
        return $slDangThucHienModel == null ? 0 : round($slDangThucHienModel,2);
    }
    
    public function getSoLuongTonKhoDuKien()
    {
        return $this->so_luong - $this->getSoLuongTrongKeHoachDaToiUu();
    }
}