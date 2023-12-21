<?php

namespace app\modules\kho\models;

use Yii;
use app\modules\kho\models\base\NhaCungCapBase;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class NhaCungCap extends NhaCungCapBase
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
     * lay danh sach don vi tinh de fill vao dropdownlist
     */
    public static function getList(){
        $list = NhaCungCap::find()->all();
        return ArrayHelper::map($list, 'id', 'ten_nha_cung_cap');
    }
    
    /***** /relation *****/
    /***** custom function *****/
    /***** /custom function *****/
    /***** virtual attributes *****/
    /**
     * show action column for code attribute
     */
    public function getShowAction(){
        return Html::a($this->code,
            [Yii::getAlias('@web/kho/nha-cung-cap/view'), 'id'=>$this->id],
            ['role'=>'modal-remote']
            );
    }
    /***** /virtual attributes *****/
}