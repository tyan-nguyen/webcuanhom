<?php

namespace app\modules\maucua\models;

use app\custom\CustomFunc;

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
}