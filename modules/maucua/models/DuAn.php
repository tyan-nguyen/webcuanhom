<?php

namespace app\modules\maucua\models;

use Yii;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

class DuAn extends DuAnBase
{  
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