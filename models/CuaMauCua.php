<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_mau_cua".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten_cua
 * @property string $kich_thuoc
 * @property float|null $ngang
 * @property float|null $cao
 * @property int|null $id_he_nhom
 * @property int $id_loai_cua
 * @property int|null $id_parent
 * @property int $id_du_an
 * @property int|null $id_cong_trinh
 * @property int|null $so_luong
 * @property string|null $status
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaCongTrinh $congTrinh
 * @property CuaDuAnChiTiet[] $cuaDuAnChiTiets
 * @property CuaMauCuaNhomSuDung[] $cuaMauCuaNhomSuDungs
 * @property CuaMauCuaNhom[] $cuaMauCuaNhoms
 * @property CuaMauCuaSettings[] $cuaMauCuaSettings
 * @property CuaMauCuaVach[] $cuaMauCuaVaches
 * @property CuaMauCuaVatTu[] $cuaMauCuaVatTus
 * @property CuaToiUu[] $cuaToiUus
 * @property CuaDuAn $duAn
 * @property CuaHeNhom $heNhom
 * @property CuaLoaiCua $loaiCua
 */
class CuaMauCua extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_mau_cua';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_cua', 'kich_thuoc', 'id_loai_cua', 'id_cong_trinh'], 'required'],
            [['ngang', 'cao'], 'number'],
            [['id_he_nhom', 'id_loai_cua', 'id_parent', 'id_du_an', 'id_cong_trinh', 'so_luong', 'user_created'], 'integer'],
            [['date_created'], 'safe'],
            [['code', 'kich_thuoc', 'status'], 'string', 'max' => 20],
            [['ten_cua'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['id_he_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => CuaHeNhom::class, 'targetAttribute' => ['id_he_nhom' => 'id']],
            [['id_loai_cua'], 'exist', 'skipOnError' => true, 'targetClass' => CuaLoaiCua::class, 'targetAttribute' => ['id_loai_cua' => 'id']],
            [['id_du_an'], 'exist', 'skipOnError' => true, 'targetClass' => CuaDuAn::class, 'targetAttribute' => ['id_du_an' => 'id']],
            [['id_cong_trinh'], 'exist', 'skipOnError' => true, 'targetClass' => CuaCongTrinh::class, 'targetAttribute' => ['id_cong_trinh' => 'id']],
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
            'ten_cua' => 'Ten Cua',
            'kich_thuoc' => 'Kich Thuoc',
            'ngang' => 'Ngang',
            'cao' => 'Cao',
            'id_he_nhom' => 'Id He Nhom',
            'id_loai_cua' => 'Id Loai Cua',
            'id_parent' => 'Id Parent',
            'id_du_an' => 'Id Du An',
            'id_cong_trinh' => 'Id Cong Trinh',
            'so_luong' => 'So Luong',
            'status' => 'Status',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[CongTrinh]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCongTrinh()
    {
        return $this->hasOne(CuaCongTrinh::class, ['id' => 'id_cong_trinh']);
    }

    /**
     * Gets query for [[CuaDuAnChiTiets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaDuAnChiTiets()
    {
        return $this->hasMany(CuaDuAnChiTiet::class, ['id_mau_cua' => 'id']);
    }

    /**
     * Gets query for [[CuaMauCuaNhomSuDungs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaMauCuaNhomSuDungs()
    {
        return $this->hasMany(CuaMauCuaNhomSuDung::class, ['id_mau_cua' => 'id']);
    }

    /**
     * Gets query for [[CuaMauCuaNhoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaMauCuaNhoms()
    {
        return $this->hasMany(CuaMauCuaNhom::class, ['id_mau_cua' => 'id']);
    }

    /**
     * Gets query for [[CuaMauCuaSettings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaMauCuaSettings()
    {
        return $this->hasMany(CuaMauCuaSettings::class, ['id_mau_cua' => 'id']);
    }

    /**
     * Gets query for [[CuaMauCuaVaches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaMauCuaVaches()
    {
        return $this->hasMany(CuaMauCuaVach::class, ['id_mau_cua' => 'id']);
    }

    /**
     * Gets query for [[CuaMauCuaVatTus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaMauCuaVatTus()
    {
        return $this->hasMany(CuaMauCuaVatTu::class, ['id_mau_cua' => 'id']);
    }

    /**
     * Gets query for [[CuaToiUus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaToiUus()
    {
        return $this->hasMany(CuaToiUu::class, ['id_mau_cua' => 'id']);
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
     * Gets query for [[HeNhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHeNhom()
    {
        return $this->hasOne(CuaHeNhom::class, ['id' => 'id_he_nhom']);
    }

    /**
     * Gets query for [[LoaiCua]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiCua()
    {
        return $this->hasOne(CuaLoaiCua::class, ['id' => 'id_loai_cua']);
    }
}
