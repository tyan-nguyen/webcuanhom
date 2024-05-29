<?php

namespace app\models;

use Yii;

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
class BanleKhachHang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banle_khach_hang';
    }

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
            [['id_loai_khach_hang'], 'exist', 'skipOnError' => true, 'targetClass' => BanleLoaiKhachHang::class, 'targetAttribute' => ['id_loai_khach_hang' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_loai_khach_hang' => 'Id Loai Khach Hang',
            'ten_khach_hang' => 'Ten Khach Hang',
            'dia_chi' => 'Dia Chi',
            'so_dien_thoai' => 'So Dien Thoai',
            'email' => 'Email',
            'ghi_chu' => 'Ghi Chu',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[BanleHoaDons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBanleHoaDons()
    {
        return $this->hasMany(BanleHoaDon::class, ['id_khach_hang' => 'id']);
    }

    /**
     * Gets query for [[LoaiKhachHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiKhachHang()
    {
        return $this->hasOne(BanleLoaiKhachHang::class, ['id' => 'id_loai_khach_hang']);
    }
}
