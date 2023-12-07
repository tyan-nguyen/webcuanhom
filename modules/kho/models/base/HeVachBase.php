<?php

namespace app\modules\kho\models\base;

use Yii;
use app\custom\CustomFunc;

/**
 * @property int $id
 * @property string|null $code
 * @property string $ten_he_vach
 * @property string|null $ghi_chu
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaMauCuaVach[] $cuaMauCuaVaches
 */
class HeVachBase extends \app\models\CuaHeVach
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_he_vach'], 'required'],
            [['ghi_chu'], 'string'],
            [['date_created'], 'safe'],
            [['user_created'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['ten_he_vach'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Mã loại vách',
            'ten_he_vach' => 'Tên loại vách',
            'ghi_chu' => 'Ghi chú',
            'date_created' => 'Ngày tạo',
            'user_created' => 'Tài khoản',
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
        $nhaCungCapModel = HeVachBase::findOne(['code'=>$code]);
        if($nhaCungCapModel == null){
            return $code;
        } else {
            $this->getRandomCode();
        }
    }

    /**
     * Gets query for [[CuaMauCuaVaches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaMauCuaVaches()
    {
        return $this->hasMany(MauCuaVachBase::class, ['id_vach' => 'id']);
    }
}
