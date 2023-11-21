<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_loai_cua".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten_loai_cua
 * @property string|null $ghi_chu
 * @property string|null $date_created
 * @property int|null $user_created
 */
class CuaLoaiCua extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_loai_cua';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_loai_cua'], 'required'],
            [['ghi_chu'], 'string'],
            [['date_created'], 'safe'],
            [['user_created'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['ten_loai_cua'], 'string', 'max' => 255],
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
            'ten_loai_cua' => 'Ten Loai Cua',
            'ghi_chu' => 'Ghi Chu',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }
}
