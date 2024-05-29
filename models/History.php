<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property string $loai
 * @property int $id_tham_chieu
 * @property string $noi_dung
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loai', 'id_tham_chieu', 'noi_dung'], 'required'],
            [['id_tham_chieu', 'nguoi_tao'], 'integer'],
            [['noi_dung', 'thoi_gian_tao'], 'safe'],
            [['loai'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai' => 'Loai',
            'id_tham_chieu' => 'Id Tham Chieu',
            'noi_dung' => 'Noi Dung',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }
}
