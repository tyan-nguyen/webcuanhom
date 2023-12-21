<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_settings".
 *
 * @property int $id
 * @property int|null $cho_phep_nhap_kho_am
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
            [['id', 'cho_phep_nhap_kho_am'], 'integer'],
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
        ];
    }
}
