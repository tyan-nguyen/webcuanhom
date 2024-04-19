<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_mau_cua_nhom".
 *
 * @property int $id
 * @property int $id_mau_cua
 * @property int $id_cay_nhom
 * @property float|null $chieu_dai
 * @property int|null $so_luong
 * @property string|null $kieu_cat
 * @property float|null $khoi_luong
 * @property float|null $don_gia
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaCayNhom $cayNhom
 * @property CuaToiUu[] $cuaToiUus
 * @property CuaMauCua $mauCua
 */
class CuaMauCuaNhom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_mau_cua_nhom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mau_cua', 'id_cay_nhom'], 'required'],
            [['id_mau_cua', 'id_cay_nhom', 'so_luong', 'user_created'], 'integer'],
            [['chieu_dai', 'khoi_luong', 'don_gia'], 'number'],
            [['date_created'], 'safe'],
            [['kieu_cat'], 'string', 'max' => 11],
            [['id_mau_cua'], 'exist', 'skipOnError' => true, 'targetClass' => CuaMauCua::class, 'targetAttribute' => ['id_mau_cua' => 'id']],
            [['id_cay_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => CuaCayNhom::class, 'targetAttribute' => ['id_cay_nhom' => 'id']],
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
            'id_cay_nhom' => 'Id Cay Nhom',
            'chieu_dai' => 'Chieu Dai',
            'so_luong' => 'So Luong',
            'kieu_cat' => 'Kieu Cat',
            'khoi_luong' => 'Khoi Luong',
            'don_gia' => 'Don Gia',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[CayNhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCayNhom()
    {
        return $this->hasOne(CuaCayNhom::class, ['id' => 'id_cay_nhom']);
    }

    /**
     * Gets query for [[CuaToiUus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaToiUus()
    {
        return $this->hasMany(CuaToiUu::class, ['id_mau_cua_nhom' => 'id']);
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
}
