<?php

namespace app\modules\kho\models;

use Yii;
use app\modules\kho\models\base\KhoVatTuBase;
use yii\helpers\Html;

class KhoVatTu extends KhoVatTuBase
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
    /**
     * Gets query for [[KhoVatTu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDonViTinh()
    {
        return $this->hasOne(DonViTinh::class, ['id' => 'dvt']);
    }
    /***** /relation *****/    
    /***** custom function *****/
    /***** /custom function *****/
    /***** virtual attributes *****/
    public function getShowAction(){
        return Html::a($this->code,
            [Yii::getAlias('@web/kho/kho-vat-tu/view'), 'id'=>$this->id],
            ['role'=>'modal-remote']
            );
    }
    /***** /virtual attributes *****/
}
