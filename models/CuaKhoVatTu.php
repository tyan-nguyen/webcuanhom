<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_kho_vat_tu".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten_vat_tu
 * @property int|null $id_nhom_vat_tu
 * @property string|null $thuong_hieu
 * @property string|null $model
 * @property int|null $xuat_xu
 * @property int|null $la_phu_kien
 * @property float|null $so_luong
 * @property int $dvt
 * @property float|null $don_gia
 * @property string|null $ghi_chu
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaKhoVatTuLichSu[] $cuaKhoVatTuLichSus
 * @property CuaMauCuaVatTu[] $cuaMauCuaVatTus
 * @property CuaXuatXu $xuatXu
 */
class CuaKhoVatTu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_kho_vat_tu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_vat_tu', 'dvt'], 'required'],
            [['id_nhom_vat_tu', 'xuat_xu', 'la_phu_kien', 'dvt', 'user_created'], 'integer'],
            [['so_luong', 'don_gia'], 'number'],
            [['ghi_chu'], 'string'],
            [['date_created'], 'safe'],
            [['code'], 'string', 'max' => 20],
            [['ten_vat_tu', 'thuong_hieu', 'model'], 'string', 'max' => 255],
            [['xuat_xu'], 'exist', 'skipOnError' => true, 'targetClass' => CuaXuatXu::class, 'targetAttribute' => ['xuat_xu' => 'id']],
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
            'ten_vat_tu' => 'Ten Vat Tu',
            'id_nhom_vat_tu' => 'Id Nhom Vat Tu',
            'thuong_hieu' => 'Thuong Hieu',
            'model' => 'Model',
            'xuat_xu' => 'Xuat Xu',
            'la_phu_kien' => 'La Phu Kien',
            'so_luong' => 'So Luong',
            'dvt' => 'Dvt',
            'don_gia' => 'Don Gia',
            'ghi_chu' => 'Ghi Chu',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[CuaKhoVatTuLichSus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaKhoVatTuLichSus()
    {
        return $this->hasMany(CuaKhoVatTuLichSu::class, ['id_kho_vat_tu' => 'id']);
    }

    /**
     * Gets query for [[CuaMauCuaVatTus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaMauCuaVatTus()
    {
        return $this->hasMany(CuaMauCuaVatTu::class, ['id_kho_vat_tu' => 'id']);
    }

    /**
     * Gets query for [[XuatXu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getXuatXu()
    {
        return $this->hasOne(CuaXuatXu::class, ['id' => 'xuat_xu']);
    }
}
