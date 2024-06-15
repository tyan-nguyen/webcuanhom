<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_he_nhom".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten_he_nhom
 * @property float|null $do_day_mac_dinh
 * @property string|null $ghi_chu
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaCayNhom[] $cuaCayNhoms
 * @property CuaMauCua[] $cuaMauCuas
 */
class CuaHeNhom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_he_nhom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_he_nhom'], 'required'],
            [['do_day_mac_dinh'], 'number'],
            [['ghi_chu'], 'string'],
            [['date_created'], 'safe'],
            [['user_created'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['ten_he_nhom'], 'string', 'max' => 255],
            [['code'], 'unique'],
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
            'ten_he_nhom' => 'Ten He Nhom',
            'do_day_mac_dinh' => 'Do Day Mac Dinh',
            'ghi_chu' => 'Ghi Chu',
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
        return $this->hasMany(CuaCayNhom::class, ['id_he_nhom' => 'id']);
    }

    /**
     * Gets query for [[CuaMauCuas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaMauCuas()
    {
        return $this->hasMany(CuaMauCua::class, ['id_he_nhom' => 'id']);
    }
}
