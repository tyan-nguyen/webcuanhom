<?php

namespace app\modules\kho\models\base;

use Yii;
use app\custom\CustomFunc;

/**
 * @property int $id
 * @property string|null $code
 * @property string $ten_nha_cung_cap
 * @property string|null $dia_chi
 * @property string|null $date_created
 * @property int|null $user_created
 */
class NhaCungCapBase extends \app\models\CuaKhoVatTuNhaCungCap
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_nha_cung_cap'], 'required'],
            [['dia_chi'], 'string'],
            [['date_created'], 'safe'],
            [['user_created'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['ten_nha_cung_cap'], 'string', 'max' => 255],
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
            'ten_nha_cung_cap' => 'Ten Nha Cung Cap',
            'dia_chi' => 'Dia Chi',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
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
        $nhaCungCapModel = NhaCungCapBase::findOne(['code'=>$code]);
        if($nhaCungCapModel == null){
            return $code;
        } else {
            $this->getRandomCode();
        }
    }
}
