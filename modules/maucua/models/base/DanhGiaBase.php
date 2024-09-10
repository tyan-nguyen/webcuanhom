<?php

namespace app\modules\maucua\models\base;

use Yii;
use app\custom\CustomFunc;
use app\modules\users\models\TaiKhoan;
use app\modules\users\models\TaiKhoanInfo;
/**
 * This is the model class for table "cua_mau_cua_danh_gia".
 *
 * @property int $id
 * @property int $id_mau_cua
 * @property int $id_nguoi_danh_gia
 * @property string $ten_nguoi_danh_gia
 * @property int $lan_thu
 * @property string $ngay_danh_gia
 * @property string|null $ghi_chu
 * @property string|null $date_created
 * @property int|null $user_created
 * @property int|null $check_he_nhom
 * @property int|null $check_kich_thuoc_phu_bi
 * @property int|null $check_kich_thuoc_thuc_te
 * @property int|null $check_nhan_hieu
 * @property int|null $check_chu_thich
 * @property int|null $check_tham_my
 *
 * @property CuaMauCua $mauCua
 * @property User $nguoiDanhGia
 */
class DanhGiaBase extends \app\models\CuaMauCuaDanhGia
{  
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mau_cua', 'ten_nguoi_danh_gia', 'lan_thu', 'ngay_danh_gia'], 'required'],
            [['id_mau_cua', 'id_nguoi_danh_gia', 'lan_thu', 'user_created', 'check_he_nhom', 'check_kich_thuoc_phu_bi', 'check_kich_thuoc_thuc_te', 'check_nhan_hieu', 'check_chu_thich', 'check_tham_my'], 'integer'],
            [['ngay_danh_gia', 'date_created'], 'safe'],
            [['ghi_chu'], 'string'],
            [['ten_nguoi_danh_gia'], 'string', 'max' => 200],
            [['id_mau_cua'], 'exist', 'skipOnError' => true, 'targetClass' => MauCuaBase::class, 'targetAttribute' => ['id_mau_cua' => 'id']],
            [['id_nguoi_danh_gia'], 'exist', 'skipOnError' => true, 'targetClass' => TaiKhoan::class, 'targetAttribute' => ['id_nguoi_danh_gia' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_mau_cua' => 'Mẫu cửa',
            'id_nguoi_danh_gia' => 'Người đánh giá',
            'ten_nguoi_danh_gia' => 'Tên người đánh giá',
            'lan_thu' => 'Lần thứ',
            'ngay_danh_gia' => 'Ngày đánh giá',
            'ghi_chu' => 'Ghi chú',
            'date_created' => 'Ngày lưu',
            'user_created' => 'Người lưu',
            'check_he_nhom' => 'Kiểm tra hệ nhôm',
            'check_kich_thuoc_phu_bi' => 'Kiểm tra kích thước (phủ bì)',
            'check_kich_thuoc_thuc_te' => 'Kiểm tra kích thước (thực tế)',
            'check_nhan_hieu' => 'Kiểm tra nhãn hiệu/Phụ kiện',
            'check_chu_thich' => 'Kiểm tra theo chú thích',
            'check_tham_my' => 'Kiểm tra thẩm mỹ',
        ];
    }      
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->date_created = date('Y-m-d H:i:s');
            $this->user_created = Yii::$app->user->id;
            $this->id_nguoi_danh_gia = Yii::$app->user->id;
        }        
        //set date
        $custom = new CustomFunc();
        if($this->ngay_danh_gia !=null){
            $this->ngay_danh_gia = $custom->convertDMYToYMD($this->ngay_danh_gia);
        }        
        return parent::beforeSave($insert);
    }
    
}