<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_kho_vat_tu_lich_su".
 *
 * @property int $id
 * @property int $id_kho_vat_tu
 * @property int|null $id_nha_cung_cap
 * @property string|null $ghi_chu
 * @property float|null $so_luong
 * @property float|null $so_luong_cu
 * @property float|null $so_luong_moi
 * @property int|null $id_mau_cua
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaKhoVatTu $khoVatTu
 */
class CuaKhoVatTuLichSu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_kho_vat_tu_lich_su';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kho_vat_tu'], 'required'],
            [['id_kho_vat_tu', 'id_nha_cung_cap', 'id_mau_cua', 'user_created'], 'integer'],
            [['ghi_chu'], 'string'],
            [['so_luong', 'so_luong_cu', 'so_luong_moi'], 'number'],
            [['date_created'], 'safe'],
            [['id_kho_vat_tu'], 'exist', 'skipOnError' => true, 'targetClass' => CuaKhoVatTu::class, 'targetAttribute' => ['id_kho_vat_tu' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_kho_vat_tu' => 'Id Kho Vat Tu',
            'id_nha_cung_cap' => 'Id Nha Cung Cap',
            'ghi_chu' => 'Ghi Chu',
            'so_luong' => 'So Luong',
            'so_luong_cu' => 'So Luong Cu',
            'so_luong_moi' => 'So Luong Moi',
            'id_mau_cua' => 'Id Mau Cua',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[KhoVatTu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoVatTu()
    {
        return $this->hasOne(CuaKhoVatTu::class, ['id' => 'id_kho_vat_tu']);
    }
}
