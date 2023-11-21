<?php

namespace app\modules\maucua\models;

use Yii;

/**
 * @property int $id
 * @property int $id_mau_cua
 * @property int $id_cay_nhom
 * @property float|null $chieu_dai
 * @property int|null $so_luong
 * @property string|null $kieu_cat
 * @property float|null $khoi_luong
 * @property float|null $don_gia
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CayNhom $cayNhom
 * @property MauCua $mauCua
 */
class MauCuaNhomBase extends \app\models\CuaMauCuaNhom
{    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mau_cua', 'id_cay_nhom'], 'required'],
            [['id_mau_cua', 'id_cay_nhom', 'so_luong', 'user_created'], 'integer'],
            [['chieu_dai', 'khoi_luong', 'don_gia'], 'number'],
            [['date_created'], 'safe'],
            [['kieu_cat'], 'string', 'max' => 11],
            [['id_mau_cua'], 'exist', 'skipOnError' => true, 'targetClass' => MauCua::class, 'targetAttribute' => ['id_mau_cua' => 'id']],
            [['id_cay_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => CayNhom::class, 'targetAttribute' => ['id_cay_nhom' => 'id']],
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
            'id_cay_nhom' => 'Id Cay Nhom',
            'chieu_dai' => 'Chieu Dai',
            'so_luong' => 'So Luong',
            'kieu_cat' => 'Kieu Cat',
            'khoi_luong' => 'Khoi Luong',
            'don_gia' => 'Don Gia',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->date_created = date('Y-m-d H:i:s');
            $this->user_created = Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * Gets query for [[CayNhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCayNhom()
    {
        return $this->hasOne(CayNhom::class, ['id' => 'id_cay_nhom']);
    }
    
    /**
     * Gets query for [[MauCua]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMauCua()
    {
        return $this->hasOne(MauCua::class, ['id' => 'id_mau_cua']);
    }
}