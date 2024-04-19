<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_mau_cua_vach".
 *
 * @property int $id
 * @property int $id_mau_cua
 * @property int $id_vach
 * @property float|null $rong
 * @property float|null $cao
 * @property float|null $so_luong
 * @property float|null $dien_tich
 * @property float $don_gia
 * @property string|null $date_created
 * @property int $user_created
 * @property float|null $so_luong_xuat
 * @property string|null $ghi_chu_xuat
 * @property float|null $so_luong_nhap_lai
 * @property string|null $ghi_chu_nhap_lai
 * @property int|null $code_bao_gia
 *
 * @property CuaMauCua $mauCua
 * @property CuaHeVach $vach
 */
class CuaMauCuaVach extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_mau_cua_vach';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mau_cua', 'id_vach', 'don_gia', 'user_created'], 'required'],
            [['id_mau_cua', 'id_vach', 'user_created', 'code_bao_gia'], 'integer'],
            [['rong', 'cao', 'so_luong', 'dien_tich', 'don_gia', 'so_luong_xuat', 'so_luong_nhap_lai'], 'number'],
            [['date_created'], 'safe'],
            [['ghi_chu_xuat', 'ghi_chu_nhap_lai'], 'string'],
            [['id_mau_cua'], 'exist', 'skipOnError' => true, 'targetClass' => CuaMauCua::class, 'targetAttribute' => ['id_mau_cua' => 'id']],
            [['id_vach'], 'exist', 'skipOnError' => true, 'targetClass' => CuaHeVach::class, 'targetAttribute' => ['id_vach' => 'id']],
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
            'id_vach' => 'Id Vach',
            'rong' => 'Rong',
            'cao' => 'Cao',
            'so_luong' => 'So Luong',
            'dien_tich' => 'Dien Tich',
            'don_gia' => 'Don Gia',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
            'so_luong_xuat' => 'So Luong Xuat',
            'ghi_chu_xuat' => 'Ghi Chu Xuat',
            'so_luong_nhap_lai' => 'So Luong Nhap Lai',
            'ghi_chu_nhap_lai' => 'Ghi Chu Nhap Lai',
            'code_bao_gia' => 'Code Bao Gia',
        ];
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

    /**
     * Gets query for [[Vach]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVach()
    {
        return $this->hasOne(CuaHeVach::class, ['id' => 'id_vach']);
    }
}
