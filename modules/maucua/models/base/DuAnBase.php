<?php

namespace app\modules\maucua\models\base;

use Yii;
use app\custom\CustomFunc;
use app\modules\dungchung\models\Setting;
use app\modules\maucua\models\DuAnSettings;

/**
 * @property int $id
 * @property string|null $code
 * @property string $ten_du_an
 * @property string|null $ten_khach_hang
 * @property string|null $dia_chi
 * @property string|null $so_dien_thoai
 * @property string|null $email
 * @property string|null $trang_thai
 * @property int|null $toi_uu_tat_ca
 * @property string|null $ngay_bat_dau_thuc_hien
 * @property string|null $ngay_hoan_thanh_du_an
 * @property string|null $ghi_chu
 * @property string|null $code_mau_thiet_ke
 * @property string|null $date_created
 * @property int|null $user_created
 */
class DuAnBase extends \app\models\CuaDuAn
{  
    const MODEL_ID = 'du-an';
    public $nhomDu;//su dung trong form nhap nhom du
    public $vMauCua;//dung trong form them mau cua vao ke hoach
    /**
     * Danh muc mau thiet ke (file excel)
     * @return string[]
     */
    public static function getDmThieKe(){
        return [
            'VER.230928'=>'Phiên bản 28.09.2023'
        ];
    }
    
    /**
     * Danh muc Mau thiet ke label
     * @param int $val
     * @return string
     */
    public static function getDmThietKeLabel($val){
        $label = '';
        if($val == 'VER.230928'){
            $label = 'Phiên bản 28.09.2023';
        }
        return $label;
    }
    /**
     * Danh muc trang thai du an
     * @return string[]
     */
    public static function getDmTrangThai(){
        return [
            'KHOI_TAO'=>'Khởi tạo',
            'THUC_HIEN'=>'Đang thực hiện',//for toi uu theo mau cua
            'TOI_UU'=>'Đã tối ưu',
            'DA_XUAT_KHO'=>'Đã hoàn thành',
            'DA_NHAP_KHO'=>'Đã nhập kho',
            'HOAN_THANH'=>'Đã hoàn thành'
        ];
    }
    
    /**
     * Danh muc Loai Kho luu tru label
     * @param int $val
     * @return string
     */
    public static function getDmTrangThaiLabel($val){
        $label = '';
        if($val == 'KHOI_TAO'){
            $label = 'Khởi tạo';
        }else if($val == 'THUC_HIEN'){
            $label = 'Đang thực hiện';
        }else if($val == 'TOI_UU'){
            $label = 'Đã tối ưu';
        }else if($val == 'DA_XUAT_KHO'){
            $label = 'Đã xuất kho';
        }else if($val == 'DA_NHAP_KHO'){
            $label = 'Đã nhập kho';
        }else if($val == 'HOAN_THANH'){
            $label = 'Đã hoàn thành';
        }
        return $label;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_du_an'], 'required'],
            [['dia_chi', 'ghi_chu'], 'string'],
            [['ngay_bat_dau_thuc_hien', 'ngay_hoan_thanh_du_an', 'date_created', 'nhomDu', 'vMauCua'], 'safe'],
            [['toi_uu_tat_ca', 'user_created'], 'integer'],
            [['ten_du_an', 'email'], 'string', 'max' => 255],
            [['ten_khach_hang'], 'string', 'max' => 100],
            [['so_dien_thoai'], 'string', 'max' => 11],
            [['code', 'code_mau_thiet_ke', 'trang_thai'], 'string', 'max' => 20],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Mã Kế hoạch',
            'ten_du_an' => 'Tên Kế hoạch',
            //'ten_khach_hang' => 'Tên Khách hàng',
            //'dia_chi' => 'Địa chỉ',
            //'so_dien_thoai' => 'SĐT',
            //'email' => 'Email',
            'trang_thai' => 'Trạng thái',
            'toi_uu_tat_ca' => 'Tối ưu toàn Kế hoạch',
            'ngay_bat_dau_thuc_hien' => 'Ngày bắt đầu thực hiện',
            'ngay_hoan_thanh_du_an' => 'Ngày hoàn thành',
            'ghi_chu' => 'Ghi chú',
            'code_mau_thiet_ke' => 'Phiên bản mẫu thiết kế',
            'date_created' => 'Ngày tạo dữ liệu',
            'user_created' => 'Người tạo dữ liệu',
        ];
    }
    
    public function getRandomCode(){
        $cus = new CustomFunc();
        $code = rand(1,9) . $cus->generateRandomString();
        $loaiCuaModel = DuAnBase::findOne(['code'=>$code]);
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
            $this->date_created = date('Y-m-d H:i:s');
            $this->user_created = Yii::$app->user->id;
            //set default trang thai
            if($this->trang_thai == null){
                $this->trang_thai = 'KHOI_TAO';
            }
            //set code
            if($this->code == null){
                $this->code = $this->getRandomCode();
            }
            //set loai toi uu
            if($this->toi_uu_tat_ca == null){
                $this->toi_uu_tat_ca = 0;
            }
        }
        //set date
        $custom = new CustomFunc();
        if($this->ngay_bat_dau_thuc_hien !=null){
            $this->ngay_bat_dau_thuc_hien = $custom->convertDMYToYMD($this->ngay_bat_dau_thuc_hien);
        }
        if($this->ngay_hoan_thanh_du_an !=null){
            $this->ngay_hoan_thanh_du_an = $custom->convertDMYToYMD($this->ngay_hoan_thanh_du_an);
        }
        
        return parent::beforeSave($insert);
    }
    
    /**
     * {@inheritdoc}
     */
    public function afterSave( $insert, $changedAttributes ){
        parent::afterSave($insert, $changedAttributes);
        //create mau cua - setting
        $globalSetting = Setting::find()->one();
        if($this->setting == NULL){
            $setModel = new DuAnSettings();
            $setModel->id_du_an = $this->id;
            $setModel->vet_cat = $globalSetting->vet_cat != null ? $globalSetting->vet_cat : 0;
            $setModel->save();
        }
    }

}
