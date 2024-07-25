<?php

namespace app\modules\kho\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\modules\kho\models\base\KhoNhomQrBase;
use app\modules\maucua\models\KhoNhom;
use app\modules\maucua\models\NhomSuDung;

class KhoNhomQr extends KhoNhomQrBase
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
     * Gets query for [[NhomSuDung]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNhomSuDung()
    {
        return $this->hasOne(NhomSuDung::class, ['id' => 'id_nhom_su_dung']);
    }
}