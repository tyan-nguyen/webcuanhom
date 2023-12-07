<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\KhoNhomBase;
use Yii;
use yii\helpers\Html;

class KhoNhom extends KhoNhomBase
{
    /**
     * Gets query for [[CayNhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCayNhom()
    {
        return $this->hasOne(CayNhom::class, ['id' => 'id_cay_nhom']);
    }
    
    /**
     * Gets query for [[CuaKhoNhomLichSus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaKhoNhomLichSus()
    {
        return $this->hasMany(KhoNhomLichSu::class, ['id_kho_nhom' => 'id']);
    }
    
    public function getShowAction(){
        return Html::a($this->scode,
                [Yii::getAlias('@web/kho/kho-nhom/view'), 'id'=>$this->id],
                ['role'=>'modal-remote']
            );
    }
    /***** virtual attribute *****/
    public function getScode(){
        return $this->cayNhom->code;
    }
}