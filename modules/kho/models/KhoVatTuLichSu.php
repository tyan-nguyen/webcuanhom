<?php

namespace app\modules\kho\models;

use Yii;
use app\modules\kho\models\base\KhoVatTuLichSuBase;

class KhoVatTuLichSu extends KhoVatTuLichSuBase
{
    /***** relation *****/
    
    /**
     * Gets query for [[KhoVatTu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoVatTu()
    {
        return $this->hasOne(KhoVatTu::class, ['id' => 'id_kho_vat_tu']);
    }
    /***** /relation *****/
    /***** custom function *****/
    /***** /custom function *****/
    /***** virtual attributes *****/
    /***** /virtual attributes *****/
}
