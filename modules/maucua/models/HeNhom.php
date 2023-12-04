<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\HeNhomBase;
use Yii;
use app\custom\CustomFunc;

/**
 * @property int $id
 * @property string|null $code
 * @property string $ten_he_nhom
 * @property string|null $ghi_chu
 * @property string|null $date_created
 * @property int|null $user_created
 */
class HeNhom extends HeNhomBase
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
}