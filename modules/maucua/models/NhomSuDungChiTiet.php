<?php

namespace app\modules\maucua\models;

use Yii;
use app\modules\maucua\models\base\NhomSuDungChiTietBase;

class NhomSuDungChiTiet extends NhomSuDungChiTietBase
{
    /**
     * Gets query for [[NhomSuDung]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNhomSuDung()
    {
        return $this->hasOne(NhomSuDung::class, ['id' => 'id_nhom_su_dung']);
    }
    
    /**
     * Gets query for [[NhomToiUu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNhomToiUu()
    {
        return $this->hasOne(ToiUu::class, ['id' => 'id_nhom_toi_uu']);
    }
}