<?php

namespace app\modules\banle\models\base;

use Yii;
use app\models\BanleHoaDon;

/**
 * This is the model class for table "banle_hoa_don".
 *
 * @property int $id
 * @property int|null $ma_hoa_don
 * @property int|null $so_vao_so
 * @property int|null $nam
 * @property string|null $ghi_chu
 * @property string|null $ngay_ban
 * @property int|null $id_nguoi_lap
 * @property int|null $id_nguoi_lap
 * @property string|null $ngay_lap
 * @property string|null $trang_thai
 * @property int|null $edit_mode
 * @property int|null $id_khach_hang
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property BanleHoaDonChiTiet[] $banleHoaDonChiTiets
 */
class HoaDonBase extends BanleHoaDon
{
    const MODEL_ID = 'hoadonbanle';
    /**
     * Danh muc trang thai hoa don
     * @return string[]
     */
    public static function getDmTrangThai(){
        return [
            'BAN_NHAP'=>'Bản nháp',
            //'CHUA_THANH_TOAN'=>'Chưa thanh toán',
            'DA_THANH_TOAN'=>'Đã xuất',
        ];
    }
    /**
     * Danh muc trang thai phieu xuat kho label
     * @param int $val
     * @return string
     */
    public static function getDmTrangThaiLabel($val){
        $label = '';
        if($val == 'BAN_NHAP'){
            $label = 'Bản nháp';
        }else if($val == 'CHUA_THANH_TOAN'){
            $label = 'Chưa thanh toán';
        }else if($val == 'DA_THANH_TOAN'){
            $label = 'Đã xuất';
        }
        return $label;
    }
    
    /**
     * danh muc trang thai da vo so phieu
     */
    public static function getDmTrangThaiCoSoHoaDon(){
        return [
            'CHUA_THANH_TOAN',
            'DA_THANH_TOAN'
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma_hoa_don', 'so_vao_so', 'nam', 'id_nguoi_ban', 'id_nguoi_lap', 'user_created', 'edit_mode', 'id_khach_hang'], 'integer'],
            [['ghi_chu'], 'string'],
            [['ngay_ban', 'ngay_lap', 'date_created'], 'safe'],
            [['trang_thai'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma_hoa_don' => 'Mã hóa đơn',
            'so_vao_so' => 'Số vào sổ',
            'nam' => 'Năm vào sổ',
            'ghi_chu' => 'Ghi chú',
            'id_nguoi_ban' => 'Id Nguoi Ban',
            'ngay_ban' => 'Ngay Ban',
            'id_nguoi_lap' => 'Người lập',
            'ngay_lap' => 'Ngày lập',
            'trang_thai' => 'Trạng thái',
            'id_khach_hang' => 'Khách hàng',
            'date_created' => 'Thời gian tạo',
            'user_created' => 'Người tạo',
            'edit_mode' => 'Cho phép chỉnh sửa khi đã xuất',
        ];
    }
    
    /** -------xu ly cho so hoa don */
    /* public function getDaDuyet(){
        if($this->trang_thai=='DA_XUAT')
            return true;
            else
                return false;
    } */
    
    public function getSoHoaDon(){
        if($this->so_vao_so != null){
            return 'HD' . $this->fillNumber($this->so_vao_so) . '/' . $this->namVaoSo;
        } else {
            return 'HDN' . $this->fillNumber($this->getSoHoaDonCuoi($this->nam) + 1) . '/' . $this->namVaoSo;
        }
    }
    
    public function getSoHoaDonCuoi($year=NULl){
        if($year==null)
            $year = date('Y');
            $hoaDonCuoi = $this::find()->where([
                'nam'=>$year,
            ])->andFilterWhere(['IN','trang_thai',$this::getDmTrangThaiCoSoHoaDon()])
            ->orderBy(['so_vao_so' => SORT_DESC])->one();
            
            if($hoaDonCuoi != null)
                return $hoaDonCuoi->so_vao_so;
                else
                    return 0;
    }
    
    public function getNamVaoSo(){
        if($this->nam != null){
            return $this->nam;
        } else {
            $this->nam = date('Y');
            if($this->save()){
                return date('Y');
            }
        }
    }
    
    public function fillNumber($number){
        $num = strlen($number);
        if( $num < 5){
            $str0 = '';
            for($i=1;$i<=(5-$num); $i++){
                $str0 .= '0';
            }
            return $str0 . $number;
        } else {
            return $number;
        }
    }
    /** //-------end xu ly cho so hoa don */
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->date_created = date('Y-m-d H:i:s');
            $this->user_created = Yii::$app->user->id;
            if($this->nam == NULL)
                $this->nam = date('Y');
            if($this->trang_thai == NULL)
                $this->trang_thai = 'BAN_NHAP';
            if($this->edit_mode == NULL)
                $this->edit_mode = 0;
        }
        return parent::beforeSave($insert);
    }
    
}
