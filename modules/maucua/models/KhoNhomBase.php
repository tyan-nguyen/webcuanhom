<?php

namespace app\modules\maucua\models;

use Yii;

/**
 * This is the model class for table "cua_kho_nhom".
 *
 * @property int $id
 * @property int $id_cay_nhom
 * @property float $chieu_dai
 * @property int|null $so_luong
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaCayNhom $cayNhom
 * @property CuaKhoNhomLichSu[] $cuaKhoNhomLichSus
 */
class KhoNhomBase extends \app\models\CuaKhoNhom
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cay_nhom', 'chieu_dai'], 'required'],
            [['id_cay_nhom', 'so_luong', 'user_created'], 'integer'],
            [['chieu_dai'], 'number'],
            [['date_created'], 'safe'],
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
            'id_cay_nhom' => 'Id Cay Nhom',
            'chieu_dai' => 'Chieu Dai',
            'so_luong' => 'So Luong',
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
     * Gets query for [[CuaKhoNhomLichSus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaKhoNhomLichSus()
    {
        return $this->hasMany(KhoNhomLichSu::class, ['id_kho_nhom' => 'id']);
    }
}
