<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_kho_nhom_qr".
 *
 * @property int $id
 * @property int $id_kho_nhom
 * @property int $id_nhom_su_dung
 * @property string|null $qr_code
 * @property int|null $user_created
 * @property string|null $date_created
 *
 * @property CuaKhoNhom $khoNhom
 * @property CuaMauCuaNhomSuDung $nhomSuDung
 */
class CuaKhoNhomQr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_kho_nhom_qr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kho_nhom', 'id_nhom_su_dung'], 'required'],
            [['id_kho_nhom', 'id_nhom_su_dung', 'user_created'], 'integer'],
            [['date_created'], 'safe'],
            [['qr_code'], 'string', 'max' => 20],
            [['id_kho_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => CuaKhoNhom::class, 'targetAttribute' => ['id_kho_nhom' => 'id']],
            [['id_nhom_su_dung'], 'exist', 'skipOnError' => true, 'targetClass' => CuaMauCuaNhomSuDung::class, 'targetAttribute' => ['id_nhom_su_dung' => 'id']],
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
            'id_nhom_su_dung' => 'Id Nhom Su Dung',
            'qr_code' => 'Qr Code',
            'user_created' => 'User Created',
            'date_created' => 'Date Created',
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

    /**
     * Gets query for [[NhomSuDung]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNhomSuDung()
    {
        return $this->hasOne(CuaMauCuaNhomSuDung::class, ['id' => 'id_nhom_su_dung']);
    }
}
