<?php

namespace app\modules\maucua\models\base;

use Yii;
use app\modules\maucua\models\KhoNhomLichSu;
use app\custom\CustomFunc;
use app\modules\kho\models\base\KhoNhomQrBase;
use app\modules\kho\models\KhoNhomQr;
use Da\QrCode\QrCode;

/**
 * This is the model class for table "cua_kho_nhom".
 *
 * @property int $id
 * @property string|null $qr_code
 * @property int $id_cay_nhom
 * @property float $chieu_dai
 * @property int|null $so_luong
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaCayNhom $cayNhom
 * @property CuaKhoNhomLichSu[] $cuaKhoNhomLichSus
 */
class KhoNhomBase extends \app\models\CuaKhoNhom
{
    public $code;
    public $noiDung;//su dung de luu lich su khi them tai view caynhom

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cay_nhom', 'chieu_dai'], 'required'],
            [['noiDung'], 'required', 'on' => ['addTonKhoNhom', 'updateTonKhoNhom']],
            [['id_cay_nhom', 'so_luong', 'user_created'], 'integer'],
            [['chieu_dai'], 'number'],
            [['qr_code'], 'string', 'max' => 20],
            [['date_created', 'code', 'noiDung'], 'safe'],
            [['id_cay_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => CayNhomBase::class, 'targetAttribute' => ['id_cay_nhom' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'qr_code' => 'Code',
            'id_cay_nhom' => 'Cây nhôm',
            'chieu_dai' => 'Chiều dài',
            'so_luong' => 'Số lượng',
            'date_created' => 'Ngày tạo',
            'user_created' => 'Tài khoản',
            
            'code'=>'Mã cây nhôm',
            'noiDung'=>'Nội dung'
        ];
    }
    
    public function getRandomCode(){
        $cus = new CustomFunc();
        $code = rand(1,9) . $cus->generateRandomString();
        $khoNhomModel = KhoNhomBase::findOne(['qr_code'=>$code]);
        $khoNhomQrModel = KhoNhomQr::findOne(['qr_code'=>$code]);
        if($khoNhomModel == null && $khoNhomQrModel == null){
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
        }
        //set code
        if($this->qr_code == null){
            $this->qr_code = $this->getRandomCode();
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $history = new KhoNhomLichSu();
            $history->id_kho_nhom = $this->id;
            $history->so_luong = $this->so_luong;
            $history->so_luong_cu = 0;
            $history->so_luong_moi = $this->so_luong;
            $history->noi_dung = 'Cập nhật tồn kho do thêm mới dữ liệu kho nhôm ' . $this->noiDung;
            $history->save();
        } else {
            
        }
        //check qrcode
        if($this->qr_code != null){
            $qrPath = Yii::getAlias('@webroot/images/qr/') . $this->qr_code . '.png';
            if(!file_exists($qrPath)){
                $this->createQRcode($this->qr_code);
            }
        }
        
        return parent::afterSave($insert, $changedAttributes);
    } 
    
    /**
     * tao QR code cho 1 chuoi ky tu
     * @param string $folder // --> ex: /folder/abc/
     * @param string $string
     */
    public function createQRcode($string){
        $stringUrl = Yii::$app->params['webUrl'] . 'qr/view?code=' . $string;
        $qrPath = Yii::getAlias('@webroot/images/qr/') .$string;
        $qrCode = (new QrCode($stringUrl))
        // ->useLogo(Yii::getAlias('@webroot/uploads/qrlibs/'). 'logo.png')
        ->setSize(2000)
        ->setMargin(5)
        ->useForegroundColor(0, 0, 0);
        //->useForegroundColor(51, 153, 255);
        
        $qrCode->writeFile($qrPath . '.png');
    }

}
