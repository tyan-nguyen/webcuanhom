<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banle_hoa_don_chi_tiet".
 *
 * @property int $id
 * @property int $id_hoa_don
 * @property int|null $id_vat_tu
 * @property string|null $loai_vat_tu
 * @property int|null $don_gia
 * @property float|null $so_luong
 * @property string|null $ghi_chu
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property BanleHoaDon $hoaDon
 */
class BanleHoaDonChiTiet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banle_hoa_don_chi_tiet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_hoa_don'], 'required'],
            [['id', 'id_hoa_don', 'id_vat_tu', 'don_gia', 'user_created'], 'integer'],
            [['so_luong'], 'number'],
            [['ghi_chu'], 'string'],
            [['date_created'], 'safe'],
            [['loai_vat_tu'], 'string', 'max' => 20],
            [['id'], 'unique'],
            [['id_hoa_don'], 'exist', 'skipOnError' => true, 'targetClass' => BanleHoaDon::class, 'targetAttribute' => ['id_hoa_don' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_hoa_don' => 'Id Hoa Don',
            'id_vat_tu' => 'Id Vat Tu',
            'loai_vat_tu' => 'Loai Vat Tu',
            'don_gia' => 'Don Gia',
            'so_luong' => 'So Luong',
            'ghi_chu' => 'Ghi Chu',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[HoaDon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHoaDon()
    {
        return $this->hasOne(BanleHoaDon::class, ['id' => 'id_hoa_don']);
    }
}
