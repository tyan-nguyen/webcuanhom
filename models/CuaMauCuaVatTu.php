<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_mau_cua_vat_tu".
 *
 * @property int $id
 * @property int $id_mau_cua
 * @property int $id_kho_vat_tu
 * @property float $so_luong
 * @property string|null $dvt
 * @property float|null $don_gia
 * @property int|null $la_phu_kien
 * @property float|null $so_luong_xuat
 * @property string|null $ghi_chu_xuat
 * @property float|null $so_luong_nhap_lai
 * @property string|null $ghi_chu_nhap_lai
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaKhoVatTu $khoVatTu
 * @property CuaMauCua $mauCua
 */
class CuaMauCuaVatTu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_mau_cua_vat_tu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mau_cua', 'id_kho_vat_tu', 'so_luong'], 'required'],
            [['id_mau_cua', 'id_kho_vat_tu', 'la_phu_kien', 'user_created'], 'integer'],
            [['so_luong', 'don_gia', 'so_luong_xuat', 'so_luong_nhap_lai'], 'number'],
            [['ghi_chu_xuat', 'ghi_chu_nhap_lai'], 'string'],
            [['date_created'], 'safe'],
            [['dvt'], 'string', 'max' => 20],
            [['id_kho_vat_tu'], 'exist', 'skipOnError' => true, 'targetClass' => CuaKhoVatTu::class, 'targetAttribute' => ['id_kho_vat_tu' => 'id']],
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
            'id_mau_cua' => 'Id Mau Cua',
            'id_kho_vat_tu' => 'Id Kho Vat Tu',
            'so_luong' => 'So Luong',
            'dvt' => 'Dvt',
            'don_gia' => 'Don Gia',
            'la_phu_kien' => 'La Phu Kien',
            'so_luong_xuat' => 'So Luong Xuat',
            'ghi_chu_xuat' => 'Ghi Chu Xuat',
            'so_luong_nhap_lai' => 'So Luong Nhap Lai',
            'ghi_chu_nhap_lai' => 'Ghi Chu Nhap Lai',
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
