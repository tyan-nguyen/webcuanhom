<?php

namespace app\modules\maucua\models;

use Yii;
use app\modules\maucua\models\base\NhomSuDungBase;

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
}