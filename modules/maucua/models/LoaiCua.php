<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\LoaiCuaBase;
use app\custom\CustomFunc;
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class LoaiCua extends LoaiCuaBase
{
    /** 
     * virtual attribute
     * hien thi thoi gian luu  
    */
    public function getThoiGianLuu(){
        $cus = new CustomFunc();
        return $cus->convertYMDHISToDMYHIS($this->date_created);
    }
    /**
     * virtual attribute
     * hien thi nguoi luu
     */
    public function getNguoiLuu(){
        $cus = new CustomFunc();
        return $cus->getTenTaiKhoan($this->user_created);
    }
    
    /**
     * show action column for code attribute
     */
    public function getShowAction(){
        return Html::a($this->code,
            [Yii::getAlias('@web/maucua/loai-cua/view'), 'id'=>$this->id],
            ['role'=>'modal-remote', 'class'=>'aInGrid'
            ]);
    }
    /**
     * lay danh sach don vi tinh de fill vao dropdownlist
     */
    public static function getList(){
        $list = LoaiCua::find()->all();
        return ArrayHelper::map($list, 'id', 'ten_loai_cua');
    }
}