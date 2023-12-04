<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\ToiUuBase;
use Yii;

class ToiUu extends ToiUuBase
{   
    /**
     * Gets query for [[MauCua]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMauCua()
    {
        return $this->hasOne(MauCua::class, ['id' => 'id_mau_cua']);
    }
    
    /**
     * Gets query for [[MauCuaNhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMauCuaNhom()
    {
        return $this->hasOne(MauCuaNhom::class, ['id' => 'id_mau_cua_nhom']);
    }
    
    /**
     * Gets query for [[TonKhoNhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTonKhoNhom()
    {
        return $this->hasOne(KhoNhom::class, ['id' => 'id_ton_kho_nhom']);
    }
}