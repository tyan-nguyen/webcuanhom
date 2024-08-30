<?php

namespace app\modules\maucua\models;

use Yii;
use app\custom\CustomFunc;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class HeMau extends \app\models\CuaHeMau
{  
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_he_mau', 'ma_mau'], 'required'],
            [['for_nhom', 'for_phu_kien', 'user_created'], 'integer'],
            [['date_created'], 'safe'],
            [['code', 'ma_mau'], 'string', 'max' => 20],
            [['ten_he_mau'], 'string', 'max' => 200],
            [['code'], 'unique'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->date_created = date('Y-m-d H:i:s');
            $this->user_created = Yii::$app->user->id;
            //set code
            if($this->code == null){
                $this->code = $this->getRandomCode();
            }
        }
        return parent::beforeSave($insert);
    }
    
    public function getRandomCode(){
        $cus = new CustomFunc();
        $code = rand(1,9) . $cus->generateRandomString();
        $loaiCuaModel = HeMau::findOne(['code'=>$code]);
        if($loaiCuaModel == null){
            return $code;
        } else {
            $this->getRandomCode();
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'ten_he_mau' => 'Tên hệ màu',
            'ma_mau' => 'Mã màu',
            'for_nhom' => 'Sử dụng cho hệ nhôm',
            'for_phu_kien' => 'Sử dụng cho phụ kiện',
            'date_created' => 'Ngày tạo',
            'user_created' => 'Người tạo',
        ];
    }
    
    /**
     * Gets query for [[CuaCayNhoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaCayNhoms()
    {
        return $this->hasMany(CayNhom::class, ['id_he_mau' => 'id']);
    }
    
    /**
     * Gets query for [[CuaHeNhomMaus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaHeNhomMaus()
    {
        return $this->hasMany(HeNhomMau::class, ['id_mau' => 'id']);
    }
    
    /**
     * show action column for code attribute
     */
    public function getShowAction(){
        return Html::a($this->code,
            [Yii::getAlias('@web/maucua/he-mau/view'), 'id'=>$this->id],
            ['role'=>'modal-remote', 'class'=>'aInGrid']);
    }
    
    /**
     * lay danh sach cho phu kien de fill vao dropdownlist
     */
    public static function getListByPhuKien(){
        $list = HeMau::find()->select([
            'id',
            'ten_he_mau as ten_he',
            'code',
            "CONCAT(code, ' (', ten_he_mau, ')') as ten_he_mau"
        ])->where(['for_phu_kien'=>1])->all();
        return ArrayHelper::map($list, 'id', 'ten_he_mau');
    }
}