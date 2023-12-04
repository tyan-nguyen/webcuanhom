<?php

namespace app\modules\kho\models;

use Yii;
use app\modules\kho\models\base\KhoVatTuLichSuBase;

class KhoVatTuLichSu extends KhoVatTuLichSuBase
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
    /***** /relation *****/
    /***** custom function *****/
    /***** /custom function *****/
    /***** virtual attributes *****/
    /***** /virtual attributes *****/
}
