<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_du_an".
 *
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
 *
 * @property CuaDuAnChiTiet[] $cuaDuAnChiTiets
 * @property CuaMauCua[] $cuaMauCuas
 */
class CuaDuAn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_du_an';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_du_an'], 'required'],
            [['dia_chi', 'ghi_chu'], 'string'],
            [['toi_uu_tat_ca', 'user_created'], 'integer'],
            [['ngay_bat_dau_thuc_hien', 'ngay_hoan_thanh_du_an', 'date_created'], 'safe'],
            [['code', 'code_mau_thiet_ke'], 'string', 'max' => 20],
            [['ten_du_an', 'email'], 'string', 'max' => 255],
            [['ten_khach_hang'], 'string', 'max' => 100],
            [['so_dien_thoai'], 'string', 'max' => 11],
            [['trang_thai'], 'string', 'max' => 10],
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
            'ten_du_an' => 'Ten Du An',
            'ten_khach_hang' => 'Ten Khach Hang',
            'dia_chi' => 'Dia Chi',
            'so_dien_thoai' => 'So Dien Thoai',
            'email' => 'Email',
            'trang_thai' => 'Trang Thai',
            'toi_uu_tat_ca' => 'Toi Uu Tat Ca',
            'ngay_bat_dau_thuc_hien' => 'Ngay Bat Dau Thuc Hien',
            'ngay_hoan_thanh_du_an' => 'Ngay Hoan Thanh Du An',
            'ghi_chu' => 'Ghi Chu',
            'code_mau_thiet_ke' => 'Code Mau Thiet Ke',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[CuaDuAnChiTiets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaDuAnChiTiets()
    {
        return $this->hasMany(CuaDuAnChiTiet::class, ['id_du_an' => 'id']);
    }

    /**
     * Gets query for [[CuaMauCuas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaMauCuas()
    {
        return $this->hasMany(CuaMauCua::class, ['id_du_an' => 'id']);
    }
}
