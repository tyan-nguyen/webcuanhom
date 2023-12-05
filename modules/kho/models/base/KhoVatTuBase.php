<?php

namespace app\modules\kho\models\base;

use Yii;
use app\custom\CustomFunc;

/**
 * @property int $id
 * @property string|null $code
 * @property string $ten_vat_tu
 * @property int|null $id_nhom_vat_tu
 * @property int|null $la_phu_kien
 * @property float|null $so_luong
 * @property string $dvt
 * @property float|null $don_gia
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaKhoVatTuLichSu[] $cuaKhoVatTuLichSus
 */
class KhoVatTuBase extends \app\models\CuaKhoVatTu
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_vat_tu', 'dvt'], 'required'],
            [['id_nhom_vat_tu', 'la_phu_kien', 'user_created'], 'integer'],
            [['so_luong', 'don_gia'], 'number'],
            [['date_created'], 'safe'],
            [['code', 'dvt'], 'string', 'max' => 20],
            [['ten_vat_tu'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Mã hàng hóa',
            'ten_vat_tu' => 'Ten Vat Tu',
            'id_nhom_vat_tu' => 'Id Nhom Vat Tu',
            'la_phu_kien' => 'La Phu Kien',
            'so_luong' => 'So Luong',
            'dvt' => 'Dvt',
            'don_gia' => 'Don Gia',
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
        $khoVatTuModel = KhoVatTuBase::findOne(['code'=>$code]);
        if($khoVatTuModel == null){
            return $code;
        } else {
            $this->getRandomCode();
        }
    }

}
