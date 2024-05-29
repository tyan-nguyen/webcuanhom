<?php

namespace app\modules\banle\models\base;

use Yii;
use app\models\BanleHoaDonChiTiet;

/**
 * This is the model class for table "banle_hoa_don_chi_tiet".
 *
 * @property int $id
 * @property int $id_hoa_don
 * @property int|null $id_vat_tu
 * @property string|null $loai_vat_tu
 * @property int|null $don_gia
 * @property float|null $so_luong
 * @property string|null $ghi_chu
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property BanleHoaDon $hoaDon
 */
class HoaDonChiTietBase extends BanleHoaDonChiTiet
{
    /**
     * Danh muc loai vat tu them vao phieu xuat kho
     * @return string[]
     */
    public static function getDmLoaiVatTu(){
        return [
            'NHOM'=>'Nhôm',
            'PHU_KIEN'=>'Phụ kiện',
            'VAT_TU'=>'Vật tư',
            'THIET_BI'=>'Thiết bị'
        ];
    }
    /**
     * Danh muc loai vat tu them vao phieu xuat kho label
     * @param int $val
     * @return string
     */
    public static function getDmLoaiVatTuLabel($val){
        $label = '';
        if($val == 'NHOM'){
            $label = 'Nhôm';
        }else if($val == 'PHU_KIEN'){
            $label = 'Phụ kiện';
        }else if($val == 'VAT_TU'){
            $label = 'Vật tư';
        }else if($val == 'THIET_BI'){
            $label = 'Thiết bị';
        }
        return $label;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_hoa_don'], 'required'],
            [['id', 'id_hoa_don', 'id_vat_tu', 'don_gia', 'user_created'], 'integer'],
            [['so_luong'], 'number'],
            [['ghi_chu'], 'string'],
            [['date_created'], 'safe'],
            [['loai_vat_tu'], 'string', 'max' => 20],
            [['id'], 'unique'],
            [['id_hoa_don'], 'exist', 'skipOnError' => true, 'targetClass' => HoaDonBase::class, 'targetAttribute' => ['id_hoa_don' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hoa_don' => 'Mã hóa đơn',
            'id_vat_tu' => 'Mã vật tư',
            'loai_vat_tu' => 'Loại vật tư',
            'don_gia' => 'Đơng gía',
            'so_luong' => 'Số lượng',
            'ghi_chu' => 'Ghi chú',
            'date_created' => 'Thời gian tạo',
            'user_created' => 'Người tạo',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->date_created = date('Y-m-d H:i:s');
            $this->user_created = Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }

}
