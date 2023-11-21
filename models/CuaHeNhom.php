<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_he_nhom".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten_he_nhom
 * @property string|null $ghi_chu
 * @property string|null $date_created
 * @property int|null $user_created
 */
class CuaHeNhom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_he_nhom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_he_nhom'], 'required'],
            [['ghi_chu'], 'string'],
            [['date_created'], 'safe'],
            [['user_created'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['ten_he_nhom'], 'string', 'max' => 255],
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
            'ten_he_nhom' => 'Ten He Nhom',
            'ghi_chu' => 'Ghi Chu',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }
}
