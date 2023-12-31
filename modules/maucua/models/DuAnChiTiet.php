<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\DuAnChiTietBase;
use Yii;

class DuAnChiTiet extends DuAnChiTietBase
{   
    /**
     * Gets query for [[DuAn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDuAn()
    {
        return $this->hasOne(DuAn::class, ['id' => 'id_du_an']);
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