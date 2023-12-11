<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\MauCuaVachBase;
use Yii;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use app\modules\kho\models\HeVach;


class MauCuaVach extends MauCuaVachBase
{  
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
     * Gets query for [[Vach]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVach()
    {
        return $this->hasOne(HeVach::class, ['id' => 'id_vach']);
    }
}