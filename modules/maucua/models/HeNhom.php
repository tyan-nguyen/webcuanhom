<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\HeNhomBase;
use Yii;
use app\custom\CustomFunc;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use app\modules\kho\models\XuatXu;

class HeNhom extends HeNhomBase
{
    /**
     * Gets query for [[XuatXu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getXuatXu()
    {
        if($this->xuat_xu == null){
            $this->xuat_xu = 1;//1 is chua-phan-loai
            if($this->save()){
                $this->refresh();
            }
        }
        return $this->hasOne(XuatXu::class, ['id' => 'xuat_xu']);
    }
    /**
     * lay danh sach don vi tinh de fill vao dropdownlist
     */
    public static function getList(){
        $list = HeNhom::find()->all();
        return ArrayHelper::map($list, 'id', 'ten_he_nhom');
    }
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
            [Yii::getAlias('@web/maucua/he-nhom/view'), 'id'=>$this->id],
            ['role'=>'modal-remote', 'class'=>'aInGrid'
            ]);
    }
}