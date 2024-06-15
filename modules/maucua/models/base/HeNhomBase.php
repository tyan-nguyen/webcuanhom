<?php

namespace app\modules\maucua\models\base;

use Yii;
use app\custom\CustomFunc;

/**
 * @property int $id
 * @property string|null $code
 * @property string $ten_he_nhom
 * @property float|null $do_day_mac_dinh
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
            [['ten_he_nhom', 'code', 'do_day_mac_dinh'], 'required'],
            [['do_day_mac_dinh'], 'number'],
            [['ghi_chu'], 'string'],
            [['date_created'], 'safe'],
            [['user_created'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['ten_he_nhom'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Mã hệ nhôm',
            'ten_he_nhom' => 'Tên hệ nhôm',
            'do_day_mac_dinh' => 'Độ dày mặc định',
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
            //set do day mac dinh
            if($this->do_day_mac_dinh == null){
                $this->do_day_mac_dinh = 0;
            }
        }
        return parent::beforeSave($insert);
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
    
}
