<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_thuong_hieu".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten_thuong_hieu
 * @property string|null $ghi_chu
 */
class CuaThuongHieu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_thuong_hieu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_thuong_hieu'], 'required'],
            [['ghi_chu'], 'string'],
            [['code'], 'string', 'max' => 20],
            [['ten_thuong_hieu'], 'string', 'max' => 255],
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
            'ten_thuong_hieu' => 'Ten Thuong Hieu',
            'ghi_chu' => 'Ghi Chu',
        ];
    }
}
