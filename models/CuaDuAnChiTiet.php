<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_du_an_chi_tiet".
 *
 * @property int $id
 * @property int $id_du_an
 * @property int $id_mau_cua
 * @property int $so_luong
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaDuAn $duAn
 * @property CuaMauCua $mauCua
 */
class CuaDuAnChiTiet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_du_an_chi_tiet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_du_an', 'id_mau_cua', 'so_luong'], 'required'],
            [['id_du_an', 'id_mau_cua', 'so_luong', 'user_created'], 'integer'],
            [['date_created'], 'safe'],
            [['id_du_an'], 'exist', 'skipOnError' => true, 'targetClass' => CuaDuAn::class, 'targetAttribute' => ['id_du_an' => 'id']],
            [['id_mau_cua'], 'exist', 'skipOnError' => true, 'targetClass' => CuaMauCua::class, 'targetAttribute' => ['id_mau_cua' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_du_an' => 'Id Du An',
            'id_mau_cua' => 'Id Mau Cua',
            'so_luong' => 'So Luong',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[DuAn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDuAn()
    {
        return $this->hasOne(CuaDuAn::class, ['id' => 'id_du_an']);
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
