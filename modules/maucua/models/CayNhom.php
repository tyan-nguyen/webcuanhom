<?php

namespace app\modules\maucua\models;

use Yii;
use yii\bootstrap5\Html;

class CayNhom extends CayNhomBase
{    
    /**
     * show action column for code attribute
     */
    public function getShowAction(){
        return Html::a($this->code,
            [Yii::getAlias('@web/maucua/cay-nhom/view'), 'id'=>$this->id],
            ['role'=>'modal-remote'
            ]);
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