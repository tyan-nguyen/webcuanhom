<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_toi_uu".
 *
 * @property int $id
 * @property int $id_mau_cua
 * @property int $id_mau_cua_nhom
 * @property int $id_ton_kho_nhom
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaMauCua $mauCua
 * @property CuaMauCuaNhom $mauCuaNhom
 * @property CuaKhoNhom $tonKhoNhom
 */
class CuaToiUu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_toi_uu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mau_cua', 'id_mau_cua_nhom', 'id_ton_kho_nhom'], 'required'],
            [['id_mau_cua', 'id_mau_cua_nhom', 'id_ton_kho_nhom', 'user_created'], 'integer'],
            [['date_created'], 'safe'],
            [['id_mau_cua'], 'exist', 'skipOnError' => true, 'targetClass' => CuaMauCua::class, 'targetAttribute' => ['id_mau_cua' => 'id']],
            [['id_mau_cua_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => CuaMauCuaNhom::class, 'targetAttribute' => ['id_mau_cua_nhom' => 'id']],
            [['id_ton_kho_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => CuaKhoNhom::class, 'targetAttribute' => ['id_ton_kho_nhom' => 'id']],
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
            'id_mau_cua_nhom' => 'Id Mau Cua Nhom',
            'id_ton_kho_nhom' => 'Id Ton Kho Nhom',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
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
     * Gets query for [[MauCuaNhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMauCuaNhom()
    {
        return $this->hasOne(CuaMauCuaNhom::class, ['id' => 'id_mau_cua_nhom']);
    }

    /**
     * Gets query for [[TonKhoNhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTonKhoNhom()
    {
        return $this->hasOne(CuaKhoNhom::class, ['id' => 'id_ton_kho_nhom']);
    }
}
