<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_he_nhom_mau".
 *
 * @property int $id
 * @property int $id_he_nhom
 * @property int $id_he_mau
 * @property int|null $is_mac_dinh
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaHeMau $heMau
 * @property CuaHeNhom $heNhom
 */
class CuaHeNhomMau extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_he_nhom_mau';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_he_nhom', 'id_he_mau'], 'required'],
            [['id_he_nhom', 'id_he_mau', 'is_mac_dinh', 'user_created'], 'integer'],
            [['date_created'], 'safe'],
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
            'id_he_mau' => 'Id He Mau',
            'is_mac_dinh' => 'Is Mac Dinh',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
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
