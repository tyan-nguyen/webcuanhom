<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_he_mau".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten_he_mau
 * @property string $ma_mau
 * @property int|null $for_nhom
 * @property int|null $for_phu_kien
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaCayNhom[] $cuaCayNhoms
 * @property CuaHeNhomMau[] $cuaHeNhomMaus
 */
class CuaHeMau extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_he_mau';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_he_mau', 'ma_mau'], 'required'],
            [['for_nhom', 'for_phu_kien', 'user_created'], 'integer'],
            [['date_created'], 'safe'],
            [['code', 'ma_mau'], 'string', 'max' => 20],
            [['ten_he_mau'], 'string', 'max' => 200],
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
            'ten_he_mau' => 'Ten He Mau',
            'ma_mau' => 'Ma Mau',
            'for_nhom' => 'For Nhom',
            'for_phu_kien' => 'For Phu Kien',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[CuaCayNhoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaCayNhoms()
    {
        return $this->hasMany(CuaCayNhom::class, ['id_he_mau' => 'id']);
    }

    /**
     * Gets query for [[CuaHeNhomMaus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaHeNhomMaus()
    {
        return $this->hasMany(CuaHeNhomMau::class, ['id_mau' => 'id']);
    }
}
