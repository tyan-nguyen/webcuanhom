<?php

namespace app\modules\dungchung\models;


class CheckFile
{  
    public $allowNull=true;//important
    public $isNumber;
    public $minLeng;
    public $maxLeng;
    public $error = '';//save error message to return
    public $isCompare;//1
    public $valueCompare = array();//1
    public $isDuplicate;//2
    public $modelDuplicate;//2
    public $isExist;//3
    public $modelExist;//3
    
    public function checkVal($custom, $value=NULL){
       
        //kiem tra gia tri co cho phep null khong
        if($this->allowNull == false){
            if($value==null){
                $this->error = $custom . ' không được để trống!';
            }
        }
        
        //kiem tra gia tri thuoc kieu so
        if($this->isNumber == true){
            
            if(!is_numeric($value)){
                if($value == null){
                    if($this->allowNull == false){
                        $this->error = $custom . ' phải là số!';
                    }
                }else {
                    $this->error = $custom . ' phải là số!';
                }
            }
        }
        
        //kiem tra gia tri trong db co nam trong mag dang (1,2,3), ('A','B','C') khong
        if($this->isCompare == true){
            if(!in_array($value, $this->valueCompare)){
                if($this->allowNull == true){
                    if($value != NULL){
                        $this->error = $custom . ' không hợp lệ!';
                    }
                } else {
                    $this->error = $custom . ' không hợp lệ!';
                }
            }
        } 
        
        //kiem tra gia tri co ton tai trong db chua, neu co thi thong bao loi
        if($this->isDuplicate == true){
            if($this->modelDuplicate->count() > 0){
                $this->error = $custom . ' đã tồn tại!';
            }
        }
        
        //nguoc lai voi isDuplicate, kiem tra gia tri co ton tai trong db chua, neu khong co thi thong bao loi
        if($this->isExist == true){
            if($this->modelExist->count() == 0 ){
                if($this->allowNull == true ){
                    if($value != NULL){
                        $this->error = $custom . ' Mã trực thuộc không tồn tại!';
                    }
                } else {
                    $this->error = $custom . ' Mã trực thuộc không tồn tại!';
                }
            }
        }
        
        
        return $this->error;
    }
}