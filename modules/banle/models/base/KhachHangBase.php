<?php

namespace app\modules\banle\models\base;

use Yii;
use app\models\BanleKhachHang;
use app\modules\banle\models\LoaiKhachHang;

/**
 * This is the model class for table "banle_khach_hang".
 *
 * @property int $id
 * @property int $id_loai_khach_hang
 * @property string $ten_khach_hang
 * @property string $dia_chi
 * @property string|null $so_dien_thoai
 * @property string|null $email
 * @property string|null $ghi_chu
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property BanleHoaDon[] $banleHoaDons
 * @property BanleLoaiKhachHang $loaiKhachHang
 */
class KhachHangBase extends BanleKhachHang
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_loai_khach_hang', 'ten_khach_hang', 'dia_chi'], 'required'],
            [['id_loai_khach_hang', 'user_created'], 'integer'],
            [['dia_chi', 'ghi_chu'], 'string'],
            [['date_created'], 'safe'],
            [['ten_khach_hang'], 'string', 'max' => 100],
            [['so_dien_thoai'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 200],
            [['id_loai_khach_hang'], 'exist', 'skipOnError' => true, 'targetClass' => LoaiKhachHang::class, 'targetAttribute' => ['id_loai_khach_hang' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_loai_khach_hang' => 'Loại khách hàng',
            'ten_khach_hang' => 'Tên Khách hàng',
            'dia_chi' => 'Địa chỉ',
            'so_dien_thoai' => 'Số điện thoại',
            'email' => 'Email',
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
