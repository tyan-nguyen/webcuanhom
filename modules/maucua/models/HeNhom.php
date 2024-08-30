<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\HeNhomBase;
use Yii;
use app\custom\CustomFunc;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use app\modules\kho\models\XuatXu;
use yii\db\Expression;

class HeNhom extends HeNhomBase
{
    /**
     * Gets query for [[HeNhomMau]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMauNhoms()
    {
        return $this->hasMany(HeNhomMau::class, ['id_he_nhom' => 'id']);
    }
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
     * lấy màu mặc định
     */
    public function getMauMacDinh(){
        $mauMD = HeNhomMau::find()->where(['id_he_nhom'=>$this->id, 'is_mac_dinh'=>1])->one();
        if($mauMD != null){
            return $mauMD->mau;
        } else {
            return null;
        }
    }
    /**
     * lay danh sach he nhom de fill vao dropdownlist (id->ten)
     */
    public static function getList(){
        $list = HeNhom::find()->select([
            'id', 
            'ten_he_nhom as ten_he', 
            'code',             
            "CONCAT(code, ' (', ten_he_nhom, ')') as ten_he_nhom"
        ])->all();
        return ArrayHelper::map($list, 'id', 'ten_he_nhom');
    }
    /**
     * lay danh sach color cua he nhom de fill vao dropdownlist (id->ten)
     */
    public static function getListByHeNhom($id){
        $list = HeNhomMau::find()->alias('t')->joinWith(['mau as hm'])->select([
            't.*',
            'hm.ten_he_mau as ten_he',
            'hm.code as code_he_mau',
            "CONCAT(hm.code, ' (', hm.ten_he_mau, ')') as ten_he_mau"
        ])->where(['id_he_nhom'=>$id])->all();
        return ArrayHelper::map($list, 'id_he_mau', 'ten_he_mau');
    }
    /**
     * lay danh sach he nhom de fill vao dropdownlist (code -> ten)
     */
    public function getListCode(){
        $list = HeNhom::find()->select('*'
            //['*', 'code as code1', "CONCAT(code, ' ', ten_he_nhom) as xxx"]
            )/* ->addSelect(['code as code1']) */->all();
        return ArrayHelper::map($list, 'code', 'ten_he_nhom');
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
    /**
     * show cảnh báo
     */
    public function getWarning(){
        $warning = false;
        if(!$this->mauNhoms || !$this->mauMacDinh)
            $warning = true;
        return $warning;
    }
}