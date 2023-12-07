<?php

namespace app\modules\kho\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\kho\models\base\HeVachBase;
use yii\helpers\Html;

class HeVach extends HeVachBase
{
    /**
     * lay danh sach he vach de fill vao dropdownlist
     */
    public static function getList(){
        $list = HeVach::find()->all();
        return ArrayHelper::map($list, 'id', 'ten_he_vach');
    }
    
    public function getShowAction(){
        return Html::a($this->code,
                [Yii::getAlias('@web/kho/he-vach/view'), 'id'=>$this->id],
                ['role'=>'modal-remote']
            );
    }
}