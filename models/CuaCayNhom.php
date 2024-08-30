<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_cay_nhom".
 *
 * @property int $id
 * @property int $id_he_nhom
 * @property string $code
 * @property int|null $id_he_mau
 * @property string $ten_cay_nhom
 * @property int|null $so_luong
 * @property float|null $don_gia
 * @property float|null $khoi_luong
 * @property float|null $chieu_dai
 * @property float|null $do_day
 * @property int|null $for_cua_so
 * @property int|null $for_cua_di
 * @property float|null $min_allow_cut
 * @property float|null $min_allow_cut_under
 * @property int|null $dung_cho_nhieu_he_nhom
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaKhoNhom[] $cuaKhoNhoms
 * @property CuaMauCuaNhom[] $cuaMauCuaNhoms
 * @property CuaHeMau $heMau
 * @property CuaHeNhom $heNhom
 */
class CuaCayNhom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_cay_nhom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_he_nhom', 'code', 'ten_cay_nhom'], 'required'],
            [['id_he_nhom', 'id_he_mau', 'so_luong', 'for_cua_so', 'for_cua_di', 'dung_cho_nhieu_he_nhom', 'user_created'], 'integer'],
            [['don_gia', 'khoi_luong', 'chieu_dai', 'do_day', 'min_allow_cut', 'min_allow_cut_under'], 'number'],
            [['date_created'], 'safe'],
            [['code'], 'string', 'max' => 20],
            [['ten_cay_nhom'], 'string', 'max' => 255],
            [['id_he_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => CuaHeNhom::class, 'targetAttribute' => ['id_he_nhom' => 'id']],
            [['id_he_mau'], 'exist', 'skipOnError' => true, 'targetClass' => CuaHeMau::class, 'targetAttribute' => ['id_he_mau' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_he_nhom' => 'Id He Nhom',
            'code' => 'Code',
            'id_he_mau' => 'Id He Mau',
            'ten_cay_nhom' => 'Ten Cay Nhom',
            'so_luong' => 'So Luong',
            'don_gia' => 'Don Gia',
            'khoi_luong' => 'Khoi Luong',
            'chieu_dai' => 'Chieu Dai',
            'do_day' => 'Do Day',
            'for_cua_so' => 'For Cua So',
            'for_cua_di' => 'For Cua Di',
            'min_allow_cut' => 'Min Allow Cut',
            'min_allow_cut_under' => 'Min Allow Cut Under',
            'dung_cho_nhieu_he_nhom' => 'Dung Cho Nhieu He Nhom',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[CuaKhoNhoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaKhoNhoms()
    {
        return $this->hasMany(CuaKhoNhom::class, ['id_cay_nhom' => 'id']);
    }

    /**
     * Gets query for [[CuaMauCuaNhoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaMauCuaNhoms()
    {
        return $this->hasMany(CuaMauCuaNhom::class, ['id_cay_nhom' => 'id']);
    }

    /**
     * Gets query for [[HeMau]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHeMau()
    {
        return $this->hasOne(CuaHeMau::class, ['id' => 'id_he_mau']);
    }

    /**
     * Gets query for [[HeNhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHeNhom()
    {
        return $this->hasOne(CuaHeNhom::class, ['id' => 'id_he_nhom']);
    }
}
