<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\MauCuaVatTuBase;
use Yii;
use app\modules\kho\models\KhoVatTu;

class MauCuaVatTu extends MauCuaVatTuBase
{
    /**
     * Gets query for [[KhoVatTu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoVatTu()
    {
        return $this->hasOne(KhoVatTu::class, ['id' => 'id_kho_vat_tu']);
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