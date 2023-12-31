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
        return $this->hasOne(MauCua::class, ['id' => 'id_mau_cua']);
    }
}