<?php

namespace app\modules\maucua\models\base;

use Yii;
use app\custom\CustomFunc;
use app\modules\maucua\models\KhoNhom;
use app\modules\maucua\models\KhoNhomLichSu;
use app\modules\maucua\models\HeNhom;
use app\modules\dungchung\models\Setting;

/**
 * @property int $id
 * @property int $id_he_nhom
 * @property string $code
 * @property string $ten_cay_nhom
 * @property int|null $so_luong
 * @property float|null $don_gia
 * @property float|null $khoi_luong
 * @property float|null $chieu_dai
 * @property int|null $for_cua_so
 * @property int|null $for_cua_di
 * @property float|null $min_allow_cut
 * @property float|null $min_allow_cut_under
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property MauCuaNhom[] $cuaMauCuaNhoms
 * @property HeNhom $heNhom
 */
class CayNhomBase extends \app\models\CuaCayNhom
{    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_he_nhom', 'ten_cay_nhom'], 'required'],
            [['id_he_nhom', 'so_luong', 'for_cua_so', 'for_cua_di', 'user_created'], 'integer'],
            [['don_gia', 'khoi_luong', 'chieu_dai', 'do_day', 'min_allow_cut', 'min_allow_cut_under'], 'number'],
            [['date_created'], 'safe'],
            [['code'], 'string', 'max' => 20],
            [['ten_cay_nhom'], 'string', 'max' => 255],
            [['id_he_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => HeNhomBase::class, 'targetAttribute' => ['id_he_nhom' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_he_nhom' => 'Hệ nhôm',
            'code' => 'Mã cây nhôm',
            'ten_cay_nhom' => 'Tên cây nhôm',
            'so_luong' => 'Số lượng',
            'don_gia' => 'Đơn giá',
            'khoi_luong' => 'Khối lượng',
            'chieu_dai' => 'Chiều dài',
            'do_day' => 'Độ dày',
            'for_cua_so' => 'Sử dụng cho hệ cửa sổ',
            'for_cua_di' => 'Sử dụng cho hệ cửa đi',
            'min_allow_cut' => 'Chặn trên',
            'min_allow_cut_under' => 'Chặn dưới',
            'date_created' => 'Ngày tạo',
            'user_created' => 'Tài khoản',
        ];
    }
    
    public function getRandomCode(){
        $cus = new CustomFunc();
        $code = rand(1,9) . $cus->generateRandomString();
        $loaiCuaModel = CayNhomBase::findOne(['code'=>$code]);
        if($loaiCuaModel == null){
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
            $setting = Setting::find()->one();
            $this->date_created = date('Y-m-d H:i:s');
            $this->user_created = Yii::$app->user->id;
            //set default chieu dai
            if($this->chieu_dai == NULL || $this->chieu_dai == 0){
                $this->chieu_dai = $setting->chieu_dai_nhom_mac_dinh!=null?$setting->chieu_dai_nhom_mac_dinh:0;//set lai theo cau hinh bang setting
            }
            
            //set default trang thai
            if($this->so_luong == null){
                $this->so_luong = 0;
            }
            if($this->don_gia == null){
                $this->don_gia = 0;
            }
            if($this->khoi_luong == null){
                $this->khoi_luong = 0;
            }
            if($this->chieu_dai == null){
                $this->chieu_dai = 0;
            }
            if($this->for_cua_so == null){
                $this->for_cua_so = 0;
            }
            if($this->for_cua_di == null){
                $this->for_cua_di = 0;
            }
            if($this->min_allow_cut == null){
                $this->min_allow_cut = 0;
            }
            if($this->min_allow_cut_under == null){
                $this->min_allow_cut_under = 0;
            }
            //set code
            if($this->code == null){
                $this->code = $this->getRandomCode();
            }
            //set do_day
            if($this->do_day == null){
                $heNhom = HeNhom::findOne($this->id_he_nhom);
                $this->do_day = $heNhom->do_day_mac_dinh;
            }
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {        
            $tonKho = new KhoNhom();
            $tonKho->id_cay_nhom = $this->id;
            $tonKho->so_luong = $this->so_luong;
            $tonKho->chieu_dai = $this->chieu_dai;
            $tonKho->noiDung = '- Thêm cây nhôm mới';
            $tonKho->save();
            
            /*sau khi them kho nhom thi aftersave se tu them ton kho*/
           /*  $lichSuTonKho = new KhoNhomLichSu();
            $lichSuTonKho->id_kho_nhom = $tonKho->id;
            $lichSuTonKho->so_luong = $tonKho->so_luong;
            $lichSuTonKho->noi_dung = 'Nhập số lượng khi thêm mới cây nhôm #'.$this->code;
            $lichSuTonKho->id_mau_cua = null;
            $lichSuTonKho->save(); */
        }
       return parent::afterSave($insert, $changedAttributes);
    } 
    
}
