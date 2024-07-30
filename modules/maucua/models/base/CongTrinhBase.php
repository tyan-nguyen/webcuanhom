<?php

namespace app\modules\maucua\models\base;

use Yii;
use app\custom\CustomFunc;
use app\modules\dungchung\models\Setting;
use app\modules\maucua\models\CongTrinhSettings;
use app\modules\banle\models\KhachHang;

/**
 * This is the model class for table "cua_cong_trinh".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten_cong_trinh
 * @property int|null $id_khach_hang
 * @property string|null $dia_diem
 * @property string|null $ngay_bat_dau
 * @property string|null $ngay_hoan_thanh
 * @property string|null $ghi_chu
 * @property string|null $code_mau_thiet_ke
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaMauCua[] $cuaMauCuas
 * @property BanleKhachHang $khachHang
 */
class CongTrinhBase extends \app\models\CuaCongTrinh
{
    const MODEL_ID = 'cong-trinh';
    //public $nhomDu;//su dung trong form nhap nhom du
    public $khsx;//dung trong form them vao ke hoach
    public $idKeHoach;//dung trong form them vao ke hoach
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
    /* public static function getDmTrangThai(){
        return [
            'KHOI_TAO'=>'Khởi tạo',
            'THUC_HIEN'=>'Đang thực hiện',//for toi uu theo mau cua
            'TOI_UU'=>'Đã tối ưu',
            'DA_XUAT_KHO'=>'Đã hoàn thành',
            'DA_NHAP_KHO'=>'Đã nhập kho',
            'HOAN_THANH'=>'Đã hoàn thành'
        ];
    } */
    
    /**
     * Danh muc Loai Kho luu tru label
     * @param int $val
     * @return string
     */
    /* public static function getDmTrangThaiLabel($val){
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
    } */
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_cong_trinh'], 'required'],
            [['id_khach_hang', 'user_created', 'khsx', 'idKeHoach'], 'integer'],
            [['ngay_bat_dau', 'ngay_hoan_thanh', 'date_created'], 'safe'],
            [['ghi_chu'], 'string'],
            [['code', 'code_mau_thiet_ke'], 'string', 'max' => 20],
            [['ten_cong_trinh'], 'string', 'max' => 255],
            [['dia_diem'], 'string', 'max' => 200],
            [['id_khach_hang'], 'exist', 'skipOnError' => true, 'targetClass' => KhachHang::class, 'targetAttribute' => ['id_khach_hang' => 'id']],
            [['idKeHoach'], 'required', 'on'=>'add-ke-hoach'], //on add mau cua vao ke hoach
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [            
            'id' => 'ID',
            'code' => 'Mã công trình',
            'ten_cong_trinh' => 'Tên công trình',
            'id_khach_hang' => 'Thuộc khách hàng',
            'dia_diem' => 'Địa điểm',
            'ngay_bat_dau' => 'Ngày bắt đầu',
            'ngay_hoan_thanh' => 'Ngày hoàn thành',
            'ghi_chu' => 'Ghi chú',
            'code_mau_thiet_ke' => 'Phiên bản mẫu thiết kế',
            'date_created' => 'Ngày tạo dữ liệu',
            'user_created' => 'Người tạo dữ liệu',
            
            'tenKhachHang' => 'Tên khách hàng',
            'diaChiKhachHang' => 'Địa chỉ khách hàng',
            'sdtKhachHang' => 'Số điện thoại khách hàng',
            'emailKhachHang' => 'Email khách hàng',
            'idKeHoach' => 'Chọn Kế hoạch sản xuất',
        ];
    }
    
    public function getRandomCode(){
        $cus = new CustomFunc();
        $code = rand(1,9) . $cus->generateRandomString();
        $congTrinhModel = CongTrinhBase::findOne(['code'=>$code]);
        if($congTrinhModel == null){
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
            /* if($this->trang_thai == null){
                $this->trang_thai = 'KHOI_TAO';
            } */
            //set code
            if($this->code == null){
                $this->code = $this->getRandomCode();
            }
            //set loai toi uu
            /* if($this->toi_uu_tat_ca == null){
                $this->toi_uu_tat_ca = 0;
            } */
        }
        //set date
        $custom = new CustomFunc();
        if($this->ngay_bat_dau !=null){
            $this->ngay_bat_dau = $custom->convertDMYToYMD($this->ngay_bat_dau);
        }
        if($this->ngay_hoan_thanh !=null){
            $this->ngay_hoan_thanh = $custom->convertDMYToYMD($this->ngay_hoan_thanh);
        }
        
        return parent::beforeSave($insert);
    }
    
    /**
     * {@inheritdoc}
     */
    /* public function afterSave( $insert, $changedAttributes ){
        parent::afterSave($insert, $changedAttributes);
        //create mau cua - setting
        $globalSetting = Setting::find()->one();
        if($this->setting == NULL){
            $setModel = new DuAnSettings();
            $setModel->id_du_an = $this->id;
            $setModel->vet_cat = $globalSetting->vet_cat != null ? $globalSetting->vet_cat : 0;
            $setModel->save();
        }
    } */
    
}
