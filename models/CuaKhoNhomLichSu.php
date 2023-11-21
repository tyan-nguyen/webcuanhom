<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_kho_nhom_lich_su".
 *
 * @property int $id
 * @property int $id_kho_nhom
 * @property int $so_luong
 * @property string $noi_dung
 * @property int|null $id_mau_cua
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaKhoNhom $khoNhom
 */
class CuaKhoNhomLichSu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_kho_nhom_lich_su';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kho_nhom', 'so_luong', 'noi_dung'], 'required'],
            [['id_kho_nhom', 'so_luong', 'id_mau_cua', 'user_created'], 'integer'],
            [['noi_dung'], 'string'],
            [['date_created'], 'safe'],
            [['id_kho_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => CuaKhoNhom::class, 'targetAttribute' => ['id_kho_nhom' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_kho_nhom' => 'Id Kho Nhom',
            'so_luong' => 'So Luong',
            'noi_dung' => 'Noi Dung',
            'id_mau_cua' => 'Id Mau Cua',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[KhoNhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoNhom()
    {
        return $this->hasOne(CuaKhoNhom::class, ['id' => 'id_kho_nhom']);
    }
}
