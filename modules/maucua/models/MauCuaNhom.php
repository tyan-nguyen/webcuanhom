<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\MauCuaNhomBase;
use Yii;

class MauCuaNhom extends MauCuaNhomBase
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
     * Gets query for [[MauCua]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMauCua()
    {
        return $this->hasOne(MauCua::class, ['id' => 'id_mau_cua']);
    }
}