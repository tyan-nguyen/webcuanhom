<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_mau_cua_nhom_su_dung".
 *
 * @property int $id
 * @property int $id_mau_cua
 * @property int $id_kho_nhom
 * @property float $chieu_dai_ban_dau
 * @property float $chieu_dai_con_lai
 * @property float|null $chieu_dai_nhap_lai
 * @property string|null $ghi_chu_nhap_lai
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaMauCuaNhomSuDungChiTiet[] $cuaMauCuaNhomSuDungChiTiets
 * @property CuaKhoNhom $khoNhom
 * @property CuaMauCua $mauCua
 */
class CuaMauCuaNhomSuDung extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_mau_cua_nhom_su_dung';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mau_cua', 'id_kho_nhom', 'chieu_dai_ban_dau', 'chieu_dai_con_lai'], 'required'],
            [['id_mau_cua', 'id_kho_nhom', 'user_created'], 'integer'],
            [['chieu_dai_ban_dau', 'chieu_dai_con_lai', 'chieu_dai_nhap_lai'], 'number'],
            [['ghi_chu_nhap_lai'], 'string'],
            [['date_created'], 'safe'],
            [['id_mau_cua'], 'exist', 'skipOnError' => true, 'targetClass' => CuaMauCua::class, 'targetAttribute' => ['id_mau_cua' => 'id']],
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
            'id_mau_cua' => 'Id Mau Cua',
            'id_kho_nhom' => 'Id Kho Nhom',
            'chieu_dai_ban_dau' => 'Chieu Dai Ban Dau',
            'chieu_dai_con_lai' => 'Chieu Dai Con Lai',
            'chieu_dai_nhap_lai' => 'Chieu Dai Nhap Lai',
            'ghi_chu_nhap_lai' => 'Ghi Chu Nhap Lai',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[CuaMauCuaNhomSuDungChiTiets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaMauCuaNhomSuDungChiTiets()
    {
        return $this->hasMany(CuaMauCuaNhomSuDungChiTiet::class, ['id_nhom_su_dung' => 'id']);
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
     * Gets query for [[MauCua]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMauCua()
    {
        return $this->hasOne(CuaMauCua::class, ['id' => 'id_mau_cua']);
    }
}
