<?php

namespace app\modules\maucua\models;

use Yii;
use app\modules\maucua\models\base\NhomSuDungBase;
use Da\QrCode\QrCode;

class NhomSuDung extends NhomSuDungBase
{
    /**
     * Gets query for [[CuaMauCuaNhomSuDungChiTiets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChiTiet()
    {
        return $this->hasMany(NhomSuDungChiTiet::class, ['id_nhom_su_dung' => 'id']);
    }
    
    /**
     * Gets query for [[KhoNhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoNhom()
    {
        return $this->hasOne(KhoNhom::class, ['id' => 'id_kho_nhom']);
    }
    
    /**
     * Gets query for [[MauCua]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMauCua()
    {
        //if($this->id_mau_cua != null){
            return $this->hasOne(MauCua::class, ['id' => 'id_mau_cua']);
       // } else {
       //     return array();
       // }
    }
    
    /**
     * Gets query for [[DuAn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDuAn()
    {
        //if($this->id_du_an != null){
        return $this->hasOne(DuAn::class, ['id' => 'id_du_an']);//id_mau_cua la id_du_an
        //} else {
       //     return array();
       // }
    }
    
    //get qrcode
    public function getQrImage(){
        $qrPath = Yii::getAlias('@web/images/qr/') .$this->id . '.png';
        $qrPathRoot = Yii::getAlias('@webroot/images/qr/') .$this->id . '.png';
        if(!file_exists($qrPathRoot)){
            $this->createQRcode($this->id);
        }
        return $qrPath;
    }
    //check qr image exist
    public function getCheckHasQr(){
        $qrPath = Yii::getAlias('@webroot/images/qr/') .$this->id . '.png';
        return file_exists($qrPath);
    }
    /**
     * tao QR code cho 1 chuoi ky tu
     * @param string $folder // --> ex: /folder/abc/
     * @param string $string
     */
    public function createQRcode($string){
        $stringUrl = Yii::$app->params['webUrl'] . 'qr/view?code=' . $string;
        $qrPath = Yii::getAlias('@webroot/images/qr/') .$string;
        $qrCode = (new QrCode($stringUrl))
        // ->useLogo(Yii::getAlias('@webroot/uploads/qrlibs/'). 'logo.png')
        ->setSize(2000)
        ->setMargin(5)
        ->useForegroundColor(0, 0, 0);
        //->useForegroundColor(51, 153, 255);
        
        $qrCode->writeFile($qrPath . '.png');
    }
}