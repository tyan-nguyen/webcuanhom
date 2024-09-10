<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\CayNhomBase;
use Yii;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

class CayNhom extends CayNhomBase
{ 
    /**
     * Gets query for [[CuaMauCuaNhoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaMauCuaNhoms()
    {
        return $this->hasMany(MauCuaNhom::class, ['id_cay_nhom' => 'id']);
    }
    
    /**
     * Gets query for [[HeNhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHeNhom()
    {
        return $this->hasOne(HeNhom::class, ['id' => 'id_he_nhom']);
    }
    
    /**
     * Gets query for [[HeMau]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHeMau()
    {
        return $this->hasOne(HeMau::class, ['id' => 'id_he_mau']);
    }
    
    /**
     * Gets query for [[CuaKhoNhoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTonKho()
    {
        return $this->hasMany(KhoNhom::class, ['id_cay_nhom' => 'id'])->orderBy(['chieu_dai' => SORT_DESC]);
    }
    
    /**
     * show action column for code attribute
     */
    public function getShowAction(){
        return Html::a($this->codeByColor,
            [Yii::getAlias('@web/maucua/cay-nhom/view'), 'id'=>$this->id],
            ['role'=>'modal-remote', 'class'=>'aInGrid']);
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
    
    /**
     * get so luong ton kho cua cay nhom moi nguyen cay
     *
     */
    public function getSoLuongNhomMoi()
    {
        $tonKho = $this->getTonKho()->where(['chieu_dai'=>$this->chieu_dai])->one();
        return $tonKho != null ? $tonKho->so_luong : 0;
    }    
    /**
     * lay danh sach cay nhom su dung duoc cho nhieu he nhom de fill vao dropdownlist
     */
    public static function getListForMulti(){
        $list = CayNhom::find()/* ->select([
            'id',
            'ten_cay_nhom as ten',
            'code',
            "CONCAT(code, ' (', ten_cay_nhom, ')') as ten_cay_nhom"
        ]) */->where([
            'dung_cho_nhieu_he_nhom'=>1
        ])->all();
        return ArrayHelper::map($list, 'id', function($model) {
            return $model->code . ' - ' . $model->tenCayNhomByColor;
        });
    }
    
    /**
     * hien thi code nhom va ten cay nhom by color
     */
    public function getCodeByColor(){
        if($this->heMau != null){
            return $this->code . ' (' . $this->heMau->code . ')';
        } else {
            return $this->code;
        }
    }
    public function getTenCayNhomByColor(){
        if($this->heMau != null){
            return $this->ten_cay_nhom . ' (' . $this->heMau->code . ')';
        } else {
            return $this->ten_cay_nhom;
        }
    }
    public function getShowColor(){
        if($this->heMau != null){
            return '<span style="background-color:'.$this->heMau->ma_mau.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
        } else {
            return '';
        }
    }
}