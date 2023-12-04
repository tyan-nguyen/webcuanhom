<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\DuAnBase;
use Yii;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;


class DuAn extends DuAnBase
{  
    /**
     * Gets query for [[DuAnChiTiet]].
     * chuan bi deleete vi doi mo hinh
     * @return \yii\db\ActiveQuery
     */
    public function getDuAnChiTiet()
    {
        return $this->hasMany(DuAnChiTiet::class, ['id_du_an' => 'id']);
    }
    
    /**
     * Gets query for [[MauCua]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMauCuas()
    {
        return $this->hasMany(MauCua::class, ['id_du_an' => 'id']);
    }
    
    /**
     * lay danh sach tat ca du an
     * @return array
     */
    public static function getList(){
        $list = DuAn::find()->all();
        return ArrayHelper::map($list, 'id', 'ten_du_an');
    }
    /**
     * show action column for code attribute
     */
    public function getShowAction(){
        return Html::a($this->code, 
            [Yii::getAlias('@web/maucua/du-an/view'), 'id'=>$this->id],
            [ 'role'=>'modal-remote' /* 'target'=>'_blank', 'data-pjax'=>0 */
        ]);
    }
    /**
     * lay ten mau thiet ke
     * @return string
     */
    public function getMauThietKe(){
        return $this->getDmThietKeLabel($this->code_mau_thiet_ke);
    }
    /**
     * lay ten trang thai
     * @return string
     */
    public function getTrangThai(){
        return $this->getDmTrangThaiLabel($this->trang_thai);
    }
}