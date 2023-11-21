<?php

namespace app\modules\maucua\models;

use Yii;
use app\modules\dungchung\models\HinhAnh;
use yii\bootstrap5\Html;

class MauCua extends MauCuaBase
{
    /**
     * show action column for code attribute
     */
    public function getShowAction(){
        return Html::a($this->code,
            [Yii::getAlias('@web/maucua/mau-cua/view'), 'id'=>$this->id],
            ['role'=>'modal-remote']
        );
    }
    
    public function getHinhAnh(){
        $img = HinhAnh::findOne([
            'loai' => MauCua::MODEL_ID,
            'id_tham_chieu' => $this->id
        ]);
        return $img != null ? $img->ten_file_luu : null;
    }
    
    public function getImageUrl(){
        return Yii::getAlias('@web/uploads/images/'.$this->hinhAnh);
    }
}