<?php

namespace app\modules\maucua\models\base;

use Yii;
use app\custom\CustomFunc;
use app\modules\maucua\models\HeNhomMau;

/**
 * @property int $id
 * @property string|null $code
 * @property string $ten_he_nhom
 * @property int|null $xuat_xu
 * @property string|null $hang_san_xuat
 * @property string|null $nha_cung_cap
 * @property float|null $do_day_mac_dinh
 * @property string|null $ghi_chu
 * @property string|null $date_created
 * @property int|null $user_created
 */
class HeNhomBase extends \app\models\CuaHeNhom
{
    public $mauNhom; //màu nhôm arr
    public $mauMacDinhInput; //sử dụng trong form HeNhom
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_he_nhom', 'code', 'do_day_mac_dinh'], 'required'],
            [['do_day_mac_dinh'], 'number'],
            [['ghi_chu'], 'string'],
            [['date_created', 'mauNhom', 'mauMacDinhInput'], 'safe'],
            [['user_created', 'xuat_xu'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['ten_he_nhom'], 'string', 'max' => 255],
            [['hang_san_xuat', 'nha_cung_cap'], 'string', 'max' => 200],
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
            'xuat_xu' => 'Xuất xứ',
            'hang_san_xuat' => 'Hãng sản xuất',
            'nha_cung_cap' => 'Nhà cung cấp',
            'do_day_mac_dinh' => 'Độ dày mặc định',
            'ghi_chu' => 'Ghi chú',
            'date_created' => 'Ngày tạo',
            'user_created' => 'Tài khoản',
            'mauNhom' => 'Màu nhôm',
            'mauMacDinhInput' => 'Màu mặc định'
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
    
    public function resetMauMacDinh(){
        $heNhomMau = HeNhomMau::find()->where(['id_he_nhom'=>$this->id])->all();
        if($heNhomMau != null){
            foreach ($heNhomMau as $mau){
                $mau->is_mac_dinh = 0;
                $mau->save();
            }
        }
    }
    
}
