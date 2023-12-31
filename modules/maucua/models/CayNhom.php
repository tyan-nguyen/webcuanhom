<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\CayNhomBase;
use Yii;
use yii\bootstrap5\Html;

class CayNhom extends CayNhomBase
{ 
    /**
     * Gets query for [[CuaMauCuaNhoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaMauCuaNhoms()
    {
        return $this->hasMany(MauCuaNhom::class, ['id_cay_nhom' => 'id']);
    }
    
    /**
     * Gets query for [[HeNhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHeNhom()
    {
        return $this->hasOne(HeNhom::class, ['id' => 'id_he_nhom']);
    }
    
    /**
     * Gets query for [[CuaKhoNhoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTonKho()
    {
        return $this->hasMany(KhoNhom::class, ['id_cay_nhom' => 'id'])->orderBy(['chieu_dai' => SORT_DESC]);
    }
    
    /**
     * show action column for code attribute
     */
    public function getShowAction(){
        return Html::a($this->code,
            [Yii::getAlias('@web/maucua/cay-nhom/view'), 'id'=>$this->id],
            ['role'=>'modal-remote', 'class'=>'aInGrid']);
    }
    
    /**
     * kiem tra thanh nhom co trong kho khong
     * @param float $chieudai
     * @return int
     */
    public function checkTonKhoNhom($chieudai){
        $tonKho = KhoNhom::find()->where([
            'id_cay_nhom'=>$this->id,
            'chieu_dai'=>$chieudai
        ])->one();
        return $tonKho == null ? 0 : $tonKho->so_luong;
    }
}