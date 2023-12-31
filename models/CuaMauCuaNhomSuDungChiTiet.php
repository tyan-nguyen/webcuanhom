<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_mau_cua_nhom_su_dung_chi_tiet".
 *
 * @property int $id
 * @property int $id_nhom_su_dung
 * @property int $id_nhom_toi_uu
 * @property int|null $date_created
 * @property int|null $user_created
 *
 * @property CuaMauCuaNhomSuDung $nhomSuDung
 * @property CuaToiUu $nhomToiUu
 */
class CuaMauCuaNhomSuDungChiTiet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_mau_cua_nhom_su_dung_chi_tiet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nhom_su_dung', 'id_nhom_toi_uu'], 'required'],
            [['id_nhom_su_dung', 'id_nhom_toi_uu', 'date_created', 'user_created'], 'integer'],
            [['id_nhom_su_dung'], 'exist', 'skipOnError' => true, 'targetClass' => CuaMauCuaNhomSuDung::class, 'targetAttribute' => ['id_nhom_su_dung' => 'id']],
            [['id_nhom_toi_uu'], 'exist', 'skipOnError' => true, 'targetClass' => CuaToiUu::class, 'targetAttribute' => ['id_nhom_toi_uu' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_nhom_su_dung' => 'Id Nhom Su Dung',
            'id_nhom_toi_uu' => 'Id Nhom Toi Uu',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[NhomSuDung]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNhomSuDung()
    {
        return $this->hasOne(CuaMauCuaNhomSuDung::class, ['id' => 'id_nhom_su_dung']);
    }

    /**
     * Gets query for [[NhomToiUu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNhomToiUu()
    {
        return $this->hasOne(CuaToiUu::class, ['id' => 'id_nhom_toi_uu']);
    }
}
