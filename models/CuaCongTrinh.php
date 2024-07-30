<?php

namespace app\models;

use Yii;

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
class CuaCongTrinh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_cong_trinh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_cong_trinh'], 'required'],
            [['id_khach_hang', 'user_created'], 'integer'],
            [['ngay_bat_dau', 'ngay_hoan_thanh', 'date_created'], 'safe'],
            [['ghi_chu'], 'string'],
            [['code', 'code_mau_thiet_ke'], 'string', 'max' => 20],
            [['ten_cong_trinh'], 'string', 'max' => 255],
            [['dia_diem'], 'string', 'max' => 200],
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
            'code' => 'Code',
            'ten_cong_trinh' => 'Ten Cong Trinh',
            'id_khach_hang' => 'Id Khach Hang',
            'dia_diem' => 'Dia Diem',
            'ngay_bat_dau' => 'Ngay Bat Dau',
            'ngay_hoan_thanh' => 'Ngay Hoan Thanh',
            'ghi_chu' => 'Ghi Chu',
            'code_mau_thiet_ke' => 'Code Mau Thiet Ke',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[CuaMauCuas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaMauCuas()
    {
        return $this->hasMany(CuaMauCua::class, ['id_cong_trinh' => 'id']);
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
