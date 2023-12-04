<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\KhoNhomBase;
use Yii;

class KhoNhom extends KhoNhomBase
{
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
     * Gets query for [[CuaKhoNhomLichSus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaKhoNhomLichSus()
    {
        return $this->hasMany(KhoNhomLichSu::class, ['id_kho_nhom' => 'id']);
    }
}