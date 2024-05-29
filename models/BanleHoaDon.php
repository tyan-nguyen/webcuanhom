<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banle_hoa_don".
 *
 * @property int $id
 * @property int|null $ma_hoa_don
 * @property int|null $so_vao_so
 * @property int|null $nam
 * @property string|null $ghi_chu
 * @property int|null $id_nguoi_ban
 * @property string|null $ngay_ban
 * @property int|null $id_nguoi_lap
 * @property string|null $ngay_lap
 * @property string|null $trang_thai
 * @property int|null $edit_mode
 * @property int|null $id_khach_hang
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property BanleHoaDonChiTiet[] $banleHoaDonChiTiets
 * @property BanleKhachHang $khachHang
 */
class BanleHoaDon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banle_hoa_don';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma_hoa_don', 'so_vao_so', 'nam', 'id_nguoi_ban', 'id_nguoi_lap', 'edit_mode', 'id_khach_hang', 'user_created'], 'integer'],
            [['ghi_chu'], 'string'],
            [['ngay_ban', 'ngay_lap', 'date_created'], 'safe'],
            [['trang_thai'], 'string', 'max' => 20],
            [['id_khach_hang'], 'exist', 'skipOnError' => true, 'targetClass' => BanleKhachHang::class, 'targetAttribute' => ['id_khach_hang' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma_hoa_don' => 'Ma Hoa Don',
            'so_vao_so' => 'So Vao So',
            'nam' => 'Nam',
            'ghi_chu' => 'Ghi Chu',
            'id_nguoi_ban' => 'Id Nguoi Ban',
            'ngay_ban' => 'Ngay Ban',
            'id_nguoi_lap' => 'Id Nguoi Lap',
            'ngay_lap' => 'Ngay Lap',
            'trang_thai' => 'Trang Thai',
            'edit_mode' => 'Edit Mode',
            'id_khach_hang' => 'Id Khach Hang',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[BanleHoaDonChiTiets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBanleHoaDonChiTiets()
    {
        return $this->hasMany(BanleHoaDonChiTiet::class, ['id_hoa_don' => 'id']);
    }

    /**
     * Gets query for [[KhachHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhachHang()
    {
        return $this->hasOne(BanleKhachHang::class, ['id' => 'id_khach_hang']);
    }
}
