<?php

namespace app\modules\kho\models\base;

use Yii;
use app\custom\CustomFunc;
use app\modules\maucua\models\KhoNhom;
use app\modules\maucua\models\NhomSuDung;

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
class KhoNhomQrBase extends \app\models\CuaKhoNhomQr
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kho_nhom', 'id_nhom_su_dung'], 'required'],
            [['id_kho_nhom', 'id_nhom_su_dung', 'user_created'], 'integer'],
            [['date_created'], 'safe'],
            [['qr_code'], 'string', 'max' => 20],
            [['id_kho_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => KhoNhom::class, 'targetAttribute' => ['id_kho_nhom' => 'id']],
            [['id_nhom_su_dung'], 'exist', 'skipOnError' => true, 'targetClass' => NhomSuDung::class, 'targetAttribute' => ['id_nhom_su_dung' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_kho_nhom' => 'ID Kho nhôm',
            'id_nhom_su_dung' => 'ID Nhôm sử dụng',
            'qr_code' => 'Qr Code',
            'user_created' => 'Người tạo',
            'date_created' => 'Ngày tạo',
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
            if($this->qr_code == null){
                $this->qr_code = $this->getRandomCode();
            }
        }
        return parent::beforeSave($insert);
    }
    
    public function getRandomCode(){
        $cus = new CustomFunc();
        $code = rand(1,9) . $cus->generateRandomString();
        $khoNhomQrModel = KhoNhomQrBase::findOne(['qr_code'=>$code]);
        $khoNhomMode = KhoNhom::findOne(['qr_code'=>$code]);
        if($khoNhomQrModel == null && $khoNhomMode == NULL){
            return $code;
        } else {
            $this->getRandomCode();
        }
    }
    
}