<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_cong_trinh_settings".
 *
 * @property int $id
 * @property int $id_cong_trinh
 */
class CuaCongTrinhSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_cong_trinh_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cong_trinh'], 'required'],
            [['id_cong_trinh'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cong_trinh' => 'Id Cong Trinh',
        ];
    }
}
