<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\KhoNhomLichSuBase;
use Yii;

class KhoNhomLichSu extends KhoNhomLichSuBase
{
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
    
    /**
     * get ten mau cua (neu co)
     */
    public function getTenMauCua(){
        if($this->mauCua != null){
            return $this->mauCua->code;
        } else {
            return null;
        }
    }
}