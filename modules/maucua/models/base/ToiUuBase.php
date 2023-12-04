<?php

namespace app\modules\maucua\models\base;

use Yii;

/**
 * This is the model class for table "cua_toi_uu".
 *
 * @property int $id
 * @property int $id_mau_cua
 * @property int $id_mau_cua_nhom
 * @property int $id_ton_kho_nhom
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaMauCua $mauCua
 * @property CuaMauCuaNhom $mauCuaNhom
 * @property CuaKhoNhom $tonKhoNhom
 */
class ToiUuBase extends \app\models\CuaToiUu
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mau_cua', 'id_mau_cua_nhom', 'id_ton_kho_nhom'], 'required'],
            [['id_mau_cua', 'id_mau_cua_nhom', 'id_ton_kho_nhom', 'user_created'], 'integer'],
            [['date_created'], 'safe'],
            [['id_mau_cua'], 'exist', 'skipOnError' => true, 'targetClass' => MauCuaBase::class, 'targetAttribute' => ['id_mau_cua' => 'id']],
            [['id_mau_cua_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => MauCuaNhomBase::class, 'targetAttribute' => ['id_mau_cua_nhom' => 'id']],
            [['id_ton_kho_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => KhoNhomBase::class, 'targetAttribute' => ['id_ton_kho_nhom' => 'id']],
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
            'id_mau_cua_nhom' => 'Id Mau Cua Nhom',
            'id_ton_kho_nhom' => 'Id Ton Kho Nhom',
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

}
