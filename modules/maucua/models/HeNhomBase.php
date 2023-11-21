<?php

namespace app\modules\maucua\models;

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
class HeNhomBase extends \app\models\CuaHeNhom
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_he_nhom'], 'required'],
            [['ghi_chu'], 'string'],
            [['date_created'], 'safe'],
            [['user_created'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['ten_he_nhom'], 'string', 'max' => 255],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'ten_he_nhom' => 'Ten He Nhom',
            'ghi_chu' => 'Ghi Chu',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }
    
    public function getRandomCode(){
        $cus = new CustomFunc();
        $code = rand(1,9) . $cus->generateRandomString();
        $heNhomModel = HeNhomBase::findOne(['code'=>$code]);
        if($heNhomModel == null){
            return $code;
        } else {
            $this->getRandomCode();
        }
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
    
}
