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
}