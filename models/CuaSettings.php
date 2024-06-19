<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_settings".
 *
 * @property int $id
 * @property int|null $cho_phep_nhap_kho_am
 * @property int|null $an_kho_nhom_bang_khong
 * @property float|null $vet_cat
 * @property float|null $chieu_dai_nhom_mac_dinh
 */
class CuaSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'cho_phep_nhap_kho_am', 'an_kho_nhom_bang_khong'], 'integer'],
            [['vet_cat', 'chieu_dai_nhom_mac_dinh'], 'number'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cho_phep_nhap_kho_am' => 'Cho Phep Nhap Kho Am',
            'an_kho_nhom_bang_khong' => 'An Kho Nhom Bang Khong',
            'vet_cat' => 'Vet Cat',
            'chieu_dai_nhom_mac_dinh' => 'Chieu Dai Nhom Mac Dinh',
        ];
    }
}
