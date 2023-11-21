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
 * @property int|null $id_he_nhom
 * @property int $id_loai_cua
 * @property int|null $id_parent
 * @property int $id_du_an
 * @property int|null $so_luong
 * @property string|null $status
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaDuAnChiTiet[] $cuaDuAnChiTiets
 * @property CuaMauCuaNhom[] $cuaMauCuaNhoms
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
            [['ten_cua', 'kich_thuoc', 'id_loai_cua', 'id_du_an'], 'required'],
            [['id_he_nhom', 'id_loai_cua', 'id_parent', 'id_du_an', 'so_luong', 'user_created'], 'integer'],
            [['date_created'], 'safe'],
            [['code', 'kich_thuoc', 'status'], 'string', 'max' => 20],
            [['ten_cua'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['id_he_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => CuaHeNhom::class, 'targetAttribute' => ['id_he_nhom' => 'id']],
            [['id_loai_cua'], 'exist', 'skipOnError' => true, 'targetClass' => CuaLoaiCua::class, 'targetAttribute' => ['id_loai_cua' => 'id']],
            [['id_du_an'], 'exist', 'skipOnError' => true, 'targetClass' => CuaDuAn::class, 'targetAttribute' => ['id_du_an' => 'id']],
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
            'id_he_nhom' => 'Id He Nhom',
            'id_loai_cua' => 'Id Loai Cua',
            'id_parent' => 'Id Parent',
            'id_du_an' => 'Id Du An',
            'so_luong' => 'So Luong',
            'status' => 'Status',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
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
     * Gets query for [[CuaMauCuaNhoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaMauCuaNhoms()
    {
        return $this->hasMany(CuaMauCuaNhom::class, ['id_mau_cua' => 'id']);
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
