<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_xuat_xu".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten_xuat_xu
 * @property string|null $ghi_chu
 *
 * @property CuaKhoVatTu[] $cuaKhoVatTus
 */
class CuaXuatXu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_xuat_xu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_xuat_xu'], 'required'],
            [['ghi_chu'], 'string'],
            [['code'], 'string', 'max' => 20],
            [['ten_xuat_xu'], 'string', 'max' => 255],
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
            'ten_xuat_xu' => 'Ten Xuat Xu',
            'ghi_chu' => 'Ghi Chu',
        ];
    }

    /**
     * Gets query for [[CuaKhoVatTus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaKhoVatTus()
    {
        return $this->hasMany(CuaKhoVatTu::class, ['xuat_xu' => 'id']);
    }
}
