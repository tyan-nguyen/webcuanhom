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
class CuaDuAnSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_du_an_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_du_an'], 'integer'],
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
            'id_du_an' => 'Id Du An',
            'vet_cat' => 'Vet Cat',
        ];
    }
}
