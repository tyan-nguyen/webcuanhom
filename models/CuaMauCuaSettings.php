<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_mau_cua_settings".
 *
 * @property int $id
 * @property int|null $id_mau_cua
 * @property float|null $vet_cat
 */
class CuaMauCuaSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_mau_cua_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mau_cua'], 'integer'],
            [['vet_cat'], 'number'],
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
            'vet_cat' => 'Vet Cat',
        ];
    }
}
