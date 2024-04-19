<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_loai_bao_gia".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten_loai_bao_gia
 * @property string|null $nhom_bao_gia
 * @property string|null $ghi_chu
 */
class CuaLoaiBaoGia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_loai_bao_gia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_loai_bao_gia'], 'required'],
            [['ghi_chu'], 'string'],
            [['code', 'nhom_bao_gia'], 'string', 'max' => 20],
            [['ten_loai_bao_gia'], 'string', 'max' => 255],
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
            'ten_loai_bao_gia' => 'Ten Loai Bao Gia',
            'nhom_bao_gia' => 'Nhom Bao Gia',
            'ghi_chu' => 'Ghi Chu',
        ];
    }
}
