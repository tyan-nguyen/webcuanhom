<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_info".
 *
 * @property int $id_user
 * @property string|null $name
 * @property string|null $chuc_vu
 * @property string|null $email
 * @property int|null $nhan_thong_bao
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user'], 'required'],
            [['id_user', 'nhan_thong_bao'], 'integer'],
            [['name', 'chuc_vu'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 200],
            [['id_user'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'name' => 'Name',
            'chuc_vu' => 'Chuc Vu',
            'email' => 'Email',
            'nhan_thong_bao' => 'Nhan Thong Bao',
        ];
    }
}
