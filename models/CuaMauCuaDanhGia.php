<?php

namespace app\models;

use Yii;

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
class CuaMauCuaDanhGia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_mau_cua_danh_gia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mau_cua', 'id_nguoi_danh_gia', 'ten_nguoi_danh_gia', 'lan_thu', 'ngay_danh_gia'], 'required'],
            [['id_mau_cua', 'id_nguoi_danh_gia', 'lan_thu', 'user_created', 'check_he_nhom', 'check_kich_thuoc_phu_bi', 'check_kich_thuoc_thuc_te', 'check_nhan_hieu', 'check_chu_thich', 'check_tham_my'], 'integer'],
            [['ngay_danh_gia', 'date_created'], 'safe'],
            [['ghi_chu'], 'string'],
            [['ten_nguoi_danh_gia'], 'string', 'max' => 200],
            [['id_mau_cua'], 'exist', 'skipOnError' => true, 'targetClass' => CuaMauCua::class, 'targetAttribute' => ['id_mau_cua' => 'id']],
            [['id_nguoi_danh_gia'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_nguoi_danh_gia' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_mau_cua' => 'Id Mau Cua',
            'id_nguoi_danh_gia' => 'Id Nguoi Danh Gia',
            'ten_nguoi_danh_gia' => 'Ten Nguoi Danh Gia',
            'lan_thu' => 'Lan Thu',
            'ngay_danh_gia' => 'Ngay Danh Gia',
            'ghi_chu' => 'Ghi Chu',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
            'check_he_nhom' => 'Check He Nhom',
            'check_kich_thuoc_phu_bi' => 'Check Kich Thuoc Phu Bi',
            'check_kich_thuoc_thuc_te' => 'Check Kich Thuoc Thuc Te',
            'check_nhan_hieu' => 'Check Nhan Hieu',
            'check_chu_thich' => 'Check Chu Thich',
            'check_tham_my' => 'Check Tham My',
        ];
    }

    /**
     * Gets query for [[MauCua]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMauCua()
    {
        return $this->hasOne(CuaMauCua::class, ['id' => 'id_mau_cua']);
    }

    /**
     * Gets query for [[NguoiDanhGia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNguoiDanhGia()
    {
        return $this->hasOne(User::class, ['id' => 'id_nguoi_danh_gia']);
    }
}
